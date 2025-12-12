@props([
'fromName' => 'dateRangePickerFrom',
'toName' => 'dateRangePickerTo',
'label' => 'Date Range',
'colMd' => '4',
])

<div class="col-md-{{ $colMd }} col-sm-6 col-12">
    <label class="form-label">{{ $label }}</label>

    <div class="input-group">
        {{-- Only FIRST input has icon --}}
        <span class="input-group-text fa-wrap">
            <i class="fa-solid fa-calendar-day text-muted"></i> </span>
        <input type="date" id="{{ $fromName }}" name="{{ $fromName }}" class="form-control">

        <span class="input-group-text middle-text">to</span>

        <input type="date" id="{{ $toName }}" name="{{ $toName }}" class="form-control">
    </div>
</div>