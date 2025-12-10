@props([
'name' => '',
'label' => 'Select state',
'colMd' => 4,
'selected' => null,
'datas' => [],
'placeholder' => 'Qiymatni tanlang'
])

@push('customCss')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* === Select2: Umumiy shakl === */
    .select2-container .select2-selection--single {
        height: 40px !important;
        border: 1px solid #ced4da !important;
        border-radius: 8px !important;
        display: flex !important;
        align-items: center;
        padding-right: 36px;
        /* o‘ng tarafda ikonalar uchun joy */
        position: relative;
    }

    /* Tanlangan element (matn) */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding-left: 12px !important;
        line-height: normal !important;
        color: #495057;
        font-size: 14px;
    }

    /* "x" (clear) tugmasi */
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

    /* "Arrow" (pastga qaragan belgi) */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        pointer-events: none;
    }

    /* Natijalarni tanlashda qora fonda oq yozuv */
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #1F2937 !important;
        color: #fff !important;
    }

    /* Mobil uchun to‘liq width */
    @media (max-width: 768px) {
        .select2-container {
            width: 100% !important;
        }
    }
</style>
@endpush

<div class="col-12 col-md-{{ $colMd }} col-lg-4">
    <div class="form-group">
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
        <select name="{{ $name }}" id="{{ $name }}" data-allow-clear="true" autocomplete="off"
            class="form-control select2">
            <option value="">{{ $placeholder }}</option>
            @foreach($datas as $code => $data)
            <option value="{{ $code }}" {{ $selected == $code ? 'selected' : '' }}>
                {{ $data }}
            </option>
            @endforeach
        </select>
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