<?php
use App\Models\User;
//use Illuminate\Foundation\Testing\RefreshDatabase;

beforeEach(function() {
    $this->user = createUser();
});

test('check the user is auth', function () {
    $this->actingAs($this->user)
        ->get('/stage/news/list')
        ->assertSee('Настройки');
});


test('check redirect for not auth user')
    ->get('/stage/news/list')
    ->assertStatus(302);
