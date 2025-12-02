@extends('layouts.app')

@push('customCss')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.css">
<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
@endpush

@section('breadcrumb')
<div class="breadcrumb-wrapper">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
                <a href="#"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('dashboard.title') }}</li>
        </ol>
    </nav>
</div>

<div class="dashboard-header-card">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div class="header-content">
            <h4 class="mb-1">{{ __('dashboard.page_title') }}</h4>
            <p class="text-muted mb-0 small">{{ __('dashboard.page_subtitle') }}</p>
        </div>
        <div class="header-actions">
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="exportData('pdf')">
                    <i class="fas fa-file-pdf"></i> {{ __('dashboard.export.pdf') }}
                </button>
                <button type="button" class="btn btn-sm btn-outline-success" onclick="exportData('excel')">
                    <i class="fas fa-file-excel"></i> {{ __('dashboard.export.excel') }}
                </button>
                <button type="button" class="btn btn-sm btn-outline-info" onclick="exportData('csv')">
                    <i class="fas fa-file-csv"></i> {{ __('dashboard.export.csv') }}
                </button>
            </div>
        </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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