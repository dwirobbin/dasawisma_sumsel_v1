<?php

namespace Database\Factories;

use App\Models\Dasawisma;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Family>
 */
class FamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dasawisma_id'  => Dasawisma::pluck('id')->random(),
            'kk_number'     => fake()->unique()->isbn13(),
            'kk_head'       => fake('ID_id')->unique()->name(),
            'user_id'       => User::where('role_id', 2)->pluck('id')->random(),
        ];
    }
}
