<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'chat_id' => 1,
            'msg_id' => fake()->randomDigit(),
//            'date' => fake()->dateTime()->format('Y-m-d H:i:s'),
            'views' => fake()->randomDigit(),
            'forwards' => fake()->randomDigit(),
            'title' => fake()->title(),
            'body' => fake()->paragraph(15),
            'announcement' => fake()->paragraph(3),
            'created_at' => fake()->dateTime()->format('Y-m-d H:i:s'),
        ];
    }
}
