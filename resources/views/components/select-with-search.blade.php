@props([
'name' => '',
'label' => 'Select state',
'colMd' => '4',
'selected' => null,
'datas' => [],
'placeholder' => 'Qiymatni tanlang',
'icon' => "fa-toggle-on",
])

@push('customCss')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* === Select2 asosiy ko‘rinishi === */
    .select2-container .select2-selection--single {
        height: 40px !important;
        border: 1px solid #ced4da !important;
        border-radius: 8px !important;
        display: flex !important;
        align-items: center;
        padding-right: 36px;
        position: relative;
    }

    /* Tanlangan element matni */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding-left: 12px !important;
        line-height: normal !important;
        color: #495057;
        font-size: 14px;
    }

    /* Clear (x) tugmasi */
    .select2-container--default .select2-selection--single .select2-selection__clear {
        position: absolute;
        right: 26px;
        top: 50%;
        transform: translateY(-50%);
        z-index: 2;
        color: #999;
        font-size: 16px;
        cursor: pointer;
    }

    /* Arrow pozitsiyasi */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        pointer-events: none;
    }

    /* Highlight qilingan option */
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #1F2937 !important;
        color: #fff !important;
    }

    /* === 📌 ICON bilan input-group uchun maxsus qo‘shimcha CSS === */

    /* Select2 input-group ichida width 100% bo‘lsin */
    .select2-icon-group .select2-container {
        flex: 1 1 auto !important;
        width: 1% !important;
    }

    /* Icon qo‘yilganda selectning chap chegarasi yo‘qolsin */
    .select2-with-icon~.select2-container .select2-selection--single {
        border-left: none !important;
        border-radius: 0px 8px 8px 0px !important;
    }

    /* Rendered text shift bo‘lmasligi uchun */
    .select2-selection__rendered {
        padding-left: 10px !important;
    }

    /* Arrow markazda */
    .select2-selection__arrow {
        top: 50% !important;
        transform: translateY(-50%) !important;
    }

    /* Mobil uchun full width */
    @media (max-width: 768px) {
        .select2-container {
            width: 100% !important;
        }
    }
</style>
@endpush


<div class="col-12 col-md-{{ $colMd }} col-lg-{{ $colMd }}">
    <div class="form-group">
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>

        <div class="input-group select2-icon-group">
            <span class="input-group-text bg-white">
                <i class="fa-solid {{ $icon }} text-muted"></i>
            </span>

            <select name="{{ $name }}" id="{{ $name }}" data-allow-clear="true" autocomplete="off"
                class="form-control select2-with-icon">
                <option value="">{{ $placeholder }}</option>
                @foreach($datas as $code => $data)
                <option value="{{ $code }}" {{ $selected == $code ? 'selected' : '' }}>
                    {{ $data }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
</div>


@push('customJs')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select2 ni ishga tushirish
        const selectEl = document.querySelector('#{{ $name }}');
        if (selectEl) {
            $(selectEl).select2({
                placeholder: "{{ $placeholder }}",
                allowClear: true,
                width: '100%'
            });
        }

        // Qidiruv va select uchun tugmalarni holatini yangilash
        const searchInput = document.querySelector('#form-control-search');
        const searchButton = document.querySelector('#search-button');
        const cleanButton = document.querySelector('#clean-button');

        function updateButtonsState() {
            const hasSearch = searchInput?.value.trim().length > 0;
            const hasSelect = selectEl?.value;
            if (searchButton && cleanButton) {
                if (hasSearch || hasSelect) {
                    searchButton.classList.remove('disabled');
                    cleanButton.classList.remove('disabled');
                } else {
                    searchButton.classList.add('disabled');
                    cleanButton.classList.add('disabled');
                }
            }
        }

        if (searchInput) searchInput.addEventListener('input', updateButtonsState);
        if (selectEl) $(selectEl).on('change', updateButtonsState);

        updateButtonsState();

        // Back/forward browser holatida select va inputni tozalash
        window.addEventListener('pageshow', function(event) {
            const isBack = event.persisted || performance.getEntriesByType("navigation")[0]?.type === "back_forward";
            if (isBack) {
                if (searchInput) searchInput.value = '';
                if (selectEl) {
                    $(selectEl).val(null).trigger('change');
                }
                updateButtonsState();
            }
        });
    });
</script>
@endpush