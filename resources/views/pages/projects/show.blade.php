@extends('layouts.app')

@push('customCss')
@endpush

@section('breadcrumb')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Loyiha  kartochkasi </li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#projectsFilterContent" aria-expanded="true"
                    aria-controls="projectsFilterContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">

        SHu yerga
    </div>
@endsection

@push('customJs')
    <script>
       //
    </script>
@endpush
