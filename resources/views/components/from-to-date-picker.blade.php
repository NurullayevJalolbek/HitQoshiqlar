@props([
    'fromName' => 'dateRangePickerFrom',
    'toName' => 'dateRangePickerTo',
    'label' => 'Date Range'
])

<div class="col-md-4 col-4 mb-4">
    <label class="form-label">{{ $label }}</label>
    <div class="input-group">
        <input type="date" id="{{ $fromName }}" class="form-control">
        <span class="input-group-text">to</span>
        <input type="date" id="{{ $toName }}" class="form-control">
    </div>
</div>
