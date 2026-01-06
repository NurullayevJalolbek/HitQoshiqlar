@php
    $directions = [
        'yer' => __('yer'),
        'qurilish' => __('qurilish'),
        'ijara' => __('ijara'),
    ];

    $activityTypes = [
        'MChJ' => __('mchj'),
        'AJ' => __('aj'),
        'YaTT' => __('yatt'),
    ];
@endphp

<div class="filter-card mb-3 mt-2 collapse show" id="projectBuyerFilterContent" style="transition: all 0.3s ease;">
    <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
        <div class="row g-3 align-items-end">

            <!-- Qidiruv -->
            <div class="col-md-3">
                <label for="searchInput" class="form-label">{{ __('Qidiruv') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input
                        type="text"
                        id="searchInput"
                        class="form-control"
                        placeholder="{{ __('korxona_nomi') }}, {{ __('direktor_fio') }}, {{ __('inn') }}..."
                    >
                </div>
            </div>

            <x-select-with-search
                name="filter_direction"
                label="Yo'nalish"
                :datas="$directions"
                colMd="3"
                placeholder="{{ __('barchasi') }}"
                :selected="request()->get('filter_direction', '')"
                :selectSearch="false"
                icon="fa-layer-group text-primary"
            />

            <x-select-with-search
                name="filter_activity"
                label="{{ __('Faoliyat turi') }}"
                :datas="$activityTypes"
                colMd="3"
                placeholder="{{ __('barchasi') }}"
                :selected="request()->get('filter_activity', '')"
                :selectSearch="false"
            />

            <!-- Filter tugmalari -->
            <x-filter-buttons />
        </div>
    </div>
</div>
