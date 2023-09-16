<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\FamilyMember;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FamilyMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '6144M'); //allocate memory

        DB::disableQueryLog(); //disable log

        Schema::disableForeignKeyConstraints();

        $lastEducations = ['TK/PAUD', 'SD/MI', 'SLTP/SMP/MTS', 'SLTA/SMA/MA/SMK', 'Diploma', 'S1', 'S2', 'S3'];

        $newDataDefaultFamilyMembers = [];

        $families = Family::get(['id', 'kk_head']);
        foreach ($families as $family) {
            $newDataDefaultFamilyMembers[] = [
                'family_id'         => $family->id,
                'nik_number'        => fake('ID_id')->unique()->isbn13(),
                'name'              => str($family->kk_head)->title(),
                'slug'              => str($family->kk_head)->slug(),
                'birth_date'        => fake()->date(),
                'status'            => 'Kepala Keluarga',
                'gender'            => 'Laki-laki',
                'marital_status'    => 'Duda',
                'last_education'    => fake()->randomElement($lastEducations),
                'profession'        => fake('ID_id')->optional(0.8, 'Belum/Tidak Bekerja')->jobTitle(),
            ];
        }

        $this->command->getOutput()->progressStart(1000000);
        // paginate data 1000
        foreach (array_chunk($newDataDefaultFamilyMembers, 1000) as $newDataDefaultFamilyMember) {
            FamilyMember::insert($newDataDefaultFamilyMember);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();

        Schema::enableForeignKeyConstraints();

        DB::setEventDispatcher(new Dispatcher()); // Reset events to free up memory.
    }
}
