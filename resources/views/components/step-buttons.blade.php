<div class="progress-indicator">
    <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">
        <i class="fas fa-arrow-left me-2"></i>{{ __('admin.Back')}}
    </button>

    <button type="button" class="btn btn-success" id="nextBtn" style="display: none;">
        {{ __('admin.next')}} <i class="fas fa-arrow-right ms-2"></i>
    </button>

    <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">
        <i class="fas fa-check me-2"></i>{{ $submitText ?? __('admin.send') }}
    </button>
</div>
