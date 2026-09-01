<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        // 1. Basic Listing: Retrieve all records ordered by creation date
        $latestPosts = Post::latest()->get();

        // 2. Filtered Query: Retrieve only records matching a specific condition
        $publishedPosts = Post::where('status', 'published')->get();

        // 3. Relationship Eager Loading: Fetch main records with category to prevent N+1
        $eagerLoadedPosts = Post::with(['category', 'tags'])->latest()->get();

        // 4. Nested / Condition Query: Categories having at least 3 associated posts
        $popularCategories = Category::has('posts', '>=', 3)
            ->withCount('posts')
            ->get();

        return view('posts.index', compact(
            'latestPosts',
            'publishedPosts',
            'eagerLoadedPosts',
            'popularCategories'
        ));
    }
}