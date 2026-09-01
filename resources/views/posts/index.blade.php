<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eloquent Query Results</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8 font-sans">
    <div class="max-w-6xl mx-auto space-y-8">
        <h1 class="text-3xl font-bold text-gray-800 border-b pb-4">Task 4: Eloquent Query Results</h1>

        <!-- Scenario 1: Basic Listing -->
        <section class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-blue-600 mb-3">1. Basic Listing (Latest Posts)</h2>
            <ul class="list-disc pl-5 space-y-1">
                @foreach($latestPosts as $post)
                    <li class="text-gray-700"><strong>{{ $post->title }}</strong> — Created: {{ $post->created_at->diffForHumans() }}</li>
                @endforeach
            </ul>
        </section>

        <!-- Scenario 2: Filtered Query -->
        <section class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-green-600 mb-3">2. Filtered Query (Status: Published)</h2>
            <ul class="list-disc pl-5 space-y-1">
                @foreach($publishedPosts as $post)
                    <li class="text-gray-700"><strong>{{ $post->title }}</strong> <span class="text-xs bg-green-200 text-green-800 px-2 py-0.5 rounded">{{ $post->status }}</span></li>
                @endforeach
            </ul>
        </section>

        <!-- Scenario 3: Eager Loading -->
        <section class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-purple-600 mb-3">3. Eager Loaded Relationships (Posts with Category & Tags)</h2>
            <div class="space-y-3">
                @foreach($eagerLoadedPosts as $post)
                    <div class="border-b pb-2">
                        <p class="font-medium text-gray-800">{{ $post->title }}</p>
                        <p class="text-sm text-gray-500">Category: <span class="font-semibold text-gray-700">{{ $post->category->name }}</span></p>
                        <div class="flex gap-1 mt-1">
                            @foreach($post->tags as $tag)
                                <span class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded">#{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Scenario 4: Nested / Condition Query -->
        <section class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-orange-600 mb-3">4. Condition Query (Categories with ≥ 3 Posts)</h2>
            <ul class="list-disc pl-5 space-y-1">
                @foreach($popularCategories as $category)
                    <li class="text-gray-700"><strong>{{ $category->name }}</strong> — Total Posts: {{ $category->posts_count }}</li>
                @endforeach
            </ul>
        </section>
    </div>
</body>
</html>