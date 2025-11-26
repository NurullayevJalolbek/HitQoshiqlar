/**
 * Dashboard Functions - Multi-language Version
 * Export: UZ, RU, EN, AR
 */

// Global o'zgaruvchilar
let currentFilters = {
    startDate: null,
    endDate: null,
    projectType: '',
    investorType: '',
    language: 'uz' // Default til
};

let chartInstances = {
    investors: null,
    projects: null,
    revenue: null,
    payments: null,
    contractRevenue: null,
    dividends: null,
    profit: null,
    contracts: null,
    documents: null,
    revenueByProject: null
};

// Ko'p tillilik tarjimalari
const translations = {
    uz: {
        reportTitle: 'Investitsiya Dashboard Hisoboti',
        date: 'Sana',
        period: 'Davr',
        projectType: 'Loyiha turi',
        investorType: 'Investor turi',
        mainIndicators: 'Asosiy Ko\'rsatkichlar',
        totalInvestors: 'Jami Investorlar',
        totalInvestment: 'Umumiy Sarmoya',
        activeProjects: 'Faol Loyihalar',
        totalRevenue: 'Umumiy Daromad',
        activeInvestors: 'Faol Investorlar',
        passiveInvestors: 'Passiv Investorlar',
        totalDividends: 'Jami Dividendlar',
        netProfit: 'Sof Foyda',
        indicator: 'Ko\'rsatkich',
        value: 'Qiymat',
        trend: 'Trend',
        pdfSuccess: 'PDF muvaffaqiyatli yuklandi!',
        excelSuccess: 'Excel muvaffaqiyatli yuklandi!',
        csvSuccess: 'CSV muvaffaqiyatli yuklandi!',
        error: 'Xatolik yuz berdi',
        selectDates: 'Iltimos, sanalarni tanlang!',
        invalidDate: 'Boshlanish sanasi tugash sanasidan katta bo\'lishi mumkin emas!',
        filterSuccess: 'Filtrlar muvaffaqiyatli qo\'llanildi!',
        projectTypes: {
            tech: 'Texnologiya',
            real_estate: 'Ko\'chmas mulk',
            agriculture: 'Qishloq xo\'jaligi',
            manufacturing: 'Ishlab chiqarish'
        },
        investorTypes: {
            active: 'Faol',
            passive: 'Passiv',
            all: 'Barchasi'
        }
    },
    ru: {
        reportTitle: 'Отчет Инвестиционной Панели',
        date: 'Дата',
        period: 'Период',
        projectType: 'Тип проекта',
        investorType: 'Тип инвестора',
        mainIndicators: 'Основные Показатели',
        totalInvestors: 'Всего Инвесторов',
        totalInvestment: 'Общие Инвестиции',
        activeProjects: 'Активные Проекты',
        totalRevenue: 'Общий Доход',
        activeInvestors: 'Активные Инвесторы',
        passiveInvestors: 'Пассивные Инвесторы',
        totalDividends: 'Общие Дивиденды',
        netProfit: 'Чистая Прибыль',
        indicator: 'Показатель',
        value: 'Значение',
        trend: 'Тенденция',
        pdfSuccess: 'PDF успешно загружен!',
        excelSuccess: 'Excel успешно загружен!',
        csvSuccess: 'CSV успешно загружен!',
        error: 'Произошла ошибка',
        selectDates: 'Пожалуйста, выберите даты!',
        invalidDate: 'Дата начала не может быть больше даты окончания!',
        filterSuccess: 'Фильтры успешно применены!',
        projectTypes: {
            tech: 'Технологии',
            real_estate: 'Недвижимость',
            agriculture: 'Сельское хозяйство',
            manufacturing: 'Производство'
        },
        investorTypes: {
            active: 'Активный',
            passive: 'Пассивный',
            all: 'Все'
        }
    },
    en: {
        reportTitle: 'Investment Dashboard Report',
        date: 'Date',
        period: 'Period',
        projectType: 'Project Type',
        investorType: 'Investor Type',
        mainIndicators: 'Key Performance Indicators',
        totalInvestors: 'Total Investors',
        totalInvestment: 'Total Investment',
        activeProjects: 'Active Projects',
        totalRevenue: 'Total Revenue',
        activeInvestors: 'Active Investors',
        passiveInvestors: 'Passive Investors',
        totalDividends: 'Total Dividends',
        netProfit: 'Net Profit',
        indicator: 'Indicator',
        value: 'Value',
        trend: 'Trend',
        pdfSuccess: 'PDF downloaded successfully!',
        excelSuccess: 'Excel downloaded successfully!',
        csvSuccess: 'CSV downloaded successfully!',
        error: 'An error occurred',
        selectDates: 'Please select dates!',
        invalidDate: 'Start date cannot be greater than end date!',
        filterSuccess: 'Filters applied successfully!',
        projectTypes: {
            tech: 'Technology',
            real_estate: 'Real Estate',
            agriculture: 'Agriculture',
            manufacturing: 'Manufacturing'
        },
        investorTypes: {
            active: 'Active',
            passive: 'Passive',
            all: 'All'
        }
    },
    ar: {
        reportTitle: 'تقرير لوحة المعلومات الاستثمارية',
        date: 'التاريخ',
        period: 'الفترة',
        projectType: 'نوع المشروع',
        investorType: 'نوع المستثمر',
        mainIndicators: 'المؤشرات الرئيسية',
        totalInvestors: 'إجمالي المستثمرين',
        totalInvestment: 'إجمالي الاستثمار',
        activeProjects: 'المشاريع النشطة',
        totalRevenue: 'إجمالي الإيرادات',
        activeInvestors: 'المستثمرون النشطون',
        passiveInvestors: 'المستثمرون السلبيون',
        totalDividends: 'إجمالي الأرباح',
        netProfit: 'صافي الربح',
        indicator: 'المؤشر',
        value: 'القيمة',
        trend: 'الاتجاه',
        pdfSuccess: 'تم تنزيل PDF بنجاح!',
        excelSuccess: 'تم تنزيل Excel بنجاح!',
        csvSuccess: 'تم تنزيل CSV بنجاح!',
        error: 'حدث خطأ',
        selectDates: 'الرجاء تحديد التواريخ!',
        invalidDate: 'لا يمكن أن يكون تاريخ البدء أكبر من تاريخ الانتهاء!',
        filterSuccess: 'تم تطبيق الفلاتر بنجاح!',
        projectTypes: {
            tech: 'التكنولوجيا',
            real_estate: 'العقارات',
            agriculture: 'الزراعة',
            manufacturing: 'التصنيع'
        },
        investorTypes: {
            active: 'نشط',
            passive: 'سلبي',
            all: 'الكل'
        }
    }
};

