@extends('layouts.app')

@push('customCss')
<style>
    .status-paid { 
        background-color: #16a34a; 
        color: #fff; 
        padding: 4px 12px; 
        border-radius: 4px; 
        font-weight: 500;
    }
    .status-pending { 
        background-color: #f59e0b; 
        color: #fff; 
        padding: 4px 12px; 
        border-radius: 4px; 
        font-weight: 500;
    }
    .status-rejected { 
        background-color: #ef4444; 
        color: #fff; 
        padding: 4px 12px; 
        border-radius: 4px; 
        font-weight: 500;
    }
    .table tbody tr:hover {
        background-color: rgba(0,0,0,0.02);
    }
    .summary-card {
        border-left: 4px solid #3b82f6;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .summary-card.paid { border-left-color: #16a34a; }
    .summary-card.pending { border-left-color: #f59e0b; }
    .summary-card.rejected { border-left-color: #ef4444; }
    .action-btn {
        transition: all 0.2s;
    }
    .action-btn:hover {
        transform: scale(1.05);
    }
    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .loading-overlay.active {
        display: flex;
    }
    .empty-state {
        padding: 3rem 0;
        text-align: center;
    }
</style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4 breadcrumb-block">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __('Даромадлар') }}
                </li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">{{ __('Юкланмоқда...') }}</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- === SUMMARY CARDS === --}}
    <div class="row mb-4" id="summaryRow">
        <!-- JavaScript bilan to'ldiriladi -->
    </div>

    {{-- === FILTRLAR === --}}
    @include('pages.incomes.filters')

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-success me-2" id="exportExcelBtn">
            <i class="fas fa-file-excel"></i> {{ __('Export Excel') }}
        </button>
        <button class="btn btn-primary me-2" id="exportPdfBtn">
            <i class="fas fa-file-pdf"></i> {{ __('Export PDF') }}
        </button>
        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="fas fa-upload"></i> {{ __('Import Excel') }}
        </button>
    </div>

    <div class="card shadow border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered m-0">
                    <thead class="table-light">
                        @include('pages.incomes._columns')
                    </thead>
                    <tbody id="income-table-body">
                        <!-- JavaScript bilan to'ldiriladi -->
                    </tbody>
                </table>
            </div>

            <div id="emptyState" class="empty-state" style="display: none;">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">{{ __('Маълумотлар топилмади') }}</p>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="importForm">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Excel файл импорт қилиш') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">{{ __('Excel файл танланг') }}</label>
                            <input type="file" class="form-control" id="importFile" accept=".xlsx,.xls">
                        </div>
                        <div class="form-text">
                            <a href="#" id="downloadTemplate">{{ __('Excel шаблонни юклаб олиш') }}</a>
                        </div>
                        <div class="mt-3" id="importPreview"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Бекор қилиш') }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            {{ __('Импорт қилиш') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Даромад тафсилоти') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detailContent">
                    <!-- JavaScript bilan to'ldiriladi -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('Ёпиш') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('customJs')
    @include('pages.incomes._scripts')
@endpush