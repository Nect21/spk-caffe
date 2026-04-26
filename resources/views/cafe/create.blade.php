@extends('layouts.app')

@section('title', 'Tambah Cafe Baru')

@section('content')
    <div class="max-w-2xl mx-auto animate-fade-in-up">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('cafe.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-black border-b-2 border-transparent hover:border-black transition-colors mb-4 uppercase" id="btn-back-create">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Ranking
            </a>
            <h1 class="text-3xl font-retro text-black uppercase text-shadow-[3px_3px_0px_#22c55e]">Tambah Cafe Baru</h1>
            <p class="text-black font-bold mt-2 bg-white inline-block px-2 border-2 border-black">Masukkan data cafe dan nilai sub-kriteria (skala 0.2 — 1.0)</p>
        </div>

        {{-- Form --}}
        <form action="{{ route('cafe.store') }}" method="POST" class="bg-white border-4 border-black p-6 sm:p-8 space-y-6 shadow-[8px_8px_0px_0px_rgba(0,0,0,1)]" id="form-create-cafe">
            @csrf

            {{-- Nama Cafe --}}
            <div>
                <label for="nama_cafe" class="block text-sm font-retro text-black mb-2 uppercase">Nama Cafe</label>
                <input
                    type="text"
                    id="nama_cafe"
                    name="nama_cafe"
                    value="{{ old('nama_cafe') }}"
                    placeholder="Contoh: KOPI NAKO"
                    required
                    class="w-full px-4 py-3 bg-[#f8fafc] border-4 border-black text-black font-bold uppercase placeholder-gray-400 focus:outline-none focus:bg-[#fef08a] transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] focus:shadow-[2px_2px_0px_0px_rgba(0,0,0,1)] focus:translate-y-[2px] focus:translate-x-[2px]"
                >
                @error('nama_cafe')
                    <p class="mt-2 text-sm font-bold text-white bg-[#ef4444] inline-block px-2 border border-black">{{ $message }}</p>
                @enderror
            </div>

            {{-- Score Fields --}}
            <div class="space-y-6">
                <h3 class="text-base font-retro text-black border-b-4 border-black pb-2 uppercase mt-8 mb-4">Nilai Kriteria</h3>

                @php
                    $fields = [
                        'wifi_score' => [
                            'label' => 'Wifi (C1)',
                            'desc' => 'Kualitas & kecepatan wifi — Benefit (makin bagus makin baik)',
                            'icon' => '📶',
                            'type' => 'benefit',
                            'scale' => [
                                '0.2' => 'Sangat Lambat',
                                '0.4' => 'Lambat',
                                '0.6' => 'Cukup Baik',
                                '0.8' => 'Cepat & Stabil',
                                '1.0' => 'Sangat Cepat',
                            ],
                        ],
                        'harga_score' => [
                            'label' => 'Harga (C2)',
                            'desc' => 'Tingkat harga menu — Cost (makin murah makin baik)',
                            'icon' => '💰',
                            'type' => 'cost',
                            'scale' => [
                                '0.2' => 'Sangat Mahal',
                                '0.4' => 'Mahal',
                                '0.6' => 'Sedang',
                                '0.8' => 'Murah',
                                '1.0' => 'Sangat Murah',
                            ],
                        ],
                        'bangunan_score' => [
                            'label' => 'Bangunan/Tempat (C3)',
                            'desc' => 'Kondisi & kenyamanan bangunan — Cost',
                            'icon' => '🏢',
                            'type' => 'cost',
                            'scale' => [
                                '0.2' => 'Sangat Sederhana',
                                '0.4' => 'Sederhana',
                                '0.6' => 'Cukup Nyaman',
                                '0.8' => 'Nyaman & Bagus',
                                '1.0' => 'Sangat Mewah',
                            ],
                        ],
                        'luas_score' => [
                            'label' => 'Luas Bangunan (C4)',
                            'desc' => 'Luas area cafe untuk kenyamanan — Benefit',
                            'icon' => '📐',
                            'type' => 'benefit',
                            'scale' => [
                                '0.2' => 'Sangat Sempit',
                                '0.4' => 'Sempit',
                                '0.6' => 'Cukup Luas',
                                '0.8' => 'Luas',
                                '1.0' => 'Sangat Luas',
                            ],
                        ],
                        'jarak_score' => [
                            'label' => 'Jarak Kampus (C5)',
                            'desc' => 'Jarak dari cafe ke kampus — Benefit (makin dekat makin baik)',
                            'icon' => '📍',
                            'type' => 'benefit',
                            'scale' => [
                                '0.2' => 'Sangat Jauh',
                                '0.4' => 'Jauh',
                                '0.6' => 'Sedang',
                                '0.8' => 'Dekat',
                                '1.0' => 'Sangat Dekat',
                            ],
                        ],
                    ];
                @endphp

                @foreach ($fields as $name => $field)
                <div class="bg-white border-4 border-black p-5 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]" id="field-{{ $name }}">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">{{ $field['icon'] }}</span>
                            <div>
                                <label for="{{ $name }}" class="text-sm font-bold text-black uppercase">{{ $field['label'] }}</label>
                                <p class="text-[10px] sm:text-xs text-black font-semibold">{{ $field['desc'] }}</p>
                            </div>
                        </div>
                        <div>
                            <span class="text-[10px] px-2 py-1 border-2 border-black font-bold uppercase tracking-wider {{ $field['type'] === 'benefit' ? 'bg-[#22c55e] text-black' : 'bg-[#ef4444] text-white' }}">{{ $field['type'] }}</span>
                        </div>
                    </div>

                    {{-- Current value display --}}
                    <div class="flex items-center justify-between mb-4 border-2 border-dashed border-black p-2 bg-[#f8fafc]">
                        <span class="text-3xl font-retro text-[#2563eb]" id="val-{{ $name }}">{{ old($name, '0.6') }}</span>
                        <span class="text-sm font-bold text-black uppercase" id="label-{{ $name }}">{{ $field['scale'][old($name, '0.6')] ?? 'Cukup Baik' }}</span>
                    </div>

                    <input
                        type="range"
                        id="{{ $name }}"
                        name="{{ $name }}"
                        min="0.2"
                        max="1.0"
                        step="0.2"
                        value="{{ old($name, '0.6') }}"
                        class="w-full"
                        data-labels='@json($field['scale'])'
                        oninput="updateSlider(this, '{{ $name }}')"
                    >

                    {{-- Scale labels --}}
                    <div class="grid grid-cols-5 gap-1 mt-3">
                        @foreach ($field['scale'] as $val => $scaleLabel)
                        <div class="text-center border-t-2 border-black pt-1">
                            <div class="text-[11px] font-black text-black">{{ $val }}</div>
                            <div class="hidden sm:block text-[9px] text-black font-bold uppercase leading-tight">{{ $scaleLabel }}</div>
                        </div>
                        @endforeach
                    </div>

                    @error($name)
                        <p class="mt-2 text-sm font-bold text-white bg-[#ef4444] inline-block px-2 border border-black">{{ $message }}</p>
                    @enderror
                </div>
                @endforeach
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-center gap-4 pt-6 border-t-4 border-black">
                <button type="submit" class="btn-primary w-full sm:w-auto text-base" id="btn-submit-create">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" d="M5 13l4 4L19 7"/></svg>
                    SIMPAN DATA
                </button>
                <a href="{{ route('cafe.index') }}" class="btn-secondary w-full sm:w-auto text-center" id="btn-cancel-create">BATAL</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    function updateSlider(input, name) {
        const val = parseFloat(input.value).toFixed(1);
        const labels = JSON.parse(input.getAttribute('data-labels'));
        document.getElementById('val-' + name).textContent = val;
        document.getElementById('label-' + name).textContent = labels[val] || '';
    }
</script>
@endpush

