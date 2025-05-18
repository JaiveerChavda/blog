<?php

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;

test('can see a post', function () {

    $post = Post::factory()->create(['status' => 'published']);

    $response = $this->get(route('post.show', ['post' => $post]));

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

    $response = $this->get(route('post.show-feed', ['post' => $post]));

    $response->assertJson([
        'slug' => $post->slug,
    ]);

    expect($response['title'])->toBe($post->title);
    expect($response['status'])->toBe($post->status);

});

test('can search posts by title', function () {

    $postToSearch = Post::factory()->create([
        'title' => 'laravel is awesome',
        'status' => PostStatus::PUBLISHED->value,
        'published_at' => now()->subDay(),
    ]);

    $missingPost = Post::factory()->create([
        'status' => PostStatus::DRAFT->value,
        'published_at' => null,
    ]);

    $searchTerm = $postToSearch->title;

    $response = $this->get(route('home', [
        'search' => $searchTerm,
    ]));

    $response->assertOk()
        ->assertViewIs('posts.index')
        ->assertViewHasAll([
            'posts',
        ])
        // Check if the matching post is present in the view
        ->assertSeeText($searchTerm)
        // Check if non-matching posts are not present in the view
        ->assertDontSeeText($missingPost->title);
});

test('can filter posts by category', function () {
    $filteredCategory = Category::factory()->create(['slug' => 'php']);
    $post1 = Post::factory()->create([
        'title' => 'PHP is still alive',
        'category_id' => $filteredCategory->id,
        'status' => PostStatus::PUBLISHED->value,
        'published_at' => now()->subDay(),
    ]);

    $post2 = Post::factory()->create(['title' => 'example post', 'published_at' => null, 'status' => PostStatus::DRAFT->value]);

    $this->get(route('home', [
        'category' => $filteredCategory->slug,
    ]))->assertOk()
        ->assertViewIs('posts.index')
        ->assertViewHasAll([
                'posts',
        ])
        ->assertSeeText($post1->title)
        ->assertDontSeeText($post2->title);

});
