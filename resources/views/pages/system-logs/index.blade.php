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
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4 breadcrumb-block">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('admin.system_logs')}}</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')

    {{-- FILTER CARD --}}
    <div class="filter-card mb-3 border rounded"
         style="border-color: rgba(0,0,0,0.1); border-radius: 0.5rem; background-color: #fff;">

        <div class="d-flex justify-content-between align-items-center p-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-search"></i>
                <span>Filterlar</span>
            </div>

            <button class="btn btn-sm rounded-pill px-3 py-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#systemHistoryFilterContent"
                    aria-controls="systemHistoryFilterContent"
                    id="systemHistoryToggleFilterBtn"
                    style="background-color:#1F2937;color:#fff;">
                <i class="bi bi-caret-down-fill me-2" id="systemHistoryFilterIcon"></i>
                <span id="systemHistoryFilterText">Yopish</span>
            </button>
        </div>

        <div class="collapse show" id="systemHistoryFilterContent">
            <div class="row g-3 align-items-end p-3">
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
                        <i class="fas fa-filter"></i> Izlash
                    </button>

                    <button id="clearBtn" class="btn btn-warning w-50">
                        Tozalash
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- LOG TABLE --}}
    <div class="card card-body py-1 px-2 shadow border-0 table-wrapper table-responsive">

        <div class="d-flex justify-content-between align-items-center p-3">
            <h5 class="mb-0">
                <i class="fas fa-history me-2"></i> {{ __('admin.system_logs') }}
            </h5>

            <button class="btn btn-info text-white">
                <i class="fas fa-file-csv"></i> CSV
            </button>
        </div>


        <table class="table user-table table-hover table-bordered  table-striped align-items-center">
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

            <tbody>

            @php
                $logs = [
                    ['time'=>'2025-12-01 14:35:12','level'=>'INFO','action'=>'update','module'=>"Loyihalar",'user'=>'admin','ip'=>'192.168.1.10','desc'=>"Loyiha ma'lumotlari yangilandi"],
                    ['time'=>'2025-12-01 14:32:00','level'=>'ERROR','action'=>'create','module'=>"Loyihalar",'user'=>'sardor','ip'=>'192.168.1.15','desc'=>"Loyiha yaratishda xatolik yuz berdi"],
                    ['time'=>'2025-12-01 14:28:12','level'=>'INFO','action'=>'export','module'=>"Loyihalar",'user'=>'ali','ip'=>'192.168.1.20','desc'=>"Loyihalarni export qilish amalga oshirildi"],
                    ['time'=>'2025-12-01 14:25:41','level'=>'WARNING','action'=>'delete','module'=>"Investorlar",'user'=>'bobur','ip'=>'192.168.1.18','desc'=>"Investorni o'chirishda noaniqlik kuzatildi"],
                    ['time'=>'2025-12-01 14:22:12','level'=>'INFO','action'=>'create','module'=>"Investorlar",'user'=>'anna','ip'=>'192.168.1.14','desc'=>"Yangi investor qo'shildi"],
                    ['time'=>'2025-12-01 14:20:00','level'=>'ERROR','action'=>'update','module'=>"Ma'muriyat bo'limi",'user'=>'admin','ip'=>'192.168.1.11','desc'=>"Admin sozlamalarida xatolik"],
                    ['time'=>'2025-12-01 14:18:09','level'=>'WARNING','action'=>'export','module'=>"Hisobotlar",'user'=>'dilshod','ip'=>'192.168.1.21','desc'=>"Hisobot eksportida vaqtinchalik kechikish"],
                    ['time'=>'2025-12-01 14:15:33','level'=>'INFO','action'=>'create','module'=>"Hisobotlar",'user'=>'ali','ip'=>'192.168.1.22','desc'=>"Yangi hisobot generatsiya qilindi"],
                    ['time'=>'2025-12-01 14:12:00','level'=>'ERROR','action'=>'delete','module'=>"Loyihalar",'user'=>'sardor','ip'=>'192.168.1.19','desc'=>"Loyihani o'chirishda xatolik aniqlandi"],
                    ['time'=>'2025-12-01 14:10:44','level'=>'INFO','action'=>'update','module'=>"Investorlar",'user'=>'bobur','ip'=>'192.168.1.16','desc'=>"Investor ma'lumotlari yangilandi"],
                ];
            @endphp

            @foreach($logs as $i => $log)
                <tr>
                    <!-- # -->
                    <td>{{ $i + 1 }}</td>

                    <!-- Foydalanuvchi -->
                    <td>{{ $log['user'] }}</td>

                    <!-- Turi -->
                    <td>{{ strtoupper($log['action']) }}</td>

                    <!-- Daraja -->
                    <td>
                        @if($log['level']=='INFO')
                            <span class="log-level-info"><i class="fas fa-check-circle"></i> INFO</span>
                        @elseif($log['level']=='WARNING')
                            <span class="log-level-warning"><i class="fas fa-exclamation-triangle"></i> WARNING</span>
                        @else
                            <span class="log-level-error"><i class="fas fa-times-circle"></i> ERROR</span>
                        @endif
                    </td>

                    <!-- Modul -->
                    <td>{{ $log['module'] }}</td>

                    <!-- Vaqti -->
                    <td>{{ $log['time'] }}</td>

                    <!-- IP -->
                    <td>{{ $log['ip'] }}</td>

                    <!-- Tavsif -->
                    <td>{{ $log['desc'] }}</td>

                    <!-- Actions (ko'zcha) -->
                    <td>
                        <i class="bi bi-eye-fill me-2"></i>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
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

        document.addEventListener('DOMContentLoaded', function () {
            initFilterToggle('systemHistoryToggleFilterBtn', 'systemHistoryFilterContent', 'systemHistoryFilterIcon', 'systemHistoryFilterText');
        });
    </script>
@endpush
