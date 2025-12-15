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


    .user-status-active,
    .user-status-blocked,
    .user-status-pending {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Yashil – Faol */
    .user-status-active {
        background: rgba(0, 200, 83, 0.15);
        color: #0f9d58;
    }

    /* Qizil – Block */
    .user-status-blocked {
        background: rgba(255, 0, 0, 0.15);
        color: #d93025;
    }

    /* Sariq – Pending */
    .user-status-pending {
        background: rgba(255, 193, 7, 0.15);
        color: #c99a00;
    }

    /* O‘qilmagan user row */
    .user-row-unread {
        background-color: #eef6ff !important;
        font-weight: 600;
        color: #2c3e50;
    }
</style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
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

        <x-export-dropdown :items="['excel','csv']" :urls="[
                'excel' => '#',
                'csv'   => '#',
            ]" />



        <!-- Yangi foydalanuvchi qo'shish -->
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm px-3 py-1" id="addUserBtn"
            style="min-width: 90px;">
            <i class="fas fa-plus me-1" style="font-size: 0.85rem;"></i> {{ __('admin.create') }}
        </a>

        <!-- Filter toggle -->
        <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#userFilterContent" aria-expanded="true"
            aria-controls="userFilterContent">
            <i class="fa-solid fa-list" style="font-size: 1.3rem;"></i>
        </button>
    </div>

</div>
@endsection

@section('content')

<!-- Filter card -->
@include('pages.users._filter')


@php
$datas = getUsersData();


$pagination = manualPaginate($datas, 10);


$paginatedUsers = $pagination['items'];


$currentPage = $pagination['currentPage'];
$pageCount = $pagination['pageCount'];

$start = $pagination['start'];
$total = $pagination['total'];
$end = $pagination['end'];


@endphp




<!-- Table -->
<div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
    <table class="table user-table table-bordered table-hover table-striped align-items-center">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
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

        <tbody>
            @foreach($paginatedUsers as $user)

            @php
            $roleIcons = [
            'Admin' => 'fa-solid fa-user-gear',
            'Moliyaviy auditor' => 'fa-solid fa-file-invoice-dollar',
            'Moderator' => 'fa-solid fa-user-shield',
            'Islom moliyasi nazorati' => 'fa-solid fa-scale-balanced',
            ];

            $icon = $roleIcons[$user['role']] ?? 'fa-solid fa-user-tag';
            @endphp

            <tr>
                <td>
                    {{ $user['id'] }}
                </td>

                <td>
                    {{ $user['name'] }}
                </td>

                <td>
                    {{ $user['username'] }}
                </td>

                <td>
                    <i class="fa-solid fa-phone me-1"></i>
                    {{ $user['phone'] }}
                </td>

                <td>
                    <i class="fa-solid fa-envelope me-1"></i>
                    {{ $user['email'] }}
                </td>

                <td>
                    <i class="{{ $icon }} me-1 text-dark"></i>
                    <span>{{ $user['role'] }}</span>
                </td>

                <td>
                    @php
                    $cls = match($user['status']) {
                    'Faol' => 'user-status-active',
                    default => 'user-status-blocked'
                    };

                    $icon = match($user['status']) {
                    'Faol' => 'fas fa-check-circle me-1',
                    default => 'fas fa-ban me-1'
                    };
                    @endphp

                    <span class="{{ $cls }}">
                        <i class="fas {{ $icon }} me-1"></i>
                        {{ $user['status'] }}
                    </span>
                </td>



                <!-- <td>
                    @if($user['status'] === 'Faol')

                    <span class="btn btn-outline-success">
                        <i class="fas fa-check-circle me-1"></i> Faol
                    </span> @else
                    <span class="btn btn-outline-danger">
                        <i class="fas fa-ban me-1"></i> Bloklangan
                    </span>
                    @endif
                </td> -->

                <td>
                    <i class="fa-solid fa-calendar-days me-1" style="color:#6c757d;"></i>
                    {{ \Carbon\Carbon::parse($user['created_at'])->format('H:i d.m.y') }}
                </td>


                <td class="text-center  justify-content-center gap-1">

                    <x-show-button href="{{ route('admin.users.show', $user['id']) }}" />
                    <x-edit-button href="{{ route('admin.users.edit', $user['id']) }}" />
                    <x-delete-button />



                    @if($user['status'] === 'Faol')
                    <button class="btn btn-link p-0 verify-btn" data-bs-toggle="modal" data-bs-target="#blockModalUser"
                        data-user-name="{{ $user['name'] }}" data-form-action="#" title="Blo'klash">
                        <i class="fas fa-lock-open status-info" style="font-size:18px;"></i>
                    </button>


                    @elseif($user['status'] === 'Bloklangan')
                    <button class="btn btn-link p-0 verify-btn" data-bs-toggle="modal"
                        data-bs-target="#unblockModalUser" data-user-name="{{ $user['name'] }}" data-form-action="#"
                        title="Bloklangan">
                        <i class="fas fa-lock status-blocked" style="font-size:18px;"></i>
                    </button>
                    @endif
                </td>
            </tr>
            @endforeach
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

<!-- Bloklash modal -->
<div class="modal fade" id="blockModalUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foydalanuvchini bloklash </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong id="blockUserName"></strong> foydalanuvchini bloklashni istaysizmi?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Diqqat! Bloklangan foydalanuvchi tizimga kirishi va barcha huquqlardan mahrum bo'ladi.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <form id="blockForm" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger">Bloklash</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Blokdan chiqarish modal -->
<div class="modal fade" id="unblockModalUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foydalanuvchini blokdan chiqarish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong id="unblockUserName"></strong> foydalanuvchini blokdan chiqarishni istaysizmi?</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Blokdan chiqarilgandan song foydalanuvchi tizimga kirishi va huquqlari tiklanadi.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <form id="unblockForm" method="POST" style="display:inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">Blokdan chiqarish</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@push('customJs')
<script>
    // Block modal uchun
    var blockModal = document.getElementById('blockModalUser')
    blockModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var investorName = button.getAttribute('data-user-name')
        var formAction = button.getAttribute('data-form-action')

        blockModal.querySelector('#blockUserName').textContent = investorName
        blockModal.querySelector('#blockForm').action = formAction
    })

    // Unblock modal uchun
    var unblockModal = document.getElementById('unblockModalUser')
    unblockModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var investorName = button.getAttribute('data-user-name')
        var formAction = button.getAttribute('data-form-action')

        unblockModal.querySelector('#unblockUserName').textContent = investorName
        unblockModal.querySelector('#unblockForm').action = formAction
    })
</script>
@endpush