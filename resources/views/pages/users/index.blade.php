@extends('layouts.app')

@push('customCss')
    <style>
        .status-active {
            color: #1e7e34;
            font-weight: bold;
        }

        .status-blocked {
            color: #bd2130;
            font-weight: bold;
        }

        /* Yangi rol badge rangi (1F2937) */
        .role-badge {
            background: #1F2937 !important;
            color: #fff;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
        }


        .action-btn i {
            font-size: 18px;
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
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.users') }}</li>
                </ol>
            </nav>
        </div>

        <!-- Tugmalar guruhi -->
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button class="btn btn-success btn-sm px-2 py-1" id="exportExcelBtn">
                <i class="fas fa-file-excel me-1" style="font-size: 0.85rem;"></i> Excel
            </button>

            <!-- Export CSV -->
            <button class="btn btn-info btn-sm text-white px-2 py-1" id="exportCsvBtn">
                <i class="fas fa-file-csv me-1" style="font-size: 0.85rem;"></i> CSV
            </button>

            <!-- Yangi foydalanuvchi qo'shish -->
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm px-3 py-1" id="addUserBtn"
               style="min-width: 90px;">
                <i class="fas fa-plus me-1" style="font-size: 0.85rem;"></i> {{ __('admin.create') }}
            </a>


            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#userFilterContent" aria-expanded="true"
                    aria-controls="userFilterContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')

    <!-- Filter card -->
    <div class="filter-card mb-3 mt-2 collapse show" id="userFilterContent" style="transition: all 0.3s ease;">
        <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
            <div class="row g-3 align-items-end">
                <!-- Qidiruv -->
                <div class="col-md-4">
                    <label for="searchInput">{{__('admin.search')}}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control"
                               placeholder="{{__('admin.full_name')}}, {{__('admin.login')}}, {{__('admin.email')}}...">
                    </div>
                </div>

                <!-- Rol bo‘yicha filter -->
                <div class="col-md-3">
                    <label for="roleFilter">{{__('admin.by_role')}}</label>
                    <select id="roleFilter" class="form-select">
                        <option value="">{{__('admin.all')}}</option>
                        <option value="Admin">Admin</option>
                        <option value="Moliyaviy auditor">Moliyaviy auditor</option>
                        <option value="Moderator">Moderator</option>
                        <option value="Islom moliyasi nazorati">Islom moliyasi nazorati</option>
                    </select>
                </div>

                <!-- Holat bo‘yicha filter -->
                <div class="col-md-3">
                    <label for="statusFilter">{{__('admin.by_status')}}</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">{{__('admin.all')}}</option>
                        <option value="Faol">Faol</option>
                        <option value="Bloklangan">Bloklangan</option>
                    </select>
                </div>

                <!-- Filter tugmalari -->
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


    <!-- Table -->
    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table user-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
            <tr>
                <th>№</th>
                <th>F.I.Sh</th>
                <th>Login</th>
                <th>Telefon</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Status</th>
                <th>Oxirgi kirish</th>
                <th class="text-center">Amallar</th>
            </tr>
            </thead>
            <tbody id="userTableBody">
            {{-- JS orqali to‘ldiriladi --}}
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="d-flex justify-content-start p-2">
            <nav>
                <ul class="pagination pagination-sm mb-0" id="pagination">
                    {{-- JS orqali yaratiladi --}}
                </ul>
            </nav>
        </div>
    </div>

@endsection

@push('customJs')
    <script>
        // *** 8 TA STATIK USER ***
        const users = [
            [1, 'Olim Jo‘rayev', 'olim_admin', '+998 90 111 22 33', 'olim@example.com', 'Admin', 'Faol', '2025-11-25 14:32'],
            [2, 'Javohir Tursunov', 'javohir_mod1', '+998 93 222 33 44', 'javohir@example.com', 'Moderator', 'Faol', '2025-11-26 09:15'],
            [3, 'Rustam Abdurahmonov', 'rustam_mod2', '+998 95 333 44 55', 'rustam@example.com', 'Moderator', 'Faol', '2025-11-24 11:20'],
            [4, 'Zoir Bekmurodov', 'zoir_mod3', '+998 97 444 55 66', 'zoir@example.com', 'Moderator', 'Bloklangan', '2025-11-20 18:20'],
            [5, 'Nodir Qodirov', 'nodir_aud1', '+998 90 555 66 77', 'nodir@example.com', 'Moliyaviy auditor', 'Faol', '2025-11-23 15:52'],
            [6, 'Umid Abdullayev', 'umid_aud2', '+998 93 666 77 88', 'umid@example.com', 'Moliyaviy auditor', 'Bloklangan', '2025-11-19 10:10'],
            [7, 'Sirojiddin Madrahimov', 'siroj_islam1', '+998 97 777 88 99', 'siroj@example.com', 'Islom moliyasi nazorati', 'Faol', '2025-11-26 07:55'],
            [8, 'Husan Sharipov', 'husan_islam2', '+998 95 888 99 00', 'husan@example.com', 'Islom moliyasi nazorati', 'Faol', '2025-11-22 12:40'],

            // Qo‘shimcha 7 ta yangi foydalanuvchi
            [9, 'Sherzod Mamatov', 'sherzod_admin2', '+998 90 112 45 67', 'sherzod@example.com', 'Moderator', 'Faol', '2025-11-27 08:10'],
            [10, 'Jasur Rahmonov', 'jasur_mod4', '+998 93 221 44 55', 'jasur@example.com', 'Moderator', 'Faol', '2025-11-25 19:44'],
            [11, 'Dilshod Yusupov', 'dilshod_aud3', '+998 91 334 55 66', 'dilshod@example.com', 'Moliyaviy auditor', 'Bloklangan', '2025-11-18 11:05'],
            [12, 'Farrux Karimov', 'farrux_islam3', '+998 94 445 66 77', 'farrux@example.com', 'Islom moliyasi nazorati', 'Faol', '2025-11-23 16:15'],
            [13, 'Bekzod Soliyev', 'bekzod_mod5', '+998 99 556 77 88', 'bekzod@example.com', 'Moderator', 'Faol', '2025-11-26 10:40'],
            [14, 'Bobur Xolmatov', 'bobur_aud4', '+998 90 667 88 99', 'bobur@example.com', 'Moliyaviy auditor', 'Faol', '2025-11-24 13:22'],
            [15, 'Akmal Ortiqov', 'akmal_islam4', '+998 93 778 99 11', 'akmal@example.com', 'Islom moliyasi nazorati', 'Bloklangan', '2025-11-21 09:05'],
        ];


        // PAGINATION SETTINGS
        const perPage = 10;          // 1-sahifada 5 ta
        const totalPages = 2;       // jami 2 sahifa (5 + 3)
        let currentPage = 1;

        // Table render
        function renderTable() {
            let tbody = document.getElementById('userTableBody');
            tbody.innerHTML = "";

            let start = (currentPage - 1) * perPage;
            let end = start + perPage;

            let pageUsers = users.slice(start, end);

            pageUsers.forEach(u => {
                tbody.innerHTML += `
                <tr class="hover-lift">
                    <td>${u[0]}</td>
                    <td class="text-start">${u[1]}</td>
                    <td>${u[2]}</td>
                    <td>${u[3]}</td>
                    <td>${u[4]}</td>
                    <td><span class="role-badge">${u[5]}</span></td>
                    <td>${u[6] === 'Faol'
                    ? '<span class="status-active">Faol</span>'
                    : '<span class="status-blocked">Bloklangan</span>'}
                    </td>
                    <td>${u[7]}</td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#1F2937;"><i class="bi bi-eye-fill"></i></a>
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;"><i class="bi bi-pencil-fill"></i></a>
                        <a href="#" class="btn btn-sm p-1 delete-role" style="background:none;color:#DC2626;"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
            `;
            });

            renderPagination();
        }

        // Pagination create
        function renderPagination() {
            let pagination = document.getElementById('pagination');
            pagination.innerHTML = "";

            pagination.innerHTML += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" onclick="goPage(${currentPage - 1})">«</a>
            </li>
        `;

            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `
                <li class="page-item ${currentPage === i ? 'active' : ''}">
                    <a class="page-link" onclick="goPage(${i})">${i}</a>
                </li>
            `;
            }

            pagination.innerHTML += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" onclick="goPage(${currentPage + 1})">»</a>
            </li>
        `;
        }

        // page switch
        function goPage(page) {
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable();
        }

        // Init
        renderTable();
    </script>
@endpush
