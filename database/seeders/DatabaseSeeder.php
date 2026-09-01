<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create 5 Categories and 10 Tags
        $categories = Category::factory()->count(5)->create();
        $tags = Tag::factory()->count(10)->create();

        // 2. Create 25 Posts distributed among existing categories
        $posts = Post::factory()->count(25)->make()->each(function ($post) use ($categories) {
            $post->category_id = $categories->random()->id;
            $post->save();
        });

        // 3. Attach 1 to 3 random tags to each post
        $posts->each(function ($post) use ($tags) {
            $post->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')
            );
        });
    }
}