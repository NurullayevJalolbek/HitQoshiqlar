<script>
(function() {
    'use strict';

    /* ============================
       TRANSLATION CONSTANTS
    ============================ */
    const TRANSLATIONS = {
        id: "{{ __('ID') }}",
        project: "{{ __('Лойиҳа') }}",
        direction: "{{ __('Йўналиш') }}",
        total_income: "{{ __('Жами даромад') }}",
        total_expense: "{{ __('Жами харажат') }}",
        profit: "{{ __('Фойда') }}",
        share_percent: "{{ __('Улуш (%)') }}",
        investor: "{{ __('Инвестор номи') }}",
        status: "{{ __('Тўлов ҳолати') }}",
        updated_at: "{{ __('Охирги янгиланиш') }}",
        actions: "{{ __('Амаллар') }}",
        details: "{{ __('Батафсил') }}",
        paid: "{{ __('Тўланган') }}",
        pending: "{{ __('Кутилмоқда') }}",
        construction: "{{ __('Қурилиш') }}",
        land: "{{ __('Ер') }}",
        rent: "{{ __('Ижара') }}",
        total_distributions: "{{ __('Жами тақсимотлар') }}",
        total_profit: "{{ __('Жами фойда') }}",
        full_partners: "{{ __('Тўлиқ шериклар') }}",
        limited_partners: "{{ __('Коммандитчилар') }}",
        sum: "{{ __('сўм') }}"
    };

    /* ============================
       UTILITY FUNCTIONS
    ============================ */
    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    }

    function formatCurrency(amount) {
        if (!amount) return '0';
        return Number(amount).toLocaleString('uz-UZ');
    }

    function formatDate(dateString) {
    if (!dateString) return '<span class="text-muted">-</span>';

    const d = new Date(dateString);
    if (isNaN(d)) return '<span class="text-muted">-</span>';

    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = String(d.getFullYear()).slice(-2);

    return `${day}.${month}.${year}`;
}


    /* ============================
       STATUS & DIRECTION HELPERS
    ============================ */
    function getStatusHtml(status) {
        const statusMap = {
            'paid': { class: 'status-paid', label: TRANSLATIONS.paid, icon: 'fa-check-circle' },
            'pending': { class: 'status-pending', label: TRANSLATIONS.pending, icon: 'fa-clock' }
        };
        const s = statusMap[status.toLowerCase()] || statusMap['pending'];
        return `<span class="${s.class}"><i class="fas ${s.icon}"></i> ${s.label}</span>`;
    }

    function getDirectionHtml(direction) {
        const directionMap = {
            'construction': { class: 'direction-construction', label: TRANSLATIONS.construction, icon: 'fa-hard-hat' },
            'land': { class: 'direction-land', label: TRANSLATIONS.land, icon: 'fa-map' },
            'rent': { class: 'direction-rent', label: TRANSLATIONS.rent, icon: 'fa-building' }
        };
        const d = directionMap[direction] || directionMap['construction'];
        return `<span class="direction-badge ${d.class}"><i class="fas ${d.icon}"></i> ${d.label}</span>`;
    }

    /* ============================
       DATA STRUCTURE
    ============================ */
    const distributionColumns = [
        { key: "id", label: TRANSLATIONS.id },
        { key: "project", label: TRANSLATIONS.project },
        { key: "direction", label: TRANSLATIONS.direction },
        { key: "total_income", label: TRANSLATIONS.total_income },
        { key: "total_expense", label: TRANSLATIONS.total_expense },
        { key: "profit", label: TRANSLATIONS.profit },
        { key: "share_percent", label: TRANSLATIONS.share_percent },
        { key: "investor", label: TRANSLATIONS.investor },
        { key: "status", label: TRANSLATIONS.status },
        { key: "updated_at", label: TRANSLATIONS.updated_at },
        { key: "actions", label: TRANSLATIONS.actions },
    ];

    let distributions = [
        { 
            id: 1, 
            project: "Қурилиш A", 
            direction: "construction", 
            total_income: 200000000, 
            total_expense: 50000000, 
            profit: 150000000, 
            share_percent: 40, 
            investor: "Jasur R.", 
            status: "paid", 
            updated_at: "2025-11-15" 
        },
        { 
            id: 2, 
            project: "Ер B", 
            direction: "land", 
            total_income: 300000000, 
            total_expense: 120000000, 
            profit: 180000000, 
            share_percent: 25, 
            investor: "Olim X.", 
            status: "pending", 
            updated_at: "2025-12-01" 
        },
        { 
            id: 3, 
            project: "Ижара C", 
            direction: "rent", 
            total_income: 85000000, 
            total_expense: 20000000, 
            profit: 65000000, 
            share_percent: 50, 
            investor: "Madina I.", 
            status: "paid", 
            updated_at: "2026-01-10" 
        },
    ];

    // Agar server-side ma'lumotlar mavjud bo'lsa:
    @if(isset($distributions) && count($distributions) > 0)
        distributions = @json($distributions);
    @endif

    let activeTab = "full_share";
    const CSRF_TOKEN = "{{ csrf_token() }}";

    /* ============================
       SUMMARY CARDS
    ============================ */
    function renderSummary() {
        const total = distributions.length;
        const fullPartners = distributions.filter(d => d.share_percent >= 50).length;
        const limitedPartners = distributions.filter(d => d.share_percent < 50).length;
        const totalProfit = distributions.reduce((sum, d) => sum + (Number(d.profit) || 0), 0);
        const totalIncome = distributions.reduce((sum, d) => sum + (Number(d.total_income) || 0), 0);

        const summaryRow = document.getElementById('summaryRow');
        if (!summaryRow) return;

        summaryRow.innerHTML = `
            <div class="col-md-3">
                <div class="card p-3 stat-card">
                    <div class="small text-muted">${TRANSLATIONS.total_distributions}</div>
                    <div class="h4 mb-0">${total}</div>
                    <div class="small text-muted mt-2">${formatCurrency(totalIncome)} ${TRANSLATIONS.sum}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 stat-card profit">
                    <div class="small text-muted">${TRANSLATIONS.total_profit}</div>
                    <div class="h4 mb-0">${formatCurrency(totalProfit)} ${TRANSLATIONS.sum}</div>
                    <div class="small text-success">${total > 0 ? ((totalProfit/totalIncome)*100).toFixed(1) : 0}% марж</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 stat-card full">
                    <div class="small text-muted">${TRANSLATIONS.full_partners}</div>
                    <div class="h4 mb-0">${fullPartners}</div>
                    <div class="small text-muted">≥50% улуш</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 stat-card limited">
                    <div class="small text-muted">${TRANSLATIONS.limited_partners}</div>
                    <div class="h4 mb-0">${limitedPartners}</div>
                    <div class="small text-muted"><50% улуш</div>
                </div>
            </div>
        `;
    }

    /* ============================
       UPDATE TAB BADGES
    ============================ */
    function updateTabBadges() {
        const fullCount = distributions.filter(x => x.share_percent >= 50).length;
        const limitedCount = distributions.filter(x => x.share_percent < 50).length;

        document.getElementById('badge-full').textContent = fullCount;
        document.getElementById('badge-limited').textContent = limitedCount;
    }

    /* ============================
       RENDER TABLE HEADER
    ============================ */
    function renderTableHeader() {
        const header = document.getElementById("table-header");
        if (!header) return;

        header.innerHTML = distributionColumns.map(col => 
            `<th class="p-3 text-start">${col.label}</th>`
        ).join("");
    }

    /* ============================
       RENDER TABLE
    ============================ */
    function loadTableData(list = distributions) {
        renderSummary();
        updateTabBadges();

        const body = document.getElementById("table-body");
        const emptyState = document.getElementById("emptyState");
        
        if (!body) return;

        const filteredByTab = list.filter(x => {
            if (activeTab === "full_share") return x.share_percent >= 50;
            if (activeTab === "limited_share") return x.share_percent < 50;
            return false;
        });

        body.innerHTML = "";

        if (filteredByTab.length === 0) {
            if (emptyState) emptyState.style.display = 'block';
            return;
        }

        if (emptyState) emptyState.style.display = 'none';

        filteredByTab.forEach(item => {
            const row = document.createElement('tr');
            row.onclick = () => openDistribution(item.id);
            
            const investorShare = ((item.profit * item.share_percent) / 100);
            
            row.innerHTML = `
                <td class="p-3">${escapeHtml(item.id)}</td>
                <td class="p-3"><strong>${escapeHtml(item.project)}</strong></td>
                <td class="p-3">${getDirectionHtml(item.direction)}</td>
                <td class="p-3">${formatCurrency(item.total_income)} ${TRANSLATIONS.sum}</td>
                <td class="p-3 text-danger">${formatCurrency(item.total_expense)} ${TRANSLATIONS.sum}</td>
                <td class="p-3 fw-bold text-success">${formatCurrency(item.profit)} ${TRANSLATIONS.sum}</td>
                <td class="p-3">
                    <span class="badge bg-primary">${item.share_percent}%</span>
                    <div class="small text-muted">${formatCurrency(investorShare)} ${TRANSLATIONS.sum}</div>
                </td>
                <td class="p-3">${escapeHtml(item.investor)}</td>
                <td class="p-3">${getStatusHtml(item.status)}</td>
                <td class="p-3">${formatDate(item.updated_at)}</td>
                <td class="p-3">
                    <button class="btn btn-sm btn-outline-primary" 
                            onclick="event.stopPropagation(); openDistribution(${item.id})"
                            title="${TRANSLATIONS.details}">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            `;
            body.appendChild(row);
        });
    }

    /* ============================
       FILTER FUNCTION
    ============================ */
    window.applyFilters = function() {
        const project = (document.getElementById("f_project")?.value || '').toLowerCase();
        const direction = document.getElementById("f_direction")?.value || '';
        const period = document.getElementById("f_period")?.value || '';
        const search = (document.getElementById("f_search")?.value || '').toLowerCase();

        const filtered = distributions.filter(x => {
            const matchProject = !project || x.project.toLowerCase().includes(project);
            const matchDirection = !direction || x.direction === direction;
            const matchPeriod = !period || x.updated_at.startsWith(period);
            const matchSearch = !search || JSON.stringify(x).toLowerCase().includes(search);

            return matchProject && matchDirection && matchPeriod && matchSearch;
        });

        loadTableData(filtered);
    };

    window.resetFilters = function() {
        document.getElementById("f_project").value = '';
        document.getElementById("f_direction").value = '';
        document.getElementById("f_period").value = '';
        document.getElementById("f_search").value = '';
        loadTableData();
    };

    /* ============================
       TAB SWITCH
    ============================ */
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll(".tab-btn").forEach(btn => {
            btn.addEventListener("click", function() {
                document.querySelectorAll(".tab-btn").forEach(b => b.classList.remove("active"));
                this.classList.add("active");
                activeTab = this.dataset.tab;
                loadTableData();
            });
        });
    });

    /* ============================
       DISTRIBUTION MODAL
    ============================ */
    window.openDistribution = function(id) {
        const item = distributions.find(e => e.id === id);
        if (!item) return;

        const distributionContent = document.getElementById("distributionContent");
        if (!distributionContent) return;

        const investorShare = ((item.profit * item.share_percent) / 100);
        const margin = ((item.profit / item.total_income) * 100).toFixed(2);

        distributionContent.innerHTML = `
            <div class="row mb-4">
                <div class="col-12">
                    <h4>${escapeHtml(item.project)}</h4>
                    <p class="text-muted mb-0">${getDirectionHtml(item.direction)}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">{{ __('Молиявий маълумотлар') }}</h5>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th width="200">${TRANSLATIONS.total_income}:</th>
                            <td class="fw-bold text-success">${formatCurrency(item.total_income)} ${TRANSLATIONS.sum}</td>
                        </tr>
                        <tr>
                            <th>${TRANSLATIONS.total_expense}:</th>
                            <td class="fw-bold text-danger">${formatCurrency(item.total_expense)} ${TRANSLATIONS.sum}</td>
                        </tr>
                        <tr class="table-light">
                            <th>${TRANSLATIONS.profit}:</th>
                            <td class="fw-bold text-primary fs-5">${formatCurrency(item.profit)} ${TRANSLATIONS.sum}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Фойда маржи') }}:</th>
                            <td><span class="badge bg-info">${margin}%</span></td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <h5 class="mb-3">{{ __('Тақсимот маълумотлари') }}</h5>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th width="200">${TRANSLATIONS.investor}:</th>
                            <td>${escapeHtml(item.investor)}</td>
                        </tr>
                        <tr>
                            <th>${TRANSLATIONS.share_percent}:</th>
                            <td><span class="badge bg-primary fs-6">${item.share_percent}%</span></td>
                        </tr>
                        <tr class="table-light">
                            <th>{{ __('Инвестор улуши') }}:</th>
                            <td class="fw-bold text-success fs-5">${formatCurrency(investorShare)} ${TRANSLATIONS.sum}</td>
                        </tr>
                        <tr>
                            <th>${TRANSLATIONS.status}:</th>
                            <td>${getStatusHtml(item.status)}</td>
                        </tr>
                        <tr>
                            <th>${TRANSLATIONS.updated_at}:</th>
                            <td>${formatDate(item.updated_at)}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>{{ __('Эслатма:') }}</strong> 
                        {{ __('Инвестор') }} <strong>${escapeHtml(item.investor)}</strong> 
                        {{ __('ушбу лойиҳадан') }} <strong>${formatCurrency(investorShare)} ${TRANSLATIONS.sum}</strong> 
                        {{ __('миқдорида фойда олади, бу умумий фойданинг') }} <strong>${item.share_percent}%</strong> {{ __('ини ташкил этади.') }}
                    </div>
                </div>
            </div>
        `;

        const modal = new bootstrap.Modal(document.getElementById('distributionModal'));
        modal.show();
    };

    /* ============================
       EXPORT & REPORT
    ============================ */
    window.exportData = function() {
        const headers = distributionColumns.map(c => c.label).slice(0, -1);
        const rows = [headers];

        distributions.forEach(item => {
            const investorShare = ((item.profit * item.share_percent) / 100);
            rows.push([
                item.id,
                item.project,
                item.direction,
                `${formatCurrency(item.total_income)} сўм`,
                `${formatCurrency(item.total_expense)} сўм`,
                `${formatCurrency(item.profit)} сўм`,
                `${item.share_percent}%`,
                item.investor,
                item.status,
                formatDate(item.updated_at)
            ]);
        });

        const csv = rows.map(r => r.map(c => `"${String(c).replace(/"/g, '""')}"`).join(',')).join('\n');
        const blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `distributions_${new Date().toISOString().slice(0, 10)}.csv`;
        a.click();
        URL.revokeObjectURL(url);
    };

    window.generateReport = function() {
        showAlert('info', '{{ __("Ҳисобот яратилмоқда...") }}');
        // Backend endpoint ga so'rov yuborish
    };

    window.printDistribution = function() {
        window.print();
    };

    /* ============================
       ALERT HELPER
    ============================ */
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${escapeHtml(message)}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        const container = document.querySelector('.breadcrumb-block');
        if (container) {
            container.insertAdjacentHTML('afterend', alertHtml);
            
            setTimeout(() => {
                const alert = document.querySelector('.alert');
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        }
    }

    /* ============================
       INIT
    ============================ */
    document.addEventListener('DOMContentLoaded', function() {
        renderTableHeader();
        loadTableData();

        // Search on Enter
        document.getElementById('f_search')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                applyFilters();
            }
        });
    });

})();
</script>