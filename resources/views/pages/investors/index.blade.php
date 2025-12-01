@extends('layouts.app')

@push('customCss')
    <style>
        .status-active {
            color: #1e7e34;
            font-weight: bold;
        }

        .status-blocked {
            color: #bd2130;
            font-weight: bold;
        }

        .status-pending {
            color: #d39e00;
            font-weight: bold;
        }

        .label-verified {
            background-color: #1e7e34;
            color: #fff;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 0.7rem;
            margin-left: 5px;
        }

        .label-unverified {
            background-color: #d39e00;
            color: #fff;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 0.7rem;
            margin-left: 5px;
        }

        .action-btn i {
            font-size: 18px;
        }
    </style>
@endpush


@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4 breadcrumb-block">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Investorlar</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection



@section('content')

    <!-- Filter card -->
    <div class="filter-card mb-3 border rounded"
         style="border-color: rgba(0,0,0,0.1); border-radius: 0.5rem; background-color: #fff;">

        <div class="d-flex justify-content-between align-items-center p-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-search"></i>
                <span>Filterlar</span>
            </div>

            <button class="btn btn-sm rounded-pill px-3 py-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#investorFilterContent"
                    aria-controls="investorFilterContent"
                    id="toggleFilterBtn"
                    style="background-color:#1F2937;color:#fff;">
                <i class="bi bi-caret-down-fill me-2" id="filterIcon"></i>
                <span id="filterText">Ochish</span>
            </button>
        </div>

        <div class="collapse" id="investorFilterContent">
            <div class="row g-3 align-items-end p-3">
                <div class="col-md-6">
                    <label for="searchInput">Qidiruv</label>
                    <input type="text" id="searchInput" class="form-control"
                           placeholder="Ism, Login, Telefon...">
                </div>

                <div class="col-md-4">
                    <label for="statusFilter">Status</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">Barchasi</option>
                        <option value="Faol">Faol</option>
                        <option value="Bloklangan">Bloklangan</option>
                        <option value="Kutilmoqda">Kutilmoqda</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button id="filterBtn" class="btn btn-primary w-50">
                        <i class="fas fa-filter"></i> Izlash
                    </button>

                    <button id="clearBtn" class="btn btn-warning w-50">
                        Tozalash
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="card card-body py-1 px-2 shadow border-0 table-wrapper table-responsive">

        <div class="d-flex justify-content-between align-items-center p-3">
            <h5 class="mb-0">
                <i class="fas fa-user-tie me-2"></i> Investorlar
            </h5>
            <div class="d-flex gap-2">
                <button class="btn btn-success"><i class="fas fa-file-excel me-1"></i> Excel</button>
                <button class="btn btn-info text-white"><i class="fas fa-file-csv me-1"></i> CSV</button>
            </div>
        </div>


        <table class="table user-table table-hover table-striped table-bordered align-items-center">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>F.I.O</th>
                <th>Login</th>
                <th>Telefon</th>
                <th>Passport</th>
                <th>JSHIR</th>
                <th>Status</th>
                <th>Oxirgi kirish</th>
                <th>Amallar</th>
            </tr>
            </thead>
            <tbody id="investorTableBody">
            </tbody>
        </table>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-start p-2">
            <nav>
                <ul class="pagination pagination-sm mb-0" id="pagination"></ul>
            </nav>
        </div>

    </div>

@endsection




