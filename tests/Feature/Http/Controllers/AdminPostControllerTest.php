<?php

use App\Enums\PostStatus;
use App\Events\PostPublished;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;

pest()->group('admin_posts');

beforeEach(function () {
    $this->adminUser = User::factory()->create(['username' => 'admin']);
    $this->user = User::factory()->create(['username' => 'john', 'email' => 'john@example.com']);
});

// Define a dataset for the test
dataset('post_data', [
    fn () => [
        'title' => 'updated title 1',
        'slug' => 'updated_slug_1',
        'excerpt' => 'new excerpt',
        'body' => 'this is the updated body',
        'category_id' => Category::factory()->create(['name' => 'laravel'])->id,
        'status' => PostStatus::DRAFT->value,
        'published_at' => null,
        'thumbnail' => UploadedFile::fake()->image('updated_image.png'),
    ],
    fn () => [
        'title' => 'updated title 2',
        'slug' => 'updated_slug_2',
        'excerpt' => 'new excerpt for 2',
        'body' => 'this is the updated body for second post',
        'category_id' => Category::factory()->create(['name' => 'php'])->id,
        'status' => PostStatus::PUBLISHED->value,
        'published_at' => null,
        'thumbnail' => UploadedFile::fake()->image('updated_image.png'),
    ],
]);

// admin can see posts of all users.
test('can see posts', function () {

    //create fake post written by other and admin users

    Post::factory()->create([
        'status' => 'draft',
        'title' => 'Draft Post 1',
    ]);

    Post::factory()->create([
        'status' => 'published',
        'title' => 'Published Post 1',
    ]);

    Post::factory()->create([
        'user_id' => $this->adminUser->id,
        'title' => 'post written by admin',
    ]);

    $response = login($this->adminUser)
        ->get(route('admin.posts.index'));

    $response->assertOk()
        ->assertSee('All Posts')
        ->assertSee('Draft Post 1')
        ->assertSee('Published Post 1')
        ->assertSee('post written by admin')
        ->assertViewIs('admin.posts.index');
});

test('can see create post page', function () {

    $response = login($this->adminUser)
        ->get(route('admin.posts.create'));

    $response->assertOk()
        ->assertViewIs('admin.posts.create')
        ->assertSee('Publish New Post')
        ->assertViewHasAll([
            'categories',
        ]);

});

test('can publish post', function () {

    Event::fake();

    $category = Category::factory()->create(['name' => 'Laravel', 'slug' => 'laravel']);
    $image = UploadedFile::fake()->image('some-image.jpg');

    $response = login($this->user)
        ->post(route('admin.posts.store'), [
            'title' => 'Test Title',
            'slug' => 'test-title',
            'thumbnail' => $image,
            'excerpt' => 'This is excerpt text',
            'body' => 'This is some content text',
            'category_id' => $category->id,
        ], ['Content-Type' => 'multipart/form-data']);

    // test the post store route response.
    $response->assertValid()
        ->assertRedirect('/')
        ->assertSessionHas('success', 'post published successfuly');

    // as the admin.posts.store route is returning a redirect response to home page
    // let's test it with our newly published post content.
    $this->get('/')
        ->assertOk()
        ->assertViewIs('posts.index')
        ->assertViewHasAll(['posts'])
        ->assertSee('Test Title');

    // assert the an event was dispatched
    Event::assertDispatched(PostPublished::class);

})->group('publish_post');

test('cannot create post with invalid data', function () {
    $response = login($this->user)
        ->post(route('admin.posts.store'), []);

    $response->assertInValid(['title', 'slug', 'category_id', 'excerpt', 'body', 'thumbnail'])
        ->assertRedirect()
        ->assertSessionHasErrors([
            'title' => 'The title field is required.',
            'slug',
            'category_id',
            'excerpt',
            'body',
        ]);
});

test('can draft post', function () {

    Event::fake();

    $category = Category::factory()->create(['name' => 'php', 'slug' => 'php']);
    $image = UploadedFile::fake()->image('some-image.jpg');

    $response = login($this->user)
        ->post(route('admin.posts.store'), [
            'title' => 'draft Title',
            'slug' => 'draft-title',
            'thumbnail' => $image,
            'excerpt' => 'This is excerpt text',
            'body' => 'This is some content text',
            'category_id' => $category->id,
            'action' => 'save_as_draft',
        ]);

    $response->assertValid()
        ->assertRedirect(route('admin.posts.index'))
        ->assertSessionHas('success', 'post saved as draft');

    $this->get(route('admin.posts.index'))
        ->assertViewIs('admin.posts.index')
        ->assertSee('draft Title')
        ->assertSee('draft');

    Event::assertNotDispatched(PostPublished::class);

})->group('draft_post');

test('can see edit post page as admin', function () {
    $post = Post::factory()->create(['title' => 'post need editing']);

    $response = login($this->adminUser)
        ->get(route(
            'admin.posts.edit',
            ['post' => $post->slug]
        ));

    $response->assertStatus(200)
        ->assertViewIs('admin.posts.edit')
        ->assertViewHasAll([
            'post',
            'authors',
        ])
        ->assertSee('post need editing');

});

test('can see edit post page as author', function () {
    $post = Post::factory()->create(['title' => 'post need editing', 'user_id' => $this->user->id]);

    $response = login($this->user)
        ->get(route(
            'admin.posts.edit',
            ['post' => $post->slug]
        ));

    $response->assertStatus(200)
        ->assertViewIs('admin.posts.edit')
        ->assertViewHasAll([
            'post',
            'authors',
        ])
        ->assertSee('post need editing');

});

test('cannot see edit post page as other user', function () {
    $post = Post::factory()->create(['title' => 'post need editing']);

    $response = login($this->user)
        ->get(route(
            'admin.posts.edit',
            ['post' => $post->slug]
        ));

    $response->assertForbidden();
});

test('can update a post', function (array $data) {
    $post = Post::factory()->create(['title' => 'post need updation', 'user_id' => $this->user->id, 'published_at' => null]);
    $response = login($this->user)
        ->put(route('admin.posts.update', ['post' => $post->slug]), $data);

    $updatedPost = Post::query()->findOrFail($post->id);

    $response->assertValid()
        ->assertRedirect(route('admin.posts.edit', ['post' => $updatedPost->slug]))
        ->assertSessionHas('success', 'post updated');

    $this->assertModelExists($post)
        ->assertDatabaseHas('posts', [
            'title' => $data['title'],
            'slug' => $data['slug'],
            'status' => $data['status'],
        ]);
})->with('post_data');

test('can delete a post', function () {

    $post = Post::factory()->create();

    $response = login($this->adminUser)
        ->delete(route('admin.posts.destroy', ['post' => $post]));

    $response->assertRedirect(route('admin.posts.index'))
        ->assertSessionHas('success', 'post deleted!');

    $this->assertDatabaseMissing('posts', [
        'id' => $post->id,
        'title' => $post->title,
    ]);
});

test('cannot delete a post as un-authorized user', function () {

    $post = Post::factory()->create();

    $response = login($this->user)
        ->delete(route('admin.posts.destroy', ['post' => $post]));

    $response->assertForbidden();

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'title' => $post->title,
    ]);
});
