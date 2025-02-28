<?php

namespace Database\Seeders;

use App\Models\BreedingRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Pet;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create();
        Pet::factory(20)->create();
        BreedingRequest::factory(20)->create();
        Category::factory(20)->create();
        Post::factory(20)->create();
        Comment::factory(20)->create();
    }
}
