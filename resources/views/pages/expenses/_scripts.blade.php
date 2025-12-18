<script>
(function() {
    'use strict';

    /* ============================
       TRANSLATION CONSTANTS
    ============================ */
    const T = {
        id: "№",
        period: "{{ __('Харажат даври') }}",
        account: "{{ __('Ҳисоб рақами') }}",
        amount: "{{ __('Умумий харажат қиймати') }}",
        found: "{{ __('Аниқланганлар сони') }}",
        not_found: "{{ __('Аниқланмаганлар сони') }}",
        need_check: "{{ __('Аниқлиқ киритиладиганлар сони') }}",
        currency: "{{ __('Валютаси') }}",
        user: "{{ __('Фойдаланувчи Ф.И.О.') }}",
        updated_at: "{{ __('Охирги янгиланиш') }}",
        actions: "{{ __('Амаллар') }}",
        move_to_need_check: "{{ __('Аниқликка ўтказиш') }}",
        total_expenses: "{{ __('Жами харажатлар') }}",
        total_records: "{{ __('Жами ёзувлар') }}",
        import_saved: "{{ __('Импорт муваффақиятли сақланди!') }}",
        moved_to_need_check: "{{ __('Аниқлик киритиладиганларга кўчирилди') }}",
        confirm_move: "{{ __('Ҳақиқатан ҳам ўтказмоқчимисиз?') }}",
        sum: "{{ __('сўм') }}",
        bank_id: "{{ __('Банк транзакция ID') }}",
        doc_number: "{{ __('Ҳужжат рақами') }}",
        date: "{{ __('Харажат санаси') }}",
        payer: "{{ __('Қабул қилувчи') }}",
        details: "{{ __('Тўлов тафсилотлари') }}",
        project: "{{ __('Инвестицион лойиҳа') }}",
        contract: "{{ __('Шартнома') }}",
        attached_user: "{{ __('Бириктирган фойдаланувчи') }}",
        attached_at: "{{ __('Бириктирилган сана') }}",
        comment: "{{ __('Изоҳ') }}",
        attach: "{{ __('Бириктириш') }}",
        attach_multiple: "{{ __('Бир нечтасига бириктириш') }}",
        move_to_other: "{{ __('Бошқа харажатларга ўтказиш') }}",
        history: "{{ __('Ўзгаришлар тарихи') }}",
        time: "{{ __('Вақт') }}",
        action: "{{ __('Ҳаракат') }}",
        note: "{{ __('Эслатма') }}",
        view: "{{ __('Кўриш') }}",
        save: "{{ __('Сақлаш') }}",
        cancel: "{{ __('Бекор қилиш') }}",
        close: "{{ __('Ёпиш') }}",
        attached_success: "{{ __('Харажат лойиҳага бириктирилди') }}",
        moved_to_other: "{{ __('Бошқа харажатларга кўчирилди') }}"
    };

    /* ============================
       UTILITY FUNCTIONS
    ============================ */
    function esc(text) {
        if (!text) return '';
        const m = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, c => m[c]);
    }

    function fmt(amount) {
        if (!amount) return '0';
        return Number(amount).toLocaleString('uz-UZ');
    }

    function fmtDate(dateString) {
        if (!dateString) return '';
        const d = new Date(dateString);
        const day = String(d.getDate()).padStart(2, '0');
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const year = d.getFullYear();
        return `${day}.${month}.${year}`;
    }

    function fmtDateTime(dateString) {
        if (!dateString) return '';
        const d = new Date(dateString);
        return `${fmtDate(dateString)} ${String(d.getHours()).padStart(2,'0')}:${String(d.getMinutes()).padStart(2,'0')}`;
    }

    /* ============================
       DATA STRUCTURE
    ============================ */
    const expenseColumns = [{
            key: "id",
            label: T.id
        },
        {
            key: "period",
            label: T.period
        },
        {
            key: "account",
            label: T.account
        },
        {
            key: "amount",
            label: T.amount
        },
        {
            key: "found",
            label: T.found
        },
        {
            key: "not_found",
            label: T.not_found
        },
        {
            key: "need_check",
            label: T.need_check
        },
        {
            key: "currency",
            label: T.currency
        },
        {
            key: "user",
            label: T.user
        },
        {
            key: "updated_at",
            label: T.updated_at
        },
        {
            key: "actions",
            label: T.actions
        },
    ];

    let expenses = [{
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

    @if(isset($expenses) && count($expenses) > 0)
    expenses = @json($expenses);
    @endif

    let activeTab = "found";
    let currentExpenseId = null;
    const CSRF_TOKEN = "{{ csrf_token() }}";

    /* ============================
       DEMO PAYMENT DATA
    ============================ */
    const demoPayments = {
        found: [{
                id: 1,
                bank_id: 'TRX-2025-0001',
                doc_number: 'INV-001',
                date: '2025-11-05',
                amount: 15000000,
                currency: 'UZS',
                payer: 'OOO "Premium Invest"',
                details: 'Loyiha to\'lovi',
                project: 'PRJ-2024-001',
                contract: 'CNT-2025-001',
                user: 'Abdullayev J.M.',
                attached_at: '2025-11-05 14:22',
                comment: ''
            },
            {
                id: 2,
                bank_id: 'TRX-2025-0002',
                doc_number: 'INV-002',
                date: '2025-11-06',
                amount: 25000000,
                currency: 'UZS',
                payer: 'MChJ "Texno Group"',
                details: 'Shartnoma bo\'yicha',
                project: 'PRJ-2024-002',
                contract: 'CNT-2025-002',
                user: 'Karimov A.S.',
                attached_at: '2025-11-06 10:15',
                comment: ''
            },
        ],
        not_found: [{
                id: 21,
                bank_id: 'TRX-2025-0101',
                doc_number: 'DOC-991',
                date: '2025-11-07',
                amount: 25000000,
                currency: 'UZS',
                payer: 'Noma\'lum mijoz',
                details: 'To\'lov maqsadi: kvartira uchun'
            },
            {
                id: 22,
                bank_id: 'TRX-2025-0102',
                doc_number: 'DOC-992',
                date: '2025-11-08',
                amount: 12000000,
                currency: 'UZS',
                payer: 'Shaxsiy transfer',
                details: 'Izoh yo\'q'
            },
        ],
        need_check: [{
                id: 31,
                bank_id: 'TRX-2025-0201',
                doc_number: 'DOC-150',
                date: '2025-11-09',
                amount: 30000000,
                currency: 'UZS',
                payer: 'OOO "Boshqa daromad"',
                details: 'Boshqa turdagi tushum',
                note: 'Ehtimol boshqa daromad'
            },
            {
                id: 32,
                bank_id: 'TRX-2025-0202',
                doc_number: 'DOC-151',
                date: '2025-11-10',
                amount: 18000000,
                currency: 'UZS',
                payer: 'MChJ "Nomalum"',
                details: 'To\'lov sababi noma\'lum',
                note: 'Tekshirish talab qilinadi'
            },
        ]
    };

    const demoHistory = [{
            time: '2025-11-15 14:22',
            user: 'Abdullayev J.M.',
            action: 'Харажат лойиҳага бириктирилди',
            note: 'PRJ-2024-001 га бириктирилди'
        },
        {
            time: '2025-11-14 09:30',
            user: 'Система',
            action: 'Импорт файл юкланди',
            note: '50 та ёзув қўшилди'
        },
        {
            time: '2025-11-13 16:45',
            user: 'Karimov A.S.',
            action: 'Аниқланмаганларга ўтказилди',
            note: 'Лойиҳа топилмади'
        },
    ];

    /* ============================
       SUMMARY CARDS
    ============================ */
    function renderSummary() {
        const total = expenses.length;
        const totalFound = expenses.reduce((s, e) => s + (Number(e.found) || 0), 0);
        const totalNotFound = expenses.reduce((s, e) => s + (Number(e.not_found) || 0), 0);
        const totalNeedCheck = expenses.reduce((s, e) => s + (Number(e.need_check) || 0), 0);
        const totalAmount = expenses.reduce((s, e) => s + (Number(e.amount) || 0), 0);
        const totalAll = totalFound + totalNotFound + totalNeedCheck;

        const summaryRow = document.getElementById('summaryRow');
        if (!summaryRow) return;

        summaryRow.innerHTML = `
            <div class="col-md-3">
                <div class="card p-3 stat-card">
                    <div class="small text-muted">${T.total_expenses}</div>
                    <div class="h4 mb-0">${fmt(totalAmount)} ${T.sum}</div>
                    <div class="small text-muted mt-2">${total} ${T.total_records}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 stat-card found">
                    <div class="small text-muted">${T.found}</div>
                    <div class="h4 mb-0 text-success">${totalFound}</div>
                    <div class="small text-success">${totalAll>0 ? ((totalFound/totalAll)*100).toFixed(1) : 0}%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 stat-card not-found">
                    <div class="small text-muted">${T.not_found}</div>
                    <div class="h4 mb-0 text-danger">${totalNotFound}</div>
                    <div class="small text-danger">${totalAll>0 ? ((totalNotFound/totalAll)*100).toFixed(1) : 0}%</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 stat-card need-check">
                    <div class="small text-muted">${T.need_check}</div>
                    <div class="h4 mb-0 text-warning">${totalNeedCheck}</div>
                    <div class="small text-warning">${totalAll>0 ? ((totalNeedCheck/totalAll)*100).toFixed(1) : 0}%</div>
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
        header.innerHTML = expenseColumns.map(col => `<th class="p-3 text-start">${col.label}</th>`).join("");
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

        const filtered = list.filter(x => {
            if (activeTab === "found") return x.found > 0;
            if (activeTab === "not_found") return x.not_found > 0;
            if (activeTab === "need_check") return x.need_check > 0;
            return false;
        });

        body.innerHTML = "";

        if (filtered.length === 0) {
            if (emptyState) emptyState.style.display = 'block';
            return;
        }

        if (emptyState) emptyState.style.display = 'none';

        filtered.forEach(item => {
            const row = document.createElement('tr');
            row.onclick = () => openCard(item.id);
            row.innerHTML = `
                <td class="p-3">${esc(item.id)}</td>
                <td class="p-3">${esc(item.period)}</td>
                <td class="p-3"><code>${esc(item.account)}</code></td>
                <td class="p-3 fw-bold">${fmt(item.amount)} ${esc(item.currency)}</td>
                <td class="p-3"><span class="badge-found">${item.found}</span></td>
                <td class="p-3"><span class="badge-not-found">${item.not_found}</span></td>
                <td class="p-3"><span class="badge-need-check">${item.need_check}</span></td>
                <td class="p-3">${esc(item.currency)}</td>
                <td class="p-3">${esc(item.user)}</td>
                <td class="p-3">${fmtDate(item.updated_at)}</td>
                <td class="p-3">
                    <button class="btn btn-sm btn-outline-primary" onclick="event.stopPropagation(); openCard(${item.id})" title="${T.view}">
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
                document.querySelectorAll(".tab-btn").forEach(b => b.classList.remove(
                    "active"));
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

        if (!period || !currency || !file) {
            alert('{{ __("Барча майдонларни тўлдиринг") }}');
            return;
        }

        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) loadingOverlay.classList.add('active');

        setTimeout(() => {
            showAlert('success', T.import_saved);
            bootstrap.Modal.getInstance(document.getElementById('importModal'))?.hide();
            if (loadingOverlay) loadingOverlay.classList.remove('active');

            document.getElementById('import_period').value = '';
            document.getElementById('import_currency').value = 'UZS';
            document.getElementById('import_file').value = '';

            loadTableData();
        }, 1500);
    };

    document.getElementById('downloadTemplateLink')?.addEventListener('click', function(e) {
        e.preventDefault();
        const csv =
            'bank_id,doc_number,date,amount,currency,payer,details,project_code\nTRX-2025-0001,INV-001,2025-11-01,1000000,UZS,Test Company,Test payment,PRJ-2024-001\n';
        const blob = new Blob(['\ufeff' + csv], {
            type: 'text/csv;charset=utf-8;'
        });
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
        currentExpenseId = id;
        const item = expenses.find(e => e.id === id);
        if (!item) return;

        const cardContent = document.getElementById("cardContent");
        if (!cardContent) return;

        cardContent.innerHTML = `
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5 class="mb-3">{{ __('Асосий маълумотлар') }}</h5>
                    <table class="table table-sm table-bordered">
                        <tr><th width="180">${T.id}:</th><td>${esc(item.id)}</td></tr>
                        <tr><th>${T.period}:</th><td>${esc(item.period)}</td></tr>
                        <tr><th>${T.account}:</th><td><code>${esc(item.account)}</code></td></tr>
                        <tr><th>${T.amount}:</th><td class="fw-bold">${fmt(item.amount)} ${esc(item.currency)}</td></tr>
                        <tr><th>${T.currency}:</th><td><span class="badge bg-secondary">${esc(item.currency)}</span></td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">{{ __('Статистика') }}</h5>
                    <table class="table table-sm table-bordered">
                        <tr><th width="180">${T.found}:</th><td><span class="badge-found">${item.found}</span></td></tr>
                        <tr><th>${T.not_found}:</th><td><span class="badge-not-found">${item.not_found}</span></td></tr>
                        <tr><th>${T.need_check}:</th><td><span class="badge-need-check">${item.need_check}</span></td></tr>
                        <tr><th>${T.user}:</th><td>${esc(item.user)}</td></tr>
                        <tr><th>${T.updated_at}:</th><td>${fmtDate(item.updated_at)}</td></tr>
                    </table>
                </div>
            </div>
            <hr>
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item"><button class="nav-link active payment-tab-btn" data-bs-toggle="tab" data-bs-target="#tab-found-payments">${T.found} <span class="badge bg-success ms-1">${demoPayments.found.length}</span></button></li>
                <li class="nav-item"><button class="nav-link payment-tab-btn" data-bs-toggle="tab" data-bs-target="#tab-notfound-payments">${T.not_found} <span class="badge bg-danger ms-1">${demoPayments.not_found.length}</span></button></li>
                <li class="nav-item"><button class="nav-link payment-tab-btn" data-bs-toggle="tab" data-bs-target="#tab-needcheck-payments">${T.need_check} <span class="badge bg-warning ms-1">${demoPayments.need_check.length}</span></button></li>
                <li class="nav-item"><button class="nav-link payment-tab-btn" data-bs-toggle="tab" data-bs-target="#tab-history">${T.history}</button></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-found-payments">
                    ${renderPaymentFilter('found')}
                    ${renderFoundPaymentsTable()}
                </div>
                <div class="tab-pane fade" id="tab-notfound-payments">
                    ${renderPaymentFilter('not_found')}
                    ${renderNotFoundPaymentsTable()}
                </div>
                <div class="tab-pane fade" id="tab-needcheck-payments">
                    ${renderPaymentFilter('need_check')}
                    ${renderNeedCheckPaymentsTable()}
                </div>
                <div class="tab-pane fade" id="tab-history">
                    ${renderHistoryTable()}
                </div>
            </div>
        `;

        const modal = new bootstrap.Modal(document.getElementById('cardModal'));
        modal.show();
    };

    function renderPaymentFilter(type) {
        return `
            <div class="filter-row mb-2 p-2 bg-light rounded">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label mb-1 small">ID / ${T.bank_id}</label>
                        <input type="text" class="form-control form-control-sm" id="${type}_search_id" placeholder="ID...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label mb-1 small">${T.date}</label>
                        <input type="date" class="form-control form-control-sm" id="${type}_search_date">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label mb-1 small">${T.amount}</label>
                        <input type="text" class="form-control form-control-sm" id="${type}_search_amount" placeholder="0">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label mb-1 small">${T.payer}</label>
                        <input type="text" class="form-control form-control-sm" id="${type}_search_payer" placeholder="">
                    </div>
                    <div class="col-md-2 d-flex gap-1">
                        <button class="btn btn-primary btn-sm flex-fill" onclick="alert('Фильтр - UI only')" title="Филтрлаш">
                            <i class="fas fa-filter"></i>
                        </button>
                        <button class="btn btn-outline-secondary btn-sm flex-fill" onclick="alert('Тозалаш - UI only')" title="Тозалаш">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    function renderFoundPaymentsTable() {
        return `
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>${T.bank_id}</th>
                            <th>${T.doc_number}</th>
                            <th>${T.date}</th>
                            <th>${T.amount}</th>
                            <th>${T.payer}</th>
                            <th>${T.details}</th>
                            <th>${T.project}</th>
                            <th>${T.contract}</th>
                            <th>${T.attached_user}</th>
                            <th>${T.attached_at}</th>
                            <th>${T.actions}</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${demoPayments.found.map(p => `
                            <tr>
                                <td>${p.id}</td>
                                <td><code class="small">${esc(p.bank_id)}</code></td>
                                <td>${esc(p.doc_number)}</td>
                                <td>${esc(p.date)}</td>
                                <td class="text-end">${fmt(p.amount)} <small class="text-muted">${esc(p.currency)}</small></td>
                                <td>${esc(p.payer)}</td>
                                <td><small>${esc(p.details)}</small></td>
                                <td><span class="badge bg-info">${esc(p.project||'')}</span></td>
                                <td>${esc(p.contract||'')}</td>
                                <td><small>${esc(p.user||'')}</small></td>
                                <td><small>${esc(p.attached_at||'')}</small></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-warning" onclick="movePaymentToNeedCheck(${p.id})" title="${T.move_to_need_check}">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        `;
    }

    function renderNotFoundPaymentsTable() {
        return `
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>${T.bank_id}</th>
                            <th>${T.doc_number}</th>
                            <th>${T.date}</th>
                            <th>${T.amount}</th>
                            <th>${T.payer}</th>
                            <th>${T.details}</th>
                            <th>${T.actions}</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${demoPayments.not_found.map(p => `
                            <tr>
                                <td>${p.id}</td>
                                <td><code class="small">${esc(p.bank_id)}</code></td>
                                <td>${esc(p.doc_number)}</td>
                                <td>${esc(p.date)}</td>
                                <td class="text-end">${fmt(p.amount)} <small class="text-muted">${esc(p.currency)}</small></td>
                                <td>${esc(p.payer)}</td>
                                <td><small>${esc(p.details)}</small></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-sm btn-outline-primary" onclick="openAttachModal(${p.id})" title="${T.attach}">
                                        <i class="fas fa-link"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="openAttachMultipleModal(${p.id})" title="${T.attach_multiple}">
                                        <i class="fas fa-link"></i><i class="fas fa-plus" style="font-size:0.6rem;"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning" onclick="movePaymentToNeedCheck(${p.id})" title="${T.move_to_need_check}">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-info" onclick="movePaymentToOther(${p.id})" title="${T.move_to_other}">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        `;
    }

    function renderNeedCheckPaymentsTable() {
        return `
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>${T.bank_id}</th>
                            <th>${T.doc_number}</th>
                            <th>${T.date}</th>
                            <th>${T.amount}</th>
                            <th>${T.payer}</th>
                            <th>${T.details}</th>
                            <th>${T.note}</th>
                            <th>${T.actions}</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${demoPayments.need_check.map(p => `
                            <tr>
                                <td>${p.id}</td>
                                <td><code class="small">${esc(p.bank_id)}</code></td>
                                <td>${esc(p.doc_number)}</td>
                                <td>${esc(p.date)}</td>
                                <td class="text-end">${fmt(p.amount)} <small class="text-muted">${esc(p.currency)}</small></td>
                                <td>${esc(p.payer)}</td>
                                <td><small>${esc(p.details)}</small></td>
                                <td><small class="text-warning">${esc(p.note||'')}</small></td>
                                <td class="text-nowrap">
                                    <button class="btn btn-sm btn-outline-primary" onclick="openAttachModal(${p.id})" title="${T.attach}">
                                        <i class="fas fa-link"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="openAttachMultipleModal(${p.id})" title="${T.attach_multiple}">
                                        <i class="fas fa-link"></i><i class="fas fa-plus" style="font-size:0.6rem;"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-info" onclick="movePaymentToOther(${p.id})" title="${T.move_to_other}">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        `;
    }

    function renderHistoryTable() {
        return `
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="180">${T.time}</th>
                            <th width="200">${T.user}</th>
                            <th>${T.action}</th>
                            <th>${T.note}</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${demoHistory.map(h => `
                            <tr>
                                <td><small>${esc(h.time)}</small></td>
                                <td>${esc(h.user)}</td>
                                <td>${esc(h.action)}</td>
                                <td><small class="text-muted">${esc(h.note)}</small></td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
        `;
    }

    /* ============================
       ATTACH MODAL
    ============================ */
    window.openAttachModal = function(paymentId) {
        const info = document.getElementById('attachExpenseInfo');
        if (info) {
            info.innerHTML = `
                <div class="alert alert-info mb-0">
                    <strong>Харажат ID:</strong> ${paymentId} | 
                    <strong>Сумма:</strong> 25,000,000 UZS | 
                    <strong>Тўловчи:</strong> Noma'lum mijoz
                </div>
            `;
        }

        document.getElementById('attach_category').value = '';
        document.getElementById('attach_project').value = '';
        document.getElementById('attach_comment').value = '';

        const modal = new bootstrap.Modal(document.getElementById('attachModal'));
        modal.show();
    };

    window.saveAttach = function() {
        const category = document.getElementById('attach_category').value;
        const project = document.getElementById('attach_project').value;
        const comment = document.getElementById('attach_comment').value;

        if (!category || !project) {
            alert('{{ __("Харажат категорияси ва лойиҳани танланг") }}');
            return;
        }

        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) loadingOverlay.classList.add('active');

        setTimeout(() => {
            showAlert('success', T.attached_success);
            bootstrap.Modal.getInstance(document.getElementById('attachModal'))?.hide();
            if (loadingOverlay) loadingOverlay.classList.remove('active');

            if (currentExpenseId) {
                const item = expenses.find(e => e.id === currentExpenseId);
                if (item) {
                    item.found += 1;
                    item.not_found = Math.max(item.not_found - 1, 0);
                    item.updated_at = new Date().toISOString().split('T')[0];
                }
            }

            loadTableData();
            if (currentExpenseId) openCard(currentExpenseId);
        }, 1000);
    };

    /* ============================
       ATTACH MULTIPLE MODAL
    ============================ */
    let projectRowCounter = 0;

    window.openAttachMultipleModal = function(paymentId) {
        const info = document.getElementById('attachMultipleExpenseInfo');
        if (info) {
            info.innerHTML = `
                <div class="alert alert-info mb-0">
                    <strong>Харажат ID:</strong> ${paymentId} | 
                    <strong>Сумма:</strong> 25,000,000 UZS | 
                    <strong>Тўловчи:</strong> Noma'lum mijoz
                    <div class="mt-2"><strong>Эслатма:</strong> Умумий сумма бир нечта лойиҳаларга тақсимланади</div>
                </div>
            `;
        }

        document.getElementById('attach_multiple_category').value = '';
        document.getElementById('multipleProjectsList').innerHTML = '';
        projectRowCounter = 0;
        addProjectRow();

        const modal = new bootstrap.Modal(document.getElementById('attachMultipleModal'));
        modal.show();
    };

    window.addProjectRow = function() {
        projectRowCounter++;
        const container = document.getElementById('multipleProjectsList');
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 align-items-end';
        row.id = `project-row-${projectRowCounter}`;
        row.innerHTML = `
            <div class="col-md-6">
                <label class="form-label small">{{ __('Инвестицион лойиҳа') }}</label>
                <select class="form-select form-select-sm" required>
                    <option value="">{{ __('Танланг') }}</option>
                    <option value="1">PRJ-2024-001 - Янги уй қурилиши</option>
                    <option value="2">PRJ-2024-002 - Офис биноси</option>
                    <option value="3">PRJ-2025-001 - Савдо маркази</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small">{{ __('Сумма') }}</label>
                <input type="number" class="form-control form-control-sm" placeholder="0" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="removeProjectRow(${projectRowCounter})">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
    };

    window.removeProjectRow = function(rowId) {
        const row = document.getElementById(`project-row-${rowId}`);
        if (row) row.remove();
    };

    window.saveAttachMultiple = function() {
        const category = document.getElementById('attach_multiple_category').value;
        const rows = document.querySelectorAll('#multipleProjectsList .row');

        if (!category) {
            alert('{{ __("Харажат категориясини танланг") }}');
            return;
        }

        if (rows.length === 0) {
            alert('{{ __("Камида бир лойиҳа қўшинг") }}');
            return;
        }

        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) loadingOverlay.classList.add('active');

        setTimeout(() => {
            showAlert('success', T.attached_success);
            bootstrap.Modal.getInstance(document.getElementById('attachMultipleModal'))?.hide();
            if (loadingOverlay) loadingOverlay.classList.remove('active');

            if (currentExpenseId) {
                const item = expenses.find(e => e.id === currentExpenseId);
                if (item) {
                    item.found += 1;
                    item.not_found = Math.max(item.not_found - 1, 0);
                    item.updated_at = new Date().toISOString().split('T')[0];
                }
            }

            loadTableData();
            if (currentExpenseId) openCard(currentExpenseId);
        }, 1000);
    };

    /* ============================
       PAYMENT ACTIONS
    ============================ */
    window.movePaymentToNeedCheck = function(paymentId) {
        if (!confirm(T.confirm_move)) return;

        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) loadingOverlay.classList.add('active');

        setTimeout(() => {
            showAlert('warning', `ID ${paymentId} ${T.moved_to_need_check}`);
            if (loadingOverlay) loadingOverlay.classList.remove('active');

            if (currentExpenseId) {
                const item = expenses.find(e => e.id === currentExpenseId);
                if (item) {
                    item.need_check += 1;
                    item.found = Math.max(item.found - 1, 0);
                    item.updated_at = new Date().toISOString().split('T')[0];
                }
            }

            loadTableData();
            if (currentExpenseId) openCard(currentExpenseId);
        }, 800);
    };

    window.movePaymentToOther = function(paymentId) {
        if (!confirm('{{ __("Бошқа харажатларга ўтказмоқчимисиз?") }}')) return;

        const loadingOverlay = document.getElementById('loadingOverlay');
        if (loadingOverlay) loadingOverlay.classList.add('active');

        setTimeout(() => {
            showAlert('info', `ID ${paymentId} ${T.moved_to_other}`);
            if (loadingOverlay) loadingOverlay.classList.remove('active');

            loadTableData();
            if (currentExpenseId) openCard(currentExpenseId);
        }, 800);
    };

    /* ============================
       EXPORT DATA
    ============================ */
    window.exportData = function() {
        const headers = expenseColumns.map(c => c.label).slice(0, -1);
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
        const blob = new Blob(['\ufeff' + csv], {
            type: 'text/csv;charset=utf-8;'
        });
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
                ${esc(message)}
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

        document.getElementById('f_search')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') applyFilters();
        });

        document.getElementById('exportExcelBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            exportData();
        });

        document.getElementById('importExcelBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            openImportModal();
        });

        document.getElementById('filterBtn')?.addEventListener('click', function() {
            applyFilters();
        });

        document.getElementById('clearBtn')?.addEventListener('click', function() {
            resetFilters();
        });
    });

})();
</script>