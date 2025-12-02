<script>
/**
 * Dashboard Functions - Clean Version
 * File: public/assets/js/dashboard-functions.js
 */

// Global variables
let currentFilters = {
    startDate: null,
    endDate: null,
    projectType: "",
    investorType: "",
    language: "uz",
};

// Translations
const translations = {
    uz: {
        reportTitle: "Investitsiya Dashboard Hisoboti",
        date: "Sana",
        period: "Davr",
        projectType: "Loyiha turi",
        investorType: "Investor turi",
        mainIndicators: "Asosiy Ko'rsatkichlar",
        totalInvestors: "Jami Investorlar",
        totalInvestment: "Umumiy Sarmoya",
        activeProjects: "Faol Loyihalar",
        totalRevenue: "Umumiy Daromad",
        indicator: "Ko'rsatkich",
        value: "Qiymat",
        trend: "Trend",
        pdfSuccess: "PDF muvaffaqiyatli yuklandi!",
        excelSuccess: "Excel muvaffaqiyatli yuklandi!",
        csvSuccess: "CSV muvaffaqiyatli yuklandi!",
        error: "Xatolik yuz berdi",
        selectDates: "Iltimos, sanalarni tanlang!",
        invalidDate:
            "Boshlanish sanasi tugash sanasidan katta bo'lishi mumkin emas!",
        filterSuccess: "Filtrlar muvaffaqiyatli qo'llanildi!",
        projectTypes: {
            tech: "Texnologiya",
            real_estate: "Ko'chmas mulk",
            agriculture: "Qishloq xo'jaligi",
            manufacturing: "Ishlab chiqarish",
        },
        investorTypes: {
            active: "Faol",
            passive: "Passiv",
            all: "Barchasi",
        },
        projectTypes: {
            land: "Yer",
            rent: "Ijara",
            construction: "Qurilish",
        },
    },
    ru: {
        reportTitle: "Отчет Инвестиционной Панели",
        date: "Дата",
        period: "Период",
        projectType: "Тип проекта",
        investorType: "Тип инвестора",
        mainIndicators: "Основные Показатели",
        totalInvestors: "Всего Инвесторов",
        totalInvestment: "Общие Инвестиции",
        activeProjects: "Активные Проекты",
        totalRevenue: "Общий Доход",
        indicator: "Показатель",
        value: "Значение",
        trend: "Тенденция",
        pdfSuccess: "PDF успешно загружен!",
        excelSuccess: "Excel успешно загружен!",
        csvSuccess: "CSV успешно загружен!",
        error: "Произошла ошибка",
        selectDates: "Пожалуйста, выберите даты!",
        invalidDate: "Дата начала не может быть больше даты окончания!",
        filterSuccess: "Фильтры успешно применены!",
        projectTypes: {
            tech: "Технологии",
            real_estate: "Недвижимость",
            agriculture: "Сельское хозяйство",
            manufacturing: "Производство",
        },
        investorTypes: {
            active: "Активный",
            passive: "Пассивный",
            all: "Все",
        },
        projectTypes: {
            land: "Земля",
            rent: "Аренда",
            construction: "Строительство",
        },
    },
    en: {
        reportTitle: "Investment Dashboard Report",
        date: "Date",
        period: "Period",
        projectType: "Project Type",
        investorType: "Investor Type",
        mainIndicators: "Key Performance Indicators",
        totalInvestors: "Total Investors",
        totalInvestment: "Total Investment",
        activeProjects: "Active Projects",
        totalRevenue: "Total Revenue",
        indicator: "Indicator",
        value: "Value",
        trend: "Trend",
        pdfSuccess: "PDF downloaded successfully!",
        excelSuccess: "Excel downloaded successfully!",
        csvSuccess: "CSV downloaded successfully!",
        error: "An error occurred",
        selectDates: "Please select dates!",
        invalidDate: "Start date cannot be greater than end date!",
        filterSuccess: "Filters applied successfully!",
        projectTypes: {
            tech: "Technology",
            real_estate: "Real Estate",
            agriculture: "Agriculture",
            manufacturing: "Manufacturing",
        },
        investorTypes: {
            active: "Active",
            passive: "Passive",
            all: "All",
        },
        projectTypes: {
            land: "Land",
            rent: "Rent",
            construction: "Construction",
        },
    },
    ar: {
        reportTitle: "تقرير لوحة المعلومات الاستثمارية",
        date: "التاريخ",
        period: "الفترة",
        projectType: "نوع المشروع",
        investorType: "نوع المستثمر",
        mainIndicators: "المؤشرات الرئيسية",
        totalInvestors: "إجمالي المستثمرين",
        totalInvestment: "إجمالي الاستثمار",
        activeProjects: "المشاريع النشطة",
        totalRevenue: "إجمالي الإيرادات",
        indicator: "المؤشر",
        value: "القيمة",
        trend: "الاتجاه",
        pdfSuccess: "تم تنزيل PDF بنجاح!",
        excelSuccess: "تم تنزيل Excel بنجاح!",
        csvSuccess: "تم تنزيل CSV بنجاح!",
        error: "حدث خطأ",
        selectDates: "الرجاء تحديد التواريخ!",
        invalidDate: "لا يمكن أن يكون تاريخ البدء أكبر من تاريخ الانتهاء!",
        filterSuccess: "تم تطبيق الفلاتر بنجاح!",
        projectTypes: {
            tech: "التكنولوجيا",
            real_estate: "العقارات",
            agriculture: "الزراعة",
            manufacturing: "التصنيع",
        },
        investorTypes: {
            active: "نشط",
            passive: "سلبي",
            all: "الكل",
        },
        projectTypes: {
            land: "الأرض",
            rent: "الإيجار",
            construction: "البناء",
        },
    },
};

