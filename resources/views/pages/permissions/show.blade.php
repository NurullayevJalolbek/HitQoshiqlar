@extends('layouts.app')

@push('customCss')
<style>
    /* Tab Navigation */
    .nav-tabs {
        border-bottom: 2px solid #e5e7eb;
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
        background: #ebeaeaff;
        margin-right: 0.25rem;
        border-radius: 0.5rem 0.5rem 0 0;
    }

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

    .method-get {
        background: #059669;
        color: #fff;
    }

    .method-post {
        background: #2563eb;
        color: #fff;
    }

    .method-put {
        background: #f59e0b;
        color: #fff;
    }

    .method-delete {
        background: #dc2626;
        color: #fff;
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
$roles = [
'Admin' => 'Admin',
'Moliyaviy auditor' => 'Moliyaviy auditor',
'Moderator' => 'Moderator',
'Islom moliyasi nazorati' => 'Islom moliyasi nazorati',
];

$datas = getAllPermissionsData();

// Tab nomlari va ularning ma'lumot kalitlari
$tabs = [
'menus' => 'Menyular',
'dashboard' => 'Dashboard',
'projects' => 'Loyihalar',
'project_investors' => 'Investorlar',
'project_buyers' => 'Xaridorlar',
'project_entry_requests' => 'Kirish so\'rovlari',
'project_exit_requests' => 'Chiqish so\'rovlari',
'company_details' => 'Rekvizitlar',
'revenues' => 'Tushumlar',
'expenses' => 'Xarajatlar',
'distributions' => 'Taqsimot',
'contracts' => 'Shartnomalar',
'reports' => 'Hisobotlar',
'islamic' => 'Islom moliyasi',
'references' => 'Ma\'lumotnomalar',
'general_settings' => 'Umumiy sozlamalar',
'integration_settings' => 'Integratsiyalar',
'user_interface' => 'Interfeys',
'users' => 'Foydalanuvchilar',
'investors' => 'Investorlar (Ma\'muriyat)',
'roles' => 'Rollar',
'login_histories' => 'Kirish tarixi',
'system_logs' => 'Tizim loglari',
'notifications' => 'Bildirishnomalar'
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
            :selectSearch=false
            icon="fa-check-circle" />
    </div>
</div>

<div class="border rounded p-2 mt-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs" id="permissionTabs" role="tablist">
        @php $isFirst = true; @endphp
        @foreach($tabs as $key => $name)
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $isFirst ? 'active' : '' }}"
                id="{{ $key }}-tab"
                data-bs-toggle="tab"
                data-bs-target="#{{ $key }}"
                type="button">
                {{ $name }}
            </button>
        </li>
        @php $isFirst = false; @endphp
        @endforeach
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="permissionTabsContent">
        @php $isFirst = true; @endphp
        @foreach($tabs as $key => $name)
        <div class="tab-pane fade {{ $isFirst ? 'show active' : '' }}"
            id="{{ $key }}"
            role="tabpanel"
            aria-labelledby="{{ $key }}-tab">

            @if(isset($datas[$key]))
            @php $items = $datas[$key]; @endphp

            @if($key === 'menus')
            <!-- Menyular uchun maxsus jadval (faqat nom va checkbox) -->
            <table class="table user-table table-bordered table-hover table-striped align-items-center menu-table"
                style="border: 2px solid rgba(42,52,65,0.4);">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" width="5%">№</th>
                        <th>Nomi</th>
                        <th class="text-center-cell">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td class="text-center">{{ $item['id'] }}</td>
                        <td>
                            @if(isset($item['icon']))
                            <i class="bi bi-{{ $item['icon'] }} me-2"></i>
                            @endif
                            {{ $item['name'] }}
                        </td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox"
                                    name="permissions[{{ $key }}][{{ $item['id'] }}]"
                                    value="1"
                                    {{ $item['checked'] ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <!-- Boshqa tablar uchun to'liq jadval -->
            <table class="table user-table table-bordered table-hover table-striped align-items-center menu-table"
                style="border: 2px solid rgba(42,52,65,0.4);">
                <thead class="table-dark">
                    <tr>
                        <th  class="text-center" width="5%">№</th>
                        <th class="text-center">Nomi</th>
                        <th class="text-center">Route</th>
                        <th class="text-center">Method</th>
                        <th class="text-center-cell">Amallar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td class="text-center">{{ $item['id'] }}</td>
                        <td class="text-center">{{ $item['name'] }}</td>
                        <td class="text-center">
                            @if(isset($item['route']))
                            <code>{{ $item['route'] }}</code>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if(isset($item['method']))
                            @php
                            $method = strtolower($item['method']);
                            $methodClasses = [
                            'get' => 'method-get',
                            'post' => 'method-post',
                            'put' => 'method-put',
                            'delete' => 'method-delete',
                            'default' => 'method-default'
                            ];
                            $methodClass = $methodClasses[$method] ?? 'method-default';
                            @endphp
                            <span class="method-badge {{ $methodClass }}">
                                {{ $item['method'] }}
                            </span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center-cell">
                            <label class="switch">
                                <input type="checkbox"
                                    name="permissions[{{ $key }}][{{ $item['id'] }}]"
                                    value="1"
                                    {{ $item['checked'] ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            @else
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle me-2"></i>
                Bu bo'lim uchun ma'lumot topilmadi.
            </div>
            @endif

        </div>
        @php $isFirst = false; @endphp
        @endforeach
    </div>
</div>

<!-- Saqlash tugmasi -->
<div class="text-end mt-4">
    <button type="button" class="btn btn-success px-4" id="savePermissions">
        <i class="fas fa-save me-2"></i>{{__('admin.save')}}
    </button>
</div>

@endsection

@push('customJs')
<script>
    // Saqlash funksiyasi
    document.getElementById('savePermissions').addEventListener('click', function() {
        // Checkboxlarni yig'ish
        const permissions = {};
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const name = checkbox.name;
                if (!permissions[name]) {
                    permissions[name] = [];
                }
                permissions[name].push(checkbox.value);
            }
        });

        // Bu yerda serverga yuborish logikasi qo'shiladi
        console.log('Tanlangan ruxsatlar:', permissions);

        // Misol uchun alert
        alert('Ruxsatlar saqlandi! (Serverga yuborish logikasi qo\'shilishi kerak)');
    });

    // Rol tanlash funksiyasi
    document.querySelector('select[name="roletFilter"]').addEventListener('change', function() {
        const role = this.value;
        if (role) {
            console.log(`Tanlangan rol: ${role}`);
            // Bu yerda rolga mos ruxsatlarni yuklash logikasi qo'shiladi
            alert(`"${role}" rolini tanladingiz. Ruxsatlarni sozlashingiz mumkin.`);
        }
    });

    // Tab switching animation
    const tabLinks = document.querySelectorAll('.nav-link');
    tabLinks.forEach(link => {
        link.addEventListener('click', function() {
            tabLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
@endpush