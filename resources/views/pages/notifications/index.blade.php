@extends('layouts.app')

@push('customCss')
    <style>

        /* Jadval HEAD dizayni */
        thead.table-dark {
            background-color: #2c3e50 !important;
        }

        thead.table-dark th input[type="checkbox"] {
            accent-color: #ffffff; /* Oq checkbox */
        }

        /* O‘qilmagan xabar */
        .row-unread {
            background-color: #eef6ff !important;
            font-weight: 600;
            color: #2c3e50;
        }

        /* O‘qilgan xabar */
        .row-read {
            background-color: #ffffff !important;
            color: #6c757d;
        }

        /* Turlar uchun ranglar */
        .badge-type {
            font-size: 0.85rem;
            padding: 6px 10px;
            border-radius: 8px;
        }

        .bg-technical {
            background-color: #e7f1ff;
            color: #0d6efd;
            border: 1px solid #b6d4fe;
        }

        .bg-request {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .bg-error {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
        }

        /* Holat nishonlari */
        .status-indicator {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-unread-badge {
            background: #e7f1ff;
            color: #0d6efd;
        }

        .status-read-badge {
            background: #e9f7ef;
            color: #198754;
        }


    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4 breadcrumb-block">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('admin.notifications')}}</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')

    {{-- FILTER PANEL --}}
    <div class="filter-card mb-3 border rounded"
         style="border-color: rgba(0,0,0,0.1); border-radius: 0.5rem; background-color: #fff;">


        <!-- Filter header -->
        <div class="d-flex justify-content-between align-items-center p-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-search"></i>
                <span>Filterlar</span>
            </div>

            <button class="btn btn-sm rounded-pill px-3 py-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#notificationFilterContent" aria-expanded="true"
                    aria-controls="notificationFilterContent" id="userToggleFilterBtn"
                    style="background-color: #1F2937; color: #ffffff;">
                <i class="bi bi-caret-down-fill me-2" id="notificationFilterIcon" style="color: #ffffff;"> </i>
                <span id="notificationFilterText">Yopish</span>
            </button>
        </div>

        <!-- Filter content -->
        <div class="collapse show" id="notificationFilterContent">
            <div class="row g-3 align-items-end p-3">
                {{-- Qidiruv --}}
                <div class="col-md-4">
                    <label class="form-label text-muted small">Qidiruv</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control" placeholder="Kalit so‘z...">
                    </div>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted small">Turi</label>
                    <select id="typeFilter" class="form-select">
                        <option value="">Barchasi</option>
                        <option value="technical">Texnik</option>
                        <option value="request">So‘rov</option>
                        <option value="error">Xato</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted small">Holati</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">Barchasi</option>
                        <option value="unread">O‘qilmagan</option>
                        <option value="read">O‘qilgan</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted small">Dan (Sana)</label>
                    <input type="date" id="startDate" class="form-control">
                </div>

                {{-- Tugmalar --}}
                <div class="col-md-2 d-flex gap-2">
                    <button id="filterBtn" class="btn btn-primary w-50">
                        <i class="fas fa-filter"></i> {{__('admin.search')}}
                    </button>

                    <button id="clearBtn" class="btn btn-warning w-50">
                        {{__('admin.clear')}}
                    </button>
                </div>
            </div>
        </div>
    </div>


    {{-- TABLE --}}
    <div class="card card-body py-1 px-2 shadow border-0 table-wrapper table-responsive">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 text-primary"><i class="fas fa-bell me-2"></i>Bildirishnomalar ro‘yxati</h5>
        </div>

            <table class="table user-table table-hover table-bordered  table-striped align-items-center">
                <thead class="table-dark">
                <tr>
                    <th style="width: 40px;">
                        <input type="checkbox" class="form-check-input" id="checkAll">
                    </th>
                    <th>Vaqt</th>
                    <th>Turi</th>
                    <th>Xabar Matni</th>
                    <th class="text-center">Holati</th>
                </tr>
                </thead>
                <tbody id="notifBody"></tbody>
            </table>
    </div>

@endsection

@push('customJs')
    <script>
        function initFilterToggle(buttonId, contentId, iconId, textId) {
            const collapseEl = document.getElementById(contentId);
            const button = document.getElementById(buttonId);
            const icon = document.getElementById(iconId);
            const text = document.getElementById(textId);

            collapseEl.addEventListener('shown.bs.collapse', () => {
                console.log('ishladi yopish');

                icon.classList.remove('bi-caret-up-fill');
                icon.classList.add('bi-caret-down-fill');
                text.textContent = 'Yopish';
            });

            collapseEl.addEventListener('hidden.bs.collapse', () => {
                console.log('ishladi ochish');
                icon.classList.remove('bi-caret-down-fill');
                icon.classList.add('bi-caret-up-fill');
                text.textContent = 'Ochish';
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            initFilterToggle('notificationToggleFilterBtn', 'notificationFilterContent', 'notificationFilterIcon', 'notificationFilterText');
        });
    </script>
    <script>

        let notifications = [
            {
                id: 1,
                date: "2025-12-01 09:14",
                type: "technical",
                text: "Server yuklanishi 85% ga yetdi.",
                status: "unread"
            },
            {id: 2, date: "2025-12-01 10:22", type: "request", text: "User parolni tiklashni so‘radi.", status: "read"},
            {id: 3, date: "2025-12-01 11:48", type: "error", text: "DB Connection Timeout xatosi.", status: "unread"},
            {
                id: 4,
                date: "2025-12-02 08:25",
                type: "technical",
                text: "Tizim yangilanishi yakunlandi.",
                status: "read"
            },
            {
                id: 5,
                date: "2025-12-02 12:14",
                type: "request",
                text: "Investor ro‘yxatdan o‘tishga so‘rov yubordi.",
                status: "unread"
            },
            {id: 6, date: "2025-12-03 14:00", type: "error", text: "To‘lov shlyuzida 502 xato.", status: "unread"}
        ];


        /* === RENDER === */
        function renderNotifications() {
            const tbody = document.getElementById("notifBody");
            tbody.innerHTML = "";

            let filtered = applyFilters();

            if (filtered.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="text-center py-4 text-muted">Ma'lumot topilmadi</td></tr>`;
                return;
            }

            filtered.forEach(notif => {
                let rowClass = notif.status === "unread" ? "row-unread" : "row-read";
                let typeCfg = getTypeConfig(notif.type);

                let statusBadge =
                    notif.status === "unread"
                        ? `
            <span class="status-badge status-unread-badge">
                <i class="bi bi-envelope-arrow-down-fill me-1"></i>
                O‘qilmagan
            </span>
        `
                        : `
            <span class="status-badge status-read-badge">
                <i class="bi bi-envelope-open me-1"></i>
                O‘qilgan
            </span>
        `;


                tbody.innerHTML += `
        <tr class="${rowClass}">
            <td>
                <input type="checkbox" class="form-check-input notif-checkbox"
                    data-id="${notif.id}"
                    ${notif.status === "read" ? "checked" : ""}
                    onchange="updateStatus(${notif.id}, this.checked)">
            </td>

            <td><small class="text-muted"><i class="far fa-clock me-1"></i>${notif.date}</small></td>

            <td>
                <span class="badge-type ${typeCfg.class}">
                    ${typeCfg.icon} ${typeCfg.label}
                </span>
            </td>

            <td>${notif.text}</td>

            <td class="text-center">${statusBadge}</td>
        </tr>
        `;
            });
        }


        /* === STATUS UPDATE === */
        function updateStatus(id, isChecked) {
            let item = notifications.find(n => n.id === id);
            item.status = isChecked ? "read" : "unread";
            renderNotifications();
        }


        /* === TYPE CONFIG === */
        function getTypeConfig(type) {
            switch (type) {
                case "technical":
                    return {class: "bg-technical", icon: '<i class="fas fa-server"></i>', label: "Texnik"};
                case "request":
                    return {class: "bg-request", icon: '<i class="fas fa-user-edit"></i>', label: "So‘rov"};
                case "error":
                    return {class: "bg-error", icon: '<i class="fas fa-exclamation-triangle"></i>', label: "Xato"};
                default:
                    return {class: "bg-light", icon: '<i class="fas fa-info-circle"></i>', label: "Info"};
            }
        }


        /* === FILTERS === */
        function applyFilters() {
            let search = document.getElementById("searchInput").value.toLowerCase();
            let type = document.getElementById("typeFilter").value;
            let status = document.getElementById("statusFilter").value;
            let start = document.getElementById("startDate").value;

            return notifications.filter(n => {
                return (
                    n.text.toLowerCase().includes(search) &&
                    (type ? n.type === type : true) &&
                    (status ? n.status === status : true) &&
                    (start ? n.date >= start : true)
                );
            }).sort((a, b) => new Date(b.date) - new Date(a.date));
        }


        /* === CHECK ALL === */
        document.getElementById("checkAll").onclick = function () {
            let isChecked = this.checked;

            notifications = notifications.map(n => ({
                ...n,
                status: isChecked ? "read" : "unread"
            }));

            renderNotifications();
        };


        /* BUTTON EVENTS */
        document.getElementById("filterBtn").onclick = renderNotifications;
        document.getElementById("clearBtn").onclick = () => {
            document.getElementById("searchInput").value = "";
            document.getElementById("typeFilter").value = "";
            document.getElementById("statusFilter").value = "";
            document.getElementById("startDate").value = "";
            renderNotifications();
        };


        /* INIT */
        renderNotifications();

    </script>
@endpush
