@extends('layouts.app')

@push('customCss')
    <style>
        .table-actions button,
        .table-actions a {
            transition: transform 0.2s, opacity 0.2s;
        }

        .table-actions button:hover,
        .table-actions a:hover {
            transform: scale(1.1);
            opacity: 0.8;
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

        .empty-state {
            padding: 4rem 0;
        }

        .empty-state i {
            font-size: 3.5rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .card {
            border-radius: 0.5rem;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .badge {
            padding: 0.5em 0.75em;
            font-weight: 500;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .status-badge.status-active::before {
            background-color: #28a745;
        }

        .status-badge.status-inactive::before {
            background-color: #dc3545;
        }

        .status-badge.status-pending::before {
            background-color: #ffc107;
        }

        .filter-card {
            background: #ffffff;
            border-radius: 0.5rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .btn-filter-apply {
            min-width: 100px;
        }

        .contract-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .contract-info small {
            color: #6c757d;
        }

        .company-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .company-name {
            font-weight: 600;
            color: #212529;
        }

        .company-inn {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .direction-badge {
            font-size: 0.85rem;
            padding: 0.4em 0.8em;
        }

        .table-responsive {
            border-radius: 0.5rem;
        }

        .action-btn {
            padding: 0.4rem 0.6rem;
            font-size: 0.875rem;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <!-- Breadcrumb -->
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.project_buyers') }}</li>
                </ol>
            </nav>
        </div>
        <!-- Tugmalar guruhi -->
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button class="btn btn-primary btn-sm d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#createBuyerModal">
                <i class="fas fa-plus"></i>
                <span class="d-none d-sm-inline">{{ __('Қўшиш') }}</span>
            </button>
            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#projectBuyerFilterContent" aria-expanded="true"
                aria-controls="projectBuyerFilterContent">
                <i class="fa-solid fa-list" style="font-size: 1.3rem;"></i>
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

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters -->
    @include('pages.project-buyers.filters')

    <!-- Main Table -->
    <div class="card card-body py-3 px-3 shadow-sm border-0 mt-3">
        <div class="table-responsive">
            <table class="table table-hover align-items-center mb-0">
                <thead class="table-dark">
                    @include('pages.project-buyers._columns')
                </thead>
                <tbody id="purchaser-table-body">
                    <!-- JavaScript bilan to'ldiriladi -->
                </tbody>
            </table>
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="empty-state text-center" style="display: none;">
            <i class="fas fa-inbox"></i>
            <h5 class="mt-3 mb-2 text-muted">{{ __('Маълумотлар топилмади') }}</h5>
            <p class="text-muted mb-0">{{ __('Ҳали ҳеч қандай маълумот қўшилмаган') }}</p>
        </div>

        <!-- Pagination -->
        <div id="paginationContainer" class="d-flex justify-content-between align-items-center mt-3">
            <!-- JavaScript bilan to'ldiriladi -->
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div class="modal fade" id="createBuyerModal" tabindex="-1" aria-labelledby="createBuyerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBuyerModalLabel">{{ __('Харидор қўшиш') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="buyerForm">
                        @csrf
                        <input type="hidden" id="buyerId" name="id">

                        <!-- Йўналиш -->
                        <div class="mb-3">
                            <label for="direction" class="form-label">{{ __('Йўналиш') }} <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="direction" name="direction" required>
                                <option value="">{{ __('Танланг') }}</option>
                                <option value="land">{{ __('Ер участкаси') }}</option>
                                <option value="construction">{{ __('Қурилиш') }}</option>
                                <option value="rent">{{ __('Ижара') }}</option>
                            </select>
                        </div>

                        <!-- Корхона маълумотлари -->
                        <h6 class="mb-3 text-primary">{{ __('Корхона маълумотлари') }}</h6>

                        <div class="mb-3">
                            <label for="company_name" class="form-label">{{ __('Корхона тўлиқ номи') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="company_name" name="company_name" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inn" class="form-label">{{ __('ИНН') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="inn" name="inn" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="activity_type" class="form-label">{{ __('Фаолият тури') }} <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="activity_type" name="activity_type" required>
                                    <option value="">{{ __('Танланг') }}</option>
                                    <option value="llc">{{ __('МЧЖ') }}</option>
                                    <option value="jsc">{{ __('АЖ') }}</option>
                                    <option value="individual">{{ __('ЯТТ') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="director_name" class="form-label">{{ __('Директор Ф.И.О.') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="director_name" name="director_name"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">{{ __('Телефон рақами') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="+998" required>
                            </div>
                        </div>

                        <!-- ЯТТ учун қўшимча майдонлар -->
                        <div id="individualFields" style="display: none;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="passport" class="form-label">{{ __('Паспорт маълумоти') }}</label>
                                    <input type="text" class="form-control" id="passport" name="passport">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pinfl" class="form-label">{{ __('ЖШШИР') }}</label>
                                    <input type="text" class="form-control" id="pinfl" name="pinfl"
                                        maxlength="14">
                                </div>
                            </div>
                        </div>

                        <!-- Шартнома маълумотлари -->
                        <h6 class="mb-3 text-primary mt-4">{{ __('Шартнома маълумотлари') }}</h6>

                        <div class="mb-3">
                            <label for="contract_file" class="form-label">{{ __('Шартнома файли') }}</label>
                            <input type="file" class="form-control" id="contract_file" name="contract_file"
                                accept=".pdf,.doc,.docx">
                            <small class="text-muted">{{ __('PDF, DOC, DOCX форматида') }}</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contract_number" class="form-label">{{ __('Шартнома рақами') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="contract_number" name="contract_number"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contract_date" class="form-label">{{ __('Шартнома санаси') }} <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="contract_date" name="contract_date"
                                    required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="payment_terms" class="form-label">{{ __('Тўлов шартлари') }}</label>
                            <textarea class="form-control" id="payment_terms" name="payment_terms" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Бекор қилиш') }}</button>
                    <button type="button" class="btn btn-primary" id="saveBuyerBtn">{{ __('Сақлаш') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Ўчиришни тасдиқлаш') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Ҳақиқатан ҳам ушбу маълумотни ўчирмоқчимисиз?') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Йўқ') }}</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">{{ __('Ҳа, ўчириш') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customJs')
    @include('pages.project-buyers._scripts')
@endpush
