<?php

use App\Services\Newsletter;

test('can subscribe to newsletter', function () {
    // Mock the Newsletter service
    $newsletterMock = Mockery::mock(Newsletter::class);

    $newsletterMock->shouldReceive('subscribe')
        ->with('jchavda@truptman.in')
        ->andReturn(true);

    // Bind the mock to the service container
    app()->instance(Newsletter::class, $newsletterMock);

    $response = $this->post('/newsletter',[
        'email' => 'jchavda@truptman.in'
    ]);
    
    $response->assertValid()
        ->assertRedirect('/')   
        ->assertSessionHas('success','You have successfully subscribed to our newsletter list');
});
