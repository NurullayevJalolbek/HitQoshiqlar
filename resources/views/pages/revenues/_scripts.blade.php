@extends('layouts.app')

@push('customCss')
    <style>
        .filter-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .exit-table {
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        .exit-table thead th {
            background: #1f2937;
            color: white;
            font-weight: 600;
            padding: 0.875rem 0.75rem;
            font-size: 0.8125rem;
            white-space: nowrap;
            border: none;
            vertical-align: middle;
        }

        .exit-table tbody td {
            padding: 0.875rem 0.75rem;
            vertical-align: middle;
            border-color: #e5e7eb;
        }

        .exit-table tbody tr {
            transition: background-color 0.15s ease;
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
            border: 1px solid rgba(255, 255, 255, 0.2);
            white-space: nowrap;
        }

        .badge-status-processing {
            background: rgba(255, 193, 7, 0.15);
            color: #c99a00;
        }

        .badge-status-accepted {
            background: rgba(0, 200, 83, 0.15);
            color: #0f9d58;
        }

        .badge-status-rejected {
            background: rgba(255, 0, 0, 0.15);
            color: #d93025;
        }

        .action-buttons {
            display: flex;
            gap: 0.375rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
            background: white;
            transition: all 0.2s ease;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
        }

        .btn-accept {
            color: #10b981;
        }

        .btn-accept:hover {
            background: #dcfce7;
            border-color: #10b981;
        }

        .btn-reject {
            color: #ef4444;
        }

        .btn-reject:hover {
            background: #fee2e2;
            border-color: #ef4444;
        }

        .value-primary {
            font-weight: 600;
            color: #1f2937;
            font-size: 0.875rem;
        }

        .value-secondary {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.125rem;
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
            opacity: 0.5;
        }

        @media (max-width: 1400px) {
            .exit-table {
                font-size: 0.8125rem;
            }
        }

        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }
            
            .exit-table thead th,
            .exit-table tbody td {
                padding: 0.5rem 0.375rem;
                font-size: 0.75rem;
            }
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
            color: white !important;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .col-phone,
        .col-login {
            display: none;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loading-overlay.show {
            display: flex;
        }

        .btn-bulk-actions {
            display: flex;
            gap: 0.5rem;
        }

        @media (max-width: 576px) {
            .btn-bulk-actions {
                flex-direction: column;
            }
            
            .btn-bulk-actions button {
                width: 100%;
            }
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3 mb-2"
         style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
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
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
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

    <div class="loading-overlay" id="loadingOverlay">
        <div class="text-center">
            <i class="fas fa-spinner fa-spin fa-3x text-primary mb-3"></i>
            <p class="text-muted">{{ __('admin.loading') }}</p>
        </div>
    </div>

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

                <x-select-with-search name="filter_exit_status" label="{{ __('admin.application_status') }}" :datas="$statuses"
                                     colMd="2" placeholder="{{ __('admin.all') }}" :selected="request()->get('filter_exit_status', '')"
                                     :selectSearch=false />

                <div class="col-md-3 btn-bulk-actions">
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
                <th style="width: 40px;"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                <th style="width: 50px;">№</th>
                <th>{{ __('admin.exit_id') }}</th>
                <th style="width: 150px;">{{ __('admin.application_status') }}</th>
                <th>{{ __('admin.application_comment') }}</th>
                <th style="width: 140px;">{{ __('admin.review_deadline') }}</th>
                <th style="min-width: 200px;">{{ __('admin.investor_name') }}</th>
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
                            <strong>{{ __('admin.attention') }}</strong>
                            <span id="acceptCount" class="badge bg-primary ms-1">0</span>
                            {{ __('admin.accept_exit_info') }}
                        </div>
                    </div>

                    <div class="alert alert-warning d-flex align-items-start">
                        <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                        <div>
                            <small>{{ __('admin.accept_exit_warning') }}</small>
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
                            <strong>{{ __('admin.warning') }}</strong>
                            <span id="rejectCount" class="badge bg-danger ms-1">0</span>
                            {{ __('admin.reject_exit_info') }}
                        </div>
                    </div>

                    <form id="rejectForm">
                        <div class="mb-3">
                            <label for="rejectionReason" class="form-label">
                                <i class="bi bi-chat-left-text me-1"></i>{{ __('admin.rejection_reason') }} *
                            </label>
                            <textarea class="form-control" id="rejectionReason" rows="4" required
                                placeholder="{{ __('admin.enter_rejection_reason') }}"></textarea>
                            <div class="form-text">{{ __('admin.rejection_reason_hint') }}</div>
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
        //        IN-MEMORY STORAGE (React state alternative)
        // ========================================

        const DEFAULT_REQUESTS = [
            {
                id: 1,
                exit_id: "EXIT-20001",
                status: "processing",
                status_comment: "",
                deadline: "2025-12-15",
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
                full_name: "Nazarova Malika Olimovna",
                phone: "+998 97 888 99 00",
                login: "malika_n",
            }
        ];

        let exitRequests = [...DEFAULT_REQUESTS];
        let filteredRequests = [...DEFAULT_REQUESTS];

        const tbody = document.getElementById('exit-request-body');
        const emptyState = document.getElementById('emptyState');
        const searchInput = document.getElementById('searchInput');
        const filterStatus = document.getElementById('filter_exit_status');
        const acceptSelectedBtn = document.getElementById('acceptSelectedBtn');
        const rejectSelectedBtn = document.getElementById('rejectSelectedBtn');
        const filterBtn = document.getElementById('filterBtn');
        const clearBtn = document.getElementById('clearBtn');
        const checkAll = document.getElementById('checkAll');
        const loadingOverlay = document.getElementById('loadingOverlay');

        // ========================================
        //           HELPER FUNCTIONS
        // ========================================

        function showLoading(show = true) {
            if (loadingOverlay) {
                loadingOverlay.classList.toggle('show', show);
            }
        }

        function escapeHtml(text) {
            if (text === null || text === undefined || text === '') return '—';
            const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return String(text).replace(/[&<>"']/g, m => map[m]);
        }

        function getStatusBadge(status) {
            const statusMap = {
                'processing': '<span class="badge badge-custom badge-status-processing"><i class="fas fa-clock me-1"></i>Jarayonda</span>',
                'accepted': '<span class="badge badge-custom badge-status-accepted"><i class="fas fa-check me-1"></i>Qabul qilingan</span>',
                'rejected': '<span class="badge badge-custom badge-status-rejected"><i class="fas fa-times me-1"></i>Rad etilgan</span>'
            };
            return statusMap[status] || status;
        }

        // ========================================
        //           RENDER TABLE
        // ========================================

        function renderExitRequests(list = filteredRequests) {
            if (!tbody) return;

            if (!list.length) {
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

                rows += `
                    <tr>
                        <td class="text-center">
                            ${canCheck ? `<input type="checkbox" class="row-check form-check-input" value="${item.id}">` : ''}
                        </td>
                        <td class="text-center">${index + 1}</td>
                        <td><div class="value-primary">${escapeHtml(item.exit_id)}</div></td>
                        <td>${getStatusBadge(item.status)}</td>
                        <td><small>${item.status_comment ? escapeHtml(item.status_comment) : '—'}</small></td>
                        <td class="text-center"><small>${escapeHtml(item.deadline)}</small></td>
                        <td>
                            <div class="value-primary">${escapeHtml(item.full_name)}</div>
                            <div class="value-secondary"><i class="fas fa-phone me-1"></i>${phone}</div>
                            <div class="value-secondary"><i class="fas fa-user me-1"></i><code>${login}</code></div>
                        </td>
                        <td class="col-phone">${phone}</td>
                        <td class="col-login"><code>${login}</code></td>
                    </tr>
                `;
            });

            tbody.innerHTML = rows;
            
            if (checkAll) checkAll.checked = false;
        }

        // ========================================
        //           CHECKBOX HANDLING
        // ========================================

        if (checkAll) {
            checkAll.addEventListener('click', function () {
                document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
            });
        }

        tbody?.addEventListener('change', function(e) {
            if (e.target.classList.contains('row-check')) {
                const allChecked = document.querySelectorAll('.row-check');
                const checkedBoxes = document.querySelectorAll('.row-check:checked');
                if (checkAll) {
                    checkAll.checked = allChecked.length > 0 && allChecked.length === checkedBoxes.length;
                }
            }
        });

        const getSelectedIds = () => [...document.querySelectorAll('.row-check:checked')].map(cb => +cb.value);

        // ========================================
        //           MODAL FUNCTIONS
        // ========================================

        function showAcceptModal() {
            const ids = getSelectedIds();
            if (!ids.length) {
                alert("⚠ Qabul qilish uchun kamida bitta arizani tanlang!");
                return;
            }

            const processingCount = ids.filter(id => {
                const item = exitRequests.find(x => x.id === id);
                return item && item.status === 'processing';
            }).length;

            if (processingCount === 0) {
                alert("⚠ Faqat 'Jarayonda' holatidagi arizalarni qabul qilish mumkin!");
                return;
            }

            document.getElementById('acceptCount').textContent = processingCount;
            const modal = new bootstrap.Modal(document.getElementById('acceptModal'));
            modal.show();
        }

        function showRejectModal() {
            const ids = getSelectedIds();
            if (!ids.length) {
                alert("⚠ Rad etish uchun kamida bitta arizani tanlang!");
                return;
            }

            const processingCount = ids.filter(id => {
                const item = exitRequests.find(x => x.id === id);
                return item && item.status === 'processing';
            }).length;

            if (processingCount === 0) {
                alert("⚠ Faqat 'Jarayonda' holatidagi arizalarni rad etish mumkin!");
                return;
            }

            document.getElementById('rejectCount').textContent = processingCount;
            document.getElementById('rejectionReason').value = '';
            const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        }

        // ========================================
        //           ACCEPT ACTION
        // ========================================

        function confirmAcceptAction() {
            showLoading(true);
            
            setTimeout(() => {
                const ids = getSelectedIds();
                let acceptedCount = 0;

                ids.forEach(id => {
                    const item = exitRequests.find(x => x.id === id && x.status === 'processing');
                    if (item) {
                        item.status = 'accepted';
                        item.status_comment = 'Ariza qabul qilindi. Yangi raund e\'lon qilindi.';
                        acceptedCount++;
                    }
                });

                const modal = bootstrap.Modal.getInstance(document.getElementById('acceptModal'));
                modal.hide();

                applyFilters();
                if (checkAll) checkAll.checked = false;
                
                showLoading(false);
                alert(`✅ ${acceptedCount} ta ariza muvaffaqiyatli qabul qilindi!\n\nInvestitsion loyiha doirasida yangi raund e'lon qilinib, sotuv jarayoni boshlanishi kerak.`);
            }, 500);
        }

        // ========================================
        //           REJECT ACTION
        // ========================================

        function confirmRejectAction() {
            const reason = document.getElementById('rejectionReason').value.trim();

            if (!reason) {
                alert("⚠ Rad etish sababini kiritish majburiy!");
                return;
            }

            showLoading(true);

            setTimeout(() => {
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

                const modal = bootstrap.Modal.getInstance(document.getElementById('rejectModal'));
                modal.hide();

                applyFilters();
                if (checkAll) checkAll.checked = false;
                
                showLoading(false);
                alert(`✅ ${rejectedCount} ta ariza rad etildi!\n\nRad etish sababi mobil ilova orqali investorlarga yuborildi.`);
            }, 500);
        }

        // ========================================
        //           FILTERS
        // ========================================

        function applyFilters() {
            const search = (searchInput?.value || '').toLowerCase().trim();
            const status = filterStatus?.value || '';

            filteredRequests = exitRequests.filter(i => {
                const matchSearch = !search ||
                    (i.full_name && i.full_name.toLowerCase().includes(search)) ||
                    (i.phone && i.phone.toLowerCase().includes(search)) ||
                    (i.login && i.login.toLowerCase().includes(search)) ||
                    (i.exit_id && i.exit_id.toLowerCase().includes(search));

                const matchStatus = !status || i.status === status;

                return matchSearch && matchStatus;
            });

            renderExitRequests(filteredRequests);
        }

        function resetFilters() {
            if (searchInput) searchInput.value = '';
            if (filterStatus) filterStatus.value = '';
            filteredRequests = [...exitRequests];
            renderExitRequests(filteredRequests);
        }

        // ========================================
        //           EVENT LISTENERS
        // ========================================

        document.addEventListener('DOMContentLoaded', function () {
            renderExitRequests(filteredRequests);

            if (acceptSelectedBtn) acceptSelectedBtn.addEventListener('click', showAcceptModal);
            if (rejectSelectedBtn) rejectSelectedBtn.addEventListener('click', showRejectModal);

            const confirmAcceptBtn = document.getElementById('confirmAcceptBtn');
            const confirmRejectBtn = document.getElementById('confirmRejectBtn');

            if (confirmAcceptBtn) confirmAcceptBtn.addEventListener('click', confirmAcceptAction);
            if (confirmRejectBtn) confirmRejectBtn.addEventListener('click', confirmRejectAction);

            if (filterBtn) filterBtn.addEventListener('click', applyFilters);
            if (clearBtn) clearBtn.addEventListener('click', resetFilters);

            if (searchInput) {
                let timeout;
                searchInput.addEventListener('input', function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(applyFilters, 300);
                });
                searchInput.addEventListener('keyup', function (e) {
                    if (e.key === 'Enter') applyFilters();
                });
            }

            if (filterStatus) filterStatus.addEventListener('change', applyFilters);
        });
    </script>
@endpush