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

        .hover-lift:hover {
            background: #f7f7f7;
            transform: translateY(-2px);
        }

        .action-btn i {
            font-size: 18px;
        }
    </style>
@endpush


@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4 breadcrumb-block">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('admin.users')}}</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')

    <!-- Filter card -->
    <div class="filter-card mb-3 border rounded"
         style="border-color: rgba(0,0,0,0.1); border-radius: 0.5rem; background-color: #fff;">


        <!-- Filter header -->
        <div class="d-flex justify-content-between align-items-center p-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-search"></i>
                <span>Filterlar</span>
            </div>

            <button class="btn btn-sm rounded-pill px-3 py-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#filterContent" aria-expanded="true"
                    aria-controls="filterContent" id="toggleFilterBtn"
                    style="background-color: #1F2937; color: #ffffff;">
                <i class="bi bi-caret-down-fill me-2" id="filterIcon" style="color: #ffffff;">
                    <span id="filterText">Ochish</span>
                </i>
            </button>
        </div>

        <!-- Filter content -->
        <div class="collapse hidden" id="filterContent">
            <div class="row g-3 align-items-end p-3">
                {{-- Qidiruv --}}
                <div class="col-md-4">
                    <label for="searchInput">{{__('admin.search')}}</label>
                    <input type="text" id="searchInput" class="form-control"
                           placeholder="{{__('admin.full_name')}}, {{__('admin.login')}}, {{__('admin.email')}}...">
                </div>

                {{-- Rol bo‘yicha filter --}}
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

                {{-- Holat bo‘yicha filter --}}
                <div class="col-md-3">
                    <label for="statusFilter">{{__('admin.by_status')}}</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">{{__('admin.all')}}</option>
                        <option value="Faol">Faol</option>
                        <option value="Bloklangan">Bloklangan</option>
                    </select>
                </div>

                {{-- Tugmalar --}}
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

    {{-- Content --}}
    <div class="card card-body py-1 px-2 shadow border-0 table-wrapper table-responsive">
        <div class="d-flex justify-content-between align-items-center p-3">
            <h5 class="mb-0">
                <i class="fas fa-users me-2"></i> {{ __('admin.users') }}
            </h5>

            <div class="d-flex gap-2">
                <!-- Export Excel -->
                <button class="btn btn-success" id="exportExcelBtn">
                    <i class="fas fa-file-excel me-1"></i> Excel
                </button>

                <!-- Export CSV -->
                <button class="btn btn-info text-white" id="exportCsvBtn">
                    <i class="fas fa-file-csv me-1"></i> CSV
                </button>

                <!-- Yangi foydalanuvchi qo'shish -->
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary" id="addUserBtn">
                    <i class="fas fa-plus me-1"></i> {{ __('admin.add_new_user') }}
                </a>
            </div>
        </div>


        <table class="table user-table table-hover table-striped align-items-center">
            <thead class="table-dark">
            <tr>
                <th class="border-bottom text-start">№</th>
                <th class="border-bottom text-start">{{__('admin.full_name')}}</th>
                <th class="border-bottom">{{__('admin.login')}}</th>
                <th class="border-bottom">{{__('admin.phone')}}</th>
                <th class="border-bottom">{{__('admin.email')}}</th>
                <th class="border-bottom">{{__('admin.role')}}</th>
                <th class="border-bottom">{{__('admin.status')}}</th>
                <th class="border-bottom">{{__('admin.last_login')}}</th>
                <th class="border-bottom text-center">{{__('admin.actions')}}</th>
            </tr>
            </thead>

            <tbody>
            {{-- 1-user --}}
            <tr class="hover-lift">
                <td>1</td>
                <td class="text-start">Alisher Karimov</td>
                <td>alisher_admin</td>
                <td>+998 90 123 45 67</td>
                <td>alisher@example.com</td>
                <td><span class="role-badge">Admin</span></td>
                <td><span class="status-active">Faol</span></td>
                <td>2025-11-25 14:32</td>
                <td class="text-center d-flex justify-content-center gap-2">
                    <a href="#" class="btn btn-sm p-1" style="background:none;color:#1F2937;">
                        <i class="bi bi-eye-fill"></i>
                    </a>
                    <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <a href="#" class="btn btn-sm p-1 delete-role" style="background:none;color:#DC2626;">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>

            {{-- 2-user --}}
            <tr class="hover-lift">
                <td>2</td>
                <td class="text-start">Dilshod Fayzullayev</td>
                <td>dilshod_manager</td>
                <td>+998 93 111 22 33</td>
                <td>dilshod@example.com</td>
                <td><span class="role-badge">Moderator</span></td>
                <td><span class="status-active">Faol</span></td>
                <td>2025-11-26 09:15</td>
                <td class="text-center d-flex justify-content-center gap-2">
                    <a href="#" class="btn btn-sm p-1" style="background:none;color:#1F2937;">
                        <i class="bi bi-eye-fill"></i>
                    </a>
                    <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <a href="#" class="btn btn-sm p-1 delete-role" style="background:none;color:#DC2626;">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>

            {{-- 3-user --}}
            <tr class="hover-lift">
                <td>3</td>
                <td class="text-start">Muhammad Yusuf</td>
                <td>yusuf_fin</td>
                <td>+998 95 555 44 22</td>
                <td>yusuf@example.com</td>
                <td><span class="role-badge">Moliyaviy auditor</span></td>
                <td><span class="status-blocked">Bloklangan</span></td>
                <td>2025-11-20 18:20</td>
                <td class="text-center d-flex justify-content-center gap-2">
                    <a href="#" class="btn btn-sm p-1" style="background:none;color:#1F2937;">
                        <i class="bi bi-eye-fill"></i>
                    </a>
                    <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <a href="#" class="btn btn-sm p-1 delete-role" style="background:none;color:#DC2626;">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>

            {{-- 4-user --}}
            <tr class="hover-lift">
                <td>4</td>
                <td class="text-start">Sarvar Beknazarov</td>
                <td>sarvar_hr</td>
                <td>+998 97 777 88 11</td>
                <td>sarvar@example.com</td>
                <td><span class="role-badge">Islom moliyasi nazorati</span></td>
                <td><span class="status-active">Faol</span></td>
                <td>2025-11-26 07:55</td>
                <td class="text-center d-flex justify-content-center gap-2">
                    <a href="#" class="btn btn-sm p-1" style="background:none;color:#1F2937;">
                        <i class="bi bi-eye-fill"></i>
                    </a>
                    <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <a href="#" class="btn btn-sm p-1 delete-role" style="background:none;color:#DC2626;">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>

    </div>

