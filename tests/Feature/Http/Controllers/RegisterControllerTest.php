<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Testing\RefreshDatabase;


test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response
        ->assertOk()
        ->assertViewIs('register.create');
});

test('guest can regiter using register screen', function (array $data) {

    $response = $this->post('/register',$data);

    $response->assertValid();

    $this->assertAuthenticated();

    $response->assertRedirect(RouteServiceProvider::HOME);
})->with([
    [['name' => 'jaiveer','username' => 'JaiveerChavda','email' => 'jchavda@truptman.in','password' => 'password']],
    [['name' => 'john','username' => 'JaiveerChavda','email' => 'john@example.com','password' => 'password']],
]);

test('returns validation error for unique username', function (array $data) {

    $ExistingUser = User::factory()->create(['username' => 'JohnDeo']);
    
    $response = $this->post('/register',$data);

    $response->assertInvalid();

    $response->assertSessionHasErrors([
        'username' => 'The username has already been taken.',
    ]);
    
})->with([
    [['name' => 'john','username' => 'JohnDeo','email' => 'john@example.com','password' => 'password']],
]);

test('user can not see registration screen', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get('/register');

    $this->assertAuthenticated();

    $response->assertRedirect(RouteServiceProvider::HOME);

});
