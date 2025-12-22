<script>
(function() {
    'use strict';

    /* ============================
       TRANSLATION CONSTANTS
    ============================ */
    const TRANSLATIONS = {
        paid: "{{ __('Тўланди') }}",
        pending: "{{ __('Кутилмоқда') }}",
        rejected: "{{ __('Рад этилган') }}",
        total_income: "{{ __('Жами даромад') }}",
        total_records: "{{ __('Жами ёзувлар') }}",
        confirm_delete: "{{ __('Ҳақиқатан ҳам ўчирмоқчимисиз?') }}",
        success_deleted: "{{ __('Муваффақиятли ўчирилди') }}",
        error_occurred: "{{ __('Хатолик юз берди') }}",
        no_document: "{{ __('Ҳужжат йўқ') }}",
        view_document: "{{ __('Ҳужжатни кўриш') }}",
        project: "{{ __('Лойиҳа') }}",
        category: "{{ __('Категория') }}",
        amount: "{{ __('Сумма') }}",
        date: "{{ __('Сана') }}",
        partner: "{{ __('Шерик') }}",
        phone: "{{ __('Телефон') }}",
        login: "{{ __('Логин') }}",
        status: "{{ __('Статус') }}",
        document: "{{ __('Ҳужжат') }}",
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

    function formatDate(dateString) {
    if (!dateString) return '<span class="text-muted">-</span>';

    const d = new Date(dateString);
    if (isNaN(d)) return '<span class="text-muted">-</span>';

    const day = String(d.getDate()).padStart(2, '0');
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const year = String(d.getFullYear()).slice(-2);

    return `${day}.${month}.${year}`;
}


    function formatCurrency(amount) {
        if (!amount) return '0';
        return Number(amount).toLocaleString('uz-UZ');
    }

    function parseAmount(amountStr) {
        if (!amountStr) return 0;
        return Number(amountStr.toString().replace(/[^\d]/g, ''));
    }

    /* ============================
       DEFAULT SAMPLE DATA
    ============================ */
    const DEFAULT_INCOME_DATA = [
        {
            id: 1,
            project: "Park Avenue",
            category: "Ijaradan daromad",
            amount: 12500000,
            partner: "Xolmatov Asror",
            phone: "+998 90 123 45 67",
            login: "asror_01",
            status: "paid",
            date: "2025-01-12",
            document: "contract_001.pdf"
        },
        {
            id: 2,
            project: "Green City",
            category: "Qurilish sotuvlari",
            amount: 45000000,
            partner: "Sattorov Diyor",
            phone: "+998 93 556 44 21",
            login: "diyor_dev",
            status: "pending",
            date: "2025-02-01",
            document: ""
        },
        {
            id: 3,
            project: "City Garden",
            category: "Er daromadi",
            amount: 9800000,
            partner: "Raximov Doniyor",
            phone: "+998 95 111 22 33",
            login: "doniyor_r",
            status: "rejected",
            date: "2025-02-15",
            document: "agreement_003.pdf"
        },
        {
            id: 4,
            project: "New Complex",
            category: "Ijaradan daromad",
            amount: 18300000,
            partner: "Sodiqova Munisa",
            phone: "+998 97 888 33 22",
            login: "munisa_s",
            status: "paid",
            date: "2025-03-01",
            document: "invoice_004.pdf"
        },
        {
            id: 5,
            project: "Panorama",
            category: "Qurilish sotuvlari",
            amount: 22000000,
            partner: "Nazarov Bekzod",
            phone: "+998 99 444 88 00",
            login: "bekzod_n",
            status: "pending",
            date: "2025-03-10",
            document: ""
        }
    ];

    /* ============================
       DATA MANAGEMENT
    ============================ */
    let incomeData = [...DEFAULT_INCOME_DATA];
    
    // Agar server-side ma'lumotlar mavjud bo'lsa:
    @if(isset($incomes) && count($incomes) > 0)
        incomeData = @json($incomes);
    @endif

    const CSRF_TOKEN = "{{ csrf_token() }}";
    const API_BASE = "{{ route('admin.incomes.index') }}";

    /* ============================
       STATUS HELPERS
    ============================ */
    function getStatusHtml(status) {
        let icon = "";
        let className = "";
        let label = "";

        switch(status) {
            case "paid":
                icon = "✔";
                className = "status-paid";
                label = TRANSLATIONS.paid;
                break;
            case "pending":
                icon = "⚠️";
                className = "status-pending";
                label = TRANSLATIONS.pending;
                break;
            case "rejected":
                icon = "✖";
                className = "status-rejected";
                label = TRANSLATIONS.rejected;
                break;
            default:
                icon = "?";
                className = "status-pending";
                label = status;
        }

        return `<span class="${className}">${icon} ${label}</span>`;
    }

    /* ============================
       SUMMARY CARDS
    ============================ */
    function renderSummary() {
        const total = incomeData.length;
        const paid = incomeData.filter(r => r.status === 'paid').length;
        const pending = incomeData.filter(r => r.status === 'pending').length;
        const rejected = incomeData.filter(r => r.status === 'rejected').length;
        const sumTotal = incomeData.reduce((acc, r) => acc + (Number(r.amount) || 0), 0);

        const summaryRow = document.getElementById('summaryRow');
        if (!summaryRow) return;

        summaryRow.innerHTML = `
            <div class="col-md-3">
                <div class="card p-3 summary-card">
                    <div class="small text-muted">${TRANSLATIONS.total_income}</div>
                    <div class="h4 mb-0">${formatCurrency(sumTotal)} ${TRANSLATIONS.sum}</div>
                    <div class="small text-muted mt-2">${total} ${TRANSLATIONS.total_records}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 summary-card paid">
                    <div class="small text-muted">${TRANSLATIONS.paid}</div>
                    <div class="h4 mb-0">${paid}</div>
                    <div class="small text-muted">${total > 0 ? ((paid/total)*100).toFixed(0) : 0}%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 summary-card pending">
                    <div class="small text-muted">${TRANSLATIONS.pending}</div>
                    <div class="h4 mb-0">${pending}</div>
                    <div class="small text-muted">${total > 0 ? ((pending/total)*100).toFixed(0) : 0}%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 summary-card rejected">
                    <div class="small text-muted">${TRANSLATIONS.rejected}</div>
                    <div class="h4 mb-0">${rejected}</div>
                    <div class="small text-muted">${total > 0 ? ((rejected/total)*100).toFixed(0) : 0}%</div>
                </div>
            </div>
        `;
    }

    /* ============================
       POPULATE PROJECT FILTER
    ============================ */
    function populateProjectFilter() {
        const projectFilter = document.getElementById('projectFilter');
        if (!projectFilter) return;

        const projects = [...new Set(incomeData.map(i => i.project))].sort();
        
        projectFilter.innerHTML = `<option value="">{{ __('Ҳаммаси') }}</option>`;
        projects.forEach(project => {
            projectFilter.innerHTML += `<option value="${escapeHtml(project)}">${escapeHtml(project)}</option>`;
        });
    }

    /* ============================
       TABLE RENDER
    ============================ */
    function loadIncomeTable(data = incomeData) {
        renderSummary();
        
        const tbody = document.getElementById('income-table-body');
        const emptyState = document.getElementById('emptyState');
        
        if (!tbody) return;

        tbody.innerHTML = "";

        if (data.length === 0) {
            if (emptyState) emptyState.style.display = 'block';
            return;
        }

        if (emptyState) emptyState.style.display = 'none';

        data.forEach((row, index) => {
            const tr = document.createElement('tr');
            
            const documentLink = row.document 
                ? `<a href="/documents/${escapeHtml(row.document)}" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-file-alt"></i>
                   </a>`
                : `<span class="text-muted small">${TRANSLATIONS.no_document}</span>`;

            tr.innerHTML = `
                <td>${index + 1}</td>
                <td class="fw-bold">${escapeHtml(row.id)}</td>
                <td>${escapeHtml(row.project)}</td>
                <td><span class="badge bg-info">${escapeHtml(row.category)}</span></td>
                <td class="fw-bold">${formatCurrency(row.amount)} ${TRANSLATIONS.sum}</td>
                <td>${formatDate(row.date)}</td>
                <td>${escapeHtml(row.partner)}</td>
                <td><a href="tel:${escapeHtml(row.phone)}">${escapeHtml(row.phone)}</a></td>
                <td><code>${escapeHtml(row.login)}</code></td>
                <td>${getStatusHtml(row.status)}</td>
                <td>${documentLink}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary action-btn" onclick="viewDetail(${row.id})" title="{{ __('Кўриш') }}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-success action-btn" onclick="editIncome(${row.id})" title="{{ __('Таҳрирлаш') }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger action-btn" onclick="deleteIncome(${row.id})" title="{{ __('Ўчириш') }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    /* ============================
       DETAIL MODAL
    ============================ */
    window.viewDetail = function(id) {
        const item = incomeData.find(i => i.id === id);
        if (!item) return;

        const detailContent = document.getElementById('detailContent');
        if (!detailContent) return;

        const documentLink = item.document 
            ? `<a href="/documents/${escapeHtml(item.document)}" target="_blank" class="btn btn-sm btn-primary">
                <i class="fas fa-download"></i> ${TRANSLATIONS.view_document}
               </a>`
            : `<span class="text-muted">${TRANSLATIONS.no_document}</span>`;

        detailContent.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm">
                        <tr><th width="150">${TRANSLATIONS.project}:</th><td>${escapeHtml(item.project)}</td></tr>
                        <tr><th>${TRANSLATIONS.category}:</th><td>${escapeHtml(item.category)}</td></tr>
                        <tr><th>${TRANSLATIONS.amount}:</th><td class="fw-bold">${formatCurrency(item.amount)} ${TRANSLATIONS.sum}</td></tr>
                        <tr><th>${TRANSLATIONS.date}:</th><td>${formatDate(item.date)}</td></tr>
                        <tr><th>${TRANSLATIONS.status}:</th><td>${getStatusHtml(item.status)}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm">
                        <tr><th width="150">${TRANSLATIONS.partner}:</th><td>${escapeHtml(item.partner)}</td></tr>
                        <tr><th>${TRANSLATIONS.phone}:</th><td><a href="tel:${escapeHtml(item.phone)}">${escapeHtml(item.phone)}</a></td></tr>
                        <tr><th>${TRANSLATIONS.login}:</th><td><code>${escapeHtml(item.login)}</code></td></tr>
                        <tr><th>${TRANSLATIONS.document}:</th><td>${documentLink}</td></tr>
                    </table>
                </div>
            </div>
        `;

        const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
        detailModal.show();
    };

    /* ============================
       EDIT & DELETE
    ============================ */
    window.editIncome = function(id) {
        // Redirect to edit page
        window.location.href = `${API_BASE}/${id}/edit`;
    };

    window.deleteIncome = function(id) {
        if (!confirm(TRANSLATIONS.confirm_delete)) return;

        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) loadingOverlay.classList.add('active');

        // AJAX request
        fetch(`${API_BASE}/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                incomeData = incomeData.filter(i => i.id !== id);
                loadIncomeTable();
                showAlert('success', data.message || TRANSLATIONS.success_deleted);
            } else {
                showAlert('danger', data.message || TRANSLATIONS.error_occurred);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', TRANSLATIONS.error_occurred);
        })
        .finally(() => {
            if (loadingOverlay) loadingOverlay.classList.remove('active');
        });
    };

    /* ============================
       FILTERS
    ============================ */
    function applyFilters() {
        const search = (document.getElementById('searchInput')?.value || '').toLowerCase();
        const category = document.getElementById('categoryFilter')?.value || '';
        const status = document.getElementById('statusFilter')?.value || '';
        const dateFrom = document.getElementById('dateFrom')?.value || '';
        const dateTo = document.getElementById('dateTo')?.value || '';
        const project = document.getElementById('projectFilter')?.value || '';

        const filtered = incomeData.filter(row => {
            // Search
            if (search) {
                const matchStr = (row.partner + row.login + row.phone).toLowerCase();
                if (!matchStr.includes(search)) return false;
            }

            // Category
            if (category && row.category !== category) return false;

            // Status
            if (status && row.status !== status) return false;

            // Project
            if (project && row.project !== project) return false;

            // Date from
            if (dateFrom && row.date < dateFrom) return false;

            // Date to
            if (dateTo && row.date > dateTo) return false;

            return true;
        });

        loadIncomeTable(filtered);
    }

    function resetFilters() {
        const form = document.getElementById('incomeFilterForm');
        if (form) form.reset();
        loadIncomeTable(incomeData);
    }

    /* ============================
       EXPORT FUNCTIONS
    ============================ */
    function exportToExcel() {
        // Simple CSV export (can be enhanced with XLSX library)
        const headers = ['ID', 'Лойиҳа', 'Категория', 'Сумма', 'Сана', 'Шерик', 'Телефон', 'Логин', 'Статус'];
        const rows = [headers];

        incomeData.forEach(row => {
            rows.push([
                row.id,
                row.project,
                row.category,
                `${row.amount} сўм`,
                row.date,
                row.partner,
                row.phone,
                row.login,
                row.status
            ]);
        });

        const csv = rows.map(r => r.map(c => `"${String(c).replace(/"/g, '""')}"`).join(',')).join('\n');
        const blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `incomes_${new Date().toISOString().slice(0, 10)}.csv`;
        a.click();
        URL.revokeObjectURL(url);
    }

    function exportToPdf() {
        // This would require a PDF library or backend endpoint
        showAlert('info', '{{ __("PDF экспорт ишлаб чиқилмоқда...") }}');
    }

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
       EVENT LISTENERS
    ============================ */
    document.addEventListener('DOMContentLoaded', function() {
        // Apply filters
        const applyFiltersBtn = document.getElementById('applyFilters');
        if (applyFiltersBtn) {
            applyFiltersBtn.addEventListener('click', applyFilters);
        }

        // Reset filters
        const resetFiltersBtn = document.getElementById('resetFilters');
        if (resetFiltersBtn) {
            resetFiltersBtn.addEventListener('click', resetFilters);
        }

        // Search on Enter
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    applyFilters();
                }
            });
        }

        // Export Excel
        const exportExcelBtn = document.getElementById('exportExcelBtn');
        if (exportExcelBtn) {
            exportExcelBtn.addEventListener('click', exportToExcel);
        }

        // Export PDF
        const exportPdfBtn = document.getElementById('exportPdfBtn');
        if (exportPdfBtn) {
            exportPdfBtn.addEventListener('click', exportToPdf);
        }

        // Populate filters
        populateProjectFilter();

        // Initial load
        loadIncomeTable();
    });

})();
</script>