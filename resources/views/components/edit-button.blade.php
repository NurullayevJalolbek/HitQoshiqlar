@props([
    'href' => '#',
    'size' => 18,
])

<a href="{{ $href }}" class="btn btn-sm p-1" style="background:none; color:#f0bc74;">
    <i class="bi bi-pencil-square" style="font-size:{{ $size }}px; display:inline-block; width:{{ $size }}px; height:{{ $size }}px;"></i>
</a>
