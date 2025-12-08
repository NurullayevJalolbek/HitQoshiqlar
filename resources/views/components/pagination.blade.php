@props(['pageCount', 'currentPage'])
@if ($pageCount > 1)
    <ul class="pagination pagination-sm mb-0 mt-2">
        {{-- Previous --}}
        <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
            <a class="page-link" href="?page={{ $currentPage - 1 }}">&laquo;</a>
        </li>

        {{-- First pages --}}
        @for ($i = 1; $i <= min(3, $pageCount); $i++)
            <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
            </li>
        @endfor

        {{-- Middle dots --}}
        @if ($currentPage > 4)
            <li class="page-item disabled"><span class="page-link">...</span></li>
        @endif

        {{-- Current page (if not first/last) --}}
        @if ($currentPage > 3 && $currentPage < $pageCount - 2)
            <li class="page-item active">
                <span class="page-link">{{ $currentPage }}</span>
            </li>
        @endif

        {{-- Middle dots before last --}}
        @if ($currentPage < $pageCount - 3)
            <li class="page-item disabled"><span class="page-link">...</span></li>
        @endif

        {{-- Last pages --}}
        @for ($i = max($pageCount - 1, 4); $i <= $pageCount; $i++)
            @if ($i > 3)
                <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                    <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                </li>
            @endif
        @endfor

        {{-- Next --}}
        <li class="page-item {{ $currentPage == $pageCount ? 'disabled' : '' }}">
            <a class="page-link" href="?page={{ $currentPage + 1 }}">&raquo;</a>
        </li>
    </ul>
@endif