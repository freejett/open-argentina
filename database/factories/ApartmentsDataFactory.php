<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ApartmentsDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'chat_id' => -1001632649859,
            'msg_id' => fake()->randomDigit(),
            'title' => fake()->title(),
            'address' => fake()->address(),
            'full_address' => fake()->streetAddress(),
            'full_price' => fake()->paragraph(2),
        ];
    }
}
