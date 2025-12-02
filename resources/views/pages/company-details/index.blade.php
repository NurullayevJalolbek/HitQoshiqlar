@extends('layouts.app')

@section('breadcrumb')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <!-- Breadcrumb -->
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.company_details') }}</li>
                </ol>
            </nav>
        </div>

        <!-- Tugmalar guruhi -->
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#companyDetailsFilterContent" aria-expanded="true"
                    aria-controls="companyDetailsFilterContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection


@section('content')
    {{--    Filter--}}
    <div class="filter-card mb-3 mt-2 collapse show" id="companyDetailsFilterContent"
         style="transition: all 0.3s ease;">
        <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
            <div class="row g-3 align-items-end">
                <!-- Qidiruv -->
                <div class="col-md-4">
                    <label for="searchInput">{{__('admin.search')}}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control"
                               placeholder="{{__('admin.full_name')}}, {{__('admin.login')}}, {{__('admin.email')}}...">
                    </div>
                </div>

                <!-- Holat bo‘yicha filter -->
                <!-- Faoliyat turi bo‘yicha filter -->
                <div class="col-md-3">
                    <label for="f_type" class="form-label">Faoliyat turi</label>
                    <select id="f_type" class="form-select">
                        <option value="">Tanlang</option>
                        <option value="МЧЖ">МЧЖ</option>
                        <option value="АЖ">АЖ</option>
                        <option value="ЯТТ">ЯТТ</option>
                    </select>
                </div>


                <!-- Filter tugmalari -->
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


    <!-- TABLE -->
    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table  table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
            <tr>
                <th >ID</th>
                <th >Корхона номи</th>
                <th >ИНН</th>
                <th >ИФУТ коди</th>
                <th >Фаолият тури</th>
                <th >Манзили</th>
                <th >Директор Ф.И.О.</th>
                <th >Телефон</th>
                <th >Эмайл</th>
                <th >Рўйхатдан ўтказилган сана</th>
                <th >Рўйхат рақами</th>
                <th >Рўйхатчи давлат органи</th>
                <th >Амаллар</th>
            </tr>
            </thead>
            <tbody id="company-table-body"></tbody>
        </table>
    </div>

    <!-- COMPANY MODAL -->
    <div id="companyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded p-6 w-11/12 max-w-4xl relative">
            <button onclick="closeCompanyModal()" class="absolute top-2 right-2 text-gray-600">&times;</button>
            <h2 class="text-xl font-bold mb-4" id="modal-title">Янги корхона қўшиш</h2>

            <form id="companyForm" class="grid grid-cols-2 gap-4">
                <input type="hidden" id="company_id">
                <div>
                    <label class="block font-semibold mb-1">Корхона тўлиқ номи</label>
                    <input type="text" id="company_name" class="border p-2 w-full rounded">
                </div>
                <div>
                    <label class="block font-semibold mb-1">ИНН</label>
                    <input type="text" id="company_inn" class="border p-2 w-full rounded">
                </div>
                <div>
                    <label class="block font-semibold mb-1">ИФУТ коди</label>
                    <input type="text" id="company_ifut" class="border p-2 w-full rounded">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Фаолият тури</label>
                    <select id="company_type" class="border p-2 w-full rounded">
                        <option value="МЧЖ">МЧЖ</option>
                        <option value="АЖ">АЖ</option>
                        <option value="ЯТТ">ЯТТ</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold mb-1">Манзили</label>
                    <input type="text" id="company_address" class="border p-2 w-full rounded">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Директор Ф.И.О.</label>
                    <input type="text" id="company_director" class="border p-2 w-full rounded">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Телефон</label>
                    <input type="text" id="company_phone" class="border p-2 w-full rounded">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Эмайл</label>
                    <input type="email" id="company_email" class="border p-2 w-full rounded">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Рўйхатдан ўтказилган сана</label>
                    <input type="date" id="company_register_date" class="border p-2 w-full rounded">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Рўйхат рақами</label>
                    <input type="text" id="company_register_number" class="border p-2 w-full rounded">
                </div>
                <div class="col-span-2">
                    <label class="block font-semibold mb-1">Рўйхатчи давлат органи</label>
                    <input type="text" id="company_register_authority" class="border p-2 w-full rounded">
                </div>

                <div class="col-span-2 flex justify-end mt-4">
                    <button type="button" onclick="saveCompany()" class="bg-blue-600 text-white p-2 rounded">Сақлаш
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Dummy data
            let companies = [
                {
                    id: 1,
                    name: "Коммандит A",
                    inn: "123456789",
                    ifut: "IFUT001",
                    type: "МЧЖ",
                    address: "Тошкент ш.",
                    director: "Олим Р.",
                    phone: "+998901234567",
                    email: "info@kommanditA.uz",
                    register_date: "2025-01-10",
                    register_number: "001",
                    register_authority: "Давлат органи A"
                },
                {
                    id: 2,
                    name: "Тўлиқ шерик B",
                    inn: "987654321",
                    ifut: "IFUT002",
                    type: "АЖ",
                    address: "Самарқанд ш.",
                    director: "Жасур И.",
                    phone: "+998912345678",
                    email: "info@fullB.uz",
                    register_date: "2024-12-05",
                    register_number: "002",
                    register_authority: "Давлат органи B"
                },
            ];

            const tableBody = document.getElementById("company-table-body");

            function renderTable(data = companies) {
                tableBody.innerHTML = data.map(item => `
            <tr class="border-b hover:bg-gray-50">
                <td class="p-2">${item.id}</td>
                <td class="p-2">${item.name}</td>
                <td class="p-2">${item.inn}</td>
                <td class="p-2">${item.ifut}</td>
                <td class="p-2">${item.type}</td>
                <td class="p-2">${item.address}</td>
                <td class="p-2">${item.director}</td>
                <td class="p-2">${item.phone}</td>
                <td class="p-2">${item.email}</td>
                <td class="p-2">${item.register_date}</td>
                <td class="p-2">${item.register_number}</td>
                <td class="p-2">${item.register_authority}</td>
                <td class="p-2">
                    <button onclick="editCompany(${item.id})" class="text-blue-600 underline mr-2">Таҳрирлаш</button>
                    <button onclick="deleteCompany(${item.id})" class="text-red-600 underline">Ўчириш</button>
                </td>
            </tr>
        `).join("");
            }

            // FILTER
            window.applyFilters = function () {
                const name = document.getElementById("f_company").value.toLowerCase();
                const type = document.getElementById("f_type").value;
                const filtered = companies.filter(c =>
                    (name ? c.name.toLowerCase().includes(name) : true) &&
                    (type ? c.type === type : true)
                );
                renderTable(filtered);
            }

            // MODAL
            const modal = document.getElementById("companyModal");
            window.openCompanyModal = function () {
                document.getElementById("modal-title").innerText = "Янги корхона қўшиш";
                document.getElementById("companyForm").reset();
                document.getElementById("company_id").value = "";
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            }
            window.closeCompanyModal = function () {
                modal.classList.add("hidden");
                modal.classList.remove("flex");
            }

            // SAVE / EDIT
            window.saveCompany = function () {
                const id = document.getElementById("company_id").value;
                const company = {
                    id: id || companies.length + 1,
                    name: document.getElementById("company_name").value,
                    inn: document.getElementById("company_inn").value,
                    ifut: document.getElementById("company_ifut").value,
                    type: document.getElementById("company_type").value,
                    address: document.getElementById("company_address").value,
                    director: document.getElementById("company_director").value,
                    phone: document.getElementById("company_phone").value,
                    email: document.getElementById("company_email").value,
                    register_date: document.getElementById("company_register_date").value,
                    register_number: document.getElementById("company_register_number").value,
                    register_authority: document.getElementById("company_register_authority").value
                };
                if (id) {
                    companies = companies.map(c => c.id == id ? company : c);
                } else {
                    companies.push(company);
                }
                renderTable();
                closeCompanyModal();
            }

            // EDIT
            window.editCompany = function (id) {
                const c = companies.find(x => x.id == id);
                document.getElementById("modal-title").innerText = "Корхонани таҳрирлаш";
                document.getElementById("company_id").value = c.id;
                document.getElementById("company_name").value = c.name;
                document.getElementById("company_inn").value = c.inn;
                document.getElementById("company_ifut").value = c.ifut;
                document.getElementById("company_type").value = c.type;
                document.getElementById("company_address").value = c.address;
                document.getElementById("company_director").value = c.director;
                document.getElementById("company_phone").value = c.phone;
                document.getElementById("company_email").value = c.email;
                document.getElementById("company_register_date").value = c.register_date;
                document.getElementById("company_register_number").value = c.register_number;
                document.getElementById("company_register_authority").value = c.register_authority;
                modal.classList.remove("hidden");
                modal.classList.add("flex");
            }

            // DELETE
            window.deleteCompany = function (id) {
                if (confirm("Ўчиришни тасдиқлайсизми?")) {
                    companies = companies.filter(c => c.id != id);
                    renderTable();
                }
            }

            renderTable();
        });
    </script>
@endsection
