<?php

use App\Models\User;

test('user can see profile screen', function () {
    $user = User::factory()->create(['name' =>  'john']);

    $this->actingAs($user);

    $response = $this->get('/profile');

    $response->assertOk()
        ->assertViewIs('user.profile.index')
        ->assertSeeText($user->name);

    expect($response['user'])->tobe($user);
});
