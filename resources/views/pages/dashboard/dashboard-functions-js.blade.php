<script>
    /**
     * Dashboard Functions - With Filter Integration
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
            invalidDate: "Boshlanish sanasi tugash sanasidan katta bo'lishi mumkin emas!",
            filterSuccess: "Filtrlar muvaffaqiyatli qo'llanildi!",
            projectTypes: {
                all: "Barchasi",
                land: "Yer",
                rent: "Ijara",
                construction: "Qurilish",
            },
            investorTypes: {
                active: "Faol",
                passive: "Passiv",
                all: "Barchasi",
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
                all: "Все",
                land: "Земля",
                rent: "Аренда",
                construction: "Строительство",
            },
            investorTypes: {
                active: "Активный",
                passive: "Пассивный",
                all: "Все",
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
                all: "All",
                land: "Land",
                rent: "Rent",
                construction: "Construction",
            },
            investorTypes: {
                active: "Active",
                passive: "Passive",
                all: "All",
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
                all: "الكل",
                land: "الأرض",
                rent: "الإيجار",
                construction: "البناء",
            },
            investorTypes: {
                active: "نشط",
                passive: "سلبي",
                all: "الكل",
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

    /**
     * Filtrlarni qo'llash
     */
    function applyFilters() {
        const startDate = document.getElementById("startDate")?.value;
        const endDate = document.getElementById("endDate")?.value;
        const projectType = document.getElementById("projectType")?.value;
        const investorType = document.getElementById("investorType")?.value;

        // Sana validatsiyasi
        if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);

            if (start > end) {
                Swal.fire({
                    icon: "error",
                    title: t("error", currentFilters.language),
                    text: t("invalidDate", currentFilters.language),
                });
                return;
            }
        }

        // Filtrlarni saqlash
        currentFilters = {
            ...currentFilters,
            startDate,
            endDate,
            projectType: projectType || 'all',
            investorType: investorType || 'all'
        };

        // Grafiklarni yangilash
        if (typeof window.applyChartFilters === 'function') {
            window.applyChartFilters(currentFilters);
        }

        // Success xabari
        Swal.fire({
            icon: "success",
            title: t("filterSuccess", currentFilters.language),
            timer: 1500,
            showConfirmButton: false,
        });
    }

    /**
     * Filtrlarni tozalash
     */
    function clearFilters() {
        // Form elementlarini tozalash
        const startDateEl = document.getElementById("startDate");
        const endDateEl = document.getElementById("endDate");
        const projectTypeEl = document.getElementById("projectType");
        const investorTypeEl = document.getElementById("investorType");

        if (startDateEl) startDateEl.value = "";
        if (endDateEl) endDateEl.value = "";
        if (projectTypeEl) projectTypeEl.value = "";
        if (investorTypeEl) investorTypeEl.value = "";

        // Filtrlarni reset qilish
        currentFilters = {
            startDate: null,
            endDate: null,
            projectType: "",
            investorType: "",
            language: currentFilters.language,
        };

        // Grafiklarni qayta yuklash
        if (typeof window.reloadChartsWithLanguage === 'function') {
            window.reloadChartsWithLanguage();
        }
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

            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            const lang = filters.language;

            // Title
            doc.setFontSize(20);
            doc.setFont(undefined, "bold");
            doc.text(t("reportTitle", lang), 105, 20, {
                align: "center"
            });

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

            if (filters.investorType) {
                yPos += 7;
                doc.text(
                    `${t("investorType", lang)}: ${t(
                `investorTypes.${filters.investorType}`,
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
            doc.text("1 / 1", 105, 290, {
                align: "center"
            });

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

            if (filters.investorType) {
                data.push([
                    t("investorType", lang),
                    t(`investorTypes.${filters.investorType}`, lang),
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
            ws["!cols"] = [{
                wch: 25
            }, {
                wch: 15
            }, {
                wch: 10
            }];

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

    // Global functions
    window.applyFilters = applyFilters;
    window.clearFilters = clearFilters;
    window.exportData = exportData;
    window.executeExport = executeExport;
</script>
