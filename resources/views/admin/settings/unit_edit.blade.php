@extends('admin.layout')

@section('title', 'Kelola Lengkap Web Unit ' . strtoupper($cleanCode))

@section('content')
@php
    $teachersList = $unitData['teachers'] ?? [];
    $programsList = $unitData['programs'] ?? [];
    $facilitiesList = $unitData['facilities'] ?? [];
    $ekskulList = $unitData['ekskul'] ?? [];
    $prestasiList = $unitData['prestasi'] ?? [];
    $agendaList = $unitData['agenda'] ?? [];
    $announcementsList = $unitData['announcements'] ?? [];
    $galleryList = $unitData['gallery'] ?? [];
    $videosList = $unitData['videos'] ?? [];
    $alumniList = $unitData['alumni'] ?? [];
    $downloadsList = $unitData['downloads'] ?? [];
    $ebooksList = $unitData['ebooks'] ?? [];
    $orgStructure = $unitData['org_structure'] ?? [];
    $orgWaka = $orgStructure['waka_list'] ?? [];
    $orgStaff = $orgStructure['technical_staff'] ?? [];
    $logoInfo = $unitData['logo_info'] ?? [];
    $logoComponents = $logoInfo['components'] ?? [];
    $hymneMars = $unitData['hymne_mars'] ?? [];
    $historyData = $unitData['history'] ?? [];
    $socialsData = $unitData['socials'] ?? [];

    $formattedMissions = '';
    if (isset($unitData['missions']) && is_array($unitData['missions'])) {
        $mLines = [];
        foreach ($unitData['missions'] as $m) {
            if (is_array($m)) {
                $t = trim($m['title'] ?? '');
                $d = trim($m['desc'] ?? '');
                $mLines[] = (!empty($t) && !empty($d)) ? ($t . ' : ' . $d) : ($t ?: $d);
            } elseif (is_string($m)) {
                $mLines[] = $m;
            }
        }
        $formattedMissions = implode("\n", $mLines);
    }

    $formattedHistory = '';
    if (isset($historyData['paragraphs']) && is_array($historyData['paragraphs'])) {
        $pLines = [];
        foreach ($historyData['paragraphs'] as $p) {
            $pLines[] = is_string($p) ? $p : (is_array($p) ? implode(" ", $p) : (string)$p);
        }
        $formattedHistory = implode("\n\n", $pLines);
    }
@endphp

