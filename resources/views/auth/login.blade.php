<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - YourApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-full">
    <div class="min-h-full flex">
        
        <!-- Left Branding Panel (Hidden on Mobile) -->
        <div class="hidden lg:flex flex-1 relative bg-slate-900 overflow-hidden">
            <!-- Background Decorative Gradients -->
            <div class="absolute -top-24 -left-20 w-96 h-96 bg-indigo-600/30 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -right-20 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 bg-[radial-gradient(#334155_1px,transparent_1px)] [background-size:16px_16px] opacity-30"></div>

            <div class="relative z-10 flex flex-col justify-between p-12 text-white w-full">
                <!-- Brand Logo -->
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 bg-indigo-500 rounded-xl flex items-center justify-center font-bold text-xl shadow-lg shadow-indigo-500/30">
                        A
                    </div>
                    <span class="text-xl font-bold tracking-tight">YourApp</span>
                </div>

                <!-- Hero Content -->
                <div class="max-w-md space-y-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-500/10 text-indigo-300 border border-indigo-500/20">
                        Version 2.0 Live
                    </span>
                    <h1 class="text-4xl font-extrabold tracking-tight leading-tight">
                        Manage your content with total confidence.
                    </h1>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Join thousands of creators using our platform to build, publish, and scale their digital experiences.
                    </p>
                </div>

                <!-- Testimonial / Footer badge -->
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md max-w-md">
                    <p class="text-xs text-slate-300 italic mb-2">"This platform transformed how our editorial team handles daily publishing."</p>
                    <div class="flex items-center space-x-3">
                        <div class="h-8 w-8 rounded-full bg-slate-700 flex items-center justify-center text-xs font-bold">JD</div>
                        <div>
                            <p class="text-xs font-semibold text-white">Jane Doe</p>
                            <p class="text-[10px] text-slate-400">Head of Content at TechCorp</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Form Panel -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                
                <!-- Header -->
                <div>
                    <div class="lg:hidden flex items-center space-x-2 mb-6">
                        <div class="h-9 w-9 bg-indigo-600 rounded-xl flex items-center justify-center font-bold text-white text-lg">A</div>
                        <span class="text-lg font-bold">YourApp</span>
                    </div>
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900">Welcome back</h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Sign up free</a>
                    </p>
                </div>

                <!-- Form -->
                <div class="mt-8">
                    <form action="{{ route('login') }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">Email address</label>
                            <div class="mt-1.5 relative">
                                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                    class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition duration-150"
                                    placeholder="name@company.com">
                            </div>
                            @error('email')
                                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-500">Forgot?</a>
                                @endif
                            </div>
                            <div class="mt-1.5">
                                <input id="password" name="password" type="password" required
                                    class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition duration-150"
                                    placeholder="••••••••">
                            </div>
                            @error('password')
                                <p class="mt-1.5 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-slate-600">Remember for 30 days</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full py-2.5 px-4 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 shadow-sm transition duration-150">
                            Sign in to account
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</body>
</html>