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
                    <i class="fa-solid fa-user me-1 text-primary"></i>
                    {{ $user['name'] }}
                </td>

                <td>
                    <i class="fa-solid fa-image-portrait"></i>
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
                    @if($user['status'] === 'Faol')
                    <i class="fa-solid fa-circle-check me-1 text-success"></i>
                    <span class="status-active">Faol</span>
                    @else
                    <i class="fa-solid fa-circle-xmark me-1 text-danger"></i>
                    <span class="status-blocked">Bloklangan</span>
                    @endif
                </td>

                <td>
                    <i class="fa-solid fa-calendar-days me-1" style="color:#6c757d;"></i>
                    {{ \Carbon\Carbon::parse($user['created_at'])->format('H:i d.m.y') }}
                </td>


                <td class="text-center d-flex justify-content-center gap-2">
                    <x-show-button href="{{ route('admin.users.show', $user['id']) }}" />
                    <x-edit-button href="{{ route('admin.users.edit', $user['id']) }}" />
                    <x-delete-button />
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


@endsection