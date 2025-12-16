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

<div class="filter-card mb-3 mt-2 collapse show" id="systemTranslationFilterContent" style="transition: all 0.3s ease;">
    <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
        <div class="row g-3 align-items-end">

            <div class="col-md-10 col-sm-6 col-12">
                <label for="fioInput">Kalit so'zi</label>
                <div class="input-group">
                    <!-- Lupa ikonka -->
                    <span class="input-group-text bg-white">
                        <i class="fa-solid fa-magnifying-glass text-muted"></i>
                    </span>
                    <input type="text" id="fioInput" class="form-control" placeholder="Kalit so'zi ..." name="key"
                        value="">
                </div>
            </div>



            <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />
        </div>
    </div>
</div>