// Tarjima olish funksiyasi
function t(key, lang = currentFilters.language) {
    const keys = key.split('.');
    let value = translations[lang];
    
    for (const k of keys) {
        value = value?.[k];
    }
    
    return value || key;
}

// Mock ma'lumotlar generatori
function generateMockData(filters) {
    const multiplier = filters.projectType === 'tech' ? 1.3 : 
                      filters.projectType === 'real_estate' ? 1.1 :
                      filters.projectType === 'agriculture' ? 0.9 :
                      filters.projectType === 'manufacturing' ? 1.0 : 1.0;
    
    const investorMultiplier = filters.investorType === 'active' ? 0.8 :
                               filters.investorType === 'passive' ? 0.3 : 1.0;
    
    return {
        kpis: {
            total_investors: Math.floor(1284 * investorMultiplier),
            total_investment: parseFloat((45.2 * multiplier).toFixed(1)),
            active_projects: Math.floor(68 * multiplier),
            total_revenue: parseFloat((8.7 * multiplier).toFixed(1)),
            active_investors: Math.floor(945 * investorMultiplier),
            passive_investors: Math.floor(280 * investorMultiplier),
            total_dividends: parseFloat((5.4 * multiplier).toFixed(1)),
            net_profit: parseFloat((12.3 * multiplier).toFixed(1)),
            
            investors_trend: (12.5 * multiplier).toFixed(1),
            investment_trend: (8.3 * multiplier).toFixed(1),
            projects_trend: filters.projectType === 'tech' ? 5.2 : -2.1,
            revenue_trend: (15.8 * multiplier).toFixed(1)
        },
        charts: {
            investors: {
                active: generateMonthlyData(320, 945, multiplier * investorMultiplier),
                passive: generateMonthlyData(98, 280, multiplier * investorMultiplier)
            },
            revenue: generateMonthlyData(1200, 3890, multiplier),
            payments: generateMonthlyData(280, 730, multiplier),
            contractRevenue: generateMonthlyData(850, 2250, multiplier),
            profit: generateMonthlyData(420, 1170, multiplier),
            contracts: generateMonthlyData(12, 48, multiplier),
            documents: generateMonthlyData(45, 128, multiplier)
        }
    };
}

