@extends('layouts.app')

@push('customCss')
    <style>
        .table td, .table th {
            vertical-align: middle;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4 breadcrumb-block">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Ulashga kirish arizalari</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')

{{-- FILTERS --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="row">

            <div class="col-md-3">
                <label>Qidiruv</label>
                <input type="text" id="filter_search" class="form-control" placeholder="F.I.O / Login / Tel">
            </div>

            <div class="col-md-3">
                <label>Ariza holati</label>
                <select id="filter_status" class="form-control">
                    <option value="">— Barchasi —</option>
                    <option value="accepted">Qabul qilingan</option>
                    <option value="processing">Jarayonda</option>
                    <option value="rejected">Rad etilgan</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>To‘lov holati</label>
                <select id="filter_payment_status" class="form-control">
                    <option value="">— Barchasi —</option>
                    <option value="approved">Tasdiqlangan</option>
                    <option value="pending">Jarayonda</option>
                    <option value="declined">Rad etilgan</option>
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button id="filterBtn" class="btn btn-primary w-100">Filter</button>
            </div>

        </div>
    </div>
</div>

{{-- TABLE --}}
<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered m-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tranzaksiya ID</th>
                    <th>Ariza holati</th>
                    <th>Izoh</th>
                    <th>To‘lov sanasi</th>
                    <th>To‘lov summasi</th>
                    <th>Valyuta</th>
                    <th>To‘lov holati</th>
                    <th>To‘lov usuli</th>
                    <th>Invest F.I.O</th>
                    <th>Telefon</th>
                    <th>Login</th>
                    <th>Ro‘yxatdan o‘tgan sana</th>
                    <th>Ro‘yxatdan o‘tish ma’lumoti</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody id="entry-request-body"></tbody>
        </table>
    </div>
</div>

@endsection

@push('customJs')
<script>

// ========================
//   LOCAL STORAGE
// ========================
let entryRequests = JSON.parse(localStorage.getItem('entryRequests') || '[]');

// AGAR BO'SH BO'LSA, STATIC DEMO DATA QO‘YIB TURAMIZ
if (entryRequests.length === 0) {
    entryRequests = [
        {
            id: 1,
            transaction_id: "TXN-10001",
            status: "processing",
            status_comment: "",
            payment_date: "2025-11-25",
            amount: "5 000 000",
            currency: "UZS",
            payment_status: "approved",
            payment_method: "Payme",
            full_name: "Aliyev Sanjar",
            phone: "+998901234567",
            login: "sanjar001",
            reg_date: "-",
            reg_info: "-",
        },
        {
            id: 2,
            transaction_id: "TXN-10002",
            status: "accepted",
            status_comment: "Tasdiqlandi",
            payment_date: "2025-11-20",
            amount: "2 500 000",
            currency: "UZS",
            payment_status: "approved",
            payment_method: "Click",
            full_name: "Karimova Malika",
            phone: "+998909876543",
            login: "malika_k",
            reg_date: "2025-11-23",
            reg_info: "12345-sonli guvohnoma",
        }
    ];

    saveToStorage();
}

function saveToStorage() {
    localStorage.setItem('entryRequests', JSON.stringify(entryRequests));
}

// ========================
//      RENDER TABLE
// ========================
function renderTable(list = entryRequests) {
    let tbody = document.getElementById('entry-request-body');
    tbody.innerHTML = "";

    list.forEach((item, index) => {
        tbody.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.transaction_id}</td>
                <td>${item.status}</td>
                <td>${item.status_comment || '-'}</td>
                <td>${item.payment_date}</td>
                <td>${item.amount}</td>
                <td>${item.currency}</td>
                <td>${item.payment_status}</td>
                <td>${item.payment_method}</td>
                <td>${item.full_name}</td>
                <td>${item.phone}</td>
                <td>${item.login}</td>
                <td>${item.reg_date}</td>
                <td>${item.reg_info}</td>
                <td>
                    <button class="btn btn-success btn-sm" onclick="acceptRequest(${item.id})">
                        Qabul qilish
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="rejectRequest(${item.id})">
                        Rad etish
                    </button>
                </td>
            </tr>
        `;
    });
}

// ========================
//     ACCEPT REQUEST
// ========================
function acceptRequest(id) {
    let item = entryRequests.find(i => i.id === id);
    if (!item) return;

    let date = prompt("Ro‘yxatdan o‘tgan sanani kiriting (yyyy-mm-dd):");
    if (!date) return;

    let info = prompt("Ro‘yxatdan o‘tish ma’lumotlarini kiriting:");
    if (!info) return;

    item.status = "accepted";
    item.reg_date = date;
    item.reg_info = info;

    saveToStorage();
    renderTable();
}

// ========================
//      REJECT REQUEST
// ========================
function rejectRequest(id) {
    let item = entryRequests.find(i => i.id === id);
    if (!item) return;

    let reason = prompt("Rad etish sababini kiriting:");
    if (!reason) return;

    item.status = "rejected";
    item.status_comment = reason;

    saveToStorage();
    renderTable();
}

// ========================
//        FILTERS
// ========================
function applyFilters() {
    let search = document.getElementById('filter_search').value.toLowerCase();
    let status = document.getElementById('filter_status').value;
    let paymentStatus = document.getElementById('filter_payment_status').value;

    let filtered = entryRequests.filter(i => {
        return (
            (i.full_name.toLowerCase().includes(search) ||
             i.login.toLowerCase().includes(search) ||
             i.phone.includes(search)) &&
            (status ? i.status === status : true) &&
            (paymentStatus ? i.payment_status === paymentStatus : true)
        );
    });

    renderTable(filtered);
}

document.getElementById('filterBtn').addEventListener('click', applyFilters);

// First render
renderTable();

</script>
@endpush
