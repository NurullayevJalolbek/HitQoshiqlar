<script>
(function() {
    'use strict';

    /* ============================
       TRANSLATION CONSTANTS
    ============================ */
    const TRANSLATIONS = {
        id: "№",
        period: "{{ __('Харажат даври') }}",
        account: "{{ __('Ҳисоб рақами') }}",
        amount: "{{ __('Умумий харажат қиймати') }}",
        found: "{{ __('Аниқланганлар') }}",
        not_found: "{{ __('Аниқланмаганлар') }}",
        need_check: "{{ __('Аниқлиқ киритиладиганлар') }}",
        currency: "{{ __('Валюта') }}",
        user: "{{ __('Фойдаланувчи') }}",
        updated_at: "{{ __('Охирги янгиланиш') }}",
        actions: "{{ __('Амаллар') }}",
        move_to_need_check: "{{ __('Аниқликка ўтказиш') }}",
        total_expenses: "{{ __('Жами харажатлар') }}",
        total_records: "{{ __('Жами ёзувлар') }}",
        import_saved: "{{ __('Импорт сақланди!') }}",
        moved_to_need_check: "{{ __('Аниқлик киритиладиганларга кўчирилди') }}",
        confirm_move: "{{ __('Ҳақиқатан ҳам ўтказмоқчимисиз?') }}",
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
        if (!dateString) return '';
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}.${month}.${year}`;
    }

    /* ============================
       DATA STRUCTURE
    ============================ */
    const expenseColumns = [
        { key: "id", label: TRANSLATIONS.id },
        { key: "period", label: TRANSLATIONS.period },
        { key: "account", label: TRANSLATIONS.account },
        { key: "amount", label: TRANSLATIONS.amount },
        { key: "found", label: TRANSLATIONS.found },
        { key: "not_found", label: TRANSLATIONS.not_found },
        { key: "need_check", label: TRANSLATIONS.need_check },
        { key: "currency", label: TRANSLATIONS.currency },
        { key: "user", label: TRANSLATIONS.user },
        { key: "updated_at", label: TRANSLATIONS.updated_at },
        { key: "actions", label: TRANSLATIONS.actions },
    ];

    let expenses = [
        {
            id: 1,
            period: "2025-11",
            account: "HR-ACC-12",
            amount: 120000000,
            found: 35,
            not_found: 12,
            need_check: 4,
            currency: "UZS",
            user: "Jasur R.",
            updated_at: "2025-11-15"
        },
        {
            id: 2,
            period: "2025-12",
            account: "ACC-304",
            amount: 85000,
            found: 9,
            not_found: 2,
            need_check: 1,
            currency: "USD",
            user: "Olim X.",
            updated_at: "2025-12-01"
        },
        {
            id: 3,
            period: "2026-01",
            account: "FIN-77",
            amount: 300000000,
            found: 88,
            not_found: 21,
            need_check: 7,
            currency: "UZS",
            user: "Madina I.",
            updated_at: "2026-01-10"
        },
    ];

    // Agar server-side ma'lumotlar mavjud bo'lsa:
    @if(isset($expenses) && count($expenses) > 0)
        expenses = @json($expenses);
    @endif

    let activeTab = "found";
    const CSRF_TOKEN = "{{ csrf_token() }}";

    /* ============================
       SUMMARY CARDS
    ============================ */
    function renderSummary() {
        const total = expenses.length;
        const totalFound = expenses.reduce((sum, e) => sum + (Number(e.found) || 0), 0);
        const totalNotFound = expenses.reduce((sum, e) => sum + (Number(e.not_found) || 0), 0);
        const totalNeedCheck = expenses.reduce((sum, e) => sum + (Number(e.need_check) || 0), 0);
        const totalAmount = expenses.reduce((sum, e) => sum + (Number(e.amount) || 0), 0);

        const summaryRow = document.getElementById('summaryRow');
        if (!summaryRow) return;

        summaryRow.innerHTML = `
            <div class="col-md-3">
                <div class="card p-3 stat-card">
                    <div class="small text-muted">${TRANSLATIONS.total_expenses}</div>
                    <div class="h4 mb-0">${formatCurrency(totalAmount)} ${TRANSLATIONS.sum}</div>
                    <div class="small text-muted mt-2">${total} ${TRANSLATIONS.total_records}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 stat-card found">
                    <div class="small text-muted">${TRANSLATIONS.found}</div>
                    <div class="h4 mb-0">${totalFound}</div>
                    <div class="small text-success">${total > 0 ? ((totalFound/(totalFound+totalNotFound+totalNeedCheck))*100).toFixed(0) : 0}%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 stat-card not-found">
                    <div class="small text-muted">${TRANSLATIONS.not_found}</div>
                    <div class="h4 mb-0">${totalNotFound}</div>
                    <div class="small text-danger">${total > 0 ? ((totalNotFound/(totalFound+totalNotFound+totalNeedCheck))*100).toFixed(0) : 0}%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 stat-card need-check">
                    <div class="small text-muted">${TRANSLATIONS.need_check}</div>
                    <div class="h4 mb-0">${totalNeedCheck}</div>
                    <div class="small text-warning">${total > 0 ? ((totalNeedCheck/(totalFound+totalNotFound+totalNeedCheck))*100).toFixed(0) : 0}%</div>
                </div>
            </div>
        `;
    }

    /* ============================
       UPDATE TAB BADGES
    ============================ */
    function updateTabBadges() {
        const foundCount = expenses.filter(x => x.found > 0).length;
        const notFoundCount = expenses.filter(x => x.not_found > 0).length;
        const needCheckCount = expenses.filter(x => x.need_check > 0).length;

        document.getElementById('badge-found').textContent = foundCount;
        document.getElementById('badge-not-found').textContent = notFoundCount;
        document.getElementById('badge-need-check').textContent = needCheckCount;
    }

    /* ============================
       RENDER TABLE HEADER
    ============================ */
    function renderTableHeader() {
        const header = document.getElementById("table-header");
        if (!header) return;

        header.innerHTML = expenseColumns.map(col =>
            `<th class="p-3 text-start">${col.label}</th>`
        ).join("");
    }

    /* ============================
       RENDER TABLE
    ============================ */
    function loadTableData(list = expenses) {
        renderSummary();
        updateTabBadges();

        const body = document.getElementById("table-body");
        const emptyState = document.getElementById("emptyState");

        if (!body) return;

        const filteredByTab = list.filter(x => {
            if (activeTab === "found") return x.found > 0;
            if (activeTab === "not_found") return x.not_found > 0;
            if (activeTab === "need_check") return x.need_check > 0;
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
            row.onclick = () => openCard(item.id);

            row.innerHTML = `
                <td class="p-3">${escapeHtml(item.id)}</td>
                <td class="p-3">${escapeHtml(item.period)}</td>
                <td class="p-3"><code>${escapeHtml(item.account)}</code></td>
                <td class="p-3 fw-bold">${formatCurrency(item.amount)} ${escapeHtml(item.currency)}</td>
                <td class="p-3"><span class="badge-found">${item.found}</span></td>
                <td class="p-3"><span class="badge-not-found">${item.not_found}</span></td>
                <td class="p-3"><span class="badge-need-check">${item.need_check}</span></td>
                <td class="p-3">${escapeHtml(item.currency)}</td>
                <td class="p-3">${escapeHtml(item.user)}</td>
                <td class="p-3">${formatDate(item.updated_at)}</td>
                <td class="p-3">
                    <button class="btn btn-sm btn-outline-warning"
                            onclick="event.stopPropagation(); moveToNeedCheck(${item.id})"
                            title="${TRANSLATIONS.move_to_need_check}">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-primary"
                            onclick="event.stopPropagation(); openCard(${item.id})"
                            title="{{ __('Кўриш') }}">
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
        const period = (document.getElementById("f_period")?.value || '').toLowerCase();
        const account = (document.getElementById("f_account")?.value || '').toLowerCase();
        const currency = document.getElementById("f_currency")?.value || '';
        const search = (document.getElementById("f_search")?.value || '').toLowerCase();

        const filtered = expenses.filter(x =>
            (!period || x.period.toLowerCase().includes(period)) &&
            (!account || x.account.toLowerCase().includes(account)) &&
            (!currency || x.currency === currency) &&
            (!search || JSON.stringify(x).toLowerCase().includes(search))
        );

        loadTableData(filtered);
    };

    window.resetFilters = function() {
        document.getElementById("f_period").value = '';
        document.getElementById("f_account").value = '';
        document.getElementById("f_currency").value = '';
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
       IMPORT MODAL
    ============================ */
    window.openImportModal = function() {
        const modal = new bootstrap.Modal(document.getElementById('importModal'));
        modal.show();
    };

    window.saveImport = function() {
        const period = document.getElementById('import_period').value;
        const currency = document.getElementById('import_currency').value;
        const file = document.getElementById('import_file').files[0];

        if (!file) {
            alert('{{ __("Файл танланг") }}');
            return;
        }

        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) loadingOverlay.classList.add('active');

        // Simulate import
        setTimeout(() => {
            alert(TRANSLATIONS.import_saved);
            bootstrap.Modal.getInstance(document.getElementById('importModal'))?.hide();
            if (loadingOverlay) loadingOverlay.classList.remove('active');
            loadTableData();
        }, 1000);
    };

    // Download template
    document.getElementById('downloadTemplateLink')?.addEventListener('click', function(e) {
        e.preventDefault();
        const csv = 'period,account,amount,currency,description\n2025-11,ACC-001,1000000,UZS,Test expense\n';
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'expenses_template.csv';
        a.click();
        URL.revokeObjectURL(url);
    });

    /* ============================
       CARD MODAL
    ============================ */
    window.openCard = function(id) {
        const item = expenses.find(e => e.id === id);
        if (!item) return;

        const cardContent = document.getElementById("cardContent");
        if (!cardContent) return;

        cardContent.innerHTML = `
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5 class="mb-3">{{ __('Асосий маълумотлар') }}</h5>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th width="180">${TRANSLATIONS.id}:</th>
                            <td>${escapeHtml(item.id)}</td>
                        </tr>
                        <tr>
                            <th>${TRANSLATIONS.period}:</th>
                            <td>${escapeHtml(item.period)}</td>
                        </tr>
                        <tr>
                            <th>${TRANSLATIONS.account}:</th>
                            <td><code>${escapeHtml(item.account)}</code></td>
                        </tr>
                        <tr>
                            <th>${TRANSLATIONS.amount}:</th>
                            <td class="fw-bold">${formatCurrency(item.amount)} ${escapeHtml(item.currency)}</td>
                        </tr>
                        <tr>
                            <th>${TRANSLATIONS.currency}:</th>
                            <td><span class="badge bg-secondary">${escapeHtml(item.currency)}</span></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">{{ __('Статистика') }}</h5>
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th width="180">${TRANSLATIONS.found}:</th>
                            <td><span class="badge-found">${item.found}</span></td>
                        </tr>
                        <tr>
                            <th>${TRANSLATIONS.not_found}:</th>
                            <td><span class="badge-not-found">${item.not_found}</span></td>
                        </tr>
                        <tr>
                            <th>${TRANSLATIONS.need_check}:</th>
                            <td><span class="badge-need-check">${item.need_check}</span></td>
                        </tr>
                        <tr>
                            <th>${TRANSLATIONS.user}:</th>
                            <td>${escapeHtml(item.user)}</td>
                        </tr>
                        <tr>
                            <th>${TRANSLATIONS.updated_at}:</th>
                            <td>${formatDate(item.updated_at)}</td>
                        </tr>
                    </table>
                </div>
            </div>
        `;

        const modal = new bootstrap.Modal(document.getElementById('cardModal'));
        modal.show();
    };

    /* ============================
       MOVE TO NEED CHECK
    ============================ */
    window.moveToNeedCheck = function(id) {
        if (!confirm(TRANSLATIONS.confirm_move)) return;

        const item = expenses.find(e => e.id === id);
        if (!item) return;

        item.need_check += 1;
        item.found = Math.max(item.found - 1, 0);
        item.updated_at = new Date().toISOString().split('T')[0];

        loadTableData();
        showAlert('success', `ID ${id} ${TRANSLATIONS.moved_to_need_check}`);
    };

    /* ============================
       EXPORT DATA
    ============================ */
    window.exportData = function() {
        const headers = expenseColumns.map(c => c.label).slice(0, -1); // Remove actions
        const rows = [headers];

        expenses.forEach(item => {
            rows.push([
                item.id,
                item.period,
                item.account,
                `${item.amount} ${item.currency}`,
                item.found,
                item.not_found,
                item.need_check,
                item.currency,
                item.user,
                item.updated_at
            ]);
        });

        const csv = rows.map(r => r.map(c => `"${String(c).replace(/"/g, '""')}"`).join(',')).join('\n');
        const blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `expenses_${new Date().toISOString().slice(0, 10)}.csv`;
        a.click();
        URL.revokeObjectURL(url);
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
