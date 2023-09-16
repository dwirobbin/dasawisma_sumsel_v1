<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => fake('ID_id')->name(),
            'email'             => fake('ID_id')->unique()->safeEmail(),
            'username'          => fake('ID_id')->unique()->userName(),
            'email_verified_at' => now(),
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
            'profile_picture'   => null,
            'phone_number'      => fake('ID_id')->unique()->e164PhoneNumber(),
            'role_id'           => Role::pluck('id')->random(),
            'province_id'       => null,
            'regency_id'        => null,
            'district_id'       => null,
            'village_id'        => null,
            'is_active'         => fake()->randomElement([true, false]),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
