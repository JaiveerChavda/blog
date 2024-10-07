<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\UploadedFile;

pest()->group('admin_posts');

beforeEach(function () {
    $this->adminUser = User::factory()->create(['username' => 'admin']);
    $this->user = User::factory()->create(['username' => 'john', 'email' => 'john@example.com']);
});

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

});

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
});
