@extends('layouts.app')

@push('customCss')
    <style>
        /* projects/index uslubiga mos umumiy kartalar */
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

        /* Korxona kategoriyasi badge'lari */
        .badge-category-full {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-category-subsidiary {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-category-commandite {
            background: #fef3c7;
            color: #92400e;
        }

        /* Faoliyat turi badge'lari – project-investors sahifasiga o‘xshash */
        .badge-activity-mchj {
            background: #e0f2fe;
            color: #0369a1;
        }

        .badge-activity-aj {
            background: #fef9c3;
            color: #854d0e;
        }

        .badge-activity-yatt {
            background: #ede9fe;
            color: #5b21b6;
        }

        .company-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 0.9rem;
            margin-bottom: 0.1rem;
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
                        {{ __('admin.company_details') ?? 'Rekvizitlar' }}
                    </li>
                </ol>
            </nav>
        </div>

        <div class="d-flex gap-2 align-items-center flex-wrap">
            {{-- Keyin real route bilan to‘ldirasiz --}}
            <a href="javascript:void(0)" class="btn btn-primary btn-sm px-3 py-2 disabled">
                <i class="fas fa-plus me-1"></i> {{ __('admin.add') ?? 'Korxona qo‘shish' }}
            </a>
            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#companyFilterContent" aria-expanded="true"
                aria-controls="companyFilterContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="filter-card mb-3 collapse show" id="companyFilterContent">
        <div class="p-3">
            <div class="row g-3 align-items-end">
                {{-- Qidiruv --}}
                <div class="col-md-4">
                    <label for="searchInput" class="form-label mb-2">{{ __('admin.search') ?? 'Qidiruv' }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0"
                            placeholder="{{ __('admin.search') ?? 'Nom, INN, direktor...' }}">
                    </div>
                </div>

                {{-- Korxona kategoriyasi (To‘liq sherik, Shu‘ba, Komandit) --}}
                <x-select-with-search
                    name="companyCategoryFilter"
                    label="{{ __('admin.company_category') ?? 'Korxona kategoriyasi' }}"
                    :datas="[
                        'full_partner' => 'To‘liq sherik',
                        'subsidiary' => 'Shu\'ba korxona',
                        'commandite' => 'Komandit shirkati',
                    ]"
                    colMd="3"
                    placeholder="Barchasi"
                    :selected="request()->get('companyCategoryFilter', '')"
                    :selectSearch="false"
                    icon="fa-layer-group" />

                {{-- Faoliyat turi (MChJ, AJ, YaTT) --}}
                <x-select-with-search
                    name="activityTypeFilter"
                    label="{{ __('admin.activity_type') ?? 'Faoliyat turi' }}"
                    :datas="['MChJ' => 'MChJ', 'AJ' => 'AJ', 'YaTT' => 'YaTT']"
                    colMd="3"
                    placeholder="Barchasi"
                    :selected="request()->get('activityTypeFilter', '')"
                    :selectSearch="false"
                    icon="fa-briefcase" />

                {{-- projects/index dagi filter tugmalari --}}
                <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />
            </div>
        </div>
    </div>

    {{-- Jadval (collapse tashqarisida) --}}
    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table user-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>{{ __('admin.company_name') ?? 'Korxona to‘liq nomi' }}</th>
                    <th>{{ __('admin.company_category') ?? 'Korxona kategoriyasi' }}</th>
                    <th>{{ __('admin.inn') ?? 'INN' }}</th>
                    <th>{{ __('admin.ifut_code') ?? 'IFUT kodi' }}</th>
                    <th>{{ __('admin.activity_type') ?? 'Faoliyat turi' }}</th>
                    <th>{{ __('admin.address') ?? 'Manzili' }}</th>
                    <th>{{ __('admin.director_fio') ?? 'Direktor F.I.O.' }}</th>
                    <th>{{ __('admin.phone') ?? 'Telefon' }}</th>
                    <th>{{ __('admin.email') ?? 'Email' }}</th>
                    <th>{{ __('admin.registered_at') ?? 'Ro‘yxatdan o‘tgan sana' }}</th>
                    <th>{{ __('admin.registration_number') ?? 'Ro‘yxat raqami' }}</th>
                    <th>{{ __('admin.registration_org') ?? 'Ro‘yxatdan o‘tkazgan tashkilot' }}</th>
                    <th>{{ __('admin.passport') ?? 'Pasport (YaTT)' }}</th>
                    <th>{{ __('admin.jshshir') ?? 'JSHSHIR (YaTT)' }}</th>
                    <th class="text-center">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody id="companyTableBody">
                <tr>
                    <td colspan="16">
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
        // Texnik topshiriqqa mos demo ma'lumotlar
        const DEFAULT_COMPANIES = [
            {
                id: 1,
                company_name: '"Envast Capital" MChJ',
                category: 'full_partner', // To‘liq sherik
                inn: '123456789',
                ifut: '00001',
                activity_type: 'MChJ',
                address: "Toshkent sh., Yunusobod t., Amir Temur ko'chasi 15-uy",
                director_fio: 'Abdullayev Jamshid Murodovich',
                phone: '+998 90 123-45-67',
                email: 'info@envast.uz',
                registered_at: '2020-05-15',
                registration_number: 'REG-2020-001',
                registration_org: "Toshkent shahar adliya boshqarmasi",
                passport: '',
                jshshir: '',
            },
            {
                id: 2,
                company_name: '"Premium Residence" MChJ',
                category: 'subsidiary', // Shu‘ba korxona
                inn: '987654321',
                ifut: '00002',
                activity_type: 'MChJ',
                address: "Toshkent sh., Mirzo Ulug'bek t., Buyuk Ipak yo'li 45-uy",
                director_fio: 'Karimov Aziz Rustamovich',
                phone: '+998 97 222-33-44',
                email: 'office@premium-res.uz',
                registered_at: '2021-08-10',
                registration_number: 'REG-2021-045',
                registration_org: "Toshkent shahar adliya boshqarmasi",
                passport: '',
                jshshir: '',
            },
            {
                id: 3,
                company_name: '"Envast Commandite 1" Komandit shirkati',
                category: 'commandite', // Komandit shirkati
                inn: '564738291',
                ifut: '00003',
                activity_type: 'MChJ',
                address: "Toshkent sh., Chilonzor t., Bunyodkor ko'chasi 120-uy",
                director_fio: 'Sattorov Dilshod Shavkatovich',
                phone: '+998 93 555-66-77',
                email: 'commandite1@envast.uz',
                registered_at: '2024-01-05',
                registration_number: 'REG-2024-010',
                registration_org: "Toshkent shahar adliya boshqarmasi",
                passport: '',
                jshshir: '',
            },
            {
                id: 4,
                company_name: 'Tursunov Aziz Mahmudovich',
                category: 'full_partner', // To‘liq sherik sifatida qatnashayotgan YaTT
                inn: '321654987',
                ifut: '00004',
                activity_type: 'YaTT',
                address: "Samarqand sh., Siab t., Bog'ishamol ko'chasi 7-uy",
                director_fio: 'Tursunov Aziz Mahmudovich',
                phone: '+998 90 333-44-55',
                email: 'aziz.t@example.uz',
                registered_at: '2019-03-20',
                registration_number: 'REG-2019-077',
                registration_org: "Samarqand viloyati soliq boshqarmasi",
                passport: 'AA1234567',
                jshshir: '12345678901234',
            },
        ];

        let companies = [...DEFAULT_COMPANIES];
        let defaultCompanies = [...DEFAULT_COMPANIES];

        const companyTableBody = document.getElementById('companyTableBody');
        const searchInput = document.getElementById('searchInput');
        const companyCategoryFilter = document.getElementById('companyCategoryFilter');
        const activityTypeFilter = document.getElementById('activityTypeFilter');
        const filterBtn = document.getElementById('filterBtn');
        const clearBtn = document.getElementById('clearBtn');

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

        function formatDate(dateString) {
            if (!dateString) return '<span class="text-muted">-</span>';
            try {
                const date = new Date(dateString);
                return date.toLocaleDateString('uz-UZ', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                });
            } catch (e) {
                return dateString;
            }
        }

        function getCategoryBadge(category) {
            if (category === 'full_partner') {
                return '<span class="badge badge-custom badge-category-full">To‘liq sherik</span>';
            }
            if (category === 'subsidiary') {
                return '<span class="badge badge-custom badge-category-subsidiary">Shu\'ba korxona</span>';
            }
            if (category === 'commandite') {
                return '<span class="badge badge-custom badge-category-commandite">Komandit shirkati</span>';
            }
            return '<span class="badge badge-custom">-</span>';
        }

        function getActivityBadge(type) {
            if (type === 'MChJ') {
                return '<span class="badge badge-custom badge-activity-mchj">MChJ</span>';
            }
            if (type === 'AJ') {
                return '<span class="badge badge-custom badge-activity-aj">AJ</span>';
            }
            if (type === 'YaTT') {
                return '<span class="badge badge-custom badge-activity-yatt">YaTT</span>';
            }
            return '<span class="badge badge-custom">-</span>';
        }

        function renderCompanies(list = companies) {
            if (!companyTableBody) return;

            if (!list.length) {
                companyTableBody.innerHTML = `
                    <tr>
                        <td colspan="16">
                            <div class="empty-state">
                                <i class="fas fa-folder-open"></i>
                                <div class="mt-2">
                                    <h5>Korxonalar topilmadi</h5>
                                    <p class="text-muted">Filterlarni o‘zgartiring yoki yangi korxona qo‘shing</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            let html = '';
            list.forEach(item => {
                html += `
                    <tr>
                        <td class="text-center">${item.id}</td>
                        <td>
                            <div class="company-name">${escapeHtml(item.company_name)}</div>
                            <div class="company-info">
                                <i class="fas fa-id-card me-1"></i>${escapeHtml(item.inn)}
                            </div>
                        </td>
                        <td class="text-center">
                            ${getCategoryBadge(item.category)}
                        </td>
                        <td class="text-center">${escapeHtml(item.inn)}</td>
                        <td class="text-center">${escapeHtml(item.ifut)}</td>
                        <td class="text-center">
                            ${getActivityBadge(item.activity_type)}
                        </td>
                        <td>
                            <div class="value-primary">${escapeHtml(item.address)}</div>
                        </td>
                        <td>
                            <div class="value-primary">${escapeHtml(item.director_fio)}</div>
                        </td>
                        <td>${escapeHtml(item.phone)}</td>
                        <td>${escapeHtml(item.email)}</td>
                        <td class="text-center">${formatDate(item.registered_at)}</td>
                        <td>${escapeHtml(item.registration_number || '-')}</td>
                        <td>${escapeHtml(item.registration_org || '-')}</td>
                        <td class="text-center">
                            ${item.activity_type === 'YaTT'
                                ? escapeHtml(item.passport || '')
                                : '<span class="text-muted">-</span>'}
                        </td>
                        <td class="text-center">
                            ${item.activity_type === 'YaTT'
                                ? escapeHtml(item.jshshir || '')
                                : '<span class="text-muted">-</span>'}
                        </td>
                        <td>
                            <div class="action-buttons">
                                {{-- keyinchalik real route bilan to‘ldiring --}}
                                <x-edit-button />
                                <x-delete-button />
                            </div>
                        </td>
                    </tr>
                `;
            });

            companyTableBody.innerHTML = html;
        }

        function applyFilter() {
            const search = (searchInput?.value || '').toLowerCase().trim();
            const category = companyCategoryFilter?.value || '';
            const activity = activityTypeFilter?.value || '';

            const filtered = defaultCompanies.filter(c => {
                const matchesSearch = !search
                    || (c.company_name && c.company_name.toLowerCase().includes(search))
                    || (c.director_fio && c.director_fio.toLowerCase().includes(search))
                    || (c.inn && c.inn.includes(search))
                    || (c.phone && c.phone.includes(search))
                    || (c.email && c.email.toLowerCase().includes(search));

                const matchesCategory = !category || c.category === category;
                const matchesActivity = !activity || c.activity_type === activity;

                return matchesSearch && matchesCategory && matchesActivity;
            });

            renderCompanies(filtered);
        }

        function resetFilters() {
            if (searchInput) searchInput.value = '';
            if (companyCategoryFilter) companyCategoryFilter.value = '';
            if (activityTypeFilter) activityTypeFilter.value = '';
            renderCompanies(defaultCompanies);
        }

        document.addEventListener('DOMContentLoaded', function () {
            renderCompanies(companies);

            if (filterBtn) {
                filterBtn.addEventListener('click', applyFilter);
            }
            if (clearBtn) {
                clearBtn.addEventListener('click', resetFilters);
            }

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

            if (companyCategoryFilter) {
                companyCategoryFilter.addEventListener('change', applyFilter);
            }
            if (activityTypeFilter) {
                activityTypeFilter.addEventListener('change', applyFilter);
            }
        });
    </script>
@endpush


