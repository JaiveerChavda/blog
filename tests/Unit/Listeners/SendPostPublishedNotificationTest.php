<?php

use App\Events\PostPublished;
use App\Listeners\SendPostPublishNotification;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostPublished as NotificationsPostPublished;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Notification;

uses(TestCase::class);

test('can send notification', function () {
    Notification::fake();

    $follower = User::factory()->create(['username' => 'janeDeo']);

    $author = User::factory()->create();

    // attach a follower to author.
    $author->followers()->attach($follower->id);

    $post = Post::factory()->create(['user_id' => $author->id]);

    $event = new PostPublished($post);

    $listener = new SendPostPublishNotification();

    $listener->handle($event);

    Notification::assertSentTo([$follower], NotificationsPostPublished::class);

})->group('publish_post');
