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

    public int $tries = 5; // Number of retry attempts
    public array $backoff = [1, 5, 10, 20]; // Retry delays in seconds

    protected $url;
    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($url, $data)
    {
        $this->url = $url;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            $response = Http::retry(5, 200, function ($exception) {
                return $exception->getCode() === 429;
            })->post($this->url . '/api/taxonomy/sync', $this->data);

            if ($response->failed()) {
                Log::error("Failed to sync taxon: {$this->url}", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                $this->fail();
            } else {
                Log::info("Taxon sync successful for: {$this->url}");
            }
        } catch (\Exception $e) {
            Log::error("Error in taxon sync: " . $e->getMessage());
            throw $e;
        }
    }
}
