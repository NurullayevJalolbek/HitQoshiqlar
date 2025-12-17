@props([
'href' => '#', // delete route
'size' => 18, // icon o'lchami px
'color' => '#DC2626', // icon rangi (default qizil)
'tooltip' => 'O\'chirish', // tooltip
'class' => '', // qo‘shimcha class
])

<a href="javascript:void(0);" class="btn btn-sm p-0 {{ $class }}"
    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $tooltip }}" onclick="deleteModel('{{ $href }}')">
    <svg class="icon icon-xs text-danger status-blocked" data-bs-toggle="tooltip" fill="currentColor"
        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
            clip-rule="evenodd"></path>
    </svg>

</a>

