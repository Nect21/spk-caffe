<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Pendukung Keputusan rekomendasi cafe ideal untuk mahasiswa Kota Tangerang Selatan menggunakan metode Simple Additive Weighting (SAW)">
    <title>@yield('title', 'SPK Cafe - Rekomendasi Cafe Ideal') | SAW, WP & SMART Method</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#ffe500] text-black font-sans antialiased">

    {{-- Navigation --}}
    <nav class="sticky top-0 z-50 bg-white border-b-4 border-black" id="main-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <a href="{{ route('cafe.index') }}" class="flex items-center gap-4 group" id="nav-brand">
                    <div class="w-12 h-12 bg-[#2563eb] border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] flex items-center justify-center transition-transform group-hover:-translate-y-1 group-active:translate-y-0 group-active:shadow-none">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-xl font-bold font-retro text-black leading-tight tracking-tighter">SPK CAFE</span>
                        <span class="block text-[10px] text-black font-bold mt-1 tracking-widest uppercase bg-[#fbbf24] px-1 border border-black inline-block">SAW, WP & SMART METHOD</span>
                    </div>
                </a>
                <div class="flex items-center gap-4">
                    <a href="{{ route('cafe.index') }}#comparison-section" class="px-4 py-2 text-sm font-bold text-black border-2 border-transparent hover:border-black hover:bg-[#fbbf24] transition-colors rounded-none" id="nav-ranking">
                        [ RANKING ]
                    </a>
                    <a href="{{ route('cafe.create') }}" class="btn-primary text-sm" id="nav-add-cafe">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" d="M12 4v16m8-8H4"/>
                        </svg>
                        TAMBAH CAFE
                    </a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 animate-fade-in-up" id="flash-success">
            <div class="bg-[#22c55e] border-4 border-black p-4 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] flex items-center gap-4">
                <div class="w-10 h-10 bg-white border-2 border-black flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="square" stroke-linejoin="miter" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-black font-bold font-sans text-base">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="mt-16 bg-white border-t-4 border-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-sm font-bold text-black">
                <p>© {{ date('Y') }} <span class="font-retro text-xs bg-[#fbbf24] px-2 py-1 border border-black">SPK CAFE</span> — Bimasena Adha Duanda (231011403599)</p>
                <p class="uppercase">Rekomendasi Cafe Ideal untuk Mahasiswa Kota Tangerang Selatan</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
