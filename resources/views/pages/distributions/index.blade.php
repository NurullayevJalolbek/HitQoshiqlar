@extends('layouts.app')

@push('customCss')
<style>
    .tab-btn {
        transition: all 0.3s;
        border-bottom: 3px solid transparent;
    }
    .tab-btn.active {
        background-color: #3b82f6 !important;
        color: white !important;
        border-bottom-color: #1e40af;
    }
    .stat-card {
        border-left: 4px solid #3b82f6;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .stat-card.full { border-left-color: #16a34a; }
    .stat-card.limited { border-left-color: #f59e0b; }
    .stat-card.profit { border-left-color: #06b6d4; }
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
    .table tbody tr {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .table tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.05);
    }
    .status-paid {
        background-color: #dcfce7;
        color: #166534;
        padding: 4px 12px;
        border-radius: 12px;
        font-weight: 600;
    }
    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
        padding: 4px 12px;
        border-radius: 12px;
        font-weight: 600;
    }
    .direction-badge {
        padding: 4px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }
    .direction-construction { background-color: #dbeafe; color: #1e40af; }
    .direction-land { background-color: #dcfce7; color: #166534; }
    .direction-rent { background-color: #fef3c7; color: #92400e; }
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
                    {{ __('Тақсимот') }}
                </li>
            </ol>
        </nav>
        <h2 class="h4">{{ __('Тақсимот бўлими') }}</h2>
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

    {{-- SUMMARY CARDS --}}
    <div class="row mb-4" id="summaryRow">
        <!-- JavaScript bilan to'ldiriladi -->
    </div>

    {{-- FILTER + SEARCH --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">{{ __('Лойиҳа номи') }}</label>
                    <input type="text" id="f_project" class="form-control" 
                           placeholder="{{ __('Лойиҳа номи') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">{{ __('Йўналиш') }}</label>
                    <select id="f_direction" class="form-select">
                        <option value="">{{ __('Ҳаммаси') }}</option>
                        <option value="construction">{{ __('Қурилиш') }}</option>
                        <option value="land">{{ __('Ер') }}</option>
                        <option value="rent">{{ __('Ижара') }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">{{ __('Давр') }}</label>
                    <input type="month" id="f_period" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Қидириш') }}</label>
                    <input type="text" id="f_search" class="form-control" 
                           placeholder="{{ __('Қидириш...') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button onclick="applyFilters()" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> {{ __('Излаш') }}
                    </button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 d-flex justify-content-end gap-2">
                    <button onclick="resetFilters()" class="btn btn-outline-secondary">
                        <i class="fas fa-undo"></i> {{ __('Тозалаш') }}
                    </button>
                    <button onclick="exportData()" class="btn btn-outline-success">
                        <i class="fas fa-download"></i> {{ __('Экспорт') }}
                    </button>
                    <button onclick="generateReport()" class="btn btn-success">
                        <i class="fas fa-file-invoice"></i> {{ __('Ҳисобот') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- TAB MENU --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white border-0">
            <div class="btn-group w-100" role="group">
                <button class="btn btn-outline-primary tab-btn active" data-tab="full_share">
                    <i class="fas fa-users"></i> {{ __('Тўлиқ шериклар') }}
                    <span class="badge bg-success ms-2" id="badge-full">0</span>
                </button>
                <button class="btn btn-outline-primary tab-btn" data-tab="limited_share">
                    <i class="fas fa-user"></i> {{ __('Коммандитчилар') }}
                    <span class="badge bg-warning ms-2" id="badge-limited">0</span>
                </button>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover m-0">
                    <thead class="table-light">
                        <tr id="table-header"></tr>
                    </thead>
                    <tbody id="table-body"></tbody>
                </table>
            </div>

            <div id="emptyState" class="text-center py-5" style="display: none;">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">{{ __('Маълумотлар топилмади') }}</p>
            </div>
        </div>
    </div>

    {{-- DISTRIBUTION MODAL --}}
    <div class="modal fade" id="distributionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Тақсимот тафсилоти') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="distributionContent">
                        <!-- JavaScript bilan to'ldiriladi -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('Ёпиш') }}
                    </button>
                    <button type="button" onclick="printDistribution()" class="btn btn-primary">
                        <i class="fas fa-print"></i> {{ __('Босиб чиқариш') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('customJs')
    @include('pages.distributions._scripts')
@endpush