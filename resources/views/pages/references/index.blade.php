@extends('layouts.app')

@push('customCss')
    {{--    CSS Ko'dlari--}}
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4 breadcrumb-block">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Malumotnomalar</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    {{--    Content--}}

@endsection

@push('customJs')
    <script>
        // JS Ko'dlar'
    </script>
@endpush