function generateMonthlyData(start, end, multiplier = 1) {
    const data = [];
    const step = (end - start) / 11;
    for (let i = 0; i < 12; i++) {
        const value = Math.floor((start + (step * i)) * multiplier);
        data.push(value);
    }
    return data;
}

// Filtrlash funksiyasi
function applyFilters() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const projectType = document.getElementById('projectType').value;
    const investorType = document.getElementById('investorType')?.value || '';
    const language = document.getElementById('languageSelect')?.value || 'uz';
    
    if (!startDate || !endDate) {
        showAlert(t('selectDates', language), 'warning');
        return;
    }
    
    if (new Date(startDate) > new Date(endDate)) {
        showAlert(t('invalidDate', language), 'error');
        return;
    }
    
    currentFilters = {
        startDate,
        endDate,
        projectType,
        investorType,
        language
    };
    
    showLoading();
    
    setTimeout(() => {
        const newData = generateMockData(currentFilters);
        updateDashboard(newData);
        hideLoading();
        showAlert(t('filterSuccess', currentFilters.language), 'success');
    }, 800);
}

function resetFilters() {
    document.getElementById('startDate').value = new Date().toISOString().split('T')[0].slice(0, 8) + '01';
    document.getElementById('endDate').value = new Date().toISOString().split('T')[0];
    document.getElementById('projectType').value = '';
    if (document.getElementById('investorType')) {
        document.getElementById('investorType').value = '';
    }
    if (document.getElementById('languageSelect')) {
        document.getElementById('languageSelect').value = 'uz';
    }
    
    currentFilters = {
        startDate: null,
        endDate: null,
        projectType: '',
        investorType: '',
        language: 'uz'
    };
    
    applyFilters();
}

function updateDashboard(data) {
    if (data.kpis) {
        updateElement('totalInvestors', formatNumber(data.kpis.total_investors));
        updateElement('totalInvestment', formatCurrency(data.kpis.total_investment));
        updateElement('activeProjects', data.kpis.active_projects);
        updateElement('totalRevenue', formatCurrency(data.kpis.total_revenue));
        
        if (document.getElementById('activeInvestors')) {
            updateElement('activeInvestors', formatNumber(data.kpis.active_investors));
        }
        if (document.getElementById('passiveInvestors')) {
            updateElement('passiveInvestors', formatNumber(data.kpis.passive_investors));
        }
        if (document.getElementById('totalDividends')) {
            updateElement('totalDividends', formatCurrency(data.kpis.total_dividends));
        }
        if (document.getElementById('netProfit')) {
            updateElement('netProfit', formatCurrency(data.kpis.net_profit));
        }
        
        updateTrend('investorsTrend', parseFloat(data.kpis.investors_trend));
        updateTrend('investmentTrend', parseFloat(data.kpis.investment_trend));
        updateTrend('projectsTrend', parseFloat(data.kpis.projects_trend));
        updateTrend('revenueTrend', parseFloat(data.kpis.revenue_trend));
    }
    
    if (data.charts && window.updateCharts) {
        window.updateCharts(data.charts);
    }
}

function updateElement(id, value) {
    const element = document.getElementById(id);
    if (!element) return;
    
    element.style.opacity = '0.5';
    setTimeout(() => {
        element.textContent = value;
        element.style.opacity = '1';
    }, 150);
}

