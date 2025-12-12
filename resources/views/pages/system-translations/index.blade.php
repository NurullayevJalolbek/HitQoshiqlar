@extends('layouts.app')

@push('customCss')
{{-- CSS Ko'dlari--}}
@endpush


@section('breadcrumb')
<div
    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
    style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
    <!-- Breadcrumb -->
    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.user-interface.index') }}">
                        {{ __('admin.user_interface') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Tillarni boshqarish
                </li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
{{-- 2. INTERFEYS TАRЖIMALARI --}}
@php
            $data = [];


            foreach ($languages as $lang) {

            $code = $lang->url;
            $file = base_path("lang/$code/admin.php");
            $data[$code] = file_exists($file) ? include $file : [];
            }


            $baseKeys = array_keys($data['uz'] ?? []);

            $pagination = manualPaginate($baseKeys, 10);


            $paginatedUsers = $pagination['items'];


            $currentPage = $pagination['currentPage'];
            $pageCount = $pagination['pageCount'];

            $start = $pagination['start'];
            $total = $pagination['total'];
            $end = $pagination['end'];






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


<div class="card card-body shadow-sm mb-4 mt-3">
    <!-- Sarlavha va toggle tugma -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="section-title d-flex align-items-center">
            <i class="fas fa-globe me-1"></i> Interfeys matnlarini tarjima qilish
        </div>
    </div>


    <!-- Jadval collapse ichida -->


    <div class="collapse show" id="interfaceTextTableContent">
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

        <!-- Paginatsa -->
        <div class="d-flex justify-content-between align-items-center mt-2">

            <div class="text-muted">
                {{ $start }} - {{ $end }} / Jami: {{ $total }}
            </div>

            <div>
                <x-pagination :pageCount="$pageCount" :currentPage="$currentPage" />
            </div>
        </div>

    </div>
</div>
@endsection
@push('customJs')
{{-- Tizim tillari uchun paginatsa--}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
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
        window.goPage = function(page) {
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