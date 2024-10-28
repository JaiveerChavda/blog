<?php

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\User;

beforeEach(
    fn () => $this->publishedPost = Post::factory()
        ->create([
            'status' => PostStatus::PUBLISHED->value,
            'published_at' => now()->subDay(),
        ])
);

beforeEach(fn () => $this->user = User::factory()->create(['username' => 'johnDeo']));


describe("auth", function() {

    beforeEach(fn () => $this->actingAs($this->user));

    it('can comment on post', function () {
        
        $post = $this->publishedPost->fresh();

        $comment = 'excellent post.';

        $response = $this->post(route('post.comment',['post' => $post->slug]),[
            'body' => $comment,
        ]);

        $response->assertValid()
            ->assertSessionHas('success',__('posts.comment.messages.Comment posted successfully'));

            $this->assertDatabaseHas('posts', [
                'id' => $post->id,
                'title' => $post->title,
            ]);

        $this->assertDatabaseHas('comments', [
            'body' => $comment,
            'user_id' => $this->user->id,
            'post_id' => $post->id,
        ]);
        
    });

});
