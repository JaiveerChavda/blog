<?php

pest()->group('profile');

use App\Models\User;
use Illuminate\Http\UploadedFile;

test('user can see profile screen', function () {
    $user = User::factory()->create(['name' =>  'john']);

    login($user);

    $response = $this->get('/profile');

    $response->assertOk()
        ->assertViewIs('user.profile.index')
        ->assertSeeText($user->name);

    expect($response['user'])->tobe($user);
});

test('user can see edit profile page', function () {
    $user = User::factory()->create(['name' => 'john']);

    $response = login($user)
                    ->get(route('profile.edit',[$user->id]));

    $response->assertOk()
        ->assertViewIs('user.profile.edit')
        ->assertSeeText('Your Profile')
        ->assertSeeText('Update Password');
});

test('user can update profile', function () {
    $user = User::factory()->create([
        'name' => 'jaiveer1',
        'username' => 'JaiveerChavda'
    ]);

    $response = login($user)
            ->put(route('profile.update',[$user->id]),[
                'name' => 'jaiveer',
                'username' => 'JaiveerChavda',
                'avatar' => UploadedFile::fake()->image('user-avtar.png'),
            ]);      

    $response->assertValid()
            ->assertRedirect(route('profile.index'))
            ->assertSessionHas('success','profile updated successfully');
    
    $user->refresh();

    expect($user->name)->not->tobe('jaiveer1');     
});

test('user cannot update profile with already exists username', function () {
    $existedUser =  User::factory()->create([
        'username' => 'jaiveer'
    ]);

    $user = User::factory()->create([
        'name' => 'john',
    ]);

    $response = login($user)
            ->put(route('profile.update',[$user->id]),[
                'name' => 'john1',
                'username' => 'jaiveer',
                'avatar' => UploadedFile::fake()->image('user-avtar.png'),
            ]);

    $response->assertInValid()
    ->assertSessionHasErrors([
        'username' => 'The username has already been taken.',
    ]);

    $user->refresh();

    expect($user->name)->tobe('john');
});