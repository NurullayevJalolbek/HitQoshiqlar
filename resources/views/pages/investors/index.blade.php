@extends('layouts.app')

@push('customCss')
    <style>
        /* Status ranglari minimal CSS */
        .status-active {
            color: #28a745;
            font-weight: bold;
        }

        .status-blocked {
            color: #dc3545;
            font-weight: bold;
        }

        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }

        .label-verified {
            background-color: #28a745;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.75rem;
            margin-left: 5px;
        }

        .label-unverified {
            background-color: #ffc107;
            color: black;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.75rem;
            margin-left: 5px;
        }

        .action-btns i {
            font-size: 1rem;
            cursor: pointer;
        }

        /* disabled icon */
        .disabled-icon {
            pointer-events: none;  /* bosish mumkin emas */
            opacity: 0.5;          /* rangni biroz o‘chiramiz */
            cursor: default;       /* kursorni default qilamiz */
            color: #6c757d !important; /* kulrang rang (Bootstrap text-muted bilan mos) */
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
    {{-- Filter --}}
    <div class="card p-3 mb-3">
        <div class="row g-3 align-items-end">
            {{-- Qidiruv --}}
            <div class="col-md-5">
                <label for="searchInput">Qidiruv</label>
                <input type="text" id="searchInput" class="form-control" placeholder="Ism, Login...">
            </div>
            {{-- Status filter --}}
            <div class="col-md-5">
                <label for="statusFilter">Status bo‘yicha filter</label>
                <select id="statusFilter" class="form-select">
                    <option value="">Barchasi</option>
                    <option value="Faol">Faol</option>
                    <option value="Bloklangan">Bloklangan</option>
                    <option value="Kutilmoqda">Kutilmoqda</option>
                </select>
            </div>
            {{-- Tugmalar --}}
            <div class="col-md-2 d-flex gap-2">
                <button id="filterBtn" class="btn btn-primary w-50">
                    <i class="fas fa-filter"></i>{{__('admin.search')}}
                </button>

                <button id="clearBtn" class="btn btn-warning w-50">
                    {{__('admin.clear')}}
                </button>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="card shadow border-0 table-wrapper table-responsive">
        <div class="d-flex justify-content-between align-items-center p-3">
            <h5 class="mb-0">Investorlar</h5>
            <div class="d-flex gap-2">
                <button class="btn btn-success"><i class="fas fa-file-excel"></i> Excel</button>
                <button class="btn btn-info text-white"><i class="fas fa-file-csv"></i> CSV</button>
            </div>
        </div>

        <table class="table table-hover table-striped align-middle text-center">
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
            <tbody id="investorTable">
            <tr>
                <td>1</td>
                <td>Jasur Islomov <span class="label-verified">Tasdiqlangan</span></td>
                <td>jasur</td>
                <td>+998901234567</td>
                <td>AA1234567</td>
                <td>12345678901234</td>
                <td class="status-active">Faol</td>
                <td>2025-11-25 14:32</td>
                <td class="action-btns">
                    <i class="fas fa-eye text-primary me-2" title="Ko‘rish"></i>
                    <i class="fas fa-shield-alt text-danger" title="Bloklash"></i>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Gulbahor Qodirova <span class="label-unverified">Tasdiqlanmagan</span></td>
                <td>gulbahor</td>
                <td>+998909876543</td>
                <td>AB7654321</td>
                <td>98765432109876</td>
                <td class="status-pending">Kutilmoqda</td>
                <td>2025-11-26 09:15</td>
                <td class="action-btns">
                    <i class="fas fa-eye text-primary me-2" title="Ko‘rish"></i>
                    <i class="fas fa-shield-alt text-danger" title="Bloklash"></i>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Olimjon Tursunov <span class="label-verified">Tasdiqlangan</span></td>
                <td>olimjon</td>
                <td>+998933445566</td>
                <td>AC1122334</td>
                <td>11223344556677</td>
                <td class="status-active">Faol</td>
                <td>2025-11-27 08:50</td>
                <td class="action-btns">
                    <i class="fas fa-eye text-primary me-2" title="Ko‘rish"></i>
                    <i class="fas fa-shield-alt text-danger" title="Bloklash"></i>
                </td>
            </tr>
            <tr>
                <td>4</td>
                <td>Nilufar Rasulova <span class="label-unverified">Tasdiqlanmagan</span></td>
                <td>nilufar</td>
                <td>+998922334455</td>
                <td>AD5566778</td>
                <td>55667788901234</td>
                <td class="status-blocked">Bloklangan</td>
                <td>2025-11-24 18:20</td>
                <td class="action-btns">
                    <i class="fas fa-eye text-primary me-2" title="Ko‘rish"></i>
                    <i class="fas fa-shield-alt text-danger disabled-icon" title="Bloklash"></i>
                </td>
            </tr>
            <tr>
                <td>5</td>
                <td>Azizbek Karimov <span class="label-verified">Tasdiqlangan</span></td>
                <td>azizbek</td>
                <td>+998911223344</td>
                <td>AA9988776</td>
                <td>99887766554433</td>
                <td class="status-active">Faol</td>
                <td>2025-11-26 12:45</td>
                <td class="action-btns">
                    <i class="fas fa-eye text-primary me-2" title="Ko‘rish"></i>
                    <i class="fas fa-shield-alt text-danger" title="Bloklash"></i>
                </td>
            </tr>
            <tr>
                <td>6</td>
                <td>Saodat Davronova <span class="label-unverified">Tasdiqlanmagan</span></td>
                <td>saodat</td>
                <td>+998900112233</td>
                <td>AB4455667</td>
                <td>44556677889900</td>
                <td class="status-pending">Kutilmoqda</td>
                <td>2025-11-23 16:10</td>
                <td class="action-btns">
                    <i class="fas fa-eye text-primary me-2" title="Ko‘rish"></i>
                    <i class="fas fa-shield-alt text-danger" title="Bloklash"></i>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection

@push('customJs')
    <script>
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const table = document.getElementById('investorTable');
        const clearBtn = document.getElementById('clearBtn');

        function filterTable() {
            const query = searchInput.value.toLowerCase();
            const status = statusFilter.value;

            Array.from(table.rows).forEach(row => {
                const name = row.cells[1].innerText.toLowerCase();
                const login = row.cells[2].innerText.toLowerCase();
                const rowStatus = row.cells[6].innerText;

                const matchesQuery = name.includes(query) || login.includes(query);
                const matchesStatus = status === '' || rowStatus === status;

                row.style.display = (matchesQuery && matchesStatus) ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        statusFilter.addEventListener('change', filterTable);
        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            statusFilter.value = '';
            filterTable();
        });
    </script>
@endpush