@endsection

@push('customJs')
    <script>
        const filterCollapse = document.getElementById('filterContent');
        const toggleBtn = document.getElementById('toggleFilterBtn');
        const filterIcon = document.getElementById('filterIcon');
        const filterText = document.getElementById('filterText');

        // Default holat: yopiq
        filterCollapse.classList.remove('show');
        filterIcon.classList.remove('bi-caret-down-fill');
        filterIcon.classList.add('bi-caret-up-fill');
        filterText.textContent = 'Ochish';

        // Collapse ochilganda
        filterCollapse.addEventListener('shown.bs.collapse', () => {
            filterIcon.classList.remove('bi-caret-up-fill');
            filterIcon.classList.add('bi-caret-down-fill');
            filterText.textContent = 'Yopish';
        });

        // Collapse yopilganda
        filterCollapse.addEventListener('hidden.bs.collapse', () => {
            filterIcon.classList.remove('bi-caret-down-fill');
            filterIcon.classList.add('bi-caret-up-fill');
            filterText.textContent = 'Ochish';
        });

        filterCollapse.addEventListener('shown.bs.collapse', () => {
            filterIcon.classList.remove('bi-caret-up-fill');
            filterIcon.classList.add('bi-caret-down-fill');
        });

        filterCollapse.addEventListener('hidden.bs.collapse', () => {
            filterIcon.classList.remove('bi-caret-down-fill');
            filterIcon.classList.add('bi-caret-up-fill');
        });


    </script>
@endpush
