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
                    + Yangi til qo‘shish
                </button>

                <button class="btn btn-sm rounded-pill px-3 py-2 d-flex align-items-center justify-content-center"
                        type="button" data-bs-toggle="collapse"
                        data-bs-target="#languageManagementTableContent" aria-expanded="true"
                        aria-controls="languageManagementTableContent" id="languageManagementTableBtn"
                        style="background-color: #1F2937; color: #ffffff;">
                    <i class="bi bi-caret-down-fill me-2" id="languageManagementTableIcon" style="color: #ffffff;"> </i>
                    <span id="languageManagementTableText">Yopish</span>
                </button>
            </div>
        </div>

        <div class="collapse hidden" id="languageManagementTableContent">
            <table class="table table-bordered">
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
    <div class="card card-body shadow-sm mb-4">
        <!-- Sarlavha va toggle tugma -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="section-title d-flex align-items-center">
                <i class="fas fa-globe me-1"></i> Interfeys matnlarini tarjima qilish
            </div>

            <!-- Toggle tugma icon bilan -->
            <button class="btn btn-sm rounded-pill px-3 py-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#interfaceTextTableContent" aria-expanded="true"
                    aria-controls="interfaceTextTableContent" id="interfaceTextTableBtn"
                    style="background-color: #1F2937; color: #ffffff;">
                <i class="bi bi-caret-down-fill me-2" id="languageManagementTableIcon" style="color: #ffffff;"> </i>
                <span id="languageManagementTableText">Yopish</span>
            </button>
        </div>


        <!-- Jadval collapse ichida -->
        <div class="collapse hidden " id="interfaceTextTableContent">
            <table class="table table-striped">
                <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Kalit</th>
                    <th>UZ</th>
                    <th>RU</th>
                    <th>EN</th>
                    <th class="text-center">Amallar</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>login_button</td>
                    <td>Kirish</td>
                    <td>Войти</td>
                    <td>Login</td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>register_button</td>
                    <td>Ro‘yxatdan o‘tish</td>
                    <td>Регистрация</td>
                    <td>Register</td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>logout_button</td>
                    <td>Chiqish</td>
                    <td>Выйти</td>
                    <td>Logout</td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>dashboard_title</td>
                    <td>Boshqaruv paneli</td>
                    <td>Панель управления</td>
                    <td>Dashboard</td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>save_button</td>
                    <td>Saqlash</td>
                    <td>Сохранить</td>
                    <td>Save</td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>cancel_button</td>
                    <td>Bekor qilish</td>
                    <td>Отмена</td>
                    <td>Cancel</td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>delete_button</td>
                    <td>O‘chirish</td>
                    <td>Удалить</td>
                    <td>Delete</td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">


                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>edit_button</td>
                    <td>Tahrirlash</td>
                    <td>Редактировать</td>
                    <td>Edit</td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>search_placeholder</td>
                    <td>Izlash...</td>
                    <td>Поиск...</td>
                    <td>Search...</td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>notification_label</td>
                    <td>Bildirishnomalar</td>
                    <td>Уведомления</td>
                    <td>Notifications</td>
                    <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Iconni rotate qilish uchun kichik JS -->
    <script>
        const collapseElement = document.getElementById('translationTable');
        const toggleIcon = document.getElementById('toggleIcon');

        collapseElement.addEventListener('shown.bs.collapse', () => {
            toggleIcon.classList.remove('bi-chevron-down');
            toggleIcon.classList.add('bi-chevron-up');
        });

        collapseElement.addEventListener('hidden.bs.collapse', () => {
            toggleIcon.classList.remove('bi-chevron-up');
            toggleIcon.classList.add('bi-chevron-down');
        });
    </script>





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
            initFilterToggle('languageManagementTableBtn', 'languageManagementTableContent', 'languageManagementTableIcon', 'languageManagementTableText')
        });
    </script>
@endpush