// Translation function
function t(key, lang = "uz") {
    const keys = key.split(".");
    let value = translations[lang];

    for (const k of keys) {
        value = value?.[k];
    }

    return value || key;
}

// Export Modal
function exportData(format) {
    const modalHTML = `
        <div class="modal fade" id="exportModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Export ${format.toUpperCase()}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Tilni tanlang / Choose Language</label>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary" onclick="executeExport('${format}', 'uz')">
                                🇺🇿 O'zbek tili
                            </button>
                            <button class="btn btn-outline-primary" onclick="executeExport('${format}', 'ru')">
                                🇷🇺 Русский язык
                            </button>
                            <button class="btn btn-outline-primary" onclick="executeExport('${format}', 'en')">
                                🇬🇧 English
                            </button>
                            <button class="btn btn-outline-primary" onclick="executeExport('${format}', 'ar')">
                                🇸🇦 العربية
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    let existingModal = document.getElementById("exportModal");
    if (existingModal) existingModal.remove();

    document.body.insertAdjacentHTML("beforeend", modalHTML);
    const modal = new bootstrap.Modal(document.getElementById("exportModal"));
    modal.show();
}

// Execute Export
function executeExport(format, language) {
    const modal = bootstrap.Modal.getInstance(
        document.getElementById("exportModal")
    );
    if (modal) modal.hide();

    Swal.fire({
        title: "Yuklanmoqda...",
        text: "Ma'lumotlar tayyorlanmoqda",
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading(),
    });

    const filters = {
        startDate: document.getElementById("startDate")?.value || "",
        endDate: document.getElementById("endDate")?.value || "",
        projectType: document.getElementById("projectType")?.value || "",
        investorType: document.getElementById("investorType")?.value || "",
        language: language,
    };

    setTimeout(() => {
        try {
            switch (format.toLowerCase()) {
                case "pdf":
                    exportToPDF(filters);
                    break;
                case "excel":
                    exportToExcel(filters);
                    break;
                case "csv":
                    exportToCSV(filters);
                    break;
                default:
                    throw new Error("Unknown format: " + format);
            }
        } catch (error) {
            console.error("Export error:", error);
            Swal.fire({
                icon: "error",
                title: "Xatolik",
                text: error.message,
            });
        }
    }, 500);
}

// PDF Export
function exportToPDF(filters) {
    try {
        if (!window.jspdf?.jsPDF) {
            throw new Error("jsPDF kutubxonasi yuklanmagan");
        }

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const lang = filters.language;

        // Title
        doc.setFontSize(20);
        doc.setFont(undefined, "bold");
        doc.text(t("reportTitle", lang), 105, 20, { align: "center" });

        // Line
        doc.setLineWidth(0.5);
        doc.line(20, 25, 190, 25);

        // Date info
        doc.setFontSize(11);
        doc.setFont(undefined, "normal");
        let yPos = 35;

        doc.text(
            `${t("date", lang)}: ${new Date().toLocaleDateString()}`,
            20,
            yPos
        );
        yPos += 7;
        doc.text(
            `${t("period", lang)}: ${filters.startDate || "N/A"} - ${
                filters.endDate || "N/A"
            }`,
            20,
            yPos
        );

        if (filters.projectType) {
            yPos += 7;
            doc.text(
                `${t("projectType", lang)}: ${t(
                    `projectTypes.${filters.projectType}`,
                    lang
                )}`,
                20,
                yPos
            );
        }

        // KPI Data
        yPos += 15;
        doc.setFontSize(14);
        doc.setFont(undefined, "bold");
        doc.text(t("mainIndicators", lang), 20, yPos);

        yPos += 10;
        doc.setFontSize(10);
        doc.setFont(undefined, "normal");

        // Table Header
        doc.setFont(undefined, "bold");
        doc.text(t("indicator", lang), 20, yPos);
        doc.text(t("value", lang), 100, yPos);
        doc.text(t("trend", lang), 150, yPos);
        yPos += 7;
        doc.line(20, yPos - 2, 190, yPos - 2);

        // Data
        doc.setFont(undefined, "normal");
        const kpiData = [
            [
                t("totalInvestors", lang),
                getElementText("totalInvestors"),
                getElementText("investorsTrend"),
            ],
            [
                t("totalInvestment", lang),
                getElementText("totalInvestment"),
                getElementText("investmentTrend"),
            ],
            [
                t("activeProjects", lang),
                getElementText("activeProjects"),
                getElementText("projectsTrend"),
            ],
            [
                t("totalRevenue", lang),
                getElementText("totalRevenue"),
                getElementText("revenueTrend"),
            ],
        ];

        kpiData.forEach((row) => {
            doc.text(row[0], 20, yPos);
            doc.text(row[1] || "N/A", 100, yPos);
            doc.text(row[2] || "0%", 150, yPos);
            yPos += 7;
        });

        // Footer
        doc.setFontSize(8);
        doc.text("1 / 1", 105, 290, { align: "center" });

        // Save
        doc.save(`dashboard-report-${lang}-${Date.now()}.pdf`);

        Swal.fire({
            icon: "success",
            title: t("pdfSuccess", lang),
            timer: 2000,
            showConfirmButton: false,
        });
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "PDF Xatolik",
            text: error.message,
        });
    }
}

// Excel Export
function exportToExcel(filters) {
    try {
        if (!window.XLSX) {
            throw new Error("XLSX kutubxonasi yuklanmagan");
        }

        const lang = filters.language;

        const data = [
            [t("reportTitle", lang)],
            [""],
            [t("date", lang), new Date().toLocaleDateString()],
            [
                t("period", lang),
                `${filters.startDate || "N/A"} - ${filters.endDate || "N/A"}`,
            ],
        ];

        if (filters.projectType) {
            data.push([
                t("projectType", lang),
                t(`projectTypes.${filters.projectType}`, lang),
            ]);
        }

        data.push([""]);
        data.push([t("indicator", lang), t("value", lang), t("trend", lang)]);
        data.push(
            [
                t("totalInvestors", lang),
                getElementText("totalInvestors"),
                getElementText("investorsTrend"),
            ],
            [
                t("totalInvestment", lang),
                getElementText("totalInvestment"),
                getElementText("investmentTrend"),
            ],
            [
                t("activeProjects", lang),
                getElementText("activeProjects"),
                getElementText("projectsTrend"),
            ],
            [
                t("totalRevenue", lang),
                getElementText("totalRevenue"),
                getElementText("revenueTrend"),
            ]
        );

        const ws = XLSX.utils.aoa_to_sheet(data);
        ws["!cols"] = [{ wch: 25 }, { wch: 15 }, { wch: 10 }];

        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Dashboard");

        XLSX.writeFile(wb, `dashboard-report-${lang}-${Date.now()}.xlsx`);

        Swal.fire({
            icon: "success",
            title: t("excelSuccess", lang),
            timer: 2000,
            showConfirmButton: false,
        });
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Excel Xatolik",
            text: error.message,
        });
    }
}

// CSV Export
function exportToCSV(filters) {
    try {
        const lang = filters.language;

        const data = [
            [t("indicator", lang), t("value", lang), t("trend", lang)],
            [
                t("totalInvestors", lang),
                getElementText("totalInvestors"),
                getElementText("investorsTrend"),
            ],
            [
                t("totalInvestment", lang),
                getElementText("totalInvestment"),
                getElementText("investmentTrend"),
            ],
            [
                t("activeProjects", lang),
                getElementText("activeProjects"),
                getElementText("projectsTrend"),
            ],
            [
                t("totalRevenue", lang),
                getElementText("totalRevenue"),
                getElementText("revenueTrend"),
            ],
        ];

        let csvContent = "\uFEFF";
        data.forEach((row) => {
            csvContent += row.map((cell) => `"${cell}"`).join(",") + "\r\n";
        });

        const blob = new Blob([csvContent], {
            type: "text/csv;charset=utf-8;",
        });
        const link = document.createElement("a");
        const url = URL.createObjectURL(blob);

        link.href = url;
        link.download = `dashboard-report-${lang}-${Date.now()}.csv`;
        link.style.display = "none";

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);

        Swal.fire({
            icon: "success",
            title: t("csvSuccess", lang),
            timer: 2000,
            showConfirmButton: false,
        });
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "CSV Xatolik",
            text: error.message,
        });
    }
}

// Helper Functions
function getElementText(id) {
    const el = document.getElementById(id);
    return el ? el.textContent.trim() : "N/A";
}


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

const chartInstances = {};

function renderInvestorsChart(activeData, passiveData) {
    const chartElement = document.querySelector("#investorsChart");
    if (!chartElement) return;
    
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
            categories: [...months] 
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
            categories: [...months] 
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
            categories: [...months] 
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
            categories: [...months] 
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
            categories: [...months] 
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
            categories: [...months] 
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
            categories: [...months] 
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

function initializeAllCharts() {
    if (!window.dashboardTranslations) {
        console.error('Dashboard translations not loaded!');
        return;
    }
    
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

window.reloadChartsWithLanguage = function() {
    console.log('Grafiklar tili o\'zgardi, qayta yuklanmoqda...');
    initializeAllCharts();
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