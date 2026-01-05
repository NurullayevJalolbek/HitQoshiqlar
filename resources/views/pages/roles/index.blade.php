@extends('layouts.app')

@push('customCss')
<style>
    .role-row-unread {
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
                <li class="breadcrumb-item active" aria-current="page">{{ __('admin.roles') }}</li>
            </ol>
        </nav>
    </div>

    <!-- Tugmalar guruhi -->
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <!-- Yangi foydalanuvchi qo'shish -->
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm px-3 py-1" id="addUserBtn"
            style="min-width: 90px;">
            <i class="fas fa-plus me-1" style="font-size: 0.85rem;"></i> {{ __('admin.create') }}
        </a>


        <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
            type="button" data-bs-toggle="collapse"
            data-bs-target="#roleFilterContent" aria-expanded="true"
            aria-controls="roleFilterContent">
            <i class="fa-solid fa-list" style="font-size: 1.3rem;"></i>
        </button>
    </div>
</div>
@endsection

@section('content')
@php
$datas = getRolesData();


$pagination = manualPaginate($datas, 10);


$roles = $pagination['items'];


$currentPage = $pagination['currentPage'];
$pageCount = $pagination['pageCount'];

$start = $pagination['start'];
$total = $pagination['total'];
$end = $pagination['end'];
@endphp


{{-- Filter--}}
<div class="filter-card mb-3 mt-2 collapse show" id="roleFilterContent" style="transition: all 0.3s ease;">
    <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
        <div class="row g-3 align-items-end">

            <!-- Role nomi bo'yicha qidiruv -->
            <div class="col-md-5">
                <label for="roleNameSearch">{{ __('admin.role_name') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fas fa-user-tag text-muted"></i></span>
                    <input type="text" class="form-control" id="roleNameSearch"
                        placeholder="{{ __('admin.role_name') }}...">
                </div>
            </div>

            <!-- Role kodi bo'yicha qidiruv -->
            <div class="col-md-5">
                <label for="roleCodeSearch">{{ __('admin.code') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fas fa-code"></i></span>
                    <input type="text" class="form-control" id="roleCodeSearch"
                        placeholder="{{ __('admin.code') }}...">
                </div>
            </div>

            <!-- Tugmalar -->
            <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />


        </div>
    </div>
</div>


{{--Content--}}
<div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
    <table class="table user-table table-bordered table-hover table-striped align-items-center">
        <thead class="table-dark">
            <tr>
                <th>№</th>
                <th>{{__('admin.icon')}}</th>
                <th>{{__('admin.name')}}</th>
                <th>{{__('admin.code')}}</th>
                <th>{{__('admin.users_count')}}</th>
                <th>{{__('admin.description')}}</th>
                <th class="text-center">{{__('admin.actions')}}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $index => $role)
            <tr>
                <td class="text-start">
                    <div class="lift-inner">{{ $loop->iteration }}</div>
                </td>
                <td class="text-center">
                    <div class="lift-inner">
                        <i class="{{ $role['icon'] ?? 'fas fa-user' }}"></i>
                    </div>
                </td>
                <td class="text-start">
                    <div class="lift-inner">{{ $role['name'] }}</div>
                </td>
                <td class="text-start">
                    <div class="lift-inner">{{ $role['code'] }}</div>
                </td>
                <td class="text-center">
                    <div class="lift-inner" data-users="{{ $role['users_count'] }}">
                        {{ $role['users_count'] }}
                    </div>
                </td>
                <td class="text-start">
                    <div class="lift-inner">{{ $role['description'] }}</div>
                </td>
                <td class="text-center  justify-content-center gap-1">
                    <div class="action-buttons d-flex gap-2 justify-content-end">


                        <!-- Ruxsatlar (kalit) -->
                        <a href="{{ route('admin.role-permissions.index', ['role_id' => $role['id']]) }}"
                            class="btn btn-sm p-1 {{ $role['is_deletable'] ?? true ? '' : 'disabled' }}"
                            style="background: none; border: none; color: #1F2937;"
                            title="{{ __('admin.permissions') }}">
                            <i class="fa-solid fa-shield text-info"></i>
                        </a>


                        <!-- Tahrirlash (qalam) -->
                        <x-edit-button href="{{ route('admin.roles.edit', $role['id']) }}" />




                        <!-- O‘chirish (savatcha) -->
                        @if($role['is_deletable'] !== false)
                        <a href="javascript:void(0);"
                            class="btn btn-sm p-0 "
                            style="background: none; color: #bd2130;"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Delete"
                            onclick='infoModel(@json(__("admin.warning")), @json(__("admin.role_delete_warning")));'>
                            <svg class="icon icon-xs text-danger status-blocked" title="Delete" data-bs-toggle="tooltip" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>

                        @else
                        <x-delete-button />
                        @endif



                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4">
                    <div class="text-muted">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <p>{{ __('admin.no_roles_found') }}</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

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

@push('customJs')


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const table = document.querySelector('.user-table tbody');
        const rows = table.querySelectorAll('tr');

        // Qidiruv
        searchInput.addEventListener('input', function() {
            const filter = searchInput.value.toLowerCase();
            rows.forEach(row => {
                // row ichidagi barcha textlarni tekshiramiz
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });

        // Tozalash
        const clearBtn = document.getElementById('clearBtn');
        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            rows.forEach(row => row.style.display = '');
        });

        // Role o'chirish
        const deleteButtons = document.querySelectorAll('.delete-role');
        let currentRow;
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                currentRow = this.closest('tr');
                const userCountEl = currentRow.querySelector('[data-users]');
                const userCount = userCountEl ? parseInt(userCountEl.dataset.users) : 0;
                if (userCount > 0) {
                    const warningModal = new bootstrap.Modal(document.getElementById('warningModal'));
                    warningModal.show();
                } else {
                    currentRow.remove();
                }
            });
        });
    });
</script>
@endpush