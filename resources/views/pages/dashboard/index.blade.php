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
            <li class="breadcrumb-item active" aria-current="page">{{__('admin.dashboard')}}</li>
        </ol>
    </nav>
</div>

<div class="dashboard-header">
    <div class="header-content">
        <h1 class="page-title">Investitsiya Dashboard</h1>
        <p class="page-subtitle">Barcha ko'rsatkichlarni real vaqtda kuzatib boring</p>
    </div>
    <div class="header-actions">
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-primary export-btn" onclick="exportData('pdf')">
                <i class="fas fa-file-pdf"></i> PDF
            </button>
            <button type="button" class="btn btn-sm btn-outline-success export-btn" onclick="exportData('excel')">
                <i class="fas fa-file-excel"></i> Excel
            </button>
            <button type="button" class="btn btn-sm btn-outline-info export-btn" onclick="exportData('csv')">
                <i class="fas fa-file-csv"></i> CSV
            </button>
        </div>
    </div>
</div>
@endsection

@section('content')
@include('pages.dashboard.partials.filters')
@include('pages.dashboard.partials.kpi-cards')
@include('pages.dashboard.partials.charts')
@endsection

@push('customJs')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="{{ asset('assets/js/dashboard-charts.js') }}"></script>
<script src="{{ asset('assets/js/dashboard-functions.js') }}"></script>
@endpush