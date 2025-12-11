@props(['pageCount', 'currentPage'])



@push('customCss')

<style>
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 5px;
        align-items: center;
        position: relative;
    }

    .page-item {
        margin: 0;
        position: relative;
    }

    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        color: #1F2937;
        text-decoration: none;
        background-color: #fff;
        transition: all 0.3s;
        font-size: 14px;
        cursor: pointer;
        user-select: none;
    }

    .page-link:hover:not(.disabled) {
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    .page-item.active .page-link {
        background-color: #1F2937;
        border-color: #1F2937;
        color: #fff;
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }

    .page-dots {
        background-color: #f8f9fa;
        position: relative;
    }

    .page-input-popup {
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1050;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        width: 150px;
        margin-bottom: 5px;
    }

    .page-input-content {
        display: flex;
        align-items: center;
        gap: 6px;
        position: relative;
    }

    .page-input {
        flex: 1;
        padding: 6px 10px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        text-align: center;
        font-size: 14px;
        transition: border-color 0.3s;
    }

    .page-input:focus {
        outline: none;
        border-color: #1F2937;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
    }

    .page-input-btn {
        background: #1F2937;
        color: white;
        border: none;
        border-radius: 4px;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
        transition: background 0.3s;
    }

    .page-input-btn:hover {
        background: #1F2937;
    }

    .fa-solid {
        font-size: 12px;
    }

    /* Arrow for popup (bottom arrow) */
    .page-input-popup::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid #dee2e6;
    }

    .page-input-popup::before {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid white;
        margin-top: -1px;
        z-index: 1;
    }
</style>
@endpush


@if ($pageCount > 1)
<ul class="pagination pagination-sm mb-0 mt-2">
    {{-- Previous --}}
    <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
        <a class="page-link" href="?page={{ $currentPage - 1 }}">
            <i class="fa-solid fa-angle-left"></i>
        </a>
    </li>

    {{-- First page --}}
    @if ($currentPage == 1)
    <li class="page-item active">
        <span class="page-link">1</span>
    </li>
    @else
    <li class="page-item">
        <a class="page-link" href="?page=1">1</a>
    </li>
    @endif

    {{-- Left dots with input --}}
    @if ($currentPage > 3)
    <li class="page-item page-input-item">
        <button class="page-link page-dots" type="button" onclick="togglePageInput('left')">
            ...
        </button>
        <div class="page-input-popup left-popup" style="display: none;">
            <div class="page-input-content">
                <input type="number"
                    class="page-input"
                    min="2"
                    max="{{ min($currentPage - 1, $pageCount - 1) }}"
                    placeholder="Sahifa"
                    onkeypress="handlePageInputKeypress(event, 'left')">
                <button class="page-input-btn" onclick="goToPageInput('left')">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </div>
        </div>
    </li>
    @endif

    {{-- Middle pages around current --}}
    @if ($pageCount > 2)
    {{-- Pages before current --}}
    @if ($currentPage > 2 && $currentPage <= $pageCount - 1)
        @if ($currentPage - 1> 1)
        <li class="page-item">
            <a class="page-link" href="?page={{ $currentPage - 1 }}">{{ $currentPage - 1 }}</a>
        </li>
        @endif
        @endif

        {{-- Current page (if not first or last) --}}
        @if ($currentPage > 1 && $currentPage < $pageCount)
            <li class="page-item active">
            <span class="page-link">{{ $currentPage }}</span>
            </li>
            @endif

            {{-- Pages after current --}}
            @if ($currentPage >= 2 && $currentPage < $pageCount - 1)
                @if ($currentPage + 1 < $pageCount)
                <li class="page-item">
                <a class="page-link" href="?page={{ $currentPage + 1 }}">{{ $currentPage + 1 }}</a>
                </li>
                @endif
                @endif
                @endif

                {{-- Right dots with input --}}
                @if ($currentPage < $pageCount - 2)
                    <li class="page-item page-input-item">
                    <button class="page-link page-dots" type="button" onclick="togglePageInput('right')">
                        ...
                    </button>
                    <div class="page-input-popup right-popup" style="display: none;">
                        <div class="page-input-content">
                            <input type="number"
                                class="page-input"
                                min="{{ max($currentPage + 1, 2) }}"
                                max="{{ $pageCount - 1 }}"
                                placeholder="Sahifa"
                                onkeypress="handlePageInputKeypress(event, 'right')">
                            <button class="page-input-btn" onclick="goToPageInput('right')">
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    </li>
                    @endif

                    {{-- Last page (if more than 1 page) --}}
                    @if ($pageCount > 1)
                    @if ($currentPage == $pageCount)
                    <li class="page-item active">
                        <span class="page-link">{{ $pageCount }}</span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="?page={{ $pageCount }}">{{ $pageCount }}</a>
                    </li>
                    @endif
                    @endif

                    {{-- Next --}}
                    <li class="page-item {{ $currentPage == $pageCount ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ $currentPage + 1 }}">
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </li>
</ul>
@endif

@push('customJs')

<script>
    let activePopup = null;

    function togglePageInput(side) {
        const popup = document.querySelector(`.${side}-popup`);
        const allPopups = document.querySelectorAll('.page-input-popup');

        // Boshqa popuplarni yopish
        allPopups.forEach(p => {
            if (p !== popup) {
                p.style.display = 'none';
            }
        });

        // Click qilingan popupni ochish/yopish
        if (popup.style.display === 'block') {
            popup.style.display = 'none';
            activePopup = null;
        } else {
            popup.style.display = 'block';
            activePopup = side;

            // Inputga fokus qilish
            const input = popup.querySelector('.page-input');
            setTimeout(() => {
                input.focus();
                input.select();
            }, 10);
        }
    }

    function goToPageInput(side) {
        const popup = document.querySelector(`.${side}-popup`);
        if (!popup) return;

        const input = popup.querySelector('.page-input');
        let page = parseInt(input.value);

        if (!page || isNaN(page)) {
            alert('Iltimos, sahifa raqamini kiriting!');
            input.focus();
            return;
        }

        // Validate page number
        const min = parseInt(input.min);
        const max = parseInt(input.max);

        if (page < min) page = min;
        if (page > max) page = max;

        // Close popup
        popup.style.display = 'none';
        activePopup = null;

        // Navigate to page
        window.location.href = `?page=${page}`;
    }

    function handlePageInputKeypress(event, side) {
        if (event.key === 'Enter') {
            event.preventDefault();
            goToPageInput(side);
        }
    }

    // Sahifaning boshqa joyiga bosilganda popuplarni yopish
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.page-input-item')) {
            document.querySelectorAll('.page-input-popup').forEach(popup => {
                popup.style.display = 'none';
            });
            activePopup = null;
        }
    });

    // Escape tugmasini bosilganda popupni yopish
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && activePopup) {
            const popup = document.querySelector(`.${activePopup}-popup`);
            if (popup) {
                popup.style.display = 'none';
                activePopup = null;
            }
        }
    });
</script>

@endpush


