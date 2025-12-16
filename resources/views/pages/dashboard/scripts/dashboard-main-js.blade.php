<script>
/**
 * Dashboard Core Functions
 * Optimized and consolidated version
 */

// Global State
const DashboardState = {
    apiData: null,
    chartMode: 'monthly',
    chartInstances: {},
    filters: {
        startDate: null,
        endDate: null,
        projectType: '',
        investorType: '',
        language: 'uz'
    }
};

// Translations
const trans = window.dashboardTranslations || {};
const months = trans.months ? Object.values(trans.months) : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

// ============= UTILITY FUNCTIONS =============

function formatNumber(num) {
    if (!num) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
}

function t(key, lang = 'uz') {
    const keys = key.split('.');
    let value = trans[lang] || trans;
    
    for (const k of keys) {
        value = value?.[k];
    }
    
    return value || key;
}

function showLoading(show = true) {
    const overlay = document.getElementById('chartLoadingOverlay');
    if (overlay) {
        overlay.style.display = show ? 'flex' : 'none';
    }
}

// ============= API FUNCTIONS =============

async function fetchDashboardData() {
    try {
        const response = await fetch('/api/dashboard');
        if (!response.ok) {
            throw new Error('API javob bermadi');
        }
        const data = await response.json();
        DashboardState.apiData = data.result;
        return DashboardState.apiData;
    } catch (error) {
        console.error('❌ API xatosi:', error);
        Swal.fire({
            icon: 'error',
            title: 'Xatolik',
            text: 'Ma\'lumotlarni yuklashda xatolik yuz berdi',
            timer: 3000
        });
        return null;
    }
}

// ============= FILTER FUNCTIONS =============

function applyFilters() {
    const startDate = document.getElementById('startDate')?.value;
    const endDate = document.getElementById('endDate')?.value;
    const projectType = document.getElementById('projectType')?.value;
    const investorType = document.getElementById('investorType')?.value;

    // Validation
    if (startDate && endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);

        if (start > end) {
            Swal.fire({
                icon: 'error',
                title: t('error', DashboardState.filters.language),
                text: t('invalidDate', DashboardState.filters.language)
            });
            return;
        }
    }

    // Update state
    DashboardState.filters = {
        ...DashboardState.filters,
        startDate,
        endDate,
        projectType: projectType || 'all',
        investorType: investorType || 'all'
    };

    // Reload charts with filters
    showLoading(true);
    setTimeout(() => {
        initializeAllCharts(DashboardState.chartMode);
        showLoading(false);
        
        Swal.fire({
            icon: 'success',
            title: 'Muvaffaqiyatli!',
            text: 'Filtrlar qo\'llandi',
            timer: 1500,
            showConfirmButton: false
        });
    }, 500);
}

function clearFilters() {
    // Reset form
    ['startDate', 'endDate', 'projectType', 'investorType'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });

    // Reset state
    DashboardState.filters = {
        startDate: null,
        endDate: null,
        projectType: '',
        investorType: '',
        language: DashboardState.filters.language
    };

    // Reload charts
    showLoading(true);
    setTimeout(() => {
        initializeAllCharts(DashboardState.chartMode);
        showLoading(false);
    }, 500);
}

// ============= CHART MODE SWITCHING =============

function switchChartMode(mode) {
    DashboardState.chartMode = mode;
    
    // Update button states
    const monthlyBtn = document.getElementById('monthlyBtn');
    const dailyBtn = document.getElementById('dailyBtn');
    
    if (monthlyBtn && dailyBtn) {
        if (mode === 'monthly') {
            monthlyBtn.classList.add('btn-primary');
            monthlyBtn.classList.remove('btn-outline-primary');
            dailyBtn.classList.remove('btn-primary');
            dailyBtn.classList.add('btn-outline-primary');
        } else {
            dailyBtn.classList.add('btn-primary');
            dailyBtn.classList.remove('btn-outline-primary');
            monthlyBtn.classList.remove('btn-primary');
            monthlyBtn.classList.add('btn-outline-primary');
        }
    }
    
    // Reload charts
    showLoading(true);
    setTimeout(async () => {
        await fetchDashboardData();
        initializeAllCharts(mode);
        showLoading(false);
    }, 300);
}

