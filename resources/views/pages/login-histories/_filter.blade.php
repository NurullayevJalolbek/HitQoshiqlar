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
$results = [
    'Muvaffaqiyatli' => 'Muvaffaqiyatli',
    'Xato' => 'Xato',
];
@endphp

<div class="filter-card mb-3 mt-2 collapse show" id="loginHistoryFilterContent" style="transition: all 0.3s ease;">
    <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
        <div class="row g-3 align-items-end">

            {{-- Foydalanuvchi Ismi bo‘yicha qidirish --}}
            <div class="col-md-4 col-sm-6 col-12">
                <label for="filterName">F.I.O</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fa-solid fa-user text-muted"></i>
                    </span>
                    <input type="text" id="filterName" class="form-control" placeholder="Ism Familya...">
                </div>
            </div>

            {{-- Login bo‘yicha qidirish --}}
            <div class="col-md-4 col-sm-6 col-12">
                <label for="filterLogin">Login</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fa-solid fa-id-badge text-muted"></i>
                    </span>
                    <input type="text" id="filterLogin" class="form-control" placeholder="Login...">
                </div>
            </div>

              <x-select-with-search 
                name="resultFilter" 
                label="Natija boyicha" 
                :datas="$results"
                colMd="4"
                placeholder="Barchasi"
                :selected="request()->get('resultFilter', '')"
                icon="fa-check-circle"
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