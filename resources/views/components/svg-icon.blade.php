@php
    // style orqali width va height beramiz
    $style = "width: {$width}px; height: {$height}px;";
@endphp

<div class="svg-icon {{ $class }}" style="{{ $style }}">
    {!! $svgContent !!}
</div>
