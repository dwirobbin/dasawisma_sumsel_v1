<?php

namespace Database\Seeders;

use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::disableQueryLog(); //disable log

        Schema::disableForeignKeyConstraints();

        Village::truncate();

        $csvData = fopen(base_path('database/seeders/csv/villages.csv'), 'r');
        $firstline = true;

        $villages = [];
        while (($data = fgetcsv($csvData, 70, ',')) !== false) {
            if (!$firstline) {
                $villages[] = [
                    'id' => $data['0'],
                    'district_id' => $data['1'],
                    'name' => $data['2'],
                    'area' => $data['3'],
                ];
            }
            $firstline = false;
        }

        foreach (array_chunk($villages, 1000) as $village) {
            Village::insert($village);
        }

        fclose($csvData);

        Schema::enableForeignKeyConstraints();

        DB::setEventDispatcher(new Dispatcher()); // Reset events to free up memory.
    }
}