// ============= KPI UPDATE FUNCTIONS =============

function updateKPICards() {
    if (!DashboardState.apiData || !DashboardState.apiData.kpi) return;
    
    const kpi = DashboardState.apiData.kpi;
    
    // Update values
    const updates = {
        totalInvestors: kpi.totalInvestors.value.toLocaleString(),
        totalInvestment: kpi.totalInvestment.formatted + ' k',
        activeProjects: kpi.activeProjects.value,
        totalRevenue: kpi.totalRevenue.formatted + ' k'
    };
    
    Object.entries(updates).forEach(([key, value]) => {
        const el = document.querySelector(`[data-kpi="${key}"]`);
        if (el) el.textContent = value;
    });
    
    // Update trends
    const trends = {
        investorsTrend: kpi.totalInvestors.trend,
        investmentTrend: kpi.totalInvestment.trend,
        projectsTrend: kpi.activeProjects.trend,
        revenueTrend: kpi.totalRevenue.trend
    };
    
    Object.entries(trends).forEach(([key, value]) => {
        const el = document.querySelector(`[data-trend="${key}"]`);
        if (el) {
            el.textContent = value + '%';
            
            // Update color classes
            const parent = el.closest('.d-flex');
            if (parent) {
                const svg = parent.querySelector('svg');
                if (svg) {
                    svg.classList.remove('text-success', 'text-danger');
                    svg.classList.add(value >= 0 ? 'text-success' : 'text-danger');
                }
            }
        }
    });
    
    // Update investor counts
    if (kpi.totalInvestors.active && kpi.totalInvestors.passive) {
        const activeEl = document.querySelector('[data-investor-active]');
        const passiveEl = document.querySelector('[data-investor-passive]');
        
        if (activeEl) activeEl.textContent = kpi.totalInvestors.active;
        if (passiveEl) passiveEl.textContent = kpi.totalInvestors.passive;
    }
}

// ============= EXPORT FUNCTIONS =============

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
                        <label class="form-label fw-bold">Tilni tanlang</label>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    let existingModal = document.getElementById('exportModal');
    if (existingModal) existingModal.remove();

    document.body.insertAdjacentHTML('beforeend', modalHTML);
    const modal = new bootstrap.Modal(document.getElementById('exportModal'));
    modal.show();
}

function executeExport(format, language) {
    const modal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
    if (modal) modal.hide();

    Swal.fire({
        title: 'Yuklanmoqda...',
        text: 'Ma\'lumotlar tayyorlanmoqda',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    setTimeout(() => {
        try {
            switch (format.toLowerCase()) {
                case 'excel':
                    exportToExcel(DashboardState.filters, language);
                    break;
                case 'csv':
                    exportToCSV(DashboardState.filters, language);
                    break;
                default:
                    throw new Error('Unknown format: ' + format);
            }
        } catch (error) {
            console.error('Export error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Xatolik',
                text: error.message
            });
        }
    }, 500);
}

function exportToExcel(filters, lang) {
    try {
        if (!window.XLSX) {
            throw new Error('XLSX kutubxonasi yuklanmagan');
        }

        const data = [
            ['Investment Dashboard Report'],
            [''],
            ['Date', new Date().toLocaleDateString()],
            ['Period', `${filters.startDate || 'N/A'} - ${filters.endDate || 'N/A'}`]
        ];

        if (filters.projectType) {
            data.push(['Project Type', filters.projectType]);
        }

        if (filters.investorType) {
            data.push(['Investor Type', filters.investorType]);
        }

        data.push(['']);
        data.push(['Indicator', 'Value', 'Trend']);

        // Add KPI data
        if (DashboardState.apiData && DashboardState.apiData.kpi) {
            const kpi = DashboardState.apiData.kpi;
            data.push(
                ['Total Investors', kpi.totalInvestors.value, kpi.totalInvestors.trend + '%'],
                ['Total Investment', kpi.totalInvestment.formatted, kpi.totalInvestment.trend + '%'],
                ['Active Projects', kpi.activeProjects.value, kpi.activeProjects.trend + '%'],
                ['Total Revenue', kpi.totalRevenue.formatted, kpi.totalRevenue.trend + '%']
            );
        }

        const ws = XLSX.utils.aoa_to_sheet(data);
        ws['!cols'] = [{ wch: 25 }, { wch: 15 }, { wch: 10 }];

        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Dashboard');

        XLSX.writeFile(wb, `dashboard-report-${lang}-${Date.now()}.xlsx`);

        Swal.fire({
            icon: 'success',
            title: 'Muvaffaqiyatli!',
            text: 'Excel fayli yuklandi',
            timer: 2000,
            showConfirmButton: false
        });
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Excel Xatolik',
            text: error.message
        });
    }
}

