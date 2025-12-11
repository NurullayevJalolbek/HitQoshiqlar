@extends('layouts.app')

@push('customCss')
<style>
    .status-icon {
        font-size: 18px;
        margin-right: 5px;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }


    .log-level-success {
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
</style>
@endpush


@section('breadcrumb')
<div
    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
    style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('admin.users') }}</li>
            </ol>
        </nav>
    </div>

    <div class="d-flex gap-2 align-items-center flex-wrap">

        <x-export-dropdown :items="['csv']" :urls="[
                'csv'   => '#',
            ]" />

        <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
            type="button" data-bs-toggle="collapse"
            data-bs-target="#loginHistoryFilterContent" aria-expanded="true"
            aria-controls="loginHistoryFilterContent">
            <i class="fa-solid fa-list" style="font-size: 1.3rem;"></i>
        </button>
    </div>
</div>
@endsection

@section('content')
@php
$datas = getLoginHistoriesData();


$pagination = manualPaginate($datas, 10);


$loginHistories = $pagination['items'];


$currentPage = $pagination['currentPage'];
$pageCount = $pagination['pageCount'];

$start = $pagination['start'];
$total = $pagination['total'];
$end = $pagination['end'];


@endphp



{{-- FILTER --}}
@include("pages.login-histories._filter")

{{-- LOGIN HISTORIES TABLE --}}
<div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
    <table class="table user-table table-bordered table-hover table-striped align-items-center">
        <thead class="table-dark">
            <tr>
                <th>№</th>
                <th>{{__('admin.user')}}</th>
                <th>{{__('admin.login')}}</th>
                <th>{{__('admin.date')}}</th>
                <th>{{__('admin.ip')}}</th>
                <th>{{__('admin.result')}}</th>
                <th>Amallar</th>
            </tr>
        </thead>

        <tbody>
            @forelse($loginHistories as $h)
            <tr>
                {{-- ID --}}
                <td>{{ $h['id'] }}</td>

                {{-- FOYDALANUVCHI --}}
                <td>
                    {{ $h['user'] }}
                </td>

                {{-- LOGIN --}}
                <td>
                    {{ $h['username'] }}
                </td>

                {{-- SANA --}}
                <td>
                    <i class="fas fa-calendar-alt me-1 text-muted"></i>
                    {{ \Carbon\Carbon::parse($h['date'])->format('H:i d.m.y') }}
                </td>

                {{-- IP --}}
                <td>
                    <i class="fas fa-network-wired  me-1"></i>
                    {{ $h['ip'] }}
                </td>

                {{-- NATIJA --}}
                <td>
                    @php
                    $cls = match($h['result']) {
                    'Muvaffaqiyatli' => 'status-active',
                    'Xato' => 'status-blocked',
                    default => 'status-pending'
                    };

                    $icon = match($h['result']) {
                    'Muvaffaqiyatli' => 'fa-check-circle',
                    'Xato' => 'fa-times-circle',
                    default => 'fas fa-exclamation-triangle'
                    };
                    @endphp

                    <span class="{{ $cls }}">
                        <i class="fas {{ $icon }} me-1"></i>
                        {{ $h['result'] }}
                    </span>
                </td>

                {{-- KO‘RISH --}}
                <td class="text-center  justify-content-center gap-1">

                    <i class="fas fa-eye text-primary showDetail"
                        data-id="{{ $h['id'] }}"
                        style="cursor: pointer;"></i>
                </td>


            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Hech qanday kirish tarixi topilmadi.</td>
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
<div class="modal fade" id="loginDetailModal" tabindex="-1">
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
                                <i class="fas fa-user  me-1"></i>
                                Foydalanuvchi
                            </th>
                            <td id="d_user"></td>
                        </tr>

                        <tr>
                            <th>
                                <i class="fas fa-id-badge  me-1"></i>
                                Login
                            </th>
                            <td id="d_login"></td>
                        </tr>

                        <tr>
                            <th>
                                <i class="fas fa-calendar-days me-1"></i>
                                Sana
                            </th>
                            <td id="d_date"></td>
                        </tr>

                        <tr>
                            <th>
                                <i class="fas fa-globe  me-1"></i>
                                IP manzil
                            </th>
                            <td id="d_ip"></td>
                        </tr>

                        <tr>
                            <th>
                                <i class="fas fa-flag-checkered  me-1"></i>
                                Natija
                            </th>
                            <td id="d_result"></td>
                        </tr>

                        <tr>
                            <th>
                                <i class="fas fa-location-dot  me-1"></i>
                                GEO
                            </th>
                            <td id="d_geo"></td>
                        </tr>

                        <tr>
                            <th>
                                <i class="fas fa-desktop  me-1"></i>
                                User-Agent
                            </th>
                            <td id="d_agent"></td>
                        </tr>

                        <tr>
                            <th>
                                <i class="fas fa-key  me-1"></i>
                                Session ID
                            </th>
                            <td id="d_session"></td>
                        </tr>

                        <tr>
                            <th>
                                <i class="fas fa-clock  me-1"></i>
                                Kirish davomiyligi
                            </th>
                            <td id="d_duration"></td>
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
    document.addEventListener("DOMContentLoaded", () => {

        const detailModal = new bootstrap.Modal(document.getElementById("loginDetailModal"));

        document.querySelectorAll(".showDetail").forEach(btn => {
            btn.addEventListener("click", async () => {

                const id = btn.dataset.id;

                try {
                    const res = await axios.get(`/admin/login-histories/${id}`);
                    console.log(res);

                    const d = res.data.data[0]; // ✅ TO‘G‘RI

                    document.getElementById('d_user').innerHTML =
                        `${d.user}`;

                    document.getElementById('d_login').innerHTML =
                        `${d.username}`;

                    document.getElementById('d_date').innerHTML =
                        `${d.date}`;

                    document.getElementById('d_ip').innerHTML =
                        `${d.ip}`;

                    document.getElementById('d_result').innerHTML =
                        (d.result === "Xato") ?
                        `${d.result}` :
                        (d.result === "Ogohlantirish") ?
                        `${d.result}` :
                        `${d.result}`;

                    document.getElementById('d_geo').innerHTML =
                        `${d.geo}`;

                    document.getElementById('d_agent').innerHTML =
                        `${d.user_agent}`;

                    document.getElementById('d_session').innerHTML =
                        `${d.session_id}`;

                    document.getElementById('d_duration').innerHTML =
                        `${d.login_duration}`;

                    detailModal.show();

                } catch (e) {
                    console.error(e);
                    alert("Ma'lumotni yuklashda xatolik!");
                }
            });
        });

    });
</script>


@endpush