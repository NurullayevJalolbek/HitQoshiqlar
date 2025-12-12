@extends('layouts.app')

@push('customCss')
<style>
    /* Tab Navigation */
    .nav-tabs {
        border-bottom: 2px solid #e5e7eb;
        /*margin-bottom: 1.5rem;*/
        overflow-x: auto;
        white-space: nowrap;
        flex-wrap: nowrap;
        overflow-y: hidden;
    }

    .nav-tabs .nav-link {
        height: 40px;
        color: #1F2937;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
        background: #cccccc;
        margin-right: 0.25rem;
        border-radius: 0.5rem 0.5rem 0 0;
    }

    /*.nav-tabs .nav-link:hover {*/
    /*    color: #2a3441;*/
    /*    background: #f3f4f6;*/
    /*}*/

    .nav-tabs .nav-link.active {
        color: #fff;
        background: #1F2937;
        border-bottom: 3px solid #2a3441;
        font-weight: 600;
    }

    /* Method Badges */
    .method-badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 0.375rem;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .method-default {
        background: #6b7280;
        color: #fff;
    }

    /* Toggle Switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: 0.3s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #2a3441;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }

    /* Table styling */
    .menu-table {
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .menu-table thead th {
        font-weight: 600;
        font-size: 0.95rem;
        border: none;
    }

    .menu-table tbody tr {
        vertical-align: middle;
    }

    .text-center-cell {
        text-align: center;
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
                <li class="breadcrumb-item active" aria-current="page">{{ __('admin.permissions') }}</li>
            </ol>
        </nav>
    </div>

    <!-- Tugmalar guruhi -->
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
            type="button" data-bs-toggle="collapse"
            data-bs-target="#permissionContent" aria-expanded="true"
            aria-controls="permissionContent">
            <i class="fa-solid fa-list" style="font-size: 1.3rem;"></i>
        </button>
    </div>
</div>
@endsection

@section('content')
@php
$roles =[
'Admin' => 'Admin',
'Moliyaviy auditor' => 'Moliyaviy auditor',
'Moderator' => 'Moderator',
'Islom moliyasi nazorati' => 'Islom moliyasi nazorati',
];
@endphp

<div class="filter-card mb-3 mt-2 collapse show" id="permissionContent" style="transition: all 0.3s ease;">
    <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">

        <x-select-with-search
            name="roletFilter"
            label="Roleni tanlang"
            :datas="$roles"
            colMd="12"
            placeholder="Barchasi"
            :selected="request()->get('roletFilter', '')"
            icon="fa-check-circle" />
    </div>
</div>


{{-- Rol tanlash --}}
<!-- <div class="filter-card mb-3 mt-2 collapse show" id="permissionContent" style="transition: all 0.3s ease;">
        <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">

            <label for="roleSelect" class="fw-bold mb-2">{{__('admin.select_role')}}</label>
            <select id="roleSelect" class="form-control">
                <option value="">— {{__('admin.select_role')}} —</option>
                <option value="admin">Admin</option>
                <option value="finance">Moliyaviy auditor</option>
                <option value="moderator">Moderator</option>
                <option value="islamic_fin">Islom moliyasi nazorati</option>
            </select>
        </div>
    </div> -->

{{-- Tab Navigation --}}
<div class="border rounded p-2 mt-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">

    <ul class="nav nav-tabs" id="permissionTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="menus-tab" data-bs-toggle="tab" data-bs-target="#menus"
                type="button">
                Menyular
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="projects-tab" data-bs-toggle="tab" data-bs-target="#projects"
                type="button">
                Investitsiya loyihalari
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="revenues-tab" data-bs-toggle="tab" data-bs-target="#revenues"
                type="button">
                Tushumlar
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="incomes-tab" data-bs-toggle="tab" data-bs-target="#incomes" type="button">
                Daromadlar
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="expenses-tab" data-bs-toggle="tab" data-bs-target="#expenses"
                type="button">
                Xarajatlar
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="distributions-tab" data-bs-toggle="tab" data-bs-target="#distributions"
                type="button">
                Taqsimot
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contracts-tab" data-bs-toggle="tab" data-bs-target="#contracts"
                type="button">
                Investitsiya shartnomalar
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports" type="button">
                Hisobotlar
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="islamic-tab" data-bs-toggle="tab" data-bs-target="#islamic" type="button">
                Islom moliyasi
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings"
                type="button">
                Sozlamalar
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="administration-tab" data-bs-toggle="tab" data-bs-target="#administration"
                type="button">
                Ma'muriyat
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications"
                type="button">
                Bildirishnomalar
            </button>
        </li>
    </ul>

    {{-- Tab Content --}}
    <div class="tab-content" id="permissionTabsContent">

        {{-- MENYULAR TAB --}}
        <div class="tab-pane fade show active" id="menus" role="tabpanel">
            <table class="table user-table table-bordered table-hover table-striped align-items-center menu-table"
                style="border: 2px solid rgba(42,52,65,0.4);">
                <thead class="table-dark">
                    <tr>
                        <th>Nomi</th>
                        <th class="text-center-cell">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><i class="bi bi-speedometer2 me-2"></i>Dashboard</td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-building me-2"></i>Investitsiya loyihalari</td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-currency-dollar me-2"></i>Tushumlar</td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-wallet2 me-2"></i>Daromadlar</td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-cash-stack me-2"></i>Xarajatlar</td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-diagram-3 me-2"></i>Taqsimot</td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-file-earmark-text me-2"></i>Investitsiya shartnomalar</td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-bar-chart-line me-2"></i>Hisobotlar</td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-shield-check me-2"></i>Islom moliyasi</td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-gear me-2"></i>Sozlamalar</td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-grid-3x3-gap me-2"></i>Ma'muriyat</td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="bi bi-bell me-2"></i>Bildirishnomalar</td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- INVESTITSIYA LOYIHALARI TAB --}}
        <div class="tab-pane fade" id="projects" role="tabpanel">
            <table class="table user-table table-bordered table-hover table-striped align-items-center menu-table"
                style="border: 2px solid rgba(42,52,65,0.4);">
                <thead class="table-dark">
                    <tr>
                        <th>Nomi</th>
                        <th>Route</th>
                        <th>Method</th>
                        <th class="text-center-cell">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Loyihalar ro'yxati</td>
                        <td>admin.projects.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Loyiha yaratish</td>
                        <td>admin.projects.create</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Loyihani tahrirlash</td>
                        <td>admin.projects.edit</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Loyihani o'chirish</td>
                        <td>admin.projects.destroy</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Loyiha investorlar ro'yxati</td>
                        <td>admin.project-investors.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Loyiha investor yaratish</td>
                        <td>admin.project-investors.create</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Loyiha sotib olganlar</td>
                        <td>admin.project-buyers.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Ulushga kirish so'rovlari</td>
                        <td>admin.project-entry-requests.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Ulushdan chiqish so'rovlari</td>
                        <td>admin.project-exit-requests.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Korxona rekvizitlari</td>
                        <td>admin.company-details.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- TUSHUMLAR TAB --}}
        <div class="tab-pane fade" id="revenues" role="tabpanel">
            <table class="table user-table table-bordered table-hover table-striped align-items-center menu-table"
                style="border: 2px solid rgba(42,52,65,0.4);">
                <thead class="table-dark">
                    <tr>
                        <th>Nomi</th>
                        <th>Route</th>
                        <th>Method</th>
                        <th class="text-center-cell">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tushumlar ro'yxati</td>
                        <td>admin.revenues.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Tushum qo'shish</td>
                        <td>admin.revenues.create</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Tushumni tahrirlash</td>
                        <td>admin.revenues.edit</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Tushumni o'chirish</td>
                        <td>admin.revenues.destroy</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- DAROMADLAR TAB --}}
        <div class="tab-pane fade" id="incomes" role="tabpanel">
            <table class="table user-table table-bordered table-hover table-striped align-items-center menu-table"
                style="border: 2px solid rgba(42,52,65,0.4);">
                <thead class="table-dark">
                    <tr>
                        <th>Nomi</th>
                        <th>Route</th>
                        <th>Method</th>
                        <th class="text-center-cell">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Daromadlar ro'yxati</td>
                        <td>admin.incomes.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Daromad qo'shish</td>
                        <td>admin.incomes.create</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Daromadni tahrirlash</td>
                        <td>admin.incomes.edit</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Daromadni o'chirish</td>
                        <td>admin.incomes.destroy</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- XARAJATLAR TAB --}}
        <div class="tab-pane fade" id="expenses" role="tabpanel">
            <table class="table user-table table-bordered table-hover table-striped align-items-center menu-table"
                style="border: 2px solid rgba(42,52,65,0.4);">
                <thead class="table-dark">
                    <tr>
                        <th>Nomi</th>
                        <th>Route</th>
                        <th>Method</th>
                        <th class="text-center-cell">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Xarajatlar ro'yxati</td>
                        <td>admin.expenses.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Xarajat qo'shish</td>
                        <td>admin.expenses.create</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Xarajatni tahrirlash</td>
                        <td>admin.expenses.edit</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Xarajatni o'chirish</td>
                        <td>admin.expenses.destroy</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- TAQSIMOT TAB --}}
        <div class="tab-pane fade" id="distributions" role="tabpanel">
            <table class="table user-table table-bordered table-hover table-striped align-items-center menu-table"
                style="border: 2px solid rgba(42,52,65,0.4);">
                <thead class="table-dark">
                    <tr>
                        <th>Nomi</th>
                        <th>Route</th>
                        <th>Method</th>
                        <th class="text-center-cell">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Taqsimotlar ro'yxati</td>
                        <td>admin.distributions.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Taqsimot yaratish</td>
                        <td>admin.distributions.create</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Taqsimotni tahrirlash</td>
                        <td>admin.distributions.edit</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Taqsimotni o'chirish</td>
                        <td>admin.distributions.destroy</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- INVESTITSIYA SHARTNOMALAR TAB --}}
        <div class="tab-pane fade" id="contracts" role="tabpanel">
            <table class="table user-table table-bordered table-hover table-striped align-items-center menu-table"
                style="border: 2px solid rgba(42,52,65,0.4);">
                <thead class="table-dark">
                    <tr>
                        <th>Nomi</th>
                        <th>Route</th>
                        <th>Method</th>
                        <th class="text-center-cell">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Shartnomalar ro'yxati</td>
                        <td>admin.investment-contracts.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Shartnoma yaratish</td>
                        <td>admin.investment-contracts.create</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Shartnomani tahrirlash</td>
                        <td>admin.investment-contracts.edit</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Shartnomani o'chirish</td>
                        <td>admin.investment-contracts.destroy</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- HISOBOTLAR TAB --}}
        <div class="tab-pane fade" id="reports" role="tabpanel">
            <table class="table user-table table-bordered table-hover table-striped align-items-center menu-table"
                style="border: 2px solid rgba(42,52,65,0.4);">
                <thead class="table-dark">
                    <tr>
                        <th>Nomi</th>
                        <th>Route</th>
                        <th>Method</th>
                        <th class="text-center-cell">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Hisobotlar ro'yxati</td>
                        <td>admin.reports.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Hisobot yaratish</td>
                        <td>admin.reports.create</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Hisobotni tahrirlash</td>
                        <td>admin.reports.edit</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Hisobotni o'chirish</td>
                        <td>admin.reports.destroy</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- ISLOM MOLIYASI TAB --}}
        <div class="tab-pane fade" id="islamic" role="tabpanel">
            <table class="table user-table table-bordered table-hover table-striped align-items-center menu-table"
                style="border: 2px solid rgba(42,52,65,0.4);">
                <thead class="table-dark">
                    <tr>
                        <th>Nomi</th>
                        <th>Route</th>
                        <th>Method</th>
                        <th class="text-center-cell">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Islom moliyasi ro'yxati</td>
                        <td>admin.islamic-finance.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Nazorat qo'shish</td>
                        <td>admin.islamic-finance.create</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Nazoratni tahrirlash</td>
                        <td>admin.islamic-finance.edit</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Nazoratni o'chirish</td>
                        <td>admin.islamic-finance.destroy</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- SOZLAMALAR TAB --}}
        <div class="tab-pane fade" id="settings" role="tabpanel">
            <table class="table user-table table-bordered table-hover table-striped align-items-center menu-table"
                style="border: 2px solid rgba(42,52,65,0.4);">
                <thead class="table-dark">
                    <tr>
                        <th>Nomi</th>
                        <th>Route</th>
                        <th>Method</th>
                        <th class="text-center-cell">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ma'lumotnomalar</td>
                        <td>admin.references.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Umumiy sozlamalar</td>
                        <td>admin.general-settings.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Integratsiya sozlamalari</td>
                        <td>admin.integration-settings.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Foydalanuvchi interfeysi</td>
                        <td>admin.user-interface.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Til boshqaruvi</td>
                        <td>admin.user-interface.language-management.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Tizim tarjimalari</td>
                        <td>admin.user-interface.system-translations.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Shablon xabarlari</td>
                        <td>admin.user-interface.template-messages.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- MA'MURIYAT TAB --}}
        <div class="tab-pane fade" id="administration" role="tabpanel">
            <table class="table user-table table-bordered table-hover table-striped align-items-center menu-table"
                style="border: 2px solid rgba(42,52,65,0.4);">
                <thead class="table-dark">
                    <tr>
                        <th>Nomi</th>
                        <th>Route</th>
                        <th>Method</th>
                        <th class="text-center-cell">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Foydalanuvchilar ro'yxati</td>
                        <td>admin.users.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Foydalanuvchi yaratish</td>
                        <td>admin.users.create</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Foydalanuvchini tahrirlash</td>
                        <td>admin.users.edit</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Foydalanuvchini o'chirish</td>
                        <td>admin.users.destroy</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Investorlar ro'yxati</td>
                        <td>admin.investors.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Investor yaratish</td>
                        <td>admin.investors.create</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Rollar ro'yxati</td>
                        <td>admin.roles.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Rol yaratish</td>
                        <td>admin.roles.create</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Login tarixi</td>
                        <td>admin.login-histories.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Tizim loglar</td>
                        <td>admin.system-logs.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- BILDIRISHNOMALAR TAB --}}
        <div class="tab-pane fade" id="notifications" role="tabpanel">
            <table class="table user-table table-bordered table-hover table-striped align-items-center menu-table"
                style="border: 2px solid rgba(42,52,65,0.4);">
                <thead class="table-dark">
                    <tr>
                        <th>Nomi</th>
                        <th>Route</th>
                        <th>Method</th>
                        <th class="text-center-cell">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Bildirishnomalar ro'yxati</td>
                        <td>admin.notifications.index</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Bildirishnoma yaratish</td>
                        <td>admin.notifications.create</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Bildirishnomani tahrirlash</td>
                        <td>admin.notifications.edit</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Bildirishnomani o'chirish</td>
                        <td>admin.notifications.destroy</td>
                        <td><span class="method-badge method-default">default</span></td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Saqlash tugmasi --}}
{{-- <div class="text-end mt-4">--}}
{{-- <button class="btn btn-success px-4"><i class="fas fa-save me-2"></i>{{__('admin.save')}}</button>--}}
{{-- </div>--}}

@endsection

@push('customJs')
<script>
    // Rol tanlash funksiyasi
    document.getElementById('roleSelect').addEventListener('change', function() {
        const role = this.value;
        if (role) {
            console.log(`Tanlangan rol: ${role}`);
            alert(`"${role}" rolini tanladingiz. Ruxsatlarni sozlashingiz mumkin.`);
        }
    });

    // Tab switching handled by Bootstrap
    console.log('Rollar sahifasi yuklandi');
</script>
@endpush