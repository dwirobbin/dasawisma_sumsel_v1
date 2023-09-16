<?php

namespace Database\Seeders;

use Closure;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::disableQueryLog(); //disable log

        Schema::disableForeignKeyConstraints();

        $roles = [
            ['name' => 'Super Admin'], ['name' => 'Admin'], ['name' => 'Guest'],
        ];

        Role::insert($roles);

        Schema::enableForeignKeyConstraints();

        DB::setEventDispatcher(new Dispatcher()); // Reset events to free up memory.
    }
}
