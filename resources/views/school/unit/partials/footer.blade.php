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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-8 pb-12 border-b border-slate-800/80 text-left">
            
            {{-- KOLOM 1: LOGO & IDENTITAS SEKOLAH (3 Kolom) --}}
            <div class="lg:col-span-3 flex flex-col items-start space-y-4">
                <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl bg-white p-3 shadow-xl border border-white/20 flex items-center justify-center shrink-0">
                    <img src="{{ asset($info['logo'] ?? '/images/logo-robbani-official.png') }}" 
                         alt="{{ $info['name'] }}" 
                         class="max-h-full max-w-full object-contain"
                         onerror="this.src='/images/logo-robbani-official.png'">
                </div>
                <div class="space-y-1.5">
                    <p class="text-sm font-bold text-white tracking-wide">
                        {{ $info['name'] }}
                    </p>
                    <p class="text-xs text-slate-400 leading-relaxed font-light">
                        {{ $info['tagline'] ?? 'Membina Generasi Qur\'ani, Cerdas & Berakhlak Mulia' }}
                    </p>
                    <div class="pt-2 flex flex-wrap gap-2">
                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/10 text-amber-300 border border-white/10">
                            NPSN: {{ $info['npsn'] ?? '69787455' }}
                        </span>
                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/10 text-emerald-300 border border-white/10">
                            {{ $info['akreditasi'] ?? 'Terakreditasi B' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- KOLOM 2: TAUTAN PROFIL & AKADEMIK (3 Kolom) --}}
            <div class="lg:col-span-3 space-y-3">
                <h4 class="text-xs font-black uppercase tracking-wider text-amber-400 flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>Tautan Cepat</span>
                </h4>
                <ul class="space-y-2 text-xs text-slate-300">
                    <li>
                        <a href="{{ url('/unit/' . $codeLower . '/sambutan') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-angle-right text-[10px] text-amber-400"></i> Sambutan Kepala Sekolah
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/unit/' . $codeLower . '/profil') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-angle-right text-[10px] text-amber-400"></i> Profil &amp; Sejarah
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/unit/' . $codeLower . '/visi-misi') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-angle-right text-[10px] text-amber-400"></i> Visi &amp; Misi Sekolah
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/unit/' . $codeLower . '/dewan-guru') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-angle-right text-[10px] text-amber-400"></i> Dewan Guru &amp; GTK
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/unit/' . $codeLower . '/struktur-organisasi') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-angle-right text-[10px] text-amber-400"></i> Struktur Organisasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/unit/' . $codeLower . '/fasilitas') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-angle-right text-[10px] text-amber-400"></i> Fasilitas &amp; Sarana
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/unit/' . $codeLower . '/program-unggulan') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-angle-right text-[10px] text-amber-400"></i> Program Unggulan
                        </a>
                    </li>
                </ul>
            </div>

            {{-- KOLOM 3: LAYANAN & DOKUMEN (3 Kolom) --}}
            <div class="lg:col-span-3 space-y-3">
                <h4 class="text-xs font-black uppercase tracking-wider text-amber-400 flex items-center gap-2">
                    <i class="fa-solid fa-folder-tree"></i>
                    <span>Layanan &amp; Unduhan</span>
                </h4>
                <ul class="space-y-2 text-xs text-slate-300">
                    <li>
                        <a href="{{ url('/unit/' . $codeLower . '/download') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-angle-right text-[10px] text-amber-400"></i> Pusat Unduhan Berkas
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/unit/' . $codeLower . '/e-book') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-angle-right text-[10px] text-amber-400"></i> E-Book &amp; Modul Ajar
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/unit/' . $codeLower . '/hymne-mars') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-angle-right text-[10px] text-amber-400"></i> Mars JSIT Indonesia
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/unit/' . $codeLower . '/logo') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-angle-right text-[10px] text-amber-400"></i> Logo &amp; Identitas Resmi
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/unit/' . $codeLower . '/layanan') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-angle-right text-[10px] text-amber-400"></i> Portal Layanan Terpadu
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/unit/' . $codeLower . '/layanan/kunjungan') }}" class="hover:text-amber-300 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-angle-right text-[10px] text-amber-400"></i> Izin Kunjungan Sekolah
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" class="text-amber-400 font-bold hover:underline transition flex items-center gap-1.5">
                            <i class="fa-solid fa-graduation-cap text-[11px]"></i> Pendaftaran SPMB Online
                        </a>
                    </li>
                </ul>
            </div>

            {{-- KOLOM 4: ALAMAT & KONTAK (3 Kolom) --}}
            <div class="lg:col-span-3 space-y-3">
                <h4 class="text-xs font-black uppercase tracking-wider text-amber-400 flex items-center gap-2">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <span>Alamat &amp; Kontak</span>
                </h4>
                <p class="text-xs text-slate-300 leading-relaxed">
                    {{ $info['address'] ?? 'Jalan Sarjana Kompleks SIT Robbani, Indralaya Utara, Kabupaten Ogan Ilir, Sumatera Selatan' }}
                </p>
                <div class="space-y-2 pt-1 text-xs">
                    <div class="flex items-center space-x-2.5">
                        <i class="fa-solid fa-phone text-amber-400 w-4"></i>
                        <span>{{ $info['phone'] ?? '0811747472' }}</span>
                    </div>
                    <div class="flex items-center space-x-2.5">
                        <i class="fa-brands fa-whatsapp text-amber-400 w-4"></i>
                        <span>{{ $info['whatsapp'] ?? $info['phone'] ?? '0811747472' }}</span>
                    </div>
                    <div class="flex items-center space-x-2.5">
                        <i class="fa-solid fa-envelope text-amber-400 w-4"></i>
                        <span class="truncate max-w-[200px]">{{ $info['email'] ?? 'info@sitrobbani.sch.id' }}</span>
                    </div>
                </div>

                {{-- MEDIA SOSIAL ICONS --}}
                <div class="pt-2 flex items-center space-x-2.5">
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" 
                       class="w-8 h-8 rounded-full bg-white text-slate-900 flex items-center justify-center hover:bg-amber-400 hover:scale-110 transition shadow" 
                       aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f text-xs"></i>
                    </a>
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" 
                       class="w-8 h-8 rounded-full bg-white text-slate-900 flex items-center justify-center hover:bg-amber-400 hover:scale-110 transition shadow" 
                       aria-label="Instagram">
                        <i class="fa-brands fa-instagram text-xs"></i>
                    </a>
                    <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" 
                       class="w-8 h-8 rounded-full bg-white text-slate-900 flex items-center justify-center hover:bg-amber-400 hover:scale-110 transition shadow" 
                       aria-label="YouTube">
                        <i class="fa-brands fa-youtube text-xs"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?phone=62{{ ltrim($info['whatsapp'] ?? $info['phone'] ?? '85269908696', '0') }}" target="_blank" rel="noopener noreferrer" 
                       class="w-8 h-8 rounded-full bg-white text-slate-900 flex items-center justify-center hover:bg-amber-400 hover:scale-110 transition shadow" 
                       aria-label="WhatsApp">
                        <i class="fa-brands fa-whatsapp text-xs"></i>
                    </a>
                </div>

                <div class="pt-2 flex items-center space-x-3 text-xs text-slate-400 font-medium">
                    <a href="{{ url('/unit/' . $codeLower . '/profil') }}" class="hover:text-amber-400 transition">Kebijakan Privasi</a>
                    <span>•</span>
                    <a href="{{ url('/unit/' . $codeLower . '/hubungi') }}" class="hover:text-amber-400 transition">Peta Lokasi</a>
                </div>
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
