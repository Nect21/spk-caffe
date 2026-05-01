@extends('layouts.app')

@section('title', 'Ranking Cafe Ideal')

@section('content')
    {{-- Hero --}}
    <section class="text-center mb-12 animate-fade-in-up" id="hero-section">
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-black font-bold text-black mb-6 tracking-wide uppercase shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
            <span class="w-3 h-3 bg-[#fbbf24] border border-black animate-pulse"></span>
            SAW, WP & SMART Methods
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black mb-4 leading-tight uppercase font-retro text-black text-shadow-[4px_4px_0px_#2563eb]">
            Rekomendasi Cafe<br>
            Ideal Mahasiswa
        </h1>
        <p class="text-black max-w-2xl mx-auto text-lg font-bold bg-white p-3 border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] mt-6">
            SPK untuk menentukan cafe terbaik di <strong>Kota Tangerang Selatan</strong> berdasarkan 5 kriteria dengan metode SAW, WP, dan SMART.
        </p>
    </section>

    {{-- Stats --}}
    @if ($totalCafes > 0)
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12 animate-fade-in-up animate-delay-100" id="stats-section">
        <div class="bg-white border-4 border-black p-5 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] card-hover">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 bg-[#3b82f6] border-2 border-black flex items-center justify-center"><span class="text-2xl">☕</span></div>
                <span class="text-sm text-black font-bold uppercase">Total Cafe</span>
            </div>
            <p class="text-4xl font-retro text-black mt-2">{{ $totalCafes }}</p>
        </div>
        <div class="bg-white border-4 border-black p-5 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] card-hover">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 bg-[#22c55e] border-2 border-black flex items-center justify-center"><span class="text-2xl">🏆</span></div>
                <span class="text-sm text-black font-bold uppercase">Cafe Terbaik</span>
            </div>
            <p class="text-xl font-bold text-black truncate mt-2 uppercase">{{ $bestConsensus['cafe']->nama_cafe ?? '-' }}</p>
            <p class="text-sm text-black font-bold bg-[#22c55e] inline-block px-2 border border-black mt-1">Rata-rata Rank: {{ number_format($bestConsensus['avg_rank'] ?? 0, 1) }}</p>
        </div>
        <div class="bg-white border-4 border-black p-5 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] card-hover">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 bg-[#a855f7] border-2 border-black flex items-center justify-center"><span class="text-2xl">⚡</span></div>
                <span class="text-sm text-black font-bold uppercase">Sistem Evaluasi</span>
            </div>
            <p class="text-2xl font-retro text-black mt-2">3 Metode</p>
            <p class="text-xs text-black font-bold mt-1 bg-[#f8fafc] border border-black px-1 inline-block">SAW, WP, SMART</p>
        </div>
    </section>
    @endif

    {{-- Criteria --}}
    <section class="mb-12 animate-fade-in-up animate-delay-200" id="criteria-section">
        <div class="bg-white border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] p-6">
            <h2 class="text-xl font-bold text-black mb-6 flex items-center gap-3 uppercase font-retro text-sm sm:text-base">
                <div class="bg-[#fbbf24] p-2 border-2 border-black">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                Bobot Kriteria
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                @foreach ($criteria as $key => $c)
                <div class="bg-[#f8fafc] border-2 border-black p-3 text-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] card-hover">
                    <p class="text-xs text-black font-bold uppercase tracking-wide mb-2">{{ $c['label'] }}</p>
                    <p class="text-2xl font-retro text-black">{{ intval($c['weight'] * 100) }}%</p>
                    <span class="inline-block mt-3 px-2 py-1 border border-black text-[10px] font-bold uppercase tracking-wider {{ $c['type'] === 'benefit' ? 'bg-[#22c55e] text-black' : 'bg-[#ef4444] text-white' }}">{{ $c['type'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Ranking Table --}}
    <section class="animate-fade-in-up animate-delay-300" id="ranking-section">
        <div class="bg-white border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
            <div class="p-6 bg-[#2563eb] border-b-4 border-black flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white flex items-center gap-2 uppercase font-retro text-sm sm:text-base">📊 Hasil Perangkingan SAW</h2>
                    <p class="text-sm text-white font-bold mt-2 bg-black px-2 py-1 inline-block">V<sub>i</sub> = Σ(w<sub>j</sub> × r<sub>ij</sub>)</p>
                </div>
                <a href="{{ route('cafe.create') }}" class="btn-primary bg-[#fbbf24] text-black hover:bg-white text-sm border-2 border-black" id="btn-add-cafe">+ TAMBAH CAFE</a>
            </div>

            @if (count($rankings) === 0)
            <div class="p-16 text-center bg-[#f1f5f9]">
                <div class="w-24 h-24 bg-white border-4 border-black flex items-center justify-center mx-auto mb-6 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]"><span class="text-5xl">☕</span></div>
                <h3 class="text-xl font-bold text-black mb-2 uppercase">Belum ada data cafe</h3>
                <p class="text-black font-bold mb-6">Mulai dengan menambahkan data cafe pertama Anda</p>
                <a href="{{ route('cafe.create') }}" class="btn-primary" id="btn-empty-add">+ TAMBAH CAFE</a>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm" id="ranking-table">
                    <thead>
                        <tr class="text-left text-black text-xs uppercase tracking-wider border-b-4 border-black bg-[#f8fafc]">
                            <th class="px-6 py-4 font-black border-r-2 border-black">Rank</th>
                            <th class="px-6 py-4 font-black border-r-2 border-black">Nama Cafe</th>
                            @foreach ($criteria as $key => $c)
                            <th class="px-4 py-4 font-black text-center border-r-2 border-black">{{ $c['label'] }}</th>
                            @endforeach
                            <th class="px-6 py-4 font-black text-center border-r-2 border-black bg-[#fbbf24]">Nilai (V<sub>i</sub>)</th>
                            <th class="px-6 py-4 font-black text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="stagger-children">
                        @foreach ($rankings as $item)
                        <tr class="border-b-2 border-black hover:bg-[#f1f5f9] transition-colors" id="cafe-row-{{ $item['cafe']->id }}">
                            <td class="px-6 py-4 border-r-2 border-black">
                                @if ($item['rank'] === 1)
                                <div class="w-10 h-10 bg-[#fbbf24] border-2 border-black flex items-center justify-center font-retro text-black text-xs shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">1</div>
                                @elseif ($item['rank'] === 2)
                                <div class="w-10 h-10 bg-gray-300 border-2 border-black flex items-center justify-center font-retro text-black text-xs shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">2</div>
                                @elseif ($item['rank'] === 3)
                                <div class="w-10 h-10 bg-amber-600 border-2 border-black flex items-center justify-center font-retro text-white text-xs shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">3</div>
                                @else
                                <div class="w-10 h-10 bg-white border-2 border-black flex items-center justify-center font-bold text-black text-sm">{{ $item['rank'] }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-black whitespace-nowrap uppercase border-r-2 border-black">{{ $item['cafe']->nama_cafe }}</td>
                            @foreach ($criteria as $key => $c)
                            <td class="px-4 py-4 text-center border-r-2 border-black">
                                <div class="text-black font-bold text-base">{{ $item['cafe']->{$key} }}</div>
                                <div class="text-[10px] text-white bg-black inline-block px-1 mt-1 font-bold">r = {{ $item['normalized'][$key] }}</div>
                            </td>
                            @endforeach
                            <td class="px-6 py-4 text-center border-r-2 border-black bg-[#fef08a]">
                                <span class="text-lg font-bold text-black">{{ number_format($item['nilai_akhir'], 4) }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('cafe.edit', $item['cafe']) }}" class="btn-secondary" id="btn-edit-{{ $item['cafe']->id }}">✏️ EDIT</a>
                                    <button type="button" class="btn-danger" onclick="hapusCafe({{ $item['cafe']->id }}, '{{ addslashes($item['cafe']->nama_cafe) }}')">🗑️ HAPUS</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Normalization Details --}}
            <div class="p-6 border-t-4 border-black bg-white">
                <details class="group" id="normalization-detail">
                    <summary class="cursor-pointer text-sm font-bold text-black uppercase hover:bg-[#fbbf24] transition-colors flex items-center gap-2 p-2 border-2 border-transparent hover:border-black inline-flex">
                        <svg class="w-5 h-5 transition-transform group-open:rotate-90" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" d="M9 5l7 7-7 7"/></svg>
                        Lihat Detail Normalisasi (Max/Min)
                    </summary>
                    <div class="mt-4 grid grid-cols-2 sm:grid-cols-5 gap-4">
                        @foreach ($criteria as $key => $c)
                        <div class="bg-white border-2 border-black p-3 text-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                            <p class="text-xs text-black font-bold mb-3 bg-[#f8fafc] border-b-2 border-black p-1">{{ $c['label'] }}</p>
                            <div class="flex flex-col gap-2 text-xs font-bold">
                                <div class="bg-[#22c55e] text-black border border-black p-1">MAX: {{ $maxMin[$key]['max'] ?? '-' }}</div>
                                <div class="bg-[#ef4444] text-white border border-black p-1">MIN: {{ $maxMin[$key]['min'] ?? '-' }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </details>
            </div>
            @endif
        </div>
    </section>

    {{-- Ranking Table WP --}}
    <section class="animate-fade-in-up animate-delay-400 mt-12" id="ranking-wp-section">
        <div class="bg-white border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
            <div class="p-6 bg-[#10b981] border-b-4 border-black flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white flex items-center gap-2 uppercase font-retro text-sm sm:text-base">📊 Hasil Perangkingan WP</h2>
                    <p class="text-sm text-white font-bold mt-2 bg-black px-2 py-1 inline-block">S<sub>i</sub> = Π(X<sub>ij</sub><sup>w<sub>j</sub></sup>), V<sub>i</sub> = S<sub>i</sub> / ΣS<sub>i</sub></p>
                </div>
                <a href="{{ route('cafe.create') }}" class="btn-primary bg-[#fbbf24] text-black hover:bg-white text-sm border-2 border-black">+ TAMBAH CAFE</a>
            </div>

            @if (count($wpRankings) === 0)
            <div class="p-16 text-center bg-[#f1f5f9]">
                <div class="w-24 h-24 bg-white border-4 border-black flex items-center justify-center mx-auto mb-6 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]"><span class="text-5xl">☕</span></div>
                <h3 class="text-xl font-bold text-black mb-2 uppercase">Belum ada data cafe</h3>
                <p class="text-black font-bold mb-6">Mulai dengan menambahkan data cafe pertama Anda</p>
                <a href="{{ route('cafe.create') }}" class="btn-primary">+ TAMBAH CAFE</a>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-black text-xs uppercase tracking-wider border-b-4 border-black bg-[#f8fafc]">
                            <th class="px-6 py-4 font-black border-r-2 border-black">Rank</th>
                            <th class="px-6 py-4 font-black border-r-2 border-black">Nama Cafe</th>
                            @foreach ($criteria as $key => $c)
                            <th class="px-4 py-4 font-black text-center border-r-2 border-black">{{ $c['label'] }}</th>
                            @endforeach
                            <th class="px-6 py-4 font-black text-center border-r-2 border-black">Nilai (S<sub>i</sub>)</th>
                            <th class="px-6 py-4 font-black text-center border-r-2 border-black bg-[#fbbf24]">Nilai (V<sub>i</sub>)</th>
                            <th class="px-6 py-4 font-black text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="stagger-children">
                        @foreach ($wpRankings as $item)
                        <tr class="border-b-2 border-black hover:bg-[#f1f5f9] transition-colors">
                            <td class="px-6 py-4 border-r-2 border-black">
                                @if ($item['rank'] === 1)
                                <div class="w-10 h-10 bg-[#fbbf24] border-2 border-black flex items-center justify-center font-retro text-black text-xs shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">1</div>
                                @elseif ($item['rank'] === 2)
                                <div class="w-10 h-10 bg-gray-300 border-2 border-black flex items-center justify-center font-retro text-black text-xs shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">2</div>
                                @elseif ($item['rank'] === 3)
                                <div class="w-10 h-10 bg-amber-600 border-2 border-black flex items-center justify-center font-retro text-white text-xs shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">3</div>
                                @else
                                <div class="w-10 h-10 bg-white border-2 border-black flex items-center justify-center font-bold text-black text-sm">{{ $item['rank'] }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-black whitespace-nowrap uppercase border-r-2 border-black">{{ $item['cafe']->nama_cafe }}</td>
                            @foreach ($criteria as $key => $c)
                            <td class="px-4 py-4 text-center border-r-2 border-black">
                                <div class="text-black font-bold text-base">{{ $item['cafe']->{$key} }}</div>
                                <div class="text-[10px] text-white bg-black inline-block px-1 mt-1 font-bold">w = {{ $c['type'] === 'benefit' ? $c['weight'] : -$c['weight'] }}</div>
                            </td>
                            @endforeach
                            <td class="px-6 py-4 text-center border-r-2 border-black font-mono">
                                {{ number_format($item['s_value'], 4) }}
                            </td>
                            <td class="px-6 py-4 text-center border-r-2 border-black bg-[#fef08a]">
                                <span class="text-lg font-bold text-black">{{ number_format($item['nilai_akhir'], 4) }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('cafe.edit', $item['cafe']) }}" class="btn-secondary">✏️ EDIT</a>
                                    <button type="button" class="btn-danger" onclick="hapusCafe({{ $item['cafe']->id }}, '{{ addslashes($item['cafe']->nama_cafe) }}')">🗑️ HAPUS</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- WP Normalization Details (Sum Si) --}}
            <div class="p-6 border-t-4 border-black bg-white">
                <details class="group">
                    <summary class="cursor-pointer text-sm font-bold text-black uppercase hover:bg-[#10b981] transition-colors flex items-center gap-2 p-2 border-2 border-transparent hover:border-black inline-flex">
                        <svg class="w-5 h-5 transition-transform group-open:rotate-90" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" d="M9 5l7 7-7 7"/></svg>
                        Lihat Detail Normalisasi (Total S)
                    </summary>
                    <div class="mt-4">
                        <div class="bg-white border-2 border-black p-4 text-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] inline-block">
                            <p class="text-xs text-black font-bold mb-2 bg-[#f8fafc] border-b-2 border-black p-1">Total S<sub>i</sub> (ΣS)</p>
                            @php $totalS = collect($wpRankings)->sum('s_value'); @endphp
                            <div class="text-xl font-retro text-black p-2 bg-[#10b981] text-white border-2 border-black">
                                {{ number_format($totalS, 4) }}
                            </div>
                            <p class="text-xs font-bold mt-2 text-gray-600 max-w-xs text-left mx-auto">Nilai V<sub>i</sub> didapatkan dengan membagi S<sub>i</sub> dari masing-masing cafe dengan Total S ini.</p>
                        </div>
                    </div>
                </details>
            </div>
            @endif
        </div>
    </section>

    {{-- Ranking Table SMART --}}
    <section class="animate-fade-in-up animate-delay-450 mt-12" id="ranking-smart-section">
        <div class="bg-white border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
            <div class="p-6 bg-[#f59e0b] border-b-4 border-black flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-black flex items-center gap-2 uppercase font-retro text-sm sm:text-base">📊 Hasil Perangkingan SMART</h2>
                    <p class="text-sm text-black font-bold mt-2 bg-white border-2 border-black px-2 py-1 inline-block">u<sub>i</sub> = (x - min)/(max - min), V<sub>i</sub> = Σ(w<sub>j</sub> × u<sub>ij</sub>)</p>
                </div>
                <a href="{{ route('cafe.create') }}" class="btn-primary bg-black text-white hover:bg-gray-800 text-sm border-2 border-black">+ TAMBAH CAFE</a>
            </div>

            @if (count($smartRankings) === 0)
            <div class="p-16 text-center bg-[#f1f5f9]">
                <div class="w-24 h-24 bg-white border-4 border-black flex items-center justify-center mx-auto mb-6 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]"><span class="text-5xl">☕</span></div>
                <h3 class="text-xl font-bold text-black mb-2 uppercase">Belum ada data cafe</h3>
                <p class="text-black font-bold mb-6">Mulai dengan menambahkan data cafe pertama Anda</p>
                <a href="{{ route('cafe.create') }}" class="btn-primary">+ TAMBAH CAFE</a>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-black text-xs uppercase tracking-wider border-b-4 border-black bg-[#f8fafc]">
                            <th class="px-6 py-4 font-black border-r-2 border-black">Rank</th>
                            <th class="px-6 py-4 font-black border-r-2 border-black">Nama Cafe</th>
                            @foreach ($criteria as $key => $c)
                            <th class="px-4 py-4 font-black text-center border-r-2 border-black">{{ $c['label'] }}</th>
                            @endforeach
                            <th class="px-6 py-4 font-black text-center border-r-2 border-black bg-[#fde68a]">Nilai (V<sub>i</sub>)</th>
                            <th class="px-6 py-4 font-black text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="stagger-children">
                        @foreach ($smartRankings as $item)
                        <tr class="border-b-2 border-black hover:bg-[#f1f5f9] transition-colors">
                            <td class="px-6 py-4 border-r-2 border-black">
                                @if ($item['rank'] === 1)
                                <div class="w-10 h-10 bg-[#fbbf24] border-2 border-black flex items-center justify-center font-retro text-black text-xs shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">1</div>
                                @elseif ($item['rank'] === 2)
                                <div class="w-10 h-10 bg-gray-300 border-2 border-black flex items-center justify-center font-retro text-black text-xs shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">2</div>
                                @elseif ($item['rank'] === 3)
                                <div class="w-10 h-10 bg-amber-600 border-2 border-black flex items-center justify-center font-retro text-white text-xs shadow-[3px_3px_0px_0px_rgba(0,0,0,1)]">3</div>
                                @else
                                <div class="w-10 h-10 bg-white border-2 border-black flex items-center justify-center font-bold text-black text-sm">{{ $item['rank'] }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-bold text-black whitespace-nowrap uppercase border-r-2 border-black">{{ $item['cafe']->nama_cafe }}</td>
                            @foreach ($criteria as $key => $c)
                            <td class="px-4 py-4 text-center border-r-2 border-black">
                                <div class="text-black font-bold text-base">{{ $item['cafe']->{$key} }}</div>
                                <div class="text-[10px] text-white bg-black inline-block px-1 mt-1 font-bold">u = {{ $item['normalized'][$key] }}</div>
                            </td>
                            @endforeach
                            <td class="px-6 py-4 text-center border-r-2 border-black bg-[#fef08a]">
                                <span class="text-lg font-bold text-black">{{ number_format($item['nilai_akhir'], 4) }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('cafe.edit', $item['cafe']) }}" class="btn-secondary">✏️ EDIT</a>
                                    <button type="button" class="btn-danger" onclick="hapusCafe({{ $item['cafe']->id }}, '{{ addslashes($item['cafe']->nama_cafe) }}')">🗑️ HAPUS</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- SMART Normalization Details --}}
            <div class="p-6 border-t-4 border-black bg-white">
                <details class="group">
                    <summary class="cursor-pointer text-sm font-bold text-black uppercase hover:bg-[#f59e0b] transition-colors flex items-center gap-2 p-2 border-2 border-transparent hover:border-black inline-flex">
                        <svg class="w-5 h-5 transition-transform group-open:rotate-90" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" d="M9 5l7 7-7 7"/></svg>
                        Lihat Detail Normalisasi (Max/Min)
                    </summary>
                    <div class="mt-4 grid grid-cols-2 sm:grid-cols-5 gap-4">
                        @foreach ($criteria as $key => $c)
                        <div class="bg-white border-2 border-black p-3 text-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                            <p class="text-xs text-black font-bold mb-3 bg-[#f8fafc] border-b-2 border-black p-1">{{ $c['label'] }}</p>
                            <div class="flex flex-col gap-2 text-xs font-bold">
                                <div class="bg-[#22c55e] text-black border border-black p-1">MAX: {{ $smartMaxMin[$key]['max'] ?? '-' }}</div>
                                <div class="bg-[#ef4444] text-white border border-black p-1">MIN: {{ $smartMaxMin[$key]['min'] ?? '-' }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </details>
            </div>
            @endif
        </div>
    </section>

    {{-- Comparison Table --}}
    <section class="animate-fade-in-up animate-delay-500 mt-12 mb-12" id="comparison-section">
        <div class="bg-white border-4 border-black shadow-[8px_8px_0px_0px_rgba(0,0,0,1)] overflow-hidden">
            <div class="p-6 bg-[#8b5cf6] border-b-4 border-black flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white flex items-center gap-2 uppercase font-retro text-sm sm:text-base">⚖️ Tabel Perbandingan SAW, WP & SMART</h2>
                    <p class="text-sm text-white font-bold mt-2 bg-black px-2 py-1 inline-block">Membandingkan hasil ranking dari ketiga metode</p>
                </div>
            </div>

            @if (count($comparison) === 0)
            <div class="p-16 text-center bg-[#f1f5f9]">
                <div class="w-24 h-24 bg-white border-4 border-black flex items-center justify-center mx-auto mb-6 shadow-[6px_6px_0px_0px_rgba(0,0,0,1)]"><span class="text-5xl">☕</span></div>
                <h3 class="text-xl font-bold text-black mb-2 uppercase">Belum ada data perbandingan</h3>
                <p class="text-black font-bold mb-6">Tambahkan data cafe untuk melihat hasil perbandingan metode</p>
                <a href="{{ route('cafe.create') }}" class="btn-primary">+ TAMBAH CAFE</a>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-center text-black text-xs uppercase tracking-wider border-b-4 border-black bg-[#f8fafc]">
                            <th class="px-6 py-4 font-black border-r-2 border-black text-left">Nama Cafe</th>
                            <th class="px-4 py-4 font-black border-r-2 border-black bg-[#bfdbfe]">Rank SAW</th>
                            <th class="px-4 py-4 font-black border-r-2 border-black bg-[#bfdbfe]">Nilai SAW</th>
                            <th class="px-4 py-4 font-black border-r-2 border-black bg-[#bbf7d0]">Rank WP</th>
                            <th class="px-4 py-4 font-black border-r-2 border-black bg-[#bbf7d0]">Nilai WP</th>
                            <th class="px-4 py-4 font-black border-r-2 border-black bg-[#fde68a]">Rank SMART</th>
                            <th class="px-4 py-4 font-black border-r-2 border-black bg-[#fde68a]">Nilai SMART</th>
                            <th class="px-4 py-4 font-black">Variasi Rank</th>
                        </tr>
                    </thead>
                    <tbody class="stagger-children">
                        @foreach ($comparison as $item)
                        @php
                            $ranks = [$item['saw_rank'], $item['wp_rank'], $item['smart_rank']];
                            $diff = max($ranks) - min($ranks);
                        @endphp
                        <tr class="border-b-2 border-black hover:bg-[#f1f5f9] transition-colors text-center">
                            <td class="px-6 py-4 font-bold text-black whitespace-nowrap uppercase border-r-2 border-black text-left">{{ $item['cafe']->nama_cafe }}</td>
                            
                            <td class="px-4 py-4 border-r-2 border-black bg-blue-50 font-bold">
                                {{ $item['saw_rank'] }}
                            </td>
                            <td class="px-4 py-4 border-r-2 border-black bg-blue-50">
                                {{ number_format($item['saw_value'], 4) }}
                            </td>
                            
                            <td class="px-4 py-4 border-r-2 border-black bg-green-50 font-bold">
                                {{ $item['wp_rank'] }}
                            </td>
                            <td class="px-4 py-4 border-r-2 border-black bg-green-50">
                                {{ number_format($item['wp_value'], 4) }}
                            </td>

                            <td class="px-4 py-4 border-r-2 border-black bg-yellow-50 font-bold">
                                {{ $item['smart_rank'] }}
                            </td>
                            <td class="px-4 py-4 border-r-2 border-black bg-yellow-50">
                                {{ number_format($item['smart_value'], 4) }}
                            </td>
                            
                            <td class="px-4 py-4 font-bold">
                                @if ($diff === 0)
                                    <span class="text-gray-500">- Konsisten -</span>
                                @else
                                    <span class="text-red-600 bg-red-100 px-2 py-1 border border-black text-xs">Selisih {{ $diff }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </section>

    {{-- Hidden delete forms (outside table to avoid HTML parser issues) --}}
    @if (count($rankings) > 0)
        @foreach ($rankings as $item)
        <form id="delete-form-{{ $item['cafe']->id }}" action="{{ route('cafe.destroy', $item['cafe']) }}" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
        @endforeach
    @endif

    {{-- Custom Delete Confirmation Modal --}}
    <div id="delete-modal" class="fixed inset-0 z-[100] hidden items-center justify-center" aria-modal="true" role="dialog">
        {{-- Backdrop --}}
        <div id="delete-modal-backdrop" class="absolute inset-0 bg-[#ffe500]/90 backdrop-blur-sm transition-opacity duration-200 opacity-0"></div>
        {{-- Modal Box --}}
        <div id="delete-modal-box" class="relative z-10 w-full max-w-md mx-4 transition-all duration-200 scale-95 opacity-0">
            <div class="bg-white border-4 border-black p-8 shadow-[12px_12px_0px_0px_rgba(0,0,0,1)]">
                {{-- Icon --}}
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-[#ef4444] border-4 border-black flex items-center justify-center shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="square" stroke-linejoin="miter" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                </div>
                {{-- Text --}}
                <h3 class="text-xl font-retro text-black text-center mb-4 uppercase text-sm sm:text-base">Hapus Data Cafe?</h3>
                <p class="text-black text-center text-sm mb-8 font-bold bg-[#f1f5f9] border-2 border-black p-3">
                    Hapus <strong id="delete-modal-name" class="text-[#ef4444] text-base"></strong> secara permanen? Data tidak dapat dikembalikan!
                </p>
                {{-- Buttons --}}
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <button type="button" id="delete-modal-cancel" class="btn-secondary w-full sm:w-1/2">
                        BATAL
                    </button>
                    <button type="button" id="delete-modal-confirm" class="btn-danger w-full sm:w-1/2">
                        🗑️ HAPUS
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let deleteFormId = null;

        function hapusCafe(id, nama) {
            deleteFormId = id;
            document.getElementById('delete-modal-name').textContent = '"' + nama + '"';
            const modal = document.getElementById('delete-modal');
            const backdrop = document.getElementById('delete-modal-backdrop');
            const box = document.getElementById('delete-modal-box');

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Trigger animation
            requestAnimationFrame(function() {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
                box.classList.remove('scale-95', 'opacity-0');
                box.classList.add('scale-100', 'opacity-100');
            });
        }

        function closeDeleteModal() {
            const backdrop = document.getElementById('delete-modal-backdrop');
            const box = document.getElementById('delete-modal-box');
            const modal = document.getElementById('delete-modal');

            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            box.classList.remove('scale-100', 'opacity-100');
            box.classList.add('scale-95', 'opacity-0');

            setTimeout(function() {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                deleteFormId = null;
            }, 200);
        }

        document.getElementById('delete-modal-cancel').addEventListener('click', closeDeleteModal);
        document.getElementById('delete-modal-backdrop').addEventListener('click', closeDeleteModal);
        document.getElementById('delete-modal-confirm').addEventListener('click', function() {
            if (deleteFormId) {
                document.getElementById('delete-form-' + deleteFormId).submit();
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDeleteModal();
        });
    </script>
@endsection

