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

        .buyer-table thead th {
            background: #1f2937;
            color: white;
            font-weight: 600;
            padding: 0.875rem 0.75rem;
            font-size: 0.8125rem;
            white-space: nowrap;
            border: none;
            vertical-align: middle;
        }

        .buyer-table tbody td {
            padding: 0.875rem 0.75rem;
            vertical-align: middle;
            border-color: #e5e7eb;
        }

        .buyer-table tbody tr {
            transition: background-color 0.15s ease;
        }

        .buyer-table tbody tr:hover {
            background-color: #f9fafb;
        }

        /* Badge'lar */
        .badge-custom {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            white-space: nowrap;
            text-transform: capitalize;
        }

        .badge-activity-mchj {
            background: rgba(30, 64, 175, 0.15);
            color: #1e40af;
        }

        .badge-activity-aj {
            background: rgba(5, 101, 70, 0.15);
            color: #065f46;
        }

        .badge-activity-yatt {
            background: rgba(146, 64, 14, 0.15);
            color: #92400e;
        }

        .badge-direction-yer {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-direction-qurilish {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-direction-ijara {
            background: #dbeafe;
            color: #1e40af;
        }

        /* Amallar */
        .action-buttons {
            display: flex;
            gap: 0.375rem;
            justify-content: center;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
            background: white;
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
        }

        .btn-edit {
            color: #f59e0b;
        }

        .btn-edit:hover {
            background: #fffbeb;
            border-color: #f59e0b;
        }

        .btn-delete {
            color: #ef4444;
        }

        .btn-delete:hover {
            background: #fef2f2;
            border-color: #ef4444;
        }

        .value-primary {
            font-weight: 600;
            color: #1f2937;
            font-size: 0.875rem;
        }

        .value-secondary {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.125rem;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Responsive */
        @media (max-width: 1400px) {
            .buyer-table {
                font-size: 0.8125rem;
            }
        }

        /* Table scroll */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .certificate-link {
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.75rem;
        }

        .certificate-link:hover {
            text-decoration: underline;
        }

        /* ====== KENGAYTIRILGAN QISQARTIRISH (USTUNLARNI YASHIRISH) ======
               Ustunlar o‘chirilmaydi, faqat ko‘rinishi yopiladi.
            */
        .buyer-table th.col-inn,
        .buyer-table td.col-inn,
        .buyer-table th.col-phone,
        .buyer-table td.col-phone,
        .buyer-table th.col-pinfl,
        .buyer-table td.col-pinfl {
            display: none;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('admin.project_buyers') }}
                    </li>
                </ol>
            </nav>
        </div>

        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button class="btn btn-primary btn-sm d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#createBuyerModal">
                <i class="fas fa-plus"></i>
                <span class="d-none d-sm-inline">{{ __('Qo\'shish') }}</span>
            </button>

            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#projectBuyerFilterContent">
                <i class="fa-solid fa-list" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @include('pages.project-buyers.filters')

    <div class="card card-body py-3 px-3 shadow-sm border-0 mt-3">
        <div class="table-responsive">
            <table class="table buyer-table table-bordered table-hover table-striped align-items-center mb-0">
                <thead class="table-dark">
                    @include('pages.project-buyers._columns')
                </thead>
                <tbody id="buyerTableBody">
                    <tr class="loading-row">
                        <td colspan="14" class="text-center py-4 text-muted">
                            <i class="fas fa-spinner fa-spin me-2"></i>{{ __('yuklanmoqda') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="emptyState" class="empty-state text-center" style="display: none;">
            <i class="fas fa-inbox"></i>
            <h5 class="mt-3 mb-2 text-muted">{{ __('malumotlar_topilmadi') }}</h5>
            <p class="text-muted mb-0">{{ __('hali_malumot_qoshilmagan') }}</p>
        </div>
    </div>

    {{-- Create / Edit modal --}}
    <div class="modal fade" id="createBuyerModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('xaridor_qoshish') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="buyerForm">
                        @csrf
                        <input type="hidden" id="buyerId" name="id">

                        <div class="mb-3">
                            <label class="form-label">
                                {{ __('yonalish') }} <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="direction" required>
                                <option value="">{{ __('tanlang') }}</option>
                                <option value="land">{{ __('yer_uchastkasi') }}</option>
                                <option value="construction">{{ __('qurilish') }}</option>
                                <option value="rent">{{ __('ijara') }}</option>
                            </select>
                        </div>

                        <h6 class="mb-3 text-primary">{{ __('korxona_malumotlari') }}</h6>

                        <div class="mb-3">
                            <label class="form-label">
                                {{ __('korxona_toliq_nomi') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="company_name" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('inn') }} *</label>
                                <input type="text" class="form-control" name="inn" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('faoliyat_turi') }} *</label>
                                <select class="form-select" name="activity_type" required>
                                    <option value="">{{ __('tanlang') }}</option>
                                    <option value="llc">{{ __('mchj') }}</option>
                                    <option value="jsc">{{ __('aj') }}</option>
                                    <option value="individual">{{ __('yatt') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('direktor_fio') }} *</label>
                                <input type="text" class="form-control" name="director_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('telefon_raqami') }} *</label>
                                <input type="text" class="form-control" name="phone" placeholder="+998" required>
                            </div>
                        </div>

                        <h6 class="mb-3 text-primary mt-4">{{ __('shartnoma_malumotlari') }}</h6>

                        <div class="mb-3">
                            <label class="form-label">{{ __('shartnoma_fayli') }}</label>
                            <input type="file" class="form-control" name="contract_file">
                            <small class="text-muted">{{ __('pdf_doc_docx_format') }}</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('shartnoma_raqami') }} *</label>
                                <input type="text" class="form-control" name="contract_number" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('shartnoma_sanasi') }} *</label>
                                <input type="date" class="form-control" name="contract_date" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('tolov_shartlari') }}</label>
                            <textarea class="form-control" name="payment_terms"></textarea>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('bekor_qilish') }}
                    </button>
                    <button class="btn btn-primary" id="saveBuyerBtn">
                        {{ __('saqlash') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('ochirishni_tasdiqlash') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{ __('rostdan_ham_ochirmoqchimisiz') }}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('yoq') }}
                    </button>
                    <button class="btn btn-danger" id="confirmDeleteBtn">
                        {{ __('ha_ochirish') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('customJs')
    @include('pages.project-buyers._scripts')
@endpush