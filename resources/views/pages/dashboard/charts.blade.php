<!-- Charts Section - Optimized Layout -->
<!-- Main Chart: Investors Growth -->
<div class="row mb-3 mb-lg-4">
    <div class="col-12">
        <div class="card chart-card">
            <div class="card-header">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
                    <h5>
                        <i class="fas fa-users text-primary"></i>
                        {{ __('admin.charts.investors_growth') }}
                    </h5>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <span class="dot rounded-circle bg-success me-2"></span>
                            <span class="small text-muted me-1">{{ __('admin.charts.active_investors') }}:</span>
                            <span class="fw-bold" data-investor-active>882</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="dot rounded-circle bg-warning me-2"></span>
                            <span class="small text-muted me-1">{{ __('admin.charts.passive_investors') }}:</span>
                            <span class="fw-bold" data-investor-passive>263</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="traffic-volumes-chart"></div>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Income & Payments (Equal Height) -->
<div class="row g-3 g-lg-4 mb-3 mb-lg-4">
    <div class="col-lg-6">
        <div class="card chart-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-arrow-down text-success"></i>
                    {{ __('admin.charts.investor_income') }}
                </h5>
            </div>
            <div class="card-body">
                <div id="revenueChart"></div>
                <div class="chart-stats">
                    <div class="chart-stat-item">
                        <small>{{ __('admin.charts.avg_income') }}</small>
                        <strong data-avg-income>2,850,000</strong>
                    </div>
                    <div class="chart-stat-item">
                        <small>{{ __('admin.charts.growth') }}</small>
                        <span class="badge bg-success-soft">
                            <i class="fas fa-arrow-up"></i>
                            <span data-trend-income>18.5%</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card chart-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-arrow-up text-danger"></i>
                    {{ __('admin.charts.exit_payments') }}
                </h5>
            </div>
            <div class="card-body">
                <div id="paymentsChart"></div>
                <div class="chart-stats">
                    <div class="chart-stat-item">
                        <small>{{ __('admin.charts.avg_payment') }}</small>
                        <strong data-avg-payment>530,000</strong>
                    </div>
                    <div class="chart-stat-item">
                        <small>{{ __('admin.charts.growth') }}</small>
                        <span class="badge bg-danger-soft">
                            <i class="fas fa-arrow-up"></i>
                            <span data-trend-payment>12.3%</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 3: Contract Revenue (Large) & Dividends (Small) -->
<div class="row g-3 g-lg-4 mb-3 mb-lg-4">
    <div class="col-lg-8">
        <div class="card chart-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-file-contract text-purple"></i>
                    {{ __('admin.charts.contract_revenue') }}
                </h5>
            </div>
            <div class="card-body">
                <div id="contractRevenueChart"></div>
                <div class="chart-stats">
                    <div class="chart-stat-item">
                        <small>{{ __('admin.charts.total_contracts') }}</small>
                        <strong data-total-contracts>284</strong>
                    </div>
                    <div class="chart-stat-item">
                        <small>{{ __('admin.charts.avg_revenue') }}</small>
                        <strong data-avg-contract-revenue>1,580,000</strong>
                    </div>
                    <div class="chart-stat-item">
                        <small>{{ __('admin.charts.growth') }}</small>
                        <strong class="text-success" data-contract-growth>+22.4%</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card chart-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-coins text-warning"></i>
                    {{ __('admin.charts.dividends_distribution') }}
                </h5>
            </div>
            <div class="card-body">
                <div id="dividendsChart"></div>
                <div class="chart-stats">
                    <div class="chart-stat-item">
                        <small>{{ __('admin.charts.paid') }}</small>
                        <strong class="text-success" data-dividend-paid>65%</strong>
                    </div>
                    <div class="chart-stat-item">
                        <small>{{ __('admin.charts.pending') }}</small>
                        <strong class="text-warning" data-dividend-pending>35%</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 4: Net Profit & Contracts -->
