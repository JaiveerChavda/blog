<?php

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\User;

beforeEach(fn () => $this->user = User::factory()->create(['username' => 'johnDeo']));

beforeEach(
    fn () => $this->publishedPost = Post::factory()
        ->create([
            'status' => PostStatus::PUBLISHED->value,
            'published_at' => now()->subDay(),
        ])
);

describe('auth', function () {

    beforeEach(fn () => $this->actingAs($this->user));

    test('can see bookmark posts page', function () {

        //create fake posts to bookmark them for current authenticated user.

        $posts = Post::factory(2)->create([
            'status' => PostStatus::PUBLISHED->value,
            'published_at' => now()->subDay(),
        ]);

        // bookmark 3 posts for currently logged user.

        $this->user->update([
            'bookmarked_posts' => $bookmarked_post_ids = [$this->publishedPost->id, $posts[0]['id'], $posts[1]['id']],
        ]);

        // visit bookmark page and assert for these bookmarked posts.
        $response = $this->get(route('bookmark.index'));

        $response->assertStatus(200)
            ->assertViewIs('user.reading-list')
            ->assertViewHas('saved_posts', Post::query()->whereIn('id', $this->user->bookmarked_posts)->get())
            ->assertViewHas('recommended_posts', Post::query()
                ->whereNotIn('id', $bookmarked_post_ids)
                ->select(['title', 'slug', 'id'])
                ->published()
                ->limit(10)
                ->get()
            )
            ->assertSeeText($posts[0]['title'])
            ->assertSeeText($this->publishedPost->title);

        // expect($this)
    });

    test('can bookmark a post', function () {

        $anotherPost = Post::factory()->create(['status' => PostStatus::PUBLISHED->value, 'published_at' => now()->subDay()]);

        // bookmark first post
        $response = $this->post(route('bookmark.store'), [
            'postId' => $this->publishedPost->id,
        ]);

        // bookmark second post
        $this->post(route('bookmark.store'), [
            'postId' => $anotherPost->id,
        ]);

        $response->assertValid()
            ->assertSessionHas('success', 'post added to reading list');

        $user = User::query()->whereId($this->user->id)->first();

        expect($user->bookmarked_posts)->toBe([$this->publishedPost->id, $anotherPost->id]);

        $this->assertDatabaseCount('posts', 2);

    });

    test('can remove a post from bookmarked posts', function () {
        $post = Post::factory()->create([
            'status' => PostStatus::PUBLISHED->value,
            'published_at' => now()->subDay()]
        );

        $this->user->update(['bookmarked_posts' => [$this->publishedPost->id, $post->id]]);

        $response = $this->delete(route('bookmark.destroy', [
            'bookmark' => $post,
        ]));

        $response->assertValid()
            ->assertSessionHas('success', 'post removed from reading list.');

        expect($this->user->bookmarked_posts)->not->toBe([$this->publishedPost->id, $post->id]);
    });

});
