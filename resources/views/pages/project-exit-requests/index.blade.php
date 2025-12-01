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
                    <a href="#"><i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Ulashdan chiqish arizalari</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')

{{-- FILTERS CARD --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="row">

            <div class="col-md-3">
                <label>Qidiruv</label>
                <input type="text" id="filter_search_exit" class="form-control" placeholder="F.I.O / Login / Tel">
            </div>

            <div class="col-md-3">
                <label>Ariza holati</label>
                <select id="filter_exit_status" class="form-control">
                    <option value="">— Barchasi —</option>
                    <option value="accepted">Qabul qilingan</option>
                    <option value="processing">Jarayonda</option>
                    <option value="rejected">Rad etilgan</option>
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button id="filterExitBtn" class="btn btn-primary w-100">Filter</button>
            </div>

        </div>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered m-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ulashdan chiqish ID</th>
                    <th>Ariza holati</th>
                    <th>Izoh</th>
                    <th>Ko‘rib chiqish muddati</th>
                    <th>Invest F.I.O</th>
                    <th>Telefon</th>
                    <th>Login</th>
                    <th>Amallar</th>
                </tr>
            </thead>
            <tbody id="exit-request-body"></tbody>
        </table>
    </div>
</div>

@endsection

@push('customJs')
<script>

// ========================================
//            LOCAL STORAGE
// ========================================

let exitRequests = JSON.parse(localStorage.getItem('exitRequests') || '[]');

// Static demo data agar LocalStorage bo‘sh bo‘lsa
if (exitRequests.length === 0) {
    exitRequests = [
        {
            id: 1,
            exit_id: "EXIT-20001",
            status: "processing",
            status_comment: "",
            deadline: "2025-12-05",
            full_name: "Rasulov Islom",
            phone: "+998901223344",
            login: "islom_dev",
        },
        {
            id: 2,
            exit_id: "EXIT-20002",
            status: "accepted",
            status_comment: "Tasdiqlandi",
            deadline: "2025-12-01",
            full_name: "Sobirova Farangiz",
            phone: "+998907778899",
            login: "farangiz_s",
        }
    ];
    saveExitStorage();
}

function saveExitStorage() {
    localStorage.setItem('exitRequests', JSON.stringify(exitRequests));
}

// ========================================
//              RENDER TABLE
// ========================================

function renderExitRequests(list = exitRequests) {
    let tbody = document.getElementById('exit-request-body');
    tbody.innerHTML = "";

    list.forEach((item, index) => {
        tbody.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.exit_id}</td>
                <td>${item.status}</td>
                <td>${item.status_comment || '-'}</td>
                <td>${item.deadline}</td>
                <td>${item.full_name}</td>
                <td>${item.phone}</td>
                <td>${item.login}</td>
                <td>
                    <button class="btn btn-success btn-sm" onclick="acceptExit(${item.id})">Qabul qilish</button>
                    <button class="btn btn-danger btn-sm" onclick="rejectExit(${item.id})">Rad etish</button>
                </td>
            </tr>
        `;
    });
}

// ========================================
//           ACCEPT EXIT REQUEST
// ========================================

function acceptExit(id) {
    let item = exitRequests.find(i => i.id === id);
    if (!item) return;

    // Hech qanday qo‘shimcha maydon so‘ralmaydi
    item.status = "accepted";
    item.status_comment = "Ariza qabul qilindi";

    saveExitStorage();
    renderExitRequests();

    alert("Ariza qabul qilindi. Yangi raunt ochilishi kerak.");
}

// ========================================
//           REJECT EXIT REQUEST
// ========================================

function rejectExit(id) {
    let item = exitRequests.find(i => i.id === id);
    if (!item) return;

    let reason = prompt("Rad etish sababini kiriting:");
    if (!reason) return;

    item.status = "rejected";
    item.status_comment = reason;

    saveExitStorage();
    renderExitRequests();
}

// ========================================
//                FILTERS
// ========================================

function applyExitFilters() {
    let search = document.getElementById('filter_search_exit').value.toLowerCase();
    let status = document.getElementById('filter_exit_status').value;

    let filtered = exitRequests.filter(i => {
        return (
            (i.full_name.toLowerCase().includes(search) ||
             i.phone.includes(search) ||
             i.login.toLowerCase().includes(search)) &&
            (status ? i.status === status : true)
        );
    });

    renderExitRequests(filtered);
}

document.getElementById('filterExitBtn').addEventListener('click', applyExitFilters);

// Initial render
renderExitRequests();

</script>
@endpush
