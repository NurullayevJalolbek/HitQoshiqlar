<script>
(function() {
    'use strict';

    /* ============================
       TRANSLATION CONSTANTS
    ============================ */
    const TRANSLATIONS = {
        identified: "{{ __('Аниқланган') }}",
        unidentified: "{{ __('Аниқланмаган') }}",
        needs_clarify: "{{ __('Аниқлик киритиладиган') }}",
        total_records: "{{ __('Жами ёзувлар') }}",
        confirm_delete: "{{ __('Ҳақиқатан ҳам ўчирмоқчимисиз?') }}",
        success_deleted: "{{ __('Муваффақиятли ўчирилди') }}",
        error_occurred: "{{ __('Хатолик юз берди') }}",
        import_success: "{{ __('Импорт тугади. Ёзувлар сони:') }}",
        import_error: "{{ __('Импортда хато:') }}",
        select_file: "{{ __('Файл танланг') }}",
        transaction_id: "{{ __('Транзакция ID') }}",
        period: "{{ __('Давр') }}",
        account: "{{ __('Ҳисоб') }}",
        amount: "{{ __('Сумма') }}",
        payer: "{{ __('Тўловчи') }}",
        details: "{{ __('Тафсилотлар') }}",
        project_hint: "{{ __('Лойиҳа маълумоти') }}",
        matched_project: "{{ __('Мослаштирилган лойиҳа') }}",
        type: "{{ __('Тури') }}",
        uploaded_by: "{{ __('Юклаган') }}",
        updated_at: "{{ __('Янгиланган') }}",
        status_changed: "{{ __('Ҳолат ўзгарди') }}",
        assigned_to: "{{ __('Бириктирилди:') }}",
        assigned_multiple: "{{ __('Бир неччага бириктирилди:') }}",
        moved_to_other: "{{ __('Ўтказилди → Бошқа даромад') }}",
        imported_via_csv: "{{ __('CSV орқали импорт қилинди') }}",
        enter_project_name: "{{ __('Лойиҳанинг номини ёки ID киритинг:') }}",
        enter_multiple_projects: "{{ __('Бир нечта лойиҳа, вергул билан ажратинг:') }}"
    };

    /* ============================
       UTILITY FUNCTIONS
    ============================ */
    const uid = () => Math.floor(Math.random() * 900000) + 100000;

    const STATUS = {
        identified: { 
            label: TRANSLATIONS.identified, 
            cls: 'badge-identified', 
            emoji: '☑' 
        },
        unidentified: { 
            label: TRANSLATIONS.unidentified, 
            cls: 'badge-unidentified', 
            emoji: '⚠️' 
        },
        needs_clarify: { 
            label: TRANSLATIONS.needs_clarify, 
            cls: 'badge-needs-clarify', 
            emoji: '✖' 
        }
    };

    function formatDateNow() {
        const now = new Date();
        const date = now.toISOString().split('T')[0];
        const time = now.toTimeString().split(' ')[0];
        return `${date} ${time}`;
    }

    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${day}.${month}.${year} ${hours}:${minutes}`;
    }

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

    /* ============================
       DEFAULT DATA
    ============================ */
    const DEFAULT_REVENUES = [
        {
            id: uid(),
            transaction_id: 'TX-50001',
            period: '2025-11',
            account: 'ACC-998877',
            amount: 5000000,
            currency: 'UZS',
            payer: 'Kom. bank A',
            details: 'Payment for project ABC (proj-abc)',
            project_hint: 'proj-abc',
            type: 'identified',
            matched_project: 'Project ABC',
            uploaded_by: 'Muhammad Auditor',
            updated_at: formatDateNow(),
            history: []
        },
        {
            id: uid(),
            transaction_id: 'TX-50002',
            period: '2025-11',
            account: 'ACC-884422',
            amount: 1200000,
            currency: 'USD',
            payer: 'Unknown payer',
            details: 'No project details',
            project_hint: '',
            type: 'unidentified',
            matched_project: null,
            uploaded_by: 'Muhammad Auditor',
            updated_at: formatDateNow(),
            history: []
        },
        {
            id: uid(),
            transaction_id: 'TX-50003',
            period: '2025-10',
            account: 'ACC-223344',
            amount: 800000,
            currency: 'UZS',
            payer: 'Kom. bank B',
            details: 'Transfer maybe for rent project',
            project_hint: 'rent',
            type: 'needs_clarify',
            matched_project: null,
            uploaded_by: 'Operator',
            updated_at: formatDateNow(),
            history: []
        }
    ];

    /* ============================
       DATA MANAGEMENT
       ESLATMA: Server-side bilan ishlash uchun tayyor
    ============================ */
    let revenues = [...DEFAULT_REVENUES];
    
    // Agar server-side ma'lumotlar mavjud bo'lsa:
    @if(isset($revenues) && count($revenues) > 0)
        revenues = @json($revenues);
    @endif

    // Simulated platform project identifiers
    let knownProjects = ['proj-abc', 'rent', 'land-01'];

    const CSRF_TOKEN = "{{ csrf_token() }}";
    const API_BASE = "{{ route('admin.revenues.index') }}";

    /* ============================
       SUMMARY RENDER
    ============================ */
    function renderSummary() {
        const total = revenues.length;
        const identified = revenues.filter(r => r.type === 'identified').length;
        const unidentified = revenues.filter(r => r.type === 'unidentified').length;
        const needs = revenues.filter(r => r.type === 'needs_clarify').length;
        const sumTotal = revenues.reduce((acc, r) => acc + (Number(r.amount) || 0), 0);

        const summaryRow = document.getElementById('summaryRow');
        if (!summaryRow) return;

        summaryRow.innerHTML = `
            <div class="col-md-3">
                <div class="card p-3 summary-card">
                    <div class="small-muted">${TRANSLATIONS.total_records}</div>
                    <div class="h5 mb-0">${total}</div>
                    <div class="small-muted mono mt-2">${sumTotal.toLocaleString()}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 summary-card identified">
                    <div class="small-muted">${TRANSLATIONS.identified}</div>
                    <div class="h5 mb-0">${identified} 
                        <span class="small-muted">(${total > 0 ? ((identified/total)*100).toFixed(0) : 0}%)</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 summary-card unidentified">
                    <div class="small-muted">${TRANSLATIONS.unidentified}</div>
                    <div class="h5 mb-0">${unidentified}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 summary-card needs-clarify">
                    <div class="small-muted">${TRANSLATIONS.needs_clarify}</div>
                    <div class="h5 mb-0">${needs}</div>
                </div>
            </div>
        `;
    }

    /* ============================
       TABLE RENDER
    ============================ */
    function countByType(record, type) {
        return record.type === type ? 1 : 0;
    }

    function renderTable(list = revenues) {
        renderSummary();
        
        const tbody = document.getElementById('revenuesTableBody');
        const emptyState = document.getElementById('emptyState');
        
        if (!tbody) return;

        tbody.innerHTML = '';

        if (list.length === 0) {
            if (emptyState) emptyState.style.display = 'block';
            return;
        }

        if (emptyState) emptyState.style.display = 'none';

        list.forEach((r, idx) => {
            const status = STATUS[r.type] || STATUS.unidentified;
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${idx + 1}</td>
                <td class="mono">${escapeHtml(r.transaction_id)}</td>
                <td>${escapeHtml(r.period)}</td>
                <td>${escapeHtml(r.account)}</td>
                <td><strong>${Number(r.amount).toLocaleString()}</strong> ${escapeHtml(r.currency)}</td>
                <td>${countByType(r, 'identified')}</td>
                <td>${countByType(r, 'unidentified')}</td>
                <td>${countByType(r, 'needs_clarify')}</td>
                <td>${escapeHtml(r.currency)}</td>
                <td>${escapeHtml(r.uploaded_by)}</td>
                <td>${formatDate(r.updated_at)}</td>
                <td><span class="${status.cls} badge">${status.emoji} ${status.label}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary action-btn" onclick="openDetail('${r.id}')">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-success action-btn" onclick="markAsIdentified('${r.id}')">
                        <i class="fas fa-check"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-warning action-btn" onclick="moveToClarify('${r.id}')">
                        <i class="fas fa-question"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    /* ============================
       DETAIL MODAL
    ============================ */
    window.openDetail = function(id) {
        const item = revenues.find(r => r.id == id);
        if (!item) return;

        // Top section
        const detailTop = document.getElementById('detailTop');
        if (detailTop) {
            detailTop.innerHTML = `
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5>${escapeHtml(item.transaction_id)} 
                            <small class="small-muted">(${escapeHtml(item.period)})</small>
                        </h5>
                        <div class="small-muted">${escapeHtml(item.account)} • ${escapeHtml(item.payer)}</div>
                    </div>
                    <div class="text-end">
                        <div class="h5">${Number(item.amount).toLocaleString()} ${escapeHtml(item.currency)}</div>
                        <div class="small-muted">${formatDate(item.updated_at)}</div>
                    </div>
                </div>
            `;
        }

        // Info tab
        const detailInfo = document.getElementById('detailInfo');
        if (detailInfo) {
            detailInfo.innerHTML = `
                <table class="table table-sm">
                    <tr><td><strong>${TRANSLATIONS.transaction_id}</strong></td><td class="mono">${escapeHtml(item.transaction_id)}</td></tr>
                    <tr><td><strong>${TRANSLATIONS.period}</strong></td><td>${escapeHtml(item.period)}</td></tr>
                    <tr><td><strong>${TRANSLATIONS.account}</strong></td><td>${escapeHtml(item.account)}</td></tr>
                    <tr><td><strong>${TRANSLATIONS.amount}</strong></td><td>${Number(item.amount).toLocaleString()} ${escapeHtml(item.currency)}</td></tr>
                    <tr><td><strong>${TRANSLATIONS.payer}</strong></td><td>${escapeHtml(item.payer)}</td></tr>
                    <tr><td><strong>${TRANSLATIONS.details}</strong></td><td>${escapeHtml(item.details)}</td></tr>
                    <tr><td><strong>${TRANSLATIONS.project_hint}</strong></td><td>${escapeHtml(item.project_hint || '-')}</td></tr>
                    <tr><td><strong>${TRANSLATIONS.matched_project}</strong></td><td>${escapeHtml(item.matched_project || '-')}</td></tr>
                    <tr><td><strong>${TRANSLATIONS.type}</strong></td><td><span class="badge ${STATUS[item.type].cls}">${STATUS[item.type].label}</span></td></tr>
                    <tr><td><strong>${TRANSLATIONS.uploaded_by}</strong></td><td>${escapeHtml(item.uploaded_by)}</td></tr>
                </table>
            `;
        }

        // History tab
        const histEl = document.getElementById('detailHistory');
        if (histEl) {
            histEl.innerHTML = '';
            const history = item.history || [];
            if (history.length === 0) {
                histEl.innerHTML = '<li class="list-group-item text-muted">{{ __("Тарих мавжуд эмас") }}</li>';
            } else {
                history.slice().reverse().forEach(h => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.innerHTML = `
                        <div class="small-muted">${formatDate(h.date)}</div>
                        <div>${escapeHtml(h.text)}</div>
                    `;
                    histEl.appendChild(li);
                });
            }
        }

        // Actions tab
        const actionsEl = document.getElementById('detailActions');
        if (actionsEl) {
            actionsEl.innerHTML = `
                <button class="btn btn-success" onclick="assignToProject('${item.id}')">
                    <i class="fas fa-link"></i> {{ __('Биткирмиш (битта лойиҳа)') }}
                </button>
                <button class="btn btn-secondary" onclick="assignToMultiple('${item.id}')">
                    <i class="fas fa-layer-group"></i> {{ __('Бир неччага биркитириш') }}
                </button>
                <button class="btn btn-warning" onclick="moveToClarify('${item.id}')">
                    <i class="fas fa-question-circle"></i> {{ __('Аниқликга ўтказиш') }}
                </button>
                <button class="btn btn-danger" onclick="moveToOtherIncome('${item.id}')">
                    <i class="fas fa-exchange-alt"></i> {{ __('Бошқа даромадга ўтказиш') }}
                </button>
            `;
        }

        // Show modal
        const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
        detailModal.show();
    };

    /* ============================
       ACTIONS
    ============================ */
    function addHistory(item, text) {
        item.history = item.history || [];
        item.history.push({ date: formatDateNow(), text });
        item.updated_at = formatDateNow();
    }

    window.markAsIdentified = function(id) {
        const it = revenues.find(r => r.id == id);
        if (!it) return;

        let matched = null;
        if (it.project_hint) {
            const hint = it.project_hint.toLowerCase();
            matched = knownProjects.find(p => hint.includes(p));
        }

        it.type = 'identified';
        it.matched_project = matched || it.matched_project || null;
        addHistory(it, `${TRANSLATIONS.status_changed} → ${TRANSLATIONS.identified}. ${TRANSLATIONS.matched_project}: ${it.matched_project || '—'}`);
        
        renderTable();
        showAlert('success', TRANSLATIONS.status_changed);
    };

    window.moveToClarify = function(id) {
        const it = revenues.find(r => r.id == id);
        if (!it) return;

        it.type = 'needs_clarify';
        addHistory(it, `${TRANSLATIONS.status_changed} → ${TRANSLATIONS.needs_clarify}`);
        
        renderTable();
        showAlert('info', TRANSLATIONS.status_changed);
    };

    window.moveToOtherIncome = function(id) {
        const it = revenues.find(r => r.id == id);
        if (!it) return;

        it.type = 'needs_clarify';
        addHistory(it, TRANSLATIONS.moved_to_other);
        
        renderTable();
        showAlert('info', TRANSLATIONS.moved_to_other);
    };

    window.assignToProject = function(id) {
        const it = revenues.find(r => r.id == id);
        if (!it) return;

        const project = prompt(TRANSLATIONS.enter_project_name);
        if (!project) return;

        it.matched_project = project;
        it.type = 'identified';
        addHistory(it, `${TRANSLATIONS.assigned_to} ${project}`);
        
        renderTable();
        bootstrap.Modal.getInstance(document.getElementById('detailModal'))?.hide();
        showAlert('success', `${TRANSLATIONS.assigned_to} ${project}`);
    };

    window.assignToMultiple = function(id) {
        const it = revenues.find(r => r.id == id);
        if (!it) return;

        const projects = prompt(TRANSLATIONS.enter_multiple_projects);
        if (!projects) return;

        it.matched_project = projects;
        it.type = 'identified';
        addHistory(it, `${TRANSLATIONS.assigned_multiple} ${projects}`);
        
        renderTable();
        bootstrap.Modal.getInstance(document.getElementById('detailModal'))?.hide();
        showAlert('success', `${TRANSLATIONS.assigned_multiple} ${projects}`);
    };

    /* ============================
       FILTER & SEARCH
    ============================ */
    function applyFilter() {
        const searchInput = document.getElementById('searchInput');
        const filterType = document.getElementById('filterType');
        
        if (!searchInput || !filterType) return;

        const q = (searchInput.value || '').toLowerCase().trim();
        const type = filterType.value;

        const filtered = revenues.filter(r => {
            const matchesSearch = !q || 
                (r.transaction_id || '').toLowerCase().includes(q) ||
                (r.account || '').toLowerCase().includes(q) ||
                (r.details || '').toLowerCase().includes(q) ||
                (r.matched_project || '').toLowerCase().includes(q) ||
                (r.payer || '').toLowerCase().includes(q);

            const matchesType = !type || r.type === type;

            return matchesSearch && matchesType;
        });

        renderTable(filtered);
    }

    /* ============================
       CSV PARSING
    ============================ */
    function parseCSV(text) {
        const lines = text.split(/\r?\n/).map(l => l.trim()).filter(l => l.length);
        const rows = [];
        const headers = lines[0].split(',').map(h => h.trim());
        
        for (let i = 1; i < lines.length; i++) {
            const cols = lines[i].split(',').map(c => c.trim());
            const obj = {};
            headers.forEach((h, idx) => obj[h] = cols[idx] ?? '');
            rows.push(obj);
        }
        
        return rows;
    }

    /* ============================
       IMPORT
    ============================ */
    const importForm = document.getElementById('importForm');
    if (importForm) {
        importForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const fileInput = document.getElementById('importFile');
            if (!fileInput.files || !fileInput.files[0]) {
                alert(TRANSLATIONS.select_file);
                return;
            }

            const period = document.getElementById('importPeriod').value;
            const loadingOverlay = document.getElementById('loadingOverlay');
            if (loadingOverlay) loadingOverlay.classList.add('active');

            const reader = new FileReader();
            reader.onload = function(ev) {
                try {
                    const rows = parseCSV(ev.target.result);
                    
                    rows.forEach(r => {
                        const hint = (r.project_hint || r.details || '').toLowerCase();
                        const matched = knownProjects.find(p => hint.includes(p));
                        const type = matched ? 'identified' : 'unidentified';
                        
                        const rev = {
                            id: uid(),
                            transaction_id: r.transaction_id || ('TX-' + uid()),
                            period: period || r.period || new Date().toISOString().slice(0, 7),
                            account: r.account || r.account_number || '',
                            amount: Number((r.amount || 0).toString().replace(/\s/g, '')) || 0,
                            currency: r.currency || 'UZS',
                            payer: r.payer || r.payer_name || '',
                            details: r.details || '',
                            project_hint: r.project_hint || '',
                            type,
                            matched_project: matched || null,
                            uploaded_by: 'Importer',
                            updated_at: formatDateNow(),
                            history: [{ date: formatDateNow(), text: TRANSLATIONS.imported_via_csv }]
                        };
                        revenues.push(rev);
                    });

                    renderTable();
                    bootstrap.Modal.getInstance(document.getElementById('importModal'))?.hide();
                    showAlert('success', `${TRANSLATIONS.import_success} ${rows.length}`);
                } catch (err) {
                    console.error('Import error:', err);
                    showAlert('danger', `${TRANSLATIONS.import_error} ${err.message}`);
                } finally {
                    if (loadingOverlay) loadingOverlay.classList.remove('active');
                }
            };
            
            reader.readAsText(fileInput.files[0], 'utf-8');
        });
    }

    /* ============================
       EXPORT
    ============================ */
    function exportCSV() {
        const rows = [
            ['id', 'transaction_id', 'period', 'account', 'amount', 'currency', 'payer', 'details', 'project_hint', 'type', 'matched_project', 'uploaded_by', 'updated_at']
        ];
        
        revenues.forEach(r => {
            rows.push([
                r.id,
                r.transaction_id,
                r.period,
                r.account,
                r.amount,
                r.currency,
                r.payer,
                (r.details || '').replace(/,/g, ' '),
                r.project_hint,
                r.type,
                r.matched_project || '',
                r.uploaded_by,
                r.updated_at
            ]);
        });

        const csv = rows.map(r => r.map(c => `"${String(c).replace(/"/g, '""')}"`).join(',')).join('\n');
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `revenues_export_${new Date().toISOString().slice(0, 10)}.csv`;
        a.click();
        URL.revokeObjectURL(url);
    }

    /* ============================
       TEMPLATE DOWNLOAD
    ============================ */
    function downloadTemplate() {
        const example = 'transaction_id,period,account,amount,currency,payer,details,project_hint\n' +
            'TX-90000,2025-11,ACC-111,1000000,UZS,XYZ Bank,Payment for proj-abc,proj-abc\n' +
            'TX-90001,2025-11,ACC-222,500000,USD,ABC Corp,Rent payment,rent\n';
        
        const blob = new Blob([example], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'revenues_template.csv';
        a.click();
        URL.revokeObjectURL(url);
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
        // Filter button
        const applyFilterBtn = document.getElementById('applyFilter');
        if (applyFilterBtn) {
            applyFilterBtn.addEventListener('click', applyFilter);
        }

        // Search on Enter
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    applyFilter();
                }
            });
        }

        // Export button
        const exportBtn = document.getElementById('exportBtn');
        if (exportBtn) {
            exportBtn.addEventListener('click', exportCSV);
        }

        // Template downloads
        const downloadTemplateBtn = document.getElementById('downloadTemplate');
        if (downloadTemplateBtn) {
            downloadTemplateBtn.addEventListener('click', function(e) {
                e.preventDefault();
                downloadTemplate();
            });
        }

        const exampleDownload = document.getElementById('exampleDownload');
        if (exampleDownload) {
            exampleDownload.addEventListener('click', function(e) {
                e.preventDefault();
                downloadTemplate();
            });
        }

        // Initial render
        renderTable();
    });

})();
</script>