<?php

use App\Models\Post;

test('can see a post', function () {

    $post = Post::factory()->create(['status' => 'published']);
    
    $response = $this->get(route('post.show',['post' => $post]));

    $response->assertStatus(200)
        ->assertViewIs('posts.show')
        ->assertViewHas('post')
        ->assertSee($post->title);
});


test('can see all posts', function () {
    Post::factory(5)->create(['status' => 'published']);

    $response = $this->get(route('home'));

    $response->assertStatus(200)
        ->assertViewIs('posts.index')
        ->assertViewHasAll(['posts'])
        ->assertSee(Post::query()->first()->title);
});

test('can see post feed', function () {
    $post = Post::factory()->create(['status' => 'published']);
    
    $response = $this->get(route('post.show-feed',['post' => $post]));

    $response->assertJson([
        'slug' => $post->slug
    ]);
    
    expect($response['title'])->toBe($post->title);
    expect($response['status'])->toBe($post->status);

});