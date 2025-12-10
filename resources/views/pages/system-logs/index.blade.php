@extends('layouts.app')

@push('customCss')
<style>
    .log-level-info {
        color: #1e7e34;
        /* yashil */
        font-weight: 600;
    }

    .log-level-warning {
        color: #d39e00;
        /* sariq */
        font-weight: 600;
    }

    .log-level-error {
        color: #bd2130;
        /* qizil */
        font-weight: 600;
    }

    .view-icon {
        cursor: pointer;
        font-size: 18px;
    }

    .table td,
    .table th {
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

        <x-export-dropdown :items="['csv']" :urls="[
                'csv'   => '#',
            ]" />

        <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
            type="button" data-bs-toggle="collapse"
            data-bs-target="#systemHistoryFilterContent" aria-expanded="true"
            aria-controls="systemHistoryFilterContent">
            <i class="fa-solid fa-list" style="font-size: 1.3rem;"></i>
        </button>
    </div>
</div>
@endsection

@section('content')

@php
$datas = getSystemLogsData();


$pagination = manualPaginate($datas, 10);


$systemLogs = $pagination['items'];


$currentPage = $pagination['currentPage'];
$pageCount = $pagination['pageCount'];

$start = $pagination['start'];
$total = $pagination['total'];
$end = $pagination['end'];


@endphp



{{-- FILTER CARD --}}
@include('pages.system-logs._filter')


{{-- LOG TABLE --}}
<div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
    <table class="table user-table table-bordered table-hover table-striped align-items-center">
        <thead class="table-dark">
            <tr>
                <th>№</th>
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
            @forelse($systemLogs as $systemLog)
            @php
            // Levelga qarab icon va class
            $levelIcons = [
            'INFO' => ['icon' => 'fas fa-check-circle', 'class' => 'text-success'],
            'WARNING' => ['icon' => 'fas fa-exclamation-triangle', 'class' => 'text-warning'],
            'ERROR' => ['icon' => 'fas fa-times-circle', 'class' => 'text-danger'],
            ];
            $levelData = $levelIcons[$systemLog['level']] ?? ['icon' => 'fas fa-circle-info', 'class' => 'text-secondary'];
            @endphp

            <tr>
                <td>
                    {{ $loop->iteration + $start - 1 }}
                </td>
                <td>
                    <i class="fas fa-user me-1 text-primary"></i>
                    {{ $systemLog['user'] }}
                </td>
                <td>
                    {{ $systemLog['action'] }}
                </td>
                <td>
                    <i class="{{ $levelData['icon'] }} me-1 {{ $levelData['class'] }}"></i>
                    <span class="{{ $levelData['class'] }}">
                        {{ $systemLog['level'] }}
                    </span>
                </td>
                <td>
                    <i class="fas fa-layer-group me-1 text-primary"></i>
                    {{ $systemLog['module'] }}
                </td>
                <td>
                    <i class="fas fa-calendar-days me-1 text-primary"></i>
                    {{ \Carbon\Carbon::parse($systemLog['time'])->format('H:i d.m.y') }}
                </td>
                <td>
                    <i class="fas fa-network-wired me-1 text-primary"></i>
                    {{ $systemLog['ip'] }}
                </td>
                <td>
                    <i class="fas fa-file-alt me-1 text-dark"></i>
                    {{ $systemLog['desc'] }}
                </td>
                <td class="text-center">
                   <x-show-button />
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center text-muted">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    Hech qanday log topilmadi
                </td>
            </tr>
            @endforelse
        </tbody>


    </table>

    <!-- Paginatsa -->
    <div class="d-flex justify-content-between align-items-center mt-2">

        <div class="text-muted">
            {{ $start }} - {{ $end }} / Jami: {{ $total }}
        </div>

        <div>
            <x-pagination :pageCount="$pageCount" :currentPage="$currentPage" />
        </div>
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
    //
</script>
@endpush