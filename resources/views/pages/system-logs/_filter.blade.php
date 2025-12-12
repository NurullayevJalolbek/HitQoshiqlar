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
$modules =[
'Loyihalar'=>'Loyihalar',
'Investorlar'=>'Investorlar',
"Ma'muriyat bo'limi"=>"Ma'muriyat bo'limi",
'Hisobotlar'=>'Hisobotlar',
'Foydalanuvchilar'=>'Foydalanuvchilar',];


$logTypes = [
'CREATE'=>'Create',
'UPDATE'=>'Update',
'DELETE'=>'Delete',
'EXPORT'=>'Export',
];

$logStatuses = [
'Muvaffaqiyatli'=>'Muvaffaqiyatli',
'Ogohlantirish'=>'Ogohlantirish',
'Xato'=>'Xato',
];
@endphp

<div class="filter-card mb-3 mt-2 collapse show" id="systemHistoryFilterContent" style="transition: all 0.3s ease;">
    <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
        <div class="row g-3 align-items-end">

            <!-- F.I.O -->
            <div class="col-md-4 col-sm-4 col-12">
                <label for="fioInput">F.I.O</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-user text-muted"></i>
                    </span>
                    <input type="text" id="fioInput" class="form-control" placeholder="F.I.O">
                </div>
            </div>

               <x-select-with-search 
                name="log_status" 
                label="Log holati boyicha" 
                :datas="$logStatuses"
                colMd="4"
                placeholder="Barchasi"
                :selected="request()->get('log_status', '')"
                icon="fa-exclamation-circle"
            />



             <x-select-with-search 
                name="log_type" 
                label="Log turi boyicha" 
                :datas="$logTypes"
                colMd="4"
                placeholder="Barchasi"
                :selected="request()->get('log_type', '')"
                icon="fa-layer-group"
            />

              <x-select-with-search 
                name="statusModuleFilter" 
                label="Module boyicha" 
                :datas="$modules"
                colMd="4"
                placeholder="Barchasi"
                :selected="request()->get('status_module', '')"
                icon="fa-boxes"
            />

             <x-from-to-date-picker
                colMd="6"
                fromName="userFilterFromDate"
                toName="userFilterToDate"
                label="Tanlangan Sana Oralig'i" />

            <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />

        </div>
    </div>
</div>