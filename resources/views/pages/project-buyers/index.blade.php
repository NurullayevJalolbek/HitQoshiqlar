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



@endsection

@push('customJs')
    @include('pages.project-buyers._scripts')
@endpush