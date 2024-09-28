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