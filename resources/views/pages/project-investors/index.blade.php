@extends('layouts.app')

@push('customCss')
    <style>
        /* Optimallashtrilgan CSS */
        .filter-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        /* Jadval optimizatsiyasi */
        .investor-table {
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        .investor-table thead th {
            background: #1f2937;
            color: white;
            font-weight: 600;
            padding: 0.875rem 0.75rem;
            font-size: 0.8125rem;
            white-space: nowrap;
            border: none;
            vertical-align: middle;
        }

        .investor-table tbody td {
            padding: 0.875rem 0.75rem;
            vertical-align: middle;
            border-color: #e5e7eb;
        }

        .investor-table tbody tr {
            transition: background-color 0.15s ease;
        }

        .investor-table tbody tr:hover {
            background-color: #f9fafb;
        }

        /* Badge'lar - Login-histories va Investors stillari bilan bir xil */
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

        .badge-status-active {
            background: rgba(0, 200, 83, 0.15);
            color: #0f9d58;
        }

        .badge-status-blocked {
            background: rgba(255, 0, 0, 0.15);
            color: #d93025;
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

        /* Ma'lumot ko'rinishi */
        .company-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.125rem;
            font-size: 0.875rem;
        }

        .company-info {
            font-size: 0.75rem;
            color: #6b7280;
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

        /* Loading state */
        .loading-row td {
            text-align: center;
            padding: 3rem !important;
            color: #6b7280;
        }

        .loading-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
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
            .investor-table {
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

        /* Certificate link */
        .certificate-link {
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.75rem;
        }

        .certificate-link:hover {
            text-decoration: underline;
        }

        /* Ustunlarni vizual qisqartirish (ma'lumot saqlanadi, ustun ko'rinmaydi) */
        .investor-table th.col-inn,
        .investor-table td.col-inn,

        .investor-table th.col-phone,
        .investor-table td.col-phone,

        .investor-table th.col-email,
        .investor-table td.col-email,

        .investor-table th.col-regno,
        .investor-table td.col-regno,

        .investor-table th.col-regorg,
        .investor-table td.col-regorg,

        .investor-table th.col-jshshir,
        .investor-table td.col-jshshir,

        .investor-table th.col-sharepct,
        .investor-table td.col-sharepct {
            display: none;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3 mb-2"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.project_investors') }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <a href="{{ route('admin.project-investors.create') }}" class="btn btn-primary btn-sm px-3 py-2">
                <i class="fas fa-plus me-1"></i> {{ __('admin.add') }}
            </a>
            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#projectInvestorFilterContent" aria-expanded="true"
                aria-controls="projectInvestorFilterContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')
    @php
        $statuses = [
            'Faol' => 'Faol',
            'Bloklangan' => 'Bloklangan',
        ];
        $activityTypes = [
            'MChJ' => 'MChJ',
            'AJ' => 'AJ',
            'YaTT' => 'YaTT',
        ];
    @endphp

    <!-- Filter qismi -->
    <div class="filter-card mb-3 collapse show" id="projectInvestorFilterContent">
        <div class="p-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="searchInput" class="form-label mb-2">{{ __('admin.search') }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0"
                            placeholder="{{ __('admin.enterprise_name') }}">
                    </div>
                </div>

                <x-select-with-search name="activityTypeFilter" label="Faoliyat turi" :datas="$activityTypes" colMd="3"
                    placeholder="Barchasi" :selected="request()->get('activityTypeFilter', '')" :selectSearch=false
                    icon="fa-building text-primary" />

                <x-select-with-search name="statusFilter" label="Holati boyicha" :datas="$statuses" colMd="3"
                    placeholder="Barchasi" :selected="request()->get('statusFilter', '')" :selectSearch=false />

                <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />
            </div>
        </div>
    </div>

    <!-- Jadval -->
    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table investor-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
                <tr>
                    <th style="width: 50px;">{{ __('admin.id') }}</th>
                    <th style="min-width: 200px;">{{ __('Korxona to\'liq nomi') }}</th>

                    <th class="col-inn" style="width: 100px;">{{ __('INN') }}</th>

                    <th style="width: 90px;">{{ __('IFUT') }}</th>
                    <th style="width: 90px;">{{ __('Faoliyat turi') }}</th>
                    <th style="min-width: 200px;">{{ __('Manzil') }}</th>
                    <th style="min-width: 180px;">{{ __('Direktor F.I.O') }}</th>

                    <th style="width: 120px;">{{ __('Login') }}</th>
                    <th class="col-phone" style="width: 130px;">{{ __('Telefon') }}</th>
                    <th class="col-email" style="min-width: 150px;">{{ __('Email') }}</th>

                    <th style="width: 110px;">{{ __('Ro\'yxatdan o\'tgan sana') }}</th>
                    <th class="col-regno" style="width: 140px;">{{ __('Ro\'yxatdan o\'tkazish raqami') }}</th>
                    <th class="col-regorg" style="min-width: 200px;">{{ __('Ro\'yxatdan o\'tkazuvchi tashkilot') }}</th>

                    <th style="width: 120px;">{{ __('Pasport (YaTT)') }}</th>
                    <th class="col-jshshir" style="width: 130px;">{{ __('JSHSHIR (YaTT)') }}</th>

                    <th style="width: 90px;">{{ __('Holat') }}</th>
                    <th style="width: 110px;">{{ __('Investorlik holati sanasi') }}</th>
                    <th style="width: 120px;">{{ __('Sertifikat') }}</th>

                    <th style="width: 140px; text-align: right;">{{ __('Ulush (summa)') }}</th>
                    <th class="col-sharepct" style="width: 90px; text-align: center;">{{ __('Ulush (%)') }}</th>

                    <th style="width: 110px;">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody id="investorTableBody">
                <tr class="loading-row">
                    <td colspan="21">
                        <i class="fas fa-spinner loading-spinner me-2"></i>
                        <span>Investorlar yuklanmoqda...</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

@push('customJs')
    @include('pages.project-investors._scripts')
@endpush
