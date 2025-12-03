<!-- KPI Kartalar -->
<div class="row g-4 mb-4">
    <!-- Jami Investorlar -->
    <div class="col-xl-3 col-md-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2 small">{{ __('admin.kpi.total_investors') }}</p>
                        <h3 class="mb-0 fw-bold" id="totalInvestors">{{ formatCurrency(1284) }}</h3>
                        <span class="trend-badge bg-success-subtle text-success mt-2">
                            <i class="fas fa-arrow-up"></i> <span id="investorsTrend">12.5%</span>
                        </span>
                        <small class="text-muted d-block mt-1">{{ __('admin.kpi.vs_last_month') }}</small>
                    </div>
                    <div class="metric-icon bg-primary-subtle text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Umumiy Sarmoya -->
    <div class="col-xl-3 col-md-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2 small">{{ __('admin.kpi.total_investment') }}</p>
                        <h3 class="mb-0 fw-bold" id="totalInvestment">{{ formatCurrency(45200000) }} UZS</h3>
                        <span class="trend-badge bg-success-subtle text-success mt-2">
                            <i class="fas fa-arrow-up"></i> <span id="investmentTrend">8.3%</span>
                        </span>
                        <small class="text-muted d-block mt-1">{{ __('admin.kpi.vs_last_month') }}</small>
                    </div>
                    <div class="metric-icon bg-success-subtle text-success">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Faol Loyihalar -->
    <div class="col-xl-3 col-md-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2 small">{{ __('admin.kpi.active_projects') }}</p>
                        <h3 class="mb-0 fw-bold" id="activeProjects">{{ formatCurrency(68) }}</h3>
                        <span class="trend-badge bg-warning-subtle text-warning mt-2">
                            <i class="fas fa-minus"></i> <span id="projectsTrend">2.1%</span>
                        </span>
                        <small class="text-muted d-block mt-1">{{ __('admin.kpi.vs_last_month') }}</small>
                    </div>
                    <div class="metric-icon bg-info-subtle text-info">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Umumiy Daromad -->
    <div class="col-xl-3 col-md-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2 small">{{ __('admin.kpi.total_revenue') }}</p>
                        <h3 class="mb-0 fw-bold" id="totalRevenue">{{ formatCurrency(8700000) }} UZS</h3>
                        <span class="trend-badge bg-success-subtle text-success mt-2">
                            <i class="fas fa-arrow-up"></i> <span id="revenueTrend">15.8%</span>
                        </span>
                        <small class="text-muted d-block mt-1">{{ __('admin.kpi.vs_last_month') }}</small>
                    </div>
                    <div class="metric-icon bg-warning-subtle text-warning">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>