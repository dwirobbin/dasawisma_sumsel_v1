<?php

namespace Database\Seeders;

use App\Models\FamilyActivity;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FamilyActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ini_set('memory_limit', '4096M'); //allocate memory

        DB::disableQueryLog(); //disable log

        Schema::disableForeignKeyConstraints();

        $up2kActivities = [
            'Usaha Warung', 'Usaha Toko', 'Usaha Kuliner', 'Usaha Online (E-commerce)',
            'Jasa kebersihan', 'Jual Tanaman Hias', 'Katering', 'Menjual Kerajinan Tangan',
            'Menjual Kue,Roti dan Minuman', 'Jasa Konsultasi atau Penasihat', 'Jasa Instruktur Kebugaran',
            'Jasa Desain Grafis atau Web', 'Jasa Sewa Penginapan', 'Jasa Pemeliharaan Kendaraan',
        ];

        $envHealthActivities = [
            'Kerja bakti atau gotong royong', 'Membuat tempat sampah',
            'Membuang sampah pada tempatnya', 'Menyelenggarakan kegiatan penanaman pohon dan tumbuhan',
            'Membuat pupuk dari sampah organik', 'Tidak sembarang membakar sampah',
        ];

        $newDataDefaultFamilyActivities = [];
        for ($i = 1; $i <= 1000000; $i++) {
            $newDataDefaultFamilyActivities[] = [
                'family_id'             => $i,
                'up2k_activity'         => fake()->randomElement($up2kActivities),
                'env_health_activity'   => fake()->randomElement($envHealthActivities),
            ];
        }

        $this->command->getOutput()->progressStart(1000000);
        // paginate data 1000
        foreach (array_chunk($newDataDefaultFamilyActivities, 1000) as $newDataDefaultFamilyActivity) {
            FamilyActivity::query()->insert($newDataDefaultFamilyActivity);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();

        Schema::enableForeignKeyConstraints();

        DB::setEventDispatcher(new Dispatcher()); // Reset events to free up memory.
    }
}
