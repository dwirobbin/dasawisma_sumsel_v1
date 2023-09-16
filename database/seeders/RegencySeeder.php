<?php

namespace Database\Seeders;

use App\Models\Regency;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RegencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::disableQueryLog(); //disable log

        Schema::disableForeignKeyConstraints();

        Regency::truncate();

        $csvData = fopen(base_path('database/seeders/csv/regencies.csv'), 'r');
        $firstline = true;

        $regencies = [];
        while (($data = fgetcsv($csvData, 50, ',')) !== false) {
            if (!$firstline) {
                $regencies[] = [
                    'id' => $data['0'],
                    'province_id' => $data['1'],
                    'name' => $data['2'],
                    'area' => $data['3'],
                ];
            }
            $firstline = false;
        }

        foreach (array_chunk($regencies, 1000) as $regency) {
            Regency::insert($regency);
        }

        fclose($csvData);

        Schema::enableForeignKeyConstraints();

        DB::setEventDispatcher(new Dispatcher()); // Reset events to free up memory.
    }
}
