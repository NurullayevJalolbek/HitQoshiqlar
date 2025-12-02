@extends('layouts.app')

@push('customCss')
    <style>
        .log-level-info {
            color: #1e7e34; /* yashil */
            font-weight: 600;
        }

        .log-level-warning {
            color: #d39e00; /* sariq */
            font-weight: 600;
        }

        .log-level-error {
            color: #bd2130; /* qizil */
            font-weight: 600;
        }

        .view-icon {
            cursor: pointer;
            font-size: 18px;
        }

        .table td, .table th {
            vertical-align: middle;
        }
    </style>
@endpush

@section('breadcrumb')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <!-- Breadcrumb -->
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.system_logs') }}</li>
                </ol>
            </nav>
        </div>

        <!-- Tugmalar guruhi -->
        <div class="d-flex gap-2 align-items-center flex-wrap">

            <!-- Export CSV -->
            <button class="btn btn-info btn-sm text-white px-2 py-1" id="exportCsvBtn">
                <i class="fas fa-file-csv me-1" style="font-size: 0.85rem;"></i> CSV
            </button>

            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#systemHistoryFilterContent" aria-expanded="true"
                    aria-controls="systemHistoryFilterContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')

    {{-- FILTER CARD --}}
    <div class="filter-card mb-3 mt-2 collapse show" id="systemHistoryFilterContent" style="transition: all 0.3s ease;">
        <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label>{{__('admin.search')}}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control"
                               placeholder="Kalit so'z, foydalanuvchi...">
                    </div>
                </div>

                <div class="col-md-2">
                    <label>{{__('admin.log_type')}}</label>
                    <select id="logTypeFilter" class="form-select">
                        <option value="all">{{__('admin.all')}}</option>
                        <option value="INFO">INFO</option>
                        <option value="WARNING">WARNING</option>
                        <option value="ERROR">ERROR</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label>{{__('admin.module')}}</label>
                    <select id="moduleFilter" class="form-select">
                        <option value="all">{{__('admin.all')}}</option>
                        <option value="Loyihalar">Loyihalar</option>
                        <option value="Investorlar">Investorlar</option>
                        <option value="Ma'muriyat bo'limi">Ma'muriyat bo'limi</option>
                        <option value="Hisobotlar">Hisobotlar</option>
                        <option value="Foydalanuvchilar">Foydalanuvchilar</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label>{{__('admin.start_date')}}</label>
                    <input type="date" id="startDate" class="form-control">
                </div>

                <div class="col-md-2">
                    <label>{{__('admin.end_date')}}</label>
                    <input type="date" id="endDate" class="form-control">
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button id="filterBtn" class="btn btn-primary w-50">
                        <i class="fas fa-filter"></i> {{__('admin.search')}}
                    </button>
                    <button id="clearBtn" class="btn btn-warning w-50">
                        {{__('admin.clear')}}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- LOG TABLE --}}
    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table user-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>{{__('admin.user')}}</th>
                <th>{{__('admin.type')}}</th>
                <th>{{__('admin.status')}}</th>
                <th>{{__('admin.module')}}</th>
                <th>{{__('admin.date')}}</th>
                <th>{{__('admin.ip')}}</th>
                <th>{{__('admin.description')}}</th>
                <th>{{__('admin.actions')}}</th>
            </tr>
            </thead>

            <tbody id="systemLogBody">
            </tbody>

        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-start p-2">
            <nav>
                <ul class="pagination pagination-sm mb-0" id="systemPagination"></ul>
            </nav>
        </div>
    </div>

    {{-- DETAIL MODAL --}}
    <div class="modal fade" id="logDetailModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Log tafsilotlari</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>Foydalanuvchi</th>
                            <td id="d_user"></td>
                        </tr>
                        <tr>
                            <th>Turi (Action)</th>
                            <td id="d_action"></td>
                        </tr>
                        <tr>
                            <th>Holati (Level)</th>
                            <td id="d_level"></td>
                        </tr>
                        <tr>
                            <th>Modul</th>
                            <td id="d_module"></td>
                        </tr>
                        <tr>
                            <th>Sana va Vaqt</th>
                            <td id="d_time"></td>
                        </tr>
                        <tr>
                            <th>IP manzil</th>
                            <td id="d_ip"></td>
                        </tr>
                        <tr>
                            <th>Tavsif</th>
                            <td id="d_desc"></td>
                        </tr>
                        <tr>
                            <th>Qo'shimcha ma'lumot</th>
                            <td id="d_extra"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('customJs')
    <script>
        function initFilterToggle(buttonId, contentId, iconId, textId) {
            const collapseEl = document.getElementById(contentId);
            const button = document.getElementById(buttonId);
            const icon = document.getElementById(iconId);
            const text = document.getElementById(textId);

            collapseEl.addEventListener('shown.bs.collapse', () => {
                icon.classList.remove('bi-caret-up-fill');
                icon.classList.add('bi-caret-down-fill');
                text.textContent = 'Yopish';
            });

            collapseEl.addEventListener('hidden.bs.collapse', () => {
                icon.classList.remove('bi-caret-down-fill');
                icon.classList.add('bi-caret-up-fill');
                text.textContent = 'Ochish';
            });
        }

        // Tizim loglari uchun statik ma'lumotlar massivi (15 ta)
        const allLogs = [
            {
                id: 1,
                time: '2025-12-02 10:05:30',
                level: 'INFO',
                action: 'UPDATE',
                module: "Loyihalar",
                user: 'admin',
                ip: '192.168.1.10',
                desc: "Loyiha 'Yangi Texno Park' ma'lumotlari yangilandi",
                extra: "O'zgartirilgan maydonlar: nomi, byudjet"
            },
            {
                id: 2,
                time: '2025-12-02 10:01:15',
                level: 'ERROR',
                action: 'CREATE',
                module: "Loyihalar",
                user: 'sardor',
                ip: '192.168.1.15',
                desc: "Loyiha yaratishda xatolik yuz berdi: Nomi takrorlanishi",
                extra: "Xatolik kodi: 409 CONFLICT"
            },
            {
                id: 3,
                time: '2025-12-02 09:55:40',
                level: 'INFO',
                action: 'EXPORT',
                module: "Loyihalar",
                user: 'ali',
                ip: '192.168.1.20',
                desc: "Loyihalar ro'yxatini CSV formatida export qilish amalga oshirildi",
                extra: "Fayl nomi: projects_20251202.csv"
            },
            {
                id: 4,
                time: '2025-12-02 09:45:00',
                level: 'WARNING',
                action: 'DELETE',
                module: "Investorlar",
                user: 'bobur',
                ip: '192.168.1.18',
                desc: "Investorni o'chirishda noaniqlik kuzatildi. Investitsiyalar hali mavjud",
                extra: "Investor ID: 105, Status: Pending Confirmation"
            },
            {
                id: 5,
                time: '2025-12-02 09:40:22',
                level: 'INFO',
                action: 'CREATE',
                module: "Investorlar",
                user: 'anna',
                ip: '192.168.1.14',
                desc: "Yangi investor 'Global Invest Corp' qo'shildi",
                extra: "Investor ID: 108"
            },
            {
                id: 6,
                time: '2025-12-02 09:35:10',
                level: 'ERROR',
                action: 'UPDATE',
                module: "Ma'muriyat bo'limi",
                user: 'admin',
                ip: '192.168.1.11',
                desc: "Admin foydalanuvchisi sozlamalarida xatolik: Ruxsatlar saqlanmadi",
                extra: "Database error: Timeout"
            },
            {
                id: 7,
                time: '2025-12-02 09:30:55',
                level: 'WARNING',
                action: 'EXPORT',
                module: "Hisobotlar",
                user: 'dilshod',
                ip: '192.168.1.21',
                desc: "Yillik hisobot eksportida vaqtinchalik kechikish (5 soniya)",
                extra: "Hisobot turi: Yillik daromad"
            },
            {
                id: 8,
                time: '2025-12-02 09:25:00',
                level: 'INFO',
                action: 'CREATE',
                module: "Hisobotlar",
                user: 'ali',
                ip: '192.168.1.22',
                desc: "Yangi 'Oylik Moliyaviy' hisobot generatsiya qilindi",
                extra: "Hisobot ID: 55"
            },
            {
                id: 9,
                time: '2025-12-02 09:20:11',
                level: 'ERROR',
                action: 'DELETE',
                module: "Loyihalar",
                user: 'sardor',
                ip: '192.168.1.19',
                desc: "Loyiha ID: 201 ni o'chirishda xatolik aniqlandi: Bog'liq resurslar topildi",
                extra: "Xatolik kodi: 403 Forbidden"
            },
            {
                id: 10,
                time: '2025-12-02 09:15:30',
                level: 'INFO',
                action: 'UPDATE',
                module: "Investorlar",
                user: 'bobur',
                ip: '192.168.1.16',
                desc: "Investor 'Azizov Group' aloqa ma'lumotlari yangilandi",
                extra: "O'zgartirilgan maydonlar: telefon, email"
            },
            {
                id: 11,
                time: '2025-12-01 18:00:00',
                level: 'INFO',
                action: 'CREATE',
                module: "Foydalanuvchilar",
                user: 'admin',
                ip: '192.168.1.10',
                desc: "Yangi foydalanuvchi 'Bekzod' qo'shildi",
                extra: "Roli: Moderator"
            },
            {
                id: 12,
                time: '2025-12-01 17:45:00',
                level: 'WARNING',
                action: 'UPDATE',
                module: "Foydalanuvchilar",
                user: 'ali',
                ip: '192.168.1.20',
                desc: "Foydalanuvchi 'Javohir' rolini o'zgartirishda ma'lumotlar to'liq emas",
                extra: "Status: Incomplete form data"
            },
            {
                id: 13,
                time: '2025-12-01 17:30:10',
                level: 'INFO',
                action: 'LOGIN',
                module: "Ma'muriyat bo'limi",
                user: 'rustam',
                ip: '192.168.1.25',
                desc: "Tizimga muvaffaqiyatli kirish",
                extra: "Platforma: Web, Browser: Firefox"
            },
            {
                id: 14,
                time: '2025-12-01 17:28:40',
                level: 'ERROR',
                action: 'LOGIN',
                module: "Ma'muriyat bo'limi",
                user: 'rustam',
                ip: '192.168.1.25',
                desc: "Kirish urinishi xatosi: noto'g'ri parol",
                extra: "Urinish soni: 3"
            },
            {
                id: 15,
                time: '2025-12-01 17:20:00',
                level: 'INFO',
                action: 'VIEW',
                module: "Loyihalar",
                user: 'anna',
                ip: '192.168.1.14',
                desc: "Loyiha ro'yxatini ko'rish",
                extra: "Filter: Active projects"
            },
        ];

        let currentLogs = [...allLogs]; // Filtrlanganda shu massiv o'zgaradi
        const perPage = 10;
        let currentPage = 1;

        function getLevelClass(level) {
            if (level === 'INFO') return 'log-level-info';
            if (level === 'WARNING') return 'log-level-warning';
            return 'log-level-error';
        }

        function getLevelIcon(level) {
            if (level === 'INFO') return 'fa-check-circle';
            if (level === 'WARNING') return 'fa-exclamation-triangle';
            return 'fa-times-circle';
        }

        function renderSystemTable() {
            const tbody = document.getElementById('systemLogBody');
            tbody.innerHTML = '';

            const start = (currentPage - 1) * perPage;
            const end = start + perPage;
            const pageData = currentLogs.slice(start, end);

            pageData.forEach((log, index) => {
                const globalIndex = start + index + 1;
                const levelClass = getLevelClass(log.level);
                const levelIcon = getLevelIcon(log.level);

                tbody.innerHTML += `
                    <tr>
                        <td>${globalIndex}</td>
                        <td>${log.user}</td>
                        <td>${log.action}</td>
                        <td>
                            <span class="${levelClass}">
                                <i class="fas ${levelIcon}"></i> ${log.level}
                            </span>
                        </td>
                        <td>${log.module}</td>
                        <td>${log.time}</td>
                        <td>${log.ip}</td>
                        <td>${log.desc}</td>
                        <td>
                            <i class="bi bi-eye-fill me-2 view-icon showLogDetail"
                               data-id="${log.id}"
                               data-user="${log.user}"
                               data-action="${log.action}"
                               data-level="${log.level}"
                               data-module="${log.module}"
                               data-time="${log.time}"
                               data-ip="${log.ip}"
                               data-desc="${log.desc}"
                               data-extra="${log.extra}"
                               title="Tafsilot"></i>
                        </td>
                    </tr>
                `;
            });

            renderSystemPagination();
            initLogDetailModal();
        }

        function renderSystemPagination() {
            const pagination = document.getElementById('systemPagination');
            pagination.innerHTML = '';
            const totalPages = Math.ceil(currentLogs.length / perPage);

            // Previous button
            pagination.innerHTML += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}"><a class="page-link" onclick="window.goSystemPage(${currentPage - 1})">«</a></li>`;

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `<li class="page-item ${currentPage === i ? 'active' : ''}"><a class="page-link" onclick="window.goSystemPage(${i})">${i}</a></li>`;
            }

            // Next button
            pagination.innerHTML += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}"><a class="page-link" onclick="window.goSystemPage(${currentPage + 1})">»</a></li>`;
        }

        window.goSystemPage = function (page) {
            const totalPages = Math.ceil(currentLogs.length / perPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderSystemTable();
        }

        function initLogDetailModal() {
            document.querySelectorAll(".showLogDetail").forEach(item => {
                item.addEventListener("click", function () {
                    const log = allLogs.find(l => l.id == this.dataset.id);
                    if (!log) return;

                    document.getElementById("d_user").innerText = log.user;
                    document.getElementById("d_action").innerText = log.action;
                    document.getElementById("d_level").innerText = log.level;
                    document.getElementById("d_module").innerText = log.module;
                    document.getElementById("d_time").innerText = log.time;
                    document.getElementById("d_ip").innerText = log.ip;
                    document.getElementById("d_desc").innerText = log.desc;
                    document.getElementById("d_extra").innerText = log.extra || "Mavjud emas";

                    let modal = new bootstrap.Modal(document.getElementById('logDetailModal'));
                    modal.show();
                });
            });
        }

        // Asosiy DOMContentLoaded funksiyasi
        document.addEventListener('DOMContentLoaded', function () {
            // Filtr ochish/yopish funksiyasini ishga tushirish
            initFilterToggle('systemHistoryToggleFilterBtn', 'systemHistoryFilterContent', 'systemHistoryFilterIcon', 'systemHistoryFilterText');

            // Dastlabki jadvalni yuklash
            renderSystemTable();

            // Filtr tugmasi funksiyasi (Hozircha statik ma'lumotlar bilan ishlaydi, amalda backendga so'rov yuborilishi kerak)
            document.getElementById('filterBtn').addEventListener('click', function () {
                // Hozirda filtr funksiyasi qo'shilmagan, lekin u yerga filtrlash mantiqi qo'shiladi
                alert("Filtr funksiyasi hali to'liq ishga tushirilmagan. Statik ma'lumotlar ko'rsatilmoqda.");
            });

            // Tozalash tugmasi funksiyasi
            document.getElementById('clearBtn').addEventListener('click', function () {
                document.getElementById('searchInput').value = '';
                document.getElementById('logTypeFilter').value = 'all';
                document.getElementById('moduleFilter').value = 'all';
                document.getElementById('startDate').value = '';
                document.getElementById('endDate').value = '';

                currentLogs = [...allLogs];
                currentPage = 1;
                renderSystemTable();
            });
        });
    </script>
@endpush
