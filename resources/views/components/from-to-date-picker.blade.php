@props([
'fromName' => 'dateRangePickerFrom',
'toName' => 'dateRangePickerTo',
'label' => 'Date Range',
'colMd' => '4',
])

@push('customCss')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

<div class="col-md-{{ $colMd }} col-sm-6 col-12">
    <label class="form-label">{{ $label }}</label>

    <div class="input-group">
        <span class="input-group-text fa-wrap">
            <i class="fa-solid fa-calendar-day text-muted"></i>
        </span>

        <input
            type="text"
            id="{{ $fromName }}"
            name="{{ $fromName }}"
            class="form-control"
            placeholder="dd.mm.yyyy"
            maxlength="10">

        <span class="input-group-text middle-text">to</span>

        <input
            type="text"
            id="{{ $toName }}"
            name="{{ $toName }}"
            class="form-control"
            placeholder="dd.mm.yyyy"
            maxlength="10">
    </div>
</div>

@push('customJs')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    // Flatpickr
    flatpickr("#{{ $fromName }}", {
        dateFormat: "d.m.Y",
        allowInput: true,
    });

    flatpickr("#{{ $toName }}", {
        dateFormat: "d.m.Y",
        allowInput: true,
    });

    // Input mask: dd.mm.yyyy
    function dateMask(input) {
        input.addEventListener('input', function() {
            let v = input.value.replace(/\D/g, '').slice(0, 8); // faqat raqam, max 8
            let r = '';

            if (v.length >= 1) r = v.substring(0, 2);
            if (v.length >= 3) r += '.' + v.substring(2, 4);
            if (v.length >= 5) r += '.' + v.substring(4, 8);

            input.value = r;
        });
    }

    dateMask(document.getElementById('{{ $fromName }}'));
    dateMask(document.getElementById('{{ $toName }}'));
</script>
@endpush