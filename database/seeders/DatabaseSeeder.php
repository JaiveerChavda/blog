<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::truncate();
        Post::truncate();
        Category::truncate();

        $user = User::factory()->create();

        $personal = Category::create([
            'name' => 'Personal',
            'slug' => 'personal'
        ]);

        $family = Category::create([
            'name' => 'Family',
            'slug' => 'family'
        ]);

        $work = Category::create([
            'name' => 'Work',
            'slug' => 'work'
        ]);

        Post::create([
            'category_id' => $work->id,
            'user_id' => $user->id,
            'slug' => 'my-work-post',
            'title' => 'My Work Post',
            'excerpt' => 'lorem is ipsum lorem is ipsum',
            'body' => 'lorem is ipsum lorem is ipsum lorem is ipsum lorem is ipsum lorem is ipsumv lorem is ipsumlorem is ipsum',
            'published_at' => now()
        ]);

        Post::create([
            'category_id' => $family->id,
            'user_id' => $user->id,
            'slug' => 'my-family-post',
            'title' => 'My Family Post',
            'excerpt' => 'lorem is ipsum lorem is ipsum',
            'body' => 'lorem is ipsum lorem is ipsum lorem is ipsum lorem is ipsum lorem is ipsumv lorem is ipsumlorem is ipsum',
            'published_at' => now()
        ]);

        Post::create([
            'category_id' => $personal->id,
            'user_id' => $user->id,
            'slug' => 'my-personal-post',
            'title' => 'My Personal Post',
            'excerpt' => 'lorem is ipsum lorem is ipsum',
            'body' => 'lorem is ipsum lorem is ipsum lorem is ipsum lorem is ipsum lorem is ipsumv lorem is ipsumlorem is ipsum',
            'published_at' => now()
        ]);

    }
}
