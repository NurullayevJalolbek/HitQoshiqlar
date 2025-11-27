/**
 * Dashboard Charts Configuration - Multilingual Version
 * Grafiklarni render qilish va yangilash
 */

// Tarjimalarni olish va tekshirish
const trans = window.dashboardTranslations || {};

// Oylarni to'g'ri formatda olish
const months = (() => {
    if (trans.months && typeof trans.months === 'object') {
        // Agar object bo'lsa, array ga o'giramiz
        return Object.values(trans.months);
    }
    // Default qiymat
    return ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
})();

// Chart instance'larini saqlash
const chartInstances = {};

// 1. Investorlar O'sish Grafikasi
function renderInvestorsChart(activeData, passiveData) {
    const chartElement = document.querySelector("#investorsChart");
    if (!chartElement) return;
    
    // Eski chartni o'chirish
    if (chartInstances.investors) {
        chartInstances.investors.destroy();
    }
    
    const options = {
        series: [{
            name: trans.charts?.active_investors || 'Active Investors',
            data: activeData || [320, 385, 412, 468, 521, 587, 642, 698, 745, 812, 878, 945]
        }, {
            name: trans.charts?.passive_investors || 'Passive Investors',
            data: passiveData || [98, 112, 128, 145, 162, 178, 195, 210, 228, 245, 262, 280]
        }],
        chart: {
            type: 'area',
            height: 350,
            toolbar: { 
                show: true,
                tools: {
                    download: true,
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                    reset: true
                }
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
            }
        },
        dataLabels: { enabled: false },
        stroke: { 
            curve: 'smooth', 
            width: 2 
        },
        xaxis: {
            categories: [...months] // Array nusxasini yaratamiz
        },
        colors: ['#3b82f6', '#f59e0b'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.1,
                stops: [0, 90, 100]
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
    
    chartInstances.investors = new ApexCharts(chartElement, options);
    chartInstances.investors.render();
}

function renderProjectsDonutChart() {
    const chartElement = document.querySelector("#projectsDonutChart");
    if (!chartElement) return;
    
    if (chartInstances.projects) {
        chartInstances.projects.destroy();
    }
    
    const options = {
        series: [35, 32, 33], // 3 ta kategoriya uchun
        chart: {
            type: 'donut',
            height: 300
        },
        labels: [
            trans.projectTypes?.land || 'Land',
            trans.projectTypes?.rent || 'Rent',
            trans.projectTypes?.construction || 'Construction'
        ],
        colors: ['#10b981', '#f59e0b', '#3b82f6'], // 3 ta rang
        legend: { 
            position: 'bottom',
            fontSize: '14px'
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
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
                            formatter: function () {
                                return '68'
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

// 3. Tushumlar Grafikasi
function renderRevenueChart(data) {
    const chartElement = document.querySelector("#revenueChart");
    if (!chartElement) return;
    
    if (chartInstances.revenue) {
        chartInstances.revenue.destroy();
    }
    
    const options = {
        series: [{
            name: trans.charts?.revenue_label || 'Revenue',
            data: data || [1200, 1450, 1680, 1920, 2150, 2480, 2720, 2950, 3180, 3420, 3650, 3890]
        }],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: true }
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
            categories: [...months] // Array nusxasini yaratamiz
        },
        yaxis: {
            title: {
                text: (trans.charts?.revenue_label || 'Revenue') + ' ($1000)'
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return "$" + val + "K"
                }
            }
        }
    };
    
    chartInstances.revenue = new ApexCharts(chartElement, options);
    chartInstances.revenue.render();
}

// 4. Chiqish To'lovlari Grafikasi
function renderPaymentsChart(data) {
    const chartElement = document.querySelector("#paymentsChart");
    if (!chartElement) return;
    
    if (chartInstances.payments) {
        chartInstances.payments.destroy();
    }
    
    const options = {
        series: [{
            name: trans.charts?.payments_label || 'Payments',
            data: data || [280, 320, 360, 410, 450, 490, 530, 570, 610, 650, 690, 730]
        }],
        chart: {
            type: 'line',
            height: 300,
            toolbar: { show: true }
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
            categories: [...months] // Array nusxasini yaratamiz
        },
        yaxis: {
            title: {
                text: (trans.charts?.payments_label || 'Payments') + ' ($1000)'
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return "$" + val + "K"
                }
            }
        }
    };
    
    chartInstances.payments = new ApexCharts(chartElement, options);
    chartInstances.payments.render();
}

// 5. Shartnoma Daromadlari Grafikasi
function renderContractRevenueChart(data) {
    const chartElement = document.querySelector("#contractRevenueChart");
    if (!chartElement) return;
    
    if (chartInstances.contractRevenue) {
        chartInstances.contractRevenue.destroy();
    }
    
    const options = {
        series: [{
            name: trans.charts?.avg_revenue || 'Revenue',
            data: data || [850, 920, 1050, 1180, 1320, 1450, 1580, 1720, 1850, 1980, 2110, 2250]
        }],
        chart: {
            type: 'area',
            height: 300,
            toolbar: { show: true }
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
            categories: [...months] // Array nusxasini yaratamiz
        },
        yaxis: {
            title: {
                text: (trans.charts?.avg_revenue || 'Revenue') + ' ($1000)'
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return "$" + val + "K"
                }
            }
        }
    };
    
    chartInstances.contractRevenue = new ApexCharts(chartElement, options);
    chartInstances.contractRevenue.render();
}

// 6. Dividendlar Grafikasi
function renderDividendsChart() {
    const chartElement = document.querySelector("#dividendsChart");
    if (!chartElement) return;
    
    if (chartInstances.dividends) {
        chartInstances.dividends.destroy();
    }
    
    const options = {
        series: [65, 35],
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
            formatter: function (val) {
                return Math.round(val) + "%"
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + "%"
                }
            }
        }
    };
    
    chartInstances.dividends = new ApexCharts(chartElement, options);
    chartInstances.dividends.render();
}

