@props([
'href' => '#', // link yoki JS action
'icon' => 'bi-eye-fill', // default icon
'size' => 18, // icon o'lchami px
'color' => '#1F2937', // icon rangi
'tooltip' => '', // tooltip text
'onclick' => '', // JS onclick function
'class' => '', // qo‘shimcha class
])

<a
    href="{{ $href }}" data-bs-toggle="tooltip" title="Batafsil"
    class="btn btn-sm p-0 {{ $class }}"
    style="background:none; color: {{ $color }};"
    @if($tooltip) data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $tooltip }}" @endif
    @if($onclick) onclick="{{ $onclick }}" @endif>
    <i class="fa-sharp-duotone fa-solid fa-eye"></i>
</a>
