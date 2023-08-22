<?php

namespace Database\Factories\Telegram;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Model>
 */
class TelegramChatFactory extends Factory
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
            'type_id' => 2,
            'title' => fake()->title(),
            'username' => fake()->company(),
            'about' => fake()->paragraph(5),
            'contact' => fake()->userName(),
            'created_at' => fake()->dateTime()->format('Y-m-d H:i:s'),
        ];
    }
}
