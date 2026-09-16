<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $latestPosts = Post::latest()->get();
        $publishedPosts = Post::where('status', 'published')->get();
        $eagerLoadedPosts = Post::with(['category', 'tags'])->latest()->get();
        $popularCategories = Category::has('posts', '>=', 1)->withCount('posts')->get();

        return view('posts.index', compact('latestPosts', 'publishedPosts', 'eagerLoadedPosts', 'popularCategories'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|min:5|max:255',
            'description' => 'required|string|min:15',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required|in:draft,published,archived',
            'image'       => 'nullable|image|mimes:jpg,png,webp|max:2048',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($validated);
        $post->tags()->sync($request->input('tags', []));

        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'       => 'required|string|min:5|max:255',
            'description' => 'required|string|min:15',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required|in:draft,published,archived',
            'image'       => 'nullable|image|mimes:jpg,png,webp|max:2048',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($validated);
        $post->tags()->sync($request->input('tags', []));

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
}