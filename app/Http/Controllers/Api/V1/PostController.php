<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'tags']);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->query('category_id'));
        }

        if ($request->has('tag_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->query('tag_id'));
            });
        }

        $posts = $query->latest()->paginate($request->query('per_page', 10));

        return PostResource::collection($posts);
    }

    public function show($id)
    {
        $post = Post::with(['category', 'tags'])->find($id);

        if (!$post) {
            return response()->json(['status' => 'error', 'message' => 'Post not found.'], 404);
        }

        return new PostResource($post);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|min:5|max:255',
            'description' => 'required|string|min:15',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required|in:draft,published,archived',
            'image'       => 'nullable|image|mimes:jpg,png,webp|max:2048',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($data);

        if ($request->has('tags')) {
            $post->tags()->sync($request->input('tags'));
        }

        return (new PostResource($post->load(['category', 'tags'])))
            ->response()
            ->setStatusCode(201);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['status' => 'error', 'message' => 'Post not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title'       => 'sometimes|required|string|min:5|max:255',
            'description' => 'sometimes|required|string|min:15',
            'category_id' => 'sometimes|required|exists:categories,id',
            'status'      => 'sometimes|required|in:draft,published,archived',
            'image'       => 'nullable|image|mimes:jpg,png,webp|max:2048',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        if ($request->has('tags')) {
            $post->tags()->sync($request->input('tags'));
        }

        return new PostResource($post->load(['category', 'tags']));
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['status' => 'error', 'message' => 'Post not found.'], 404);
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->tags()->detach();
        $post->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Post deleted successfully.'
        ], 200);
    }
}