function updateTrend(elementId, value) {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    const parent = element.parentElement;
    element.textContent = Math.abs(value).toFixed(1) + '%';
    
    parent.classList.remove('bg-success-subtle', 'text-success', 'bg-danger-subtle', 'text-danger', 'bg-warning-subtle', 'text-warning');
    
    const icon = parent.querySelector('i');
    if (value > 0) {
        parent.classList.add('bg-success-subtle', 'text-success');
        if (icon) icon.className = 'fas fa-arrow-up';
    } else if (value < 0) {
        parent.classList.add('bg-danger-subtle', 'text-danger');
        if (icon) icon.className = 'fas fa-arrow-down';
    } else {
        parent.classList.add('bg-warning-subtle', 'text-warning');
        if (icon) icon.className = 'fas fa-minus';
    }
}

// Export funksiyalari
function exportData(format) {
    const lang = currentFilters.language || 'uz';
    
    // Export modal ko'rsatish
    showExportModal(format);
}

function showExportModal(format) {
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
    
    // Modal qo'shish
    let existingModal = document.getElementById('exportModal');
    if (existingModal) existingModal.remove();
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    const modal = new bootstrap.Modal(document.getElementById('exportModal'));
    modal.show();
}

function executeExport(format, lang) {
    // Modal yopish
    const modal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
    if (modal) modal.hide();
    
    showLoading();
    
    const filters = {
        ...currentFilters,
        language: lang
    };
    
    setTimeout(() => {
        switch(format) {
            case 'pdf':
                exportToPDF(filters);
                break;
            case 'excel':
                exportToExcel(filters);
                break;
            case 'csv':
                exportToCSV(filters);
                break;
        }
    }, 500);
}

// PDF export
function exportToPDF(filters) {
    try {
        if (!window.jspdf || !window.jspdf.jsPDF) {
            throw new Error('jsPDF library not found');
        }
        
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const lang = filters.language;
        
        // Arab tili uchun RTL
        const isRTL = lang === 'ar';
        const pageWidth = doc.internal.pageSize.getWidth();
        
        // Sarlavha
        doc.setFontSize(20);
        const title = t('reportTitle', lang);
        const titleX = isRTL ? pageWidth - 20 : 20;
        doc.text(title, titleX, 20, { align: isRTL ? 'right' : 'left' });
        
        // Sana ma'lumotlari
        doc.setFontSize(12);
        let yPos = 30;
        
        const dateText = `${t('date', lang)}: ${new Date().toLocaleDateString(lang === 'ar' ? 'ar-SA' : lang === 'ru' ? 'ru-RU' : 'en-US')}`;
        const periodText = `${t('period', lang)}: ${filters.startDate} - ${filters.endDate}`;
        
        doc.text(dateText, titleX, yPos, { align: isRTL ? 'right' : 'left' });
        yPos += 8;
        doc.text(periodText, titleX, yPos, { align: isRTL ? 'right' : 'left' });
        
        if (filters.projectType) {
            yPos += 8;
            const projectText = `${t('projectType', lang)}: ${t(`projectTypes.${filters.projectType}`, lang)}`;
            doc.text(projectText, titleX, yPos, { align: isRTL ? 'right' : 'left' });
        }
        
        // KPI ma'lumotlar
        yPos += 14;
        doc.setFontSize(14);
        doc.text(t('mainIndicators', lang), titleX, yPos, { align: isRTL ? 'right' : 'left' });
        
        doc.setFontSize(11);
        yPos += 10;
        
        const kpiData = [
            `${t('totalInvestors', lang)}: ${getElementText('totalInvestors')}`,
            `${t('totalInvestment', lang)}: ${getElementText('totalInvestment')}`,
            `${t('activeProjects', lang)}: ${getElementText('activeProjects')}`,
            `${t('totalRevenue', lang)}: ${getElementText('totalRevenue')}`
        ];
        
        const dataX = isRTL ? pageWidth - 30 : 30;
        kpiData.forEach((item, index) => {
            doc.text(item, dataX, yPos + (index * 8), { align: isRTL ? 'right' : 'left' });
        });
        
        // Fayl saqlash
        doc.save(`dashboard-report-${lang}-${new Date().getTime()}.pdf`);
        
        hideLoading();
        showAlert(t('pdfSuccess', lang), 'success');
    } catch (error) {
        console.error('PDF export error:', error);
        hideLoading();
        showAlert(t('error', filters.language) + ': ' + error.message, 'error');
    }
}

