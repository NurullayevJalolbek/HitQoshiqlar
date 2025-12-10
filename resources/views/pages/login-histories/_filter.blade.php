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

            {{-- Natija bo‘yicha filter --}}
            <div class="col-md-4 col-sm-6 col-12">
                <label for="filterResult">{{ __('admin.result_type') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fa-solid fa-check-circle text-muted"></i>
                    </span>
                    <select id="filterResult" class="form-select">
                        <option value="">{{ __('admin.all') }}</option>
                        <option value="Muvaffaqiyatli">Muvaffaqiyatli</option>
                        <option value="Xato">Xato</option>
                    </select>
                </div>
            </div>

          <x-from-to-date-picker
                colMd="8"
                fromName="userFilterFromDate"
                toName="userFilterToDate"
                label="Tanlangan Sana Oralig'i" />
            <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />
        </div>
    </div>
</div>