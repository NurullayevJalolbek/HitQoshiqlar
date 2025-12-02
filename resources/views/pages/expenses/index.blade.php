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
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-card.found {
            border-left-color: #16a34a;
        }

        .stat-card.not-found {
            border-left-color: #ef4444;
        }

        .stat-card.need-check {
            border-left-color: #f59e0b;
        }

        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
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

        .badge-found {
            background-color: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: 600;
        }

        .badge-not-found {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: 600;
        }

        .badge-need-check {
            background-color: #fef3c7;
            color: #92400e;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: 600;
        }
    </style>
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
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.expenses') }}</li>
                </ol>
            </nav>
        </div>

        <!-- Tugmalar guruhi -->
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button class="btn btn-success btn-sm px-2 py-1" id="exportExcelBtn">
                <i class="fas fa-file-excel me-1" style="font-size: 0.85rem;"></i> Excel
            </button>

            <button class="btn btn-warning btn-sm text-dark px-2 py-1" id="importExcelBtn">
                <i class="fas fa-file-import me-1" style="font-size: 0.85rem;"></i> Import
            </button>


            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#expenseFilterContent" aria-expanded="true"
                    aria-controls="expenseFilterContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
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

    {{-- FILTER + SEARCH + IMPORT --}}
    <div class="filter-card mb-3 mt-2 collapse show" id="expenseFilterContent" style="transition: all 0.3s ease;">
        <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">{{ __('Давр') }}</label>
                    <input type="month" id="f_period" class="form-control"
                           placeholder="{{ __('2025-11') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">{{ __('Ҳисоб рақами') }}</label>
                    <input type="text" id="f_account" class="form-control"
                           placeholder="{{ __('Ҳисоб рақами') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">{{ __('Валюта') }}</label>
                    <select id="f_currency" class="form-select">
                        <option value="">{{ __('Ҳаммаси') }}</option>
                        <option value="UZS">UZS</option>
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                    </select>
                </div>

                <!-- Filter tugmalari -->
                <div class="col-md-2 d-flex gap-2">
                    <button id="filterBtn" class="btn btn-primary w-50">
                        <i class="fas fa-filter"></i> {{__('admin.search')}}
                    </button>
                    <button id="clearBtn" class="btn btn-warning w-50">
                        {{__('admin.clear')}}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="row mb-4" id="summaryRow">
        <!-- JavaScript bilan to'ldiriladi -->
    </div>



    {{-- TAB MENU --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white border-0">
            <div class="btn-group w-100" role="group">
                <button class="btn btn-outline-primary tab-btn active" data-tab="found">
                    <i class="fas fa-check-circle"></i> {{ __('Аниқланган') }}
                    <span class="badge bg-success ms-2" id="badge-found">0</span>
                </button>
                <button class="btn btn-outline-primary tab-btn" data-tab="not_found">
                    <i class="fas fa-times-circle"></i> {{ __('Аниқланмаган') }}
                    <span class="badge bg-danger ms-2" id="badge-not-found">0</span>
                </button>
                <button class="btn btn-outline-primary tab-btn" data-tab="need_check">
                    <i class="fas fa-question-circle"></i> {{ __('Аниқлиқ киритиладиган') }}
                    <span class="badge bg-warning ms-2" id="badge-need-check">0</span>
                </button>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table user-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
            <tr id="table-header"></tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>

    <div id="emptyState" class="text-center py-5" style="display: none;">
        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
        <p class="text-muted">{{ __('Маълумотлар топилмади') }}</p>
    </div>

    {{-- IMPORT MODAL --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Импорт харажат') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('Давр') }}</label>
                        <input type="month" id="import_period" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Валюта') }}</label>
                        <select id="import_currency" class="form-select">
                            <option value="UZS">UZS</option>
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Файл (CSV/Excel)') }}</label>
                        <input type="file" id="import_file" class="form-control" accept=".csv,.xlsx,.xls">
                    </div>
                    <div class="form-text">
                        <a href="#" id="downloadTemplateLink">{{ __('Шаблонни юклаб олиш') }}</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('Бекор қилиш') }}
                    </button>
                    <button type="button" onclick="saveImport()" class="btn btn-success">
                        {{ __('Сақлаш') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD MODAL --}}
    <div class="modal fade" id="cardModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Харажат маълумоти') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="cardContent">
                        <!-- JavaScript bilan to'ldiriladi -->
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
    @include('pages.expenses._scripts')
@endpush
