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
    <div class="card p-3 mb-3">
        <div class="row g-3 align-items-end">
            <div class="col-md-2">
                <label>{{__('admin.search')}}</label>
                <input type="text" id="searchInput" class="form-control" placeholder="Kalit so'z, foydalanuvchi...">
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

            <div class="col-auto d-flex gap-2">
                <button id="filterBtn" class="btn btn-primary">
                    <i class="fas fa-filter"></i> {{__('admin.search')}}
                </button>
                <button id="clearBtn" class="btn btn-warning">{{__('admin.clear')}}</button>
            </div>
        </div>
    </div>

    {{-- LOG TABLE --}}
    <div class="card shadow border-0 table-wrapper table-responsive">
        <div class="d-flex justify-content-between align-items-center p-3">
            <h5 class="mb-0">{{__('admin.system_logs')}}</h5>
            <button class="btn btn-info text-white"><i class="fas fa-file-csv"></i> CSV</button>
        </div>

        <table class="table table-hover align-middle text-center">
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
                        <i class="fas fa-eye view-icon" style="cursor:pointer;"></i>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
@endsection

@push('customJs')
@endpush
