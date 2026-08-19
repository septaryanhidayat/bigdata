@extends('admin.layout')

@section('title', 'Pengaturan Titik Koordinat GPS & Geofence Unit Sekolah')

@section('content')
<div class="space-y-6">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 rounded-3xl p-6 lg:p-8 text-white shadow-2xl border border-emerald-500/40 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-400/20 text-emerald-300 text-xs font-black tracking-wider uppercase border border-emerald-400/40 mb-3">
                    <span>📍</span> Multi-Unit Geofence Manager
                </div>
                <h1 class="text-2xl lg:text-3xl font-black tracking-tight text-white">Pengaturan Titik Koordinat GPS &amp; Radius Presensi</h1>
                <p class="text-emerald-100 text-sm mt-1.5 max-w-2xl font-medium">
                    Tentukan titik koordinat pusat kampus (Latitude &amp; Longitude dari Google Maps) serta radius toleransi presensi selfie untuk masing-masing unit sekolah SIT Robbani.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.mobile.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs border border-slate-700 transition-all flex items-center gap-2">
                    <span>‹</span> Kembali ke Dashboard Mobile
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Success Message -->
    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-900/80 border-2 border-emerald-500 text-white font-bold text-xs flex items-center gap-3 shadow-lg">
        <span class="text-lg">✓</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Google Maps Coordinate Guide Box (Light Mode) -->
    <div class="p-5 rounded-2xl bg-amber-50 border border-amber-300 text-slate-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-xs">
        <div class="flex items-start gap-3">
            <span class="text-2xl">🗺️</span>
            <div>
                <h4 class="text-xs font-black text-amber-900 uppercase tracking-wider">Cara Mengambil Titik Koordinat dari Google Maps:</h4>
                <p class="text-xs text-slate-700 mt-1 leading-relaxed font-semibold">
                    1. Buka <a href="https://maps.google.com" target="_blank" class="underline font-black text-amber-900">Google Maps</a> di browser ➔ 
                    2. Cari lokasi gedung kampus unit sekolah Anda ➔ 
                    3. <strong>Klik kanan</strong> tepat pada atap gedung sekolah ➔ 
                    4. Klik angka koordinat di menu paling atas (misal: <code class="bg-amber-100 text-amber-950 px-1.5 py-0.5 rounded font-mono font-bold">-3.220800, 104.650400</code>) untuk menyalin ➔ 
                    5. Masukkan ke formulir unit di bawah ini lalu klik <strong>Simpan</strong>.
                </p>
            </div>
        </div>
        <a href="https://maps.google.com" target="_blank" class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs shrink-0 shadow-md flex items-center gap-1">
            <span>🌐</span> Buka Google Maps ↗
        </a>
    </div>

    <!-- Grid Unit School Geofences (Pure Light Mode) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($schools as $school)
        <div class="bg-white text-slate-900 rounded-3xl border border-slate-200 shadow-sm p-6 space-y-5">
            <!-- Unit Header -->
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-black text-base border border-emerald-300">
                        {{ $school->code }}
                    </div>
                    <div>
                        <h3 class="text-base font-black text-slate-900">{{ $school->name }}</h3>
                        <span class="text-xs text-slate-500 font-medium">NPSN: {{ $school->npsn ?? '1064xxxx' }} • Unit ID: {{ $school->id }}</span>
                    </div>
                </div>

                <a href="https://www.google.com/maps/search/?api=1&query={{ $school->latitude ?? -3.220800 }},{{ $school->longitude ?? 104.650400 }}" 
                   target="_blank" 
                   class="px-3 py-1.5 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-300 font-bold text-xs border border-emerald-500/40 flex items-center gap-1.5 transition-colors"
                   title="Lihat Titik di Google Maps">
                    <span>📍</span> Cek Pin Peta
                </a>
            </div>

            <!-- Form Edit Geofence (Light Mode) -->
            <form action="{{ route('admin.mobile.geofence.update', $school->id) }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-black text-emerald-900 mb-1.5 uppercase">
                            Titik Latitude (Lintang) *
                        </label>
                        <input type="text" 
                               name="latitude" 
                               value="{{ $school->latitude ?? -3.22080000 }}" 
                               required 
                               placeholder="Contoh: -3.22080000" 
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-50 text-slate-900 font-mono font-black text-xs border border-slate-300 focus:border-emerald-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-emerald-900 mb-1.5 uppercase">
                            Titik Longitude (Bujur) *
                        </label>
                        <input type="text" 
                               name="longitude" 
                               value="{{ $school->longitude ?? 104.65040000 }}" 
                               required 
                               placeholder="Contoh: 104.65040000" 
                               class="w-full px-4 py-2.5 rounded-xl bg-slate-50 text-slate-900 font-mono font-black text-xs border border-slate-300 focus:border-emerald-600 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-emerald-900 mb-1.5 uppercase">
                        Radius Toleransi Presensi (Meter) *
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="number" 
                               name="radius_meters" 
                               value="{{ $school->radius_meters ?? 150 }}" 
                               required 
                               min="20" 
                               max="2000" 
                               step="10" 
                               class="w-36 px-4 py-2.5 rounded-xl bg-slate-50 text-slate-900 font-mono font-black text-xs border border-slate-300 focus:border-emerald-600 focus:outline-none">
                        <span class="text-xs text-slate-600 font-semibold">
                            Meter dari titik pusat (Disarankan: 100 - 250m)
                        </span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-800 mb-1.5 uppercase">
                        Alamat / Keterangan Gedung Kampus
                    </label>
                    <input type="text" 
                           name="address" 
                           value="{{ $school->address ?? 'Jl. Lintas Timur KM 35 Indralaya, Ogan Ilir' }}" 
                           class="w-full px-4 py-2 rounded-xl bg-slate-50 text-slate-900 font-medium text-xs border border-slate-300 focus:border-emerald-600 focus:outline-none">
                </div>

                <div class="pt-2 flex items-center justify-between">
                    <span class="text-[11px] text-slate-500 font-mono">
                        Koordinat Aktif: {{ number_format((float)($school->latitude ?? -3.2208), 6) }}, {{ number_format((float)($school->longitude ?? 104.6504), 6) }}
                    </span>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md transition-all">
                        Simpan Titik Koordinat &amp; Radius ➔
                    </button>
                </div>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection
