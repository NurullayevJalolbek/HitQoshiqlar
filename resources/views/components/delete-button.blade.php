@props([
    'href' => '#', // delete route
    'size' => 18, // icon o'lchami px
    'color' => '#DC2626', // icon rangi (default qizil)
    'tooltip' => 'O\'chirish', // tooltip
    'class' => '', // qo‘shimcha class
])

<a href="javascript:void(0)" class="btn btn-sm p-1 {{ $class }}"
    style="background:none; color: {{ $color }};" data-bs-toggle="tooltip" data-bs-placement="top"
    title="{{ $tooltip }}" onclick="deleteModel('{{ $href }}')">
    <i class="fas fa-trash"
        style="font-size: {{ $size }}px; display:inline-block; width: {{ $size }}px; height: {{ $size }}px;">
    </i>
</a>
