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


    .status-active,
    .status-blocked,
    .status-pending {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        backdrop-filter: blur(6px);
        /* shaffof effekt */
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Yashil – Muvaffaqiyatli */
    .status-active {
        background: rgba(0, 200, 83, 0.15);
        color: #0f9d58;
    }

    /* Qizil – Xato */
    .status-blocked {
        background: rgba(255, 0, 0, 0.15);
        color: #d93025;
    }

    /* Sariq – Kutilyapti */
    .status-pending {
        background: rgba(255, 193, 7, 0.15);
        color: #c99a00;
    }

    
        .system-login-row-unread {
    background-color: #eef6ff !important;
    font-weight: 600;
    color: #2c3e50;
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

        <x-export-dropdown :items="['csv','pdf']" :urls="[
                'csv'   => '#',
                'pdf'   => '#'
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

            <tr class="system-login-row-unread">
                <td>
                    {{ $loop->iteration + $start - 1 }}
                </td>
                <td>
                    {{ $systemLog['user'] }}
                </td>
                <td>
                    {{ $systemLog['action'] }}
                </td>

                <td>
                    @php

                    $cls = match($systemLog['level']){
                    'Muvaffaqiyatli' => 'status-active',
                    'Ogohlantirish' => 'status-pending',
                    'Xato' => 'status-blocked',
                    default => 'text-secondary'
                    };
                    $icon = match($systemLog['level']){
                    'Muvaffaqiyatli' => 'fas fa-check-circle',
                    'Ogohlantirish' => 'fas fa-exclamation-triangle',
                    'Xato' => 'fas fa-times-circle',
                    default => 'fas fa-circle-info'
                    };
                    @endphp
                    <span class="{{ $cls }}">
                        <i class="fas {{ $icon }} me-1"></i>
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
                    {{ $systemLog['desc'] }}
                </td>
                <td class="text-center  justify-content-center gap-1">

                    <i class="fas fa-eye text-primary systemLogShowDetail"
                        data-id="{{ $systemLog['id'] }}"
                        style="cursor: pointer;"></i>
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
<div class="modal fade" id="systemLogDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle text-primary me-1"></i>
                    Kirish tafsilotlari
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th>
                                <i class="fas fa-user-circle me-1"></i>
                                Foydalanuvchi
                            </th>
                            <td id="d_user"></td>
                        </tr>
                        <tr>
                            <th>
                                <i class="fas fa-exchange-alt me-1"></i>
                                Turi
                            </th>
                            <td id="d_action"></td>
                        </tr>
                        <tr>
                            <th>
                                <i class="fas fa-signal me-1"></i>
                                Holati
                            </th>
                            <td id="d_level"></td>
                        </tr>
                        <tr>
                            <th>
                                <i class="fas fa-cubes me-1"></i>
                                Module
                            </th>
                            <td id="d_module"></td>
                        </tr>
                        <tr>
                            <th>
                                <i class="fas fa-calendar-alt me-1"></i>
                                Sana
                            </th>
                            <td id="d_time"></td>
                        </tr>
                        <tr>
                            <th>
                                <i class="fas fa-network-wired me-1"></i>
                                IP
                            </th>
                            <td id="d_IP"></td>
                        </tr>
                        <tr>
                            <th>
                                <i class="fas fa-info-circle me-1"></i>
                                Tavsifi
                            </th>
                            <td id="d_desc"></td>
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
    document.addEventListener('DOMContentLoaded', function() {

        const detailModal = new bootstrap.Modal(document.getElementById("systemLogDetailModal"));



        document.querySelectorAll(".systemLogShowDetail").forEach(btn => {

            btn.addEventListener("click", async () => {

                const id = btn.getAttribute("data-id");

                try {

                    const response = await axios.get('/admin/system-logs/' + id);


                    const data = response.data.data[0];


                    document.getElementById('d_user').innerHTML =
                        `${data.user}`;
                    document.getElementById('d_action').innerHTML =
                        `${data.action}`;
                    document.getElementById('d_level').innerHTML =
                        `${data.level}`;
                    document.getElementById('d_module').innerHTML =
                        `${data.module}`;
                    document.getElementById('d_time').innerHTML =
                        `${data.time}`;
                    document.getElementById('d_IP').innerHTML =
                        `${data.ip}`;
                    document.getElementById('d_desc').innerHTML =
                        `${data.desc}`;
                    detailModal.show();

                } catch (e) {
                    console.error(e);
                    alert("Ma'lumotni yuklashda xatolik!");
                }
            });
        })

    })
</script>
@endpush