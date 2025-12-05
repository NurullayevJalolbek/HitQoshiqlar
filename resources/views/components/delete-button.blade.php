@props([
    'href' => '#',
    'size' => 18,
    'class' => 'delete-role', // oson JS bilan handle qilish uchun
])

<a href="{{ $href }}" class="btn btn-sm p-1 {{ $class }}" style="background:none; color:#DC2626;">
    <i class="fas fa-trash" style="font-size:{{ $size }}px; display:inline-block; width:{{ $size }}px; height:{{ $size }}px;"></i>
</a>
