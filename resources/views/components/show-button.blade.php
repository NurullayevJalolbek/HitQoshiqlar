@props([
    'href' => '#',   // link
    'size' => 18,    // icon o'lchami
])

<a href="{{ $href }}" class="btn btn-sm p-1" style="background:none; color:#1F2937;">
    <i class="bi bi-eye-fill" style="font-size:{{ $size }}px; display:inline-block; width:{{ $size }}px; height:{{ $size }}px;"></i>
</a>
