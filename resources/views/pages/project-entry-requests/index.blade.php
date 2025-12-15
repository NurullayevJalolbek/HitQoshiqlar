@extends('layouts.app')

@push('customCss')
    <style>
        .filter-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        .entry-table {
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        .entry-table thead th {
            background: #1f2937;
            color: white;
            font-weight: 600;
            padding: 0.875rem 0.75rem;
            font-size: 0.8125rem;
            white-space: nowrap;
            border: none;
            vertical-align: middle;
        }

        .entry-table tbody td {
            padding: 0.875rem 0.75rem;
            vertical-align: middle;
            border-color: #e5e7eb;
        }

        .entry-table tbody tr {
            transition: background-color 0.15s ease;
        }

        .entry-table tbody tr:hover {
            background-color: #f9fafb;
        }

        .badge-custom {
            padding: 0.35rem 0.65rem;
            border-radius: 0.35rem;
            font-size: 0.7rem;
            font-weight: 600;
            display: inline-block;
            white-space: nowrap;
        }

        .badge-status-processing {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-status-accepted {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-pay-approved {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-pay-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-pay-declined {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-buttons {
            display: flex;
            gap: 0.375rem;
            justify-content: center;
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

        .btn-reject {
            color: #ef4444;
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
            .entry-table {
                font-size: 0.8125rem;
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
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .modal-title {
            color: #212529;
            font-weight: 600;
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

        .text-file-link {
            color: #667eea;
            text-decoration: none;
            transition: color 0.2s;
        }

        .text-file-link:hover {
            color: #764ba2;
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
                    <li class="breadcrumb-item active" aria-current="page">Улушга кириш сўровлари</li>
                </ol>
            </nav>
        </div>

        <!-- Tugmalar guruhi -->
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#projectEntryRequestFilterContent" aria-expanded="true"
                aria-controls="projectEntryRequestFilterContent">
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

        $paymentStatuses = [
            'approved' => __('admin.payment_approved'),
            'pending' => __('admin.payment_pending'),
            'declined' => __('admin.payment_declined'),
        ];
    @endphp

    <!-- Filter -->
    <div class="filter-card mt-3 collapse show" id="projectEntryRequestFilterContent">
        <div class="p-3">
            <div class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label for="searchInput" class="form-label">{{ __('admin.search') }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0"
                            placeholder="{{ __('admin.search_placeholder') }}">
                    </div>
                </div>

                <x-select-with-search name="filter_status" label="{{ __('admin.application_status') }}" :datas="$statuses"
                    colMd="2" placeholder="{{ __('admin.all') }}" :selected="request()->get('filter_status', '')"
                    :selectSearch=false />

                <x-select-with-search name="filter_payment_status" label="{{ __('admin.payment_status') }}"
                    :datas="$paymentStatuses" colMd="2" placeholder="{{ __('admin.all') }}"
                    :selected="request()->get('filter_payment_status', '')" :selectSearch=false />

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

    <!-- Table -->
    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table entry-table table-bordered table-hover table-striped align-items-center mb-0">
            <thead class="table-dark">
                <tr>
                    <th><input type="checkbox" id="checkAll" class="form-check-input"></th>
                    <th>{{ __('admin.txn_id') }}</th>
                    <th>{{ __('admin.application_status') }}</th>
                    <th>{{ __('admin.application_comment') }}</th>
                    <th>{{ __('admin.refund_receipt') }}</th>
                    <th>{{ __('admin.rejection_act') }}</th>
                    <th>{{ __('admin.kyc_info') }}</th>
                    <th>{{ __('admin.digital_signature') }}</th>
                    <th>{{ __('admin.document_verification') }}</th>
                    <th>{{ __('admin.contract') }}</th>
                    <th>{{ __('admin.agreement') }}</th>
                    <th>{{ __('admin.payment_date') }}</th>
                    <th>{{ __('admin.amount') }}</th>
                    <th>{{ __('admin.currency') }}</th>
                    <th>{{ __('admin.payment_status') }}</th>
                    <th>{{ __('admin.payment_method') }}</th>
                    <th>{{ __('admin.investor_name') }}</th>
                    <th>{{ __('admin.phone') }}</th>
                    <th>{{ __('admin.login') }}</th>
                    <th>{{ __('admin.registered_at') }}</th>
                    <th>{{ __('admin.registration_info') }}</th>
                </tr>
            </thead>

            <tbody id="entryRequestBody">
                <tr class="loading-row">
                    <td colspan="21" class="text-center py-4 text-muted">
                        <i class="fas fa-spinner fa-spin me-2"></i>{{ __('admin.loading') }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div id="emptyState" class="empty-state" style="display:none;">
            <i class="fas fa-folder-open"></i>
            <div class="mt-2">
                <h5>{{ __('admin.no_data') }}</h5>
                <p class="text-muted">{{ __('admin.no_entries') }}</p>
            </div>
        </div>
    </div>

    <!-- Accept Modal -->
    <div class="modal fade" id="acceptModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-check-circle me-2"></i>{{ __('admin.accept_applications') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-info d-flex align-items-start">
                        <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                        <div>
                            <strong>{{ __('admin.attention') }}</strong>
                            <span id="acceptCount" class="badge bg-primary">0</span>
                            {{ __('admin.accept_selected_info') }}
                        </div>
                    </div>

                    <form id="acceptForm">
                        <div class="mb-3">
                            <label for="registrationDate" class="form-label">
                                <i class="bi bi-calendar-event me-1"></i>{{ __('admin.registration_date') }} *
                            </label>
                            <input type="date" class="form-control" id="registrationDate" required>
                            <div class="form-text">{{ __('admin.registration_date_hint') }}</div>
                        </div>

                        <div class="mb-3">
                            <label for="registrationInfo" class="form-label">
                                <i class="bi bi-file-text me-1"></i>{{ __('admin.registration_info') }} *
                            </label>
                            <textarea class="form-control" id="registrationInfo" rows="3" required></textarea>
                            <div class="form-text">{{ __('admin.registration_info_hint') }}</div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>{{ __('admin.cancel') }}
                    </button>

                    <button type="button" class="btn btn-success" id="confirmAccept">
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
                        <i class="bi bi-x-circle me-2"></i>{{ __('admin.reject_applications') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-start">
                        <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                        <div>
                            <strong>{{ __('admin.warning') }}</strong>
                            <span id="rejectCount" class="badge bg-danger">0</span>
                            {{ __('admin.reject_selected_info') }}
                        </div>
                    </div>

                    <form id="rejectForm">
                        <div class="mb-3">
                            <label for="rejectionReason" class="form-label">
                                <i class="bi bi-chat-left-text me-1"></i>{{ __('admin.rejection_reason') }} *
                            </label>
                            <textarea class="form-control" id="rejectionReason" rows="4" required></textarea>
                            <div class="form-text">{{ __('admin.rejection_reason_hint') }}</div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>{{ __('admin.cancel') }}
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmReject">
                        <i class="bi bi-x-circle me-1"></i>{{ __('admin.reject') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('customJs')
    <script>
        let entryRequests = JSON.parse(localStorage.getItem('entryRequests') || '[]');
        if (!entryRequests.length) {
            entryRequests = [
                {
                    id: 1,
                    transaction_id: "TXN-2025-0001",
                    status: "processing",
                    status_comment: "",
            refund_receipt: "receipt_001.pdf",
            rejection_act: "-",
            kyc: "Tasdiqlangan",
            e_signature: "Mavjud",
            doc_confirm: "Tasdiqlangan",
                    signed_contract: "contract_001.pdf",
                    agreement: "agreement_001.pdf",
                    payment_date: "2025-12-05",
                    amount: 12500000,
                    currency: "UZS",
                    payment_status: "approved",
                    payment_method: "Payme",
                    full_name: "Холматов Жасурбек Алишерович",
                    phone: "+998 99 123 45 67",
                    login: "jasur_87",
                    reg_date: "",
                    reg_info: ""
                },
                {
                    id: 2,
                    transaction_id: "TXN-2025-0002",
                    status: "processing",
                    status_comment: "",
                    refund_receipt: "",
                    rejection_act: "",
                    kyc: "Кутилмоқда",
                    e_signature: "Мавжуд эмас",
                    doc_confirm: "Танишилмаган",
                    signed_contract: "",
                    agreement: "",
                    payment_date: "2025-12-07",
                    amount: 8000000,
                    currency: "UZS",
                    payment_status: "pending",
                    payment_method: "Click",
                    full_name: "Каримова Дилноза Рашидовна",
                    phone: "+998 97 777 88 99",
                    login: "dilnoza_k",
                    reg_date: "",
                    reg_info: ""
                },
                {
                    id: 3,
                    transaction_id: "TXN-2025-0003",
                    status: "accepted",
                    status_comment: "",
                    refund_receipt: "",
                    rejection_act: "",
                    kyc: "Тасдиқланган (MyID)",
                    e_signature: "Мавжуд",
                    doc_confirm: "Танишиб чиқилган",
                    signed_contract: "contract_003.pdf",
                    agreement: "agreement_003.pdf",
                    payment_date: "2025-11-30",
                    amount: 25000000,
                    currency: "UZS",
                    payment_status: "approved",
                    payment_method: "Uzcard",
                    full_name: "Исмоилов Отабек Шавкатович",
                    phone: "+998 90 555 11 22",
                    login: "otabek89",
                    reg_date: "2025-12-02",
                    reg_info: "Рўйхатга олинган №A-145/25 сон 02.12.2025"
                },
                {
                    id: 4,
                    transaction_id: "TXN-2025-0004",
                    status: "rejected",
                    status_comment: "KYC ҳужжатлари етарли эмас. MyID орқали тўлиқ маълумотларни тақдим этиш талаб қилинади.",
                    refund_receipt: "refund_004.pdf",
                    rejection_act: "act_004.pdf",
                    kyc: "Рад этилган",
                    e_signature: "Мавжуд эмас",
                    doc_confirm: "Танишилмаган",
                    signed_contract: "",
                    agreement: "",
                    payment_date: "2025-12-03",
                    amount: 3500000,
                    currency: "UZS",
                    payment_status: "declined",
                    payment_method: "Payme",
                    full_name: "Саидов Рустам Комилович",
                    phone: "+998 93 444 33 22",
                    login: "rustam_s",
                    reg_date: "",
                    reg_info: ""
                },
                {
                    id: 5,
                    transaction_id: "TXN-2025-0005",
                    status: "processing",
                    status_comment: "",
                    refund_receipt: "",
                    rejection_act: "",
                    kyc: "Тасдиқланган (MyID)",
                    e_signature: "Мавжуд",
                    doc_confirm: "Танишиб чиқилган",
                    signed_contract: "contract_005.pdf",
                    agreement: "agreement_005.pdf",
                    payment_date: "2025-12-08",
                    amount: 50000,
                    currency: "USD",
                    payment_status: "approved",
                    payment_method: "Visa Card",
                    full_name: "Жонсон Майкл",
                    phone: "+1 555 123 0192",
                    login: "m_johnson",
                    reg_date: "",
                    reg_info: ""
                },
                {
                    id: 6,
                    transaction_id: "TXN-2025-0006",
                    status: "processing",
                    status_comment: "",
                    refund_receipt: "",
                    rejection_act: "",
                    kyc: "Тасдиқланган (MyID)",
                    e_signature: "Мавжуд",
                    doc_confirm: "Танишиб чиқилган",
                    signed_contract: "contract_006.pdf",
                    agreement: "agreement_006.pdf",
                    payment_date: "2025-12-09",
                    amount: 15000000,
                    currency: "UZS",
                    payment_status: "approved",
                    payment_method: "Uzum Bank",
                    full_name: "Турсунова Нилуфар Азизовна",
                    phone: "+998 95 888 77 66",
                    login: "nilufar_t",
                    reg_date: "",
                    reg_info: ""
                }
            ];
            localStorage.setItem('entryRequests', JSON.stringify(entryRequests));
        }

        let defaultRequests = [...entryRequests];

        const tbody = document.getElementById('entryRequestBody');
        const emptyState = document.getElementById('emptyState');
        const searchInput = document.getElementById('searchInput');
        const filterStatus = document.getElementById('filter_status');
        const filterPaymentStatus = document.getElementById('filter_payment_status');
        const acceptSelectedBtn = document.getElementById('acceptSelectedBtn');
        const rejectSelectedBtn = document.getElementById('rejectSelectedBtn');
        const filterBtn = document.getElementById('filterBtn');
        const clearBtn = document.getElementById('clearBtn');
        const checkAll = document.getElementById('checkAll');

        const statusBadge = (s) => {
            if (s === 'accepted') return '<span class="badge badge-custom badge-status-accepted">Қабул қилинган</span>';
            if (s === 'rejected') return '<span class="badge badge-custom badge-status-rejected">Рад этилган</span>';
            return '<span class="badge badge-custom badge-status-processing">Жараёнда</span>';
        };

        const payBadge = (s) => {
            if (s === 'approved') return '<span class="badge badge-custom badge-pay-approved">Тасдиқланган</span>';
            if (s === 'declined') return '<span class="badge badge-custom badge-pay-declined">Рад этилган</span>';
            return '<span class="badge badge-custom badge-pay-pending">Жараёнда</span>';
        };

        function formatCurrency(num, currency) {
            if (num === null || num === undefined) return '-';
            const formatted = new Intl.NumberFormat('uz-UZ').format(num);
            return `${formatted} ${currency || ''}`.trim();
        }

        function docLink(file, color = 'primary') {
            if (!file || file === '' || file === '-') return '<span class="text-muted">-</span>';
            return `<a href="#" class="text-file-link" title="${file}"><i class="bi bi-file-earmark-pdf"></i> ${file}</a>`;
        }

        function escapeHtml(text) {
            if (!text || text === '-') return '-';
            const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
            return String(text).replace(/[&<>"']/g, m => map[m]);
        }

        function renderTable(list = entryRequests) {
            if (!tbody) return;

            if (!list.length) {
                tbody.innerHTML = '';
                if (emptyState) emptyState.style.display = 'block';
                return;
            }
            if (emptyState) emptyState.style.display = 'none';

            let rows = '';
            list.forEach(i => {
                const canCheck = i.status === 'processing';
                rows += `
                        <tr>
                            <td>
                                ${canCheck ? `<input type="checkbox" class="row-check form-check-input" value="${i.id}">` : ''}
                            </td>
                            <td><div class="value-primary">${escapeHtml(i.transaction_id)}</div></td>
                            <td>${statusBadge(i.status)}</td>
                            <td>${escapeHtml(i.status_comment)}</td>
                            <td class="text-center">${docLink(i.refund_receipt, 'success')}</td>
                            <td class="text-center">${docLink(i.rejection_act, 'danger')}</td>
                            <td>${escapeHtml(i.kyc)}</td>
                            <td>${escapeHtml(i.e_signature)}</td>
                            <td>${escapeHtml(i.doc_confirm)}</td>
                            <td class="text-center">${docLink(i.signed_contract)}</td>
                            <td class="text-center">${docLink(i.agreement)}</td>
                            <td class="text-center">${escapeHtml(i.payment_date)}</td>
                            <td class="text-end"><div class="value-primary">${formatCurrency(i.amount, i.currency)}</div></td>
                            <td class="text-center">${escapeHtml(i.currency)}</td>
                            <td>${payBadge(i.payment_status)}</td>
                            <td><span class="badge badge-custom badge-pay-pending">${escapeHtml(i.payment_method)}</span></td>
                            <td><div class="value-primary">${escapeHtml(i.full_name)}</div></td>
                            <td>${escapeHtml(i.phone)}</td>
                            <td><code>${escapeHtml(i.login)}</code></td>
                            <td class="text-center">${escapeHtml(i.reg_date)}</td>
                            <td>${escapeHtml(i.reg_info)}</td>
                        </tr>`;
            });
            tbody.innerHTML = rows;
        }

        if (checkAll) {
            checkAll.onclick = function () {
                document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
            };
        }

        const getSelectedIds = () => [...document.querySelectorAll('.row-check:checked')].map(cb => +cb.value);

        function showAcceptModal() {
            const ids = getSelectedIds();
            if (!ids.length) {
                alert("❌ Қабул қилиш учун камида битта аризани танланг!");
                return;
            }

            const processingCount = ids.filter(id => {
                const item = entryRequests.find(x => x.id === id);
                return item && item.status === 'processing';
            }).length;

            if (processingCount === 0) {
                alert("❌ Фақат 'Жараёнда' ҳолатидаги аризаларни қабул қилиш мумкин!");
                return;
            }

            document.getElementById('acceptCount').textContent = processingCount;
            document.getElementById('registrationDate').value = '';
            document.getElementById('registrationInfo').value = '';

            const modal = new bootstrap.Modal(document.getElementById('acceptModal'));
            modal.show();
        }

        function showRejectModal() {
            const ids = getSelectedIds();
            if (!ids.length) {
                alert("❌ Рад этиш учун камида битта аризани танланг!");
                return;
            }

            const processingCount = ids.filter(id => {
                const item = entryRequests.find(x => x.id === id);
                return item && item.status === 'processing';
            }).length;

            if (processingCount === 0) {
                alert("❌ Фақат 'Жараёнда' ҳолатидаги аризаларни рад этиш мумкин!");
                return;
            }

            document.getElementById('rejectCount').textContent = processingCount;
            document.getElementById('rejectionReason').value = '';

            const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        }

        function confirmAcceptAction() {
            const date = document.getElementById('registrationDate').value;
            const info = document.getElementById('registrationInfo').value;

            if (!date || !info) {
                alert("❌ Барча майдонларни тўлдиринг!");
                return;
            }

            const ids = getSelectedIds();
            let acceptedCount = 0;

            ids.forEach(id => {
                const item = entryRequests.find(x => x.id === id && x.status === 'processing');
                if (item) {
                    item.status = 'accepted';
                    item.reg_date = date;
                    item.reg_info = info;
                    item.status_comment = "";
                    acceptedCount++;
                }
            });

            localStorage.setItem('entryRequests', JSON.stringify(entryRequests));
            defaultRequests = [...entryRequests];

            const modal = bootstrap.Modal.getInstance(document.getElementById('acceptModal'));
            modal.hide();

            applyFilters();

            if (checkAll) checkAll.checked = false;

            alert(`✅ ${acceptedCount} та ариза муваффақиятли қабул қилинди!\n\nИнвесторларга улуш берилди ва инвестицион жараёнлар бошланди.`);
        }

        function confirmRejectAction() {
            const reason = document.getElementById('rejectionReason').value;

            if (!reason || reason.trim() === '') {
                alert("❌ Рад этиш сабабини киритинг!");
                return;
            }

            const ids = getSelectedIds();
            let rejectedCount = 0;

            ids.forEach(id => {
                const item = entryRequests.find(x => x.id === id && x.status === 'processing');
                if (item) {
                    item.status = 'rejected';
                    item.status_comment = reason;
                    item.refund_receipt = `refund_${String(id).padStart(3, '0')}.pdf`;
                    item.rejection_act = `act_${String(id).padStart(3, '0')}.pdf`;
                    item.payment_status = 'declined';
                    rejectedCount++;
                }
            });

            localStorage.setItem('entryRequests', JSON.stringify(entryRequests));
            defaultRequests = [...entryRequests];

            const modal = bootstrap.Modal.getInstance(document.getElementById('rejectModal'));
            modal.hide();

            applyFilters();

            if (checkAll) checkAll.checked = false;

            alert(`✅ ${rejectedCount} та ариза рад этилди!\n\nМолиявий аудитор тўловларни қайтариш жараёнини бошлайди.`);
        }

        function applyFilters() {
            const s = (searchInput?.value || '').toLowerCase().trim();
            const st = filterStatus?.value || '';
            const pay = filterPaymentStatus?.value || '';

            const filtered = defaultRequests.filter(i => {
                const matchSearch = !s ||
                    (i.transaction_id && i.transaction_id.toLowerCase().includes(s)) ||
                    (i.full_name && i.full_name.toLowerCase().includes(s)) ||
                    (i.login && i.login.toLowerCase().includes(s)) ||
                    (i.phone && i.phone.toLowerCase().includes(s));
                const matchStatus = !st || i.status === st;
                const matchPay = !pay || i.payment_status === pay;
                return matchSearch && matchStatus && matchPay;
            });
            renderTable(filtered);
        }

        function resetFilters() {
            if (searchInput) searchInput.value = '';
            if (filterStatus) filterStatus.value = '';
            if (filterPaymentStatus) filterPaymentStatus.value = '';
            renderTable(defaultRequests);
        }

        document.addEventListener('DOMContentLoaded', function () {
            renderTable(defaultRequests);

            if (acceptSelectedBtn) acceptSelectedBtn.addEventListener('click', showAcceptModal);
            if (rejectSelectedBtn) rejectSelectedBtn.addEventListener('click', showRejectModal);

            const confirmAcceptBtn = document.getElementById('confirmAccept');
            const confirmRejectBtn = document.getElementById('confirmReject');

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
            if (filterPaymentStatus) filterPaymentStatus.addEventListener('change', applyFilters);
        });

        window.showAcceptModal = showAcceptModal;
        window.showRejectModal = showRejectModal;
        window.confirmAcceptAction = confirmAcceptAction;
        window.confirmRejectAction = confirmRejectAction;
        window.applyFilters = applyFilters;
        window.resetFilters = resetFilters;

    </script>
@endpush