@extends('layouts.app')

@push('customCss')
    <style>
        :root {
            --primary-color: #2563eb;
            --success-color: #16a34a;
            --warning-color: #f59e0b;
            --danger-color: #dc2626;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-600: #4b5563;
            --gray-900: #111827;
            --border-radius: 0.5rem;
        }

        .revenue-header {
            background: #ffffff;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-top: 0.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--gray-200);
        }

        .revenue-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .revenue-subtitle {
            color: var(--gray-600);
            font-size: 0.9rem;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.6rem;
            border-radius: 999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .nav-tabs-container {
            position: relative;
            margin-bottom: 1rem;
            padding: 0 0.75rem;
        }

        .nav-tabs {
            border-bottom: 2px solid #e5e7eb;
            overflow-x: auto;
            white-space: nowrap;
            flex-wrap: nowrap;
            overflow-y: hidden;
            padding-bottom: 0.5rem;
            scroll-behavior: smooth;
        }

        .nav-tabs::-webkit-scrollbar {
            height: 8px;
        }

        .nav-tabs::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .nav-tabs::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        .nav-tabs .nav-link {
            height: 40px;
            color: #1F2937;
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
            background: #ebeaeaff;
            margin-right: 0.25rem;
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .nav-tabs .nav-link.active {
            color: #fff;
            background: #1F2937;
            border-bottom: 3px solid #2a3441;
            font-weight: 600;
        }

        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0;
            color: #1F2937;
            z-index: 10;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            pointer-events: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .nav-tabs-container:hover .scroll-btn {
            opacity: 1;
            pointer-events: all;
        }

        .scroll-btn-left {
            left: 6px;
        }

        .scroll-btn-right {
            right: 6px;
        }

        .scroll-btn.hidden {
            display: none;
        }

        .info-card {
            background: #ffffff;
            border-radius: var(--border-radius);
            padding: 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid var(--gray-200);
        }

        .info-card-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tab-content-inner {
            padding: 0.5rem 0.25rem 0.25rem;
        }

        .status-badge {
            padding: 0.25rem 0.6rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-detected {
            background: #dcfce7;
            color: #166534;
        }

        .status-undetected {
            background: #fee2e2;
            color: #b91c1c;
        }

        .status-clarify {
            background: #fef3c7;
            color: #92400e;
        }

        .table-sm th,
        .table-sm td {
            font-size: 0.8rem;
            vertical-align: middle;
        }

        .filter-row {
            background: var(--gray-50);
            border-radius: var(--border-radius);
            padding: 0.75rem;
            margin-bottom: 0.5rem;
        }

        /* Optimallashtrilgan CSS */
        .filter-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 0.75rem;
            padding: 1.25rem;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        }

        .stats-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stats-card .stat-label {
            font-size: 0.85rem;
            opacity: 0.9;
        }

        /* Jadval optimizatsiyasi */
        .project-table {
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        .project-table thead th {
            background: #1f2937;
            color: white;
            font-weight: 600;
            padding: 0.875rem 0.75rem;
            font-size: 0.8125rem;
            white-space: nowrap;
            border: none;
            vertical-align: middle;
        }

        .project-table tbody td {
            padding: 0.875rem 0.75rem;
            vertical-align: middle;
            border-color: #e5e7eb;
        }

        .project-table tbody tr {
            transition: background-color 0.15s ease;
        }

        .project-table tbody tr:hover {
            background-color: #f9fafb;
        }

        /* Rasm optimizatsiyasi */
        .project-img {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 2px solid #fff;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .project-img:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Image Modal Styles */
        .image-modal .modal-dialog {
            max-width: 90vw;
            max-height: 90vh;
            width: auto;
            margin: 1.75rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-modal .modal-content {
            background: transparent;
            border: none;
            width: fit-content;
            max-width: 90vw;
            max-height: 90vh;
            margin: auto;
        }

        .image-modal .modal-body {
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            width: fit-content;
            max-width: 90vw;
            max-height: 90vh;
            margin: auto;
        }

        .image-modal img {
            max-width: 90vw;
            max-height: 90vh;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 0.5rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            display: block;
            margin: auto;
        }

        .image-modal .btn-close {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 255, 255, 0.95);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e");
            background-size: 16px;
            background-repeat: no-repeat;
            background-position: center;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            opacity: 1;
            z-index: 1051;
            border: 2px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            filter: none;
        }

        .image-modal .btn-close:hover {
            background-color: rgba(255, 255, 255, 1);
            border-color: rgba(0, 0, 0, 0.2);
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

        .badge-category-yer {
            background: rgba(5, 101, 70, 0.15);
            color: #065f46;
        }

        .badge-category-qurilish {
            background: rgba(30, 64, 175, 0.15);
            color: #1e40af;
        }

        .badge-category-ijara {
            background: rgba(146, 64, 14, 0.15);
            color: #92400e;
        }

        .badge-status-faol {
            background: rgba(0, 200, 83, 0.15);
            color: #0f9d58;
        }

        .badge-status-rejalashtirilgan {
            background: rgba(30, 64, 175, 0.15);
            color: #1e40af;
        }

        .badge-status-yakunlangan {
            background: rgba(55, 65, 81, 0.15);
            color: #374151;
        }

        .badge-status-nofaol {
            background: rgba(255, 0, 0, 0.15);
            color: #d93025;
        }

        /* Progress bar with dynamic colors */
        .progress-wrapper {
            min-width: 100px;
        }

        .progress-custom {
            height: 6px;
            background: #e5e7eb;
            border-radius: 1rem;
            overflow: hidden;
            margin-bottom: 0.25rem;
        }

        .progress-bar-custom {
            height: 100%;
            border-radius: 1rem;
            transition: width 0.3s ease;
        }

        .progress-bar-danger {
            background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%);
        }

        .progress-bar-warning {
            background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
        }

        .progress-bar-info {
            background: linear-gradient(90deg, #06b6d4 0%, #0891b2 100%);
        }

        .progress-bar-success {
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        }

        .progress-text {
            font-size: 0.7rem;
            color: #6b7280;
            font-weight: 500;
        }

        /* Raund ko'rsatkichlari - Horizontal */
        .round-indicators {
            display: flex;
            gap: 0.35rem;
            align-items: center;
            flex-wrap: nowrap;
        }

        .round-dot {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 600;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }

        .round-active {
            background: #3b82f6;
            color: white;
        }

        .round-completed {
            background: #10b981;
            color: white;
        }

        .round-pending {
            background: #f3f4f6;
            color: #9ca3af;
            border: 1px solid #e5e7eb;
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

        .btn-view {
            color: #3b82f6;
        }

        .btn-view:hover {
            background: #eff6ff;
            border-color: #3b82f6;
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
        .project-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.125rem;
            font-size: 0.875rem;
        }

        .project-location {
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
            .project-table {
                font-size: 0.8125rem;
            }

            .project-img {
                width: 48px;
                height: 48px;
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
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3 mb-2"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.revenues.index') }}">
                            {{ __('admin.revenues') ?? 'Tushumlar' }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ "Tushum kartochkasi" }}
                    </li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#projectsFilterContent" aria-expanded="true"
                aria-controls="projectsFilterContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="filter-card mb-3 collapse show" id="projectsFilterContent">
        <div class="p-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label mb-1">ID / Bank tranzaksiya ID</label>
                    <input type="text" class="form-control form-control-sm" id="detectedSearchId"
                        placeholder="ID bo‘yicha qidirish">
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-1">Sana</label>
                    <input type="date" class="form-control form-control-sm" id="detectedSearchDate">
                </div>
                <div class="col-md-3">
                    <label class="form-label mb-1">Summasi</label>
                    <input type="text" class="form-control form-control-sm" id="detectedSearchAmount"
                        placeholder="Summani kiriting">
                </div>
                <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />
            </div>
        </div>
    </div>

    <div class="card card-body shadow-sm border-0">
        <div class="nav-tabs-container">
            <button class="scroll-btn scroll-btn-left" onclick="scrollTabs('left')" id="scrollLeftBtn"
                aria-label="Scroll left">
                <i class="fas fa-chevron-left"></i>
            </button>
            <ul class="nav nav-tabs" id="revenueTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-tab="detected" type="button">
                        Aniqlangan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-tab="undetected" type="button">
                        Aniqlanmagan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-tab="clarify" type="button">
                        Aniqlik kiritiladigan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-tab="history" type="button">
                        O‘zgarishlar tarixi
                    </button>
                </li>
            </ul>
            <button class="scroll-btn scroll-btn-right" onclick="scrollTabs('right')" id="scrollRightBtn"
                aria-label="Scroll right">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <div class="tab-content-inner">
            {{-- Aniqlangan --}}
            <div id="tab-detected" class="tab-pane-content active">

                <div class="info-card">
                    <h5 class="info-card-title">
                        <i class="fas fa-list-check"></i>
                        Aniqlangan tushumlar
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover align-items-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Bank tranzaksiya ID</th>
                                    <th>Hujjat raqami</th>
                                    <th>Sana</th>
                                    <th>Summasi</th>
                                    <th>To‘lovchi</th>
                                    <th>To‘lov taʼriflari</th>
                                    <th>Biriktirilgan loyiha</th>
                                    <th>Shartnoma</th>
                                    <th>Biriktirgan foydalanuvchi</th>
                                    <th>Biriktirilgan sana</th>
                                    <th>Izoh</th>
                                    <th>Amallar</th>
                                </tr>
                            </thead>
                            <tbody id="detectedTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Aniqlanmagan --}}
            <div id="tab-undetected" class="tab-pane-content" style="display:none;">
                <div class="info-card">
                    <h5 class="info-card-title">
                        <i class="fas fa-circle-question"></i>
                        Aniqlanmagan tushumlar
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover align-items-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Bank tranzaksiya ID</th>
                                    <th>Hujjat raqami</th>
                                    <th>Sana</th>
                                    <th>Summasi</th>
                                    <th>To‘lovchi</th>
                                    <th>To‘lov taʼriflari</th>
                                    <th>Amallar</th>
                                </tr>
                            </thead>
                            <tbody id="undetectedTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Aniqlik kiritiladigan --}}
            <div id="tab-clarify" class="tab-pane-content" style="display:none;">
                <div class="info-card">
                    <h5 class="info-card-title">
                        <i class="fas fa-triangle-exclamation"></i>
                        Aniqlik kiritiladigan tushumlar
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover align-items-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Bank tranzaksiya ID</th>
                                    <th>Hujjat raqami</th>
                                    <th>Sana</th>
                                    <th>Summasi</th>
                                    <th>To‘lovchi</th>
                                    <th>To‘lov taʼriflari</th>
                                    <th>Izoh</th>
                                    <th>Amallar</th>
                                </tr>
                            </thead>
                            <tbody id="clarifyTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- O‘zgarishlar tarixi --}}
            <div id="tab-history" class="tab-pane-content" style="display:none;">
                <div class="info-card">
                    <h5 class="info-card-title">
                        <i class="fas fa-clock-rotate-left"></i>
                        O‘zgarishlar tarixi
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-items-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sana va vaqt</th>
                                    <th>Foydalanuvchi</th>
                                    <th>Amal turi</th>
                                    <th>Avvalgi holat</th>
                                    <th>Yangi holat</th>
                                    <th>Izoh</th>
                                </tr>
                            </thead>
                            <tbody id="historyTableBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Aniqlanmagan / aniqlik kiritiladigan tushumlarni biriktirish modallari uchun joy (faqat UI, logika keyin) --}}
    <div class="modal fade" id="attachModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-link me-1"></i>
                        Tushumni loyiha(lar)ga biriktirish
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="info-card mb-3">
                        <h6 class="info-card-title mb-2">
                            <i class="fas fa-receipt"></i>
                            Tushum maʼlumotlari
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Bank tranzaksiya ID</th>
                                        <th>Hujjat raqami</th>
                                        <th>Sana</th>
                                        <th>Summasi</th>
                                        <th>To‘lovchi</th>
                                        <th>To‘lov taʼriflari</th>
                                    </tr>
                                </thead>
                                <tbody id="attachModalPaymentInfo">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="info-card">
                        <h6 class="info-card-title mb-2">
                            <i class="fas fa-diagram-project"></i>
                            Investitsion loyihalarga biriktirish
                        </h6>
                        <p class="text-muted mb-2" style="font-size: 0.8rem;">
                            Tushum summasini bitta yoki bir nechta investitsion loyihaga taqsimlang. Taqsimlangan jami
                            summa umumiy tushum qiymatidan oshmasligi kerak.
                        </p>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0" id="attachProjectsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Loyiha</th>
                                        <th>Yo‘nalishi</th>
                                        <th>Ajratilayotgan summa</th>
                                        <th>Valyuta</th>
                                        <th>Amal</th>
                                    </tr>
                                </thead>
                                <tbody id="attachProjectsBody">
                                </tbody>
                            </table>
                        </div>
                        <button class="btn btn-outline-primary btn-sm mt-2" type="button" onclick="addAttachProjectRow()">
                            <i class="fas fa-plus me-1"></i>
                            Loyiha qo‘shish
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                        Bekor qilish
                    </button>
                    <button class="btn btn-primary btn-sm" type="button" onclick="saveAttachChanges()">
                        <i class="fas fa-save me-1"></i> Saqlash
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customJs')
    <script>
        // SHOW.BLADE.PHP uchun JavaScript qismi (yaxshilangan)

        // Demo ma'lumotlar
        const detectedPayments = [
            {
                id: 1,
                bank_id: 'TRX-2025-0001',
                doc_number: 'INV-001',
                date: '2025-01-05',
                amount: 15000000,
                currency: 'UZS',
                payer: 'OOO "Premium Invest"',
                details: 'PRJ-2024-001 bo\'yicha to\'lov',
                project: 'PRJ-2024-001 - Premium Turar-joy',
                contract: 'CNT-2025-001',
                user: 'Abdullayev J.M.',
                attached_at: '2025-01-05 14:22',
                comment: '',
            },
        ];

        const undetectedPayments = [
            {
                id: 21,
                bank_id: 'TRX-2025-0101',
                doc_number: 'DOC-991',
                date: '2025-01-07',
                amount: 25000000,
                currency: 'UZS',
                payer: 'Noma\'lum mijoz',
                details: 'To\'lov maqsadi: kvartira uchun to\'lov',
            },
        ];

        const clarifyPayments = [
            {
                id: 31,
                bank_id: 'TRX-2025-0201',
                doc_number: 'DOC-150',
                date: '2025-01-09',
                amount: 30000000,
                currency: 'UZS',
                payer: 'OOO "Boshqa daromad"',
                details: 'Boshqa turdagi tushum',
                note: 'Ehtimol, boshqa daromad sifatida qayd etiladi',
            },
        ];

        const historyItems = [
            {
                datetime: '2025-01-05 14:22',
                user: 'Abdullayev J.M.',
                action: 'Aniqlanmagan → Aniqlangan',
                from: 'Aniqlanmagan',
                to: 'Aniqlangan',
                note: 'PRJ-2024-001 loyihasiga biriktirildi',
            },
            {
                datetime: '2025-01-06 10:05',
                user: 'Karimova D.R.',
                action: 'Aniqlangan → Aniqlik kiritiladigan',
                from: 'Aniqlangan',
                to: 'Aniqlik kiritiladigan',
                note: 'To\'lov maqsadida xatolik topildi',
            },
        ];

        // Helper functions
        function formatMoney(amount, currency) {
            if (amount == null) return '-';
            const formatted = new Intl.NumberFormat('uz-UZ').format(amount);
            return `${formatted} ${currency || ''}`.trim();
        }

        function escapeHtml(text) {
            if (!text) return '';
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;',
            };
            return String(text).replace(/[&<>"']/g, m => map[m]);
        }

        // Tab switching with better UX
        let currentTab = 'detected';

        function switchTab(tabName) {
            if (currentTab === tabName) return;

            currentTab = tabName;

            // Update active states
            document.querySelectorAll('#revenueTabs .nav-link').forEach(btn => {
                btn.classList.toggle('active', btn.dataset.tab === tabName);
            });

            // Hide all tabs with fade effect
            document.querySelectorAll('.tab-pane-content').forEach(content => {
                content.style.display = 'none';
            });

            // Show selected tab
            const selectedTab = document.getElementById(`tab-${tabName}`);
            if (selectedTab) {
                selectedTab.style.display = 'block';
            }

            // Update scroll buttons visibility
            updateScrollButtons();
        }

        // Scroll buttons management
        function updateScrollButtons() {
            const navTabs = document.getElementById('revenueTabs');
            const scrollLeftBtn = document.getElementById('scrollLeftBtn');
            const scrollRightBtn = document.getElementById('scrollRightBtn');

            if (!navTabs || !scrollLeftBtn || !scrollRightBtn) return;

            const canScrollLeft = navTabs.scrollLeft > 0;
            const canScrollRight = navTabs.scrollLeft < (navTabs.scrollWidth - navTabs.clientWidth);

            scrollLeftBtn.classList.toggle('hidden', !canScrollLeft);
            scrollRightBtn.classList.toggle('hidden', !canScrollRight);
        }

        function scrollTabs(direction) {
            const navTabs = document.getElementById('revenueTabs');
            const scrollAmount = 200;
            navTabs.scrollBy({
                left: direction === 'left' ? -scrollAmount : scrollAmount,
                behavior: 'smooth',
            });

            setTimeout(updateScrollButtons, 300);
        }

        // Render functions with improved HTML structure
        function renderDetected() {
            const tbody = document.getElementById('detectedTableBody');
            if (!tbody) return;

            if (!detectedPayments.length) {
                tbody.innerHTML = `
                <tr>
                    <td colspan="13" class="text-center py-4">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p class="mt-2 mb-0">Aniqlangan tushumlar yo'q</p>
                        </div>
                    </td>
                </tr>
            `;
                return;
            }

            let html = '';
            detectedPayments.forEach(p => {
                html += `
                <tr>
                    <td class="text-center">${p.id}</td>
                    <td><code class="text-primary">${escapeHtml(p.bank_id)}</code></td>
                    <td>${escapeHtml(p.doc_number)}</td>
                    <td><small>${escapeHtml(p.date)}</small></td>
                    <td class="text-end"><strong>${formatMoney(p.amount, p.currency)}</strong></td>
                    <td>${escapeHtml(p.payer)}</td>
                    <td><small>${escapeHtml(p.details)}</small></td>
                    <td>${escapeHtml(p.project)}</td>
                    <td>${escapeHtml(p.contract)}</td>
                    <td>${escapeHtml(p.user)}</td>
                    <td><small>${escapeHtml(p.attached_at)}</small></td>
                    <td><small>${escapeHtml(p.comment || '—')}</small></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-outline-warning" type="button"
                            onclick="moveToClarify(${p.id})">
                            <i class="fas fa-exchange-alt me-1"></i>
                            Aniqlik kiritish
                        </button>
                    </td>
                </tr>
            `;
            });
            tbody.innerHTML = html;
        }

        function renderUndetected() {
            const tbody = document.getElementById('undetectedTableBody');
            if (!tbody) return;

            if (!undetectedPayments.length) {
                tbody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p class="mt-2 mb-0">Aniqlanmagan tushumlar yo'q</p>
                        </div>
                    </td>
                </tr>
            `;
                return;
            }

            let html = '';
            undetectedPayments.forEach(p => {
                html += `
                <tr>
                    <td class="text-center">${p.id}</td>
                    <td><code class="text-primary">${escapeHtml(p.bank_id)}</code></td>
                    <td>${escapeHtml(p.doc_number)}</td>
                    <td><small>${escapeHtml(p.date)}</small></td>
                    <td class="text-end"><strong>${formatMoney(p.amount, p.currency)}</strong></td>
                    <td>${escapeHtml(p.payer)}</td>
                    <td><small>${escapeHtml(p.details)}</small></td>
                    <td class="text-center">
                        <div class="d-flex flex-column gap-1">
                            <button class="btn btn-sm btn-outline-primary" type="button"
                                onclick="openAttachModal(${p.id}, 'single')">
                                <i class="fas fa-link me-1"></i> Biriktirish
                            </button>
                            <button class="btn btn-sm btn-outline-primary" type="button"
                                onclick="openAttachModal(${p.id}, 'multi')">
                                <i class="fas fa-project-diagram me-1"></i> Bir nechta loyihaga
                            </button>
                            <button class="btn btn-sm btn-outline-warning" type="button"
                                onclick="moveToClarify(${p.id})">
                                <i class="fas fa-question-circle me-1"></i> Aniqlik kiritish
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" type="button"
                                onclick="moveToOtherIncome(${p.id})">
                                <i class="fas fa-folder-plus me-1"></i> Boshqa daromadlarga
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            });
            tbody.innerHTML = html;
        }

        function renderClarify() {
            const tbody = document.getElementById('clarifyTableBody');
            if (!tbody) return;

            if (!clarifyPayments.length) {
                tbody.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center py-4">
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p class="mt-2 mb-0">Aniqlik kiritiladigan tushumlar yo'q</p>
                        </div>
                    </td>
                </tr>
            `;
                return;
            }

            let html = '';
            clarifyPayments.forEach(p => {
                html += `
                <tr>
                    <td class="text-center">${p.id}</td>
                    <td><code class="text-primary">${escapeHtml(p.bank_id)}</code></td>
                    <td>${escapeHtml(p.doc_number)}</td>
                    <td><small>${escapeHtml(p.date)}</small></td>
                    <td class="text-end"><strong>${formatMoney(p.amount, p.currency)}</strong></td>
                    <td>${escapeHtml(p.payer)}</td>
                    <td><small>${escapeHtml(p.details)}</small></td>
                    <td><small class="text-warning">${escapeHtml(p.note || '—')}</small></td>
                    <td class="text-center">
                        <div class="d-flex flex-column gap-1">
                            <button class="btn btn-sm btn-outline-primary" type="button"
                                onclick="openAttachModal(${p.id}, 'single')">
                                <i class="fas fa-link me-1"></i> Biriktirish
                            </button>
                            <button class="btn btn-sm btn-outline-primary" type="button"
                                onclick="openAttachModal(${p.id}, 'multi')">
                                <i class="fas fa-project-diagram me-1"></i> Bir nechta loyihaga
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" type="button"
                                onclick="moveToOtherIncome(${p.id})">
                                <i class="fas fa-folder-plus me-1"></i> Boshqa daromadlarga
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            });
            tbody.innerHTML = html;
        }

        function renderHistory() {
            const tbody = document.getElementById('historyTableBody');
            if (!tbody) return;

            if (!historyItems.length) {
                tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <div class="empty-state">
                            <i class="fas fa-history"></i>
                            <p class="mt-2 mb-0">O'zgarishlar tarixi yo'q</p>
                        </div>
                    </td>
                </tr>
            `;
                return;
            }

            let html = '';
            historyItems.forEach(item => {
                html += `
                <tr>
                    <td><small><i class="far fa-clock me-1"></i>${escapeHtml(item.datetime)}</small></td>
                    <td>${escapeHtml(item.user)}</td>
                    <td><span class="badge bg-info">${escapeHtml(item.action)}</span></td>
                    <td><span class="badge bg-secondary">${escapeHtml(item.from)}</span></td>
                    <td><span class="badge bg-success">${escapeHtml(item.to)}</span></td>
                    <td><small>${escapeHtml(item.note || '—')}</small></td>
                </tr>
            `;
            });
            tbody.innerHTML = html;
        }

        // Filter functions
        let detectedFilters = { id: '', date: '', amount: '' };

        function applyDetectedFilter() {
            detectedFilters = {
                id: document.getElementById('detectedSearchId')?.value || '',
                date: document.getElementById('detectedSearchDate')?.value || '',
                amount: document.getElementById('detectedSearchAmount')?.value || ''
            };

            console.log('Applying filters:', detectedFilters);
            alert('Filter qo\'llanildi (backend bilan bog\'lanadi)');
        }

        function resetDetectedFilter() {
            const idInput = document.getElementById('detectedSearchId');
            const dateInput = document.getElementById('detectedSearchDate');
            const amountInput = document.getElementById('detectedSearchAmount');

            if (idInput) idInput.value = '';
            if (dateInput) dateInput.value = '';
            if (amountInput) amountInput.value = '';

            detectedFilters = { id: '', date: '', amount: '' };
            renderDetected();
        }

        // Modal functions
        let currentAttachingPayment = null;
        let attachRowCounter = 0;

        function openAttachModal(id, mode) {
            const modalEl = document.getElementById('attachModal');
            if (!modalEl) return;

            const modal = new bootstrap.Modal(modalEl);

            const payment = [...undetectedPayments, ...clarifyPayments].find(p => p.id === id);
            if (!payment) return;

            currentAttachingPayment = payment;

            const infoBody = document.getElementById('attachModalPaymentInfo');
            if (infoBody) {
                infoBody.innerHTML = `
                <tr>
                    <td><code>${escapeHtml(payment.bank_id)}</code></td>
                    <td>${escapeHtml(payment.doc_number)}</td>
                    <td>${escapeHtml(payment.date)}</td>
                    <td class="text-end"><strong>${formatMoney(payment.amount, payment.currency)}</strong></td>
                    <td>${escapeHtml(payment.payer)}</td>
                    <td><small>${escapeHtml(payment.details)}</small></td>
                </tr>
            `;
            }

            const projectsBody = document.getElementById('attachProjectsBody');
            if (projectsBody) {
                projectsBody.innerHTML = '';
                attachRowCounter = 0;
                addAttachProjectRow();
            }

            modal.show();
        }

        function addAttachProjectRow() {
            const tbody = document.getElementById('attachProjectsBody');
            if (!tbody) return;

            attachRowCounter++;
            const row = document.createElement('tr');
            row.dataset.rowId = attachRowCounter;
            row.innerHTML = `
            <td>
                <select class="form-select form-select-sm">
                    <option value="">Loyihani tanlang</option>
                    <option value="PRJ-2024-001">PRJ-2024-001 - Premium Turar-joy</option>
                    <option value="PRJ-2024-002">PRJ-2024-002 - Ofis binosi</option>
                    <option value="PRJ-2024-003">PRJ-2024-003 - Savdo markazi</option>
                </select>
            </td>
            <td>
                <select class="form-select form-select-sm">
                    <option value="land">Yer uchastkasi</option>
                    <option value="construction">Qurilish</option>
                    <option value="rent">Ijara</option>
                </select>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm" 
                       placeholder="Summani kiriting" min="0" step="1000">
            </td>
            <td>
                <select class="form-select form-select-sm">
                    <option value="UZS">UZS</option>
                    <option value="USD">USD</option>
                </select>
            </td>
            <td class="text-center">
                <button class="btn btn-sm btn-outline-danger" type="button"
                    onclick="removeAttachProjectRow(${attachRowCounter})">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
            tbody.appendChild(row);
        }

        function removeAttachProjectRow(rowId) {
            const row = document.querySelector(`tr[data-row-id="${rowId}"]`);
            if (row) row.remove();
        }

        function saveAttachChanges() {
            const tbody = document.getElementById('attachProjectsBody');
            if (!tbody) return;

            const rows = tbody.querySelectorAll('tr');
            let totalAllocated = 0;
            let hasErrors = false;

            rows.forEach(row => {
                const project = row.querySelector('select')?.value;
                const amount = parseFloat(row.querySelector('input[type="number"]')?.value || 0);

                if (!project || amount <= 0) {
                    hasErrors = true;
                }

                totalAllocated += amount;
            });

            if (hasErrors) {
                alert('Iltimos, barcha maydonlarni to\'ldiring!');
                return;
            }

            if (currentAttachingPayment && totalAllocated > currentAttachingPayment.amount) {
                alert('Ajratilayotgan jami summa umumiy tushum summasidan oshib ketdi!');
                return;
            }

            alert('Biriktirish muvaffaqiyatli saqlandi (backend bilan bog\'lanadi)');
            const modal = bootstrap.Modal.getInstance(document.getElementById('attachModal'));
            if (modal) modal.hide();
        }

        function moveToClarify(id) {
            if (confirm('Ushbu tushumni "Aniqlik kiritiladigan" holatiga o\'tkazmoqchimisiz?')) {
                alert('Backend bilan bog\'langach o\'tkazish amalga oshiriladi');
            }
        }

        function moveToOtherIncome(id) {
            if (confirm('Ushbu tushumni "Boshqa daromadlar"ga o\'tkazmoqchimisiz?')) {
                alert('Backend bilan bog\'langach o\'tkazish amalga oshiriladi');
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function () {
            // Setup tabs
            document.querySelectorAll('#revenueTabs .nav-link').forEach(btn => {
                btn.addEventListener('click', function () {
                    switchTab(this.dataset.tab);
                });
            });

            // Setup scroll listener
            const navTabs = document.getElementById('revenueTabs');
            if (navTabs) {
                navTabs.addEventListener('scroll', updateScrollButtons);
                updateScrollButtons();
            }

            // Setup filter buttons
            const filterBtn = document.getElementById('filterBtn');
            const clearBtn = document.getElementById('clearBtn');

            if (filterBtn) filterBtn.addEventListener('click', applyDetectedFilter);
            if (clearBtn) clearBtn.addEventListener('click', resetDetectedFilter);

            // Render initial data
            renderDetected();
            renderUndetected();
            renderClarify();
            renderHistory();

            console.log('Revenues show page initialized successfully');
        });
    </script>
@endpush