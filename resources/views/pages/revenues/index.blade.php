@extends('layouts.app')

@push('customCss')
<style>
    .badge-identified { background-color: #16a34a; color: #fff; }
    .badge-unidentified { background-color: #f59e0b; color: #fff; }
    .badge-needs-clarify { background-color: #ef4444; color: #fff; }
    .small-muted { font-size: 12px; color: #6b7280; }
    .table tbody tr:hover { background: rgba(0,0,0,0.02); }
    .cursor-pointer { cursor: pointer; }
    .mono { font-family: monospace; }
    .card-actions button { margin-right: 6px; }
    .summary-card {
        border-left: 4px solid #3b82f6;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .summary-card.identified { border-left-color: #16a34a; }
    .summary-card.unidentified { border-left-color: #f59e0b; }
    .summary-card.needs-clarify { border-left-color: #ef4444; }
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
                    {{ __('Тушумлар') }}
                </li>
            </ol>
        </nav>
        <h2 class="h4">{{ __('Тушумлар (Revenues)') }}</h2>
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

    <!-- Controls -->
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="fas fa-upload"></i> {{ __('Import (CSV)') }}
        </button>
        <a href="#" id="downloadTemplate" class="btn btn-outline-secondary">
            <i class="fas fa-download"></i> {{ __('Шаблон юклаб олиш') }}
        </a>
        <button class="btn btn-success" id="exportBtn">
            <i class="fas fa-file-export"></i> {{ __('Export CSV') }}
        </button>

        <div class="ms-auto d-flex flex-wrap gap-2">
            <input type="text" id="searchInput" class="form-control" 
                   placeholder="{{ __('Қидириш: ID, ҳисоб, сумма, изоҳ') }}" 
                   style="min-width: 250px;">
            <select id="filterType" class="form-control" style="min-width: 180px;">
                <option value="">{{ __('Барчаси') }}</option>
                <option value="identified">{{ __('Аниқланган') }}</option>
                <option value="unidentified">{{ __('Аниқланмаган') }}</option>
                <option value="needs_clarify">{{ __('Аниқлик киритиладиган') }}</option>
            </select>
            <button class="btn btn-primary" id="applyFilter">
                <i class="fas fa-search"></i> {{ __('Қидириш') }}
            </button>
        </div>
    </div>

    <!-- Summary cards -->
    <div class="row mb-3" id="summaryRow">
        <!-- JavaScript bilan to'ldiriladi -->
    </div>

    <!-- Table -->
    <div class="card shadow border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover m-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Давр') }}</th>
                            <th>{{ __('Ҳисоб рақами') }}</th>
                            <th>{{ __('Умумий сумма') }}</th>
                            <th>{{ __('Аниқланган') }}</th>
                            <th>{{ __('Аниқланмаган') }}</th>
                            <th>{{ __('Аниқлик киритиш') }}</th>
                            <th>{{ __('Валюта') }}</th>
                            <th>{{ __('Юклаган') }}</th>
                            <th>{{ __('Охирги янгиланиш') }}</th>
                            <th>{{ __('Ҳолат') }}</th>
                            <th>{{ __('Амаллар') }}</th>
                        </tr>
                    </thead>
                    <tbody id="revenuesTableBody">
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
                        <h5 class="modal-title">{{ __('Тушумларни импорт қилиш (CSV)') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="small-muted">
                            {{ __('CSV формат: transaction_id, period, account, amount, currency, payer, details, project_hint') }}
                            <br><strong>project_hint</strong> {{ __('майдони платформадаги лойиҳа идентификатори ёки калит сўз бўлиши мумкин') }}
                        </p>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Файл танланг (CSV)') }}</label>
                            <input type="file" class="form-control" id="importFile" accept=".csv">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('Давр (масалан: 2025-11)') }}</label>
                            <input type="month" id="importPeriod" class="form-control">
                        </div>
                        <div class="form-text">
                            <a href="#" id="exampleDownload">{{ __('CSV мисолини юклаб олиш') }}</a>
                        </div>
                        <div class="mt-3" id="importPreview"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Бекор қилиш') }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            {{ __('Импорт қилиш ва сақлаш') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Тушум тафсилоти') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- top section -->
                    <div id="detailTop" class="mb-3"></div>

                    <!-- tabs -->
                    <ul class="nav nav-tabs" id="detailTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#infoTab">
                                {{ __('Маълумот') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#historyTab">
                                {{ __('Тарих') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="actions-tab" data-bs-toggle="tab" data-bs-target="#actionsTab">
                                {{ __('Амаллар') }}
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content p-3">
                        <div class="tab-pane fade show active" id="infoTab">
                            <div id="detailInfo"></div>
                        </div>
                        <div class="tab-pane fade" id="historyTab">
                            <ul id="detailHistory" class="list-group"></ul>
                        </div>
                        <div class="tab-pane fade" id="actionsTab">
                            <div id="detailActions" class="card-actions"></div>
                        </div>
                    </div>
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
    @include('pages.revenues._scripts')
@endpush