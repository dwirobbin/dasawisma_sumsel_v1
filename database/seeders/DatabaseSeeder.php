<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Closure;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Events\Dispatcher;
use Database\Seeders\FamilySeeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\RegencySeeder;
use Database\Seeders\VillageSeeder;
use Database\Seeders\DistrictSeeder;
use Database\Seeders\ProvinceSeeder;
use Database\Seeders\DasawismaSeeder;
use Illuminate\Support\Facades\Schema;
use Database\Seeders\FamilyMemberSeeder;
use Database\Seeders\FamilyNumberSeeder;
use Database\Seeders\FamilyActivitySeeder;
use Database\Seeders\FamilyBuildingSeeder;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ini_set('memory_limit', '10240M'); //allocate memory

        // DB::disableQueryLog(); //disable log

        // Schema::disableForeignKeyConstraints();

        if (app()->environment() == 'production') {
            $this->call([
                RoleSeeder::class,
                ProvinceSeeder::class,
                RegencySeeder::class,
                DistrictSeeder::class,
                VillageSeeder::class,
                UserSeeder::class,
            ]);
        } else {
            $this->command->warn(PHP_EOL . 'Creating role...');
            $this->call(RoleSeeder::class);
            $this->command->info('Role created.');

            $this->command->warn(PHP_EOL . 'Creating Province...');
            $this->call(ProvinceSeeder::class);
            $this->command->info('Province created.');

            $this->command->warn(PHP_EOL . 'Creating Regency...');
            $this->call(RegencySeeder::class);
            $this->command->info('Regency created.');

            $this->command->warn(PHP_EOL . 'Creating District...');
            $this->call(DistrictSeeder::class);
            $this->command->info('District created.');

            $this->command->warn(PHP_EOL . 'Creating Village...');
            $this->call(VillageSeeder::class);
            $this->command->info('Village created.');

            $this->command->warn(PHP_EOL . 'Creating User...');
            $this->call(UserSeeder::class);
            $this->command->info('User created.');

            $this->command->warn(PHP_EOL . 'Creating Dasawisma...');
            $this->call(DasawismaSeeder::class);
            $this->command->info('Dasawisma created.');

            $this->command->warn(PHP_EOL . 'Creating Family...');
            $this->call(FamilySeeder::class);
            $this->command->info('Family created.');

            $this->command->warn(PHP_EOL . 'Creating Family Building...');
            $this->call(FamilyBuildingSeeder::class);
            $this->command->info('Family Building created.');

            $this->command->warn(PHP_EOL . 'Creating Family Number...');
            $this->call(FamilyNumberSeeder::class);
            $this->command->info('Family Number created.');

            // $this->command->warn(PHP_EOL . 'Creating Family Member...');
            // $this->call(FamilyMemberSeeder::class);
            // $this->command->info('Family Member created.');

            $this->command->warn(PHP_EOL . 'Creating Family Activity...');
            $this->call(FamilyActivitySeeder::class);
            $this->command->info('Family Activity created.');
        }

        // Schema::enableForeignKeyConstraints();

        // DB::setEventDispatcher(new Dispatcher()); // Reset events to free up memory.
    }
}
