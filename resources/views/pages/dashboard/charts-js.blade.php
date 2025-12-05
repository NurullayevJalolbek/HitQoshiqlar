<script>
    /** ------------------------------------------------ CHART JS ---------------------------------------------------------------------------------*/
    /**
     * Dashboard Charts Configuration - Multilingual Version with API Integration
     * Grafiklarni render qilish va API dan ma'lumotlarni olish
     */
    const trans = window.dashboardTranslations || {};
    const months = (() => {
        if (trans.months && typeof trans.months === 'object') {
            return Object.values(trans.months);
        }
        return ['Yanvar', 'Fevral', 'Mart', 'Aprel', 'May', 'Iyun', 'Iyul', 'Avgust', 'Sentabr', 'Oktabr',
            'Noyabr', 'Dekabr'
        ];
    })();

    const chartInstances = {};
    let apiData = null; // Global API data storage

    // ============= API INTEGRATION =============
    /**
     * API dan ma'lumotlarni olish funksiyasi
     */
    async function fetchDashboardData() {
        try {
            const response = await fetch('http://localhost:8000/api/dashboard');
            if (!response.ok) {
                throw new Error('API javob bermadi');
            }
            const data = await response.json();
            apiData = data.result;
            console.log('✅ API ma\'lumotlari muvaffaqiyatli yuklandi:', apiData);
            return apiData;
        } catch (error) {
            console.error('❌ API ma\'lumotlarini yuklashda xato:', error);
            return null;
        }
    }

    /**
     * Ma'lumotlarni formatlash funksiyasi
     */
    function formatNumber(num) {
        if (!num) return '0';
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    }

    // ============= CHART RENDER FUNCTIONS =============

    /**
     * 1. Investorlar grafigi (Traffic Volumes Chart)
     */
    function renderInvestorsChart(activeData, passiveData, categories) {
        const chartElement = document.querySelector("#traffic-volumes-chart");
        if (!chartElement) return;

        if (chartInstances.investors) {
            chartInstances.investors.destroy();
        }

        const mode = window.chartMode || 'monthly';

        // API dan ma'lumotlarni olish
        if (apiData && apiData.charts && apiData.charts.investorsGrowth) {
            const investorData = apiData.charts.investorsGrowth[mode];
            activeData = investorData.active;
            passiveData = investorData.passive;
            categories = investorData.categories;
        }

        const options = {
            series: [{
                name: trans.charts?.active_investors || 'Faol Investorlar',
                data: activeData
            }, {
                name: trans.charts?.passive_investors || 'Passiv Investorlar',
                data: passiveData
            }],
            chart: {
                type: 'area',
                height: 350,
                fontFamily: 'Inter',
                foreColor: '#f2f2f2',
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
                categories: categories || months
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

        // Legend raqamlarini yangilash
        updateInvestorLegend(activeData, passiveData);
    }

    function updateInvestorLegend(activeData, passiveData) {
        if (!activeData || !passiveData) return;

        const activeCount = activeData[activeData.length - 1];
        const passiveCount = passiveData[passiveData.length - 1];

        const legends = document.querySelectorAll('.lh-130');
        if (legends.length >= 2) {
            legends[0].querySelector('.text-dark').textContent = activeCount;
            legends[1].querySelector('.text-dark').textContent = passiveCount;
        }
    }

    /**
     * 2. Tushumlar grafigi (Investor Income)
     */
    function renderRevenueChart(data, categories) {
        const chartElement = document.querySelector("#revenueChart");
        if (!chartElement) return;

        if (chartInstances.revenue) {
            chartInstances.revenue.destroy();
        }

        const mode = window.chartMode || 'monthly';

        // API dan ma'lumotlarni olish
        if (apiData && apiData.charts && apiData.charts.investorIncome) {
            const incomeData = apiData.charts.investorIncome[mode];
            data = incomeData.data;
            categories = incomeData.categories;
        }

        const options = {
            series: [{
                name: trans.charts?.investor_income || 'Investorlar Tushumlar',
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
                categories: categories || months
            },
            yaxis: {
                title: {
                    text: 'UZS (ming)'
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return formatNumber(val) + " ming UZS"
                    }
                }
            }
        };

        chartInstances.revenue = new ApexCharts(chartElement, options);
        chartInstances.revenue.render();

        // O'rtacha qiymatni yangilash
        if (data && data.length > 0) {
            const avg = Math.round(data.reduce((a, b) => a + b, 0) / data.length);
            const avgElement = document.querySelector('#revenueChart').closest('.chart-container').querySelector(
                'strong');
            if (avgElement) {
                avgElement.textContent = formatNumber(avg) + ' UZS';
            }
        }
    }

    /**
     * 3. To'lovlar grafigi (Exit Payments)
     */
    function renderPaymentsChart(data, categories) {
        const chartElement = document.querySelector("#paymentsChart");
        if (!chartElement) return;

        if (chartInstances.payments) {
            chartInstances.payments.destroy();
        }

        const mode = window.chartMode || 'monthly';

        // API dan ma'lumotlarni olish
        if (apiData && apiData.charts && apiData.charts.exitPayments) {
            const paymentsData = apiData.charts.exitPayments[mode];
            data = paymentsData.data;
            categories = paymentsData.categories;
        }

        const options = {
            series: [{
                name: trans.charts?.exit_payments || 'Chiqim To\'lovlari',
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
                categories: categories || months
            },
            yaxis: {
                title: {
                    text: 'UZS (ming)'
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return formatNumber(val) + " ming UZS"
                    }
                }
            }
        };

        chartInstances.payments = new ApexCharts(chartElement, options);
        chartInstances.payments.render();

        // O'rtacha qiymatni yangilash
        if (data && data.length > 0) {
            const avg = Math.round(data.reduce((a, b) => a + b, 0) / data.length);
            const avgElement = document.querySelector('#paymentsChart').closest('.chart-container').querySelector(
                'strong');
            if (avgElement) {
                avgElement.textContent = formatNumber(avg) + ' UZS';
            }
        }
    }

    /**
     * 4. Shartnoma daromadi grafigi (Contract Revenue)
     */
    function renderContractRevenueChart(data, categories) {
        const chartElement = document.querySelector("#contractRevenueChart");
        if (!chartElement) return;

        if (chartInstances.contractRevenue) {
            chartInstances.contractRevenue.destroy();
        }

        const mode = window.chartMode || 'monthly';

        // API dan ma'lumotlarni olish
        if (apiData && apiData.charts && apiData.charts.contractRevenue) {
            const contractData = apiData.charts.contractRevenue[mode];
            data = contractData.data;
            categories = contractData.categories;

            // Statistikalarni yangilash
            if (apiData.charts.contractRevenue.stats) {
                const stats = apiData.charts.contractRevenue.stats;
                const statsContainer = document.querySelector('#contractRevenueChart').closest('.chart-container')
                    .querySelector('.row.text-center');
                if (statsContainer) {
                    const cols = statsContainer.querySelectorAll('.col-4 strong');
                    if (cols.length >= 3) {
                        cols[0].textContent = stats.totalContracts;
                        cols[1].textContent = stats.avgRevenueFormatted + ' UZS';
                        cols[2].textContent = '+' + stats.growth + '%';
                    }
                }
            }
        }

        const options = {
            series: [{
                name: trans.charts?.contract_revenue || 'Shartnoma Daromadi',
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
                categories: categories || months
            },
            yaxis: {
                title: {
                    text: 'UZS (ming)'
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return formatNumber(val) + " ming UZS"
                    }
                }
            }
        };

        chartInstances.contractRevenue = new ApexCharts(chartElement, options);
        chartInstances.contractRevenue.render();
    }

    /**
     * 5. Dividendlar grafigi
     */
    function renderDividendsChart() {
        const chartElement = document.querySelector("#dividendsChart");
        if (!chartElement) return;

        if (chartInstances.dividends) {
            chartInstances.dividends.destroy();
        }

        let paidPercent = 65;
        let pendingPercent = 35;

        // API dan ma'lumotlarni olish
        if (apiData && apiData.charts && apiData.charts.dividendsDistribution) {
            paidPercent = apiData.charts.dividendsDistribution.paid;
            pendingPercent = apiData.charts.dividendsDistribution.pending;

            // Foizlarni yangilash
            const container = document.querySelector('#dividendsChart').closest('.chart-container');
            const percentages = container.querySelectorAll('.row .col-6 strong');
            if (percentages.length >= 2) {
                percentages[0].textContent = paidPercent + '%';
                percentages[1].textContent = pendingPercent + '%';
            }
        }

        const options = {
            series: [paidPercent, pendingPercent],
            chart: {
                type: 'pie',
                height: 300
            },
            labels: [
                trans.charts?.paid || 'To\'langan',
                trans.charts?.pending || 'Kutilmoqda'
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

    /**
     * 6. Sof foyda grafigi (Net Profit)
     */
    function renderProfitChart(data, categories) {
        const chartElement = document.querySelector("#profitChart");
        if (!chartElement) return;

        if (chartInstances.profit) {
            chartInstances.profit.destroy();
        }

        const mode = window.chartMode || 'monthly';

        // API dan ma'lumotlarni olish
        if (apiData && apiData.charts && apiData.charts.netProfit) {
            const profitData = apiData.charts.netProfit[mode];
            data = profitData.data;
            categories = profitData.categories;

            // O'rtacha foyda yangilash
            if (apiData.charts.netProfit.avgProfit) {
                const avgElement = document.querySelector('#profitChart').closest('.chart-container').querySelector(
                    'strong');
                if (avgElement) {
                    avgElement.textContent = apiData.charts.netProfit.avgProfitFormatted + ' UZS';
                }
            }
        }

        const options = {
            series: [{
                name: trans.charts?.net_profit || 'Sof Foyda',
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
                categories: categories || months
            },
            yaxis: {
                title: {
                    text: 'UZS (ming)'
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return formatNumber(val) + " ming UZS"
                    }
                }
            }
        };

        chartInstances.profit = new ApexCharts(chartElement, options);
        chartInstances.profit.render();
    }

    /**
     * 7. Shartnomalar grafigi (Realization Contracts)
     */
    function renderContractsChart(data, categories) {
        const chartElement = document.querySelector("#contractsChart");
        if (!chartElement) return;

        if (chartInstances.contracts) {
            chartInstances.contracts.destroy();
        }

        const mode = window.chartMode || 'monthly';

        // API dan ma'lumotlarni olish
        if (apiData && apiData.charts && apiData.charts.realizationContracts) {
            const contractsData = apiData.charts.realizationContracts[mode];
            data = contractsData.data;
            categories = contractsData.categories;

            // Jami imzolangan shartnomalar
            if (apiData.charts.realizationContracts.totalSigned) {
                const totalElement = document.querySelector('#contractsChart').closest('.chart-container')
                    .querySelector('strong');
                if (totalElement) {
                    totalElement.textContent = apiData.charts.realizationContracts.totalSigned + ' ' + (trans.charts
                        ?.contracts || 'shartnoma');
                }
            }
        }

        const options = {
            series: [{
                name: trans.charts?.realization_contracts || 'Shartnomalar',
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
                categories: categories || months
            },
            yaxis: {
                title: {
                    text: trans.charts?.total_contracts || 'Shartnomalar'
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " " + (trans.charts?.contracts || 'shartnoma')
                    }
                }
            }
        };

        chartInstances.contracts = new ApexCharts(chartElement, options);
        chartInstances.contracts.render();
    }

    /**
     * 8. Hujjatlar grafigi (Documents Growth)
     */
    function renderDocumentsChart(data, categories) {
        const chartElement = document.querySelector("#documentsChart");
        if (!chartElement) return;

        if (chartInstances.documents) {
            chartInstances.documents.destroy();
        }

        const mode = window.chartMode || 'monthly';

        // API dan ma'lumotlarni olish
        if (apiData && apiData.charts && apiData.charts.documentsGrowth) {
            const docsData = apiData.charts.documentsGrowth[mode];
            data = docsData.data;
            categories = docsData.categories;
        }

        const options = {
            series: [{
                name: trans.messages?.documents || 'Hujjatlar',
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
                categories: categories || months
            },
            yaxis: {
                title: {
                    text: trans.messages?.documents || 'Hujjatlar'
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " " + (trans.messages?.documents || 'hujjat')
                    }
                }
            }
        };

        chartInstances.documents = new ApexCharts(chartElement, options);
        chartInstances.documents.render();
    }

    /**
     * 9. Loyihalar bo'yicha Investorlar (Donut Chart)
     */
    function renderProjectsDonutChart() {
        const chartElement = document.querySelector("#projectsDonutChart");
        if (!chartElement) return;

        if (chartInstances.projects) {
            chartInstances.projects.destroy();
        }

        let seriesData = [35, 32, 33];
        let categories = [
            trans.projectTypes?.land || 'Yer',
            trans.projectTypes?.rent || 'Ijara',
            trans.projectTypes?.construction || 'Qurilish'
        ];

        // API dan ma'lumotlarni olish
        if (apiData && apiData.charts && apiData.charts.investorShareByProject) {
            seriesData = apiData.charts.investorShareByProject.data;
            categories = apiData.charts.investorShareByProject.categories;
        }

        const options = {
            series: seriesData,
            chart: {
                type: 'donut',
                height: 300
            },
            labels: categories,
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
                                label: trans.charts?.total_projects || 'Jami',
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

    /**
     * 10. Loyihalar bo'yicha Daromad (Revenue by Project)
     */
    /**
     * 10. Loyihalar bo'yicha Daromad (Revenue by Project)
     */
    function renderRevenueByProjectChart() {

        const chartElement = document.querySelector("#revenueByProjectChart");
        if (!chartElement) {
            console.error("revenueByProjectChart elementi topilmadi");
            return;
        }

        // chartInstances mavjud bo‘lmasa yaratib olamiz
        if (typeof chartInstances === "undefined") {
            window.chartInstances = {};
        }

        // Eski chartni o‘chiramiz
        if (chartInstances.revenueByProject) {
            chartInstances.revenueByProject.destroy();
            chartInstances.revenueByProject = null;
        }

        // ✅ Default qiymatlar (fallback)
        let dataValues = [150000, 134000, 172678];
        let categories = [
            trans?.projectTypes?.land || "Yer",
            trans?.projectTypes?.rent || "Ijara",
            trans?.projectTypes?.construction || "Qurilish"
        ];

        // ✅ API dan xavfsiz tarzda olish
        if (
            typeof apiData !== "undefined" &&
            apiData?.charts?.revenueByProject &&
            Array.isArray(apiData.charts.revenueByProject.dataK) &&
            apiData.charts.revenueByProject.dataK.length > 0
        ) {
            dataValues = apiData.charts.revenueByProject.dataK;
            categories = apiData.charts.revenueByProject.categories;
        } else {
            console.warn("RevenueByProject API ma'lumotlari topilmadi, fallback ishladi");
        }

        const options = {
            series: [{
                name: trans?.charts?.revenue_label || "Daromad",
                data: dataValues
            }],

            chart: {
                type: "bar",
                height: 320,
                toolbar: {
                    show: true
                },
                animations: {
                    enabled: true
                }
            },

            colors: ["#2563eb"],

            plotOptions: {
                bar: {
                    borderRadius: 10,
                    horizontal: true,
                    barHeight: "55%",
                    dataLabels: {
                        position: "center"
                    }
                }
            },

            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return formatNumber(val) + " ming";
                },
                style: {
                    fontSize: "12px",
                    fontWeight: "600",

                },
                offsetX: 12
            },

            xaxis: {
                categories: categories,
                labels: {
                    formatter: function(val) {
                        return formatNumber(val) + " k";
                    }
                }
            },

            tooltip: {
                y: {
                    formatter: function(val) {
                        return formatNumber(val) + " ming UZS";
                    }
                }
            },

            grid: {
                strokeDashArray: 4
            },

            responsive: [{
                breakpoint: 640,
                options: {
                    chart: {
                        height: 280
                    },
                    plotOptions: {
                        bar: {
                            barHeight: "65%"
                        }
                    }
                }
            }]
        };

        chartInstances.revenueByProject = new ApexCharts(chartElement, options);
        chartInstances.revenueByProject.render();
    }


    // ============= INITIALIZATION & UPDATE FUNCTIONS =============

    /**
     * Barcha grafiklarni boshlang'ich holatga keltirish
     */
    async function initializeAllCharts(mode = 'monthly') {
        if (!window.dashboardTranslations) {
            console.error('Dashboard translations not loaded!');
            return;
        }

        window.chartMode = mode;

        // API dan ma'lumotlarni olish
        if (!apiData) {
            await fetchDashboardData();
        }

        // Barcha grafiklarni render qilish
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

        console.log('✅ Barcha grafiklar yuklandi');
    }

    /**
     * Grafiklarni yangilash (eski versiya - backward compatibility)
     */
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

    /**
     * Chart mode o'zgartirish
     */
    window.switchChartMode = async function(mode) {
        window.chartMode = mode;
        console.log('📊 Chart mode o\'zgardi:', mode);

        // API dan yangi ma'lumotlarni olish
        await fetchDashboardData();

        // Barcha grafiklarni qayta render qilish
        initializeAllCharts(mode);
    };

    /**
     * Til o'zgarganda grafiklarni qayta yuklash
     */
    window.reloadChartsWithLanguage = function() {
        console.log('🌐 Grafiklar tili o\'zgardi, qayta yuklanmoqda...');
        initializeAllCharts(window.chartMode || 'monthly');
    };

    /**
     * Sahifa yuklanganda
     */
    document.addEventListener('DOMContentLoaded', async function() {
        console.log('📈 Dashboard yuklanmoqda...');

        // API dan ma'lumotlarni olish
        await fetchDashboardData();

        // Grafiklarni boshlang'ich holatga keltirish
        await initializeAllCharts();

        console.log('✅ Dashboard muvaffaqiyatli yuklandi!');
    });

    /**
     * Avtomatik yangilanish - har 5 daqiqada
     */
    setInterval(async () => {
        console.log('🔄 Avtomatik yangilanish...');
        await fetchDashboardData();
        await initializeAllCharts(window.chartMode || 'monthly');
        console.log('yangilandi harrom')
    }, 1); // 5 daqiqa

    // Export funksiyalar (agar kerak bo'lsa)
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
            initializeAllCharts,
            fetchDashboardData
        };
    }
</script>
