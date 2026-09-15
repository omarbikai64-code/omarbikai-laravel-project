<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Dashboard | Eloquent Queries</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen font-sans text-slate-800 antialiased">

    <!-- Top Navigation Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-600 text-white font-bold px-3 py-1.5 rounded-lg text-lg tracking-wider">L12</div>
                <h1 class="text-xl font-bold text-slate-900">Post Management System</h1>
            </div>
            
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition shadow-sm">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        New Post
                    </a>

                    <!-- Profile Dropdown Menu -->
                    <div class="relative inline-block text-left">
                        <button id="userMenuBtn" onclick="toggleUserMenu()" class="flex items-center space-x-3 focus:outline-none rounded-lg p-1.5 hover:bg-slate-100 transition">
                            <div class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 border border-blue-200 flex items-center justify-center font-bold text-sm shadow-sm">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </div>
                            <span class="text-sm font-semibold text-slate-700 hidden sm:inline-block">
                                {{ auth()->user()->name ?? 'User' }}
                            </span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Card -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-200 py-1 z-30 transition-all">
                            <div class="px-4 py-2.5 border-b border-slate-100">
                                <p class="text-xs font-semibold text-slate-900 truncate">{{ auth()->user()->name ?? 'User' }}</p>
                                <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ auth()->user()->email ?? '' }}</p>
                            </div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-xs font-medium text-rose-600 hover:bg-rose-50 flex items-center space-x-2 transition">
                                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 px-3 py-2">Sign in</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-slate-900 text-white text-sm font-medium rounded-lg hover:bg-slate-800 transition">Get Started</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- Flash Alert -->
        @if(session('success'))
            <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-200 flex items-center justify-between text-emerald-800">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Section 3: Eager Loaded Posts Table (Main CRUD Table) -->
        <section id="postsSection" class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">Eager Loaded Posts & Operations</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Includes category relationships, tag collections, image thumbnails, and CRUD actions.</p>
                </div>
                <span class="text-xs font-semibold uppercase tracking-wider bg-purple-100 text-purple-700 px-2.5 py-1 rounded-full">Query 3</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                        <tr>
                            <th class="px-6 py-3.5">Post</th>
                            <th class="px-6 py-3.5">Category</th>
                            <th class="px-6 py-3.5">Tags</th>
                            <th class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse($eagerLoadedPosts as $index => $post)
                            <tr class="post-row hover:bg-slate-50/80 transition {{ $index >= 4 ? 'hidden' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        @if($post->image)
                                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-12 h-12 rounded-lg object-cover border border-slate-200 shadow-sm flex-shrink-0">
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 font-bold text-xs flex-shrink-0">
                                                NO IMG
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="font-semibold text-slate-900 truncate max-w-xs md:max-w-md">{{ $post->title }}</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Created {{ $post->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $post->category?->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($post->tags as $tag)
                                            <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded">#{{ $tag->name }}</span>
                                        @empty
                                            <span class="text-xs text-slate-400 italic">No tags</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    @auth
                                        <div class="inline-flex items-center space-x-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('posts.edit', $post->id) }}" 
                                               class="inline-flex items-center px-3 py-1.5 border border-slate-200 text-xs font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-500">
                                                <svg class="w-3.5 h-3.5 mr-1 text-slate-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to permanently delete this post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1.5 border border-rose-100 text-xs font-medium rounded-lg text-rose-600 bg-rose-50/50 hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-rose-500">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-400">
                                            Read-only
                                        </span>
                                    @endauth
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-slate-400">No posts available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Dynamic Batch & Toggle Button Container -->
            @if(count($eagerLoadedPosts) > 4)
                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-200 text-center flex items-center justify-center space-x-3">
                    <button id="togglePostsBtn" onclick="handlePostToggle()" 
                            class="inline-flex items-center px-5 py-2.5 border border-slate-300 text-xs font-semibold rounded-lg text-slate-700 bg-white hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-sm">
                        <span id="btnText">See More Posts (+4)</span>
                        <svg id="btnIcon" class="w-4 h-4 ml-2 text-slate-500 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <button id="seeLessBtn" onclick="collapsePosts()" 
                            class="hidden inline-flex items-center px-4 py-2.5 border border-slate-200 text-xs font-semibold rounded-lg text-slate-600 bg-slate-100 hover:bg-slate-200 hover:text-slate-800 focus:outline-none transition-all shadow-sm">
                        <span>See Less</span>
                        <svg class="w-4 h-4 ml-1.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                </div>
            @endif
        </section>

        <!-- Grid Layout for Queries 1, 2, and 4 -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Section 1: Basic Listing -->
            <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                <div class="px-5 py-3.5 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 text-sm">1. Latest Posts</h3>
                    <span class="text-xs font-semibold bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">Basic Query</span>
                </div>
                <div class="p-4 flex-1">
                    <ul class="divide-y divide-slate-100">
                        @foreach($latestPosts->take(6) as $post)
                            <li class="py-2.5 flex justify-between items-center">
                                <span class="text-xs font-medium text-slate-700 truncate max-w-[180px]">{{ $post->title }}</span>
                                <span class="text-[11px] text-slate-400 whitespace-nowrap ml-2">{{ $post->created_at->diffForHumans() }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>

            <!-- Section 2: Filtered Query (Published) -->
            <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                <div class="px-5 py-3.5 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 text-sm">2. Filtered (Published)</h3>
                    <span class="text-xs font-semibold bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full">Where Clause</span>
                </div>
                <div class="p-4 flex-1">
                    <ul class="divide-y divide-slate-100">
                        @foreach($publishedPosts->take(6) as $post)
                            <li class="py-2.5 flex items-center justify-between">
                                <span class="text-xs font-medium text-slate-700 truncate max-w-[170px]">{{ $post->title }}</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase">
                                    {{ $post->status }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>

            <!-- Section 4: Condition Query -->
            <section class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                <div class="px-5 py-3.5 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 text-sm">4. Popular Categories</h3>
                    <span class="text-xs font-semibold bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">≥ 3 Posts</span>
                </div>
                <div class="p-4 flex-1">
                    <ul class="space-y-2">
                        @foreach($popularCategories as $category)
                            <li class="flex items-center justify-between p-2 rounded-lg bg-slate-50 border border-slate-100">
                                <span class="text-xs font-semibold text-slate-800">{{ $category->name }}</span>
                                <span class="text-xs font-medium bg-slate-200 text-slate-700 px-2 py-0.5 rounded-full">
                                    {{ $category->posts_count }} posts
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>

        </div>

    </main>

    <!-- JavaScript logic -->
    <script>
        // Profile Menu Toggle Logic
        function toggleUserMenu() {
            const menu = document.getElementById('userDropdown');
            menu.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside of it
        window.addEventListener('click', function(e) {
            const btn = document.getElementById('userMenuBtn');
            const menu = document.getElementById('userDropdown');
            if (btn && menu && !btn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        // Table Toggle & Batching Logic
        function handlePostToggle() {
            const hiddenRows = document.querySelectorAll('.post-row.hidden');
            const seeLessBtn = document.getElementById('seeLessBtn');
            const btnText = document.getElementById('btnText');
            const btnIcon = document.getElementById('btnIcon');
            const batchSize = 4;

            for (let i = 0; i < batchSize && i < hiddenRows.length; i++) {
                hiddenRows[i].classList.remove('hidden');
            }

            if (seeLessBtn) {
                seeLessBtn.classList.remove('hidden');
            }

            const remainingHidden = document.querySelectorAll('.post-row.hidden').length;

            if (remainingHidden === 0) {
                btnText.textContent = 'Collapse All';
                btnIcon.querySelector('path').setAttribute('d', 'M5 15l7-7 7 7');
                if (seeLessBtn) seeLessBtn.classList.add('hidden');
            } else {
                btnText.textContent = `See More Posts (+${Math.min(batchSize, remainingHidden)})`;
            }
        }

        function collapsePosts() {
            const rows = document.querySelectorAll('.post-row');
            const seeLessBtn = document.getElementById('seeLessBtn');
            const btnText = document.getElementById('btnText');
            const btnIcon = document.getElementById('btnIcon');

            rows.forEach((row, index) => {
                if (index >= 4) {
                    row.classList.add('hidden');
                }
            });

            btnText.textContent = 'See More Posts (+4)';
            btnIcon.querySelector('path').setAttribute('d', 'M19 9l-7 7-7-7');
            
            if (seeLessBtn) {
                seeLessBtn.classList.add('hidden');
            }

            document.getElementById('postsSection').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>