// Excel export
function exportToExcel(filters) {
    try {
        if (!window.XLSX) {
            throw new Error('XLSX library not found');
        }
        
        const lang = filters.language;
        
        const data = [
            [t('reportTitle', lang)],
            [''],
            [t('date', lang), new Date().toLocaleDateString()],
            [t('period', lang), `${filters.startDate} - ${filters.endDate}`],
            filters.projectType ? [t('projectType', lang), t(`projectTypes.${filters.projectType}`, lang)] : [],
            [''],
            [t('indicator', lang), t('value', lang), t('trend', lang)],
            [t('totalInvestors', lang), getElementText('totalInvestors'), getElementText('investorsTrend')],
            [t('totalInvestment', lang), getElementText('totalInvestment'), getElementText('investmentTrend')],
            [t('activeProjects', lang), getElementText('activeProjects'), getElementText('projectsTrend')],
            [t('totalRevenue', lang), getElementText('totalRevenue'), getElementText('revenueTrend')]
        ].filter(row => row.length > 0);
        
        const ws = XLSX.utils.aoa_to_sheet(data);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Dashboard');
        
        XLSX.writeFile(wb, `dashboard-report-${lang}-${new Date().getTime()}.xlsx`);
        
        hideLoading();
        showAlert(t('excelSuccess', lang), 'success');
    } catch (error) {
        console.error('Excel export error:', error);
        hideLoading();
        showAlert(t('error', filters.language) + ': ' + error.message, 'error');
    }
}

// CSV export
function exportToCSV(filters) {
    try {
        const lang = filters.language;
        
        const data = [
            [t('indicator', lang), t('value', lang), t('trend', lang)],
            [t('totalInvestors', lang), getElementText('totalInvestors'), getElementText('investorsTrend')],
            [t('totalInvestment', lang), getElementText('totalInvestment'), getElementText('investmentTrend')],
            [t('activeProjects', lang), getElementText('activeProjects'), getElementText('projectsTrend')],
            [t('totalRevenue', lang), getElementText('totalRevenue'), getElementText('revenueTrend')]
        ];
        
        let csvContent = "data:text/csv;charset=utf-8,\uFEFF";
        data.forEach(row => {
            csvContent += row.join(',') + "\r\n";
        });
        
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", `dashboard-report-${lang}-${new Date().getTime()}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        hideLoading();
        showAlert(t('csvSuccess', lang), 'success');
    } catch (error) {
        console.error('CSV export error:', error);
        hideLoading();
        showAlert(t('error', filters.language) + ': ' + error.message, 'error');
    }
}

// Yordamchi funksiyalar
function formatNumber(num) {
    return new Intl.NumberFormat('en-US').format(num);
}

function formatCurrency(amount) {
    return '$' + new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 1,
        maximumFractionDigits: 1
    }).format(amount) + 'M';
}

function getElementText(id) {
    const el = document.getElementById(id);
    return el ? el.textContent.trim() : '';
}

function showLoading() {
    let loader = document.getElementById('dashboard-loader');
    if (!loader) {
        loader = document.createElement('div');
        loader.id = 'dashboard-loader';
        loader.innerHTML = `
            <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                        background: rgba(0,0,0,0.6); z-index: 9999; 
                        display: flex; align-items: center; justify-content: center;
                        backdrop-filter: blur(2px);">
                <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        document.body.appendChild(loader);
    }
}

function hideLoading() {
    const loader = document.getElementById('dashboard-loader');
    if (loader) loader.remove();
}

function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    const alertClass = type === 'success' ? 'alert-success' :
                       type === 'error' ? 'alert-danger' :
                       type === 'warning' ? 'alert-warning' : 'alert-info';
    
    alertDiv.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 10000; min-width: 300px;';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => alertDiv.remove(), 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard functions loaded');
    
    if (document.getElementById('startDate')) {
        const initialData = generateMockData(currentFilters);
        updateDashboard(initialData);
    }
});