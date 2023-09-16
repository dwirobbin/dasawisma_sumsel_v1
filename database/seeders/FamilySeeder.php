<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Family;
use App\Models\Dasawisma;
use App\Models\FamilyMember;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ini_set('memory_limit', '2048M'); //allocate memory

        DB::disableQueryLog(); //disable log

        Schema::disableForeignKeyConstraints();

        $dasawismaIds = Dasawisma::query()->pluck('id');
        $userIds = User::query()->where('role_id', 2)->pluck('id');

        $newDataDefaultFamilies = [];
        for ($i = 1; $i <= 1000000; $i++) {
            $name = fake('ID_id')->unique()->name('male');
            $newDataDefaultFamilies[] = [
                'dasawisma_id'  => $dasawismaIds->random(),
                'kk_number'     => fake()->unique()->isbn13(),
                'kk_head'       => str($name)->title(),
                'user_id'       => $userIds->random(),
            ];
        }

        $this->command->getOutput()->progressStart(1000000);
        // paginate data 1000
        foreach (array_chunk($newDataDefaultFamilies, 1000) as $newDataDefaultFamily) {
            Family::query()->insert($newDataDefaultFamily);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();

        Schema::enableForeignKeyConstraints();

        DB::setEventDispatcher(new Dispatcher()); // Reset events to free up memory.
    }
}
