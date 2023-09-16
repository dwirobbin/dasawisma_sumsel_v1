<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::disableQueryLog(); //disable log

        Schema::disableForeignKeyConstraints();

        Province::truncate();

        $csvData = fopen(base_path('database/seeders/csv/provinces.csv'), 'r');
        $firstline = true;

        while (($data = fgetcsv($csvData, 40, ',')) !== false) {
            if (!$firstline) {
                Province::create([
                    'id' => $data['0'],
                    'name' => $data['1'],
                    'capital_city' => $data['2'],
                    'area' => $data['3'],
                ]);
            }
            $firstline = false;
        }

        fclose($csvData);

        Schema::enableForeignKeyConstraints();

        DB::setEventDispatcher(new Dispatcher()); // Reset events to free up memory.
    }
}
