@extends('layouts.app')

@push('customCss')
    <style>
        .section-title {
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4 breadcrumb-block">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('admin.user_interface') }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')

    {{-- 1. TILLARNI BOSHQARISH --}}
    <div class="card card-body shadow-sm mb-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="section-title">
                <i class="fas fa-language me-1"></i> Tillarni boshqarish
            </div>

            <div class="d-flex gap-4">
                <button class="btn btn-primary btn-sm">
                    {{__('admin.create')}}
                </button>

                <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
                        type="button" data-bs-toggle="collapse"
                        data-bs-target="#languageManagementTableContent" aria-expanded="true"
                        aria-controls="languageManagementTableContent">
                    <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
                </button>
            </div>
        </div>

        <div class="collapse hidden" id="languageManagementTableContent">
            <table class="table language-table table-bordered table-hover table-striped align-items-center">
                <thead class="table-dark">
                <tr>
                    <th style="width:50px;">#</th>
                    <th>Til nomi</th>
                    <th style="width:90px;">Kodi</th>
                    <th style="width:120px;">Holati</th>
                    <th style="width:120px;">Asosiy til</th>
                    <th style="width:120px;" class="text-center">Amallar</th>
                </tr>
                </thead>

                <tbody>
                {{-- 1. Uzbek --}}
                <tr>
                    <td>1</td>
                    <td>O‘zbek</td>
                    <td>uz</td>
                    <td><span class="badge bg-success">Faol</span></td>
                    <td><span class="badge bg-primary">Default</span></td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <a href="#" class="btn btn-sm p-1 delete-role" style="background:none;color:#DC2626;">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>

                {{-- 2. Russian --}}
                <tr>
                    <td>2</td>
                    <td>Русский</td>
                    <td>ru</td>
                    <td><span class="badge bg-success">Faol</span></td>
                    <td>—</td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <a href="#" class="btn btn-sm p-1 delete-role" style="background:none;color:#DC2626;">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>


                {{-- 3. English --}}
                <tr>
                    <td>3</td>
                    <td>English</td>
                    <td>en</td>
                    <td><span class="badge bg-secondary">NoFaol</span></td>
                    <td>—</td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <a href="#" class="btn btn-sm p-1 delete-role" style="background:none;color:#DC2626;">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>

                {{-- 4. Arabic --}}
                <tr>
                    <td>4</td>
                    <td>العربية</td>
                    <td>ar</td>
                    <td><span class="badge bg-secondary">NoFaol</span></td>
                    <td>—</td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                        <a href="#" class="btn btn-sm p-1 delete-role" style="background:none;color:#DC2626;">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>



    {{-- 2. INTERFEYS TАRЖIMALARI --}}
    @php
        $data = [];


        foreach ($languages as $lang) {

            $code = $lang->url;
            $file = base_path("lang/$code/admin.php");
            $data[$code] = file_exists($file) ? include $file : [];
        }
        $baseKeys = array_keys($data['uz'] ?? []);








         function renderValue($value, $prefix = '')
            {
                // Agar array bo‘lsa — har bir elementni alohida ko‘rsatamiz
                if (is_array($value)) {
                    $html = '';
                    foreach ($value as $k => $v) {
                        $html .= renderValue($v, $prefix . $k . '. ');
                    }
                    return $html;
                }

                // Agar string bo‘lsa — to‘g‘ridan-to‘g‘ri chiqaramiz
                return "<div>{$prefix}{$value}</div>";
            }
    @endphp


    <div class="card card-body shadow-sm mb-4">
        <!-- Sarlavha va toggle tugma -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="section-title d-flex align-items-center">
                <i class="fas fa-globe me-1"></i> Interfeys matnlarini tarjima qilish
            </div>

            <!-- Toggle tugma icon bilan -->
            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#interfaceTextTableContent" aria-expanded="true"
                    aria-controls="interfaceTextTableContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
        </div>


            <!-- Jadval collapse ichida -->


        <div class="collapse hidden" id="interfaceTextTableContent">
            <table class="table user-table table-bordered table-hover table-striped align-items-center"
                   id="interfaceTable">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Kalit</th>
                    <th>UZ</th>
                    <th>RU</th>
                    <th>EN</th>
                    <th>AR</th>
                    <th class="text-center">Amallar</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($baseKeys as $index => $key)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                        <span class="badge rounded-pill text-white" style="background-color: #1F2937;">
                            {{ $key }}
                        </span>
                        </td>
                        <td>{!! renderValue($data['uz'][$key] ?? '') !!}</td>
                        <td>{!! renderValue($data['ru'][$key] ?? '') !!}</td>
                        <td>{!! renderValue($data['en'][$key] ?? '') !!}</td>
                        <td>{!! renderValue($data['ar'][$key] ?? '') !!}</td>

                        <td class="text-center">
                            <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-start p-2">
                <nav>
                    <ul class="pagination pagination-sm mb-0" id="paginationNumbers">
                        {{-- JS orqali yaratiladi --}}
                    </ul>
                </nav>
            </div>

        </div>
    </div>






    {{-- 3. STATIK SAHIFALAR --}}
    <div class="card card-body shadow-sm mb-4">
        <div class="section-title"><i class="fas fa-file-alt me-1"></i> Statik sahifalar</div>

        <table class="table table-hover">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Sahifa</th>
                <th>UZ</th>
                <th>RU</th>
                <th>EN</th>
                <th>Amallar</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Biz haqimizda</td>
                <td>✔️</td>
                <td>✔️</td>
                <td>✖️</td>
                <td>
                    <button class="btn btn-sm btn-warning">Tahrirlash</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Aloqa</td>
                <td>✔️</td>
                <td>✔️</td>
                <td>✔️</td>
                <td>
                    <button class="btn btn-sm btn-warning">Tahrirlash</button>
                </td>
            </tr>
            </tbody>
        </table>

        <button class="btn btn-primary w-25">+ Yangi sahifa</button>
    </div>


    {{-- 4. MEDIA — LOGO, BANNER --}}
    <div class="card card-body shadow-sm mb-4">
        <div class="section-title"><i class="fas fa-image me-1"></i> Media fayllar</div>


        <table class="table table-bordered">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Fayl turi</th>
                <th>Hozirgi fayl</th>
                <th>Amallar</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Logo</td>
                <td><img src="/logo.png" width="80" alt=""></td>
                <td>
                    <button class="btn btn-sm btn-warning">O‘zgartirish</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Asosiy banner</td>
                <td><img src="/banner.jpg" width="120" alt=""></td>
                <td>
                    <button class="btn btn-sm btn-warning">O‘zgartirish</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>


    {{-- 5. SHABLON XABARLAR --}}
    <div class="card card-body shadow-sm mb-4">
        <div class="section-title"><i class="fas fa-envelope me-1"></i> Shablon xabarlar matni</div>

        <table class="table table-striped">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Xabar turi</th>
                <th>UZ</th>
                <th>RU</th>
                <th>EN</th>
                <th>Amallar</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>1</td>
                <td>SMS – Tasdiqlash kodi</td>
                <td>✔️</td>
                <td>✔️</td>
                <td>✔️</td>
                <td>
                    <button class="btn btn-sm btn-warning">Tahrirlash</button>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td>Email – Ro‘yxatdan o‘tish</td>
                <td>✔️</td>
                <td>✔️</td>
                <td>✖️</td>
                <td>
                    <button class="btn btn-sm btn-warning">Tahrirlash</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection
@push('customJs')
    {{--    Tizim tillari uchun paginatsa--}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const rowsPerPage = 10;
            const table = document.getElementById("interfaceTable");
            const tbody = table.querySelector("tbody");
            const rows = tbody.querySelectorAll("tr");

            let currentPage = 1;
            const totalRows = rows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);

            const paginationNumbers = document.getElementById("paginationNumbers");


            /* ====================
               SAHIFANI KO'RSATISH
            ==================== */
            function showPage(page) {
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                rows.forEach((row, index) => {
                    row.style.display = (index >= start && index < end) ? "" : "none";
                });

                renderPagination();
            }


            /* ============================
               PAGINATION RAQAMLARINI CHIZISH
            ============================ */
            function renderPagination() {
                paginationNumbers.innerHTML = "";

                // OLDINGI
                paginationNumbers.innerHTML += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" style="cursor:pointer;" onclick="goPage(${currentPage - 1})">«</a>
            </li>
        `;

                // RAQAMLAR
                for (let i = 1; i <= totalPages; i++) {
                    paginationNumbers.innerHTML += `
                <li class="page-item ${currentPage === i ? 'active' : ''}">
                    <a class="page-link" style="cursor:pointer;" onclick="goPage(${i})">${i}</a>
                </li>
            `;
                }

                // KEYINGI
                paginationNumbers.innerHTML += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" style="cursor:pointer;" onclick="goPage(${currentPage + 1})">»</a>
            </li>
        `;
            }


            /* ============================
               GLOBAL FUNKSIYA
               (onclick uchun kerak)
            ============================ */
            window.goPage = function (page) {
                if (page >= 1 && page <= totalPages) {
                    currentPage = page;
                    showPage(currentPage);
                }
            }


            // INITIAL
            showPage(currentPage);
        });
    </script>

@endpush