function exportToCSV(filters, lang) {
    try {
        const data = [
            ['Indicator', 'Value', 'Trend']
        ];

        if (DashboardState.apiData && DashboardState.apiData.kpi) {
            const kpi = DashboardState.apiData.kpi;
            data.push(
                ['Total Investors', kpi.totalInvestors.value, kpi.totalInvestors.trend + '%'],
                ['Total Investment', kpi.totalInvestment.formatted, kpi.totalInvestment.trend + '%'],
                ['Active Projects', kpi.activeProjects.value, kpi.activeProjects.trend + '%'],
                ['Total Revenue', kpi.totalRevenue.formatted, kpi.totalRevenue.trend + '%']
            );
        }

        let csvContent = '\uFEFF';
        data.forEach(row => {
            csvContent += row.map(cell => `"${cell}"`).join(',') + '\r\n';
        });

        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);

        link.href = url;
        link.download = `dashboard-report-${lang}-${Date.now()}.csv`;
        link.style.display = 'none';

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);

        Swal.fire({
            icon: 'success',
            title: 'Muvaffaqiyatli!',
            text: 'CSV fayli yuklandi',
            timer: 2000,
            showConfirmButton: false
        });
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'CSV Xatolik',
            text: error.message
        });
    }
}

// ============= INITIALIZATION =============

async function initializeDashboard() {
    showLoading(true);
    
    try {
        await fetchDashboardData();
        
        updateKPICards();
        
        await initializeAllCharts(DashboardState.chartMode);
    } catch (error) {
        console.error('❌ Dashboard yuklanishida xatolik:', error);
        Swal.fire({
            icon: 'error',
            title: 'Xatolik',
            text: 'Dashboard yuklanishida xatolik yuz berdi'
        });
    } finally {
        showLoading(false);
    }
}

// ============= AUTO REFRESH =============

let autoRefreshInterval = null;

function startAutoRefresh(intervalMinutes = 5) {
    stopAutoRefresh(); // Clear existing interval
    
    autoRefreshInterval = setInterval(async () => {
        await fetchDashboardData();
        updateKPICards();
        await initializeAllCharts(DashboardState.chartMode);
    }, intervalMinutes * 60 * 1000);
}

function stopAutoRefresh() {
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
        autoRefreshInterval = null;
    }
}

// ============= GLOBAL EXPORTS =============

window.DashboardState = DashboardState;
window.applyFilters = applyFilters;
window.clearFilters = clearFilters;
window.switchChartMode = switchChartMode;
window.exportData = exportData;
window.executeExport = executeExport;
window.fetchDashboardData = fetchDashboardData;

// ============= DOM READY =============

document.addEventListener('DOMContentLoaded', async function() {
    await initializeDashboard();
    startAutoRefresh(5); // Auto refresh every 5 minutes
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    stopAutoRefresh();
});
</script>
