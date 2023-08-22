<?php

namespace Tests\Feature;

use App\Models\Telegram\TelegramChat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TelegramChatTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
    }

    public function test_create_telegram_chat_successful()
    {
        $telegramChatCreateData = [
            'chat_id' => rand(1, 1000),
            'type_id' => 3,
            'title' => fake()->domainName(),
            'username' => fake()->company(),
            'about' => fake()->paragraph(5),
            'contact' => fake()->userName(),
        ];

        $response = $this->actingAs($this->user)->post('/stage/news/settings', $telegramChatCreateData);

        $response->assertStatus(302);
        $response->assertRedirect('/stage/news/settings/');

        $this->assertDatabaseHas('telegram_chats', $telegramChatCreateData);

        $lastChat = TelegramChat::latest()->first();
        $this->assertEquals($lastChat->chat_id, $telegramChatCreateData['chat_id']);
        $this->assertEquals($lastChat->title, $telegramChatCreateData['title']);
    }

    public function test_telegram_chat_edit_contain_correct_values()
    {
        $telegramChat = TelegramChat::factory()->create();

        $response = $this->actingAs($this->user)->get('/stage/news/settings/'. $telegramChat->id .'/edit');

        $response->assertStatus(200);
        $response->assertSee('value="'. $telegramChat->chat_id .'"', false);
        $response->assertSee('value="'. $telegramChat->title .'"', false);
        $response->assertViewHas('telegramChat', $telegramChat);
    }

    private function createUser(): User
    {
        return User::create([
            'name' => fake()->name(),
            'email' => fake()->email(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' // password
        ]);
    }
}
