<!-- Robbani AI Assistant Floating Chat Widget -->
<style>[x-cloak] { display: none !important; }</style>
<script>
    if (typeof window.Alpine === 'undefined') {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js';
        script.defer = true;
        document.head.appendChild(script);
    }
</script>
<div x-data="robbaniAiChat" class="fixed bottom-[74px] sm:bottom-5 right-3 sm:right-5 z-[60] font-sans flex flex-col items-end gap-2.5">

    <!-- Scroll to Top Indicator Button (Naik ke Atas) -->
    <button 
        x-show="showScrollTop" 
        x-cloak 
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })" 
        aria-label="Kembali ke Atas Halaman" 
        title="Naik ke Atas"
        class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-white/95 dark:bg-slate-800/95 text-emerald-700 dark:text-[#c6f634] shadow-xl border border-slate-200 dark:border-slate-700 flex items-center justify-center hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 dark:hover:text-white transition-all transform hover:-translate-y-1 active:scale-95 cursor-pointer backdrop-blur-md"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path>
        </svg>
    </button>

    <!-- Floating Trigger Button (Robbani AI - Robot Mascot Icon) -->
    <div class="relative group flex flex-col items-center">
        <button 
            @click="isOpen = !isOpen" 
            aria-label="Buka Robbani AI" 
            title="Robbani AI"
            class="relative w-12 h-12 sm:w-13 sm:h-13 rounded-full bg-gradient-to-br from-[#004532] via-[#065f46] to-teal-700 text-white shadow-2xl flex items-center justify-center transition-all transform hover:scale-110 active:scale-95 border-2 border-white/40 cursor-pointer overflow-visible"
        >
            <img src="{{ asset('images/robbani-ai-mascot.webp') }}" alt="Robbani AI" class="w-8 h-8 sm:w-9 sm:h-9 object-contain drop-shadow-sm transition-transform duration-300 group-hover:scale-110" onerror="this.onerror=null; this.src='{{ asset('images/robbani-ai-mascot.png') }}';">
            <span class="absolute top-0 right-0 w-3.5 h-3.5 rounded-full bg-[#a3e635] border-2 border-[#004532]"></span>
        </button>
        <span class="mt-1 px-2 py-0.5 rounded-full bg-slate-900/90 dark:bg-black/90 text-white text-[9px] font-black tracking-tight shadow-md backdrop-blur-xs whitespace-nowrap">
            Robbani AI
        </span>
        <span class="pointer-events-none absolute right-full mr-2.5 top-3.5 -translate-y-1/2 px-2.5 py-1 rounded-full bg-slate-900 text-white text-[10px] font-extrabold whitespace-nowrap shadow-lg opacity-0 group-hover:opacity-100 transition-opacity hidden sm:block">
            Robbani AI 💬
        </span>
    </div>

    <!-- Chat Modal Window (Strict Clean Light Mode) -->
    <div x-show="isOpen" x-cloak 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="fixed bottom-20 sm:bottom-24 right-3 sm:right-6 w-[94vw] sm:w-[420px] max-h-[82vh] h-[580px] bg-white rounded-3xl border border-slate-200 shadow-2xl flex flex-col overflow-hidden z-[70]">

        <!-- Chat Header -->
        <div class="bg-gradient-to-r from-[#004532] via-[#065f46] to-[#0f172a] p-4 text-white flex items-center justify-between shadow-md shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/10 border border-white/20 flex items-center justify-center p-1.5 shrink-0 shadow-inner">
                    <img src="{{ asset('images/robbani-ai-mascot.webp') }}" alt="Robbani AI" class="w-full h-full object-contain" onerror="this.onerror=null; this.src='{{ asset('images/robbani-ai-mascot.png') }}';">
                </div>
                <div>
                    <h3 class="font-extrabold text-xs sm:text-sm text-white flex items-center gap-1.5">
                        <span>Robbani AI</span>
                        <span class="w-2 h-2 rounded-full bg-[#a3e635] animate-ping"></span>
                    </h3>
                    <span class="text-[10px] text-emerald-200 font-semibold block">Asisten Cerdas Resmi SIT Robbani</span>
                </div>
            </div>
            <button @click="isOpen = false" aria-label="Tutup Robbani AI" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white text-xs font-bold transition-colors">
                ✕
            </button>
        </div>

        <!-- Message Stream Area -->
        <div x-ref="chatBox" class="flex-1 p-4 overflow-y-auto space-y-3 bg-slate-50 text-xs">
            
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.sender === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    
                    <div :class="msg.sender === 'user' ? 'bg-emerald-700 text-white rounded-2xl rounded-tr-none shadow-sm' : 'bg-white text-slate-800 border border-slate-200 rounded-2xl rounded-tl-none shadow-sm'" 
                         class="max-w-[85%] p-3.5 space-y-1.5 transition-all">
                        
                        <div class="flex items-center justify-between gap-2 border-b border-slate-100 pb-1 text-[9px] font-bold"
                             :class="msg.sender === 'user' ? 'text-emerald-200 border-white/10' : 'text-emerald-700 border-slate-100'">
                            <span class="inline-flex items-center gap-1.5">
                                <template x-if="msg.sender === 'user'">
                                    <span>👤 Anda</span>
                                </template>
                                <template x-if="msg.sender !== 'user'">
                                    <span class="inline-flex items-center gap-1">
                                        <img src="{{ asset('images/robbani-ai-mascot.webp') }}" alt="Robbani AI" class="w-3.5 h-3.5 object-contain inline-block" onerror="this.src='{{ asset('images/robbani-ai-mascot.png') }}'">
                                        <span>Robbani AI</span>
                                    </span>
                                </template>
                            </span>
                            <span x-text="msg.time" class="opacity-75"></span>
                        </div>

                        <div class="leading-relaxed font-medium text-xs break-words" x-html="formatMarkdown(msg.text)"></div>
                    </div>

                </div>
            </template>

            <!-- Loading Spinner Indicator -->
            <div x-show="isLoading" class="flex justify-start">
                <div class="bg-white border border-slate-200 p-2.5 sm:p-3 rounded-2xl rounded-tl-none text-xs text-slate-600 flex items-center gap-2 shadow-xs">
                    <img src="{{ asset('images/robbani-ai-mascot.webp') }}" class="w-4 h-4 object-contain animate-bounce" onerror="this.src='{{ asset('images/robbani-ai-mascot.png') }}'">
                    <span class="font-bold text-[11px]">Robbani AI sedang berpikir...</span>
                </div>
            </div>

        </div>

        <!-- Quick Suggestion Chips -->
        <div class="p-2.5 bg-slate-100 border-t border-slate-200 flex items-center gap-2 overflow-x-auto text-[10px] font-bold shrink-0 no-scrollbar">
            <button @click="sendMessage('Bagaimana cara mendaftar SPMB Online?')" class="px-3 py-1.5 rounded-full bg-white text-slate-700 border border-slate-200 hover:bg-emerald-50 hover:text-emerald-700 shrink-0 shadow-2xs transition-colors">
                📝 Pendaftaran SPMB
            </button>
            <button @click="sendMessage('Apa saja 4 Unit Sekolah di SIT Robbani?')" class="px-3 py-1.5 rounded-full bg-white text-slate-700 border border-slate-200 hover:bg-emerald-50 hover:text-emerald-700 shrink-0 shadow-2xs transition-colors">
                🏫 4 Unit Sekolah
            </button>
            <button @click="sendMessage('Berapa biaya SPP dan cara mengeceknya?')" class="px-3 py-1.5 rounded-full bg-white text-slate-700 border border-slate-200 hover:bg-emerald-50 hover:text-emerald-700 shrink-0 shadow-2xs transition-colors">
                💳 Rincian Biaya SPP
            </button>
            <button @click="sendMessage('Dimana lokasi kampus dan kontak WhatsApp?')" class="px-3 py-1.5 rounded-full bg-white text-slate-700 border border-slate-200 hover:bg-emerald-50 hover:text-emerald-700 shrink-0 shadow-2xs transition-colors">
                📍 Alamat &amp; Kontak
            </button>
        </div>

        <!-- Input Bar -->
        <div class="p-3 bg-white border-t border-slate-200 shrink-0">
            <form @submit.prevent="sendMessage()" class="flex items-center gap-2">
                <input type="text" 
                       x-model="inputMessage" 
                       aria-label="Ketik pertanyaan untuk AI Assistant"
                       placeholder="Ketik pertanyaan seputar SIT Robbani..." 
                       class="flex-1 px-3.5 py-2.5 rounded-xl bg-slate-100 text-slate-900 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600 border border-slate-200">
                <button type="submit" 
                        aria-label="Kirim Pesan ke AI"
                        :disabled="isLoading || !inputMessage.trim()"
                        class="p-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 disabled:opacity-50 text-white font-bold text-xs shadow-sm transition-all shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
        </div>

    </div>

</div>

<!-- Separate Clean Alpine Component Script -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('robbaniAiChat', () => ({
            isOpen: false,
            showScrollTop: false,
            messages: [
                {
                    sender: 'ai',
                    time: 'Baru saja',
                    text: 'Assalamu\'alaikum! 👋 Saya **Robbani AI**, asisten kecerdasan buatan resmi SIT Robbani Ogan Ilir.\n\nSaya telah mempelajari seluruh informasi sekolah, kurikulum tahfidz, pendaftaran SPMB, dan sistem kami. Silakan tanyakan hal apa pun yang ingin Anda ketahui!'
                }
            ],
            inputMessage: '',
            isLoading: false,
            init() {
                this.showScrollTop = (window.pageYOffset > 250);
                window.addEventListener('scroll', () => {
                    this.showScrollTop = (window.pageYOffset > 250);
                });
                window.addEventListener('open-robbani-ai', (e) => {
                    this.isOpen = true;
                    if (e.detail && e.detail.query) {
                        this.sendMessage(e.detail.query);
                    }
                    this.$nextTick(() => {
                        const input = this.$el.querySelector('input');
                        if (input) input.focus();
                    });
                });
            },
            sendMessage(customText = null) {
                let msg = customText || this.inputMessage;
                if (!msg || !msg.trim()) return;
                
                this.messages.push({
                    sender: 'user',
                    time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                    text: msg
                });
                
                if (!customText) this.inputMessage = '';
                this.isLoading = true;
                
                this.$nextTick(() => { this.scrollToBottom(); });

                fetch('{{ route("school.chat-ai") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: msg })
                })
                .then(res => {
                    if (!res.ok) {
                        throw new Error('HTTP error ' + res.status);
                    }
                    return res.json();
                })
                .then(data => {
                    this.isLoading = false;
                    this.messages.push({
                        sender: 'ai',
                        time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                        text: data.answer || 'Terima kasih telah menghubungi SIT Robbani Ogan Ilir. Silakan tanyakan hal lain seputar SPMB atau Sekolah.'
                    });
                    this.$nextTick(() => { this.scrollToBottom(); });
                })
                .catch(err => {
                    this.isLoading = false;
                    this.messages.push({
                        sender: 'ai',
                        time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
                        text: "Assalamu'alaikum! Terima kasih telah bertanya kepada Robbani AI Assistant.\n\nSIT Robbani Ogan Ilir menyelenggarakan jenjang KB/TKIT, SDIT, SMPIT, dan SMAIT Robbani.\n\nUntuk informasi pendaftaran siswa baru, silakan kunjungi menu **[Pendaftaran SPMB]** (`/spmb`) atau WhatsApp Admin **0811747472**."
                    });
                    this.$nextTick(() => { this.scrollToBottom(); });
                });
            },
            scrollToBottom() {
                const chatContainer = this.$refs.chatBox;
                if (chatContainer) {
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }
            },
            formatMarkdown(text) {
                if (!text) return '';
                return text
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/`(.*?)`/g, '<code class="bg-emerald-50 text-emerald-800 px-1.5 py-0.5 rounded font-mono text-[11px]">$1</code>')
                    .replace(/\n/g, '<br>');
            }
        }));
    });
</script>
