<!-- Dashboard Charts Section -->

<!-- Chart Mode Switcher -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary btn-sm" id="monthlyBtn" onclick="switchChartMode('monthly')">
                        <i class="fas fa-calendar-alt me-1"></i> {{ __('admin.charts.monthly') }}
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="dailyBtn" onclick="switchChartMode('daily')">
                        <i class="fas fa-calendar-day me-1"></i> {{ __('admin.charts.daily') }}
                    </button>
                </div>
                <small class="text-muted">
                    <i class="fas fa-sync-alt me-1"></i>
                    {{ __('admin.charts.last_update') }}: <span id="updateTimestamp">--:--</span>
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Row 1: Investors Growth -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-users text-primary me-2"></i>
                        {{ __('admin.charts.investors_growth') }}
                    </h5>
                    <div class="d-flex gap-3">
                        <div class="d-flex align-items-center">
                            <span class="dot rounded-circle bg-success me-2"></span>
                            <span class="fw-normal small">{{ __('admin.charts.active_investors') }}:</span>
                            <span class="fw-bold ms-1" data-investor-active>882</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="dot rounded-circle bg-warning me-2"></span>
                            <span class="fw-normal small">{{ __('admin.charts.passive_investors') }}:</span>
                            <span class="fw-bold ms-1" data-investor-passive>263</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <div id="traffic-volumes-chart"></div>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Income & Payments -->
<div class="row mb-4">
    <!-- Investor Income -->
    <div class="col-xl-6 mb-4 mb-xl-0">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-arrow-down text-success me-2"></i>
                    {{ __('admin.charts.investor_income') }}
                </h5>
            </div>
            <div class="card-body p-3">
                <div id="revenueChart"></div>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        {{ __('admin.charts.avg_income') }}: 
                        <strong data-avg-income>2,850,000 UZS</strong>
                    </small>
                    <span class="badge bg-success-soft text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span data-trend-income>18.5%</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Exit Payments -->
    <div class="col-xl-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-arrow-up text-danger me-2"></i>
                    {{ __('admin.charts.exit_payments') }}
                </h5>
            </div>
            <div class="card-body p-3">
                <div id="paymentsChart"></div>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        {{ __('admin.charts.avg_payment') }}: 
                        <strong data-avg-payment>530,000 UZS</strong>
                    </small>
                    <span class="badge bg-danger-soft text-danger">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span data-trend-payment>12.3%</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 3: Contract Revenue & Dividends -->
<div class="row mb-4">
    <!-- Contract Revenue -->
    <div class="col-xl-8 mb-4 mb-xl-0">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-file-contract text-purple me-2"></i>
                    {{ __('admin.charts.contract_revenue') }}
                </h5>
            </div>
            <div class="card-body p-3">
                <div id="contractRevenueChart"></div>
                <div class="mt-3">
                    <div class="row text-center">
                        <div class="col-4">
                            <small class="text-muted d-block">{{ __('admin.charts.total_contracts') }}</small>
                            <strong data-total-contracts>284</strong>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">{{ __('admin.charts.avg_revenue') }}</small>
                            <strong data-avg-contract-revenue>1,580,000 UZS</strong>
                        </div>
                        <div class="col-4">
                            <small class="text-muted d-block">{{ __('admin.charts.growth') }}</small>
                            <strong class="text-success" data-contract-growth>+22.4%</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dividends Distribution -->
    <div class="col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-coins text-warning me-2"></i>
                    {{ __('admin.charts.dividends_distribution') }}
                </h5>
            </div>
            <div class="card-body p-3">
                <div id="dividendsChart"></div>
                <div class="mt-3">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <small class="text-muted d-block">{{ __('admin.charts.paid') }}</small>
                            <strong class="text-success" data-dividend-paid>65%</strong>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block">{{ __('admin.charts.pending') }}</small>
                            <strong class="text-warning" data-dividend-pending>35%</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 4: Net Profit & Contracts -->
<div class="row mb-4">
    <!-- Net Profit -->
    <div class="col-xl-6 mb-4 mb-xl-0">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-hand-holding-usd text-info me-2"></i>
                    {{ __('admin.charts.net_profit') }}
                </h5>
            </div>
            <div class="card-body p-3">
                <div id="profitChart"></div>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        {{ __('admin.charts.avg_profit') }}: 
                        <strong data-avg-profit>820,000 UZS</strong>
                    </small>
                    <span class="badge bg-success-soft text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span data-trend-profit>25.6%</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Realization Contracts -->
    <div class="col-xl-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-file-signature text-warning me-2"></i>
                    {{ __('admin.charts.realization_contracts') }}
                </h5>
            </div>
            <div class="card-body p-3">
                <div id="contractsChart"></div>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        {{ __('admin.charts.total_signed') }}: 
                        <strong data-total-signed>312 {{ __('admin.charts.contracts') }}</strong>
                    </small>
                    <span class="badge bg-success-soft text-success">
                        <i class="fas fa-arrow-up me-1"></i>
                        <span data-trend-contracts>16.8%</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 5: Documents & Revenue by Project -->
<div class="row mb-4">
    <!-- Documents Growth -->
    <div class="col-xl-6 mb-4 mb-xl-0">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-file-alt text-secondary me-2"></i>
                    {{ __('admin.charts.documents_growth') }}
                </h5>
            </div>
            <div class="card-body p-3">
                <div id="documentsChart"></div>
            </div>
        </div>
    </div>

    <!-- Revenue by Project -->
    <div class="col-xl-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-chart-bar text-primary me-2"></i>
                    {{ __('admin.charts.revenue_by_project') }}
                </h5>
            </div>
            <div class="card-body p-3">
                <div id="revenueByProjectChart"></div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="chartLoadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center;">
    <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Yuklanmoqda...</span>
    </div>
</div>

<style>
/* Chart Container Styles */
.dot {
    width: 10px;
    height: 10px;
    display: inline-block;
}

.text-purple {
    color: #8b5cf6;
}

.bg-success-soft {
    background-color: rgba(16, 185, 129, 0.1);
}

.bg-danger-soft {
    background-color: rgba(239, 68, 68, 0.1);
}

.card-header h5 i {
    font-size: 1.1rem;
}

.card:hover {
    box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.1) !important;
}
</style>

<script>
// Update timestamp on load
function updateTimestamp() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const timestampElement = document.getElementById('updateTimestamp');
    if (timestampElement) {
        timestampElement.textContent = `${hours}:${minutes}`;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    updateTimestamp();
    setInterval(updateTimestamp, 60000); // Update every minute
});
</script>