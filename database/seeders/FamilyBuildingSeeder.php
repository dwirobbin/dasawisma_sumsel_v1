<?php

namespace Database\Seeders;

use App\Models\FamilyBuilding;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FamilyBuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ini_set('memory_limit', '4096M'); //allocate memory

        DB::disableQueryLog(); //disable log

        Schema::disableForeignKeyConstraints();

        $stapleFoodLists = ['Beras', 'Non Beras'];
        $waterSourceLists = [
            'PDAM', 'Sumur', 'Sungai', 'Lainnya',  'PDAM,Sumur',
            'PDAM,Sungai', 'PDAM,Sumur,Sungai', 'Sumur,Sungai',
        ];
        $houseCriteriaLists = ['Sehat', 'Kurang Sehat'];

        $newDataDefaultFamilyBuildings = [];
        for ($i = 1; $i <= 1000000; $i++) {
            $newDataDefaultFamilyBuildings[] = [
                'family_id'             => $i,
                'staple_food'           => fake()->randomElement($stapleFoodLists),
                'have_toilet'           => fake()->boolean(80),
                'water_src'             => fake()->randomElement($waterSourceLists),
                'have_landfill'         => fake()->boolean(80),
                'have_sewerage'         => fake()->boolean(80),
                'pasting_p4k_sticker'   => fake()->boolean(80),
                'house_criteria'        => fake()->randomElement($houseCriteriaLists),
            ];
        }

        $this->command->getOutput()->progressStart(1000000);
        // paginate data 1000
        foreach (array_chunk($newDataDefaultFamilyBuildings, 1000) as $newDataDefaultFamilyBuilding) {
            FamilyBuilding::query()->insert($newDataDefaultFamilyBuilding);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();

        Schema::enableForeignKeyConstraints();

        DB::setEventDispatcher(new Dispatcher()); // Reset events to free up memory.
    }
}
