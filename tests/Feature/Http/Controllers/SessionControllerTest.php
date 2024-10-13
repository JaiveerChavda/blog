<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_screen_is_visible(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();

        $response = $this->post('/login',[
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertValid();

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_user_can_not_authenticate_with_invalid_credentials()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertInvalid();
        $this->assertGuest();
    }

    public function test_guest_can_not_see_admin_dashboard()
    {
        $user = User::factory()->create();

        $response = $this->get('/admin/posts');

        $response->assertRedirect('/login');
    }

    public function test_user_can_not_see_login_page()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/login');

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->post('/logout')
            ->assertRedirect('/')
            ->assertSessionHas('success','Goodbye!');
    }
}
