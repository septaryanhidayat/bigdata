<!-- Robbani AI Assistant Floating Chat Widget -->
<div x-data="robbaniAiChat" class="fixed bottom-5 right-5 z-50 font-sans">

    <!-- Floating Trigger Button -->
    <button @click="isOpen = !isOpen" class="group relative px-4 py-3.5 rounded-full bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-800 text-white font-extrabold text-xs shadow-2xl flex items-center gap-2.5 transition-all transform hover:scale-105 active:scale-95 border-2 border-white/20">
        <div class="relative flex items-center justify-center">
            <span class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-lg animate-pulse">🤖</span>
            <span class="absolute top-0 right-0 w-2.5 h-2.5 rounded-full bg-[#a3e635] border-2 border-emerald-800"></span>
        </div>
        <div class="text-left hidden sm:block">
            <span class="block text-[10px] text-emerald-200 font-bold uppercase tracking-wider leading-none">Smart AI Assistant</span>
            <span class="text-xs font-black leading-tight block">Tanya Robbani AI</span>
        </div>
        <span class="sm:hidden font-black text-xs">Chat AI</span>
    </button>

    <!-- Chat Modal Window -->
    <div x-show="isOpen" x-cloak 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="fixed bottom-20 right-4 sm:right-6 w-[92vw] sm:w-[420px] max-h-[82vh] h-[580px] bg-white dark:bg-[#0c1a0e] rounded-3xl border border-slate-200/90 dark:border-[#1b3d1f] shadow-2xl flex flex-col overflow-hidden z-50">

        <!-- Chat Header -->
        <div class="bg-gradient-to-r from-[#004532] via-[#065f46] to-[#0f172a] p-4 text-white flex items-center justify-between shadow-md shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-xl shrink-0 shadow-inner">
                    🤖
                </div>
                <div>
                    <h3 class="font-extrabold text-xs sm:text-sm text-white flex items-center gap-1.5">
                        <span>Robbani AI Assistant</span>
                        <span class="w-2 h-2 rounded-full bg-[#a3e635] animate-ping"></span>
                    </h3>
                    <span class="text-[10px] text-emerald-200 font-semibold block">Asisten Cerdas SIT Robbani Ogan Ilir</span>
                </div>
            </div>
            <button @click="isOpen = false" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white text-xs font-bold transition-colors">
                ✕
            </button>
        </div>

        <!-- Message Stream Area -->
        <div x-ref="chatBox" class="flex-1 p-4 overflow-y-auto space-y-3 bg-slate-50/70 dark:bg-[#071208] text-xs">
            
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.sender === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    
                    <div :class="msg.sender === 'user' ? 'bg-emerald-700 text-white rounded-2xl rounded-tr-none' : 'bg-white dark:bg-[#122615] text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-[#204724] rounded-2xl rounded-tl-none shadow-sm'" 
                         class="max-w-[85%] p-3.5 space-y-1.5 transition-all">
                        
                        <div class="flex items-center justify-between gap-2 border-b border-white/10 dark:border-white/5 pb-1 text-[9px] font-bold"
                             :class="msg.sender === 'user' ? 'text-emerald-200' : 'text-emerald-700 dark:text-[#a3e635]'">
                            <span x-text="msg.sender === 'user' ? 'Anda' : '🤖 Robbani AI'"></span>
                            <span x-text="msg.time" class="opacity-75"></span>
                        </div>

                        <div class="leading-relaxed font-medium text-xs break-words" x-html="formatMarkdown(msg.text)"></div>
                    </div>

                </div>
            </template>

            <!-- Loading Spinner Indicator -->
            <div x-show="isLoading" class="flex justify-start">
                <div class="bg-white dark:bg-[#122615] border border-slate-200 dark:border-[#204724] p-3 rounded-2xl rounded-tl-none text-xs text-slate-500 dark:text-slate-300 flex items-center gap-2 shadow-xs">
                    <span class="w-4 h-4 border-2 border-emerald-600 border-t-transparent rounded-full animate-spin"></span>
                    <span class="font-bold text-[11px]">Robbani AI sedang berpikir...</span>
                </div>
            </div>

        </div>

        <!-- Quick Suggestion Chips -->
        <div class="p-2.5 bg-slate-100/90 dark:bg-[#0c1a0e] border-t border-slate-200/80 dark:border-[#1b3d1f] flex items-center gap-2 overflow-x-auto text-[10px] font-bold shrink-0 no-scrollbar">
            <button @click="sendMessage('Bagaimana cara mendaftar SPMB Online?')" class="px-3 py-1.5 rounded-full bg-white dark:bg-[#142c17] text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-[#224d26] hover:bg-emerald-50 hover:text-emerald-700 shrink-0 shadow-2xs transition-colors">
                📝 Pendaftaran SPMB
            </button>
            <button @click="sendMessage('Apa saja 4 Unit Sekolah di SIT Robbani?')" class="px-3 py-1.5 rounded-full bg-white dark:bg-[#142c17] text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-[#224d26] hover:bg-emerald-50 hover:text-emerald-700 shrink-0 shadow-2xs transition-colors">
                🏫 4 Unit Sekolah
            </button>
            <button @click="sendMessage('Berapa biaya SPP dan cara mengeceknya?')" class="px-3 py-1.5 rounded-full bg-white dark:bg-[#142c17] text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-[#224d26] hover:bg-emerald-50 hover:text-emerald-700 shrink-0 shadow-2xs transition-colors">
                💳 Rincian Biaya SPP
            </button>
            <button @click="sendMessage('Dimana lokasi kampus dan kontak WhatsApp?')" class="px-3 py-1.5 rounded-full bg-white dark:bg-[#142c17] text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-[#224d26] hover:bg-emerald-50 hover:text-emerald-700 shrink-0 shadow-2xs transition-colors">
                📍 Alamat &amp; Kontak
            </button>
        </div>

        <!-- Input Bar -->
        <div class="p-3 bg-white dark:bg-[#0c1a0e] border-t border-slate-200 dark:border-[#1b3d1f] shrink-0">
            <form @submit.prevent="sendMessage()" class="flex items-center gap-2">
                <input type="text" 
                       x-model="inputMessage" 
                       placeholder="Ketik pertanyaan seputar SIT Robbani..." 
                       class="flex-1 px-3.5 py-2.5 rounded-xl bg-slate-100 dark:bg-[#142c17] text-slate-900 dark:text-white text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600 border border-slate-200 dark:border-[#224d26]">
                <button type="submit" 
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
            messages: [
                {
                    sender: 'ai',
                    time: 'Baru saja',
                    text: 'Assalamu\'alaikum! 👋 Saya **Robbani AI Assistant**, asisten cerdas resmi SIT Robbani Ogan Ilir.\n\nAda yang bisa saya bantu mengenai Pendaftaran SPMB, 4 Unit Sekolah, Alamat Kampus, atau Pengecekan SPP?'
                }
            ],
            inputMessage: '',
            isLoading: false,
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
                        text: "Assalamu'alaikum! Terima kasih telah bertanya kepada Robbani AI Assistant.\n\nSIT Robbani Ogan Ilir menyelenggarakan jenjang KB/TKIT, SDIT, SMPIT, dan SMAIT Robbani.\n\nUntuk informasi pendaftaran santri baru, silakan kunjungi menu **[Pendaftaran SPMB]** (`/ppdb`) atau WhatsApp Admin **0811747472**."
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
                    .replace(/`(.*?)`/g, '<code class="bg-slate-100 dark:bg-slate-800 px-1.5 py-0.5 rounded text-emerald-600 dark:text-[#a3e635] font-mono text-[11px]">$1</code>')
                    .replace(/\n/g, '<br>');
            }
        }));
    });
</script>
