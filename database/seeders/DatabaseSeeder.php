<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        User::query()->truncate();
        Category::query()->truncate();
        Post::query()->truncate();

        Schema::enableForeignKeyConstraints();

        $user = User::factory()->create(['name'=>'jchavda','username'=>'jchavda','email' => 'jayveersinhchavda555@gmail.com']);

        Category::factory(8)->sequence(
            ['name' => 'Laravel'],
            ['name' => 'PHP'],
            ['name' => 'Javascript'],
            ['name' => 'Vue.js'],
            ['name' => 'Jquery'],
            ['name' => 'C#'],
            ['name' => 'Java'],
            ['name' => 'Angular.js'],
        )->has(
            Post::factory()->count(rand(2,5)))
        ->create();

    }
}
