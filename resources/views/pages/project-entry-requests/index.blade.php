{{-- resources/views/admin/project-entry-requests/index.blade.php --}}
@extends('layouts.app')

@push('customCss')
<style>
.table td,
.table th {
    vertical-align: middle;
    font-size: 0.925rem;
}

.badge {
    font-size: 0.8rem;
}

.form-control,
.form-select {
    font-size: 0.9rem;
}

.filter-card {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}
</style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between align-items-center py-3 breadcrumb-block px-3 mt-3"
    style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px;">
    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item active">{{ __('admin.project_entry_requests') }}</li>
            </ol>
        </nav>
    </div>
    <button class="btn btn-sm btn-light border" data-bs-toggle="collapse"
        data-bs-target="#projectEntryRequestFilterContent" aria-expanded="true">
        <i class="bi bi-sliders2"></i>
    </button>
</div>
@endsection

@section('content')

{{-- FILTER --}}
<div class="filter-card mt-3 collapse show" id="projectEntryRequestFilterContent">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-3">
                    <label class="form-label">{{ __('admin.application_status') }}</label>
                    <select id="filter_status" class="form-select form-select-sm">
                        <option value="">{{ __('admin.all') }}</option>
                        <option value="processing">{{ __('admin.status_processing') }}</option>
                        <option value="accepted">{{ __('admin.status_accepted') }}</option>
                        <option value="rejected">{{ __('admin.status_rejected') }}</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">{{ __('admin.payment_status') }}</label>
                    <select id="filter_payment_status" class="form-select form-select-sm">
                        <option value="">{{ __('admin.all') }}</option>
                        <option value="approved">{{ __('admin.payment_approved') }}</option>
                        <option value="pending">{{ __('admin.payment_pending') }}</option>
                        <option value="declined">{{ __('admin.payment_declined') }}</option>
                    </select>
                </div>

                <x-filter-buttons />

                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button onclick="acceptSelected()" class="btn btn-success btn-sm flex-fill">
                        <i class="bi bi-check2-circle"></i> {{ __('admin.accept_selected') }}
                    </button>
                    <button onclick="rejectSelected()" class="btn btn-danger btn-sm flex-fill">
                        <i class="bi bi-x-circle"></i> {{ __('admin.reject_selected') }}
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- TABLE --}}
<div class="card mt-3 shadow border-0">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0">{{ __('admin.project_entry_requests') }}</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th width="40"><input type="checkbox" id="checkAll"></th>
                    <th>{{ __('admin.txn_id') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.comment') }}</th>
                    <th>{{ __('admin.receipt') }}</th>
                    <th>{{ __('admin.act') }}</th>
                    <th>KYC</th>
                    <th>{{ __('admin.e_signature') }}</th>
                    <th>{{ __('admin.doc_confirm') }}</th>
                    <th>{{ __('admin.contract') }}</th>
                    <th>{{ __('admin.agreement') }}</th>
                    <th>{{ __('admin.payment_date') }}</th>
                    <th>{{ __('admin.amount') }}</th>
                    <th>{{ __('admin.currency') }}</th>
                    <th>{{ __('admin.payment_status') }}</th>
                    <th>{{ __('admin.payment_method') }}</th>
                    <th>{{ __('admin.investor') }}</th>
                    <th>{{ __('admin.phone') }}</th>
                    <th>{{ __('admin.login') }}</th>
                    <th>{{ __('admin.reg_date') }}</th>
                    <th>{{ __('admin.reg_info') }}</th>
                </tr>
            </thead>
            <tbody id="entry-request-body">
                {{-- JS orqali to'ldiriladi --}}
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-white text-center py-3" id="no-data" style="d-none">
        <em class="text-muted">{{ __('admin.no_data') }}</em>
    </div>
</div>

@endsection

@push('customJs')
<script>
// ================= REALISTIK MA'LUMOTLAR =================
let entryRequests = JSON.parse(localStorage.getItem('entryRequests') || '[]');

if (!entryRequests.length) {
    entryRequests = [{
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
            amount: "12 500 000",
            currency: "UZS",
            payment_status: "approved",
            payment_method: "Payme",
            full_name: "Xolmatov Jasurbek",
            phone: "+998 99 123 45 67",
            login: "jasur_87",
            reg_date: "-",
            reg_info: "-"
        },
        {
            id: 2,
            transaction_id: "TXN-2025-0002",
            status: "processing",
            status_comment: "",
            refund_receipt: "-",
            rejection_act: "-",
            kyc: "Kutilmoqda",
            e_signature: "Mavjud emas",
            doc_confirm: "Rad etilgan",
            signed_contract: "-",
            agreement: "-",
            payment_date: "2025-12-07",
            amount: "8 000 000",
            currency: "UZS",
            payment_status: "pending",
            payment_method: "Click",
            full_name: "Karimova Dilnoza",
            phone: "+998 97 777 88 99",
            login: "dilnoza_k",
            reg_date: "-",
            reg_info: "-"
        },
        {
            id: 3,
            transaction_id: "TXN-2025-0003",
            status: "accepted",
            status_comment: "",
            refund_receipt: "-",
            rejection_act: "-",
            kyc: "Tasdiqlangan",
            e_signature: "Mavjud",
            doc_confirm: "Tasdiqlangan",
            signed_contract: "contract_003.pdf",
            agreement: "agreement_003.pdf",
            payment_date: "2025-11-30",
            amount: "25 000 000",
            currency: "UZS",
            payment_status: "approved",
            payment_method: "Uzcard",
            full_name: "Ismoilov Otabek",
            phone: "+998 90 555 11 22",
            login: "otabek89",
            reg_date: "2025-12-02",
            reg_info: "Ro'yxatga olingan №A-145/25"
        },
        {
            id: 4,
            transaction_id: "TXN-2025-0004",
            status: "rejected",
            status_comment: "KYC hujjatlari yetarli emas",
            refund_receipt: "refund_004.pdf",
            rejection_act: "act_004.pdf",
            kyc: "Rad etilgan",
            e_signature: "Mavjud emas",
            doc_confirm: "Rad etilgan",
            signed_contract: "-",
            agreement: "-",
            payment_date: "2025-12-03",
            amount: "3 500 000",
            currency: "UZS",
            payment_status: "declined",
            payment_method: "Payme",
            full_name: "Saidov Rustam",
            phone: "+998 93 444 33 22",
            login: "rustam_s",
            reg_date: "-",
            reg_info: "-"
        },
        {
            id: 5,
            transaction_id: "TXN-2025-0005",
            status: "processing",
            status_comment: "",
            refund_receipt: "-",
            rejection_act: "-",
            kyc: "Tasdiqlangan",
            e_signature: "Mavjud",
            doc_confirm: "Tasdiqlangan",
            signed_contract: "-",
            agreement: "-",
            payment_date: "2025-12-08",
            amount: "50 000",
            currency: "USD",
            payment_status: "approved",
            payment_method: "Visa",
            full_name: "Johnson Michael",
            phone: "+1 555 0192",
            login: "m_johnson",
            reg_date: "-",
            reg_info: "-"
        }
    ];
    localStorage.setItem('entryRequests', JSON.stringify(entryRequests));
}

// ================= BADGES =================
const statusBadge = (s) => {
    if (s === 'accepted') return `<span class="badge bg-success">{{ __('admin.status_accepted') }}</span>`;
    if (s === 'rejected') return `<span class="badge bg-danger">{{ __('admin.status_rejected') }}</span>`;
    return `<span class="badge bg-warning text-dark">{{ __('admin.status_processing') }}</span>`;
};

const payBadge = (s) => {
    if (s === 'approved') return `<span class="badge bg-success">{{ __('admin.payment_approved') }}</span>`;
    if (s === 'declined') return `<span class="badge bg-danger">{{ __('admin.payment_declined') }}</span>`;
    return `<span class="badge bg-warning text-dark">{{ __('admin.payment_pending') }}</span>`;
};

// ================= RENDER =================
function renderTable(list = entryRequests) {
    const tbody = document.getElementById('entry-request-body');
    if (!list.length) {
        tbody.innerHTML =
            `<tr><td colspan="21" class="text-center py-4 text-muted">{{ __('admin.no_data') }}</td></tr>`;
        document.getElementById('no-data').classList.remove('d-none');
        return;
    }

    document.getElementById('no-data').classList.add('d-none');
    let rows = '';
    list.forEach(i => {
        rows += `
            <tr>
                <td><input type="checkbox" class="row-check form-check-input" value="${i.id}"></td>
                <td><strong>${i.transaction_id}</strong></td>
                <td>${statusBadge(i.status)}</td>
                <td>${i.status_comment || '-'}</td>
                <td>${i.refund_receipt !== '-' ? `<a href="#" class="text-primary"><i class="bi bi-file-earmark-pdf"></i> ${i.refund_receipt}</a>` : '-'}</td>
                <td>${i.rejection_act !== '-' ? `<a href="#" class="text-danger"><i class="bi bi-file-earmark-pdf"></i> ${i.rejection_act}</a>` : '-'}</td>
                <td><span class="badge ${i.kyc === 'Tasdiqlangan' ? 'bg-success' : 'bg-secondary'}">${i.kyc}</span></td>
                <td><span class="badge ${i.e_signature === 'Mavjud' ? 'bg-success' : 'bg-secondary'}">${i.e_signature}</span></td>
                <td><span class="badge ${i.doc_confirm === 'Tasdiqlangan' ? 'bg-success' : 'bg-danger'}">${i.doc_confirm}</span></td>
                <td>${i.signed_contract !== '-' ? `<a href="#" class="text-primary"><i class="bi bi-file-earmark-text"></i></a>` : '-'}</td>
                <td>${i.agreement !== '-' ? `<a href="#" class="text-primary"><i class="bi bi-file-earmark-check"></i></a>` : '-'}</td>
                <td>${i.payment_date}</td>
                <td><strong>${i.amount}</strong></td>
                <td>${i.currency}</td>
                <td>${payBadge(i.payment_status)}</td>
                <td><span class="badge bg-info">${i.payment_method}</span></td>
                <td>${i.full_name}</td>
                <td><a href="tel:${i.phone}">${i.phone}</a></td>
                <td><code>${i.login}</code></td>
                <td>${i.reg_date || '-'}</td>
                <td>${i.reg_info || '-'}</td>
            </tr>`;
    });
    tbody.innerHTML = rows;
}

// ================= CHECK ALL =================
document.getElementById('checkAll').onclick = function() {
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
};

// ================= SELECTED IDS =================
const getSelectedIds = () => [...document.querySelectorAll('.row-check:checked')].map(cb => +cb.value);

// ================= ACCEPT =================
function acceptSelected() {
    const ids = getSelectedIds();
    if (!ids.length) return alert("{{ __('admin.no_rows_selected') }}");

    const date = prompt("{{ __('admin.enter_reg_date') }} (YYYY-MM-DD)");
    const info = prompt("{{ __('admin.enter_reg_info') }}");

    if (!date || !info) return;

    ids.forEach(id => {
        const item = entryRequests.find(x => x.id === id && x.status === 'processing');
        if (item) {
            item.status = 'accepted';
            item.reg_date = date;
            item.reg_info = info;
        }
    });

    localStorage.setItem('entryRequests', JSON.stringify(entryRequests));
    renderTable();
    alert("{{ __('admin.selected_accepted') }}");
}

// ================= REJECT =================
function rejectSelected() {
    const ids = getSelectedIds();
    if (!ids.length) return alert("{{ __('admin.no_rows_selected') }}");

    const reason = prompt("{{ __('admin.enter_reject_reason') }}");
    if (!reason) return;

    ids.forEach(id => {
        const item = entryRequests.find(x => x.id === id && x.status === 'processing');
        if (item) {
            item.status = 'rejected';
            item.status_comment = reason;
        }
    });

    localStorage.setItem('entryRequests', JSON.stringify(entryRequests));
    renderTable();
    alert("{{ __('admin.selected_rejected') }}");
}

// ================= FILTER =================
document.getElementById('filterBtn').onclick = () => {
    const status = document.getElementById('filter_status').value;
    const payStatus = document.getElementById('filter_payment_status').value;

    const filtered = entryRequests.filter(i => {
        return (!status || i.status === status) && (!payStatus || i.payment_status === payStatus);
    });

    renderTable(filtered);
};

// Init
renderTable();
</script>
@endpush