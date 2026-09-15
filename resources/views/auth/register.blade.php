<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - YourApp</title>
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
        
        <!-- Left Branding Panel -->
        <div class="hidden lg:flex flex-1 relative bg-slate-900 overflow-hidden">
            <div class="absolute -top-24 -left-20 w-96 h-96 bg-indigo-600/30 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -right-20 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 bg-[radial-gradient(#334155_1px,transparent_1px)] [background-size:16px_16px] opacity-30"></div>

            <div class="relative z-10 flex flex-col justify-between p-12 text-white w-full">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 bg-indigo-500 rounded-xl flex items-center justify-center font-bold text-xl shadow-lg shadow-indigo-500/30">A</div>
                    <span class="text-xl font-bold tracking-tight">YourApp</span>
                </div>

                <div class="max-w-md space-y-4">
                    <h1 class="text-4xl font-extrabold tracking-tight leading-tight">
                        Start your 14-day free trial today.
                    </h1>
                    <ul class="space-y-3 text-slate-300 text-sm">
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>No credit card required to get started</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Full access to all posts & categorization features</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Cancel anytime with one click</span>
                        </li>
                    </ul>
                </div>

                <p class="text-xs text-slate-500">© 2026 YourApp Inc. All rights reserved.</p>
            </div>
        </div>

        <!-- Right Form Panel -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                
                <div>
                    <div class="lg:hidden flex items-center space-x-2 mb-6">
                        <div class="h-9 w-9 bg-indigo-600 rounded-xl flex items-center justify-center font-bold text-white text-lg">A</div>
                        <span class="text-lg font-bold">YourApp</span>
                    </div>
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900">Create an account</h2>
                    <p class="mt-2 text-sm text-slate-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Sign in</a>
                    </p>
                </div>

                <div class="mt-8">
                    <form action="{{ route('register') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Name Input -->
                        <div>
                            <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">Full Name</label>
                            <input id="name" name="name" type="text" required value="{{ old('name') }}"
                                class="mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition duration-150"
                                placeholder="Alex Morgan">
                            @error('name')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Input -->
                        <div>
                            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">Email address</label>
                            <input id="email" name="email" type="email" required value="{{ old('email') }}"
                                class="mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition duration-150"
                                placeholder="name@company.com">
                            @error('email')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">Password</label>
                            <input id="password" name="password" type="password" required
                                class="mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition duration-150"
                                placeholder="Min. 8 characters">
                            @error('password')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-700">Confirm Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="mt-1.5 w-full px-3.5 py-2.5 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition duration-150"
                                placeholder="Re-enter password">
                        </div>

                        <button type="submit" class="w-full mt-2 py-2.5 px-4 rounded-lg text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 shadow-sm transition duration-150">
                            Create Free Account
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</body>
</html>