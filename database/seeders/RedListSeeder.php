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
            'en' => ['name' => 'Global'],
            'hr' => ['name' => 'Globalna'],
            'sr' => ['name' => 'Глобална'],
            'sr-Latn' => ['name' => 'Globalna'],
        ]);

        RedList::firstOrCreate(['slug' => 'europe'])->update([
            'bs' => ['name' => 'Evropa'],
            'en' => ['name' => 'Europe'],
            'hr' => ['name' => 'Europa'],
            'sr' => ['name' => 'Европа'],
            'sr-Latn' => ['name' => 'Evropa'],
        ]);

        RedList::firstOrCreate(['slug' => 'serbia'])->update([
            'bs' => ['name' => 'Srbija'],
            'en' => ['name' => 'Serbia'],
            'hr' => ['name' => 'Srbija'],
            'sr' => ['name' => 'Србија'],
            'sr-Latn' => ['name' => 'Srbija'],
        ]);

        RedList::firstOrCreate(['slug' => 'balkans'])->update([
            'bs' => ['name' => 'Balkan'],
            'en' => ['name' => 'Balkans'],
            'hr' => ['name' => 'Balkan'],
            'sr' => ['name' => 'Балкан'],
            'sr-Latn' => ['name' => 'Balkan'],
        ]);

        RedList::firstOrCreate(['slug' => 'croatia'])->update([
            'bs' => ['name' => 'Hrvatska'],
            'en' => ['name' => 'Croatia'],
            'hr' => ['name' => 'Hrvatska'],
            'sr' => ['name' => 'Хрватска'],
            'sr-Latn' => ['name' => 'Hrvatska'],
        ]);

        RedList::firstOrCreate(['slug' => 'eu'])->update([
            'bs' => ['name' => 'Evropska unija'],
            'en' => ['name' => 'European Union'],
            'hr' => ['name' => 'Europska unija'],
            'sr' => ['name' => 'Европска унија'],
            'sr-Latn' => ['name' => 'Evropska unija'],
        ]);

        RedList::firstOrCreate(['slug' => 'mediterranean'])->update([
            'bs' => ['name' => 'Mediteran'],
            'en' => ['name' => 'Mediterranean'],
            'hr' => ['name' => 'Mediteran'],
            'sr' => ['name' => 'Mediteran'],
            'sr-Latn' => ['name' => 'Медитеран'],
        ]);
    }
}
