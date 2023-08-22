<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\Telegram\TelegramChat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class CheckAuthTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
    }

    /**
     * Проверка доступа в дашборд для неавторизованного пользователя
     * @return void
     */
    public function test_is_not_access_to_dashboard_if_user_not_logged_in()
    {
        $response = $this->get('/stage/news/list');

        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    /**
     * Проверка доступа в дашборд для авторизованного пользователя
     * @return void
     */
    public function test_is_access_to_dashboard_if_user_logged_in()
    {
        $response = $this->actingAs($this->user)->get('/stage/news/list');

        $response->assertSee('Настройки');
    }

    /**
     * Авторизация и переход к списку новостей
     */
    public function test_check_login_and_redirect_to_news_list()
    {
        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/stage/news/list');
    }


    public function test_check_login_and_redirect_to_edit_new()
    {
        TelegramChat::factory()->create();
        News::factory()->create();

        $this->post('/login', [
            'email' => 'mail@site.dev',
            'password' => 'password'
        ]);

        $response = $this->actingAs($this->user)->get('/stage/news/list/1/edit');
//        dd($response);
        $response->assertStatus(200);
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