@push('customJs')
    <script>

        // 15 ta statik investorlar
        const investors = [
            [1, 'Jasur Islomov', 'jasur', '+998901234567', 'AA1234567', '12345678901234', 'Faol', 'Tasdiqlangan', '2025-11-25 14:32'],
            [2, 'Gulbahor Qodirova', 'gulbahor', '+998909876543', 'AB7654321', '98765432109876', 'Kutilmoqda', 'Tasdiqlanmagan', '2025-11-26 09:15'],
            [3, 'Olimjon Tursunov', 'olimjon', '+998933445566', 'AC1122334', '11223344556677', 'Faol', 'Tasdiqlangan', '2025-11-27 08:50'],
            [4, 'Nilufar Rasulova', 'nilufar', '+998922334455', 'AD5566778', '55667788901234', 'Bloklangan', 'Tasdiqlanmagan', '2025-11-24 18:20'],
            [5, 'Azizbek Karimov', 'azizbek', '+998911223344', 'AA9988776', '99887766554433', 'Faol', 'Tasdiqlangan', '2025-11-26 12:45'],
            [6, 'Saodat Davronova', 'saodat', '+998900112233', 'AB4455667', '44556677889900', 'Kutilmoqda', 'Tasdiqlanmagan', '2025-11-23 16:10'],
            [7, 'Oybek Rahimov', 'oybek', '+998905554433', '', '', 'Kutilmoqda', 'Tasdiqlanmagan', '2025-11-22 11:10'],
            [8, 'Dilorom Mamarasul', 'dilorom', '+998909998877', 'AC5544332', '55443322110099', 'Faol', 'Tasdiqlangan', '2025-11-21 17:33'],
            [9, 'Sirojiddin Bekmurodov', 'siroj', '+998900011223', '', '', 'Kutilmoqda', 'Tasdiqlanmagan', '2025-11-20 09:55'],
            [10, 'Komil Qurbonov', 'komil', '+998933301122', 'AA8899007', '88990077665544', 'Faol', 'Tasdiqlangan', '2025-11-19 08:12'],
            [11, 'Madina Usmonova', 'madina', '+998930045612', 'AB1122994', '11229944556677', 'Bloklangan', 'Tasdiqlangan', '2025-11-18 19:55'],
            [12, 'Jamshid Soliyev', 'jamshid', '+998950033221', 'AC7788112', '77881122334455', 'Faol', 'Tasdiqlangan', '2025-11-17 16:40'],
            [13, 'Shohjahon Abdullayev', 'shoh', '+998977712345', 'AD6677885', '66778855332211', 'Faol', 'Tasdiqlangan', '2025-11-16 10:27'],
            [14, 'Hilola Qodirova', 'hilola', '+998934455667', '', '', 'Kutilmoqda', 'Tasdiqlanmagan', '2025-11-15 14:22'],
            [15, 'Aziza Matyoqubova', 'aziza', '+998990112233', 'AA4455667', '44556677889911', 'Faol', 'Tasdiqlangan', '2025-11-14 18:00'],
        ];


        // PAGINATION SETTINGS
        const perPage = 10;
        const totalPages = 2;
        let currentPage = 1;


        // TABLE RENDER
        function renderTable() {
            let tbody = document.getElementById('investorTableBody');
            tbody.innerHTML = "";

            let start = (currentPage - 1) * perPage;
            let end = start + perPage;
            let pageData = investors.slice(start, end);

            pageData.forEach(inv => {
                tbody.innerHTML += `
        <tr>
            <td>${inv[0]}</td>
            <td>
                ${inv[1]}
                ${inv[7] === 'Tasdiqlangan'
                    ? '<span class="label-verified">Tasdiqlangan</span>'
                    : '<span class="label-unverified">Tasdiqlanmagan</span>'}
            </td>
            <td>${inv[2]}</td>
            <td>${inv[3]}</td>

            <td>${inv[7] === 'Tasdiqlangan' ? inv[4] : '-'}</td>
            <td>${inv[7] === 'Tasdiqlangan' ? inv[5] : '-'}</td>

            <td>
                ${inv[6] === 'Faol'
                    ? '<span class="status-active">Faol</span>'
                    : inv[6] === 'Bloklangan'
                        ? '<span class="status-blocked">Bloklangan</span>'
                        : '<span class="status-pending">Kutilmoqda</span>'}
            </td>

            <td>${inv[8]}</td>

            <td class="text-center">
                <i class="bi bi-eye-fill me-2"></i>
                <i class="fas fa-shield-alt text-danger"></i>
            </td>
        </tr>`;
            });

            renderPagination();
        }


        // PAGINATION BUTTONS
        function renderPagination() {
            let pagination = document.getElementById('pagination');
            pagination.innerHTML = "";

            pagination.innerHTML += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <button class="page-link" onclick="goPage(${currentPage - 1})">«</button>
        </li>`;

            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `
            <li class="page-item ${currentPage === i ? 'active' : ''}">
                <button class="page-link" onclick="goPage(${i})">${i}</button>
            </li>`;
            }

            pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <button class="page-link" onclick="goPage(${currentPage + 1})">»</button>
        </li>`;
        }


        function goPage(page) {
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable();
        }


        // INIT
        renderTable();

    </script>
@endpush
