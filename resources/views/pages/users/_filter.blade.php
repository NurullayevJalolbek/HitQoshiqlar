@push('customCss')
<style>
    .input-group-text {
        border-right: none;
    }

    .input-group .form-control,
    .input-group .form-select {
        border-left: none;
    }
</style>
@endpush

@php
$roles = [
    'Admin' => 'Admin',
    'Moliyaviy auditor' => 'Moliyaviy auditor',
    'Moderator' => 'Moderator',
    'Islom moliyasi nazorati' => 'Islom moliyasi nazorati',
];

$statuses = [
    'Faol' => 'Faol',
    'Kutilmoqda' => 'Kutilmoqda',
    'Bloklangan' => 'Bloklangan',
];
@endphp

<div class="filter-card mb-3 mt-2 collapse show" id="userFilterContent" style="transition: all 0.3s ease;">
    <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
        <div class="row g-3 align-items-end">

            <!-- F.I.O -->
            <div class="col-md-3 col-sm-6 col-12">
                <label for="fioInput">F.I.O</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fa-solid fa-user text-muted"></i>
                    </span>
                    <input type="text" id="fioInput" class="form-control" placeholder="F.I.O">
                </div>
            </div>

            <!-- Login -->
            <div class="col-md-3 col-sm-6 col-12">
                <label for="loginInput">Login</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fa-solid fa-image-portrait text-muted"></i>
                    </span>
                    <input type="text" id="loginInput" class="form-control" placeholder="Login">
                </div>
            </div>

            <!-- Email -->
            <div class="col-md-3 col-sm-6 col-12">
                <label for="emailInput">Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fa-solid fa-envelope text-muted"></i>
                    </span>
                    <input type="email" id="emailInput" class="form-control" placeholder="Email">
                </div>
            </div>

            <!-- Telefon -->
            <div class="col-md-3 col-sm-6 col-12">
                <label for="phoneFilter">Telefon</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fa-solid fa-phone text-muted"></i>
                    </span>
                    <input type="text" id="phoneFilter" class="form-control" placeholder="+998 ...">
                </div>
            </div>

             <x-select-with-search 
                name="roleFilter" 
                label="Role boyicha" 
                :datas="$roles"
                colMd="3"
                placeholder="Barchasi"
                :selected="request()->get('roleFilter', '')"
            />

             <x-select-with-search 
                name="statusFilter" 
                label="Holati boyicha" 
                :datas="$statuses"
                colMd="3"
                placeholder="Barchasi"
                :selected="request()->get('statusFilter', '')"
            />



            <!-- Holat bo‘yicha filter -->
            <!-- <div class="col-md-3 col-sm-6 col-12">
                <label for="statusFilter">{{__('admin.by_status')}}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fa-solid fa-toggle-on text-muted"></i>
                    </span>
                    <select id="statusFilter" class="form-select">
                        <option value="">{{__('admin.all')}}</option>
                        <option value="Faol">Faol</option>
                        <option value="Kutilmoqda">Kutilmoqda</option>
                        <option value="Bloklangan">Bloklangan</option>
                    </select>
                </div>
            </div> -->

            <x-from-to-date-picker
                colMd="4"
                fromName="userFilterFromDate"
                toName="userFilterToDate"
                label="Tanlangan Sana Oralig'i" />

            <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />
        </div>
    </div>
</div>