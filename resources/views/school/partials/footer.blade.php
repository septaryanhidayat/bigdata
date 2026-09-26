<!-- FOOTER SECTION (EXECUTIVE UNIFIED 4-COLUMN) -->
<footer class="bg-gradient-to-b from-[#003828] via-[#002b1f] to-[#011a13] text-white pt-12 sm:pt-16 pb-8 border-t border-emerald-900/80 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-10 pb-10 sm:pb-12 text-center md:text-left">
            
            <!-- Col 1: Identitas Resmi Sekolah -->
            <div class="space-y-4 flex flex-col items-center md:items-start">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                    <img alt="SIT Robbani Logo" width="180" height="48" loading="lazy" class="h-10 sm:h-12 w-auto object-contain" src="{{ $settings['logo_light'] ?? '/images/logo-robbani-official.png' }}" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                </a>

                <!-- Tagline Badge Pill (Rapi & Elegan) -->
                <div class="inline-flex flex-wrap items-center justify-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-950/90 border border-emerald-500/40 text-[10px] font-black tracking-wide uppercase text-white shadow-inner mx-auto md:mx-0">
                    <span class="text-amber-400">⚡ MANDIRI</span>
                    <span class="text-emerald-500">•</span>
                    <span class="text-emerald-300">📖 PINTER NGAJI</span>
                    <span class="text-emerald-500">•</span>
                    <span class="text-cyan-300">💻 JAGO IT!</span>
                </div>

                <p class="text-xs text-slate-300/90 leading-relaxed font-normal text-center md:text-left max-w-sm">
                    {{ $settings['school_name'] ?? 'Sekolah Islam Terpadu Robbani' }} — Lembaga pendidikan Islam terpadu pelopor karakter Qur'ani, sains modern, dan teknologi digital di Kabupaten Ogan Ilir, Sumatera Selatan.
                </p>

                <!-- Kontak Card List (Rapi, Sejajar, Tidak Berantakan di HP) -->
                <div class="pt-1 text-xs text-slate-300 space-y-2 w-full max-w-sm">
                    <div class="flex items-start gap-2.5 text-left bg-emerald-950/60 border border-emerald-900/60 p-2.5 rounded-xl shadow-xs">
                        <span class="w-6 h-6 rounded-md bg-emerald-900 border border-emerald-700/60 text-amber-400 flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                            <span class="material-symbols-outlined text-[15px]">location_on</span>
                        </span>
                        <span class="text-[11px] leading-snug text-slate-200">KPA SIT Robbani: Jl. Sarjana Blok A.25, Timbangan, Indralaya, Kab. Ogan Ilir</span>
                    </div>

                    <div class="flex items-center gap-2.5 text-left bg-emerald-950/60 border border-emerald-900/60 p-2.5 rounded-xl shadow-xs">
                        <span class="w-6 h-6 rounded-md bg-emerald-900 border border-emerald-700/60 text-amber-400 flex items-center justify-center shrink-0 shadow-xs">
                            <span class="material-symbols-outlined text-[15px]">call</span>
                        </span>
                        <a href="https://wa.me/62811747472" target="_blank" class="text-[11px] font-bold text-slate-200 hover:text-amber-300 transition-colors">Hotline/WA: 0811-747-472</a>
                    </div>

                    <div class="flex items-center gap-2.5 text-left bg-emerald-950/60 border border-emerald-900/60 p-2.5 rounded-xl shadow-xs">
                        <span class="w-6 h-6 rounded-md bg-emerald-900 border border-emerald-700/60 text-amber-400 flex items-center justify-center shrink-0 shadow-xs">
                            <span class="material-symbols-outlined text-[15px]">mail</span>
                        </span>
                        <a href="mailto:{{ $settings['school_email'] ?? 'info@sitrobbani.sch.id' }}" class="text-[11px] text-slate-200 hover:text-amber-300 transition-colors truncate">{{ $settings['school_email'] ?? 'info@sitrobbani.sch.id' }}</a>
                    </div>
                </div>
            </div>

            <!-- Col 2: Unit Pendidikan -->
            <div class="space-y-3 sm:space-y-4 flex flex-col items-center md:items-start">
                <h3 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wider font-headline border-b border-emerald-500/40 pb-1.5 inline-block mx-auto md:mx-0">Unit Pendidikan</h3>
                <ul class="space-y-2 text-[11px] sm:text-xs text-slate-300 flex flex-col items-center md:items-start">
                    <li><a href="{{ route('school.unit', 'tkit') }}" class="hover:text-amber-300 hover:translate-x-1 inline-flex items-center gap-1.5 transition-all"><span>🎓</span> <span>KB / TKIT Robbani</span></a></li>
                    <li><a href="{{ route('school.unit', 'sdit') }}" class="hover:text-amber-300 hover:translate-x-1 inline-flex items-center gap-1.5 transition-all"><span>🏫</span> <span>SDIT Robbani</span></a></li>
                    <li><a href="{{ route('school.unit', 'smpit') }}" class="hover:text-amber-300 hover:translate-x-1 inline-flex items-center gap-1.5 transition-all"><span>🎒</span> <span>SMPIT Robbani</span></a></li>
                    <li><a href="{{ route('school.unit', 'smait') }}" class="hover:text-amber-300 hover:translate-x-1 inline-flex items-center gap-1.5 transition-all"><span>🏛️</span> <span>SMAIT Robbani</span></a></li>
                </ul>
            </div>

            <!-- Col 3: Navigasi Portal -->
            <div class="space-y-3 sm:space-y-4 flex flex-col items-center md:items-start">
                <h3 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wider font-headline border-b border-emerald-500/40 pb-1.5 inline-block mx-auto md:mx-0">Navigasi Portal</h3>
                <ul class="space-y-2 text-[11px] sm:text-xs text-slate-300 flex flex-col items-center md:items-start">
                    <li><a href="{{ route('home') }}" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">Beranda Utama</a></li>
                    <li><a href="{{ route('school.profil') }}" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">Profil Yayasan</a></li>
                    <li><a href="{{ route('school.layanan') }}" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">Layanan Publik Terpadu</a></li>
                    <li><a href="{{ route('school.fasilitas') }}" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">Fasilitas Sekolah</a></li>
                    <li><a href="{{ route('school.berita') }}" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">Berita Kampus</a></li>
                    <li><a href="{{ route('school.artikel') }}" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">Artikel Edukasi</a></li>
                </ul>
            </div>

            <!-- Col 4: Layanan & Social Media -->
            <div class="space-y-3 sm:space-y-4 flex flex-col items-center md:items-start">
                <h3 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wider font-headline border-b border-emerald-500/40 pb-1.5 inline-block mx-auto md:mx-0">Layanan &amp; Medsos</h3>
                <ul class="space-y-2 text-[11px] sm:text-xs text-slate-300 mb-3 flex flex-col items-center md:items-start">
                    <li><a href="{{ route('school.spmb') }}" class="text-amber-400 font-bold hover:underline inline-flex items-center gap-1"><span>✨</span> <span>SPMB Online 2026/2027</span></a></li>
                    <li><a href="{{ route('school.layanan.kunjungan') }}" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">Izin Kunjungan Sekolah</a></li>
                    <li><a href="{{ route('school.layanan.kerjasama') }}" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">Permohonan Kerja Sama</a></li>
                    <li><a href="{{ route('school.layanan.sewa') }}" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">Pemanfaatan Sarana &amp; Fasilitas</a></li>
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-300 hover:underline font-bold inline-flex items-center gap-1"><span>🔐</span> <span>Portal Login Guru & Admin</span></a></li>
                </ul>

                <div class="pt-2 border-t border-emerald-800/80 w-full flex flex-col items-center md:items-start">
                    <span class="text-[10px] sm:text-[11px] font-semibold text-slate-300 block mb-2 text-center md:text-left">Ikuti Media Sosial:</span>
                    <div class="flex items-center justify-center md:justify-start gap-2.5">
                        <a href="https://www.youtube.com/@sitrobbanioganilir8496" target="_blank" aria-label="Kunjungi YouTube Channel SIT Robbani" class="w-9 h-9 rounded-full bg-emerald-900/80 hover:bg-red-600 text-white flex items-center justify-center transition-all hover:scale-110 shadow-md" title="SIT Robbani YouTube Channel">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        <a href="https://instagram.com" target="_blank" aria-label="Kunjungi Instagram SIT Robbani" class="w-9 h-9 rounded-full bg-emerald-900/80 hover:bg-pink-600 text-white flex items-center justify-center transition-all hover:scale-110 shadow-md" title="Instagram">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="https://facebook.com" target="_blank" aria-label="Kunjungi Facebook SIT Robbani" class="w-9 h-9 rounded-full bg-emerald-900/80 hover:bg-blue-600 text-white flex items-center justify-center transition-all hover:scale-110 shadow-md" title="Facebook">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.592 0 9 1.583 9 4.615V8z"/></svg>
                        </a>
                        <a href="https://api.whatsapp.com/send?phone=62811747472" target="_blank" aria-label="Hubungi WhatsApp Admin SIT Robbani" class="w-9 h-9 rounded-full bg-emerald-900/80 hover:bg-emerald-600 text-white flex items-center justify-center transition-all hover:scale-110 shadow-md" title="WhatsApp Admin">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Copyright & Credit Bar -->
        <div class="pt-6 sm:pt-8 border-t border-emerald-900/80 flex flex-col md:flex-row justify-between items-center gap-3 sm:gap-4 text-center md:text-left text-slate-400 text-[11px] sm:text-xs">
            <p>© {{ date('Y') }} {{ $settings['school_name'] ?? 'SIT Robbani' }} (SIT Robbani Ogan Ilir, Sumsel). All rights reserved.</p>
            <a href="https://berandadigital.net" target="_blank" class="text-amber-400 hover:underline font-bold inline-flex items-center gap-1.5 bg-slate-900/90 px-3.5 py-1.5 rounded-full border border-emerald-800 hover:border-amber-400 transition-all text-[11px]">
                <span>Powered by Beranda Teknologi Digital</span>
            </a>
        </div>
    </div>
</footer>

{{-- FLOATING GOOGLE TRANSLATE (KIRI BAWAH) --}}
@include('components.floating-translate')
