/**
 * Dashboard Main Script
 * Ma'lumotlarni yuklash va grafiklarni yangilash
 */

// Global o'zgaruvchilar
let dashboardData = null;
let currentMode = 'monthly'; // 'monthly' yoki 'daily'
let chartInstances = {};

/**
 * Dashboard ma'lumotlarini yuklash
 */
async function loadDashboardData() {
    try {
        const response = await fetch('/dashboard-data.json');
        dashboardData = await response.json();
        console.log('Dashboard ma\'lumotlari yuklandi:', dashboardData);
        return dashboardData;
    } catch (error) {
        console.error('Dashboard ma\'lumotlarini yuklashda xatolik:', error);
        // Fallback - default ma'lumotlar
        return getDefaultData();
    }
}

/**
 * Default ma'lumotlarni qaytarish (agar JSON yuklanmasa)
 */
function getDefaultData() {
    return {
        kpi: {
            totalInvestors: { value: 945, trend: 20.5, change: 'increase', active: 882, passive: 263 },
            totalInvestment: { value: 88000000000, formatted: '88,000', trend: 18.5, change: 'increase' },
            activeProjects: { value: 6, trend: 16.8, change: 'increase' },
            totalRevenue: { value: 456678000000, formatted: '456,678', trend: 22.4, change: 'increase' },
            partnerRevenue: { value: 125480000000, formatted: '125,480', trend: 25.6, change: 'increase' }
        }
    };
}

/**
 * KPI kartalarni yangilash
 */
function updateKPICards(data) {
    const kpi = data.kpi;
    
    // Jami investorlar
    document.getElementById('kpiTotalInvestors').textContent = kpi.totalInvestors.value.toLocaleString();
    document.getElementById('activeInvestorsCount').textContent = kpi.totalInvestors.active;
    document.getElementById('passiveInvestorsCount').textContent = kpi.totalInvestors.passive;
    
    // Umumiy sarmoya
    const investmentMln = (kpi.totalInvestment.value / 1000000).toLocaleString();
    document.getElementById('kpiTotalInvestment').textContent = investmentMln + ' mln';
    
    // Faol loyihalar
    document.getElementById('kpiActiveProjects').textContent = kpi.activeProjects.value;
    
    // Umumiy daromad
    const revenueMln = (kpi.totalRevenue.value / 1000000).toLocaleString();
    document.getElementById('kpiTotalRevenue').textContent = revenueMln + ' mln';
    
    // Mini grafiklar
    renderKPIMiniCharts(data);
}

/**
 * KPI mini grafiklarni render qilish
 */
function renderKPIMiniCharts(data) {
    // Investorlar mini grafigi
    const investorsData = currentMode === 'monthly' 
        ? data.charts.investorsGrowth.monthly.active 
        : data.charts.investorsGrowth.daily.active;
    
    renderMiniChart('chart-investors-mini', investorsData.slice(-7), '#4D4AE8');
    
    // Sarmoya mini grafigi
    const investmentData = currentMode === 'monthly'
        ? data.charts.investorIncome.monthly.data
        : data.charts.investorIncome.daily.data;
    
    renderMiniChart('chart-investment-mini', investmentData.slice(-7), '#31316A');
    
    // Loyihalar mini grafigi
    renderMiniChart('chart-projects-mini', [4, 5, 5, 5, 6, 6, 6], '#06A77D');
    
    // Haftalik daromad grafigi
    const revenueData = data.charts.contractRevenue.monthly.data.slice(-8);
    renderWeeklyRevenueChart(revenueData);
}

/**
 * Mini grafik render qilish
 */
function renderMiniChart(elementId, data, color) {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    if (chartInstances[elementId]) {
        chartInstances[elementId].destroy();
    }
    
    const options = {
        series: [{ name: 'Value', data: data }],
        chart: {
            type: 'area',
            width: '100%',
            height: 140,
            sparkline: { enabled: true }
        },
        colors: [color],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.5,
                opacityTo: 0.1
            }
        },
        stroke: { curve: 'smooth', width: 2 },
        tooltip: {
            fixed: { enabled: false },
            x: { show: false },
            y: { formatter: (val) => val.toLocaleString() },
            marker: { show: false }
        }
    };
    
    chartInstances[elementId] = new ApexCharts(element, options);
    chartInstances[elementId].render();
}

