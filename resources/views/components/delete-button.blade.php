@props([
    'href' => '#',
    'size' => 18,
    'tooltip' => "Delete",
    'class' => 'delete-role', 
])

<a 
    class="cursor-pointer {{ $class }} btn btn-sm p-1" 
    data-bs-toggle="tooltip" 
    data-bs-placement="top" 
    data-bs-custom-class="tooltip-danger"
    title="{{ $tooltip }}"
    onclick="deleteModel('{{ $href }}')"
>
    <i class="fas fa-trash text-danger" style="font-size: {{ $size }}px; width: {{ $size }}px; height: {{ $size }}px;"></i>
</a>
