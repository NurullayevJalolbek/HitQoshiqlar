<!-- Grafiklar Bo'limi -->

<!-- Birinchi Qator: Investorlar va Loyihalar -->
<div class="row">
    <!-- Investorlar Dinamikasi -->
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="chart-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-chart-area text-primary me-2"></i>
                    {{ __('dashboard.charts.investors_growth') }}
                </h5>
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-secondary active" data-period="month">
                        {{ __('dashboard.charts.month') }}
                    </button>
                    <button type="button" class="btn btn-outline-secondary" data-period="year">
                        {{ __('dashboard.charts.year') }}
                    </button>
                </div>
            </div>
            <div id="investorsChart"></div>
        </div>
    </div>

    <!-- Loyihalar Taqsimoti -->
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="chart-container">
            <h5 class="mb-3 fw-bold">
                <i class="fas fa-project-diagram text-success me-2"></i>
                {{ __('dashboard.charts.projects_distribution') }}
            </h5>
            <div id="projectsDonutChart"></div>
            <div class="mt-3">
                <small class="text-muted">{{ __('dashboard.charts.total_projects') }}: <strong>68</strong></small>
            </div>
        </div>
    </div>
</div>

<!-- Ikkinchi Qator: Tushumlar va To'lovlar -->
<div class="row">
    <!-- Tushumlar Dinamikasi -->
    <div class="col-xl-6 mb-4">
        <div class="chart-container">
            <h5 class="mb-3 fw-bold">
                <i class="fas fa-arrow-down text-success me-2"></i>
                {{ __('dashboard.charts.investor_income') }}
            </h5>
            <div id="revenueChart"></div>
            <div class="mt-3 d-flex justify-content-between">
                <small class="text-muted">{{ __('dashboard.charts.avg_income') }}: <strong>$2,850K</strong></small>
                <small class="text-success"><i class="fas fa-arrow-up"></i> 18.5%</small>
            </div>
        </div>
    </div>

    <!-- To'lovlar Dinamikasi -->
    <div class="col-xl-6 mb-4">
        <div class="chart-container">
            <h5 class="mb-3 fw-bold">
                <i class="fas fa-arrow-up text-danger me-2"></i>
                {{ __('dashboard.charts.exit_payments') }}
            </h5>
            <div id="paymentsChart"></div>
            <div class="mt-3 d-flex justify-content-between">
                <small class="text-muted">{{ __('dashboard.charts.avg_payment') }}: <strong>$530K</strong></small>
                <small class="text-danger"><i class="fas fa-arrow-up"></i> 12.3%</small>
            </div>
        </div>
    </div>
</div>

<!-- Uchinchi Qator: Daromad va Dividendlar -->
<div class="row">
    <!-- Daromad Dinamikasi -->
    <div class="col-xl-8 mb-4">
        <div class="chart-container">
            <h5 class="mb-3 fw-bold">
                <i class="fas fa-file-contract text-purple me-2"></i>
                {{ __('dashboard.charts.contract_revenue') }}
            </h5>
            <div id="contractRevenueChart"></div>
            <div class="mt-3">
                <div class="row text-center">
                    <div class="col-4">
                        <small class="text-muted d-block">{{ __('dashboard.charts.total_contracts') }}</small>
                        <strong>284</strong>
                    </div>
                    <div class="col-4">
                        <small class="text-muted d-block">{{ __('dashboard.charts.avg_revenue') }}</small>
                        <strong>$1,580K</strong>
                    </div>
                    <div class="col-4">
                        <small class="text-muted d-block">{{ __('dashboard.charts.growth') }}</small>
                        <strong class="text-success">+22.4%</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dividendlar -->
    <div class="col-xl-4 mb-4">
        <div class="chart-container">
            <h5 class="mb-3 fw-bold">
                <i class="fas fa-coins text-warning me-2"></i>
                {{ __('dashboard.charts.dividends_distribution') }}
            </h5>
            <div id="dividendsChart"></div>
            <div class="mt-3 text-center">
                <div class="row">
                    <div class="col-6">
                        <div class="border-end">
                            <small class="text-muted d-block">{{ __('dashboard.charts.paid') }}</small>
                            <strong class="text-success">65%</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">{{ __('dashboard.charts.pending') }}</small>
                        <strong class="text-warning">35%</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- To'rtinchi Qator: Sof Foyda va Shartnomalar -->
<div class="row">
    <!-- Sof Foyda -->
    <div class="col-xl-6 mb-4">
        <div class="chart-container">
            <h5 class="mb-3 fw-bold">
                <i class="fas fa-hand-holding-usd text-info me-2"></i>
                {{ __('dashboard.charts.net_profit') }}
            </h5>
            <div id="profitChart"></div>
            <div class="mt-3 d-flex justify-content-between">
                <small class="text-muted">{{ __('dashboard.charts.avg_profit') }}: <strong>$820K</strong></small>
                <small class="text-success"><i class="fas fa-arrow-up"></i> 25.6%</small>
            </div>
        </div>
    </div>

    <!-- Shartnomalar -->
    <div class="col-xl-6 mb-4">
        <div class="chart-container">
            <h5 class="mb-3 fw-bold">
                <i class="fas fa-file-signature text-warning me-2"></i>
                {{ __('dashboard.charts.realization_contracts') }}
            </h5>
            <div id="contractsChart"></div>
            <div class="mt-3 d-flex justify-content-between">
                <small class="text-muted">{{ __('dashboard.charts.total_signed') }}: <strong>312 {{ __('dashboard.charts.contracts') }}</strong></small>
                <small class="text-success"><i class="fas fa-arrow-up"></i> 16.8%</small>
            </div>
        </div>
    </div>
</div>

<!-- Beshinchi Qator: Qo'shimcha Grafiklar -->
<div class="row">
    <!-- Hujjatlar Dinamikasi -->
    <div class="col-xl-6 mb-4">
        <div class="chart-container">
            <h5 class="mb-3 fw-bold">
                <i class="fas fa-file-alt text-secondary me-2"></i>
                {{ __('dashboard.charts.documents_growth') }}
            </h5>
            <div id="documentsChart"></div>
        </div>
    </div>

    <!-- Loyihalar bo'yicha Daromad -->
    <div class="col-xl-6 mb-4">
        <div class="chart-container">
            <h5 class="mb-3 fw-bold">
                <i class="fas fa-chart-bar text-primary me-2"></i>
                {{ __('dashboard.charts.revenue_by_project') }}
            </h5>
            <div id="revenueByProjectChart"></div>
        </div>
    </div>
</div>