<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::disableQueryLog(); //disable log

        Schema::disableForeignKeyConstraints();

        $defaultUsers = [
            // Super Admin
            [
                'name'              => 'Super Admin',
                'username'          => 'superadmin',
                'email'             => 'superadmin@gmail.com',
                'email_verified_at' => now(),
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token'    => Str::random(10),
                'profile_picture'   => null,
                'phone_number'      => fake('ID_id')->unique()->e164PhoneNumber(),
                'role_id'           => 1,
                'province_id'       => null,
                'regency_id'        => null,
                'district_id'       => null,
                'village_id'        => null,
                'is_active'         => true,
                'created_at'        => now()->toDateTimeString(),
                'updated_at'        => now()->toDateTimeString(),
            ],

            // Admin Provinsi SumSel
            [
                'name'              => 'Admin Prov. Sumsel',
                'username'          => 'adminprov.sumsel',
                'email'             => 'adminprov.sumsel@gmail.com',
                'email_verified_at' => now(),
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token'    => Str::random(10),
                'profile_picture'   => null,
                'phone_number'      => fake('ID_id')->unique()->e164PhoneNumber(),
                'role_id'           => 2,
                'province_id'       => 16,
                'regency_id'        => null,
                'district_id'       => null,
                'village_id'        => null,
                'is_active'         => true,
                'created_at'        => now()->toDateTimeString(),
                'updated_at'        => now()->toDateTimeString(),
            ],

            // Admin Kota Sumsel -> Palembang
            [
                'name'              => 'Admin Kota Palembang',
                'username'          => 'adminkotapalembang',
                'email'             => 'adminkotapalembang@gmail.com',
                'email_verified_at' => now(),
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token'    => Str::random(10),
                'profile_picture'   => null,
                'phone_number'      => fake('ID_id')->unique()->e164PhoneNumber(),
                'role_id'           => 2,
                'province_id'       => 16,
                'regency_id'        => 1671,
                'district_id'       => null,
                'village_id'        => null,
                'is_active'         => true,
                'created_at'        => now()->toDateTimeString(),
                'updated_at'        => now()->toDateTimeString(),
            ],

            // Admin Kecamatan Palembang -> Jakabaring
            [
                'name'              => 'Admin Kec. Jakabaring',
                'username'          => 'adminkec.jakabaring',
                'email'             => 'adminkec.jakabaring@gmail.com',
                'email_verified_at' => now(),
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token'    => Str::random(10),
                'profile_picture'   => null,
                'phone_number'      => fake('ID_id')->unique()->e164PhoneNumber(),
                'role_id'           => 2,
                'province_id'       => 16,
                'regency_id'        => 1671,
                'district_id'       => 1671022,
                'village_id'        => null,
                'is_active'         => true,
                'created_at'        => now()->toDateTimeString(),
                'updated_at'        => now()->toDateTimeString(),
            ],

            // Admin Kelurahan Palembang -> Jakabaring -> Silaberanti
            [
                'name'              => 'Admin Kel. Silaberanti',
                'username'          => 'adminkel.silaberanti',
                'email'             => 'adminkel.silaberanti@gmail.com',
                'email_verified_at' => now(),
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token'    => Str::random(10),
                'profile_picture'   => null,
                'phone_number'      => fake('ID_id')->unique()->e164PhoneNumber(),
                'role_id'           => 2,
                'province_id'       => 16,
                'regency_id'        => 1671,
                'district_id'       => 1671022,
                'village_id'        => 1671022004,
                'is_active'         => true,
                'created_at'        => now()->toDateTimeString(),
                'updated_at'        => now()->toDateTimeString(),
            ],

            // Admin Kabupaten Ogan Komering Ulu
            [
                'name'              => 'Admin Kab. OKU',
                'username'          => 'adminkab.oku',
                'email'             => 'adminkab.oku@gmail.com',
                'email_verified_at' => now(),
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token'    => Str::random(10),
                'profile_picture'   => null,
                'phone_number'      => fake('ID_id')->unique()->e164PhoneNumber(),
                'role_id'           => 2,
                'province_id'       => 16,
                'regency_id'        => 1601,
                'district_id'       => null,
                'village_id'        => null,
                'is_active'         => true,
                'created_at'        => now()->toDateTimeString(),
                'updated_at'        => now()->toDateTimeString(),
            ],

            // Admin Kecamatan OKU -> Sinar Peninjauan
            [
                'name'              => 'Admin Kec. Sinar Peninjauan',
                'username'          => 'adminkec.sinarpeninjauan',
                'email'             => 'adminkec.sinarpeninjauan@gmail.com',
                'email_verified_at' => now(),
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token'    => Str::random(10),
                'profile_picture'   => null,
                'phone_number'      => fake('ID_id')->unique()->e164PhoneNumber(),
                'role_id'           => 2,
                'province_id'       => 16,
                'regency_id'        => 1601,
                'district_id'       => 1601092,
                'village_id'        => null,
                'is_active'         => true,
                'created_at'        => now()->toDateTimeString(),
                'updated_at'        => now()->toDateTimeString(),
            ],

            // Admin Kelurahan OKU -> Sinar Peninjauan -> Marga Mulya
            [
                'name'              => 'Admin Kel. Marga Mulya',
                'username'          => 'adminkel.margamulya',
                'email'             => 'adminkel.margamulya@gmail.com',
                'email_verified_at' => now(),
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token'    => Str::random(10),
                'profile_picture'   => null,
                'phone_number'      => fake('ID_id')->unique()->e164PhoneNumber(),
                'role_id'           => 2,
                'province_id'       => 16,
                'regency_id'        => 1601,
                'district_id'       => 1601092,
                'village_id'        => 1601092005,
                'is_active'         => true,
                'created_at'        => now()->toDateTimeString(),
                'updated_at'        => now()->toDateTimeString(),
            ],

            // Akun Tamu
            [
                'name'              => 'Guest 1',
                'username'          => 'guest1',
                'email'             => 'guest1@gmail.com',
                'email_verified_at' => now(),
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token'    => Str::random(10),
                'profile_picture'   => null,
                'phone_number'      => fake('ID_id')->unique()->e164PhoneNumber(),
                'role_id'           => 3,
                'province_id'       => null,
                'regency_id'        => null,
                'district_id'       => null,
                'village_id'        => null,
                'is_active'         => true,
                'created_at'        => now()->toDateTimeString(),
                'updated_at'        => now()->toDateTimeString(),
            ],

            // Akun Tamu
            [
                'name'              => 'Guest 2',
                'username'          => 'guest2',
                'email'             => 'guest2@gmail.com',
                'email_verified_at' => now(),
                'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password,
                'remember_token'    => Str::random(10),
                'profile_picture'   => null,
                'phone_number'      => fake('ID_id')->unique()->e164PhoneNumber(),
                'role_id'           => 3,
                'province_id'       => null,
                'regency_id'        => null,
                'district_id'       => null,
                'village_id'        => null,
                'is_active'         => false,
                'created_at'        => now()->toDateTimeString(),
                'updated_at'        => now()->toDateTimeString(),
            ],
        ];

        $newDefaultUsers = [];
        for ($i = 0; $i < count($defaultUsers); $i++) {
            $newDefaultUsers[] = $defaultUsers[$i];
        }

        foreach (array_chunk($newDefaultUsers, 1000) as $newDefaultUser) {
            User::insert($newDefaultUser);
        }

        Schema::enableForeignKeyConstraints();

        DB::setEventDispatcher(new Dispatcher()); // Reset events to free up memory.
    }
}
