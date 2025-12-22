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

        /* Korxona kategoriyasi badge'lari */
        .badge-category-full {
            background: rgba(5, 101, 70, 0.15);
            color: #065f46;
        }

        .badge-category-subsidiary {
            background: rgba(30, 64, 175, 0.15);
            color: #1e40af;
        }

        .badge-category-commandite {
            background: rgba(146, 64, 14, 0.15);
            color: #92400e;
        }

        /* Faoliyat turi badge'lari */
        .badge-activity-mchj {
            background: rgba(3, 105, 161, 0.15);
            color: #0369a1;
        }

        .badge-activity-aj {
            background: rgba(133, 77, 14, 0.15);
            color: #854d0e;
        }

        .badge-activity-yatt {
            background: rgba(91, 33, 182, 0.15);
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
            line-height: 1.2;
            word-break: break-word;
        }

        .value-primary {
            font-weight: 600;
            color: #1f2937;
            font-size: 0.875rem;
            line-height: 1.2;
        }

        .value-secondary {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.125rem;
            line-height: 1.2;
            word-break: break-word;
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

        /* ====== QISQARTIRISH: ustunlar o‘chirilmaydi, faqat ko‘rinmaydi (data saqlanadi) ======
           - INN -> Korxona nomi katagida pastda chiqadi
           - Telefon -> Direktor FIO katagida pastda chiqadi
           - Ro‘yxat raqami + organ -> Ro‘yxatdan o‘tgan sana katagida pastda chiqadi
           - JSHSHIR -> Pasport katagida pastda chiqadi
        */
        .user-table th.col-inn,
        .user-table td.col-inn,
        .user-table th.col-phone,
        .user-table td.col-phone,
        .user-table th.col-regnum,
        .user-table td.col-regnum,
        .user-table th.col-regorg,
        .user-table td.col-regorg,
        .user-table th.col-jshshir,
        .user-table td.col-jshshir {
            display: none;
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

                {{-- Korxona kategoriyasi --}}
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

                {{-- Faoliyat turi --}}
                <x-select-with-search
                    name="activityTypeFilter"
                    label="{{ __('admin.activity_type') ?? 'Faoliyat turi' }}"
                    :datas="['MChJ' => 'MChJ', 'AJ' => 'AJ', 'YaTT' => 'YaTT']"
                    colMd="3"
                    placeholder="Barchasi"
                    :selected="request()->get('activityTypeFilter', '')"
                    :selectSearch="false"
                    icon="fa-briefcase" />

                <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />
            </div>
        </div>
    </div>

    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table user-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>{{ __('admin.company_name') ?? 'Korxona to‘liq nomi' }}</th>
                    <th>{{ __('admin.company_category') ?? 'Korxona kategoriyasi' }}</th>

                    {{-- INN ustuni kodda bor, lekin ko‘rinmaydi --}}
                    <th class="col-inn">{{ __('admin.inn') ?? 'INN' }}</th>

                    <th>{{ __('admin.ifut_code') ?? 'IFUT kodi' }}</th>
                    <th>{{ __('admin.activity_type') ?? 'Faoliyat turi' }}</th>
                    <th>{{ __('admin.address') ?? 'Manzili' }}</th>

                    <th>{{ __('admin.director_fio') ?? 'Direktor F.I.O.' }}</th>

                    {{-- Telefon ustuni kodda bor, lekin ko‘rinmaydi --}}
                    <th class="col-phone">{{ __('admin.phone') ?? 'Telefon' }}</th>

                    <th>{{ __('admin.email') ?? 'Email' }}</th>

                    <th>{{ __('admin.registered_at') ?? 'Ro‘yxatdan o‘tgan sana' }}</th>

                    {{-- ro‘yxat raqami + organ ustunlari kodda bor, lekin ko‘rinmaydi --}}
                    <th class="col-regnum">{{ __('admin.registration_number') ?? 'Ro‘yxat raqami' }}</th>
                    <th class="col-regorg">{{ __('admin.registration_org') ?? 'Ro‘yxatdan o‘tkazgan tashkilot' }}</th>

                    <th>{{ __('admin.passport') ?? 'Pasport (YaTT)' }}</th>

                    {{-- JSHSHIR ustuni kodda bor, lekin ko‘rinmaydi --}}
                    <th class="col-jshshir">{{ __('admin.jshshir') ?? 'JSHSHIR (YaTT)' }}</th>

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
        const DEFAULT_COMPANIES = [
            {
                id: 1,
                company_name: '"Envast Capital" MChJ',
                category: 'full_partner',
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
                category: 'subsidiary',
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
                category: 'commandite',
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
                category: 'full_partner',
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
            const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return String(text).replace(/[&<>"']/g, m => map[m]);
        }

        function formatDate(dateString) {
    if (!dateString) return '<span class="text-muted">-</span>';

    const d = new Date(dateString);
    if (isNaN(d)) return '<span class="text-muted">-</span>';

    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = String(d.getFullYear()).slice(-2);

    return `${day}.${month}.${year}`;
}



        function getCategoryBadge(category) {
            if (category === 'full_partner') return '<span class="badge badge-custom badge-category-full">To‘liq sherik</span>';
            if (category === 'subsidiary') return '<span class="badge badge-custom badge-category-subsidiary">Shu\'ba korxona</span>';
            if (category === 'commandite') return '<span class="badge badge-custom badge-category-commandite">Komandit shirkati</span>';
            return '<span class="badge badge-custom">-</span>';
        }

        function getActivityBadge(type) {
            if (type === 'MChJ') return '<span class="badge badge-custom badge-activity-mchj">MChJ</span>';
            if (type === 'AJ') return '<span class="badge badge-custom badge-activity-aj">AJ</span>';
            if (type === 'YaTT') return '<span class="badge badge-custom badge-activity-yatt">YaTT</span>';
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
                const inn = item.inn ? escapeHtml(item.inn) : '-';
                const phone = item.phone ? escapeHtml(item.phone) : '-';

                // registered_at shu yerda ishlatiladi -> dd.mm.yy
                const regDate = item.registered_at ? formatDate(item.registered_at) : '<span class="text-muted">-</span>';
                const regNum = item.registration_number ? escapeHtml(item.registration_number) : '-';
                const regOrg = item.registration_org ? escapeHtml(item.registration_org) : '-';

                const passport = item.passport ? escapeHtml(item.passport) : '';
                const jshshir = item.jshshir ? escapeHtml(item.jshshir) : '';

                html += `
                    <tr>
                        <td class="text-center">${item.id}</td>

                        <!-- Korxona nomi ichiga INN jamlanadi -->
                        <td>
                            <div class="company-name">${escapeHtml(item.company_name)}</div>
                            <div class="company-info"><i class="fas fa-id-card me-1"></i>${inn}</div>
                        </td>

                        <td class="text-center">${getCategoryBadge(item.category)}</td>

                        <!-- INN: data bor, lekin ko‘rinmaydi -->
                        <td class="col-inn text-center">${inn}</td>

                        <td class="text-center">${escapeHtml(item.ifut)}</td>
                        <td class="text-center">${getActivityBadge(item.activity_type)}</td>

                        <td>
                            <div class="value-primary">${escapeHtml(item.address)}</div>
                        </td>

                        <!-- Direktor ichiga Telefon jamlanadi -->
                        <td>
                            <div class="value-primary">${escapeHtml(item.director_fio)}</div>
                            <div class="value-secondary"><span class="text-muted">Tel:</span> ${phone}</div>
                        </td>

                        <!-- Telefon: data bor, lekin ko‘rinmaydi -->
                        <td class="col-phone">${phone}</td>

                        <td>${escapeHtml(item.email)}</td>

                        <!-- Ro‘yxatdan o‘tgan sana ichiga raqam + organ jamlanadi -->
                        <td class="text-center">
                            <div class="value-primary">${regDate}</div>
                            <div class="value-secondary"><span class="text-muted">№</span> ${regNum}</div>
                            <div class="value-secondary">${regOrg}</div>
                        </td>

                        <!-- reg_number/reg_org: data bor, lekin ko‘rinmaydi -->
                        <td class="col-regnum">${regNum}</td>
                        <td class="col-regorg">${regOrg}</td>

                        <!-- Pasport ichiga JSHSHIR jamlanadi (faqat YaTT mazmuni saqlanadi) -->
                        <td class="text-center">
                            ${
                                item.activity_type === 'YaTT'
                                ? `
                                    <div class="value-primary">${passport ? passport : '<span class="text-muted">-</span>'}</div>
                                    <div class="value-secondary"><span class="text-muted">JSHSHIR:</span> ${jshshir ? jshshir : '-'}</div>
                                  `
                                : '<span class="text-muted">-</span>'
                            }
                        </td>

                        <!-- JSHSHIR: data bor, lekin ko‘rinmaydi -->
                        <td class="col-jshshir text-center">
                            ${item.activity_type === 'YaTT' ? (jshshir ? jshshir : '-') : '-'}
                        </td>

                        <td>
                            <div class="action-buttons">
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

            if (companyCategoryFilter) companyCategoryFilter.addEventListener('change', applyFilter);
            if (activityTypeFilter) activityTypeFilter.addEventListener('change', applyFilter);
        });
    </script>
@endpush