// 7. Sof Foyda Grafikasi
function renderProfitChart(data) {
    const chartElement = document.querySelector("#profitChart");
    if (!chartElement) return;
    
    if (chartInstances.profit) {
        chartInstances.profit.destroy();
    }
    
    const options = {
        series: [{
            name: trans.charts?.profit_label || 'Profit',
            data: data || [420, 480, 540, 610, 680, 750, 820, 890, 960, 1030, 1100, 1170]
        }],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: true }
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
            categories: [...months] // Array nusxasini yaratamiz
        },
        yaxis: {
            title: {
                text: (trans.charts?.profit_label || 'Profit') + ' ($1000)'
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return "$" + val + "K"
                }
            }
        }
    };
    
    chartInstances.profit = new ApexCharts(chartElement, options);
    chartInstances.profit.render();
}

// 8. Shartnomalar Grafikasi
function renderContractsChart(data) {
    const chartElement = document.querySelector("#contractsChart");
    if (!chartElement) return;
    
    if (chartInstances.contracts) {
        chartInstances.contracts.destroy();
    }
    
    const options = {
        series: [{
            name: trans.charts?.contracts_label || 'Contracts',
            data: data || [12, 15, 18, 22, 25, 28, 32, 35, 38, 42, 45, 48]
        }],
        chart: {
            type: 'line',
            height: 300,
            toolbar: { show: true }
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
            categories: [...months] // Array nusxasini yaratamiz
        },
        yaxis: {
            title: {
                text: trans.charts?.total_contracts || 'Contracts'
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " " + (trans.charts?.contracts || 'contracts')
                }
            }
        }
    };
    
    chartInstances.contracts = new ApexCharts(chartElement, options);
    chartInstances.contracts.render();
}

// 9. Hujjatlar Dinamikasi Grafikasi
function renderDocumentsChart(data) {
    const chartElement = document.querySelector("#documentsChart");
    if (!chartElement) return;
    
    if (chartInstances.documents) {
        chartInstances.documents.destroy();
    }
    
    const options = {
        series: [{
            name: trans.messages?.documents || 'Documents',
            data: data || [45, 52, 58, 65, 72, 80, 88, 95, 103, 112, 120, 128]
        }],
        chart: {
            type: 'area',
            height: 300,
            toolbar: { show: true }
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
            categories: [...months] // Array nusxasini yaratamiz
        },
        yaxis: {
            title: {
                text: trans.messages?.documents || 'Documents'
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " " + (trans.messages?.documents || 'documents')
                }
            }
        }
    };
    
    chartInstances.documents = new ApexCharts(chartElement, options);
    chartInstances.documents.render();
}

function renderRevenueByProjectChart() {
    const chartElement = document.querySelector("#revenueByProjectChart");
    if (!chartElement) return;
    
    if (chartInstances.revenueByProject) {
        chartInstances.revenueByProject.destroy();
    }
    
    const options = {
        series: [{
            name: trans.charts?.revenue_label || 'Revenue',
            data: [850, 720, 680] // 3 ta qiymat
        }],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: true }
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
                return "$" + val + "K"
            },
            offsetX: 30
        },
        xaxis: {
            categories: [
                trans.projectTypes?.land || 'Land',
                trans.projectTypes?.rent || 'Rent',
                trans.projectTypes?.construction || 'Construction'
            ]
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return "$" + val + "K"
                }
            }
        }
    };
    
    chartInstances.revenueByProject = new ApexCharts(chartElement, options);
    chartInstances.revenueByProject.render();
}

// Barcha grafiklarni yuklash
function initializeAllCharts() {
    // Tarjimalar to'liq yuklanganini tekshiramiz
    if (!window.dashboardTranslations) {
        console.error('Dashboard translations not loaded!');
        return;
    }
    
    console.log('Initializing charts with translations:', window.dashboardTranslations);
    
    renderInvestorsChart();
    renderProjectsDonutChart();
    renderRevenueChart();
    renderPaymentsChart();
    renderContractRevenueChart();
    renderDividendsChart();
    renderProfitChart();
    renderContractsChart();
    renderDocumentsChart();
    renderRevenueByProjectChart();
}

// Grafiklarni yangilash funksiyasi
window.updateCharts = function(data) {
    console.log('Grafiklar yangilanmoqda...', data);
    
    if (data.investors) {
        renderInvestorsChart(data.investors.active, data.investors.passive);
    }
    
    if (data.revenue) {
        renderRevenueChart(data.revenue);
    }
    
    if (data.payments) {
        renderPaymentsChart(data.payments);
    }
    
    if (data.contractRevenue) {
        renderContractRevenueChart(data.contractRevenue);
    }
    
    if (data.profit) {
        renderProfitChart(data.profit);
    }
    
    if (data.contracts) {
        renderContractsChart(data.contracts);
    }
    
    if (data.documents) {
        renderDocumentsChart(data.documents);
    }
};

// Til o'zgarganda grafiklarni qayta yuklash
window.reloadChartsWithLanguage = function() {
    console.log('Grafiklar tili o\'zgardi, qayta yuklanmoqda...');
    initializeAllCharts();
};

// DOM yuklangandan keyin chartlarni ishga tushirish
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing charts...');
    initializeAllCharts();
});

if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        renderInvestorsChart,
        renderProjectsDonutChart,
        renderRevenueChart,
        renderPaymentsChart,
        renderContractRevenueChart,
        renderDividendsChart,
        renderProfitChart,
        renderContractsChart,
        renderDocumentsChart,
        renderRevenueByProjectChart,
        initializeAllCharts
    };
}