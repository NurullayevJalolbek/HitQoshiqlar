<!-- Filtrlash Bo'limi - Yaxshilangan Versiya -->
<div class="filter-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 fw-bold">
            <i class="fas fa-filter me-2 text-primary"></i>{{ __('dashboard.filters.title') }}
        </h6>
        <button class="btn btn-sm btn-outline-secondary" onclick="toggleFilters()">
            <i class="fas fa-chevron-down" id="filterToggleIcon"></i>
        </button>
    </div>
    
    <div id="filterContent" style="display: block;">
        <div class="row align-items-end g-3">
            <!-- Boshlanish sanasi -->
            <div class="col-lg-2 col-md-4 col-sm-6">
                <label class="form-label small text-muted mb-1">
                    <i class="fas fa-calendar-alt me-1"></i>
                    {{ __('dashboard.filters.start_date') }}
                </label>
                <input type="date" 
                       class="form-control form-control-sm" 
                       id="startDate" 
                       value="{{ date('Y-m-01') }}">
            </div>

            <!-- Tugash sanasi -->
            <div class="col-lg-2 col-md-4 col-sm-6">
                <label class="form-label small text-muted mb-1">
                    <i class="fas fa-calendar-check me-1"></i>
                    {{ __('dashboard.filters.end_date') }}
                </label>
                <input type="date" 
                       class="form-control form-control-sm" 
                       id="endDate" 
                       value="{{ date('Y-m-d') }}">
            </div>

            <!-- Loyiha turi -->
            <div class="col-lg-2 col-md-4 col-sm-6">
                <label class="form-label small text-muted mb-1">
                    <i class="fas fa-briefcase me-1"></i>
                    {{ __('dashboard.filters.project_type') }}
                </label>
                <select class="form-select form-select-sm" id="projectType">
                    <option value="">{{ __('dashboard.filters.all') }}</option>
                    <option value="tech">{{ __('dashboard.project_types.tech') }}</option>
                    <option value="real_estate">{{ __('dashboard.project_types.real_estate') }}</option>
                    <option value="agriculture">{{ __('dashboard.project_types.agriculture') }}</option>
                    <option value="manufacturing">{{ __('dashboard.project_types.manufacturing') }}</option>
                </select>
            </div>

            <!-- Investor turi -->
            <div class="col-lg-2 col-md-4 col-sm-6">
                <label class="form-label small text-muted mb-1">
                    <i class="fas fa-user-tag me-1"></i>
                    {{ __('dashboard.filters.investor_type') }}
                </label>
                <select class="form-select form-select-sm" id="investorType">
                    <option value="">{{ __('dashboard.filters.all') }}</option>
                    <option value="active">{{ __('dashboard.investor_types.active') }}</option>
                    <option value="passive">{{ __('dashboard.investor_types.passive') }}</option>
                </select>
            </div>

            <!-- Qo'llash tugmasi -->
            <div class="col-lg-2 col-md-4 col-sm-6">
                <button class="btn btn-primary btn-sm w-100" onclick="applyFilters()">
                    <i class="fas fa-search me-1"></i> 
                    {{ __('dashboard.filters.apply') }}
                </button>
            </div>

            <!-- Tozalash tugmasi -->
            <div class="col-lg-2 col-md-4 col-sm-6">
                <button class="btn btn-outline-secondary btn-sm w-100" onclick="resetFilters()">
                    <i class="fas fa-redo me-1"></i> 
                    {{ __('dashboard.filters.reset') }}
                </button>
            </div>
        </div>

        <!-- Faol filterlar ko'rsatish -->
        <div id="activeFilters" class="mt-3" style="display: none;">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <small class="text-muted me-2">{{ __('dashboard.filters.active') }}:</small>
                <div id="activeFiltersList" class="d-flex flex-wrap gap-2"></div>
            </div>
        </div>
    </div>
</div>

<script>
// Filter toggle funksiyasi
function toggleFilters() {
    const content = document.getElementById('filterContent');
    const icon = document.getElementById('filterToggleIcon');
    
    if (content.style.display === 'none') {
        content.style.display = 'block';
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
    } else {
        content.style.display = 'none';
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
    }
}

// Faol filterlarni ko'rsatish
function showActiveFilters() {
    const activeFiltersDiv = document.getElementById('activeFilters');
    const activeFiltersList = document.getElementById('activeFiltersList');
    const filters = [];
    
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const projectType = document.getElementById('projectType');
    const investorType = document.getElementById('investorType');
    
    if (startDate || endDate) {
        filters.push(`<span class="badge bg-primary">${startDate} - ${endDate}</span>`);
    }
    
    if (projectType.value) {
        const text = projectType.options[projectType.selectedIndex].text;
        filters.push(`<span class="badge bg-info">${text}</span>`);
    }
    
    if (investorType && investorType.value) {
        const text = investorType.options[investorType.selectedIndex].text;
        filters.push(`<span class="badge bg-success">${text}</span>`);
    }
    
    if (filters.length > 0) {
        activeFiltersList.innerHTML = filters.join('');
        activeFiltersDiv.style.display = 'block';
    } else {
        activeFiltersDiv.style.display = 'none';
    }
}

// applyFilters funksiyasini yangilash
const originalApplyFilters = window.applyFilters;
window.applyFilters = function() {
    if (originalApplyFilters) {
        originalApplyFilters();
    }
    showActiveFilters();
};
</script>