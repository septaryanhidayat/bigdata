@extends('admin.layout')

@section('title', 'Pengaturan Titik Koordinat GPS & Geofence Unit Sekolah')

@section('content')
<div class="space-y-6">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 rounded-3xl p-6 lg:p-8 text-white shadow-2xl border border-emerald-500/30 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-400/20 text-emerald-300 text-xs font-black tracking-wider uppercase border border-emerald-400/40 mb-3">
                    <span>📍</span> Multi-Unit Geofence Manager
                </div>
                <h1 class="text-2xl lg:text-3xl font-black tracking-tight">Pengaturan Titik Koordinat GPS &amp; Radius Presensi</h1>
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

    <!-- Google Maps Coordinate Guide Box -->
    <div class="p-5 rounded-2xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/60 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start gap-3">
            <span class="text-2xl">🗺️</span>
            <div>
                <h4 class="text-sm font-extrabold text-amber-900 dark:text-amber-200">Cara Mengambil Koordinat dari Google Maps:</h4>
                <p class="text-xs text-amber-800 dark:text-amber-300/80 mt-0.5 leading-relaxed">
                    1. Buka <a href="https://maps.google.com" target="_blank" class="underline font-black">Google Maps</a> di browser ➔ 
                    2. Cari dan klik kanan pada lokasi gedung sekolah ➔ 
                    3. Klik angka koordinat di paling atas (misal: <code class="bg-amber-200/60 dark:bg-amber-900 px-1 py-0.5 rounded font-mono">-3.220800, 104.650400</code>) untuk menyalinnya ➔ 
                    4. Tempelkan angka pertama ke kolom <strong>Latitude</strong> dan angka kedua ke <strong>Longitude</strong>.
                </p>
            </div>
        </div>
        <a href="https://maps.google.com" target="_blank" class="px-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-500 text-white font-black text-xs shrink-0 shadow-sm">
            Buka Google Maps ↗
        </a>
    </div>

    <!-- Grid Unit School Geofences -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($schools as $school)
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-shadow p-6 space-y-5">
            <!-- Unit Header -->
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-black text-lg border border-emerald-200 dark:border-emerald-800">
                        {{ $school->code }}
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-900 dark:text-white">{{ $school->name }}</h3>
                        <span class="text-xs text-slate-500">NPSN: {{ $school->npsn ?? '1064xxxx' }} • Unit ID: {{ $school->id }}</span>
                    </div>
                </div>

                <a href="https://www.google.com/maps/search/?api=1&query={{ $school->latitude ?? -3.220800 }},{{ $school->longitude ?? 104.650400 }}" 
                   target="_blank" 
                   class="px-3 py-1.5 rounded-xl bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 font-bold text-xs border border-emerald-200 dark:border-emerald-800 flex items-center gap-1.5"
                   title="Lihat Titik di Google Maps">
                    <span>📍</span> Cek Pin Peta
                </a>
            </div>

            <!-- Form Edit Geofence -->
            <form action="{{ route('admin.mobile.geofence.update', $school->id) }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            Titik Latitude (Garis Lintang) *
                        </label>
                        <input type="text" 
                               name="latitude" 
                               value="{{ old('latitude', $school->latitude ?? -3.22080000) }}" 
                               required 
                               placeholder="Contoh: -3.22080000" 
                               class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-mono font-bold">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            Titik Longitude (Garis Bujur) *
                        </label>
                        <input type="text" 
                               name="longitude" 
                               value="{{ old('longitude', $school->longitude ?? 104.65040000) }}" 
                               required 
                               placeholder="Contoh: 104.65040000" 
                               class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-mono font-bold">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                        Radius Toleransi Presensi (Meter) *
                    </label>
                    <div class="flex items-center gap-3">
                        <input type="number" 
                               name="radius_meters" 
                               value="{{ old('radius_meters', $school->radius_meters ?? 150) }}" 
                               required 
                               min="20" 
                               max="2000" 
                               step="10" 
                               class="w-32 px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-bold font-mono">
                        <span class="text-xs text-slate-500 font-semibold">
                            Meter dari titik pusat (Disarankan: 100 - 250m untuk area kampus)
                        </span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                        Alamat Gedung Kampus
                    </label>
                    <input type="text" 
                           name="address" 
                           value="{{ old('address', $school->address ?? 'Jl. Lintas Timur KM 35 Indralaya, Ogan Ilir') }}" 
                           class="w-full px-3.5 py-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-medium">
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs transition-colors shadow-sm flex items-center gap-1.5">
                        <span>💾</span> Simpan Titik Koordinat &amp; Radius
                    </button>
                </div>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection
