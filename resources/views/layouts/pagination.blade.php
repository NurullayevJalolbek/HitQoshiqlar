<div class="pagination-block w-100 d-flex align-items-center justify-content-between mt-3">
    @if ($paginator->hasPages())
        <nav>
            <ul class="pagination pagination-round pagination-primary">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="disabled page-item" aria-disabled="true">
                            <a class="page-link">{{ $element }}</a>
                        </li>
                    @endif
                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link">{{ $page }}</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </nav>
    @endif

    @if ($paginator->items() && $paginator->lastPage() > 1)
        <div class="mx-4">
            <div>
                <p class="text-sm text-gray-500 leading-5">
                    {!! __('pagination.results', [
                        'first' => $paginator->firstItem(),
                        'last' => $paginator->lastItem(),
                        'total' => $paginator->total(),
                    ]) !!}
                </p>
            </div>
        </div>
    @endif
</div>