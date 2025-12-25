@extends('layouts.app')

@push('customCss')
    <style>
        .filter-card {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .05);
            border-radius: .75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .06);
        }

        .exit-table {
            font-size: .875rem;
            margin-bottom: 0;
        }

        .exit-table thead th {
            background: #1f2937;
            color: #fff;
            font-weight: 600;
            padding: .875rem .75rem;
            font-size: .8125rem;
            white-space: nowrap;
            border: none;
            vertical-align: middle;
        }

        .exit-table tbody td {
            padding: .875rem .75rem;
            vertical-align: middle;
            border-color: #e5e7eb;
        }

        .exit-table tbody tr {
            transition: background-color .15s ease;
        }

        .exit-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .badge-custom {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, .2);
            white-space: nowrap;
        }

        .badge-status-processing {
            background: rgba(255, 193, 7, .15);
            color: #c99a00;
        }

        .badge-status-accepted {
            background: rgba(0, 200, 83, .15);
            color: #0f9d58;
        }

        .badge-status-rejected {
            background: rgba(255, 0, 0, .15);
            color: #d93025;
        }

        .value-primary {
            font-weight: 600;
            color: #1f2937;
            font-size: .875rem;
        }

        .value-secondary {
            font-size: .75rem;
            color: #6b7280;
            margin-top: .125rem;
            line-height: 1.2;
            word-break: break-word;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: .5;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }

        .modal-header.bg-success {
            background: #10b981 !important;
        }

        .modal-header.bg-danger {
            background: #ef4444 !important;
        }

        .modal-title {
            color: #212529;
            font-weight: 600;
        }

        .modal-header.bg-success .modal-title,
        .modal-header.bg-danger .modal-title {
            color: #fff !important;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: .5rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 .2rem rgba(102, 126, 234, .25);
        }

        /* Telefon va Login ustunlarini yashirish */
        .exit-table th.col-phone,
        .exit-table td.col-phone,
        .exit-table th.col-login,
        .exit-table td.col-login {
            display: none;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3 mb-2"
        style="border:1px solid rgba(0,0,0,0.05); border-radius:.5rem; background-color:#fff; height:60px">
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.project_exit_requests') }}</li>
                </ol>
            </nav>
        </div>

        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#projectExitRequestFilterContent" aria-expanded="true"
                aria-controls="projectExitRequestFilterContent">
                <i class="bi bi-sliders2" style="font-size:1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')
    @php
        $statuses = [
            'processing' => __('admin.status_processing'),
            'accepted' => __('admin.status_accepted'),
            'rejected' => __('admin.status_rejected'),
        ];
    @endphp

    <div class="filter-card mt-3 collapse show" id="projectExitRequestFilterContent">
        <div class="p-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="searchInput" class="form-label">{{ __('admin.search') }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0"
                            placeholder="{{ __('admin.full_name') }}, {{ __('admin.login') }}, {{ __('admin.phone') }}...">
                    </div>
                </div>

                <x-select-with-search name="filter_exit_status" label="{{ __('admin.application_status') }}"
                    :datas="$statuses" colMd="2" placeholder="{{ __('admin.all') }}"
                    :selected="request()->get('filter_exit_status', '')" :selectSearch=false />

                <div class="col-md-3 d-flex gap-2">
                    <button id="acceptSelectedBtn" class="btn btn-success btn-sm flex-fill">
                        <i class="bi bi-check2-circle"></i> {{ __('admin.accept') }}
                    </button>
                    <button id="rejectSelectedBtn" class="btn btn-danger btn-sm flex-fill">
                        <i class="bi bi-x-circle"></i> {{ __('admin.reject') }}
                    </button>
                </div>

                <x-filter-buttons />
            </div>
        </div>
    </div>

    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table exit-table table-bordered table-hover table-striped align-items-center mb-0">
            <thead class="table-dark">
                <tr>
                    <th style="width:40px;"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                    <th style="width:50px;">№</th>
                    <th>{{ __('admin.exit_id') }}</th>
                    <th style="width:150px;">{{ __('admin.application_status') }}</th>
                    <th>{{ __('admin.application_comment') }}</th>
                    <th style="width:140px;">{{ __('admin.review_deadline') }}</th>
                    <th style="min-width:200px;">{{ __('admin.investor_name') }}</th>
                    <th class="col-phone">{{ __('admin.phone') }}</th>
                    <th class="col-login">{{ __('admin.login') }}</th>
                </tr>
            </thead>

            <tbody id="exit-request-body">
                <tr class="loading-row">
                    <td colspan="9" class="text-center py-4 text-muted">
                        <i class="fas fa-spinner fa-spin me-2"></i>{{ __('admin.loading') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div id="emptyState" class="empty-state" style="display:none;">
            <i class="fas fa-folder-open"></i>
            <div class="mt-2">
                <h5>{{ __('admin.no_data') }}</h5>
                <p class="text-muted">{{ __('admin.no_exit_requests') }}</p>
            </div>
        </div>
    </div>

    <!-- Accept Modal -->
    <div class="modal fade" id="acceptModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-check-circle me-2"></i>{{ __('admin.accept_exit_requests') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-info d-flex align-items-start">
                        <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                        <div>
                            <strong>{{ __('admin.attention') }}!</strong>
                            <span id="acceptCount" class="badge bg-primary ms-1">0</span> ta ariza tanlandi.
                        </div>
                    </div>

                    <div class="alert alert-warning d-flex align-items-start">
                        <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                        <div>
                            <small>Ariza qabul qilingandan so'ng, Investitsion loyiha doirasida <strong>yangi raund e'lon
                                    qilinib, sotuv jarayoni boshlanishi</strong> kerak.</small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>{{ __('admin.cancel') }}
                    </button>
                    <button type="button" class="btn btn-success" id="confirmAcceptBtn">
                        <i class="bi bi-check-circle me-1"></i>{{ __('admin.accept') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-x-circle me-2"></i>{{ __('admin.reject_exit_requests') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-start">
                        <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                        <div>
                            <strong>{{ __('admin.warning') }}!</strong>
                            <span id="rejectCount" class="badge bg-danger ms-1">0</span> ta ariza rad etiladi.
                        </div>
                    </div>

                    <form id="rejectForm">
                        <div class="mb-3">
                            <label for="rejectionReason" class="form-label">
                                <i class="bi bi-chat-left-text me-1"></i>{{ __('admin.rejection_reason') }} *
                            </label>
                            <textarea class="form-control" id="rejectionReason" rows="4" required
                                placeholder="Ariza rad etilish sababini kiriting..."></textarea>
                            <div class="form-text">Kiritilgan sabab mobil ilova orqali Investorga ko'rsatiladi.</div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>{{ __('admin.cancel') }}
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmRejectBtn">
                        <i class="bi bi-x-circle me-1"></i>{{ __('admin.reject') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('customJs')
    <script>
        // ========================================
        //  STORAGE + SEED MERGE (Hamma 6 ta chiqadi)
        // ========================================

        const STORAGE_KEY = 'exitRequests';

        const SEED = [
            {
                id: 1,
                exit_id: "EXIT-20001",
                status: "processing",
                status_comment: "",
                deadline: "2025-12-15",
                submitted_at: "2025-12-01",
                requested_amount: 150000000,
                investor_type: "Jismoniy shaxs",
                full_name: "Rasulov Islom Akmalovich",
                phone: "+998 90 122 33 44",
                login: "islom_dev",
            },
            {
                id: 2,
                exit_id: "EXIT-20002",
                status: "accepted",
                status_comment: "Ariza qabul qilindi. Yangi raund e'lon qilindi.",
                deadline: "2025-12-10",
                submitted_at: "2025-11-28",
                requested_amount: 200000000,
                investor_type: "Yuridik shaxs",
                full_name: "Sobirova Farangiz Rustamovna",
                phone: "+998 90 777 88 99",
                login: "farangiz_s",
            },
            {
                id: 3,
                exit_id: "EXIT-20003",
                status: "processing",
                status_comment: "",
                deadline: "2025-12-18",
                submitted_at: "2025-12-03",
                requested_amount: 90000000,
                investor_type: "Jismoniy shaxs",
                full_name: "Karimov Aziz Sharipovich",
                phone: "+998 90 111 22 33",
                login: "aziz_k",
            },
            {
                id: 4,
                exit_id: "EXIT-20004",
                status: "rejected",
                status_comment: "Investitsiya davri hali yakunlanmagan. Minimal investitsiya muddati 6 oy.",
                deadline: "2025-12-12",
                submitted_at: "2025-11-25",
                requested_amount: 120000000,
                investor_type: "Jismoniy shaxs",
                full_name: "Toshmatova Dilnoza Akbarovna",
                phone: "+998 90 555 66 77",
                login: "dilnoza_t",
            },
            {
                id: 5,
                exit_id: "EXIT-20005",
                status: "processing",
                status_comment: "",
                deadline: "2025-12-20",
                submitted_at: "2025-12-05",
                requested_amount: 175000000,
                investor_type: "Yuridik shaxs",
                full_name: "Alimov Sardor Murodovich",
                phone: "+998 93 444 55 66",
                login: "sardor_alimov",
            },
            {
                id: 6,
                exit_id: "EXIT-20006",
                status: "processing",
                status_comment: "",
                deadline: "2025-12-22",
                submitted_at: "2025-12-07",
                requested_amount: 65000000,
                investor_type: "Jismoniy shaxs",
                full_name: "Nazarova Malika Olimovna",
                phone: "+998 97 888 99 00",
                login: "malika_n",
            }
        ];

        function safeJsonParse(v, fallback) {
            try { return JSON.parse(v); } catch (e) { return fallback; }
        }

        function saveStorage(list) {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(list));
        }

        // localStorage o‘qish
        let exitRequests = safeJsonParse(localStorage.getItem(STORAGE_KEY), []);
        if (!Array.isArray(exitRequests)) exitRequests = [];

        // SEED MERGE: localStorage’da kam bo‘lsa hammasini to‘ldiradi
        // Bor id lar saqlanadi, yo‘qlari qo‘shiladi.
        const map = new Map();
        exitRequests.forEach(i => {
            if (i && typeof i === 'object' && i.id != null) map.set(Number(i.id), i);
        });

        SEED.forEach(s => {
            const id = Number(s.id);
            if (!map.has(id)) {
                map.set(id, s);
            } else {
                // MIGRATION: bor yozuvda yangi fieldlar yo‘q bo‘lsa qo‘shib qo‘yadi
                const cur = map.get(id);
                if (!cur.submitted_at) cur.submitted_at = s.submitted_at || cur.deadline || '—';
                if (typeof cur.requested_amount !== 'number') cur.requested_amount = 0;
                if (!cur.investor_type) cur.investor_type = '—';
                if (!cur.exit_id) cur.exit_id = s.exit_id;
                if (!cur.full_name) cur.full_name = s.full_name;
                if (!cur.deadline) cur.deadline = s.deadline;
                map.set(id, cur);
            }
        });

        exitRequests = Array.from(map.values()).sort((a, b) => Number(a.id) - Number(b.id));
        saveStorage(exitRequests);

        let defaultRequests = [...exitRequests];

        const tbody = document.getElementById('exit-request-body');
        const emptyState = document.getElementById('emptyState');
        const searchInput = document.getElementById('searchInput');
        const filterStatus = document.getElementById('filter_exit_status');
        const acceptSelectedBtn = document.getElementById('acceptSelectedBtn');
        const rejectSelectedBtn = document.getElementById('rejectSelectedBtn');
        const filterBtn = document.getElementById('filterBtn');
        const clearBtn = document.getElementById('clearBtn');
        const checkAll = document.getElementById('checkAll');

        // ========================================
        // helpers
        // ========================================
        function escapeHtml(text) {
            if (text === null || text === undefined || text === '') return '—';
            const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return String(text).replace(/[&<>"']/g, m => map[m]);
        }

        function getStatusBadge(status) {
            const statusMap = {
                'processing': '<span class="badge badge-custom badge-status-processing">Jarayonda</span>',
                'accepted': '<span class="badge badge-custom badge-status-accepted">Qabul qilingan</span>',
                'rejected': '<span class="badge badge-custom badge-status-rejected">Rad etilgan</span>'
            };
            return statusMap[status] || `<span class="badge badge-custom">${escapeHtml(status)}</span>`;
        }

        function formatMoney(n) {
            if (!n || typeof n !== 'number') return '—';
            return new Intl.NumberFormat('uz-UZ').format(n) + ' so‘m';
        }

        function daysLeft(deadline) {
            if (!deadline) return '—';
            const d = new Date(deadline + 'T00:00:00');
            const now = new Date();
            return Math.ceil((d.getTime() - now.getTime()) / (1000 * 60 * 60 * 24));
        }

        // ========================================
        // render
        // ========================================
        function renderExitRequests(list = exitRequests) {
            if (!tbody) return;

            if (!Array.isArray(list) || list.length === 0) {
                tbody.innerHTML = '';
                if (emptyState) emptyState.style.display = 'block';
                return;
            }

            if (emptyState) emptyState.style.display = 'none';

            let rows = '';
            list.forEach((item, index) => {
                const canCheck = item.status === 'processing';
                const phone = item.phone ? escapeHtml(item.phone) : '—';
                const login = item.login ? escapeHtml(item.login) : '—';

                const extraProcessingInfo = item.status === 'processing' ? `
                    <div class="value-secondary"><span class="text-muted">Topshirildi:</span> ${escapeHtml(item.submitted_at)}</div>
                    <div class="value-secondary"><span class="text-muted">Qolgan kun:</span> ${daysLeft(item.deadline)} kun</div>
                    <div class="value-secondary"><span class="text-muted">Investor turi:</span> ${escapeHtml(item.investor_type)}</div>
                    <div class="value-secondary"><span class="text-muted">So‘ralgan summa:</span> <strong>${formatMoney(item.requested_amount)}</strong></div>
                ` : '';

                rows += `
                    <tr>
                        <td>
                            ${canCheck ? `<input type="checkbox" class="row-check form-check-input" value="${item.id}">` : ''}
                        </td>
                        <td>${index + 1}</td>
                        <td><div class="value-primary">${escapeHtml(item.exit_id)}</div></td>
                        <td>${getStatusBadge(item.status)}</td>
                        <td>${item.status_comment ? escapeHtml(item.status_comment) : '—'}</td>
                        <td class="text-center">${escapeHtml(item.deadline)}</td>
                        <td>
                            <div class="value-primary">${escapeHtml(item.full_name)}</div>
                            <div class="value-secondary"><span class="text-muted">Tel:</span> ${phone}</div>
                            <div class="value-secondary"><span class="text-muted">Login:</span> <code>${login}</code></div>
                            ${extraProcessingInfo}
                        </td>
                        <td class="col-phone">${phone}</td>
                        <td class="col-login"><code>${login}</code></td>
                    </tr>
                `;
            });

            tbody.innerHTML = rows;
        }

        // ========================================
        // checkbox
        // ========================================
        if (checkAll) {
            checkAll.onclick = function () {
                document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
            };
        }
        const getSelectedIds = () => [...document.querySelectorAll('.row-check:checked')].map(cb => +cb.value);

        // ========================================
        // modals
        // ========================================
        function showAcceptModal() {
            const ids = getSelectedIds();
            if (!ids.length) { alert("⚠ Qabul qilish uchun kamida bitta arizani tanlang!"); return; }

            const processingCount = ids.filter(id => {
                const item = exitRequests.find(x => x.id === id);
                return item && item.status === 'processing';
            }).length;

            if (processingCount === 0) { alert("⚠ Faqat 'Jarayonda' holatidagi arizalarni qabul qilish mumkin!"); return; }

            document.getElementById('acceptCount').textContent = processingCount;
            new bootstrap.Modal(document.getElementById('acceptModal')).show();
        }

        function showRejectModal() {
            const ids = getSelectedIds();
            if (!ids.length) { alert("⚠ Rad etish uchun kamida bitta arizani tanlang!"); return; }

            const processingCount = ids.filter(id => {
                const item = exitRequests.find(x => x.id === id);
                return item && item.status === 'processing';
            }).length;

            if (processingCount === 0) { alert("⚠ Faqat 'Jarayonda' holatidagi arizalarni rad etish mumkin!"); return; }

            document.getElementById('rejectCount').textContent = processingCount;
            document.getElementById('rejectionReason').value = '';
            new bootstrap.Modal(document.getElementById('rejectModal')).show();
        }

        // ========================================
        // actions
        // ========================================
        function confirmAcceptAction() {
            const ids = getSelectedIds();
            let acceptedCount = 0;

            ids.forEach(id => {
                const item = exitRequests.find(x => x.id === id && x.status === 'processing');
                if (item) {
                    item.status = 'accepted';
                    item.status_comment = "Ariza qabul qilindi. Yangi raund e'lon qilindi.";
                    acceptedCount++;
                }
            });

            saveStorage(exitRequests);
            defaultRequests = [...exitRequests];

            bootstrap.Modal.getInstance(document.getElementById('acceptModal')).hide();
            applyFilters();
            if (checkAll) checkAll.checked = false;

            alert(`✅ ${acceptedCount} ta ariza muvaffaqiyatli qabul qilindi!\n\nInvestitsion loyiha doirasida yangi raund e'lon qilinib, sotuv jarayoni boshlanishi kerak.`);
        }

        function confirmRejectAction() {
            const reason = document.getElementById('rejectionReason').value.trim();
            if (!reason) { alert("⚠ Rad etish sababini kiritish majburiy!"); return; }

            const ids = getSelectedIds();
            let rejectedCount = 0;

            ids.forEach(id => {
                const item = exitRequests.find(x => x.id === id && x.status === 'processing');
                if (item) {
                    item.status = 'rejected';
                    item.status_comment = reason;
                    rejectedCount++;
                }
            });

            saveStorage(exitRequests);
            defaultRequests = [...exitRequests];

            bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
            applyFilters();
            if (checkAll) checkAll.checked = false;

            alert(`✅ ${rejectedCount} ta ariza rad etildi!\n\nRad etish sababi mobil ilova orqali investorlarga yuborildi.`);
        }

        // ========================================
        // filters
        // ========================================
        function applyFilters() {
            const search = (searchInput?.value || '').toLowerCase().trim();
            const status = (filterStatus?.value || '').trim();

            const filtered = defaultRequests.filter(i => {
                const matchSearch = !search ||
                    (i.full_name && i.full_name.toLowerCase().includes(search)) ||
                    (i.phone && i.phone.toLowerCase().includes(search)) ||
                    (i.login && i.login.toLowerCase().includes(search)) ||
                    (i.exit_id && i.exit_id.toLowerCase().includes(search));

                const matchStatus = !status || i.status === status;
                return matchSearch && matchStatus;
            });

            renderExitRequests(filtered);
        }

        function resetFilters() {
            if (searchInput) searchInput.value = '';
            if (filterStatus) filterStatus.value = '';
            renderExitRequests(defaultRequests);
        }

        // ========================================
        // init
        // ========================================
        document.addEventListener('DOMContentLoaded', function () {
            // doim hammasini chiqaradi
            renderExitRequests(defaultRequests);

            if (acceptSelectedBtn) acceptSelectedBtn.addEventListener('click', showAcceptModal);
            if (rejectSelectedBtn) rejectSelectedBtn.addEventListener('click', showRejectModal);

            const confirmAcceptBtn = document.getElementById('confirmAcceptBtn');
            const confirmRejectBtn = document.getElementById('confirmRejectBtn');

            if (confirmAcceptBtn) confirmAcceptBtn.addEventListener('click', confirmAcceptAction);
            if (confirmRejectBtn) confirmRejectBtn.addEventListener('click', confirmRejectAction);

            if (filterBtn) filterBtn.addEventListener('click', applyFilters);
            if (clearBtn) clearBtn.addEventListener('click', resetFilters);

            if (searchInput) {
                let t;
                searchInput.addEventListener('input', function () {
                    clearTimeout(t);
                    t = setTimeout(applyFilters, 300);
                });
                searchInput.addEventListener('keyup', function (e) {
                    if (e.key === 'Enter') applyFilters();
                });
            }

            if (filterStatus) filterStatus.addEventListener('change', applyFilters);
        });

        window.showAcceptModal = showAcceptModal;
        window.showRejectModal = showRejectModal;
        window.confirmAcceptAction = confirmAcceptAction;
        window.confirmRejectAction = confirmRejectAction;
        window.applyFilters = applyFilters;
        window.resetFilters = resetFilters;
    </script>
@endpush