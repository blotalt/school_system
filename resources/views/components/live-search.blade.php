@props(['endpoint', 'placeholder' => '', 'name' => null, 'value' => null])
@php $wrapperId = 'live-search-' . \Illuminate\Support\Str::random(8); @endphp

<div {{ $attributes->merge(['class' => 'search-box-wrapper']) }} id="{{ $wrapperId }}" onclick="event.stopPropagation()">
    <div class="search-box">
        <input type="text" class="live-search-input" @if($name) name="{{ $name }}" @endif value="{{ $value }}" placeholder="{{ $placeholder }}" autocomplete="off">
        <button type="button" class="search-clear-btn live-search-clear" style="display:none;" aria-label="{{ __('nav.clear_search') }}">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <button type="submit" style="background:none;border:none;cursor:pointer;padding:0;display:flex;">
            <i class="fa-solid fa-magnifying-glass live-search-icon"></i>
        </button>
    </div>
    <div class="search-results live-search-results"></div>
</div>

@once
<script>
const LIVE_SEARCH_LABELS = {
    noResults: @json(__('nav.no_results_found')),
    searchFailed: @json(__('nav.search_failed')),
};
const LIVE_SEARCH_CATEGORY_ICONS = {
    Students: 'fa-user-graduate',
    Teachers: 'fa-chalkboard-user',
    Classes: 'fa-school',
    Exams: 'fa-clipboard',
    Homework: 'fa-book',
    Announcements: 'fa-bullhorn',
};

function escapeHtmlForSearch(value) {
    const div = document.createElement('div');
    div.textContent = value == null ? '' : String(value);
    return div.innerHTML;
}

function initLiveSearch(wrapperId, endpoint) {
    const wrapper = document.getElementById(wrapperId);
    if (!wrapper) return;
    const input = wrapper.querySelector('.live-search-input');
    const panel = wrapper.querySelector('.live-search-results');
    const icon = wrapper.querySelector('.live-search-icon');
    const clearBtn = wrapper.querySelector('.live-search-clear');

    let debounceTimer = null;
    let currentRequest = null;
    let activeIndex = -1;
    let items = [];

    function setLoading(isLoading) {
        icon.classList.toggle('fa-magnifying-glass', !isLoading);
        icon.classList.toggle('fa-spinner', isLoading);
        icon.classList.toggle('fa-spin', isLoading);
    }

    function setActive(index) {
        items.forEach(function(el) { el.classList.remove('active'); });
        activeIndex = index;
        if (activeIndex >= 0 && items[activeIndex]) {
            items[activeIndex].classList.add('active');
            items[activeIndex].scrollIntoView({ block: 'nearest' });
        }
    }

    function renderResults(groups) {
        const keys = Object.keys(groups || {});
        activeIndex = -1;

        if (keys.length === 0) {
            panel.innerHTML = '<div class="search-empty">' + LIVE_SEARCH_LABELS.noResults + '</div>';
            panel.classList.add('show');
            items = [];
            return;
        }

        panel.innerHTML = keys.map(function(group) {
            const groupItems = groups[group].map(function(item) {
                return '<a href="' + escapeHtmlForSearch(item.url) + '" class="search-result-item">'
                    + '<span class="search-result-title">' + escapeHtmlForSearch(item.title) + '</span>'
                    + '<span class="search-result-subtitle">' + escapeHtmlForSearch(item.subtitle || '') + '</span>'
                    + '</a>';
            }).join('');
            const groupIcon = LIVE_SEARCH_CATEGORY_ICONS[group] || 'fa-circle';
            return '<div class="search-group"><div class="search-group-label"><i class="fa-solid ' + groupIcon + '"></i> ' + escapeHtmlForSearch(group) + '</div>' + groupItems + '</div>';
        }).join('');
        panel.classList.add('show');
        items = Array.from(panel.querySelectorAll('.search-result-item'));
    }

    function renderError() {
        panel.innerHTML = '<div class="search-empty">' + LIVE_SEARCH_LABELS.searchFailed + '</div>';
        panel.classList.add('show');
        items = [];
    }

    function runSearch(q) {
        if (currentRequest) currentRequest.abort();
        const controller = new AbortController();
        currentRequest = controller;
        setLoading(true);

        fetch(endpoint + '?q=' + encodeURIComponent(q), { signal: controller.signal })
            .then(function(res) { return res.json(); })
            .then(function(data) { renderResults(data.results); })
            .catch(function(err) { if (err.name !== 'AbortError') renderError(); })
            .finally(function() { setLoading(false); });
    }

    input.addEventListener('input', function() {
        const q = input.value.trim();
        clearBtn.style.display = q.length ? 'flex' : 'none';
        clearTimeout(debounceTimer);

        if (q.length < 2) {
            panel.classList.remove('show');
            panel.innerHTML = '';
            items = [];
            return;
        }

        debounceTimer = setTimeout(function() { runSearch(q); }, 250);
    });

    input.addEventListener('keydown', function(e) {
        if (!panel.classList.contains('show') || items.length === 0) return;

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            setActive(activeIndex < items.length - 1 ? activeIndex + 1 : 0);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            setActive(activeIndex > 0 ? activeIndex - 1 : items.length - 1);
        } else if (e.key === 'Enter' && activeIndex >= 0) {
            // Only hijack Enter once the user has arrow-selected a suggestion —
            // a bare Enter should submit the surrounding form when there is one
            // (e.g. the admin Students/Teachers page's full-filter search).
            e.preventDefault();
            items[activeIndex]?.click();
        } else if (e.key === 'Escape') {
            panel.classList.remove('show');
            input.blur();
        }
    });

    input.addEventListener('focus', function() {
        if (panel.innerHTML.trim() !== '') panel.classList.add('show');
    });

    clearBtn.addEventListener('click', function() {
        input.value = '';
        clearBtn.style.display = 'none';
        panel.classList.remove('show');
        panel.innerHTML = '';
        items = [];
        input.focus();
    });

    document.addEventListener('click', function() {
        panel.classList.remove('show');
    });
}
</script>
@endonce

<script>
initLiveSearch(@js($wrapperId), @js($endpoint));
</script>
