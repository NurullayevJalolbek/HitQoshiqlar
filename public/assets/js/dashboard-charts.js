/**
 * Dashboard Charts Configuration - Dynamic Version
 * Grafiklarni render qilish va yangilash
 */

// Umumiy kategoriyalar (oylar)
const months = window.dashboardTranslations?.months || [
    'Yan', 'Fev', 'Mar', 'Apr', 'May', 'Iyun', 'Iyul', 'Avg', 'Sen', 'Okt', 'Noy', 'Dek'
];

// Tarjimalar
const trans = window.dashboardTranslations?.charts || {};

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
            name: trans.active_investors || 'Aktiv Investorlar',
            data: activeData || [320, 385, 412, 468, 521, 587, 642, 698, 745, 812, 878, 945]
        }, {
            name: trans.passive_investors || 'Passiv Investorlar',
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
            categories: months
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

// 2. Loyihalar Donut Chart
function renderProjectsDonutChart() {
    const chartElement = document.querySelector("#projectsDonutChart");
    if (!chartElement) return;
    
    if (chartInstances.projects) {
        chartInstances.projects.destroy();
    }
    
    const options = {
        series: [28, 22, 18, 32],
        chart: {
            type: 'donut',
            height: 300
        },
        labels: ['Texnologiya', 'Ko\'chmas mulk', 'Qishloq xo\'jaligi', 'Ishlab chiqarish'],
        colors: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6'],
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
                            label: 'Jami',
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
            name: trans.revenue_label || 'Tushumlar',
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
            categories: months
        },
        yaxis: {
            title: {
                text: 'Tushumlar ($1000)'
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
            name: trans.payments_label || 'To\'lovlar',
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
            categories: months
        },
        yaxis: {
            title: {
                text: 'To\'lovlar ($1000)'
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
            name: 'Daromad',
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
            categories: months
        },
        yaxis: {
            title: {
                text: 'Daromad ($1000)'
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
        labels: ['To\'langan', 'Kutilmoqda'],
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
            name: trans.profit_label || 'Foyda',
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
            categories: months
        },
        yaxis: {
            title: {
                text: 'Foyda ($1000)'
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
            name: trans.contracts_label || 'Shartnomalar',
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
            categories: months
        },
        yaxis: {
            title: {
                text: 'Shartnomalar Soni'
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " ta"
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
            name: 'Hujjatlar',
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
            categories: months
        },
        yaxis: {
            title: {
                text: 'Hujjatlar Soni'
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " ta"
                }
            }
        }
    };
    
    chartInstances.documents = new ApexCharts(chartElement, options);
    chartInstances.documents.render();
}

// 10. Loyihalar bo'yicha Daromad Grafikasi
function renderRevenueByProjectChart() {
    const chartElement = document.querySelector("#revenueByProjectChart");
    if (!chartElement) return;
    
    if (chartInstances.revenueByProject) {
        chartInstances.revenueByProject.destroy();
    }
    
    const options = {
        series: [{
            name: 'Daromad',
            data: [850, 720, 650, 580]
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
            categories: ['Texnologiya', 'Ko\'chmas mulk', 'Qishloq xo\'jaligi', 'Ishlab chiqarish']
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

// Sahifa yuklanganda
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard charts yuklandi');
    initializeAllCharts();
});

// Export
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