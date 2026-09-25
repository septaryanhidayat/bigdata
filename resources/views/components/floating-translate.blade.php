<!-- Floating Google Translate Switcher (Pojok Kiri Bawah) -->
<div class="{{ $positionClass ?? 'fixed bottom-5 left-4 sm:left-5 z-40' }} font-sans group">
    <div class="flex items-center gap-1.5 px-3 py-1.5 sm:px-3.5 sm:py-2 rounded-full bg-white/95 dark:bg-[#0c1a0e]/95 backdrop-blur-md border border-slate-200/90 dark:border-[#1c401f] shadow-xl hover:shadow-2xl transition-all duration-200 transform hover:-translate-y-0.5">
        <span class="text-xs sm:text-sm select-none" aria-hidden="true">🌐</span>
        <div class="gtranslate_wrapper"></div>
    </div>
</div>

<style>
    /* Minimalist Transparent Floating GTranslate Dropdown */
    .gtranslate_wrapper select.gt_selector {
        background-color: transparent !important;
        color: #0f172a !important;
        border: none !important;
        padding: 0 2px !important;
        font-size: 11px !important;
        font-weight: 800 !important;
        cursor: pointer !important;
        outline: none !important;
        font-family: inherit !important;
        box-shadow: none !important;
    }
    .dark .gtranslate_wrapper select.gt_selector {
        background-color: transparent !important;
        color: #f8fafc !important;
    }
    body { top: 0px !important; }
    .goog-te-banner-frame, .skiptranslate > iframe { display: none !important; }
</style>

<script>
    if (!window.gtranslateSettings) {
        window.gtranslateSettings = {
            "default_language": "id",
            "languages": ["id", "en", "ar"],
            "wrapper_selector": ".gtranslate_wrapper",
            "flag_size": 16,
            "switcher_horizontal_position": "inline",
            "alt_flags": {"en": "usa"}
        };
    }
</script>
<script src="https://cdn.gtranslate.net/widgets/latest/dropdown.js" defer></script>