<div class="space-y-6" x-data="{
    activeTab: 'identitas',
    teachers: {{ Js::from($teachersList) }},
    programs: {{ Js::from($programsList) }},
    facilities: {{ Js::from($facilitiesList) }},
    ekskul: {{ Js::from($ekskulList) }},
    prestasi: {{ Js::from($prestasiList) }},
    agenda: {{ Js::from($agendaList) }},
    announcements: {{ Js::from($announcementsList) }},
    gallery: {{ Js::from($galleryList) }},
    videos: {{ Js::from($videosList) }},
    alumni: {{ Js::from($alumniList) }},
    downloads: {{ Js::from($downloadsList) }},
    ebooks: {{ Js::from($ebooksList) }},
    orgWaka: {{ Js::from($orgWaka) }},
    orgStaff: {{ Js::from($orgStaff) }},
    logoComponents: {{ Js::from($logoComponents) }},

    addTeacher() {
        this.teachers.push({ name: '', role: 'Guru / Pendidik', photo: '/images/avatar-gray-person.svg', bio: '' });
    },
    removeTeacher(idx) {
        this.teachers.splice(idx, 1);
    },
    addProgram() {
        this.programs.push({ title: '', icon: '📖', desc: '' });
    },
    removeProgram(idx) {
        this.programs.splice(idx, 1);
    },
    addFacility() {
        this.facilities.push({ title: '', badge: 'Fasilitas Unit', icon: '🏫', desc: '', image: '/images/mockup_desktop_1.png' });
    },
    removeFacility(idx) {
        this.facilities.splice(idx, 1);
    },
    addEkskul() {
        this.ekskul.push({ title: '', badge: 'Ekstrakurikuler', icon: '⭐', desc: '', image: '/images/mockup_desktop_2.png' });
    },
    removeEkskul(idx) {
        this.ekskul.splice(idx, 1);
    },
    addPrestasi() {
        this.prestasi.push({ title: '', category: 'Akademik', rank: 'Juara 1', year: '{{ date('Y') }}', desc: '', image: '/images/mockup_desktop_3.png' });
    },
    removePrestasi(idx) {
        this.prestasi.splice(idx, 1);
    },
    addAgenda() {
        this.agenda.push({ title: '', date_day: '{{ date('d') }}', date_month: '{{ date('M') }}', date: '{{ date('d F Y') }}', time: '08:00 WIB', location: 'Kampus Sekolah', desc: '' });
    },
    removeAgenda(idx) {
        this.agenda.splice(idx, 1);
    },
    addAnnouncement() {
        this.announcements.push({ title: '', date: '{{ date('d F Y') }}', category: 'Pengumuman Resmi', summary: '', link: '#' });
    },
    removeAnnouncement(idx) {
        this.announcements.splice(idx, 1);
    },
    addGallery() {
        this.gallery.push({ title: 'Dokumentasi Kegiatan', category: 'Kegiatan', date: '{{ date('d F Y') }}', image: '/images/mockup_desktop_4.png' });
    },
    removeGallery(idx) {
        this.gallery.splice(idx, 1);
    },
    addVideo() {
        this.videos.push({ title: '', url: 'https://www.youtube.com/watch?v=', date: 'Dokumentasi Resmi', desc: '' });
    },
    removeVideo(idx) {
        this.videos.splice(idx, 1);
    },
    addDownload() {
        this.downloads.push({ title: '', category: 'publik', format: 'PDF', size: '1.2 MB', desc: '', url: '' });
    },
    removeDownload(idx) {
        this.downloads.splice(idx, 1);
    },
    addEbook() {
        this.ebooks.push({ title: '', author: 'Tim Pendidik SIT Robbani', level: 'Semua Jenjang', pages: '60 Halaman', size: '2.5 MB', tag: 'Modul Ajar', desc: '', cover: '', file: '' });
    },
    removeEbook(idx) {
        this.ebooks.splice(idx, 1);
    },
    addOrgWaka() {
        this.orgWaka.push({ title: 'Waka Baru', desc: 'Tugas & Tanggung Jawab', icon: 'fa-solid fa-layer-group' });
    },
    removeOrgWaka(idx) {
        this.orgWaka.splice(idx, 1);
    },
    addOrgStaff() {
        this.orgStaff.push({ title: 'Tim Teknis Baru', desc: 'Rincian tugas', icon: 'fa-solid fa-users' });
    },
    removeOrgStaff(idx) {
        this.orgStaff.splice(idx, 1);
    },
    addLogoComp() {
        this.logoComponents.push({ icon: 'fa-solid fa-star', title: 'Elemen Lambang Baru', desc: 'Makna filosofis elemen lambang ini' });
    },
    removeLogoComp(idx) {
        this.logoComponents.splice(idx, 1);
    },
    addAlumni() {
        this.alumni.push({ name: '', title: 'Wali Murid / Tokoh', category: 'wali', stars: 5, text: '', photo: '/images/avatar-gray-person.svg' });
    },
    removeAlumni(idx) {
        this.alumni.splice(idx, 1);
    }
}">

    <!-- Top Action Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.settings.units') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">← Kembali ke Daftar Unit</a>
                <span class="text-slate-300">•</span>
                <span class="px-2.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-black text-[10px] uppercase">PORTAL CMS LENGKAP UNIT {{ strtoupper($cleanCode) }}</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">Kelola Seluruh Tampilan &amp; Menu Web Unit {{ strtoupper($cleanCode) }}</h1>
            <p class="text-xs text-slate-600 font-medium mt-0.5">Semua teks, foto, dokumen, video, kurikulum, dan struktur di web unit dapat diedit langsung secara mandiri di sini tanpa hardcode.</p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ url('/unit/' . $cleanCode) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-md flex items-center gap-1.5 transition">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>Lihat Web Unit Live</span>
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-300 text-emerald-900 text-xs font-bold flex items-center gap-3 shadow-xs">
        <span class="text-xl">✅</span>
        <div class="flex-1">
            <div class="font-black text-emerald-950">Berhasil Disimpan!</div>
            <div class="font-normal text-emerald-800">{{ session('success') }}</div>
        </div>
    </div>
    @endif

    <!-- Form Container -->
    <form action="{{ route('admin.settings.units.update', $cleanCode) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Tabs Navigation -->
        <div class="bg-white p-2 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-1 overflow-x-auto no-scrollbar">
            <button type="button" @click="activeTab = 'identitas'" :class="activeTab === 'identitas' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                <span>🏛️</span> <span>Identitas &amp; Kontak</span>
            </button>
            <button type="button" @click="activeTab = 'hero_status'" :class="activeTab === 'hero_status' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                <span>🎨</span> <span>Banner Hero &amp; Status</span>
            </button>
            <button type="button" @click="activeTab = 'sambutan'" :class="activeTab === 'sambutan' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                <span>👤</span> <span>Kepala Sekolah</span>
            </button>
            <button type="button" @click="activeTab = 'visi_sejarah'" :class="activeTab === 'visi_sejarah' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                <span>🎯</span> <span>Visi, Misi &amp; Sejarah</span>
            </button>
            <button type="button" @click="activeTab = 'guru'" :class="activeTab === 'guru' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                <span>👨‍🏫</span> <span>Dewan Guru (<span x-text="teachers.length"></span>)</span>
            </button>
            <button type="button" @click="activeTab = 'struktur'" :class="activeTab === 'struktur' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                <span>🏢</span> <span>Struktur Organisasi</span>
            </button>
            <button type="button" @click="activeTab = 'program_fasilitas'" :class="activeTab === 'program_fasilitas' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                <span>⭐</span> <span>Program &amp; Fasilitas</span>
            </button>
            <button type="button" @click="activeTab = 'prestasi'" :class="activeTab === 'prestasi' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                <span>🏆</span> <span>Prestasi (<span x-text="prestasi.length"></span>)</span>
            </button>
            <button type="button" @click="activeTab = 'agenda_pengumuman'" :class="activeTab === 'agenda_pengumuman' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                <span>📅</span> <span>Agenda &amp; Pengumuman</span>
            </button>
            <button type="button" @click="activeTab = 'galeri_video'" :class="activeTab === 'galeri_video' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                <span>🖼️</span> <span>Galeri &amp; Video</span>
            </button>
            <button type="button" @click="activeTab = 'unduhan_ebook'" :class="activeTab === 'unduhan_ebook' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                <span>📥</span> <span>Unduhan &amp; E-Book</span>
            </button>
            <button type="button" @click="activeTab = 'mars_logo'" :class="activeTab === 'mars_logo' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                <span>🎵</span> <span>Mars, Hymne &amp; Logo</span>
            </button>
            <button type="button" @click="activeTab = 'testimoni'" :class="activeTab === 'testimoni' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                <span>💬</span> <span>Testimoni (<span x-text="alumni.length"></span>)</span>
            </button>
            <button type="button" @click="activeTab = 'statistik'" :class="activeTab === 'statistik' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold shrink-0 transition flex items-center gap-1.5 cursor-pointer">
                <span>📊</span> <span>Statistik</span>
            </button>
        </div>

        <!-- ==========================================
             TAB 1: IDENTITAS & KONTAK
             ========================================== -->
        <div x-show="activeTab === 'identitas'" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>🏛️</span> <span>Identitas Utama &amp; Kontak Resmi Unit</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Nama sekolah, nomor pokok sekolah nasional (NPSN), akreditasi, dan kanal kontak resmi.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Resmi Unit Sekolah *</label>
                    <input type="text" name="name" value="{{ old('name', $unitData['name'] ?? '') }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">NPSN Unit *</label>
                    <input type="text" name="npsn" value="{{ old('npsn', $unitData['npsn'] ?? '') }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Akreditasi</label>
                    <input type="text" name="akreditasi" value="{{ old('akreditasi', $unitData['akreditasi'] ?? 'Terakreditasi B') }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Slogan / Tagline Khas Unit</label>
                    <input type="text" name="tagline" value="{{ old('tagline', $unitData['tagline'] ?? '') }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Singkat Profil Unit *</label>
                <textarea name="description" rows="3" class="w-full text-xs font-medium rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>{{ old('description', $unitData['description'] ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Telepon Kantor</label>
                    <input type="text" name="phone" value="{{ old('phone', $unitData['phone'] ?? '') }}" class="w-full text-xs font-semibold rounded-xl border-slate-300">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp Resmi</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $unitData['whatsapp'] ?? ($unitData['phone'] ?? '')) }}" class="w-full text-xs font-semibold rounded-xl border-slate-300">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email Resmi Unit</label>
                    <input type="email" name="email" value="{{ old('email', $unitData['email'] ?? '') }}" class="w-full text-xs font-semibold rounded-xl border-slate-300">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap Kampus Sekolah</label>
                <textarea name="address" rows="2" class="w-full text-xs font-medium rounded-xl border-slate-300">{{ old('address', $unitData['address'] ?? '') }}</textarea>
            </div>

            <!-- Social Media Section -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                <span class="text-xs font-black text-slate-800 uppercase tracking-wider block">🔗 Akun Media Sosial Resmi Unit</span>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Instagram URL</label>
                        <input type="url" name="social_instagram" value="{{ old('social_instagram', $socialsData['instagram'] ?? 'https://instagram.com/sitrobbani') }}" class="w-full text-xs rounded-xl border-slate-300">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">YouTube Channel URL</label>
                        <input type="url" name="social_youtube" value="{{ old('social_youtube', $socialsData['youtube'] ?? 'https://youtube.com/@sitrobbani') }}" class="w-full text-xs rounded-xl border-slate-300">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Facebook Page URL</label>
                        <input type="url" name="social_facebook" value="{{ old('social_facebook', $socialsData['facebook'] ?? 'https://facebook.com/sitrobbani') }}" class="w-full text-xs rounded-xl border-slate-300">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">TikTok URL</label>
                        <input type="url" name="social_tiktok" value="{{ old('social_tiktok', $socialsData['tiktok'] ?? '') }}" class="w-full text-xs rounded-xl border-slate-300">
                    </div>
                </div>
            </div>
        </div>

        <!-- ==========================================
             TAB 2: HERO BANNER & STATUS UNIT
             ========================================== -->
        <div x-show="activeTab === 'hero_status'" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>🎨</span> <span>Kustomisasi Banner Hero &amp; Status Operasional Unit</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Atur status pembukaan unit sekolah dan foto-foto representatif di banner utama.</p>
            </div>

            <!-- Status Unit Selector -->
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 space-y-3">
                <span class="text-xs font-black text-amber-950 uppercase tracking-wider block">⚙️ Status Operasional Unit Web</span>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="flex items-center gap-2 p-3 bg-white rounded-xl border border-amber-200 cursor-pointer">
                        <input type="radio" name="status" value="AKTIF" {{ ($unitData['status'] ?? 'AKTIF') === 'AKTIF' ? 'checked' : '' }} class="text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <span class="text-xs font-black text-slate-800 block">Unit Aktif Beroperasi</span>
                            <span class="text-[10px] text-slate-500">Menampilkan seluruh konten kegiatan, pendaftaran siswa, dewan guru, dan fasilitas.</span>
                        </div>
                    </label>
                    <label class="flex items-center gap-2 p-3 bg-white rounded-xl border border-amber-200 cursor-pointer">
                        <input type="radio" name="status" value="BELUM_DIBUKA" {{ ($unitData['status'] ?? '') === 'BELUM_DIBUKA' ? 'checked' : '' }} class="text-amber-600 focus:ring-amber-500">
                        <div>
                            <span class="text-xs font-black text-slate-800 block">Tahap Persiapan / Segera Dibuka</span>
                            <span class="text-[10px] text-slate-500">Menampilkan banner persiapan operasional pembukaan jenjang lanjutan.</span>
                        </div>
                    </label>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-amber-900 mb-1">Pesan Pengumuman Status (Tampil jika Belum Dibuka):</label>
                    <input type="text" name="status_alert_message" value="{{ old('status_alert_message', $unitData['status_alert_message'] ?? '') }}" placeholder="Contoh: SMA IT Robbani saat ini dalam tahap persiapan operasional pembukaan." class="w-full text-xs rounded-xl border-amber-300">
                </div>
            </div>

            <!-- Visual Hero Banner Images -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Hero BG -->
                <div class="space-y-3 p-4 bg-slate-50 rounded-2xl border border-slate-200">
                    <label class="block text-xs font-black text-slate-800 uppercase">🏛️ Background Hero Banner (Gedung/Masjid):</label>
                    <div class="h-32 rounded-xl overflow-hidden border border-slate-300 bg-slate-900 flex items-center justify-center">
                        <img src="{{ asset($unitData['hero_bg_image'] ?? '/images/logo-robbani-official.png') }}" class="w-full h-full object-cover opacity-80" onerror="this.src='/images/logo-robbani-official.png'">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Upload Foto Background Baru:</label>
                        <input type="file" name="hero_bg_file" accept="image/*" class="w-full text-xs border border-slate-300 rounded-xl p-2 bg-white">
                        <input type="hidden" name="hero_bg_image" value="{{ $unitData['hero_bg_image'] ?? '' }}">
                    </div>
                </div>

                <!-- Hero Main Image -->
                <div class="space-y-3 p-4 bg-slate-50 rounded-2xl border border-slate-200">
                    <label class="block text-xs font-black text-slate-800 uppercase">🎓 Foto Utama Hero Banner (Siswa / Visual):</label>
                    <div class="h-32 rounded-xl overflow-hidden border border-slate-300 bg-slate-900 flex items-center justify-center">
                        <img src="{{ asset($unitData['hero_image'] ?? '/images/logo-robbani-official.png') }}" class="w-full h-full object-cover" onerror="this.src='/images/logo-robbani-official.png'">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Upload Foto Utama Baru:</label>
                        <input type="file" name="hero_image_file" accept="image/*" class="w-full text-xs border border-slate-300 rounded-xl p-2 bg-white">
                        <input type="hidden" name="hero_image" value="{{ $unitData['hero_image'] ?? '' }}">
                    </div>
                </div>

                <!-- Campus Photo -->
                <div class="space-y-3 p-4 bg-slate-50 rounded-2xl border border-slate-200">
                    <label class="block text-xs font-black text-slate-800 uppercase">🏫 Foto Kampus / Lingkungan Sekolah:</label>
                    <div class="h-32 rounded-xl overflow-hidden border border-slate-300 bg-slate-900 flex items-center justify-center">
                        <img src="{{ asset($unitData['campus_photo'] ?? '/images/logo-robbani-official.png') }}" class="w-full h-full object-cover" onerror="this.src='/images/logo-robbani-official.png'">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Upload Foto Kampus Baru:</label>
                        <input type="file" name="campus_photo_file" accept="image/*" class="w-full text-xs border border-slate-300 rounded-xl p-2 bg-white">
                        <input type="hidden" name="campus_photo" value="{{ $unitData['campus_photo'] ?? '' }}">
                    </div>
                </div>

                <!-- SPMB Flyer -->
                <div class="space-y-3 p-4 bg-slate-50 rounded-2xl border border-slate-200">
                    <label class="block text-xs font-black text-slate-800 uppercase">🎯 Brosur / Flyer Resmi SPMB Unit:</label>
                    <div class="h-32 rounded-xl overflow-hidden border border-slate-300 bg-slate-900 flex items-center justify-center">
                        <img src="{{ asset($unitData['flyer'] ?? '/images/spmb/banner_spmb_official.jpg') }}" class="w-full h-full object-cover" onerror="this.src='/images/logo-robbani-official.png'">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Upload Flyer Baru:</label>
                        <input type="file" name="flyer_file" accept="image/*" class="w-full text-xs border border-slate-300 rounded-xl p-2 bg-white">
                        <input type="hidden" name="flyer" value="{{ $unitData['flyer'] ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- ==========================================
             TAB 3: KEPALA SEKOLAH & SAMBUTAN
             ========================================== -->
        <div x-show="activeTab === 'sambutan'" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>👤</span> <span>Kepala Sekolah &amp; Sambutan Resmi</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Informasi profil pimpinan unit serta teks sambutan yang tampil di halaman Sambutan dan Beranda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kepala Sekolah &amp; Gelar *</label>
                    <input type="text" name="principal_name" value="{{ old('principal_name', $unitData['principal_name'] ?? '') }}" class="w-full text-xs font-semibold rounded-xl border-slate-300" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan Resmi</label>
                    <input type="text" name="principal_title" value="{{ old('principal_title', $unitData['principal_title'] ?? ('Kepala ' . strtoupper($cleanCode))) }}" class="w-full text-xs font-semibold rounded-xl border-slate-300">
                </div>
            </div>

            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                <label class="block text-xs font-bold text-slate-700 mb-2">Foto Kepala Sekolah:</label>
                <div class="flex items-center gap-4">
                    <img src="{{ asset($unitData['principal_photo'] ?? '/images/avatar-gray-person.svg') }}" class="w-16 h-16 rounded-2xl object-cover border border-slate-300 shrink-0" onerror="this.src='/images/avatar-gray-person.svg'">
                    <div class="flex-1">
                        <input type="file" name="principal_photo" accept="image/*" class="w-full text-xs border border-slate-300 rounded-xl p-2 bg-white">
                        <input type="hidden" name="principal_photo_url" value="{{ $unitData['principal_photo'] ?? '' }}">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Teks Sambutan Resmi Kepala Sekolah *</label>
                <textarea name="principal_greeting" rows="6" class="w-full text-xs font-medium rounded-xl border-slate-300" required>{{ old('principal_greeting', $unitData['principal_greeting'] ?? '') }}</textarea>
            </div>
        </div>

        <!-- ==========================================
             TAB 4: VISI, MISI & SEJARAH
             ========================================== -->
        <div x-show="activeTab === 'visi_sejarah'" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>🎯</span> <span>Visi, Misi &amp; Sejarah Singkat Unit</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Pedoman filosofis institusi dan narasi sejarah perkembangan unit.</p>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kalimat Visi Unit *</label>
                <textarea name="vision" rows="2" class="w-full text-xs font-semibold rounded-xl border-slate-300" required>{{ old('vision', $unitData['vision'] ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Poin-Poin Misi Unit (Tulis satu misi per baris):</label>
                <textarea name="missions_text" rows="5" class="w-full text-xs font-medium rounded-xl border-slate-300" placeholder="Menanamkan aqidah Islam yang lurus...&#10;Membimbing hafalan Al-Qur'an mutqin...&#10;Membekali literasi sains dan teknologi...">{{ old('missions_text', $formattedMissions) }}</textarea>
            </div>

            <!-- History Section -->
            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 space-y-4">
                <span class="text-xs font-black text-slate-800 uppercase tracking-wider block">📜 Jejak Langkah &amp; Sejarah Unit</span>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Judul Sejarah</label>
                        <input type="text" name="history_title" value="{{ old('history_title', $historyData['title'] ?? '') }}" class="w-full text-xs rounded-xl border-slate-300">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Badge / Kategori</label>
                        <input type="text" name="history_badge" value="{{ old('history_badge', $historyData['badge'] ?? 'Jejak Langkah & Perkembangan') }}" class="w-full text-xs rounded-xl border-slate-300">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Foto Sejarah / Dokumentasi Pendirian:</label>
                    <div class="flex items-center gap-3">
                        <img src="{{ asset($historyData['image'] ?? '/images/logo-robbani-official.png') }}" class="w-16 h-12 rounded-lg object-cover border border-slate-300" onerror="this.src='/images/logo-robbani-official.png'">
                        <input type="file" name="history_image_file" accept="image/*" class="w-full text-xs border border-slate-300 rounded-xl p-2 bg-white">
                        <input type="hidden" name="history_image" value="{{ $historyData['image'] ?? '' }}">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-600 mb-1">Paragraf Sejarah (Pisahkan antar-paragraf dengan baris kosong ganda):</label>
                    <textarea name="history_paragraphs_text" rows="5" class="w-full text-xs rounded-xl border-slate-300">{{ old('history_paragraphs_text', $formattedHistory) }}</textarea>
                </div>
            </div>
        </div>

        <!-- ==========================================
             TAB 5: DEWAN GURU & GTK
             ========================================== -->
        <div x-show="activeTab === 'guru'" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                        <span>👨‍🏫</span> <span>Dewan Guru &amp; Tenaga Kependidikan Unit</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola foto, nama guru, serta jabatan yang tampil di halaman Dewan Guru dan Beranda.</p>
                </div>
                <button type="button" @click="addTeacher()" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs flex items-center gap-1.5 cursor-pointer">
                    <span>➕ Tambah Guru</span>
                </button>
            </div>

            <div class="space-y-4">
                <template x-for="(teacher, index) in teachers" :key="index">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                            <span class="text-xs font-black text-slate-800" x-text="'Guru / Pendidik #' + (index + 1)"></span>
                            <button type="button" @click="removeTeacher(index)" class="text-xs text-rose-600 hover:text-rose-800 font-bold">🗑️ Hapus</button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Lengkap &amp; Gelar *</label>
                                <input type="text" :name="'teachers[' + index + '][name]'" x-model="teacher.name" required class="w-full text-xs rounded-xl border-slate-300">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Jabatan / Guru Bidang Studi *</label>
                                <input type="text" :name="'teachers[' + index + '][role]'" x-model="teacher.role" required class="w-full text-xs rounded-xl border-slate-300">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Foto Guru (Upload Baru):</label>
                                <div class="flex items-center gap-2">
                                    <template x-if="teacher.photo">
                                        <img :src="teacher.photo" class="w-8 h-8 rounded-full object-cover border border-slate-300 shrink-0">
                                    </template>
                                    <input type="file" :name="'teacher_photo_' + index" accept="image/*" class="w-full text-[10px] border border-slate-300 rounded-xl p-1 bg-white">
                                    <input type="hidden" :name="'teachers[' + index + '][photo]'" :value="teacher.photo">
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- ==========================================
             TAB 6: STRUKTUR ORGANISASI
             ========================================== -->
        <div x-show="activeTab === 'struktur'" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>🏢</span> <span>Bagan Struktur Organisasi Satuan Pendidikan</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola nama pimpinan yayasan, komite sekolah, jajaran wakil kepala sekolah, dan pelaksana teknis.</p>
            </div>

            <!-- Yayasan & Komite -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-2">
                    <span class="text-xs font-black text-slate-800 uppercase block">🏛️ Badan Penyelenggara (Yayasan)</span>
                    <input type="text" name="org_foundation_name" value="{{ old('org_foundation_name', $orgStructure['foundation_name'] ?? 'Yayasan Generasi Robbani') }}" placeholder="Nama Yayasan" class="w-full text-xs rounded-xl border-slate-300">
                    <input type="text" name="org_foundation_leader" value="{{ old('org_foundation_leader', $orgStructure['foundation_leader'] ?? 'Sughesti Wulandari, S.Pd') }}" placeholder="Nama Ketua Yayasan" class="w-full text-xs rounded-xl border-slate-300">
                </div>
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 space-y-2">
                    <span class="text-xs font-black text-slate-800 uppercase block">🤝 Mitra Sinergi (Komite)</span>
                    <input type="text" name="org_committee_name" value="{{ old('org_committee_name', $orgStructure['committee_name'] ?? 'Komite Sekolah') }}" placeholder="Nama Komite" class="w-full text-xs rounded-xl border-slate-300">
                    <input type="text" name="org_committee_sub" value="{{ old('org_committee_sub', $orgStructure['committee_sub'] ?? 'Perwakilan Orang Tua & Tokoh') }}" placeholder="Sub-keterangan" class="w-full text-xs rounded-xl border-slate-300">
                </div>
            </div>

            <!-- Jajaran Waka & Koordinator -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-black text-slate-800 uppercase">👥 Jajaran Wakil Kepala Sekolah (Waka)</span>
                    <button type="button" @click="addOrgWaka()" class="text-xs text-emerald-600 hover:text-emerald-800 font-bold">➕ Tambah Waka</button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <template x-for="(waka, index) in orgWaka" :key="index">
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700" x-text="'Waka #' + (index + 1)"></span>
                                <button type="button" @click="removeOrgWaka(index)" class="text-[11px] text-rose-600 font-bold">Hapus</button>
                            </div>
                            <input type="text" :name="'org_waka[' + index + '][title]'" x-model="waka.title" placeholder="Nama Jabatan (Waka Kurikulum)" class="w-full text-xs rounded-xl border-slate-300">
                            <input type="text" :name="'org_waka[' + index + '][desc]'" x-model="waka.desc" placeholder="Tanggung Jawab Singkat" class="w-full text-xs rounded-xl border-slate-300">
                            <input type="text" :name="'org_waka[' + index + '][icon]'" x-model="waka.icon" placeholder="Icon FontAwesome (fa-solid fa-book-open)" class="w-full text-xs rounded-xl border-slate-300">
                        </div>
                    </template>
                </div>
            </div>

            <!-- Pelaksana Teknis -->
            <div class="space-y-3 pt-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-black text-slate-800 uppercase">🛠️ Pelaksana Teknis &amp; Staf</span>
                    <button type="button" @click="addOrgStaff()" class="text-xs text-emerald-600 hover:text-emerald-800 font-bold">➕ Tambah Staf Teknis</button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <template x-for="(staff, index) in orgStaff" :key="index">
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700" x-text="'Pelaksana #' + (index + 1)"></span>
                                <button type="button" @click="removeOrgStaff(index)" class="text-[11px] text-rose-600 font-bold">Hapus</button>
                            </div>
                            <input type="text" :name="'org_staff[' + index + '][title]'" x-model="staff.title" placeholder="Nama Divisi (Dewan Guru / Tata Usaha)" class="w-full text-xs rounded-xl border-slate-300">
                            <textarea :name="'org_staff[' + index + '][desc]'" x-model="staff.desc" rows="2" placeholder="Uraian tugas" class="w-full text-xs rounded-xl border-slate-300"></textarea>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- ==========================================
             TAB 7: PROGRAM UNGGULAN & FASILITAS & EKSKUL
             ========================================== -->
        <div x-show="activeTab === 'program_fasilitas'" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-8">
            <!-- 1. Program Unggulan -->
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <span>⭐</span> <span>Program Unggulan Khas Unit</span>
                        </h3>
                        <p class="text-xs text-slate-500">Program khas pembeda satuan pendidikan (Tahfidz, Billingual, dsb).</p>
                    </div>
                    <button type="button" @click="addProgram()" class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-bold text-xs">➕ Tambah Program</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="(prog, index) in programs" :key="index">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700" x-text="'Program #' + (index + 1)"></span>
                                <button type="button" @click="removeProgram(index)" class="text-xs text-rose-600 font-bold">🗑️ Hapus</button>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="text" :name="'programs[' + index + '][icon]'" x-model="prog.icon" placeholder="📖" class="w-16 text-center text-xs font-bold rounded-xl border-slate-300">
                                <input type="text" :name="'programs[' + index + '][title]'" x-model="prog.title" placeholder="Judul Program" class="w-full text-xs font-bold rounded-xl border-slate-300">
                            </div>
                            <textarea :name="'programs[' + index + '][desc]'" x-model="prog.desc" rows="2" placeholder="Uraian program..." class="w-full text-xs rounded-xl border-slate-300"></textarea>
                        </div>
                    </template>
                </div>
            </div>

            <!-- 2. Fasilitas Fisik -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <span>🏫</span> <span>Fasilitas &amp; Sarana Prasarana</span>
                        </h3>
                        <p class="text-xs text-slate-500">Gedung, laboratorium, masjid, ruang kelas AC, lapangan dsb.</p>
                    </div>
                    <button type="button" @click="addFacility()" class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-bold text-xs">➕ Tambah Fasilitas</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="(fac, index) in facilities" :key="index">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700" x-text="'Fasilitas #' + (index + 1)"></span>
                                <button type="button" @click="removeFacility(index)" class="text-xs text-rose-600 font-bold">🗑️ Hapus</button>
                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                <input type="text" :name="'facilities[' + index + '][icon]'" x-model="fac.icon" placeholder="🏫" class="text-center text-xs font-bold rounded-xl border-slate-300">
                                <input type="text" :name="'facilities[' + index + '][badge]'" x-model="fac.badge" placeholder="Badge Kategori" class="col-span-2 text-xs rounded-xl border-slate-300">
                            </div>
                            <input type="text" :name="'facilities[' + index + '][title]'" x-model="fac.title" placeholder="Nama Fasilitas" class="w-full text-xs font-bold rounded-xl border-slate-300">
                            <textarea :name="'facilities[' + index + '][desc]'" x-model="fac.desc" rows="2" placeholder="Deskripsi sarana..." class="w-full text-xs rounded-xl border-slate-300"></textarea>
                            <div class="flex items-center gap-2 pt-1">
                                <template x-if="fac.image">
                                    <img :src="fac.image" class="w-10 h-8 rounded-lg object-cover border border-slate-300 shrink-0">
                                </template>
                                <input type="file" :name="'facility_photo_' + index" accept="image/*" class="w-full text-[10px] border border-slate-300 rounded-xl p-1 bg-white">
                                <input type="hidden" :name="'facilities[' + index + '][image]'" :value="fac.image">
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- 3. Ekstrakurikuler -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <span>🏹</span> <span>Ekstrakurikuler &amp; Life Skill</span>
                        </h3>
                        <p class="text-xs text-slate-500">Pramuka SIT, Panahan, Futsal, Robotik, Karya Ilmiah dsb.</p>
                    </div>
                    <button type="button" @click="addEkskul()" class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-bold text-xs">➕ Tambah Ekskul</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="(eks, index) in ekskul" :key="index">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700" x-text="'Ekskul #' + (index + 1)"></span>
                                <button type="button" @click="removeEkskul(index)" class="text-xs text-rose-600 font-bold">🗑️ Hapus</button>
                            </div>
                            <div class="grid grid-cols-3 gap-2">
                                <input type="text" :name="'ekskul[' + index + '][icon]'" x-model="eks.icon" placeholder="🏹" class="text-center text-xs font-bold rounded-xl border-slate-300">
                                <input type="text" :name="'ekskul[' + index + '][badge]'" x-model="eks.badge" placeholder="Badge Kategori" class="col-span-2 text-xs rounded-xl border-slate-300">
                            </div>
                            <input type="text" :name="'ekskul[' + index + '][title]'" x-model="eks.title" placeholder="Nama Ekstrakurikuler" class="w-full text-xs font-bold rounded-xl border-slate-300">
                            <textarea :name="'ekskul[' + index + '][desc]'" x-model="eks.desc" rows="2" placeholder="Deskripsi kegiatan..." class="w-full text-xs rounded-xl border-slate-300"></textarea>
                            <div class="flex items-center gap-2 pt-1">
                                <template x-if="eks.image">
                                    <img :src="eks.image" class="w-10 h-8 rounded-lg object-cover border border-slate-300 shrink-0">
                                </template>
                                <input type="file" :name="'ekskul_photo_' + index" accept="image/*" class="w-full text-[10px] border border-slate-300 rounded-xl p-1 bg-white">
                                <input type="hidden" :name="'ekskul[' + index + '][image]'" :value="eks.image">
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- ==========================================
             TAB 8: PRESTASI SISWA
             ========================================== -->
        <div x-show="activeTab === 'prestasi'" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                        <span>🏆</span> <span>Prestasi Siswa &amp; Santri Unit</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola capaian juara kompetisi akademik, sains, tahfidz, dan olahraga.</p>
                </div>
                <button type="button" @click="addPrestasi()" class="px-3.5 py-2 rounded-xl bg-emerald-600 text-white font-bold text-xs">➕ Tambah Prestasi</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="(pr, index) in prestasi" :key="index">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-700" x-text="'Prestasi #' + (index + 1)"></span>
                            <button type="button" @click="removePrestasi(index)" class="text-xs text-rose-600 font-bold">🗑️ Hapus</button>
                        </div>
                        <input type="text" :name="'prestasi[' + index + '][title]'" x-model="pr.title" placeholder="Nama Prestasi & Kompetisi" class="w-full text-xs font-bold rounded-xl border-slate-300">
                        <div class="grid grid-cols-3 gap-2">
                            <input type="text" :name="'prestasi[' + index + '][rank]'" x-model="pr.rank" placeholder="Juara 1" class="text-xs rounded-xl border-slate-300">
                            <input type="text" :name="'prestasi[' + index + '][category]'" x-model="pr.category" placeholder="Tingkat Nasional" class="text-xs rounded-xl border-slate-300">
                            <input type="text" :name="'prestasi[' + index + '][year]'" x-model="pr.year" placeholder="Tahun" class="text-xs rounded-xl border-slate-300">
                        </div>
                        <textarea :name="'prestasi[' + index + '][desc]'" x-model="pr.desc" rows="2" placeholder="Deskripsi pemenang..." class="w-full text-xs rounded-xl border-slate-300"></textarea>
                        <div class="flex items-center gap-2 pt-1">
                            <template x-if="pr.image">
                                <img :src="pr.image" class="w-10 h-8 rounded-lg object-cover border border-slate-300 shrink-0">
                            </template>
                            <input type="file" :name="'prestasi_photo_' + index" accept="image/*" class="w-full text-[10px] border border-slate-300 rounded-xl p-1 bg-white">
                            <input type="hidden" :name="'prestasi[' + index + '][image]'" :value="pr.image">
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- ==========================================
             TAB 9: AGENDA & PENGUMUMAN
             ========================================== -->
        <div x-show="activeTab === 'agenda_pengumuman'" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-8">
            <!-- Agenda -->
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <span>📅</span> <span>Agenda &amp; Kalender Akademik</span>
                        </h3>
                        <p class="text-xs text-slate-500">Jadwal ujian, mabit, pembagian rapor, dan kegiatan sekolah.</p>
                    </div>
                    <button type="button" @click="addAgenda()" class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-bold text-xs">➕ Tambah Agenda</button>
                </div>
                <div class="space-y-3">
                    <template x-for="(ag, index) in agenda" :key="index">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700" x-text="'Agenda #' + (index + 1)"></span>
                                <button type="button" @click="removeAgenda(index)" class="text-xs text-rose-600 font-bold">🗑️ Hapus</button>
                            </div>
                            <input type="text" :name="'agenda[' + index + '][title]'" x-model="ag.title" placeholder="Nama Kegiatan / Agenda" class="w-full text-xs font-bold rounded-xl border-slate-300">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                                <input type="text" :name="'agenda[' + index + '][date_day]'" x-model="ag.date_day" placeholder="Tgl (15)" class="text-xs rounded-xl border-slate-300">
                                <input type="text" :name="'agenda[' + index + '][date_month]'" x-model="ag.date_month" placeholder="Bln (OKT)" class="text-xs rounded-xl border-slate-300">
                                <input type="text" :name="'agenda[' + index + '][time]'" x-model="ag.time" placeholder="08:00 - Selesai" class="text-xs rounded-xl border-slate-300">
                                <input type="text" :name="'agenda[' + index + '][location]'" x-model="ag.location" placeholder="Lokasi Kegiatan" class="text-xs rounded-xl border-slate-300">
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Pengumuman -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <span>📢</span> <span>Pengumuman Resmi Sekolah</span>
                        </h3>
                        <p class="text-xs text-slate-500">Kabar resmi dari kepala sekolah dan tata usaha untuk wali murid & siswa.</p>
                    </div>
                    <button type="button" @click="addAnnouncement()" class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-bold text-xs">➕ Tambah Pengumuman</button>
                </div>
                <div class="space-y-3">
                    <template x-for="(an, index) in announcements" :key="index">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700" x-text="'Pengumuman #' + (index + 1)"></span>
                                <button type="button" @click="removeAnnouncement(index)" class="text-xs text-rose-600 font-bold">🗑️ Hapus</button>
                            </div>
                            <input type="text" :name="'announcements[' + index + '][title]'" x-model="an.title" placeholder="Judul Surat Pengumuman" class="w-full text-xs font-bold rounded-xl border-slate-300">
                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" :name="'announcements[' + index + '][category]'" x-model="an.category" placeholder="Kategori / Badge" class="text-xs rounded-xl border-slate-300">
                                <input type="text" :name="'announcements[' + index + '][date]'" x-model="an.date" placeholder="Tanggal Rilis" class="text-xs rounded-xl border-slate-300">
                            </div>
                            <textarea :name="'announcements[' + index + '][summary]'" x-model="an.summary" rows="2" placeholder="Ringkasan pengumuman..." class="w-full text-xs rounded-xl border-slate-300"></textarea>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- ==========================================
             TAB 10: GALERI FOTO & VIDEO YOUTUBE
             ========================================== -->
        <div x-show="activeTab === 'galeri_video'" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-8">
            <!-- Galeri Foto -->
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <span>🖼️</span> <span>Galeri Foto Dokumentasi Unit</span>
                        </h3>
                        <p class="text-xs text-slate-500">Momen pembelajaran, outbond, tahfidz camp, dan wisuda.</p>
                    </div>
                    <button type="button" @click="addGallery()" class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-bold text-xs">➕ Tambah Foto Galeri</button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <template x-for="(gl, index) in gallery" :key="index">
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700" x-text="'Foto #' + (index + 1)"></span>
                                <button type="button" @click="removeGallery(index)" class="text-xs text-rose-600 font-bold">🗑️</button>
                            </div>
                            <input type="text" :name="'gallery[' + index + '][title]'" x-model="gl.title" placeholder="Judul Foto" class="w-full text-xs font-bold rounded-xl border-slate-300">
                            <input type="text" :name="'gallery[' + index + '][category]'" x-model="gl.category" placeholder="Kategori Kegiatan" class="w-full text-xs rounded-xl border-slate-300">
                            <div class="flex items-center gap-2 pt-1">
                                <template x-if="gl.image">
                                    <img :src="gl.image" class="w-10 h-8 rounded-lg object-cover border border-slate-300 shrink-0">
                                </template>
                                <input type="file" :name="'gallery_photo_' + index" accept="image/*" class="w-full text-[10px] border border-slate-300 rounded-xl p-1 bg-white">
                                <input type="hidden" :name="'gallery[' + index + '][image]'" :value="gl.image">
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Video YouTube -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <span>🎥</span> <span>Dokumentasi Video YouTube</span>
                        </h3>
                        <p class="text-xs text-slate-500">Video profil, wisuda tahfidz, dan liputan kegiatan sekolah.</p>
                    </div>
                    <button type="button" @click="addVideo()" class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-bold text-xs">➕ Tambah Video YouTube</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="(vd, index) in videos" :key="index">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700" x-text="'Video #' + (index + 1)"></span>
                                <button type="button" @click="removeVideo(index)" class="text-xs text-rose-600 font-bold">🗑️ Hapus</button>
                            </div>
                            <input type="text" :name="'videos[' + index + '][title]'" x-model="vd.title" placeholder="Judul Video" class="w-full text-xs font-bold rounded-xl border-slate-300">
                            <input type="url" :name="'videos[' + index + '][url]'" x-model="vd.url" placeholder="https://www.youtube.com/watch?v=..." class="w-full text-xs rounded-xl border-slate-300">
                            <input type="text" :name="'videos[' + index + '][desc]'" x-model="vd.desc" placeholder="Keterangan singkat video" class="w-full text-xs rounded-xl border-slate-300">
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- ==========================================
             TAB 11: PUSAT UNDUHAN & E-BOOK
             ========================================== -->
        <div x-show="activeTab === 'unduhan_ebook'" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-8">
            <!-- Unduhan Berkas -->
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <span>📥</span> <span>Pusat Unduhan Berkas &amp; Formulir</span>
                        </h3>
                        <p class="text-xs text-slate-500">Brosur SPMB, formulir pendaftaran, kalender pendidikan, dan panduan akademik.</p>
                    </div>
                    <button type="button" @click="addDownload()" class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-bold text-xs">➕ Tambah Berkas</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="(dw, index) in downloads" :key="index">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700" x-text="'Dokumen #' + (index + 1)"></span>
                                <button type="button" @click="removeDownload(index)" class="text-xs text-rose-600 font-bold">🗑️ Hapus</button>
                            </div>
                            <input type="text" :name="'downloads[' + index + '][title]'" x-model="dw.title" placeholder="Judul Dokumen / Brosur" class="w-full text-xs font-bold rounded-xl border-slate-300">
                            <div class="grid grid-cols-3 gap-2">
                                <input type="text" :name="'downloads[' + index + '][category]'" x-model="dw.category" placeholder="publik / akademik" class="text-xs rounded-xl border-slate-300">
                                <input type="text" :name="'downloads[' + index + '][format]'" x-model="dw.format" placeholder="PDF" class="text-xs rounded-xl border-slate-300">
                                <input type="text" :name="'downloads[' + index + '][size]'" x-model="dw.size" placeholder="1.5 MB" class="text-xs rounded-xl border-slate-300">
                            </div>
                            <input type="text" :name="'downloads[' + index + '][desc]'" x-model="dw.desc" placeholder="Keterangan isi berkas" class="w-full text-xs rounded-xl border-slate-300">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 mb-1">Upload File Dokumen Baru (PDF/DOCX):</label>
                                <input type="file" :name="'download_file_' + index" class="w-full text-[10px] border border-slate-300 rounded-xl p-1 bg-white">
                                <input type="hidden" :name="'downloads[' + index + '][url]'" :value="dw.url">
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- E-Book & Modul Digital -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <span>📚</span> <span>Katalog E-Book &amp; Modul Ajar Digital</span>
                        </h3>
                        <p class="text-xs text-slate-500">Modul tematik, mutaba'ah BPI, panduan ibadah, dan e-book karya guru.</p>
                    </div>
                    <button type="button" @click="addEbook()" class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-bold text-xs">➕ Tambah E-Book</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="(eb, index) in ebooks" :key="index">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700" x-text="'E-Book #' + (index + 1)"></span>
                                <button type="button" @click="removeEbook(index)" class="text-xs text-rose-600 font-bold">🗑️ Hapus</button>
                            </div>
                            <input type="text" :name="'ebooks[' + index + '][title]'" x-model="eb.title" placeholder="Judul Buku / Modul" class="w-full text-xs font-bold rounded-xl border-slate-300">
                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" :name="'ebooks[' + index + '][author]'" x-model="eb.author" placeholder="Penulis" class="text-xs rounded-xl border-slate-300">
                                <input type="text" :name="'ebooks[' + index + '][tag]'" x-model="eb.tag" placeholder="Tag (Modul Ajar)" class="text-xs rounded-xl border-slate-300">
                            </div>
                            <textarea :name="'ebooks[' + index + '][desc]'" x-model="eb.desc" rows="2" placeholder="Sinopsis buku..." class="w-full text-xs rounded-xl border-slate-300"></textarea>
                            <div class="grid grid-cols-2 gap-2 pt-1">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-600 mb-0.5">Upload Cover Buku:</label>
                                    <input type="file" :name="'ebook_cover_' + index" accept="image/*" class="w-full text-[10px] border border-slate-300 rounded-xl p-1 bg-white">
                                    <input type="hidden" :name="'ebooks[' + index + '][cover]'" :value="eb.cover">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-600 mb-0.5">Upload File PDF Buku:</label>
                                    <input type="file" :name="'ebook_pdf_' + index" accept=".pdf" class="w-full text-[10px] border border-slate-300 rounded-xl p-1 bg-white">
                                    <input type="hidden" :name="'ebooks[' + index + '][file]'" :value="eb.file">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- ==========================================
             TAB 12: MARS JSIT, HYMNE & LOGO INFO
             ========================================== -->
        <div x-show="activeTab === 'mars_logo'" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-8">
            <!-- Mars JSIT -->
            <div class="space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                        <span>🎵</span> <span>Mars JSIT Indonesia &amp; Hymne Sekolah</span>
                    </h3>
                    <p class="text-xs text-slate-500">Pengaturan video resmi YouTube, pemutar audio, serta bait lirik resmi.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Link Video YouTube Mars</label>
                        <input type="url" name="mars_youtube_url" value="{{ old('mars_youtube_url', $hymneMars['youtube_url'] ?? 'https://www.youtube.com/watch?v=ijDo1wLvZ6w') }}" class="w-full text-xs rounded-xl border-slate-300">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">File / URL Audio MP3 Mars</label>
                        <input type="text" name="mars_audio_url" value="{{ old('mars_audio_url', $hymneMars['audio_url'] ?? 'uploads/mars-jsit.mp3') }}" class="w-full text-xs rounded-xl border-slate-300">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Lirik Lengkap Mars JSIT Indonesia</label>
                        <textarea name="mars_lyrics" rows="8" class="w-full text-xs font-mono rounded-xl border-slate-300">{{ old('mars_lyrics', $hymneMars['mars_lyrics'] ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Lirik Lengkap Hymne Sekolah Robbani</label>
                        <textarea name="hymne_lyrics" rows="8" class="w-full text-xs font-mono rounded-xl border-slate-300">{{ old('hymne_lyrics', $hymneMars['hymne_lyrics'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Makna Logo -->
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <span>🛡️</span> <span>Identitas Visual &amp; Makna Elemen Logo</span>
                        </h3>
                        <p class="text-xs text-slate-500">Filosofi setiap komponen lambang resmi unit.</p>
                    </div>
                    <button type="button" @click="addLogoComp()" class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-bold text-xs">➕ Tambah Komponen Logo</button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-200">
                        <label class="block text-xs font-bold text-slate-700 mb-2">Logo Resmi Unit:</label>
                        <div class="flex items-center gap-3">
                            <img src="{{ asset($unitData['logo'] ?? '/images/logo-robbani-official.png') }}" class="w-12 h-12 object-contain" onerror="this.src='/images/logo-robbani-official.png'">
                            <input type="file" name="logo_image_file" accept="image/*" class="w-full text-[10px] border border-slate-300 rounded-xl p-1 bg-white">
                            <input type="hidden" name="logo" value="{{ $unitData['logo'] ?? '' }}">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Judul Halaman Makna Logo</label>
                        <input type="text" name="logo_title" value="{{ old('logo_title', $logoInfo['title'] ?? 'Lambang Keagungan Ilmu & Ketakwaan Robbani') }}" class="w-full text-xs rounded-xl border-slate-300">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Subtitle</label>
                        <input type="text" name="logo_subtitle" value="{{ old('logo_subtitle', $logoInfo['subtitle'] ?? 'Official Brand Identity') }}" class="w-full text-xs rounded-xl border-slate-300">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Keseluruhan Lambang</label>
                    <textarea name="logo_desc" rows="2" class="w-full text-xs rounded-xl border-slate-300">{{ old('logo_desc', $logoInfo['description'] ?? '') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <template x-for="(comp, index) in logoComponents" :key="index">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700" x-text="'Elemen #' + (index + 1)"></span>
                                <button type="button" @click="removeLogoComp(index)" class="text-xs text-rose-600 font-bold">🗑️</button>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="text" :name="'logo_components[' + index + '][icon]'" x-model="comp.icon" placeholder="fa-solid fa-mosque" class="w-40 text-xs rounded-xl border-slate-300">
                                <input type="text" :name="'logo_components[' + index + '][title]'" x-model="comp.title" placeholder="Nama Unsur Lambang" class="w-full text-xs font-bold rounded-xl border-slate-300">
                            </div>
                            <textarea :name="'logo_components[' + index + '][desc]'" x-model="comp.desc" rows="2" placeholder="Makna filosofi..." class="w-full text-xs rounded-xl border-slate-300"></textarea>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- ==========================================
             TAB 13: TESTIMONI & ALUMNI
             ========================================== -->
        <div x-show="activeTab === 'testimoni'" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                        <span>💬</span> <span>Testimoni Tokoh, Wali Murid &amp; Alumni</span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Ulasan dan kesan positif dari wali murid dan alumni untuk memperkuat kepercayaan publik.</p>
                </div>
                <button type="button" @click="addAlumni()" class="px-3.5 py-2 rounded-xl bg-emerald-600 text-white font-bold text-xs">➕ Tambah Testimoni</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="(al, index) in alumni" :key="index">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-700" x-text="'Testimoni #' + (index + 1)"></span>
                            <button type="button" @click="removeAlumni(index)" class="text-xs text-rose-600 font-bold">🗑️ Hapus</button>
                        </div>
                        <input type="text" :name="'alumni[' + index + '][name]'" x-model="al.name" placeholder="Nama Lengkap Wali / Alumni" class="w-full text-xs font-bold rounded-xl border-slate-300">
                        <div class="grid grid-cols-3 gap-2">
                            <input type="text" :name="'alumni[' + index + '][title]'" x-model="al.title" placeholder="Profesi / Status" class="col-span-2 text-xs rounded-xl border-slate-300">
                            <input type="number" min="1" max="5" :name="'alumni[' + index + '][stars]'" x-model="al.stars" placeholder="⭐ (5)" class="text-center text-xs rounded-xl border-slate-300">
                        </div>
                        <textarea :name="'alumni[' + index + '][text]'" x-model="al.text" rows="3" placeholder="Isi testimoni..." class="w-full text-xs rounded-xl border-slate-300"></textarea>
                        <div class="flex items-center gap-2 pt-1">
                            <template x-if="al.photo || al.avatar">
                                <img :src="al.photo || al.avatar" class="w-8 h-8 rounded-full object-cover border border-slate-300 shrink-0">
                            </template>
                            <input type="file" :name="'alumni_photo_' + index" accept="image/*" class="w-full text-[10px] border border-slate-300 rounded-xl p-1 bg-white">
                            <input type="hidden" :name="'alumni[' + index + '][photo]'" :value="al.photo || al.avatar">
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- ==========================================
             TAB 14: STATISTIK & METRICS
             ========================================== -->
        <div x-show="activeTab === 'statistik'" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>📊</span> <span>Statistik &amp; Capaian Utama Unit</span>
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Angka metrik yang tampil di counter statistik beranda unit sekolah.</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Siswa Aktif</label>
                    <input type="number" name="students_count" value="{{ old('students_count', $unitData['students_count'] ?? 450) }}" class="w-full text-base font-black rounded-xl border-slate-300">
                </div>
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Guru &amp; Tendik</label>
                    <input type="number" name="employees_count" value="{{ old('employees_count', $unitData['employees_count'] ?? 38) }}" class="w-full text-base font-black rounded-xl border-slate-300">
                </div>
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Rombongan Belajar</label>
                    <input type="number" name="classrooms_count" value="{{ old('classrooms_count', $unitData['classrooms_count'] ?? 18) }}" class="w-full text-base font-black rounded-xl border-slate-300">
                </div>
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Target Hafalan Tahfidz</label>
                    <input type="text" name="target_hafalan" value="{{ old('target_hafalan', $unitData['target_hafalan'] ?? '3 - 5 Juz Mutqin') }}" class="w-full text-xs font-black rounded-xl border-slate-300">
                </div>
            </div>
        </div>

        <!-- Sticky Save Action Footer -->
        <div class="sticky bottom-4 z-30 p-4 bg-slate-900/95 backdrop-blur-md text-white rounded-2xl shadow-2xl flex flex-col sm:flex-row items-center justify-between gap-3 border border-slate-700">
            <div class="text-xs text-slate-300">
                <span>Sedang mengedit: </span>
                <strong class="text-amber-400 uppercase font-black">UNIT {{ strtoupper($cleanCode) }}</strong>
                <span class="hidden sm:inline"> • Semua perubahan tersimpan secara aman &amp; instan.</span>
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.settings.units') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black shadow-lg shadow-emerald-900/30 flex items-center gap-2 cursor-pointer transition">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Seluruh Data Web Unit {{ strtoupper($cleanCode) }}</span>
                </button>
            </div>
        </div>

    </form>
</div>
@endsection
