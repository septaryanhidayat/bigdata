@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
@endphp

<footer class="bg-[#0b1220] text-slate-300 pt-12 border-t border-slate-800 relative z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        {{-- BULETIN & KABAR SEKOLAH (Newsletter Subscription Bar) --}}
        <div class="bg-gradient-to-r from-indigo-950 via-slate-900 to-blue-950 rounded-3xl p-6 sm:p-8 border border-indigo-900/60 shadow-2xl flex flex-col lg:flex-row items-center justify-between gap-6">
            <div class="space-y-1 text-center lg:text-left">
                <span class="inline-block text-[11px] font-black uppercase tracking-wider text-amber-400">
                    Buletin &amp; Kabar Sekolah
                </span>
                <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                    Dapatkan Info &amp; Pengumuman Terupdate
                </h3>
            </div>
            <form onsubmit="event.preventDefault(); alert('Terima kasih! Email Anda telah terdaftar untuk menerima info terupdate.'); this.reset();" 
                  class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto max-w-md">
                <input type="email" 
                       required
                       placeholder="Masukkan Email Anda" 
                       class="w-full sm:w-72 px-5 py-3 rounded-full bg-white text-slate-800 placeholder-slate-400 text-xs font-medium focus:outline-none focus:ring-2 focus:ring-amber-400 border-0 shadow-inner">
                <button type="submit" 
                        class="w-full sm:w-auto px-7 py-3 rounded-full bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950 font-black text-xs uppercase tracking-wider shadow-lg shadow-amber-500/30 hover:shadow-amber-500/50 hover:brightness-105 active:scale-95 transition flex items-center justify-center space-x-2 shrink-0">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Langganan</span>
                </button>
            </form>
        </div>

        {{-- MAIN INSTITUTIONAL FOOTER GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10 pb-12 border-b border-slate-800/80">
            
            {{-- KOLOM 1: LOGO SEKOLAH (3 Kolom) --}}
            <div class="lg:col-span-3 flex flex-col items-center sm:items-start space-y-4 text-center sm:text-left">
                <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-3xl bg-white p-3 shadow-xl border border-white/20 flex items-center justify-center">
                    <img src="{{ asset($info['logo'] ?? '/uploads/logo-ishum-square.png') }}" 
                         alt="{{ $info['name'] }}" 
                         class="max-h-full max-w-full object-contain"
                         onerror="this.src='/uploads/logo-ishum-square.png'">
                </div>
                <div class="space-y-1">
                    <p class="text-xs font-bold text-white tracking-wide">
                        {{ $info['name'] }}
                    </p>
                    <p class="text-[11px] text-slate-400 leading-relaxed font-light">
                        {{ $info['tagline'] ?? 'Membina Generasi Qur\'ani, Cerdas & Berakhlak Mulia' }}
                    </p>
                </div>
            </div>

            {{-- KOLOM 2: ALAMAT KAMPUS (4 Kolom) --}}
            <div class="lg:col-span-4 space-y-3 flex flex-col items-center sm:items-start text-center sm:text-left">
                <h4 class="text-xs font-black uppercase tracking-wider text-amber-400 flex items-center gap-2">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <span>Alamat Kampus</span>
                </h4>
                <p class="text-xs text-slate-300 leading-relaxed max-w-sm">
                    {{ $info['address'] ?? ($codeLower === 'smpit' ? 'Jalan Sadewa No. 45 RT 01 RW 04 Kelurahan Karang Raja, Kecamatan Prabumulih Timur, Kota Prabumulih, Sumatera Selatan 31113' : 'Jalan Sarjana Kompleks SIT Robbani, Indralaya Utara, Kabupaten Ogan Ilir, Sumatera Selatan') }}
                </p>
                <div class="space-y-2 pt-2 text-xs flex flex-col items-center sm:items-start">
                    <div class="flex items-center space-x-2.5">
                        <i class="fa-solid fa-phone text-amber-400 w-4"></i>
                        <span>{{ $info['phone'] ?? '0852-6990-8696' }}</span>
                    </div>
                    <div class="flex items-center space-x-2.5">
                        <i class="fa-brands fa-whatsapp text-amber-400 w-4"></i>
                        <span>{{ $info['whatsapp'] ?? $info['phone'] ?? '0853-7897-4396' }}</span>
                    </div>
                    <div class="flex items-center space-x-2.5">
                        <i class="fa-solid fa-envelope text-amber-400 w-4"></i>
                        <span class="truncate max-w-[220px] sm:max-w-none">{{ $info['email'] ?? 'smpitishlahulummah.2015@yahoo.com' }}</span>
                    </div>
                </div>
            </div>

            {{-- KOLOM 3: MEDIA SOSIAL (3 Kolom) --}}
            <div class="lg:col-span-3 space-y-3 flex flex-col items-center sm:items-start text-center sm:text-left">
                <h4 class="text-xs font-black uppercase tracking-wider text-amber-400 flex items-center gap-2">
                    <i class="fa-solid fa-share-nodes"></i>
                    <span>Media Sosial</span>
                </h4>
                <p class="text-xs font-bold text-white">
                    {{ $info['name'] }}
                </p>
                <div class="flex items-center space-x-3 pt-1">
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 rounded-full bg-white text-slate-900 flex items-center justify-center hover:bg-amber-400 hover:scale-110 transition shadow" 
                       aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f text-sm"></i>
                    </a>
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 rounded-full bg-white text-slate-900 flex items-center justify-center hover:bg-amber-400 hover:scale-110 transition shadow" 
                       aria-label="Instagram">
                        <i class="fa-brands fa-instagram text-sm"></i>
                    </a>
                    <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 rounded-full bg-white text-slate-900 flex items-center justify-center hover:bg-amber-400 hover:scale-110 transition shadow" 
                       aria-label="YouTube">
                        <i class="fa-brands fa-youtube text-sm"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?phone=62{{ ltrim($info['whatsapp'] ?? $info['phone'] ?? '85269908696', '0') }}" target="_blank" rel="noopener noreferrer" 
                       class="w-9 h-9 rounded-full bg-white text-slate-900 flex items-center justify-center hover:bg-amber-400 hover:scale-110 transition shadow" 
                       aria-label="WhatsApp">
                        <i class="fa-brands fa-whatsapp text-sm"></i>
                    </a>
                </div>
                <div class="pt-2">
                    <span class="text-xs text-slate-300 flex items-center gap-1.5 font-medium">
                        <i class="fa-solid fa-globe text-amber-400"></i>
                        <span>{{ $info['domain'] ?? ($codeLower === 'smpit' ? 'smpitishum.sch.id' : 'sitrobbani.sch.id') }}</span>
                    </span>
                </div>
            </div>

            {{-- KOLOM 4: PENGUNJUNG (2 Kolom) --}}
            <div class="lg:col-span-2 space-y-3 flex flex-col items-center sm:items-start text-center sm:text-left">
                <div class="flex items-center space-x-2">
                    <h4 class="text-xs font-black uppercase tracking-wider text-amber-400">
                        Pengunjung
                    </h4>
                    <span class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-indigo-950 text-amber-300 border border-amber-400/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                        <span>Live</span>
                    </span>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                        {{ number_format($info['visitor_count'] ?? 12916, 0, ',', '.') }}
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1 font-light">
                        Kunjungan ke website resmi sekolah
                    </p>
                </div>
                <div class="pt-2 flex items-center space-x-3 text-xs text-slate-400 font-medium">
                    <a href="{{ url('/unit/' . $codeLower . '/profil') }}" class="hover:text-amber-400 transition">Kebijakan Privasi</a>
                    <span>•</span>
                    <a href="{{ url('/unit/' . $codeLower . '#kontak') }}" class="hover:text-amber-400 transition">Kontak</a>
                </div>
            </div>

        </div>

        {{-- BOTTOM SUB-FOOTER BAR --}}
        <div class="pb-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left text-xs text-slate-500">
            <div>
                Copyright &copy; 2026 <strong class="text-slate-400 font-semibold">{{ $info['name'] }}</strong>. All Rights Reserved.
            </div>
            <div>
                <span class="text-slate-400 font-semibold">Beranda Teknologi Digital</span>
            </div>
        </div>

    </div>
</footer>