/**
 * Haftalik daromad grafigini render qilish
 */
function renderWeeklyRevenueChart(data) {
    const element = document.getElementById('chart-weekly-revenue');
    if (!element) return;
    
    if (chartInstances['chart-weekly-revenue']) {
        chartInstances['chart-weekly-revenue'].destroy();
    }
    
    const options = {
        series: [{ name: 'Daromad', data: data }],
        chart: {
            type: 'bar',
            width: '100%',
            height: 260,
            sparkline: { enabled: true }
        },
        theme: { monochrome: { enabled: true, color: '#4D4AE8' } },
        plotOptions: {
            bar: {
                columnWidth: '20%',
                borderRadius: 5,
                colors: {
                    backgroundBarColors: ['#F2F4F6'],
                    backgroundBarRadius: 5
                }
            }
        },
        labels: ['1', '2', '3', '4', '5', '6', '7', '8'],
        tooltip: {
            y: {
                formatter: function(val) {
                    return (val / 1000000).toFixed(0) + ' mln';
                }
            }
        }
    };
    
    chartInstances['chart-weekly-revenue'] = new ApexCharts(element, options);
    chartInstances['chart-weekly-revenue'].render();
}

/**
 * Barcha grafiklarni render qilish
 */
function renderAllCharts(data) {
    const mode = currentMode;
    const chartsData = data.charts;
    
    // 1. Investorlar o'sishi
    renderInvestorsGrowthChart(chartsData.investorsGrowth[mode]);
    
    // 2. Investor share by project
    renderInvestorShareChart(chartsData.investorShareByProject);
    
    // 3. Investor tushumlari
    renderInvestorIncomeChart(chartsData.investorIncome[mode]);
    
    // 4. Chiqish to'lovlari
    renderExitPaymentsChart(chartsData.exitPayments[mode]);
    
    // 5. Shartnoma daromadi
    renderContractRevenueChart(chartsData.contractRevenue[mode]);
    
    // 6. Dividendlar
    renderDividendsChart(chartsData.dividendsDistribution);
    
    // 7. Sof foyda
    renderNetProfitChart(chartsData.netProfit[mode]);
    
    // 8. To'liq sherik daromadi
    renderPartnerRevenueChart(chartsData.partnerRevenue[mode]);
    
    // 9. Realization shartnomalar
    renderRealizationContractsChart(chartsData.realizationContracts[mode]);
    
    // 10. Loyihalar bo'yicha daromad
    renderRevenueByProjectChart(chartsData.revenueByProject);
}

/**
 * Sonlarni formatlash (mln UZS)
 */
function formatCurrency(value) {
    return (value / 1000000).toLocaleString() + ' mln';
}

/**
 * Grafikni qayta render qilish helper
 */
function recreateChart(elementId, options) {
    const element = document.getElementById(elementId);
    if (!element) return null;
    
    if (chartInstances[elementId]) {
        chartInstances[elementId].destroy();
    }
    
    chartInstances[elementId] = new ApexCharts(element, options);
    chartInstances[elementId].render();
    return chartInstances[elementId];
}

/**
 * Dashboard rejimini o'zgartirish (monthly/daily)
 */
function switchChartMode(mode) {
    currentMode = mode;
    if (dashboardData) {
        renderAllCharts(dashboardData);
        updateKPICards(dashboardData);
    }
}

/**
 * Sahifa yuklanganda
 */
document.addEventListener('DOMContentLoaded', async function() {
    console.log('Dashboard yuklanmoqda...');
    
    // Ma'lumotlarni yuklash
    dashboardData = await loadDashboardData();
    
    // KPI va grafiklarni yangilash
    updateKPICards(dashboardData);
    renderAllCharts(dashboardData);
    
    console.log('Dashboard tayyor!');
});

// Global funksiyalarni export qilish
window.switchChartMode = switchChartMode;
window.dashboardData = dashboardData;