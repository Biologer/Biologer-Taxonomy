<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendTaxonSyncRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;
    public array $backoff = [3, 5, 10, 20, 30];

    protected $url;
    protected $path;
    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($url, $path, $data)
    {
        $this->url = $url;
        $this->path = $path;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            $response = Http::retry($this->tries, 2000, function ($exception) {
                return $exception->getCode() === 429;
            })->post($this->url . $this->path, $this->data);

            if ($response->failed()) {
                $attempt = $this->attempts();
                $delay = $this->backoff[$attempt - 1] ?? end($this->backoff);
                Log::error("Failed to sync taxon: {$this->url}{$this->path}", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                $this->release($delay);
            } else {
                Log::info("Taxon sync successful for: {$this->url}{$this->path}");
            }
        } catch (\Exception $e) {
            Log::error("Error in taxon sync: " . $e->getMessage(), [
                'url' => $this->url . $this->path,
                'data' => $this->data,
            ]);
            $this->fail($e);
        }
    }
}
