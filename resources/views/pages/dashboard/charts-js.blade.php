<script src="{{ asset('assets/js/dashboard-functions.js') }}"></script>
<script>
    /** ------------------------------------------------ CHART JS ---------------------------------------------------------------------------------*/
    /**
     * Dashboard Charts Configuration - Multilingual Version
     * Grafiklarni render qilish va yangilash
     */
    const trans = window.dashboardTranslations || {};
    const months = (() => {
        if (trans.months && typeof trans.months === 'object') {
            return Object.values(trans.months);
        }
        return ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    })();
    const chartData = {
        monthly: {
            categories: months,
            investors: {
                active: [320, 385, 412, 468, 521, 587, 642, 698, 745, 812, 878, 945],
                passive: [98, 112, 128, 145, 162, 178, 195, 210, 228, 245, 262, 280]
            },
            revenue: [1200, 1450, 1680, 1920, 2150, 2480, 2720, 2950, 3180, 3420, 3650, 3890],
            payments: [280, 320, 360, 410, 450, 490, 530, 570, 610, 650, 690, 730],
            contractRevenue: [850, 920, 1050, 1180, 1320, 1450, 1580, 1720, 1850, 1980, 2110, 2250],
            profit: [420, 480, 540, 610, 680, 750, 820, 890, 960, 1030, 1100, 1170],
            contracts: [12, 15, 18, 22, 25, 28, 32, 35, 38, 42, 45, 48],
            documents: [45, 52, 58, 65, 72, 80, 88, 95, 103, 112, 120, 128]
        },
        daily: {
            categories: ['Nov 3', 'Nov 4', 'Nov 5', 'Nov 6', 'Nov 7', 'Nov 8', 'Nov 9', 'Nov 10', 'Nov 11',
                'Nov 12', 'Nov 13', 'Nov 14', 'Nov 15', 'Nov 16', 'Nov 17', 'Nov 18', 'Nov 19', 'Nov 20',
                'Nov 21', 'Nov 22', 'Nov 23', 'Nov 24', 'Nov 25', 'Nov 26', 'Nov 27', 'Nov 28', 'Nov 29',
                'Nov 30', 'Dec 1', 'Dec 2'
            ],
            investors: {
                active: [819, 821, 823, 825, 827, 830, 832, 834, 836, 838, 841, 843, 845, 847, 849, 852, 854, 856,
                    858, 860, 863, 865, 867, 869, 871, 874, 876, 878, 880, 882
                ],
                passive: [247, 247, 248, 248, 249, 250, 250, 251, 251, 252, 252, 253, 254, 254, 255, 255, 256, 256,
                    257, 257, 258, 259, 259, 260, 260, 261, 261, 262, 263, 263
                ]
            },
            revenue: [122, 122, 122, 122, 122, 122, 122, 122, 122, 122, 122, 122, 122, 122, 122, 122, 122, 122, 122,
                122, 122, 122, 122, 122, 122, 122, 122, 122, 125, 125
            ],
            payments: [23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23, 23,
                23, 23, 23, 23, 23, 24, 24
            ],
            contractRevenue: [1993, 1997, 2002, 2006, 2010, 2015, 2019, 2023, 2028, 2032, 2036, 2041, 2045, 2049,
                2054, 2058, 2062, 2067, 2071, 2075, 2080, 2084, 2088, 2093, 2097, 2101, 2106, 2110, 2115, 2119
            ],
            profit: [37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37, 37,
                37, 37, 37, 37, 38, 38
            ],
            contracts: [42, 42, 42, 43, 43, 43, 43, 43, 43, 43, 43, 43, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44, 44,
                45, 45, 45, 45, 45, 45, 45
            ],
            documents: [113, 113, 113, 114, 114, 114, 114, 115, 115, 115, 115, 116, 116, 116, 117, 117, 117, 117,
                118, 118, 118, 118, 119, 119, 119, 119, 120, 120, 120, 121
            ]
        }
    };
    const chartInstances = {};

    function renderInvestorsChart(activeData, passiveData) {
        const chartElement = document.querySelector("#investorsChart");
        if (!chartElement) return;

        if (chartInstances.investors) {
            chartInstances.investors.destroy();
        }

        const mode = window.chartMode || 'monthly';
        const categories = chartData[mode].categories;
        if (!activeData) activeData = chartData[mode].investors.active;
        if (!passiveData) passiveData = chartData[mode].investors.passive;

        const options = {
            series: [{
                name: trans.charts?.active_investors || 'Active Investors',
                data: activeData
            }, {
                name: trans.charts?.passive_investors || 'Passive Investors',
                data: passiveData
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
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: categories
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
            series: [35, 32, 33],
            chart: {
                type: 'donut',
                height: 300
            },
            labels: [
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
                                formatter: function() {
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

    function renderRevenueChart(data) {
        const chartElement = document.querySelector("#revenueChart");
        if (!chartElement) return;

        if (chartInstances.revenue) {
            chartInstances.revenue.destroy();
        }

        const mode = window.chartMode || 'monthly';
        const categories = chartData[mode].categories;
        if (!data) data = chartData[mode].revenue;

        const options = {
            series: [{
                name: trans.charts?.revenue_label || 'Revenue',
                data: data
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
                categories: categories
            },
            yaxis: {
                title: {
                    text: (trans.charts?.revenue_label || 'Revenue') + (mode === 'daily' ? ' Daily' : '') +
                        ' ($1000)'
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

    function renderPaymentsChart(data) {
        const chartElement = document.querySelector("#paymentsChart");
        if (!chartElement) return;

        if (chartInstances.payments) {
            chartInstances.payments.destroy();
        }

        const mode = window.chartMode || 'monthly';
        const categories = chartData[mode].categories;
        if (!data) data = chartData[mode].payments;

        const options = {
            series: [{
                name: trans.charts?.payments_label || 'Payments',
                data: data
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
                categories: categories
            },
            yaxis: {
                title: {
                    text: (trans.charts?.payments_label || 'Payments') + (mode === 'daily' ? ' Daily' : '') +
                        ' ($1000)'
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

    function renderContractRevenueChart(data) {
        const chartElement = document.querySelector("#contractRevenueChart");
        if (!chartElement) return;

        if (chartInstances.contractRevenue) {
            chartInstances.contractRevenue.destroy();
        }

        const mode = window.chartMode || 'monthly';
        const categories = chartData[mode].categories;
        if (!data) data = chartData[mode].contractRevenue;

        const options = {
            series: [{
                name: trans.charts?.avg_revenue || 'Revenue',
                data: data
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
                categories: categories
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
                formatter: function(val) {
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

    function renderProfitChart(data) {
        const chartElement = document.querySelector("#profitChart");
        if (!chartElement) return;

        if (chartInstances.profit) {
            chartInstances.profit.destroy();
        }

        const mode = window.chartMode || 'monthly';
        const categories = chartData[mode].categories;
        if (!data) data = chartData[mode].profit;

        const options = {
            series: [{
                name: trans.charts?.profit_label || 'Profit',
                data: data
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
                categories: categories
            },
            yaxis: {
                title: {
                    text: (trans.charts?.profit_label || 'Profit') + (mode === 'daily' ? ' Daily' : '') + ' ($1000)'
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

    function renderContractsChart(data) {
        const chartElement = document.querySelector("#contractsChart");
        if (!chartElement) return;

        if (chartInstances.contracts) {
            chartInstances.contracts.destroy();
        }

        const mode = window.chartMode || 'monthly';
        const categories = chartData[mode].categories;
        if (!data) data = chartData[mode].contracts;

        const options = {
            series: [{
                name: trans.charts?.contracts_label || 'Contracts',
                data: data
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
                categories: categories
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

    function renderDocumentsChart(data) {
        const chartElement = document.querySelector("#documentsChart");
        if (!chartElement) return;

        if (chartInstances.documents) {
            chartInstances.documents.destroy();
        }

        const mode = window.chartMode || 'monthly';
        const categories = chartData[mode].categories;
        if (!data) data = chartData[mode].documents;

        const options = {
            series: [{
                name: trans.messages?.documents || 'Documents',
                data: data
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
                categories: categories
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
                data: [850, 720, 680]
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

    function initializeAllCharts(mode = 'monthly') {
        if (!window.dashboardTranslations) {
            console.error('Dashboard translations not loaded!');
            return;
        }
        window.chartMode = mode;

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
    window.switchChartMode = function(mode) {
        initializeAllCharts(mode);
    };
    window.reloadChartsWithLanguage = function() {
        console.log('Grafiklar tili o\'zgardi, qayta yuklanmoqda...');
        initializeAllCharts(window.chartMode || 'monthly');
    };
    document.addEventListener('DOMContentLoaded', function() {
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
</script>
