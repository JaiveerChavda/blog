<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Testing\RefreshDatabase;


uses(RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response
        ->assertOk()
        ->assertViewIs('register.create');
});

test('guest can regiter using register form', function (array $data) {

    $response = $this->post('/register',$data);

    $response->assertValid();

    $this->assertAuthenticated();

    $response->assertRedirect(RouteServiceProvider::HOME);
})->with([
    [['name' => 'jaiveer','username' => 'JaiveerChavda','email' => 'jchavda@truptman.in','password' => 'password']],
    [['name' => 'john','username' => 'JaiveerChavda','email' => 'john@example.com','password' => 'password']],
]);

test('user can not see registration screen', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get('/register');

    $this->assertAuthenticated();

    $response->assertRedirect(RouteServiceProvider::HOME);

});
