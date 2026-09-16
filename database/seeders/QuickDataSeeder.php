<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class QuickDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create or Get Default User
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Create or Get Categories
        $tech = Category::firstOrCreate(
            ['slug' => 'technology'],
            ['name' => 'Technology']
        );

        $design = Category::firstOrCreate(
            ['slug' => 'design'],
            ['name' => 'Design']
        );

        // 3. Create or Get Tags
        $laravelTag = Tag::firstOrCreate(
            ['slug' => 'laravel'],
            ['name' => 'Laravel']
        );

        $tailwindTag = Tag::firstOrCreate(
            ['slug' => 'tailwind'],
            ['name' => 'Tailwind']
        );

        // 4. Create or Get Sample Posts
        $post1 = Post::firstOrCreate(
            ['title' => 'Getting Started with Laravel 12'],
            [
                'description' => 'This is a sample post describing how to set up robust relationships and authentication in Laravel 12.',
                'category_id' => $tech->id,
                'status'      => 'published',
            ]
        );

        $post2 = Post::firstOrCreate(
            ['title' => 'Designing Modern UI with Tailwind CSS'],
            [
                'description' => 'A guide to using split-screen layouts, glassmorphism, and responsive design systems in modern web apps.',
                'category_id' => $design->id,
                'status'      => 'published',
            ]
        );

        // 5. Safely Sync Tags (Prevents duplicate pivot table entries)
        $post1->tags()->syncWithoutDetaching([$laravelTag->id]);
        $post2->tags()->syncWithoutDetaching([$tailwindTag->id]);
    }
}