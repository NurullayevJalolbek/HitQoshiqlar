@extends('layouts.app')

@push('customCss')
    <style>
        .filter-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .badge-custom {
            padding: 0.35rem 0.65rem;
            border-radius: 0.35rem;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-block;
            white-space: nowrap;
            text-transform: capitalize;
        }

        /* Tushum holati badge'lari */
        .badge-status-detected {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-status-undetected {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-status-clarify {
            background: #fef3c7;
            color: #92400e;
        }

        .period-pill {
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

        .value-primary {
            font-weight: 600;
            color: #1f2937;
            font-size: 0.875rem;
        }

        .value-secondary {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .action-buttons {
            display: flex;
            gap: 0.375rem;
            justify-content: center;
        }
    </style>
@endpush

@section('breadcrumb')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3 mb-2"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('admin.revenues') ?? 'Tushumlar' }}
                    </li>
                </ol>
            </nav>
        </div>

        <div class="d-flex gap-2 align-items-center flex-wrap">
            {{-- Export dropdown (user index page style) --}}
            <x-export-dropdown :items="['excel','csv']" :urls="[
                    'excel' => '#',
                    'csv'   => '#',
                ]" />

            {{-- Import modalini ochish tugmasi --}}
            <button class="btn btn-primary btn-sm px-3 py-2" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fas fa-file-import me-1"></i> {{ __('admin.import') ?? 'Import' }}
            </button>

            {{-- Filter toggle --}}
            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#revenuesFilterContent" aria-expanded="true"
                aria-controls="revenuesFilterContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')
    {{-- Filter qismi (collapse faqat filterlarga) --}}
    <div class="filter-card mb-3 collapse show" id="revenuesFilterContent">
        <div class="p-3">
            <div class="row g-3 align-items-end">
                {{-- Qidiruv --}}
                <div class="col-md-3">
                    <label for="searchInput" class="form-label mb-2">{{ __('admin.search') ?? 'Qidiruv' }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0"
                            placeholder="{{ __('admin.search') ?? 'Davr, hisob raqami, foydalanuvchi...' }}">
                    </div>
                </div>

                {{-- Davr (oy) --}}
                <div class="col-md-3">
                    <label for="periodFilter" class="form-label mb-2">{{ __('admin.period') ?? 'Davr' }}</label>
                    <select id="periodFilter" class="form-select">
                        <option value="">{{ __('admin.all') ?? 'Barchasi' }}</option>
                        <option value="2025-01">2025-Yanvar</option>
                        <option value="2025-02">2025-Fevral</option>
                        <option value="2025-03">2025-Mart</option>
                    </select>
                </div>

                {{-- Valyuta --}}
                <div class="col-md-2">
                    <label for="currencyFilter" class="form-label mb-2">{{ __('admin.currency') ?? 'Valyuta' }}</label>
                    <select id="currencyFilter" class="form-select">
                        <option value="">{{ __('admin.all') ?? 'Barchasi' }}</option>
                        <option value="UZS">UZS</option>
                        <option value="USD">USD</option>
                    </select>
                </div>

                {{-- Holat bo‘yicha rangli filterlar (aniqlangan / aniqlanmagan / aniqlik kiritiladigan) --}}
                <div class="col-md-2">
                    <label for="statusFilter" class="form-label mb-2">{{ __('admin.status') ?? 'Turi' }}</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">{{ __('admin.all') ?? 'Barchasi' }}</option>
                        <option value="detected">Aniqlangan</option>
                        <option value="undetected">Aniqlanmagan</option>
                        <option value="clarify">Aniqlik kiritiladigan</option>
                    </select>
                </div>

                {{-- Tugmalar --}}
                <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />
            </div>
        </div>
    </div>

    {{-- Tushumlar ro‘yxati jadvali (collapse tashqarisida) --}}
    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table user-table table-bordered table-hover table-striped align-items-center" id="revenuesTable">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>{{ __('admin.period') ?? 'Tushum davri' }}</th>
                    <th>{{ __('admin.account_number') ?? 'Hisob raqami' }}</th>
                    <th>{{ __('admin.total_amount') ?? 'Umumiy tushum' }}</th>
                    <th>{{ __('admin.detected_count') ?? 'Aniqlanganlar' }}</th>
                    <th>{{ __('admin.undetected_count') ?? 'Aniqlanmaganlar' }}</th>
                    <th>{{ __('admin.clarify_count') ?? 'Aniqlik kiritiladiganlar' }}</th>
                    <th>{{ __('admin.currency') ?? 'Valyuta' }}</th>
                    <th>{{ __('admin.created_by') ?? 'Yaratgan foydalanuvchi' }}</th>
                    <th>{{ __('admin.updated_at') ?? 'Oxirgi yangilanish' }}</th>
                    <th class="text-center">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody id="revenuesTableBody">
                <tr>
                    <td colspan="11">
                        <div class="empty-state">
                            <i class="fas fa-spinner fa-spin"></i>
                            <div class="mt-2">
                                <h5>{{ __('admin.loading') ?? 'Ma‘lumotlar yuklanmoqda...' }}</h5>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Import modali --}}
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">
                        <i class="fas fa-file-import me-1"></i>
                        {{ __('admin.revenues_import') ?? 'Tushumlarni import qilish' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">{{ __('admin.period') ?? 'Davr' }}</label>
                            <select id="importPeriod" class="form-select">
                                <option value="2025-01">2025-Yanvar</option>
                                <option value="2025-02">2025-Fevral</option>
                                <option value="2025-03">2025-Mart</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('admin.currency') ?? 'Valyuta' }}</label>
                            <select id="importCurrency" class="form-select">
                                <option value="UZS">UZS</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('admin.file') ?? 'Import fayli' }}</label>
                            <input type="file" class="form-control" id="importFile">
                        </div>
                    </div>

                    <div class="mt-3">
                        <button class="btn btn-link p-0" id="downloadTemplateBtn" type="button">
                            <i class="fas fa-download me-1"></i>
                            {{ __('admin.download_template') ?? 'Shablonni yuklab olish (Excel)' }}
                        </button>
                    </div>

                    <div class="alert alert-info mt-3 mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        {{ __('admin.revenues_import_hint') ?? 'Import fayli kelishilgan shablon strukturasiga mos bo‘lishi kerak. Har bir qator bo‘yicha tizim avtomatik tarzda aniqlangan/aniqlanmagan turlariga ajratadi.' }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                        {{ __('admin.cancel') ?? 'Bekor qilish' }}
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" id="importSaveBtn">
                        <i class="fas fa-save me-1"></i>
                        {{ __('admin.save') ?? 'Saqlash' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customJs')
    <script>
        // Demo ma'lumotlar (keyin backend API bilan almashtiriladi)
        const DEFAULT_REVENUES = [
            {
                id: 1,
                period: '2025-01',
                period_label: '2025-Yanvar',
                account_number: '20208000405500001001',
                total_amount: 1500000000,
                detected_count: 120,
                undetected_count: 15,
                clarify_count: 5,
                currency: 'UZS',
                user_fio: 'Abdullayev Jamshid Murodovich',
                updated_at: '2025-02-01 12:34',
                status: 'detected',
            },
            {
                id: 2,
                period: '2025-02',
                period_label: '2025-Fevral',
                account_number: '20208000405500001001',
                total_amount: 980000000,
                detected_count: 70,
                undetected_count: 25,
                clarify_count: 10,
                currency: 'UZS',
                user_fio: 'Karimova Dilnoza Rustamovna',
                updated_at: '2025-03-05 09:20',
                status: 'undetected',
            },
            {
                id: 3,
                period: '2025-03',
                period_label: '2025-Mart',
                account_number: '20208000405500001002',
                total_amount: 450000000,
                detected_count: 20,
                undetected_count: 5,
                clarify_count: 30,
                currency: 'USD',
                user_fio: 'Islomov Sardor Akramovich',
                updated_at: '2025-04-01 16:10',
                status: 'clarify',
            },
        ];

        let revenues = [...DEFAULT_REVENUES];
        let defaultRevenues = [...DEFAULT_REVENUES];

        const revenuesTableBody = document.getElementById('revenuesTableBody');
        const searchInput = document.getElementById('searchInput');
        const periodFilter = document.getElementById('periodFilter');
        const currencyFilter = document.getElementById('currencyFilter');
        const statusFilter = document.getElementById('statusFilter');
        const filterBtn = document.getElementById('filterBtn');
        const clearBtn = document.getElementById('clearBtn');
        const exportBtn = document.getElementById('exportBtn');

        function formatMoneyShort(amount, currency) {
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

        function getStatusBadge(status) {
            if (status === 'detected') {
                return '<span class="badge badge-custom badge-status-detected">Aniqlangan</span>';
            }
            if (status === 'undetected') {
                return '<span class="badge badge-custom badge-status-undetected">Aniqlanmagan</span>';
            }
            if (status === 'clarify') {
                return '<span class="badge badge-custom badge-status-clarify">Aniqlik kiritiladigan</span>';
            }
            return '<span class="badge badge-custom">-</span>';
        }

        function renderRevenues(list = revenues) {
            if (!revenuesTableBody) return;

            if (!list.length) {
                revenuesTableBody.innerHTML = `
                    <tr>
                        <td colspan="11">
                            <div class="empty-state">
                                <i class="fas fa-folder-open"></i>
                                <div class="mt-2">
                                    <h5>Tushumlar topilmadi</h5>
                                    <p class="text-muted">Filterlarni o‘zgartiring yoki yangi tushumlarni import qiling</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            let html = '';
            list.forEach(item => {
                const showUrl = "{{ route('admin.revenues.show', ':id') }}".replace(':id', item.id);

                html += `
                    <tr class="revenue-row" data-id="${item.id}" style="cursor: pointer;">
                        <td class="text-center">${item.id}</td>
                        <td>
                            <span class="period-pill">
                                <i class="far fa-calendar-alt"></i>
                                ${escapeHtml(item.period_label)}
                            </span>
                        </td>
                        <td>
                            <div class="value-primary">${escapeHtml(item.account_number)}</div>
                        </td>
                        <td>
                            <div class="value-primary">${formatMoneyShort(item.total_amount, item.currency)}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success-subtle text-success fw-bold">
                                ☑ ${item.detected_count}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-danger-subtle text-danger fw-bold">
                                ⚠ ${item.undetected_count}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-warning-subtle text-warning fw-bold">
                                ✖ ${item.clarify_count}
                            </span>
                        </td>
                        <td class="text-center">${escapeHtml(item.currency)}</td>
                        <td>
                            <div class="value-primary">${escapeHtml(item.user_fio)}</div>
                        </td>
                        <td>
                            <div class="value-secondary">${escapeHtml(item.updated_at)}</div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="${showUrl}" class="btn btn-sm btn-light border">
                                    <i class="fas fa-eye text-primary"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                `;
            });

            revenuesTableBody.innerHTML = html;

            // Satr ustiga bosilganda kartochkaga o‘tish
            document.querySelectorAll('.revenue-row').forEach(row => {
                row.addEventListener('click', function (e) {
                    // Action tugmasiga bosilganda row click ishlamasin
                    if (e.target.closest('.action-buttons')) return;
                    const id = this.dataset.id;
                    if (!id) return;
                    const url = "{{ route('admin.revenues.show', ':id') }}".replace(':id', id);
                    window.location.href = url;
                });
            });
        }

        function applyFilter() {
            const search = (searchInput?.value || '').toLowerCase().trim();
            const period = periodFilter?.value || '';
            const currency = currencyFilter?.value || '';
            const status = statusFilter?.value || '';

            const filtered = defaultRevenues.filter(r => {
                const matchesSearch = !search
                    || (r.period_label && r.period_label.toLowerCase().includes(search))
                    || (r.account_number && r.account_number.includes(search))
                    || (r.user_fio && r.user_fio.toLowerCase().includes(search));

                const matchesPeriod = !period || r.period === period;
                const matchesCurrency = !currency || r.currency === currency;
                const matchesStatus = !status || r.status === status;

                return matchesSearch && matchesPeriod && matchesCurrency && matchesStatus;
            });

            renderRevenues(filtered);
        }

        function resetFilters() {
            if (searchInput) searchInput.value = '';
            if (periodFilter) periodFilter.value = '';
            if (currencyFilter) currencyFilter.value = '';
            if (statusFilter) statusFilter.value = '';
            renderRevenues(defaultRevenues);
        }

        function exportToExcel() {
            // Bu demo – keyin backend/export route bilan almashtiriladi
            alert('Excelga eksport qilish funksiyasi keyin backend bilan bog‘lanadi.');
        }

        function downloadTemplate() {
            alert('Shablon faylini yuklab olish funksiyasi keyin backend bilan bog‘lanadi.');
        }

        function importRevenues() {
            alert('Import qilish bo‘yicha backend logikasi keyin ulanadi. Hozircha demo.');
            const modal = bootstrap.Modal.getInstance(document.getElementById('importModal'));
            modal.hide();
        }

        document.addEventListener('DOMContentLoaded', function () {
            renderRevenues(revenues);

            if (filterBtn) filterBtn.addEventListener('click', applyFilter);
            if (clearBtn) clearBtn.addEventListener('click', resetFilters);

            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', function () {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(applyFilter, 300);
                });
                searchInput.addEventListener('keyup', function (e) {
                    if (e.key === 'Enter') applyFilter();
                });
            }

            if (periodFilter) periodFilter.addEventListener('change', applyFilter);
            if (currencyFilter) currencyFilter.addEventListener('change', applyFilter);
            if (statusFilter) statusFilter.addEventListener('change', applyFilter);
            if (exportBtn) exportBtn.addEventListener('click', exportToExcel);

            document.getElementById('downloadTemplateBtn')?.addEventListener('click', downloadTemplate);
            document.getElementById('importSaveBtn')?.addEventListener('click', importRevenues);
        });
    </script>
@endpush

