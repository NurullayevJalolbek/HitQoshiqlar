/**
 * Dashboard API Integration - Dynamic Charts
 * API dan ma'lumotlarni olish va grafiklarni yangilash
 */

// API dan ma'lumotlarni olish funksiyasi
async function fetchDashboardData() {
    try {
        const response = await fetch('http://localhost:8000/api/dashboard');
        if (!response.ok) {
            throw new Error('API javob bermadi');
        }
        const data = await response.json();
        return data.result;
    } catch (error) {
        console.error('Ma\'lumot yuklanmadi:', error);
        return null;
    }
}

// Grafiklarni yangilash funksiyasi
function updateAllCharts(apiData) {
    if (!apiData) {
        console.error('Ma\'lumot topilmadi');
        return;
    }

    const mode = window.chartMode || 'monthly';
    const charts = apiData.charts;

    // 1. Investorlar grafigi
    if (charts.investorsGrowth) {
        const investorData = charts.investorsGrowth[mode];
        renderInvestorsChart(
            investorData.active,
            investorData.passive
        );
    }

    // 2. Daromad grafigi (Investor Income)
    if (charts.investorIncome) {
        const incomeData = charts.investorIncome[mode];
        renderRevenueChart(incomeData.data);
    }

    // 3. To'lovlar grafigi (Exit Payments)
    if (charts.exitPayments) {
        const paymentsData = charts.exitPayments[mode];
        renderPaymentsChart(paymentsData.data);
    }

    // 4. Shartnoma daromadi grafigi
    if (charts.contractRevenue) {
        const contractData = charts.contractRevenue[mode];
        renderContractRevenueChart(contractData.data);
    }

    // 5. Dividendlar grafigi
    if (charts.dividendsDistribution) {
        renderDividendsChart();
    }

    // 6. Sof foyda grafigi
    if (charts.netProfit) {
        const profitData = charts.netProfit[mode];
        renderProfitChart(profitData.data);
    }

    // 7. Shartnomalar grafigi
    if (charts.realizationContracts) {
        const contractsData = charts.realizationContracts[mode];
        renderContractsChart(contractsData.data);
    }

    // 8. Hujjatlar grafigi
    if (charts.documentsGrowth) {
        const docsData = charts.documentsGrowth[mode];
        renderDocumentsChart(docsData.data);
    }

    // 9. Loyiha bo'yicha investorlar (Donut chart)
    if (charts.investorShareByProject) {
        renderProjectsDonutChart(
            charts.investorShareByProject.data,
            charts.investorShareByProject.categories
        );
    }

    // 10. Loyiha bo'yicha daromad
    if (charts.revenueByProject) {
        renderRevenueByProjectChart(
            charts.revenueByProject.dataK,
            charts.revenueByProject.categories
        );
    }

    // KPI kartalarini yangilash
    updateKPICards(apiData.kpi);
}

// KPI kartalarini yangilash
function updateKPICards(kpiData) {
    // Investorlar soni
    const totalInvestors = document.querySelector('[data-kpi="totalInvestors"]');
    if (totalInvestors) {
        totalInvestors.textContent = kpiData.totalInvestors.value.toLocaleString();
    }

    // Umumiy sarmoya
    const totalInvestment = document.querySelector('[data-kpi="totalInvestment"]');
    if (totalInvestment) {
        totalInvestment.textContent = kpiData.totalInvestment.formatted + ' k';
    }

    // Faol loyihalar
    const activeProjects = document.querySelector('[data-kpi="activeProjects"]');
    if (activeProjects) {
        activeProjects.textContent = kpiData.activeProjects.value;
    }

    // Umumiy daromad
    const totalRevenue = document.querySelector('[data-kpi="totalRevenue"]');
    if (totalRevenue) {
        totalRevenue.textContent = kpiData.totalRevenue.formatted + ' k';
    }

    // Trend foizlarini yangilash
    updateTrends(kpiData);
}

