@props([
'url',
'text' => 'Tahrirlash'
])

<div class="d-flex gap-2 align-items-center flex-wrap">
    <a href="{{ $url }}"
        class="btn btn-primary btn-sm px-3 py-1"
        style="min-width: 90px;">
        <i class="fa-jelly-duo fa-solid fa-pencil" style="font-size: 0.85rem;"></i>
        {{ $text }}
    </a>
</div>