<script>
    /**
     * Chart Rendering Functions
     * Optimized ApexCharts implementation
     */

    // ============= CHART HELPER FUNCTIONS =============

    function destroyChart(chartName) {
        if (DashboardState.chartInstances[chartName]) {
            DashboardState.chartInstances[chartName].destroy();
            delete DashboardState.chartInstances[chartName];
        }
    }

    function getChartData(chartKey) {
        const mode = DashboardState.chartMode;
        const apiData = DashboardState.apiData;

        if (!apiData || !apiData.charts || !apiData.charts[chartKey]) {
            return null;
        }

        return apiData.charts[chartKey][mode] || apiData.charts[chartKey];
    }

    // ============= CHART RENDER FUNCTIONS =============

    /**
     * 1. Investors Growth Chart
     */
    function renderInvestorsChart() {
        const chartElement = document.querySelector('#traffic-volumes-chart');
        if (!chartElement) return;

        destroyChart('investors');

        const chartData = getChartData('investorsGrowth');
        if (!chartData) return;

        const options = {
            series: [{
                    name: trans.charts?.active_investors || 'Active Investors',
                    data: chartData.active
                },
                {
                    name: trans.charts?.passive_investors || 'Passive Investors',
                    data: chartData.passive
                }
            ],
            chart: {
                type: 'area',
                height: 350,
                fontFamily: 'Inter, sans-serif',
                toolbar: {
                    show: true
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: chartData.categories
            },
            colors: ['#10b981', '#f59e0b'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left'
            },
            tooltip: {
                shared: true,
                intersect: false
            }
        };

        DashboardState.chartInstances.investors = new ApexCharts(chartElement, options);
        DashboardState.chartInstances.investors.render();

        // Update legend values
        if (chartData.active && chartData.passive) {
            const activeCount = chartData.active[chartData.active.length - 1];
            const passiveCount = chartData.passive[chartData.passive.length - 1];

            const activeEl = document.querySelector('[data-investor-active]');
            const passiveEl = document.querySelector('[data-investor-passive]');

            if (activeEl) activeEl.textContent = activeCount;
            if (passiveEl) passiveEl.textContent = passiveCount;
        }
    }

    /**
     * 2. Revenue Chart (Investor Income)
     */
    function renderRevenueChart() {
        const chartElement = document.querySelector('#revenueChart');
        if (!chartElement) return;

        destroyChart('revenue');

        const chartData = getChartData('investorIncome');
        if (!chartData) return;

        const options = {
            series: [{
                name: trans.charts?.investor_income || 'Investor Income',
                data: chartData.data
            }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: true
                }
            },
            colors: ['#10b981'],
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: chartData.categories
            },
            yaxis: {
                title: {
                    text: 'UZS (ming)'
                }
            },
            tooltip: {
                y: {
                    formatter: val => formatNumber(val) + ' ming UZS'
                }
            }
        };

        DashboardState.chartInstances.revenue = new ApexCharts(chartElement, options);
        DashboardState.chartInstances.revenue.render();

        // Update average
        if (chartData.data && chartData.data.length > 0) {
            const avg = Math.round(chartData.data.reduce((a, b) => a + b, 0) / chartData.data.length);
            const avgEl = document.querySelector('[data-avg-income]');
            if (avgEl) avgEl.textContent = formatNumber(avg) + ' UZS';
        }
    }

    /**
     * 3. Payments Chart (Exit Payments)
     */
    function renderPaymentsChart() {
        const chartElement = document.querySelector('#paymentsChart');
        if (!chartElement) return;

        destroyChart('payments');

        const chartData = getChartData('exitPayments');
        if (!chartData) return;

        const options = {
            series: [{
                name: trans.charts?.exit_payments || 'Exit Payments',
                data: chartData.data
            }],
            chart: {
                type: 'line',
                height: 300,
                toolbar: {
                    show: true
                }
            },
            colors: ['#ef4444'],
            stroke: {
                curve: 'smooth',
                width: 3
            },
            markers: {
                size: 5,
                hover: {
                    size: 7
                }
            },
            xaxis: {
                categories: chartData.categories
            },
            yaxis: {
                title: {
                    text: 'UZS (ming)'
                }
            },
            tooltip: {
                y: {
                    formatter: val => formatNumber(val) + ' ming UZS'
                }
            }
        };

        DashboardState.chartInstances.payments = new ApexCharts(chartElement, options);
        DashboardState.chartInstances.payments.render();

        // Update average
        if (chartData.data && chartData.data.length > 0) {
            const avg = Math.round(chartData.data.reduce((a, b) => a + b, 0) / chartData.data.length);
            const avgEl = document.querySelector('[data-avg-payment]');
            if (avgEl) avgEl.textContent = formatNumber(avg) + ' UZS';
        }
    }

    /**
     * 4. Contract Revenue Chart
     */
    function renderContractRevenueChart() {
        const chartElement = document.querySelector('#contractRevenueChart');
        if (!chartElement) return;

        destroyChart('contractRevenue');

        const chartData = getChartData('contractRevenue');
        if (!chartData) return;

        const options = {
            series: [{
                name: trans.charts?.contract_revenue || 'Contract Revenue',
                data: chartData.data
            }],
            chart: {
                type: 'area',
                height: 300,
                toolbar: {
                    show: true
                }
            },
            colors: ['#8b5cf6'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.5,
                    opacityTo: 0.1
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: chartData.categories
            },
            yaxis: {
                title: {
                    text: 'UZS (ming)'
                }
            },
            tooltip: {
                y: {
                    formatter: val => formatNumber(val) + ' ming UZS'
                }
            }
        };

        DashboardState.chartInstances.contractRevenue = new ApexCharts(chartElement, options);
        DashboardState.chartInstances.contractRevenue.render();

        // Update stats
        const apiData = DashboardState.apiData;
        if (apiData && apiData.charts && apiData.charts.contractRevenue && apiData.charts.contractRevenue.stats) {
            const stats = apiData.charts.contractRevenue.stats;

            const totalEl = document.querySelector('[data-total-contracts]');
            const avgEl = document.querySelector('[data-avg-contract-revenue]');
            const growthEl = document.querySelector('[data-contract-growth]');

            if (totalEl) totalEl.textContent = stats.totalContracts;
            if (avgEl) avgEl.textContent = stats.avgRevenueFormatted + ' UZS';
            if (growthEl) growthEl.textContent = '+' + stats.growth + '%';
        }
    }

    /**
     * 5. Dividends Distribution Chart
     */
    function renderDividendsChart() {
        const chartElement = document.querySelector('#dividendsChart');
        if (!chartElement) return;

        destroyChart('dividends');

        const chartData = getChartData('dividendsDistribution');
        if (!chartData) return;

        const options = {
            series: [chartData.paid, chartData.pending],
            chart: {
                type: 'pie',
                height: 300
            },
            labels: [
                trans.charts?.paid || 'Paid',
                trans.charts?.pending || 'Pending'
            ],
            colors: ['#10b981', '#f59e0b'],
            legend: {
                position: 'bottom'
            },
            dataLabels: {
                enabled: true,
                formatter: val => Math.round(val) + '%'
            },
            tooltip: {
                y: {
                    formatter: val => val + '%'
                }
            }
        };

        DashboardState.chartInstances.dividends = new ApexCharts(chartElement, options);
        DashboardState.chartInstances.dividends.render();

        // Update percentages
        const paidEl = document.querySelector('[data-dividend-paid]');
        const pendingEl = document.querySelector('[data-dividend-pending]');

        if (paidEl) paidEl.textContent = chartData.paid + '%';
        if (pendingEl) pendingEl.textContent = chartData.pending + '%';
    }

    /**
     * 6. Net Profit Chart
     */
    function renderProfitChart() {
        const chartElement = document.querySelector('#profitChart');
        if (!chartElement) return;

        destroyChart('profit');

        const chartData = getChartData('netProfit');
        if (!chartData) return;

        const options = {
            series: [{
                name: trans.charts?.net_profit || 'Net Profit',
                data: chartData.data
            }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: true
                }
            },
            colors: ['#06b6d4'],
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    columnWidth: '60%'
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: chartData.categories
            },
            yaxis: {
                title: {
                    text: 'UZS (ming)'
                }
            },
            tooltip: {
                y: {
                    formatter: val => formatNumber(val) + ' ming UZS'
                }
            }
        };

        DashboardState.chartInstances.profit = new ApexCharts(chartElement, options);
        DashboardState.chartInstances.profit.render();

        // Update average
        const apiData = DashboardState.apiData;
        if (apiData && apiData.charts && apiData.charts.netProfit && apiData.charts.netProfit.avgProfitFormatted) {
            const avgEl = document.querySelector('[data-avg-profit]');
            if (avgEl) avgEl.textContent = apiData.charts.netProfit.avgProfitFormatted + ' UZS';
        }
    }

    /**
     * 7. Realization Contracts Chart
     */
    function renderContractsChart() {
        const chartElement = document.querySelector('#contractsChart');
        if (!chartElement) return;

        destroyChart('contracts');

        const chartData = getChartData('realizationContracts');
        if (!chartData) return;

        const options = {
            series: [{
                name: trans.charts?.realization_contracts || 'Contracts',
                data: chartData.data
            }],
            chart: {
                type: 'line',
                height: 300,
                toolbar: {
                    show: true
                }
            },
            colors: ['#f59e0b'],
            stroke: {
                curve: 'smooth',
                width: 3
            },
            markers: {
                size: 5,
                hover: {
                    size: 7
                }
            },
            xaxis: {
                categories: chartData.categories
            },
            yaxis: {
                title: {
                    text: trans.charts?.total_contracts || 'Contracts'
                }
            },
            tooltip: {
                y: {
                    formatter: val => val + ' ' + (trans.charts?.contracts || 'contracts')
                }
            }
        };

        DashboardState.chartInstances.contracts = new ApexCharts(chartElement, options);
        DashboardState.chartInstances.contracts.render();

        // Update total signed
        const apiData = DashboardState.apiData;
        if (apiData && apiData.charts && apiData.charts.realizationContracts && apiData.charts.realizationContracts
            .totalSigned) {
            const totalEl = document.querySelector('[data-total-signed]');
            if (totalEl) {
                totalEl.textContent = apiData.charts.realizationContracts.totalSigned + ' ' + (trans.charts
                    ?.contracts || 'contracts');
            }
        }
    }

    /**
     * 8. Documents Growth Chart
     */
    function renderDocumentsChart() {
        const chartElement = document.querySelector('#documentsChart');
        if (!chartElement) return;

        destroyChart('documents');

        const chartData = getChartData('documentsGrowth');
        if (!chartData) return;

        const options = {
            series: [{
                name: trans.messages?.documents || 'Documents',
                data: chartData.data
            }],
            chart: {
                type: 'area',
                height: 300,
                toolbar: {
                    show: true
                }
            },
            colors: ['#6b7280'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.1
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: chartData.categories
            },
            yaxis: {
                title: {
                    text: trans.messages?.documents || 'Documents'
                }
            },
            tooltip: {
                y: {
                    formatter: val => val + ' ' + (trans.messages?.documents || 'documents')
                }
            }
        };

        DashboardState.chartInstances.documents = new ApexCharts(chartElement, options);
        DashboardState.chartInstances.documents.render();
    }

    /**
     * 9. Revenue by Project Chart
     */
    function renderRevenueByProjectChart() {
        const chartElement = document.querySelector('#revenueByProjectChart');
        if (!chartElement) return;

        destroyChart('revenueByProject');

        const chartData = getChartData('revenueByProject');
        if (!chartData) return;

        const options = {
            series: [{
                name: trans.charts?.revenue_label || 'Revenue',
                data: chartData.dataK
            }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: true
                }
            },
            colors: ['#3b82f6'],
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    horizontal: true,
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: val => formatNumber(val) + ' k',
                offsetX: 30
            },
            xaxis: {
                categories: chartData.categories
            },
            tooltip: {
                y: {
                    formatter: val => formatNumber(val) + ' ming UZS'
                }
            }
        };

        DashboardState.chartInstances.revenueByProject = new ApexCharts(chartElement, options);
        DashboardState.chartInstances.revenueByProject.render();
    }

    // ============= MAIN INITIALIZATION =============

    async function initializeAllCharts(mode = 'monthly') {
        DashboardState.chartMode = mode;

        console.log('📊 Grafiklar yuklanmoqda...', mode);

        // Render all charts
        renderInvestorsChart();
        renderRevenueChart();
        renderPaymentsChart();
        renderContractRevenueChart();
        renderDividendsChart();
        renderProfitChart();
        renderContractsChart();
        renderDocumentsChart();
        renderRevenueByProjectChart();

        console.log('✅ Barcha grafiklar yuklandi');
    }

    // Export function
    window.initializeAllCharts = initializeAllCharts;

    
</script>
