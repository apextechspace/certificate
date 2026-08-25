<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login — Umera Certificate Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%238B0000'/><path d='M30 30h40v40H30z' fill='none' stroke='white' stroke-width='6'/><text x='50' y='62' text-anchor='middle' fill='white' font-family='serif' font-size='28' font-weight='bold'>U</text></svg>">
</head>
<body class="min-h-screen bg-neutral-50 text-neutral-800">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-umbera-500 via-umbera-600 to-umbera-700 text-white relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-20 left-20 w-72 h-72 rounded-full bg-white blur-3xl"></div>
                <div class="absolute bottom-20 right-20 w-96 h-96 rounded-full bg-white blur-3xl"></div>
            </div>
            <div class="relative z-10 flex flex-col justify-between p-12 xl:p-16 w-full">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo.png') }}" class="h-14 w-auto object-contain" alt="Umera Logo" />
                    <div>
                        <div class="font-serif text-2xl font-bold tracking-tight">Umera</div>
                        <div class="text-white/70 text-sm">Business School</div>
                    </div>
                </div>
                <div class="space-y-8 max-w-md">
                    <h1 class="font-serif text-5xl xl:text-6xl font-bold leading-tight tracking-tight">
                        Certificate<br/>Management
                    </h1>
                    <p class="text-white/80 text-lg leading-relaxed">
                        Manage, issue, and verify professional certificates for UmeraBoost program participants with confidence and precision.
                    </p>
                    <div class="space-y-4 pt-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white/15 border border-white/20 flex items-center justify-center shrink-0">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <span class="text-white/90">Secure, tamper-proof certificate IDs</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white/15 border border-white/20 flex items-center justify-center shrink-0">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <span class="text-white/90">Real-time verification &amp; tracking</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-white/15 border border-white/20 flex items-center justify-center shrink-0">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            </div>
                            <span class="text-white/90">Bulk operations &amp; reporting</span>
                        </div>
                    </div>
                </div>
                <div class="text-white/60 text-sm">
                    &copy; {{ date('Y') }} Umera Business School. All rights reserved.
                </div>
            </div>
        </div>

        <div class="flex-1 flex items-center justify-center p-6 sm:p-10 lg:p-12">
            <div class="w-full max-w-md">
                <div class="lg:hidden flex items-center gap-3 mb-10">
                    <img src="{{ asset('images/logo.png') }}" class="h-11 w-auto object-contain" alt="Umera Logo" />
                    <div>
                        <div class="font-serif text-xl font-bold text-neutral-900">Umera Business School</div>
                        <div class="text-xs text-neutral-500">Certificate Manager</div>
                    </div>
                </div>

                <div class="animate-slide-up">
                    <h2 class="font-serif text-3xl font-bold text-neutral-900 tracking-tight">Welcome back</h2>
                    <p class="mt-2 text-neutral-500">Sign in to the admin console to manage certificates.</p>
                </div>

                <form method="POST" action="{{ url('/admin/login') }}" class="mt-10 space-y-5">
                    @csrf

                    @if ($errors->any())
                        <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm flex flex-col gap-1.5 animate-fade-in">
                            @foreach ($errors->all() as $error)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 shrink-0 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    <span>{{ $error }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div>
                        <label for="email" class="block text-sm font-medium text-neutral-700 mb-1.5">Email Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400 pointer-events-none">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </span>
                            <input id="email" type="email" name="email" required autocomplete="email" value="{{ old('email') }}" class="input-field pl-10" placeholder="you@umbs.ng" />
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-medium text-neutral-700">Password</label>
                            <a href="#" class="text-sm font-medium text-umbera-500 hover:text-umbera-600 transition-colors">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-neutral-400 pointer-events-none">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </span>
                            <input id="password" type="password" name="password" required autocomplete="current-password" class="input-field pl-10 pr-10" placeholder="Enter your password" />
                            <button type="button" onclick="Umera.togglePassword('password', this)" class="absolute inset-y-0 right-0 flex items-center pr-3 text-neutral-400 hover:text-neutral-600 transition-colors">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" checked class="w-4 h-4 rounded border-neutral-300 text-umbera-500 focus:ring-umbera-500 focus:ring-offset-0 cursor-pointer" />
                            <span class="text-sm text-neutral-600">Remember me</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-full py-3 text-base justify-center">
                        Sign In
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </button>
                </form>

                <div class="mt-10 pt-8 border-t border-neutral-200">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-800 transition-colors">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        Back to certificate portal
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
