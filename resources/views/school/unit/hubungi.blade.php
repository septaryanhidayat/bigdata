@extends('school.unit.layouts.master')

@section('title', 'Hubungi Kami & Layanan Informasi - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Kontak resmi, alamat kampus, layanan WhatsApp hotline, dan lokasi peta ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '. Kami siap melayani informasi pendidikan ananda.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $schoolAddress = $school->address ?? $info['address'] ?? ($codeLower === 'smpit' ? 'Jl. Mayor Iskandar No. 12, Mangga Besar, Prabumulih, Sumatera Selatan' : 'Jl. Lintas Timur KM 35, Indralaya Mulya, Kec. Indralaya, Kab. Ogan Ilir, Sumatera Selatan');
    $schoolPhone = $school->phone ?? $info['phone'] ?? '0812-7170-8899';
    $cleanPhone = preg_replace('/[^0-9]/', '', $schoolPhone);
    $schoolEmail = $school->email ?? $info['email'] ?? ($codeLower . '@sitrobbani.sch.id');
@endphp

@section('content')
{{-- SUBPAGE HERO HEADER --}}
<div class="bg-gradient-to-r {{ $uTheme['nav_gradient'] }} border-b border-indigo-950 text-white py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-indigo-200 mb-2.5 sm:mb-3 flex items-center space-x-2 overflow-x-auto no-scrollbar whitespace-nowrap">
            <a href="{{ url('/unit/' . $codeLower) }}" class="hover:text-white transition shrink-0">Beranda</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold shrink-0">Hubungi Kami</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Hubungi Kami &amp; Layanan Informasi</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Pintu komunikasi terbuka bagi orang tua, calon siswa, dan masyarakat untuk berkonsultasi seputar pendidikan di {{ $info['name'] }}.
        </p>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14">
    
    {{-- 4 CONTACT CARDS ROW --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-12">
        
        {{-- CARD 1: ALAMAT --}}
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 flex flex-col justify-between reveal-fade-up">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-slate-50 text-unit-primary flex items-center justify-center text-xl mb-4 border border-indigo-100">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h4 class="text-xs font-black uppercase tracking-wider text-gray-400 mb-1">Alamat Kampus</h4>
                <p class="text-xs text-gray-800 font-medium leading-relaxed">
                    {{ $schoolAddress }}
                </p>
            </div>
            <div class="pt-4 mt-4 border-t border-gray-50">
                <span class="text-[11px] font-bold text-unit-primary flex items-center gap-1">
                    <span>Lihat Peta di Bawah</span>
                    <i class="fa-solid fa-arrow-down text-[10px]"></i>
                </span>
            </div>
        </div>

        {{-- CARD 2: TELEPON / WHATSAPP --}}
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 flex flex-col justify-between reveal-fade-up">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl mb-4 border border-emerald-100">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <h4 class="text-xs font-black uppercase tracking-wider text-gray-400 mb-1">WhatsApp &amp; Telepon</h4>
                <p class="text-sm font-bold text-gray-900">
                    {{ $schoolPhone }}
                </p>
                <p class="text-[11px] text-gray-500 mt-1">Layanan respon cepat pada jam operasional kerja.</p>
            </div>
            <div class="pt-4 mt-4 border-t border-gray-50">
                <a href="https://wa.me/{{ $cleanPhone }}?text=Assalamu%27alaikum%20Humas%20{{ urlencode($info['name']) }}%2C%20saya%20ingin%20berkonsultasi." 
                   target="_blank" rel="noopener"
                   class="text-[11px] font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1">
                    <span>Chat WhatsApp Langsung</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                </a>
            </div>
        </div>

        {{-- CARD 3: EMAIL --}}
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 flex flex-col justify-between reveal-fade-up">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl mb-4 border border-blue-100">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <h4 class="text-xs font-black uppercase tracking-wider text-gray-400 mb-1">Email Resmi</h4>
                <p class="text-xs font-bold text-gray-900 break-all">
                    {{ $schoolEmail }}
                </p>
                <p class="text-[11px] text-gray-500 mt-1">Korespondensi surat menyurat dan MoU kemitraan.</p>
            </div>
            <div class="pt-4 mt-4 border-t border-gray-50">
                <a href="mailto:{{ $schoolEmail }}" 
                   class="text-[11px] font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    <span>Kirim Email Resmi</span>
                    <i class="fa-solid fa-paper-plane text-[10px]"></i>
                </a>
            </div>
        </div>

        {{-- CARD 4: JAM OPERASIONAL --}}
        <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 flex flex-col justify-between reveal-fade-up">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl mb-4 border border-amber-100">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <h4 class="text-xs font-black uppercase tracking-wider text-gray-400 mb-1">Jam Pelayanan TU</h4>
                <p class="text-xs font-bold text-gray-900">
                    Senin - Sabtu
                </p>
                <p class="text-[11px] text-gray-500 mt-1">07.30 - 16.00 WIB (Sabtu s.d 13.00 WIB)</p>
            </div>
            <div class="pt-4 mt-4 border-t border-gray-50">
                <span class="text-[11px] font-bold text-amber-600 flex items-center gap-1">
                    <i class="fa-solid fa-circle text-[8px]"></i>
                    <span>Buka pada Hari Kerja</span>
                </span>
            </div>
        </div>

    </div>

    {{-- MAIN GRID: FORM & MAPS EMBED --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
        
        {{-- CONTACT FORM (7/12) --}}
        <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-gray-100 reveal-fade-up">
                <div class="border-b border-gray-100 pb-5 mb-6">
                    <span class="text-xs font-black uppercase tracking-wider text-unit-primary block mb-1">
                        Layanan Pengaduan &amp; Aspirasi
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">
                        Kirim Pesan &amp; Konsultasi Online
                    </h2>
                    <p class="text-xs text-gray-500 mt-1">
                        Sampaikan pertanyaan mengenai SPMB, mutasi siswa, biaya pendidikan, atau saran membangun bagi sekolah.
                    </p>
                </div>

                {{-- FORM WITH DIRECT WHATSAPP / SIMULATED SEND --}}
                <form action="https://wa.me/{{ $cleanPhone }}" method="GET" target="_blank"
                      onsubmit="event.preventDefault(); const n = document.getElementById('cf_name').value; const k = document.getElementById('cf_kategori').value; const p = document.getElementById('cf_pesan').value; const url = 'https://wa.me/{{ $cleanPhone }}?text=' + encodeURIComponent('Halo Humas {{ $info['name'] }},\n\nNama: ' + n + '\nKategori: ' + k + '\nPesan: ' + p); window.open(url, '_blank');"
                      class="space-y-4">
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Nama Lengkap Anda <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="cf_name" required
                               placeholder="Nama lengkap wali murid / calon pendaftar"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-unit-primary transition">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                No. WhatsApp / HP <span class="text-rose-500">*</span>
                            </label>
                            <input type="tel" id="cf_hp" required
                                   placeholder="08xxxxxxxxxx"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-unit-primary transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                Kategori Informasi <span class="text-rose-500">*</span>
                            </label>
                            <select id="cf_kategori" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-unit-primary transition">
                                <option value="Informasi SPMB & Pendaftaran">Informasi SPMB &amp; Pendaftaran Siswa Baru</option>
                                <option value="Biaya Pendidikan & E-SPP">Biaya Pendidikan &amp; E-SPP</option>
                                <option value="Konsultasi Tahfidz & Akademik">Konsultasi Tahfidz &amp; Akademik JSIT</option>
                                <option value="Layanan Administrasi & TU">Layanan Administrasi &amp; Ijazah/Mutasi</option>
                                <option value="Kritik, Saran & Aspirasi">Kritik, Saran &amp; Aspirasi Wali Murid</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Isi Pesan / Pertanyaan Anda <span class="text-rose-500">*</span>
                        </label>
                        <textarea id="cf_pesan" rows="4" required
                                  placeholder="Tuliskan pertanyaan atau pesan Anda secara rinci agar tim kami dapat memberikan penjelasan terbaik..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-unit-primary transition"></textarea>
                    </div>

                    <div class="pt-3 flex items-center justify-between gap-4">
                        <span class="text-[11px] text-gray-400">
                            <i class="fa-brands fa-whatsapp text-emerald-500"></i> Langsung tersambung ke WhatsApp Humas.
                        </span>
                        <button type="submit" 
                                class="px-7 py-3 rounded-xl text-xs font-bold text-white bg-unit-primary hover:opacity-90 shadow-md transition flex items-center gap-2">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                            <span>Kirim ke WhatsApp Humas</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>

        {{-- GOOGLE MAPS & SOCIAL MEDIA (5/12) --}}
        <div class="lg:col-span-5 space-y-6">
            
            {{-- GOOGLE MAPS EMBED --}}
            <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 reveal-fade-up">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-black uppercase tracking-wider text-unit-primary flex items-center gap-2">
                        <i class="fa-solid fa-map-location-dot"></i>
                        Peta Lokasi Kampus
                    </h3>
                    <a href="https://maps.google.com/?q={{ urlencode($schoolAddress) }}" target="_blank" rel="noopener" class="text-[11px] font-bold text-unit-primary hover:underline">
                        Buka di Google Maps <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                    </a>
                </div>
                
                <div class="w-full h-64 rounded-2xl overflow-hidden border border-gray-200 bg-gray-100 shadow-inner">
                    <iframe 
                        src="https://maps.google.com/maps?q={{ urlencode($schoolAddress) }}&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <p class="text-[11px] text-gray-500 mt-3 flex items-center gap-1.5">
                    <i class="fa-solid fa-route text-unit-primary"></i>
                    <span>Mudah dijangkau dengan kendaraan pribadi maupun angkutan umum kota.</span>
                </p>
            </div>

            {{-- MEDIA SOSIAL RESMI --}}
            <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 reveal-fade-up">
                <h4 class="text-xs font-black uppercase tracking-wider text-gray-900 mb-3">Ikuti Media Sosial Resmi</h4>
                <div class="grid grid-cols-2 gap-2.5">
                    <a href="https://instagram.com" target="_blank" rel="noopener" class="flex items-center gap-2.5 p-3 rounded-xl bg-pink-50 text-pink-700 hover:bg-pink-100 transition text-xs font-bold">
                        <i class="fa-brands fa-instagram text-base"></i>
                        <span>Instagram</span>
                    </a>
                    <a href="https://youtube.com" target="_blank" rel="noopener" class="flex items-center gap-2.5 p-3 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 transition text-xs font-bold">
                        <i class="fa-brands fa-youtube text-base"></i>
                        <span>YouTube</span>
                    </a>
                    <a href="https://facebook.com" target="_blank" rel="noopener" class="flex items-center gap-2.5 p-3 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 transition text-xs font-bold">
                        <i class="fa-brands fa-facebook text-base"></i>
                        <span>Facebook</span>
                    </a>
                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" rel="noopener" class="flex items-center gap-2.5 p-3 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition text-xs font-bold">
                        <i class="fa-brands fa-whatsapp text-base"></i>
                        <span>WhatsApp</span>
                    </a>
                </div>
            </div>

            {{-- SPMB BANNER --}}
            <div class="bg-gradient-to-br from-amber-500 to-amber-600 text-gray-950 rounded-3xl p-6 shadow-xl space-y-2.5">
                <span class="text-[10px] font-black uppercase tracking-wider bg-black/15 px-2.5 py-0.5 rounded-full inline-block">
                    Penerimaan Siswa Baru (SPMB)
                </span>
                <h4 class="text-base font-black leading-snug">Daftarkan Putra-Putri Anda Sekarang!</h4>
                <p class="text-xs font-medium opacity-90 leading-relaxed">
                    Kuota terbatas untuk kelas tahfidz dan reguler. Dapatkan diskon infaq pengembangan bagi pendaftar gelombang pertama.
                </p>
                <div class="pt-2">
                    <a href="{{ route('school.ppdb') }}" class="inline-block py-2.5 px-5 rounded-xl text-xs font-black bg-gray-950 text-white hover:bg-gray-800 shadow-md transition">
                        Daftar SPMB Online <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
