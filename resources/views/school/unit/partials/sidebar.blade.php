@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $sidebarNews = !empty($unitNews) ? collect($unitNews)->take(5) : collect();
    $sidebarAgendas = !empty($unitAgendas) ? collect($unitAgendas)->take(3) : collect();
@endphp

<aside class="space-y-8">
    
    {{-- CARD 1: KABAR SEKOLAH --}}
    <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 reveal-fade-up">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-5">
            <h3 class="font-extrabold text-sm sm:text-base text-gray-900 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-newspaper text-indigo-600"></i>
                <span>Kabar Sekolah</span>
            </h3>
            <a href="{{ url('/unit/' . $codeLower . '#berita') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
                <span>Lihat Semua</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="space-y-4">
            @forelse($sidebarNews as $item)
                <a href="{{ !empty($item['slug']) ? route('school.berita.show', $item['slug']) : url('/unit/' . $codeLower . '#berita') }}" 
                   class="flex items-center space-x-3.5 group p-2 rounded-2xl hover:bg-gray-50 transition">
                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0 shadow-sm">
                        <img src="{{ asset($item['image'] ?? '/images/logo-robbani-official.png') }}" 
                             alt="{{ $item['title'] }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                             onerror="this.src='/images/logo-robbani-official.png'">
                    </div>
                    <div class="space-y-1 min-w-0 flex-1">
                        <h4 class="text-xs font-bold text-gray-900 group-hover:text-indigo-600 transition line-clamp-2 leading-snug">
                            {{ $item['title'] }}
                        </h4>
                        <span class="block text-[10px] text-gray-400 font-medium">
                            <i class="fa-regular fa-clock text-[9px] mr-1"></i>
                            {{ $item['date'] ?? '18 Sep 2026' }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="text-center py-4 text-xs text-gray-400">
                    Belum ada kabar berita terbaru.
                </div>
            @endforelse
        </div>
    </div>

    {{-- CARD 2: AGENDA TERDEKAT / AKADEMIK --}}
    <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 reveal-fade-up delay-1">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-5">
            <h3 class="font-extrabold text-sm sm:text-base text-gray-900 tracking-tight flex items-center gap-2">
                <i class="fa-solid fa-calendar-check text-indigo-600"></i>
                <span>Agenda Terdekat</span>
            </h3>
            <a href="{{ url('/unit/' . $codeLower . '#agenda') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
                <span>Lihat Semua</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="space-y-4">
            @forelse($sidebarAgendas as $agenda)
                <div class="flex items-start space-x-3.5 p-3 rounded-2xl bg-gray-50/70 border border-gray-100 hover:border-indigo-200 transition">
                    <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-700 border border-cyan-200/60 flex flex-col items-center justify-center flex-shrink-0 leading-none shadow-sm">
                        <span class="text-xs font-black">{{ $agenda['date_day'] ?? '15' }}</span>
                        <span class="text-[9px] font-extrabold uppercase mt-0.5 tracking-wider">{{ $agenda['date_month'] ?? 'JUL' }}</span>
                    </div>
                    <div class="space-y-1 min-w-0 flex-1">
                        <h4 class="text-xs font-bold text-gray-900 leading-snug line-clamp-2">
                            {{ $agenda['title'] }}
                        </h4>
                        <p class="text-[10px] text-gray-500 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-amber-500 text-[9px]"></i>
                            <span class="truncate">{{ $agenda['location'] ?? 'Kampus Sekolah' }}</span>
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-4 text-xs text-gray-400">
                    Belum ada agenda terdekat terjadwal.
                </div>
            @endforelse
        </div>
    </div>

    {{-- CARD 3: PPDB TELAH DIBUKA! (Conversion Callout Card) --}}
    <div class="bg-gradient-to-br from-[#1e1b4b] via-[#2d2568] to-[#1e1b4b] rounded-3xl p-7 text-white text-center space-y-4 shadow-2xl border border-indigo-500/20 reveal-fade-up delay-2 relative overflow-hidden">
        <div class="absolute -right-8 -top-8 w-24 h-24 bg-amber-500/10 rounded-full blur-xl pointer-events-none"></div>
        <div class="w-14 h-14 rounded-2xl bg-white/10 text-amber-400 mx-auto flex items-center justify-center text-2xl border border-white/10 shadow-inner">
            <i class="fa-solid fa-graduation-cap"></i>
        </div>
        <div class="space-y-2">
            <h3 class="text-xl font-black tracking-tight text-white">
                PPDB Telah Dibuka!
            </h3>
            <p class="text-xs text-indigo-200 leading-relaxed font-light">
                Wujudkan impian putra-putri Anda menjadi hafidz Qur'an yang cerdas sains bersama {{ $info['name'] }}.
            </p>
        </div>
        <div class="pt-2">
            <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" 
               class="inline-block w-full py-3 px-6 rounded-full font-black text-xs uppercase tracking-wider bg-[#dc2626] hover:bg-[#b91c1c] text-white shadow-lg shadow-red-600/30 hover:shadow-red-600/50 transform hover:-translate-y-0.5 active:translate-y-0 transition duration-200">
                Daftar PPDB Online
            </a>
        </div>
    </div>

</aside>
