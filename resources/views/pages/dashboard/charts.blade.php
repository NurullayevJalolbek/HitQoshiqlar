<!-- Grafiklar Bo'limi -->

<!-- Investorlar Dinamikasi -->
<div class="row">

    <div class="col-12 col-xl-6 col-xxl-8 mb-4">
        <div class="card border-0 shadow">
            <div class="card-body d-flex flex-row align-items-center flex-0 border-bottom">
                <div class="w-100 d-sm-flex justify-content-between align-items-start">
                    <div>
                        <div class="fs-5 fw-normal mb-2"> {{ __('admin.charts.investors_growth') }}
                        </div>
                        <h2 class="fs-3 fw-extrabold">{{ __('admin.charts.active_investors') }}</h2>
                        {{-- <div class="small mt-2 d-flex">
                            <div class="d-flex align-items-center me-2">
                                <svg class="icon icon-xs text-success" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-success fw-bold">180k</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <svg class="icon icon-xxs text-gray-500 me-1" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>WorldWide</span>
                            </div>
                        </div> --}}
                    </div>
                    <div class="d-flex align-items-center mb-2 me-3 lh-130">
                        <span class="dot rounded-circle bg-success me-2"></span>
                        <span class="fw-normal small">{{ __('admin.charts.active_investors') }}</span>
                        <span class="small fw-bold text-dark ms-1">45</span>
                    </div>
                    <div class="d-xxl-flex flex-wrap justify-content-end mt-4 mt-sm-0">
                        <div class="d-flex align-items-center mb-2 me-3 lh-130">
                            <span class="dot rounded-circle bg-warning me-2"></span>
                            <span class="fw-normal small">{{ __('admin.charts.passive_investors') }}</span>
                            <span class="small fw-bold text-dark ms-1">51</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-2 pb-4">
                <div id="traffic-volumes-chart"></div>
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
                {{ __('admin.charts.investor_income') }}
            </h5>
            <div id="revenueChart"></div>
            <div class="mt-3 d-flex justify-content-between">
                <small class="text-muted">{{ __('admin.charts.avg_income') }}: <strong>2,850,000 UZS</strong></small>
                <small class="text-success"><i class="fas fa-arrow-up"></i> 18.5%</small>
            </div>
        </div>
    </div>

    <!-- To'lovlar Dinamikasi -->
    <div class="col-xl-6 mb-4">
        <div class="chart-container">
            <h5 class="mb-3 fw-bold">
                <i class="fas fa-arrow-up text-danger me-2"></i>
                {{ __('admin.charts.exit_payments') }}
            </h5>
            <div id="paymentsChart"></div>
            <div class="mt-3 d-flex justify-content-between">
                <small class="text-muted">{{ __('admin.charts.avg_payment') }}: <strong>530,000 UZS</strong></small>
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
                {{ __('admin.charts.contract_revenue') }}
            </h5>
            <div id="contractRevenueChart"></div>
            <div class="mt-3">
                <div class="row text-center">
                    <div class="col-4">
                        <small class="text-muted d-block">{{ __('admin.charts.total_contracts') }}</small>
                        <strong>284</strong>
                    </div>
                    <div class="col-4">
                        <small class="text-muted d-block">{{ __('admin.charts.avg_revenue') }}</small>
                        <strong>1,580,000 UZS</strong>
                    </div>
                    <div class="col-4">
                        <small class="text-muted d-block">{{ __('admin.charts.growth') }}</small>
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
                {{ __('admin.charts.dividends_distribution') }}
            </h5>
            <div id="dividendsChart"></div>
            <div class="mt-3 text-center">
                <div class="row">
                    <div class="col-6">
                        <div class="border-end">
                            <small class="text-muted d-block">{{ __('admin.charts.paid') }}</small>
                            <strong class="text-success">65%</strong>
                        </div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">{{ __('admin.charts.pending') }}</small>
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
                {{ __('admin.charts.net_profit') }}
            </h5>
            <div id="profitChart"></div>
            <div class="mt-3 d-flex justify-content-between">
                <small class="text-muted">{{ __('admin.charts.avg_profit') }}: <strong>820,000 UZS</strong></small>
                <small class="text-success"><i class="fas fa-arrow-up"></i> 25.6%</small>
            </div>
        </div>
    </div>

    <!-- Shartnomalar -->
    <div class="col-xl-6 mb-4">
        <div class="chart-container">
            <h5 class="mb-3 fw-bold">
                <i class="fas fa-file-signature text-warning me-2"></i>
                {{ __('admin.charts.realization_contracts') }}
            </h5>
            <div id="contractsChart"></div>
            <div class="mt-3 d-flex justify-content-between">
                <small class="text-muted">{{ __('admin.charts.total_signed') }}: <strong>312
                        {{ __('admin.charts.contracts') }}</strong></small>
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
                {{ __('admin.charts.documents_growth') }}
            </h5>
            <div id="documentsChart"></div>
        </div>
    </div>

    <!-- Loyihalar bo'yicha Daromad -->
    <div class="col-xl-6 mb-4">
        <div class="chart-container">
            <h5 class="mb-3 fw-bold">
                <i class="fas fa-chart-bar text-primary me-2"></i>
                {{ __('admin.charts.revenue_by_project') }}
            </h5>
            <div id="revenueByProjectChart"></div>
        </div>
    </div>
</div>
