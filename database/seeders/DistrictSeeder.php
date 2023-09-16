<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::disableQueryLog(); //disable log

        Schema::disableForeignKeyConstraints();

        District::truncate();

        $csvData = fopen(base_path('database/seeders/csv/districts.csv'), 'r');
        $firstline = true;

        $districts = [];
        while (($data = fgetcsv($csvData, 60, ',')) !== false) {
            if (!$firstline) {
                $districts[] = [
                    'id' => $data['0'],
                    'regency_id' => $data['1'],
                    'name' => $data['2'],
                    'area' => $data['3'],
                ];
            }
            $firstline = false;
        }

        foreach (array_chunk($districts, 1000) as $district) {
            District::insert($district);
        }

        fclose($csvData);

        Schema::enableForeignKeyConstraints();

        DB::setEventDispatcher(new Dispatcher()); // Reset events to free up memory.
    }
}
