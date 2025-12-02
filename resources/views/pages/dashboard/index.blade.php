@extends('layouts.app')

@push('customCss')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
@endpush

@section('breadcrumb')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <!-- Breadcrumb -->
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.dashboard') }}</li>
                </ol>
            </nav>
        </div>

        <!-- Tugmalar guruhi -->
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button class="btn btn-success btn-sm px-2 py-1" id="exportExcelBtn">
                <i class="fas fa-file-excel me-1" style="font-size: 0.85rem;"></i> Excel
            </button>

            <!-- Export CSV -->
            <button class="btn btn-info btn-sm text-white px-2 py-1" id="exportCsvBtn">
                <i class="fas fa-file-csv me-1" style="font-size: 0.85rem;"></i> CSV
            </button>

            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#dashboardFilterContent" aria-expanded="true"
                    aria-controls="dashboardFilterContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')
    @include('pages.dashboard.partials.filters')
    @include('pages.dashboard.partials.kpi-cards')
    @include('pages.dashboard.partials.charts')
    @include('pages.dashboard.partials._scripts')
@endsection

@push('customJs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        window.dashboardTranslations = {
            months: @json(__('dashboard.months')),
            charts: @json(__('dashboard.charts')),
            messages: @json(__('dashboard.messages')),
            projectTypes: @json(__('dashboard.project_types')),
            investorTypes: @json(__('dashboard.investor_types')),
            currentLang: '{{ app()->getLocale() }}'
        };
    </script>

@endpush
