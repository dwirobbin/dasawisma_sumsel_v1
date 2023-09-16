<?php

namespace Database\Seeders;

use App\Models\FamilyNumber;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FamilyNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ini_set('memory_limit', '4096M'); //allocate memory

        DB::disableQueryLog(); //disable log

        Schema::disableForeignKeyConstraints();

        $newDataDefaultFamilyNumbers = [];
        for ($i = 1; $i <= 1000000; $i++) {
            $newDataDefaultFamilyNumbers[] = [
                'family_id'                     => $i,
                'toddlers_number'               => fake()->optional(0.8, 0)->randomDigitNotNull(),
                'pus_number'                    => fake()->optional(0.8, 0)->randomDigitNotNull(),
                'wus_number'                    => fake()->optional(0.8, 0)->randomDigitNotNull(),
                'blind_people_number'           => fake()->optional(0.8, 0)->randomDigitNotNull(),
                'pregnant_women_number'         => fake()->optional(0.8, 0)->randomDigitNotNull(),
                'breastfeeding_mother_number'   => fake()->optional(0.8, 0)->randomDigitNotNull(),
                'elderly_number'                => fake()->optional(0.8, 0)->randomDigitNotNull(),
            ];
        }

        $this->command->getOutput()->progressStart(1000000);
        // paginate data 1000
        foreach (array_chunk($newDataDefaultFamilyNumbers, 1000) as $newDataDefaultFamilyNumber) {
            FamilyNumber::query()->insert($newDataDefaultFamilyNumber);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();

        Schema::enableForeignKeyConstraints();

        DB::setEventDispatcher(new Dispatcher()); // Reset events to free up memory.
    }
}
