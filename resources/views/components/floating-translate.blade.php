<!-- Floating Google Translate Switcher Sesuai Referensi Pengguna (Bendera 3D + Kode Negara) -->
<div class="gtranslate_wrapper {{ $positionClass ?? 'fixed bottom-5 left-4 sm:left-5 z-40' }}"></div>

<style>
    /* Styling Floating Switcher Sesuai Screenshot Referensi Pengguna */
    .gt_float_switcher {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        border-radius: 8px !important;
        color: #333333 !important;
        line-height: 20px !important;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15), 0 1px 3px rgba(0, 0, 0, 0.1) !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        overflow: hidden !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    .gt_float_switcher img {
        vertical-align: middle !important;
        display: inline-block !important;
        width: 26px !important;
        height: auto !important;
        margin: 0 6px 0 0 !important;
        border-radius: 3px !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.15) !important;
    }
    .gt_float_switcher .gt-selected .gt-current-lang {
        padding: 6px 12px !important;
        color: #1e293b !important;
        font-weight: 800 !important;
        font-size: 12px !important;
        display: flex !important;
        align-items: center !important;
        gap: 2px !important;
        cursor: pointer !important;
    }
    .gt_float_switcher .gt_options {
        background: #ffffff !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    .gt_float_switcher .gt_options a {
        display: flex !important;
        align-items: center !important;
        padding: 7px 12px !important;
        color: #334155 !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        text-decoration: none !important;
        transition: background 0.15s ease, color 0.15s ease !important;
    }
    .gt_float_switcher .gt_options a:hover {
        background: #f1f5f9 !important;
        color: #047857 !important;
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
            "flag_style": "3d",
            "switcher_horizontal_position": "left",
            "switcher_vertical_position": "bottom",
            "float_switcher_open_direction": "top"
        };
    }

    // Format teks pilihan dropdown menjadi kode negara ringkas (AR, EN, ID) sesuai referensi pengguna
    document.addEventListener('DOMContentLoaded', function() {
        const formatLangCodes = () => {
            document.querySelectorAll('.gt_float_switcher .gt_options a').forEach(el => {
                const lang = el.getAttribute('data-gt-lang');
                if (lang && !el.dataset.codeFormatted) {
                    const img = el.querySelector('img');
                    el.innerHTML = '';
                    if (img) el.appendChild(img);
                    const codeSpan = document.createElement('span');
                    codeSpan.textContent = ' ' + lang.toUpperCase();
                    codeSpan.className = 'font-bold ml-1 text-slate-800';
                    el.appendChild(codeSpan);
                    el.dataset.codeFormatted = 'true';
                }
            });
        };

        const observer = new MutationObserver(() => formatLangCodes());
        observer.observe(document.body, { childList: true, subtree: true });
        setTimeout(formatLangCodes, 600);
        setTimeout(formatLangCodes, 1500);
    });
</script>
<script src="https://cdn.gtranslate.net/widgets/latest/float.js" defer></script>
