<!-- KPI Kartalar -->
<div class="row g-4 mb-4">
    <!-- Jami Investorlar -->
    <div class="col-xl-3 col-md-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2 small">{{ __('dashboard.kpi.total_investors') }}</p>
                        <h3 class="mb-0 fw-bold" id="totalInvestors">1,284</h3>
                        <span class="trend-badge bg-success-subtle text-success mt-2">
                            <i class="fas fa-arrow-up"></i> <span id="investorsTrend">12.5%</span>
                        </span>
                        <small class="text-muted d-block mt-1">{{ __('dashboard.kpi.vs_last_month') }}</small>
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
                        <p class="text-muted mb-2 small">{{ __('dashboard.kpi.total_investment') }}</p>
                        <h3 class="mb-0 fw-bold" id="totalInvestment">$45.2M</h3>
                        <span class="trend-badge bg-success-subtle text-success mt-2">
                            <i class="fas fa-arrow-up"></i> <span id="investmentTrend">8.3%</span>
                        </span>
                        <small class="text-muted d-block mt-1">{{ __('dashboard.kpi.vs_last_month') }}</small>
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
                        <p class="text-muted mb-2 small">{{ __('dashboard.kpi.active_projects') }}</p>
                        <h3 class="mb-0 fw-bold" id="activeProjects">68</h3>
                        <span class="trend-badge bg-warning-subtle text-warning mt-2">
                            <i class="fas fa-minus"></i> <span id="projectsTrend">2.1%</span>
                        </span>
                        <small class="text-muted d-block mt-1">{{ __('dashboard.kpi.vs_last_month') }}</small>
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
                        <p class="text-muted mb-2 small">{{ __('dashboard.kpi.total_revenue') }}</p>
                        <h3 class="mb-0 fw-bold" id="totalRevenue">$8.7M</h3>
                        <span class="trend-badge bg-success-subtle text-success mt-2">
                            <i class="fas fa-arrow-up"></i> <span id="revenueTrend">15.8%</span>
                        </span>
                        <small class="text-muted d-block mt-1">{{ __('dashboard.kpi.vs_last_month') }}</small>
                    </div>
                    <div class="metric-icon bg-warning-subtle text-warning">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Qo'shimcha Statistika Kartalar -->
<div class="row g-4 mb-4">
    <!-- Aktiv Investorlar -->
    <div class="col-xl-3 col-md-6">
        <div class="card metric-card border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">{{ __('dashboard.kpi.active_investors') }}</p>
                        <h4 class="mb-0 fw-bold" id="activeInvestors">945</h4>
                    </div>
                    <i class="fas fa-user-check fa-2x text-primary opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Passiv Investorlar -->
    <div class="col-xl-3 col-md-6">
        <div class="card metric-card border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">{{ __('dashboard.kpi.passive_investors') }}</p>
                        <h4 class="mb-0 fw-bold" id="passiveInvestors">280</h4>
                    </div>
                    <i class="fas fa-user-clock fa-2x text-warning opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Jami Dividendlar -->
    <div class="col-xl-3 col-md-6">
        <div class="card metric-card border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">{{ __('dashboard.kpi.total_dividends') }}</p>
                        <h4 class="mb-0 fw-bold" id="totalDividends">$5.4M</h4>
                    </div>
                    <i class="fas fa-hand-holding-usd fa-2x text-success opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Sof Foyda -->
    <div class="col-xl-3 col-md-6">
        <div class="card metric-card border-start border-info border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">{{ __('dashboard.kpi.net_profit') }}</p>
                        <h4 class="mb-0 fw-bold" id="netProfit">$12.3M</h4>
                    </div>
                    <i class="fas fa-chart-pie fa-2x text-info opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>
