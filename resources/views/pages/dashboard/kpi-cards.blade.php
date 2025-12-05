<!-- Chart Mode Switcher -->
<div class="row">
    <div class="col-12">
        <div class="card chart-mode-card">
            <div
                class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary btn-sm" id="monthlyBtn"
                        onclick="switchChartMode('monthly')">
                        <i class="fas fa-calendar-alt me-1"></i> {{ __('admin.charts.monthly') }}
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="dailyBtn"
                        onclick="switchChartMode('daily')">
                        <i class="fas fa-calendar-day me-1"></i> {{ __('admin.charts.daily') }}
                    </button>
                </div>
                <small class="text-muted">
                    <i class="fas fa-sync-alt me-1"></i>
                    {{ __('admin.charts.last_update') }}: <span id="updateTimestamp" class="fw-semibold">--:--</span>
                </small>
            </div>
        </div>
    </div>
</div>
<!-- KPI Kartalar -->
<div class="row g-4 mb-4">
    <!-- Jami Investorlar -->
    <div class="col-xl-3 col-md-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="row d-block d-sm-flex d-xl-block d-xxl-flex align-items-center">
                    <div class="col-12 col-sm-6 col-xl-12 col-xxl-6 px-xxl-0 mb-3 mb-sm-0 mb-xl-3 mb-xxl-0">
                        <div id="chart-users"></div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-12 col-xxl-6 ps-xxl-4 pe-xxl-0">
                        <h2 class="fs-5 fw-normal mb-1">{{ __('admin.kpi.active_investors') }}</h2>
                        <h3 class="fw-extrabold mb-1" data-kpi="totalInvestors">945</h3>
                        <span class="text-success fw-bolder me-1" data-trend="investorsTrend">20.5%</span>
                        <small class="d-flex align-items-center">
                            <svg class="icon icon-xxs text-gray-400 me-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Apr 1 - May 1
                        </small>
                        <div class="small d-flex mt-1">
                            <svg class="icon icon-xs text-success" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <div><span class="text-success fw-bolder me-1">20%</span> Since last month</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Umumiy Sarmoya -->
    <div class="col-xl-3 col-md-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="row d-block d-xxl-flex align-items-center">
                    <div class="col-12 col-xxl-6 px-xxl-0 mb-3 mb-xxl-0">
                        <div id="chart-investment"></div>
                    </div>
                    <div class="col-12 col-xxl-6 ps-xxl-4 pe-xl-0">
                        <h2 class="fs-5 fw-normal mb-1">{{ __('admin.kpi.total_investment') }}</h2>
                        <h3 class="fw-extrabold mb-1" data-kpi="totalInvestment">88,000,000 k</h3>
                        <span class="text-success fw-bolder me-1" data-trend="investmentTrend">18.5%</span>
                        <small class="d-flex align-items-center">
                            <svg class="icon icon-xxs text-gray-400 me-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Apr 1 - May 1
                        </small>
                        <div class="small d-flex mt-1">
                            <svg class="icon icon-xs text-danger" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <div><span class="text-danger fw-bolder me-1">4,6%</span> Since last month</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="row d-block d-sm-flex d-xl-block d-xxl-flex align-items-center">
                    <div class="col-12 col-sm-6 col-xl-12 col-xxl-6 px-xxl-0 mb-3 mb-sm-0 mb-xl-3 mb-xxl-0">
                        <div id="chart-active-projects"></div>
                    </div>
                    <div class="col-12 col-sm-6 col-xl-12 col-xxl-6 ps-xxl-4 pe-xxl-0">
                        <h2 class="fs-5 fw-normal mb-1">{{ __('admin.kpi.active_projects') }}</h2>
                        <h3 class="fw-extrabold mb-1" data-kpi="activeProjects">0</h3>
                        <span class="text-success fw-bolder me-1" data-trend="projectsTrend">0%</span>
                        <small class="d-flex align-items-center">
                            <svg class="icon icon-xxs text-gray-400 me-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Apr 1 - May 1
                        </small>
                        <div class="small d-flex mt-1">
                            <svg class="icon icon-xs text-success" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <div><span class="text-success fw-bolder me-1">20%</span> Since last month</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Umumiy Daromad -->

    <div class="col-xl-3 col-md-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="row d-block d-xxl-flex align-items-center">
                    <div class="col-12 col-xxl-6 px-xxl-0 mb-3 mb-xxl-0">
                        <div id="chart-revenue"></div>
                    </div>
                    <div class="col-12 col-xxl-6 ps-xxl-4 pe-xl-0">
                        <h2 class="fs-6 fw-normal mb-1 text-gray-400">{{ __('admin.kpi.total_revenue') }}</h2>
                        <h3 class="fw-extrabold mb-1" data-kpi="totalRevenue">0</h3>
                        <small class="d-flex align-items-center">
                            <svg class="icon icon-xxs text-gray-400 me-1" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Apr 1 - May 1
                        </small>
                        <div class="small d-flex mt-1">
                            <div><svg class="icon icon-xs text-danger" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                    clip-rule="evenodd"></path>
                                </svg><span class="text-green fw-bolder" data-trend="revenueTrend">0%</span> Since last month</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