<div class="row g-3 g-lg-4 mb-3 mb-lg-4">
    <div class="col-lg-6">
        <div class="card chart-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-hand-holding-usd text-info"></i>
                    {{ __('admin.charts.net_profit') }}
                </h5>
            </div>
            <div class="card-body">
                <div id="profitChart"></div>
                <div class="chart-stats">
                    <div class="chart-stat-item">
                        <small>{{ __('admin.charts.avg_profit') }}</small>
                        <strong data-avg-profit>820,000</strong>
                    </div>
                    <div class="chart-stat-item">
                        <small>{{ __('admin.charts.growth') }}</small>
                        <span class="badge bg-success-soft">
                            <i class="fas fa-arrow-up"></i>
                            <span data-trend-profit>25.6%</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card chart-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-file-signature text-warning"></i>
                    {{ __('admin.charts.realization_contracts') }}
                </h5>
            </div>
            <div class="card-body">
                <div id="contractsChart"></div>
                <div class="chart-stats">
                    <div class="chart-stat-item">
                        <small>{{ __('admin.charts.total_signed') }}</small>
                        <strong data-total-signed>312</strong>
                    </div>
                    <div class="chart-stat-item">
                        <small>{{ __('admin.charts.growth') }}</small>
                        <span class="badge bg-success-soft">
                            <i class="fas fa-arrow-up"></i>
                            <span data-trend-contracts>16.8%</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 5: Documents & Revenue by Project -->
<div class="row g-3 g-lg-4 mb-3 mb-lg-4">
    <div class="col-lg-6">
        <div class="card chart-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-file-alt text-secondary"></i>
                    {{ __('admin.charts.documents_growth') }}
                </h5>
            </div>
            <div class="card-body">
                <div id="documentsChart"></div>
                <div class="chart-stats">
                    <div class="chart-stat-item">
                        <small>Jami hujjatlar</small>
                        <strong>1,245</strong>
                    </div>
                    <div class="chart-stat-item">
                        <small>Yangi hujjatlar</small>
                        <strong class="text-primary">+89</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card chart-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-chart-bar text-primary"></i>
                    {{ __('admin.charts.revenue_by_project') }}
                </h5>
            </div>
            <div class="card-body">
                <div id="revenueByProjectChart"></div>
                <div class="chart-stats">
                    <div class="chart-stat-item">
                        <small>Eng yuqori</small>
                        <strong>Loyiha A</strong>
                    </div>
                    <div class="chart-stat-item">
                        <small>Umumiy</small>
                        <strong>88.5M</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="chartLoadingOverlay">
    <div class="spinner-border text-light" role="status">
        <span class="visually-hidden">{{ __('admin.loading') }}</span>
    </div>
</div>

<script>
// Update timestamp
function updateTimestamp() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const element = document.getElementById('updateTimestamp');
    if (element) {
        element.textContent = `${hours}:${minutes}`;
    }
}

// Chart mode switcher
function switchChartMode(mode) {
    const monthlyBtn = document.getElementById('monthlyBtn');
    const dailyBtn = document.getElementById('dailyBtn');
    
    if (mode === 'monthly') {
        monthlyBtn.classList.remove('btn-outline-primary');
        monthlyBtn.classList.add('btn-primary');
        dailyBtn.classList.remove('btn-primary');
        dailyBtn.classList.add('btn-outline-primary');
    } else {
        dailyBtn.classList.remove('btn-outline-primary');
        dailyBtn.classList.add('btn-primary');
        monthlyBtn.classList.remove('btn-primary');
        monthlyBtn.classList.add('btn-outline-primary');
    }
    
    // Trigger chart update (implement your chart reload logic)
    console.log('Switching to', mode, 'mode');
    // reloadCharts(mode);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateTimestamp();
    setInterval(updateTimestamp, 60000); // Update every minute
});
</script>