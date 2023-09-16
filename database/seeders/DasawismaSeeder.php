<?php

namespace Database\Seeders;

use App\Models\Dasawisma;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DasawismaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::disableQueryLog(); //disable log

        Schema::disableForeignKeyConstraints();

        for ($i = 0; $i < 3; $i++) {
            Dasawisma::create([
                'name'          => 'Mawar',
                'slug'          => 'mawar',
                'province_id'   => 16, // Provinsi
                'regency_id'    => 1601, // OKU
                'district_id'   => 1601092, // Sinar Peninjauan
                'village_id'    => 1601092005, // Marga Mulya
                'rt'            => fake()->randomDigitNotNull(),
                'rw'            => fake()->randomDigitNotNull(),
            ]);
        }

        Dasawisma::factory(37)->create();

        Schema::enableForeignKeyConstraints();

        DB::setEventDispatcher(new Dispatcher()); // Reset events to free up memory.
    }
}
