@extends('layouts.app')

@push('customCss')
    <style>
        .table td,
        .table th {
            vertical-align: middle;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .status-processing {
            background: rgba(255, 193, 7, 0.15);
            color: #c99a00;
        }

        .status-accepted {
            background: rgba(0, 200, 83, 0.15);
            color: #0f9d58;
        }

        .status-rejected {
            background: rgba(255, 0, 0, 0.15);
            color: #d93025;
        }

        .action-buttons {
            display: flex;
            gap: 0.25rem;
        }

        .action-buttons .btn {
            padding: 0.25rem 0.5rem;
            min-width: 32px;
        }

        /* ====== QISQARTIRISH: Telefon + Login ustunlari ko‘rinmaydi (data saqlanadi) ====== */
        .exit-table th.col-phone,
        .exit-table td.col-phone,
        .exit-table th.col-login,
        .exit-table td.col-login {
            display: none;
        }

        .value-primary {
            font-weight: 600;
            color: #111827;
            font-size: 0.875rem;
            line-height: 1.2;
        }

        .value-secondary {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.15rem;
            line-height: 1.2;
            word-break: break-word;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <!-- Breadcrumb -->
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.project_exit_requests') }}</li>
                </ol>
            </nav>
        </div>

        <!-- Tugmalar guruhi -->
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#projectExitRequestFilterContent" aria-expanded="true"
                aria-controls="projectExitRequestFilterContent">
                <i class="fa-solid fa-list" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')

    <div class="filter-card mb-3 mt-2 collapse show" id="projectExitRequestFilterContent"
        style="transition: all 0.3s ease;">
        <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
            <div class="row g-3 align-items-end">
                <!-- Qidiruv -->
                <div class="col-md-4">
                    <label for="searchInput">{{ __('admin.search') }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="{{ __('admin.full_name') }}, {{ __('admin.login') }}, {{ __('admin.phone') }}...">
                    </div>
                </div>

                <div class="col-md-3">
                    <label>Ariza holati</label>
                    <select id="filter_exit_status" class="form-control">
                        <option value="">— Barchasi —</option>
                        <option value="processing">Jarayonda</option>
                        <option value="accepted">Qabul qilingan</option>
                        <option value="rejected">Rad etilgan</option>
                    </select>
                </div>

                <!-- Filter tugmalari -->
                <div class="col-md-2 d-flex gap-2">
                    <button id="filterBtn" class="btn btn-primary w-50">
                        <i class="fas fa-filter"></i> {{ __('admin.search') }}
                    </button>
                    <button id="clearBtn" class="btn btn-warning w-50">
                        {{ __('admin.clear') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table exit-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
                <tr>
                    <th style="width: 40px;">№</th>
                    <th>Ulashdan chiqish ID</th>
                    <th style="width: 150px;">Ariza holati</th>
                    <th>Izoh</th>
                    <th style="width: 140px;">Ko'rib chiqish muddati</th>

                    <!-- Investor FIO ichiga telefon + login jamlanadi -->
                    <th style="min-width: 200px;">Invest F.I.O</th>

                    <!-- Ustunlar o‘chirilmaydi, faqat ko‘rinmaydi -->
                    <th class="col-phone">Telefon</th>
                    <th class="col-login">Login</th>

                    <th style="width: 200px;">Amallar</th>
                </tr>
            </thead>
            <tbody id="exit-request-body"></tbody>
        </table>
    </div>

    <!-- Modal: Qabul qilish -->
    <div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="acceptModalLabel">Arizani qabul qilish</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Ushbu arizani qabul qilmoqchimisiz?</p>
                    <p class="text-muted small">Ariza qabul qilingandan so'ng, Inestitsion loyiha doirasida yangi raund
                        e'lon qilinib, sotuv jarayoni boshlanishi kerak.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="button" class="btn btn-success" id="confirmAcceptBtn">Qabul qilish</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Rad etish -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="rejectModalLabel">Arizani rad etish</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejectReason" class="form-label">Rad etish sababi <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control" id="rejectReason" rows="4"
                            placeholder="Ariza rad etilish sababini kiriting..." required></textarea>
                        <div class="invalid-feedback">Rad etish sababini kiritish majburiy!</div>
                    </div>
                    <p class="text-muted small">Kiritilgan sabab mobil ilova orqali Investorga ko'rsatiladi.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="button" class="btn btn-danger" id="confirmRejectBtn">Rad etish</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('customJs')
    <script>
        // ========================================
        //            IN-MEMORY STORAGE
        // ========================================

        let exitRequests = [
            {
                id: 1,
                exit_id: "EXIT-20001",
                status: "processing",
                status_comment: "",
                deadline: "2025-12-15",
                full_name: "Rasulov Islom",
                phone: "+998901223344",
                login: "islom_dev",
            },
            {
                id: 2,
                exit_id: "EXIT-20002",
                status: "accepted",
                status_comment: "Ariza qabul qilindi",
                deadline: "2025-12-10",
                full_name: "Sobirova Farangiz",
                phone: "+998907778899",
                login: "farangiz_s",
            },
            {
                id: 3,
                exit_id: "EXIT-20003",
                status: "processing",
                status_comment: "",
                deadline: "2025-12-18",
                full_name: "Karimov Aziz",
                phone: "+998901112233",
                login: "aziz_k",
            },
            {
                id: 4,
                exit_id: "EXIT-20004",
                status: "rejected",
                status_comment: "Investitsiya davri hali yakunlanmagan",
                deadline: "2025-12-12",
                full_name: "Toshmatova Dilnoza",
                phone: "+998905556677",
                login: "dilnoza_t",
            }
        ];

        let currentActionId = null;

        // ========================================
        //              RENDER TABLE
        // ========================================

        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return String(text).replace(/[&<>"']/g, m => map[m]);
        }

        function getStatusBadge(status) {
            const statusMap = {
                'processing': '<span class="status-badge status-processing">Jarayonda</span>',
                'accepted': '<span class="status-badge status-accepted">Qabul qilingan</span>',
                'rejected': '<span class="status-badge status-rejected">Rad etilgan</span>'
            };
            return statusMap[status] || status;
        }

        function renderExitRequests(list = exitRequests) {
            let tbody = document.getElementById('exit-request-body');
            tbody.innerHTML = "";

            if (list.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            Ma'lumotlar topilmadi
                        </td>
                    </tr>
                `;
                return;
            }

            list.forEach((item, index) => {
                const isProcessing = item.status === 'processing';

                const actionButtons = isProcessing ? `
                    <div class="action-buttons">
                        <a href="javascript:void(0);" class="btn btn-sm p-0"
                           style="background:none; width: 28px; height: 28px;"
                           data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('admin.accept') }}"
                           onclick="openAcceptModal(${item.id})">
                            <i class="fa-solid fa-circle-check"></i>
                        </a>

                        <a href="javascript:void(0);"
                           class="btn btn-sm p-0"
                           style="background: none; color: #bd2130;"
                           data-bs-toggle="tooltip"
                           data-bs-placement="top"
                           title="Delete"
                           onclick='infoModel(@json(__("admin.warning")), @json(__("admin.role_delete_warning")));'>
                            <svg class="icon icon-xs text-danger status-blocked" title="Delete" data-bs-toggle="tooltip" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                ` : `<span class="text-muted small">—</span>`;

                tbody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td><strong>${escapeHtml(item.exit_id)}</strong></td>
                        <td>${getStatusBadge(item.status)}</td>
                        <td>${item.status_comment ? escapeHtml(item.status_comment) : '—'}</td>
                        <td>${escapeHtml(item.deadline)}</td>

                        <!-- Investor FIO ichiga Tel + Login jamlandi -->
                        <td>
                            <div class="value-primary">${escapeHtml(item.full_name)}</div>
                            <div class="value-secondary"><span class="text-muted">Tel:</span> ${escapeHtml(item.phone || '—')}</div>
                            <div class="value-secondary"><span class="text-muted">Login:</span> <code>${escapeHtml(item.login || '—')}</code></div>
                        </td>

                        <!-- Telefon/Login: data bor, lekin ko‘rinmaydi -->
                        <td class="col-phone">${escapeHtml(item.phone || '—')}</td>
                        <td class="col-login"><code>${escapeHtml(item.login || '—')}</code></td>

                        <td>${actionButtons}</td>
                    </tr>
                `;
            });
        }

        // ========================================
        //           MODAL FUNCTIONS
        // ========================================

        function openAcceptModal(id) {
            currentActionId = id;
            const modal = new bootstrap.Modal(document.getElementById('acceptModal'));
            modal.show();
        }

        function openRejectModal(id) {
            currentActionId = id;
            document.getElementById('rejectReason').value = '';
            document.getElementById('rejectReason').classList.remove('is-invalid');
            const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        }

        // ========================================
        //           ACCEPT EXIT REQUEST
        // ========================================

        document.getElementById('confirmAcceptBtn').addEventListener('click', function () {
            if (!currentActionId) return;

            let item = exitRequests.find(i => i.id === currentActionId);
            if (!item) return;

            item.status = "accepted";
            item.status_comment = "Ariza qabul qilindi";

            renderExitRequests();

            const modal = bootstrap.Modal.getInstance(document.getElementById('acceptModal'));
            modal.hide();

            showAlert('success', 'Ariza muvaffaqiyatli qabul qilindi. Yangi raund ochilishi kerak.');

            currentActionId = null;
        });

        // ========================================
        //           REJECT EXIT REQUEST
        // ========================================

        document.getElementById('confirmRejectBtn').addEventListener('click', function () {
            if (!currentActionId) return;

            const reasonInput = document.getElementById('rejectReason');
            const reason = reasonInput.value.trim();

            if (!reason) {
                reasonInput.classList.add('is-invalid');
                return;
            }

            let item = exitRequests.find(i => i.id === currentActionId);
            if (!item) return;

            item.status = "rejected";
            item.status_comment = reason;

            renderExitRequests();

            const modal = bootstrap.Modal.getInstance(document.getElementById('rejectModal'));
            modal.hide();

            showAlert('danger', 'Ariza rad etildi. Sabab Investorga yuborildi.');

            currentActionId = null;
        });

        // ========================================
        //                FILTERS
        // ========================================

        function applyExitFilters() {
            let search = document.getElementById('searchInput').value.toLowerCase();
            let status = document.getElementById('filter_exit_status').value;

            let filtered = exitRequests.filter(i => {
                const matchSearch = !search ||
                    i.full_name.toLowerCase().includes(search) ||
                    i.phone.includes(search) ||
                    i.login.toLowerCase().includes(search) ||
                    i.exit_id.toLowerCase().includes(search);

                const matchStatus = !status || i.status === status;

                return matchSearch && matchStatus;
            });

            renderExitRequests(filtered);
        }

        function clearFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('filter_exit_status').value = '';
            renderExitRequests();
        }

        document.getElementById('filterBtn').addEventListener('click', applyExitFilters);
        document.getElementById('clearBtn').addEventListener('click', clearFilters);

        document.getElementById('searchInput').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                applyExitFilters();
            }
        });

        // ========================================
        //           ALERT FUNCTION
        // ========================================

        function showAlert(type, message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        // Initial render
        renderExitRequests();
    </script>
@endpush
