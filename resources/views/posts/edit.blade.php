<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-6">Edit Post</h2>

        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium text-gray-700">Title</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" class="w-full border rounded p-2 mt-1">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-gray-700">Description</label>
                <textarea name="description" rows="4" class="w-full border rounded p-2 mt-1">{{ old('description', $post->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-gray-700">Category</label>
                <select name="category_id" class="w-full border rounded p-2 mt-1">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Tags Section -->
            <div>
                <label class="block font-medium text-gray-700 mb-2">Tags</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 bg-gray-50 p-3 border rounded">
                    @foreach($tags as $tag)
                        <label class="inline-flex items-center space-x-2 text-sm text-gray-700 cursor-pointer">
                            <input type="checkbox" 
                                   name="tags[]" 
                                   value="{{ $tag->id }}" 
                                   class="rounded text-blue-600 border-gray-300 focus:ring-blue-500"
                                   {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <span>#{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('tags') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-gray-700">Status</label>
                <select name="status" class="w-full border rounded p-2 mt-1">
                    <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="archived" {{ old('status', $post->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
                @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Current Image Preview -->
            @if($post->image)
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Current Image</label>
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Current Post Image" class="w-32 h-32 object-cover rounded border">
                </div>
            @endif

            <!-- File Input to Replace Image -->
            <div>
                <label class="block font-medium text-gray-700">Replace Image (Optional, max 2MB)</label>
                <input type="file" name="image" class="w-full border rounded p-2 mt-1">
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-between pt-4">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Update Post
                </button>
            </div>
        </form>

        <!-- Separate Form for Deleting Post -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Delete Post
                </button>
            </form>
        </div>
    </div>
</body>
</html>