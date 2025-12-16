@extends('layouts.app')

@push('customCss')
    <style>
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
            font-size: 1.5rem;
            font-weight: 700;
        }

        .stats-card .stat-label {
            font-size: 0.8rem;
            opacity: 0.9;
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

        /* Loyiha kategoriyasi */
        .badge-category-rent {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-category-construction {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-category-land {
            background: #d1fae5;
            color: #065f46;
        }

        /* Holat badge'lari (tulov holati) */
        .badge-status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-status-paid {
            background: #dcfce7;
            color: #166534;
        }

        .badge-status-rejected {
            background: #fee2e2;
            color: #b91c1c;
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
                        {{ __('admin.incomes') ?? 'Daromadlar' }}
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

            {{-- Keyinchalik import zarur bo‘lsa shu yerda bo‘ladi --}}
            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#incomesFilterContent" aria-expanded="true"
                aria-controls="incomesFilterContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')
    {{-- Yuqori qisqa statistikalar – Tўлиқ sherik portfeli --}}
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stat-label">{{ __('admin.incomes.total_portfolio') ?? 'Umumiy daromad portfeli' }}</div>
                <div class="stat-value" id="statsTotalIncome">0</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stat-label">{{ __('admin.incomes.next_distribution') ?? 'Yaqin taqsimot davri' }}</div>
                <div class="stat-value" id="statsNextDistribution">-</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <div class="stat-label">{{ __('admin.incomes.waiting_payments') ?? 'Kutilayotgan to‘lovlar' }}</div>
                <div class="stat-value" id="statsPendingPayments">0</div>
            </div>
        </div>
    </div>

    {{-- Filter qismi (collapse faqat filterlarga) --}}
    <div class="filter-card mb-3 collapse show" id="incomesFilterContent">
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
                            placeholder="{{ __('admin.search') ?? 'Loyiha, hisob raqami...' }}">
                    </div>
                </div>

                {{-- Loyiha kategoriyasi (ijara, qurilish, yer) --}}
                <div class="col-md-3">
                    <label for="categoryFilter" class="form-label mb-2">{{ __('admin.category') ?? 'Kategoriya' }}</label>
                    <select id="categoryFilter" class="form-select">
                        <option value="">{{ __('admin.all') ?? 'Barchasi' }}</option>
                        <option value="rent">Ijara</option>
                        <option value="construction">Qurilish</option>
                        <option value="land">Yer</option>
                    </select>
                </div>

                {{-- To‘lov holati --}}
                <div class="col-md-3">
                    <label for="statusFilter" class="form-label mb-2">{{ __('admin.payment_status') ?? 'To‘lov holati' }}</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">{{ __('admin.all') ?? 'Barchasi' }}</option>
                        <option value="pending">Kutilmoqda</option>
                        <option value="paid">O‘tkazilgan</option>
                        <option value="rejected">Rad etilgan</option>
                    </select>
                </div>

                {{-- Tugmalar --}}
                <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />
            </div>
        </div>
    </div>

    {{-- Loyihalar kesimidagi daromadlar jadvali (collapse tashqarisida) --}}
    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table user-table table-bordered table-hover table-striped align-items-center" id="incomesTable">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>{{ __('admin.project') ?? 'Loyiha' }}</th>
                    <th>{{ __('admin.category') ?? 'Kategoriya' }}</th>
                    <th>{{ __('admin.incomes.total_income') ?? 'Jami daromad' }}</th>
                    <th>{{ __('admin.incomes.rent_income') ?? 'Ijara daromadi' }}</th>
                    <th>{{ __('admin.incomes.construction_income') ?? 'Qurilishdan' }}</th>
                    <th>{{ __('admin.incomes.land_income') ?? 'Yerdan' }}</th>
                    <th>{{ __('admin.incomes.full_partner_share') ?? 'Tўliq sherik ulushi (30%)' }}</th>
                    <th>{{ __('admin.payment_status') ?? 'To‘lov holati' }}</th>
                    <th>{{ __('admin.next_distribution_date') ?? 'Keyingi taqsimot' }}</th>
                    <th class="text-center">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody id="incomesTableBody">
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
@endsection

@push('customJs')
    <script>
        // Demo ma'lumotlar – 30% ulush avtomatik hisoblanadi
        const FULL_PARTNER_PERCENT = 30;

        const DEFAULT_INCOMES = [
            {
                id: 1,
                project_code: 'PRJ-2024-001',
                project_name: 'Premium Turar-joy majmuasi',
                category: 'construction', // qurilish sotuvlari
                total_income: 5000000000,
                rent_income: 0,
                construction_income: 5000000000,
                land_income: 0,
                currency: 'UZS',
                payment_status: 'paid',
                next_distribution_date: '2025-03-01',
            },
            {
                id: 2,
                project_code: 'PRJ-2024-002',
                project_name: 'Biznes markaz ijara loyihasi',
                category: 'rent',
                total_income: 1200000000,
                rent_income: 1200000000,
                construction_income: 0,
                land_income: 0,
                currency: 'UZS',
                payment_status: 'pending',
                next_distribution_date: '2025-02-15',
            },
            {
                id: 3,
                project_code: 'PRJ-2024-003',
                project_name: 'Yer uchastkasi investitsiyasi',
                category: 'land',
                total_income: 800000000,
                rent_income: 0,
                construction_income: 0,
                land_income: 800000000,
                currency: 'UZS',
                payment_status: 'rejected',
                next_distribution_date: '-',
            },
        ];

        let incomes = DEFAULT_INCOMES.map(item => ({
            ...item,
            full_partner_share: Math.round((item.total_income * FULL_PARTNER_PERCENT) / 100),
        }));
        let defaultIncomes = [...incomes];

        const incomesTableBody = document.getElementById('incomesTableBody');
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const statusFilter = document.getElementById('statusFilter');
        const filterBtn = document.getElementById('filterBtn');
        const clearBtn = document.getElementById('clearBtn');
        const exportIncomeBtn = document.getElementById('exportIncomeBtn');

        const statsTotalIncomeEl = document.getElementById('statsTotalIncome');
        const statsNextDistributionEl = document.getElementById('statsNextDistribution');
        const statsPendingPaymentsEl = document.getElementById('statsPendingPayments');

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

        function getCategoryBadge(category) {
            if (category === 'rent') {
                return '<span class="badge badge-custom badge-category-rent">Ijara</span>';
            }
            if (category === 'construction') {
                return '<span class="badge badge-custom badge-category-construction">Qurilish</span>';
            }
            if (category === 'land') {
                return '<span class="badge badge-custom badge-category-land">Yer</span>';
            }
            return '<span class="badge badge-custom">-</span>';
        }

        function getPaymentStatusBadge(status) {
            if (status === 'pending') {
                return '<span class="badge badge-custom badge-status-pending">Kutilmoqda</span>';
            }
            if (status === 'paid') {
                return '<span class="badge badge-custom badge-status-paid">O‘tkazilgan</span>';
            }
            if (status === 'rejected') {
                return '<span class="badge badge-custom badge-status-rejected">Rad etilgan</span>';
            }
            return '<span class="badge badge-custom">-</span>';
        }

        function renderIncomes(list = incomes) {
            if (!incomesTableBody) return;

            if (!list.length) {
                incomesTableBody.innerHTML = `
                    <tr>
                        <td colspan="11">
                            <div class="empty-state">
                                <i class="fas fa-folder-open"></i>
                                <div class="mt-2">
                                    <h5>Daromadlar topilmadi</h5>
                                    <p class="text-muted">Filterlarni o‘zgartiring yoki taqsimotlar yakunlangach qayta kirib ko‘ring</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
                updateStats(list);
                return;
            }

            let html = '';
            list.forEach(item => {
                html += `
                    <tr>
                        <td class="text-center">${item.id}</td>
                        <td>
                            <div class="value-primary">${escapeHtml(item.project_name)}</div>
                            <div class="value-secondary">${escapeHtml(item.project_code)}</div>
                        </td>
                        <td class="text-center">
                            ${getCategoryBadge(item.category)}
                        </td>
                        <td class="text-end">
                            <div class="value-primary">${formatMoney(item.total_income, item.currency)}</div>
                        </td>
                        <td class="text-end">${formatMoney(item.rent_income, item.currency)}</td>
                        <td class="text-end">${formatMoney(item.construction_income, item.currency)}</td>
                        <td class="text-end">${formatMoney(item.land_income, item.currency)}</td>
                        <td class="text-end">
                            <div class="value-primary">${formatMoney(item.full_partner_share, item.currency)}</div>
                            <div class="value-secondary">30%</div>
                        </td>
                        <td class="text-center">
                            ${getPaymentStatusBadge(item.payment_status)}
                        </td>
                        <td class="text-center">
                            <span class="value-secondary">${escapeHtml(item.next_distribution_date || '-')}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                {{-- keyinchalik daromad kartochkasiga o‘tish route: admin.incomes.show --}}
                                <button class="btn btn-sm btn-light border" type="button">
                                    <i class="fas fa-eye text-primary"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });

            incomesTableBody.innerHTML = html;
            updateStats(list);
        }

        function updateStats(list) {
            const totalIncome = list.reduce((sum, i) => sum + (i.total_income || 0), 0);
            const pendingCount = list.filter(i => i.payment_status === 'pending').length;
            const nextDates = list
                .map(i => i.next_distribution_date)
                .filter(Boolean)
                .sort();

            if (statsTotalIncomeEl) {
                statsTotalIncomeEl.textContent = formatMoney(totalIncome, 'UZS');
            }
            if (statsPendingPaymentsEl) {
                statsPendingPaymentsEl.textContent = pendingCount.toString();
            }
            if (statsNextDistributionEl) {
                statsNextDistributionEl.textContent = nextDates[0] || '-';
            }
        }

        function applyFilter() {
            const search = (searchInput?.value || '').toLowerCase().trim();
            const category = categoryFilter?.value || '';
            const status = statusFilter?.value || '';

            const filtered = defaultIncomes.filter(i => {
                const matchesSearch = !search
                    || (i.project_name && i.project_name.toLowerCase().includes(search))
                    || (i.project_code && i.project_code.toLowerCase().includes(search));

                const matchesCategory = !category || i.category === category;
                const matchesStatus = !status || i.payment_status === status;

                return matchesSearch && matchesCategory && matchesStatus;
            });

            renderIncomes(filtered);
        }

        function resetFilters() {
            if (searchInput) searchInput.value = '';
            if (categoryFilter) categoryFilter.value = '';
            if (statusFilter) statusFilter.value = '';
            renderIncomes(defaultIncomes);
        }

        function exportIncomes() {
            alert('Daromadlar bo‘yicha Excel eksport funksiyasi backend bilan bog‘langach ishlaydi.');
        }

        document.addEventListener('DOMContentLoaded', function () {
            renderIncomes(incomes);

            if (filterBtn) filterBtn.addEventListener('click', applyFilter);
            if (clearBtn) clearBtn.addEventListener('click', resetFilters);
            if (exportIncomeBtn) exportIncomeBtn.addEventListener('click', exportIncomes);

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

            if (categoryFilter) categoryFilter.addEventListener('change', applyFilter);
            if (statusFilter) statusFilter.addEventListener('change', applyFilter);
        });
    </script>
@endpush

