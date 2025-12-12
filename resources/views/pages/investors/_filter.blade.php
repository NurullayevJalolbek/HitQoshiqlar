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
$statuses =[
    'Faol' => 'Faol',
    'Kutilmoqda' => 'Kutilmoqda',
    'Bloklangan' => 'Bloklangan',
];

@endphp

<div class="filter-card mb-3 mt-2 collapse show" id="investorFilterContent" style="transition: all 0.3s ease;">
    <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
        <div class="row g-3 align-items-end">

            <!-- F.I.O -->
            <div class="col-md-4 col-sm-12">
                <label for="nameInput" class="form-label">F.I.O</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fa-solid fa-user text-muted"></i></span>
                    <input type="text" id="nameInput" class="form-control" placeholder="F.I.O">
                </div>
            </div>

            <!-- Login -->
            <div class="col-md-4 col-sm-12">
                <label for="loginInput" class="form-label">Login</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fa-solid fa-image-portrait text-muted"></i></span>
                    <input type="text" id="loginInput" class="form-control" placeholder="Login">
                </div>
            </div>

            <!-- Telefon -->
            <div class="col-md-4 col-sm-12">
                <label for="phoneInput" class="form-label">Telefon</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fa-solid fa-phone text-muted"></i></span>
                    <input type="text" id="phoneInput" class="form-control" placeholder="+998 ...">
                </div>
            </div>

            <!-- Pasport -->
            <div class="col-md-4 col-sm-12">
                <label for="passportInput" class="form-label">Pasport</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fa-solid fa-id-card text-muted"></i></span>
                    <input type="text" id="passportInput" class="form-control" placeholder="Pasport seriya/raqam">
                </div>
            </div>

            <!-- JSHIR -->
            <div class="col-md-4 col-sm-12">
                <label for="innInput" class="form-label">JSHIR</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fa-solid fa-fingerprint text-muted"></i></span>
                    <input type="text" id="innInput" class="form-control" placeholder="JSHIR">
                </div>
            </div>

            <x-select-with-search 
                name="statusFilter" 
                label="Holati boyicha" 
                :datas="$statuses"
                colMd="4"
                placeholder="Barchasi"
                :selected="request()->get('statusFilter', '')"
            />


         <x-from-to-date-picker
                colMd="8"
                fromName="userFilterFromDate"
                toName="userFilterToDate"
                label="Tanlangan Sana Oralig'i" />

            
            <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />


        </div>
    </div>
</div>