// Trend ko'rsatkichlarini yangilash
function updateTrends(kpiData) {
    const trends = {
        investorsTrend: kpiData.totalInvestors.trend,
        investmentTrend: kpiData.totalInvestment.trend,
        projectsTrend: kpiData.activeProjects.trend,
        revenueTrend: kpiData.totalRevenue.trend
    };

    Object.keys(trends).forEach(key => {
        const element = document.querySelector(`[data-trend="${key}"]`);
        if (element) {
            element.textContent = trends[key] + '%';
            const iconElement = element.previousElementSibling;
            if (iconElement && iconElement.tagName === 'svg') {
                iconElement.classList.remove('text-success', 'text-danger');
                iconElement.classList.add(trends[key] > 0 ? 'text-success' : 'text-danger');
            }
        }
    });
}

// Yangilangan renderProjectsDonutChart funksiyasi
function renderProjectsDonutChart(seriesData, categories) {
    const chartElement = document.querySelector("#projectsDonutChart");
    if (!chartElement) return;

    if (chartInstances.projects) {
        chartInstances.projects.destroy();
    }

    const options = {
        series: seriesData || [35, 32, 33],
        chart: {
            type: 'donut',
            height: 300
        },
        labels: categories || [
            trans.projectTypes?.land || 'Land',
            trans.projectTypes?.rent || 'Rent',
            trans.projectTypes?.construction || 'Construction'
        ],
        colors: ['#10b981', '#f59e0b', '#3b82f6'],
        legend: {
            position: 'bottom',
            fontSize: '14px'
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return Math.round(val) + "%"
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: trans.charts?.total_projects || 'Total',
                            formatter: function(w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            }
                        }
                    }
                }
            }
        }
    };

    chartInstances.projects = new ApexCharts(chartElement, options);
    chartInstances.projects.render();
}

// Yangilangan renderRevenueByProjectChart funksiyasi
function renderRevenueByProjectChart(dataValues, categories) {
    const chartElement = document.querySelector("#revenueByProjectChart");
    if (!chartElement) return;

    if (chartInstances.revenueByProject) {
        chartInstances.revenueByProject.destroy();
    }

    const options = {
        series: [{
            name: trans.charts?.revenue_label || 'Revenue',
            data: dataValues || [150000, 134000, 172678]
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
            formatter: function(val) {
                return val.toLocaleString() + " k"
            },
            offsetX: 30
        },
        xaxis: {
            categories: categories || [
                trans.projectTypes?.land || 'Land',
                trans.projectTypes?.rent || 'Rent',
                trans.projectTypes?.construction || 'Construction'
            ]
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val.toLocaleString() + " k UZS"
                }
            }
        }
    };

    chartInstances.revenueByProject = new ApexCharts(chartElement, options);
    chartInstances.revenueByProject.render();
}

// Mode o'zgarganda yangilash
window.switchChartMode = function(mode) {
    window.chartMode = mode;
    fetchDashboardData().then(data => {
        if (data) {
            updateAllCharts(data);
        }
    });
};

// Sahifa yuklanganda ma'lumotlarni olish
document.addEventListener('DOMContentLoaded', async function() {
    
    // API dan ma'lumotlarni olish
    const dashboardData = await fetchDashboardData();
    
    if (dashboardData) {
        updateAllCharts(dashboardData);
    } else {
        initializeAllCharts();
    }
});

// Auto-refresh har 5 daqiqada
setInterval(async () => {
    const dashboardData = await fetchDashboardData();
    if (dashboardData) {
        updateAllCharts(dashboardData);
    }
}, 300000); // 5 daqiqa

// KPI kartalar uchun HTML strukturasini yangilash
// kpi-cards.blade.php faylingizda quyidagi data-attributelarni qo'shing:
/*
<!-- Jami Investorlar -->
<h3 class="fw-extrabold mb-1" data-kpi="totalInvestors">15.3k</h3>
<span data-trend="investorsTrend">20%</span>

<!-- Umumiy Sarmoya -->
<h3 class="fw-extrabold mb-1" data-kpi="totalInvestment">$253,594</h3>
<span data-trend="investmentTrend">18.5%</span>

<!-- Faol Loyihalar -->
<h3 class="fs-1 fw-extrabold mb-1" data-kpi="activeProjects">6</h3>
<span data-trend="projectsTrend">16.8%</span>

<!-- Umumiy Daromad -->
<h3 class="display-3 fw-extrabold mb-0" data-kpi="totalRevenue">$456,678</h3>
<span data-trend="revenueTrend">22.4%</span>
*/

// Export funksiyalar
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        fetchDashboardData,
        updateAllCharts,
        updateKPICards
    };
}