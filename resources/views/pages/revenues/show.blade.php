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
    </style>
@endpush

@section('breadcrumb')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
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
                        {{ __('admin.revenue_card') ?? 'Tushum kartochkasi' }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <div class="revenue-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="revenue-title" id="headerPeriod">2025-Yanvar tushumlari</div>
                <div class="revenue-subtitle" id="headerAccount">
                    Hisob raqami: 20208000405500001001
                </div>
                <div class="mt-2 d-flex flex-wrap gap-2">
                    <span class="pill" id="headerCurrency">
                        <i class="fas fa-coins"></i> UZS
                    </span>
                    <span class="pill" id="headerTotal">
                        <i class="fas fa-sack-dollar"></i>
                        1 500 000 000 UZS
                    </span>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="mb-1">
                    <span class="status-badge status-detected" id="headerDetectedBadge">Aniqlangan</span>
                </div>
                <div class="revenue-subtitle" id="headerCounts">
                    ☑ <span id="headerDetectedCount">120</span> • ⚠
                    <span id="headerUndetectedCount">15</span> • ✖
                    <span id="headerClarifyCount">5</span>
                </div>
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
                <div class="filter-row mb-2">
                    <div class="row g-2 align-items-end">
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
                        <div class="col-md-3 d-flex gap-2">
                            <button class="btn btn-primary btn-sm w-100" type="button"
                                onclick="applyDetectedFilter()">
                                <i class="fas fa-filter me-1"></i> Filtrlash
                            </button>
                            <button class="btn btn-warning btn-sm w-100" type="button"
                                onclick="resetDetectedFilter()">
                                <i class="fas fa-times me-1"></i> Tozalash
                            </button>
                        </div>
                    </div>
                </div>

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
                <div class="filter-row mb-2">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label mb-1">Bank tranzaksiya ID / Hujjat raqami</label>
                            <input type="text" class="form-control form-control-sm" id="undetectedSearch"
                                placeholder="Matn bo‘yicha qidirish">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label mb-1">Sana</label>
                            <input type="date" class="form-control form-control-sm" id="undetectedSearchDate">
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <button class="btn btn-primary btn-sm w-100" type="button"
                                onclick="applyUndetectedFilter()">
                                <i class="fas fa-filter me-1"></i> Filtrlash
                            </button>
                            <button class="btn btn-warning btn-sm w-100" type="button"
                                onclick="resetUndetectedFilter()">
                                <i class="fas fa-times me-1"></i> Tozalash
                            </button>
                        </div>
                    </div>
                </div>

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
                <div class="filter-row mb-2">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label mb-1">Bank tranzaksiya ID / Hujjat raqami</label>
                            <input type="text" class="form-control form-control-sm" id="clarifySearch"
                                placeholder="Matn bo‘yicha qidirish">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label mb-1">Sana</label>
                            <input type="date" class="form-control form-control-sm" id="clarifySearchDate">
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <button class="btn btn-primary btn-sm w-100" type="button"
                                onclick="applyClarifyFilter()">
                                <i class="fas fa-filter me-1"></i> Filtrlash
                            </button>
                            <button class="btn btn-warning btn-sm w-100" type="button"
                                onclick="resetClarifyFilter()">
                                <i class="fas fa-times me-1"></i> Tozalash
                            </button>
                        </div>
                    </div>
                </div>

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
                        <button class="btn btn-outline-primary btn-sm mt-2" type="button"
                            onclick="addAttachProjectRow()">
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
        // Demo ma'lumotlar (keyin backend ma'lumotlari bilan almashtiriladi)
        const detectedPayments = [
            {
                id: 1,
                bank_id: 'TRX-2025-0001',
                doc_number: 'INV-001',
                date: '2025-01-05',
                amount: 15000000,
                currency: 'UZS',
                payer: 'OOO "Premium Invest"',
                details: 'PRJ-2024-001 bo‘yicha to‘lov',
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
                payer: 'Nomaʼlum mijoz',
                details: 'To‘lov maqsadi: kvartira uchun to‘lov',
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
                note: 'To‘lov maqsadida xatolik topildi',
            },
        ];

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

        function switchTab(tabName) {
            document.querySelectorAll('#revenueTabs .nav-link').forEach(btn => {
                btn.classList.toggle('active', btn.dataset.tab === tabName);
            });
            document.querySelectorAll('.tab-pane-content').forEach(content => {
                content.style.display = content.id === `tab-${tabName}` ? 'block' : 'none';
            });
        }

        function scrollTabs(direction) {
            const navTabs = document.getElementById('revenueTabs');
            const scrollAmount = 200;
            navTabs.scrollBy({
                left: direction === 'left' ? -scrollAmount : scrollAmount,
                behavior: 'smooth',
            });
        }

        function renderDetected() {
            const tbody = document.getElementById('detectedTableBody');
            if (!tbody) return;
            let html = '';
            detectedPayments.forEach(p => {
                html += `
                    <tr>
                        <td class="text-center">${p.id}</td>
                        <td>${escapeHtml(p.bank_id)}</td>
                        <td>${escapeHtml(p.doc_number)}</td>
                        <td>${escapeHtml(p.date)}</td>
                        <td class="text-end">${formatMoney(p.amount, p.currency)}</td>
                        <td>${escapeHtml(p.payer)}</td>
                        <td>${escapeHtml(p.details)}</td>
                        <td>${escapeHtml(p.project)}</td>
                        <td>${escapeHtml(p.contract)}</td>
                        <td>${escapeHtml(p.user)}</td>
                        <td>${escapeHtml(p.attached_at)}</td>
                        <td>${escapeHtml(p.comment || '')}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning" type="button"
                                onclick="moveToClarify(${p.id})">
                                <i class="fas fa-arrow-right-arrow-left me-1"></i>
                                Aniqlik kiritiladiganlarga
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
            let html = '';
            undetectedPayments.forEach(p => {
                html += `
                    <tr>
                        <td class="text-center">${p.id}</td>
                        <td>${escapeHtml(p.bank_id)}</td>
                        <td>${escapeHtml(p.doc_number)}</td>
                        <td>${escapeHtml(p.date)}</td>
                        <td class="text-end">${formatMoney(p.amount, p.currency)}</td>
                        <td>${escapeHtml(p.payer)}</td>
                        <td>${escapeHtml(p.details)}</td>
                        <td class="text-center">
                            <div class="d-flex flex-column gap-1">
                                <button class="btn btn-sm btn-outline-primary" type="button"
                                    onclick="openAttachModal(${p.id}, 'single')">
                                    Biriktirish
                                </button>
                                <button class="btn btn-sm btn-outline-primary" type="button"
                                    onclick="openAttachModal(${p.id}, 'multi')">
                                    Bir nechta loyihaga
                                </button>
                                <button class="btn btn-sm btn-outline-warning" type="button"
                                    onclick="moveToClarify(${p.id})">
                                    Aniqlik kiritiladiganlarga o‘tkazish
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" type="button"
                                    onclick="moveToOtherIncome(${p.id})">
                                    Boshqa daromadlarga o‘tkazish
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
            let html = '';
            clarifyPayments.forEach(p => {
                html += `
                    <tr>
                        <td class="text-center">${p.id}</td>
                        <td>${escapeHtml(p.bank_id)}</td>
                        <td>${escapeHtml(p.doc_number)}</td>
                        <td>${escapeHtml(p.date)}</td>
                        <td class="text-end">${formatMoney(p.amount, p.currency)}</td>
                        <td>${escapeHtml(p.payer)}</td>
                        <td>${escapeHtml(p.details)}</td>
                        <td>${escapeHtml(p.note || '')}</td>
                        <td class="text-center">
                            <div class="d-flex flex-column gap-1">
                                <button class="btn btn-sm btn-outline-primary" type="button"
                                    onclick="openAttachModal(${p.id}, 'single')">
                                    Biriktirish
                                </button>
                                <button class="btn btn-sm btn-outline-primary" type="button"
                                    onclick="openAttachModal(${p.id}, 'multi')">
                                    Bir nechta loyihaga
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" type="button"
                                    onclick="moveToOtherIncome(${p.id})">
                                    Boshqa daromadlarga o‘tkazish
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
            let html = '';
            historyItems.forEach(item => {
                html += `
                    <tr>
                        <td>${escapeHtml(item.datetime)}</td>
                        <td>${escapeHtml(item.user)}</td>
                        <td>${escapeHtml(item.action)}</td>
                        <td>${escapeHtml(item.from)}</td>
                        <td>${escapeHtml(item.to)}</td>
                        <td>${escapeHtml(item.note || '')}</td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
        }

        // Filtrlar (hozircha faqat UI darajasida, demo uchun)
        function applyDetectedFilter() {
            alert('Aniqlangan tushumlar bo‘yicha filtr backend bilan bog‘langandan so‘ng ishlaydi.');
        }
        function resetDetectedFilter() {
            document.getElementById('detectedSearchId').value = '';
            document.getElementById('detectedSearchDate').value = '';
            document.getElementById('detectedSearchAmount').value = '';
        }
        function applyUndetectedFilter() {
            alert('Aniqlanmagan tushumlar bo‘yicha filtr backend bilan bog‘langandan so‘ng ishlaydi.');
        }
        function resetUndetectedFilter() {
            document.getElementById('undetectedSearch').value = '';
            document.getElementById('undetectedSearchDate').value = '';
        }
        function applyClarifyFilter() {
            alert('Aniqlik kiritiladigan tushumlar bo‘yicha filtr backend bilan bog‘langandan so‘ng ishlaydi.');
        }
        function resetClarifyFilter() {
            document.getElementById('clarifySearch').value = '';
            document.getElementById('clarifySearchDate').value = '';
        }

        // Modallar
        function openAttachModal(id, mode) {
            const modalEl = document.getElementById('attachModal');
            const modal = new bootstrap.Modal(modalEl);

            const payment =
                undetectedPayments.find(p => p.id === id)
                || clarifyPayments.find(p => p.id === id);

            const infoBody = document.getElementById('attachModalPaymentInfo');
            infoBody.innerHTML = `
                <tr>
                    <td>${escapeHtml(payment.bank_id)}</td>
                    <td>${escapeHtml(payment.doc_number)}</td>
                    <td>${escapeHtml(payment.date)}</td>
                    <td class="text-end">${formatMoney(payment.amount, payment.currency)}</td>
                    <td>${escapeHtml(payment.payer)}</td>
                    <td>${escapeHtml(payment.details)}</td>
                </tr>
            `;

            const projectsBody = document.getElementById('attachProjectsBody');
            projectsBody.innerHTML = '';
            addAttachProjectRow();

            modal.show();
        }

        function addAttachProjectRow() {
            const tbody = document.getElementById('attachProjectsBody');
            if (!tbody) return;
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <select class="form-select form-select-sm">
                        <option value="">Loyihani tanlang</option>
                        <option value="PRJ-2024-001">PRJ-2024-001 - Premium Turar-joy</option>
                        <option value="PRJ-2024-002">PRJ-2024-002 - Ofis binosi</option>
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
                    <input type="text" class="form-control form-control-sm" placeholder="Summani kiriting">
                </td>
                <td>
                    <select class="form-select form-select-sm">
                        <option value="UZS">UZS</option>
                        <option value="USD">USD</option>
                    </select>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-danger" type="button"
                        onclick="this.closest('tr').remove()">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        }

        function saveAttachChanges() {
            alert('Biriktirish natijasini saqlash logikasi backend bilan bog‘langach ishlaydi.');
            const modal = bootstrap.Modal.getInstance(document.getElementById('attachModal'));
            modal.hide();
        }

        function moveToClarify(id) {
            alert('Tushumni "Aniqlik kiritiladigan" holatiga o‘tkazish backend orqali amalga oshiriladi.');
        }

        function moveToOtherIncome(id) {
            alert('Tushumni "Boshqa daromadlar" ga o‘tkazish backend orqali amalga oshiriladi.');
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Tab switching
            document.querySelectorAll('#revenueTabs .nav-link').forEach(btn => {
                btn.addEventListener('click', function () {
                    switchTab(this.dataset.tab);
                });
            });

            renderDetected();
            renderUndetected();
            renderClarify();
            renderHistory();
        });
    </script>
@endpush


