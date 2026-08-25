<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Umera Certificate Manager — Umera Business School')</title>
    <meta name="description" content="@yield('meta_description', 'Access, download, share, and verify official Umera Business School certificates.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%238B0000'/><path d='M30 30h40v40H30z' fill='none' stroke='white' stroke-width='6'/><text x='50' y='62' text-anchor='middle' fill='white' font-family='serif' font-size='28' font-weight='bold'>U</text></svg>">
</head>
<body class="bg-neutral-50 text-neutral-800 min-h-screen flex flex-col">
    @hasSection('header')
        @yield('header')
    @else
        <header class="w-full border-b border-neutral-200 bg-white/90 backdrop-blur-sm sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" class="h-9 w-auto object-contain" alt="Umera Logo" />
                        <div class="flex flex-col leading-tight">
                            <span class="font-semibold text-neutral-900 text-sm">Umera Business School</span>
                            <span class="text-[11px] text-neutral-500">Certificate Manager</span>
                        </div>
                    </a>
                    <nav class="hidden md:flex items-center gap-6 text-sm">
                        <a href="{{ url('/') }}" class="text-neutral-600 hover:text-neutral-900 transition-colors">Home</a>
                        <a href="{{ url('/verify/UMB5-GAI-2026-000001') }}" class="text-neutral-600 hover:text-neutral-900 transition-colors">Verify</a>
                    </nav>
                    <button class="md:hidden btn btn-sm btn-ghost" onclick="Umera.showToast('Menu prototype', 'info')" aria-label="Menu">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    </button>
                </div>
            </div>
        </header>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    @hasSection('footer')
        @yield('footer')
    @else
        <footer class="border-t border-neutral-200 bg-white mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="grid gap-8 md:grid-cols-3">
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <img src="{{ asset('images/logo.png') }}" class="h-8 w-auto object-contain" alt="Umera Logo" />
                            <div class="font-semibold text-neutral-900">Umera Business School</div>
                        </div>
                        <p class="text-sm text-neutral-500 leading-relaxed">Empowering professionals with verified credentials and recognized achievements.</p>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-neutral-900 mb-3">Certificate Portal</div>
                        <ul class="space-y-2 text-sm text-neutral-500">
                            <li><a href="{{ url('/') }}" class="hover:text-umbera-500 transition-colors">Find My Certificate</a></li>
                            <li><a href="{{ url('/verify/UMB5-GAI-2026-000001') }}" class="hover:text-umbera-500 transition-colors">Verify a Certificate</a></li>
                            <li><a href="{{ url('/certificate/UMB5-GAI-2026-000001') }}" class="hover:text-umbera-500 transition-colors">Preview Example</a></li>
                        </ul>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-neutral-900 mb-3">Organization</div>
                        <ul class="space-y-2 text-sm text-neutral-500">
                            <li><span class="text-neutral-400">cert@umbs.ng</span></li>
                            <li><span class="text-neutral-400">&copy; {{ date('Y') }} Umera Business School</span></li>
                        </ul>
                    </div>
                </div>
                <div class="mt-10 pt-6 border-t border-neutral-100 flex flex-col sm:flex-row justify-between items-center gap-3">
                    <div class="text-xs text-neutral-400">All certificates are digitally verifiable.</div>
                    <div class="text-xs text-neutral-400">Umera Certificate Manager v1.0</div>
                </div>
            </div>
        </footer>
    @endif

    @include('components.share-modal')
</body>
</html>
