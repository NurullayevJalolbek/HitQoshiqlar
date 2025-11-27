<!-- File: resources/views/pages/dashboard/partials/filters.blade.php -->
<!-- Filtrlash Bo'limi -->
<div class="filter-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 fw-bold">
            <i class="fas fa-filter me-2 text-primary"></i>{{ __('dashboard.filters.title') }}
        </h6>
        <button class="btn btn-sm btn-outline-secondary px-2 py-1" onclick="toggleFilters()" style="min-width: 32px;">
            <i class="fas fa-chevron-down" id="filterToggleIcon"></i>
        </button>
    </div>

    <div id="filterContent" style="display: block;">
        <div class="filter-card">
            <div class="row g-3 align-items-end">
                <!-- Boshlanish sanasi -->
                <div class="col-md-2">
                    <label for="startDate">{{ __('dashboard.filters.start_date') }}</label>
                    <input type="date" 
                           class="form-control" 
                           id="startDate" 
                           value="{{ date('Y-m-01') }}">
                </div>

                <!-- Tugash sanasi -->
                <div class="col-md-2">
                    <label for="endDate">{{ __('dashboard.filters.end_date') }}</label>
                    <input type="date" 
                           class="form-control" 
                           id="endDate" 
                           value="{{ date('Y-m-d') }}">
                </div>

                <!-- Loyiha turi -->
                <div class="col-md-2">
                    <label for="projectType">{{ __('dashboard.filters.project_type') }}</label>
                    <select id="projectType" class="form-select">
                        <option value="">{{ __('dashboard.filters.all') }}</option>
                        <option value="land">{{ __('dashboard.project_types.land') }}</option>
                        <option value="rent">{{ __('dashboard.project_types.rent') }}</option>
                        <option value="construction">{{ __('dashboard.project_types.construction') }}</option>
                    </select>
                </div>

                <!-- Investor turi -->
                <div class="col-md-2">
                    <label for="investorType">{{ __('dashboard.filters.investor_type') }}</label>
                    <select id="investorType" class="form-select">
                        <option value="">{{ __('dashboard.filters.all') }}</option>
                        <option value="active">{{ __('dashboard.investor_types.active') }}</option>
                        <option value="passive">{{ __('dashboard.investor_types.passive') }}</option>
                    </select>
                </div>

                <!-- Tugmalar -->
                <div class="col-md-4 d-flex gap-2">
                    <button id="filterBtn" class="btn btn-primary w-50" onclick="applyFilters()">
                        <i class="fas fa-filter"></i> {{ __('dashboard.filters.apply') }}
                    </button>
                    <button id="clearBtn" class="btn btn-warning w-50" onclick="resetFilters()">
                        {{ __('dashboard.filters.reset') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Faol filterlar ko'rsatish -->
        <div id="activeFilters" class="mt-3" style="display: none;">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <small class="text-muted me-2">Faol filterlar:</small>
                <div id="activeFiltersList" class="d-flex flex-wrap gap-2"></div>
            </div>
        </div>
    </div>
</div>

<script>
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

    function resetFilters() {
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
        document.getElementById('projectType').value = '';
        document.getElementById('investorType').value = '';
        
        document.getElementById('activeFilters').style.display = 'none';
        
        if (typeof window.applyFilters === 'function') {
            window.applyFilters();
        }
    }

    const originalApplyFilters = window.applyFilters;
    window.applyFilters = function() {
        if (originalApplyFilters) {
            originalApplyFilters();
        }
        showActiveFilters();
    };
</script>