<?php

namespace Database\Seeders;

use App\RedList;
use Illuminate\Database\Seeder;

class RedListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RedList::firstOrCreate(['slug' => 'global'])->update([
            'bs' => ['name' => 'Globalna'],
            'bs-Cyrl' => ['name' => 'Глобална'],
            'en' => ['name' => 'Global'],
            'hr' => ['name' => 'Globalna'],
            'sr' => ['name' => 'Глобална'],
            'sr-Latn' => ['name' => 'Globalna'],
        ]);

        RedList::firstOrCreate(['slug' => 'europe'])->update([
            'bs' => ['name' => 'Evropa'],
            'bs-Cyrl' => ['name' => 'Европа'],
            'en' => ['name' => 'Europe'],
            'hr' => ['name' => 'Europa'],
            'sr' => ['name' => 'Европа'],
            'sr-Latn' => ['name' => 'Evropa'],
        ]);

        RedList::firstOrCreate(['slug' => 'balkans'])->update([
            'bs' => ['name' => 'Balkan'],
            'bs-Cyrl' => ['name' => 'Балкан'],
            'en' => ['name' => 'Balkans'],
            'hr' => ['name' => 'Balkan'],
            'sr' => ['name' => 'Балкан'],
            'sr-Latn' => ['name' => 'Balkan'],
        ]);

        RedList::firstOrCreate(['slug' => 'croatia'])->update([
            'bs' => ['name' => 'Hrvatska'],
            'bs-Cyrl' => ['name' => 'Хрватска'],
            'en' => ['name' => 'Croatia'],
            'hr' => ['name' => 'Hrvatska'],
            'sr' => ['name' => 'Хрватска'],
            'sr-Latn' => ['name' => 'Hrvatska'],
        ]);

        RedList::firstOrCreate(['slug' => 'eu'])->update([
            'bs' => ['name' => 'Evropska unija'],
            'bs-Cyrl' => ['name' => 'Европска унија'],
            'en' => ['name' => 'European Union'],
            'hr' => ['name' => 'Europska unija'],
            'sr' => ['name' => 'Европска унија'],
            'sr-Latn' => ['name' => 'Evropska unija'],
        ]);
    }
}
