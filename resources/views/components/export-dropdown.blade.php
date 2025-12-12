@props([
'items' => [],
'urls' => [],
])

@php
$allItems = [
'excel' => ['label' => 'Excel', 'icon' => 'fas fa-file-excel', 'id' => 'exportExcelBtn'],
'csv' => ['label' => 'CSV', 'icon' => 'fas fa-file-csv', 'id' => 'exportCsvBtn'],
'pdf' => ['label' => 'PDF', 'icon' => 'fas fa-file-pdf', 'id' => 'exportPdfBtn'],
];
@endphp

<div class="dropdown d-inline-block" style="position: relative;">
    <button class="btn btn-success btn-sm dropdown-toggle px-3 py-1" type="button" id="exportDropdownBtn"
        data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-file-export me-1" style="font-size: 0.85rem;"></i> Export
    </button>
    <ul class="dropdown-menu" style="min-width: 100%;" aria-labelledby="exportDropdownBtn">
        @foreach($items as $itemKey)
        @if(isset($allItems[$itemKey]))
        <li>
            <a href="{{ $urls[$itemKey] ?? '#' }}" class="dropdown-item d-flex align-items-center" id="{{ $allItems[$itemKey]['id'] }}">
                <i class="{{ $allItems[$itemKey]['icon'] }} me-2" style="font-size: 0.85rem;"></i>
                {{ $allItems[$itemKey]['label'] }}
            </a>
        </li>
        @endif
        @endforeach
    </ul>
</div>