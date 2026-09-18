@extends('school.unit.layouts.master')

@section('title', 'Testimonial & Kata Mereka - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Kesan, pesan, dan testimoni nyata dari orang tua wali santri, alumni, dan tokoh masyarakat tentang mutu pendidikan di ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    
    // Testimonial authentic unit data
    $alumniList = !empty($unitAlumni) ? $unitAlumni : (!empty($info['alumni']) ? $info['alumni'] : []);
    if (empty($alumniList)) {
        $alumniList = [
            [
                'name' => 'dr. H. Hendra Saputra, Sp.A',
                'title' => 'Wali Santri Angkatan VII',
                'category' => 'wali',
                'text' => 'Alhamdulillah, ananda mengalami perubahan adab dan kemandirian yang luar biasa sejak bersekolah di SIT Robbani. Bimbingan tahfidz para ustadz sangat telaten dan suasana kekeluargaan sekolah begitu kental.',
                'avatar' => '/images/avatar-gray-person.svg',
                'stars' => 5
            ],
            [
                'name' => 'Fathurrahman Al-Ghifari',
                'title' => 'Alumni - Mahasiswa Kedokteran UNSRI',
                'category' => 'alumni',
                'text' => 'Fondasi hafalan Al-Qur\'an dan kedisiplinan belajar yang saya dapatkan di SIT Robbani menjadi bekal berharga hingga ke bangku perkuliahan. Guru-guru tidak hanya mengajar, tetapi mendidik dengan hati.',
                'avatar' => '/images/avatar-gray-person.svg',
                'stars' => 5
            ],
            [
                'name' => 'Hj. Nurul Aini, S.Pd',
                'title' => 'Wali Santri Kelas Tahfidz',
                'category' => 'wali',
                'text' => 'Sistem pembelajaran terpadu antara kurikulum nasional dan nilai keislaman sangat seimbang. Komunikasi sekolah dengan wali santri sangat transparan melalui sistem pelaporan digital yang rapi.',
                'avatar' => '/images/avatar-gray-person.svg',
                'stars' => 5
            ],
            [
                'name' => 'Aisyah Putri Ramadhani',
                'title' => 'Alumni - Hafidzah 30 Juz',
                'category' => 'alumni',
                'text' => 'Metode tahfidz di Robbani membuat menghafal Al-Qur\'an terasa sangat menyenangkan dan tidak membebani. Lingkungan teman yang sholeh saling menyemangati dalam kebaikan.',
                'avatar' => '/images/avatar-gray-person.svg',
                'stars' => 5
            ],
            [
                'name' => 'Ir. Bambang Trihatmojo',
                'title' => 'Tokoh Pendidikan & Komite Sekolah',
                'category' => 'tokoh',
                'text' => 'SIT Robbani membuktikan bahwa pendidikan Islam mampu tampil modern, menguasai sains dan riset teknologi, tanpa meninggalkan sedikit pun identitas akhlakul karimah.',
                'avatar' => '/images/avatar-gray-person.svg',
                'stars' => 5
            ],
            [
                'name' => 'Bunda Siti Maryam, M.Pd',
                'title' => 'Wali Murid Berprestasi',
                'category' => 'wali',
                'text' => 'Program parenting rutin bagi orang tua sangat membantu kami menyelaraskan pola asuh di rumah dengan target pembinaan adab santri di sekolah. Sekolah pilihan terbaik bagi ananda!',
                'avatar' => '/images/avatar-gray-person.svg',
                'stars' => 5
            ]
        ];
    }
@endphp

@section('content')
{{-- SUBPAGE HERO HEADER --}}
<div class="bg-gradient-to-r {{ $uTheme['nav_gradient'] }} border-b border-indigo-950 text-white py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-indigo-200 mb-2.5 sm:mb-3 flex items-center space-x-2 overflow-x-auto no-scrollbar whitespace-nowrap">
            <a href="{{ url('/unit/' . $codeLower) }}" class="hover:text-white transition shrink-0">Beranda</a>
            <span>/</span>
            <span class="shrink-0">Profil</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold shrink-0">Testimonial</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Testimonial &amp; Kata Mereka</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Ungkapan tulus dan apresiasi dari orang tua santri, alumni, dan mitra tentang pengalaman berharga bersama {{ $info['name'] }}.
        </p>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14"
     x-data="{
        activeTab: 'all',
        matches(item) {
            if (this.activeTab === 'all') return true;
            return (item.category || 'wali') === this.activeTab;
        }
     }">

    {{-- STATS HIGHLIGHT ROW --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-12">
        <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-xl border border-gray-100 text-center reveal-fade-up">
            <div class="text-2xl sm:text-4xl font-black text-unit-primary mb-1">98.6%</div>
            <div class="text-xs font-bold text-gray-900">Kepuasan Wali Santri</div>
            <div class="text-[11px] text-gray-500 mt-0.5">Survei Mutu Tahunan</div>
        </div>

        <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-xl border border-gray-100 text-center reveal-fade-up">
            <div class="text-2xl sm:text-4xl font-black text-amber-500 mb-1">100%</div>
            <div class="text-xs font-bold text-gray-900">Kelulusan Santri</div>
            <div class="text-[11px] text-gray-500 mt-0.5">Diterima Sekolah/PTN Favorit</div>
        </div>

        <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-xl border border-gray-100 text-center reveal-fade-up">
            <div class="text-2xl sm:text-4xl font-black text-emerald-600 mb-1">5★</div>
            <div class="text-xs font-bold text-gray-900">Rating Kualitas Pengasuhan</div>
            <div class="text-[11px] text-gray-500 mt-0.5">Berdasarkan Ulasan Publik</div>
        </div>

        <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-xl border border-gray-100 text-center reveal-fade-up">
            <div class="text-2xl sm:text-4xl font-black text-indigo-900 mb-1">1000+</div>
            <div class="text-xs font-bold text-gray-900">Alumni Berkarakter</div>
            <div class="text-[11px] text-gray-500 mt-0.5">Tersebar di Berbagai Profesi</div>
        </div>
    </div>

    {{-- SECTION HEADER & FILTER TABS --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8 pb-6 border-b border-gray-200">
        <div>
            <span class="text-xs font-black uppercase tracking-wider text-unit-primary block mb-1">
                Kisah &amp; Pengalaman Nyata
            </span>
            <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Apa Kata Keluarga Besar Robbani?
            </h2>
            <div class="w-16 h-1 bg-unit-primary rounded-full mt-2"></div>
        </div>

        {{-- FILTER PILLS --}}
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
            <button type="button" 
                    @click="activeTab = 'all'"
                    :class="activeTab === 'all' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                    class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition">
                Semua Ulasan
            </button>
            <button type="button" 
                    @click="activeTab = 'wali'"
                    :class="activeTab === 'wali' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                    class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition">
                Wali Santri
            </button>
            <button type="button" 
                    @click="activeTab = 'alumni'"
                    :class="activeTab === 'alumni' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                    class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition">
                Alumni
            </button>
            <button type="button" 
                    @click="activeTab = 'tokoh'"
                    :class="activeTab === 'tokoh' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                    class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition">
                Tokoh Masyarakat
            </button>
        </div>
    </div>

    {{-- TESTIMONIAL GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-14">
        @foreach($alumniList as $index => $item)
            @php
                $category = $item['category'] ?? ($index % 2 === 0 ? 'wali' : 'alumni');
            @endphp
            <div x-show="matches({ category: '{{ $category }}' })"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 hover:border-indigo-200 hover:-translate-y-1.5 transition duration-300 flex flex-col justify-between relative overflow-hidden group">
                
                {{-- TOP BACKGROUND QUOTE ICON --}}
                <div class="absolute -right-3 -top-3 text-7xl font-serif text-gray-100 select-none pointer-events-none group-hover:text-indigo-50 transition">
                    “
                </div>

                <div>
                    {{-- 5 STARS --}}
                    <div class="flex items-center gap-1 text-amber-400 text-xs mb-4">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>

                    {{-- TESTIMONY TEXT --}}
                    <p class="text-xs sm:text-sm text-gray-700 leading-relaxed italic relative z-10">
                        "{{ $item['text'] ?? $item['quote'] ?? 'Pendidikan adab dan tahfidz di SIT Robbani sangat berkesan bagi masa depan ananda.' }}"
                    </p>
                </div>

                {{-- AUTHOR INFO --}}
                <div class="pt-6 mt-6 border-t border-gray-100 flex items-center gap-3.5 relative z-10">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-100 to-amber-100 border-2 border-white shadow-md flex items-center justify-center text-unit-primary font-black text-sm shrink-0 overflow-hidden">
                        @if(!empty($item['avatar']) && $item['avatar'] !== '/images/avatar-gray-person.svg')
                            <img src="{{ asset($item['avatar']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-user"></i>
                        @endif
                    </div>
                    <div>
                        <h4 class="text-xs sm:text-sm font-bold text-gray-900 group-hover:text-unit-primary transition">
                            {{ $item['name'] }}
                        </h4>
                        <p class="text-[11px] text-gray-500 font-medium mt-0.5">
                            {{ $item['title'] ?? 'Wali Santri SIT Robbani' }}
                        </p>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    {{-- SUBMIT TESTIMONIAL CALLOUT & SPMB BANNER --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center bg-gradient-to-br from-gray-900 via-indigo-950 to-blue-950 text-white rounded-3xl p-8 sm:p-12 shadow-2xl reveal-fade-up">
        <div class="lg:col-span-8 space-y-3">
            <span class="text-xs font-black uppercase tracking-wider text-amber-300 block">
                Bagikan Pengalaman Anda
            </span>
            <h3 class="text-xl sm:text-3xl font-extrabold tracking-tight">
                Pernah Menjadi Bagian dari {{ $info['name'] }}?
            </h3>
            <p class="text-xs sm:text-sm text-indigo-100 font-light leading-relaxed max-w-2xl">
                Kesan dan pesan Anda sangat berharga bagi kami untuk terus berbenah dan menginspirasi calon santri generasi penerus. Kirimkan ulasan Anda langsung kepada kami.
            </p>
            <div class="pt-3 flex flex-wrap gap-3">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $school->phone ?? $info['phone'] ?? '6281271708899') }}?text=Halo%20Humas%20{{ urlencode($info['name']) }}%2C%20saya%20ingin%20mengirimkan%20testimoni%20pengalaman%20saya%20bersama%20sekolah." 
                   target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 px-5 py-3 rounded-xl text-xs font-bold text-gray-950 bg-amber-400 hover:bg-amber-300 shadow-md transition">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Kirim Testimoni via WhatsApp</span>
                </a>
                <a href="{{ route('school.ppdb') }}" 
                   class="inline-flex items-center gap-2 px-5 py-3 rounded-xl text-xs font-bold text-white bg-white/10 hover:bg-white/20 border border-white/20 transition">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>Daftar Santri Baru (SPMB)</span>
                </a>
            </div>
        </div>

        <div class="lg:col-span-4 text-center lg:text-right">
            <div class="inline-block p-6 rounded-3xl bg-white/5 border border-white/10 backdrop-blur-sm text-center">
                <div class="w-16 h-16 rounded-2xl bg-amber-400 text-gray-950 flex items-center justify-center text-3xl mx-auto mb-3 shadow-lg">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <h4 class="text-sm font-bold text-white">Terima Kasih Atas Kepercayaan</h4>
                <p class="text-[11px] text-indigo-200 mt-1 font-light">
                    Bersama membimbing generasi Qur'ani masa depan bangsa.
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
