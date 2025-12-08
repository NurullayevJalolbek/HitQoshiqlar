@props([
    'href' => '#', // link
    'size' => 18, // icon o'lchami px
    'color' => '#f0bc74', // icon rangi (default sariq)
    'tooltip' => 'Tahrirlash', // tooltip
    'class' => '', // qo‘shimcha class
])

<a href="{{ $href }}" class="btn btn-sm p-1 {{ $class }}"
    style="background:none; color: {{ $color }};" data-bs-toggle="tooltip" data-bs-placement="top"
    title="{{ $tooltip }}">
    <i class="bi bi-pencil-square"
        style="font-size: {{ $size }}px; display:inline-block; width: {{ $size }}px; height: {{ $size }}px;">
    </i>
</a>
