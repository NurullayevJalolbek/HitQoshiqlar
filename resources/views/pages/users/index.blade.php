@extends('layouts.app')

@push('customCss')
<style>
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

    .user-status-active {
        background: rgba(0, 200, 83, 0.15);
        color: #0f9d58;
    }

    .user-status-blocked {
        background: rgba(255, 0, 0, 0.15);
        color: #d93025;
    }

    .user-status-pending {
        background: rgba(255, 193, 7, 0.15);
        color: #c99a00;
    }
</style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
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
        <x-export-dropdown :items="['excel','csv']" :urls="[
            'excel' => '#',
            'csv'   => '#',
        ]" />

        <a href="{{ route('admin.users.create', ['go_back' => url()->full()]) }}"
            class="btn btn-primary btn-sm px-3 py-1" style="min-width: 90px;">
            <i class="fas fa-plus me-1" style="font-size: 0.85rem;"></i> {{ __('admin.create') }}
        </a>

        <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#userFilterContent" aria-expanded="true"
            aria-controls="userFilterContent">
            <i class="fa-solid fa-list" style="font-size: 1.3rem;"></i>
        </button>
    </div>
</div>
@endsection

@section('content')

@include('pages.users._filter')

@php
$pagination = manualPaginate($datas, 10);

$paginatedUsers = $pagination['items'];
$currentPage = $pagination['currentPage'];
$pageCount = $pagination['pageCount'];

$start = $pagination['start'];
$total = $pagination['total'];
$end = $pagination['end'];
@endphp

<div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
    <table class="table user-table table-bordered table-hover table-striped align-items-center">
        <thead class="table-dark">
            <tr>
                <th style="width: 60px">#</th>
                <th>Fullname</th>
                <th>Username</th>
                <th>Xabarlar</th>
                <th>Chat ID</th>
                <th>Botmi?</th>
                <th>Locale</th>
                <th>Status</th>
                <th>Created at</th>
            </tr>
        </thead>

        <tbody>
            @forelse($paginatedUsers as $index => $user)
            @php
            $isBot = (string)($user['is_bot'] ?? '0');

            $status = $user['status'] ?? 'inactive';
            $statusClass = match ($status) {
            'active' => 'user-status-active',
            'pending' => 'user-status-pending',
            default => 'user-status-blocked',
            };
            @endphp

            <tr>
                <td class="text-center fw-bold">{{ $start + $index }}</td>

                <td>{{ $user['fullname'] ?? '-' }}</td>
                <td>
                    @if(!empty($user['username']))
                    <a href="https://t.me/{{ ltrim($user['username'], '@') }}"
                        target="_blank"
                        class="text-decoration-none d-inline-flex align-items-center gap-1">

                        <i class="fa-brands fa-telegram text-primary"></i>
                        <span>{{ '@' . ltrim($user['username'], '@') }}</span>
                    </a>
                    @else
                    -
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{ route('admin.messages.index', ['user_id' => $user['id']]) }}"
                        class="btn btn-sm d-inline-flex align-items-center gap-1"
                        style="color:#229ED9;"
                        title="Xabarlar">
                        <i class="fa-solid fa-paper-plane"></i>
                    </a>
                </td>



                <td>{{ $user['chat_id'] ?? '-' }}</td>

                <td>
                    @if($isBot === '1')
                    <span class="badge bg-warning text-dark">BOT</span>
                    @else
                    <span class="badge bg-success">USER</span>
                    @endif
                </td>


                <td>{{ $user['locale'] ?? '-' }}</td>

                <td>
                    <span class="{{ $statusClass }}">{{ $status }}</span>
                </td>

                <td>
                    {{ !empty($user['created_at']) ? \Carbon\Carbon::parse($user['created_at'])->format('H:i d.m.y') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-4">
                    Hozircha foydalanuvchilar topilmadi
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination (o'zgartirmadim) --}}
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