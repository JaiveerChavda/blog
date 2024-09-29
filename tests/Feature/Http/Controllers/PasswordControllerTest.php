<?php

test('user can update password from profile screen',function (){
    $response = login()
                ->put(route('password.update'),[
                    'current_password' => 'password',
                    'password' => 'excellentMe',
                    'password_confirmation' => 'excellentMe'
                ]);

    $response->assertValid()
        ->assertSessionHas('success','password updated');
});

test('return validation error of password confirmation',function (){
    $response = login()
                ->put(route('password.update'),[
                    'current_password' => 'password',
                    'password' => 'excellentMe',
                    'password_confirmation' => 'excellentMee'
                ]);

    $response->assertInValid()
        ->assertSessionHasErrorsIn('updatePassword',[
            'password' => 'The password field confirmation does not match.'
        ]);
});

test('user cannot update password with invalid current password',function () {
    $response = login()
                    ->put(route('password.update'),[
                        'current_password' => 'passwordd', //wrong password
                        'password' => 'passwords',
                        'password_confirmation' => 'passwords'
                    ]);
                    
    $response->assertInValid()
        ->assertSessionHasErrorsIn('updatePassword',[
            'current_password' => 'The password is incorrect.'
        ]);
});