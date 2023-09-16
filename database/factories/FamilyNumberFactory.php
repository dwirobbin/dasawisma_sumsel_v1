<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FamilyNumber>
 */
class FamilyNumberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'toddlers_number'               => fake()->optional(0.8, 0)->randomDigitNotNull(),
            'pus_number'                    => fake()->optional(0.8, 0)->randomDigitNotNull(),
            'wus_number'                    => fake()->optional(0.8, 0)->randomDigitNotNull(),
            'blind_people_number'           => fake()->optional(0.8, 0)->randomDigitNotNull(),
            'pregnant_women_number'         => fake()->optional(0.8, 0)->randomDigitNotNull(),
            'breastfeeding_mother_number'   => fake()->optional(0.8, 0)->randomDigitNotNull(),
            'elderly_number'                => fake()->optional(0.8, 0)->randomDigitNotNull(),
        ];
    }
}
