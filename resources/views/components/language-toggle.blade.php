@php
    $currentLocale = app()->getLocale();
    $targetLocale = $currentLocale === 'sw' ? 'en' : 'sw';
@endphp

<a
    href="{{ route('language.switch', $targetLocale) }}"
    class="inline-flex items-center justify-center px-3 py-2 text-xs font-bold text-amber-200 bg-amber-900/60 border border-amber-800/50 rounded-xl hover:bg-amber-900 transition shadow-sm whitespace-nowrap"
    aria-label="{{ $targetLocale === 'sw' ? 'Switch to Swahili' : 'Switch to English' }}"
>
    {{ $targetLocale === 'sw' ? '(SW)' : '(EN)' }}
</a>

<script>
(function () {
    const lang = @json($currentLocale);
    document.documentElement.lang = lang;

    function applyLanguage() {
        document.querySelectorAll('[data-en][data-sw]').forEach(function (el) {
            if (el.children.length === 0) {
                const value = el.getAttribute('data-' + lang);
                if (value !== null) el.textContent = value;
            }
        });

        document.querySelectorAll('[data-en-placeholder][data-sw-placeholder]').forEach(function (el) {
            const value = el.getAttribute('data-' + lang + '-placeholder');
            if (value !== null) el.placeholder = value;
        });

        document.querySelectorAll('[data-en-title][data-sw-title]').forEach(function (el) {
            const value = el.getAttribute('data-' + lang + '-title');
            if (value !== null) el.title = value;
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', applyLanguage, { once: true });
    } else {
        applyLanguage();
    }
})();
</script>
