@extends('layouts.app')

@push('customCss')
    <style>
        /* Kartochka */
        .permissions-card {
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            background-color: #fff;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.08);
            transition: transform .2s, box-shadow .2s;
        }

        .permissions-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.12);
        }

        /* Accordion */
        .accordion-header {
            cursor: pointer;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .5rem 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 1.07rem;
        }

        .accordion-header i {
            color: #4a90e2;
        }

        .accordion-content {
            display: none;
            padding-top: .5rem;
        }

        /* Ruxsat itemlari */
        .permission-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .5rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .permission-item:hover {
            background: #f7f9fc;
        }

        /* Filtering */
        .filter-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: .5rem;
            padding: 1rem;
        }

        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #4a90e2;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between align-items-center py-4 breadcrumb-block">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active">{{__('admin.permissions')}}</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')

    {{-- 🔥 Rol tanlash qismi --}}
    <div class="filter-card mb-3">
        <label for="roleSelect" class="fw-bold mb-1">{{__('admin.select_role')}}</label>
        <select id="roleSelect" class="form-control">
            <option value="">— {{__('admin.select_role')}} —</option>
            <option value="admin">Admin</option>
            <option value="finance">Moliyaviy auditor</option>
            <option value="moderator">Moderator</option>
            <option value="islamic_fin">Islom moliyasi nazorati</option>
        </select>
    </div>

    {{-- 🔎 Qidiruv --}}
    <div class="filter-card p-3 mb-3" style="border: 1px solid #fff; border-radius: 0.5rem; background-color: #fff;">
        <div class="row g-3 align-items-end">
            <div class="col-md-9">
                <label for="searchInput">{{__('admin.search')}}</label>
                <input type="text" id="searchInput" class="form-control" placeholder="{{__('admin.permission_name')}} , {{__('admin.module')}}...">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button id="filterBtn" class="btn btn-primary w-50"><i class="fas fa-filter"></i>{{__('admin.search')}}</button>
                <button id="clearBtn" class="btn btn-warning w-50">{{__('admin.clear')}}</button>
            </div>
        </div>
    </div>

    {{-- 🔥 Ruxsatlar kartochkalari --}}
    <div class="permissions-card">
        <div class="accordion-header" onclick="toggleAccordion(this)">
            <span><i class="fas fa-users me-2"></i>Foydalanuvchilarni boshqarish</span>

            <div class="d-flex align-items-center gap-2">
                <label class="m-0 small" style="font-size: 0.85rem;">{{__('admin.select_all')}}</label>
                <input type="checkbox" class="select-all" data-target="users">
                <i class="fas fa-chevron-down ms-3"></i>
            </div>
        </div>

        <div class="accordion-content">
            <div class="permission-item">
                <span><i class="fas fa-user-plus me-2"></i>Foydalanuvchi qo‘shish</span>
                <input type="checkbox" class="users">
            </div>
            <div class="permission-item">
                <span><i class="fas fa-user-times me-2"></i>Foydalanuvchini o‘chirish</span>
                <input type="checkbox" class="users">
            </div>
            <div class="permission-item">
                <span><i class="fas fa-user-edit me-2"></i>Foydalanuvchini tahrirlash</span>
                <input type="checkbox" class="users">
            </div>
        </div>
    </div>


    <div class="permissions-card">
        <div class="accordion-header" onclick="toggleAccordion(this)">
            <span><i class="fas fa-project-diagram me-2"></i>Loyihalar</span>

            <div class="d-flex align-items-center gap-2">
                <label class="m-0 small">{{__('admin.select_all')}}</label>
                <input type="checkbox" class="select-all" data-target="projects">
                <i class="fas fa-chevron-down ms-3"></i>
            </div>
        </div>

        <div class="accordion-content">
            <div class="permission-item">
                <span><i class="fas fa-plus-square me-2"></i>Loyiha qo‘shish</span>
                <input type="checkbox" class="projects">
            </div>
            <div class="permission-item">
                <span><i class="fas fa-edit me-2"></i>Loyiha ma'lumotlarini o‘zgartirish</span>
                <input type="checkbox" class="projects">
            </div>
            <div class="permission-item">
                <span><i class="fas fa-trash-alt me-2"></i>Loyihani o‘chirish</span>
                <input type="checkbox" class="projects">
            </div>
        </div>
    </div>


    <div class="permissions-card">
        <div class="accordion-header" onclick="toggleAccordion(this)">
            <span><i class="fas fa-file-alt me-2"></i>Hisobotlar</span>

            <div class="d-flex align-items-center gap-2">
                <label class="m-0 small">{{__('admin.select_all')}}</label>
                <input type="checkbox" class="select-all" data-target="reports">
                <i class="fas fa-chevron-down ms-3"></i>
            </div>
        </div>

        <div class="accordion-content">
            <div class="permission-item">
                <span><i class="fas fa-eye me-2"></i>Hisobotlarni ko‘rish</span>
                <input type="checkbox" class="reports">
            </div>
            <div class="permission-item">
                <span><i class="fas fa-download me-2"></i>Hisobotni yuklab olish</span>
                <input type="checkbox" class="reports">
            </div>
        </div>
    </div>


    <div class="text-end mt-3">
        <button class="btn btn-success"><i class="fas fa-save me-2"></i>{{__('admin.save')}}</button>
    </div>

@endsection

@push('customJs')
    <script>
        // Accordion
        function toggleAccordion(header) {
            const content = header.nextElementSibling;
            const icon = header.querySelector('.fa-chevron-down, .fa-chevron-up');

            if (content.style.display === "block") {
                content.style.display = "none";
                icon.classList.add('fa-chevron-down');
                icon.classList.remove('fa-chevron-up');
            } else {
                content.style.display = "block";
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        }

        // Qidiruv
        document.getElementById('searchInput').addEventListener('input', function () {
            let keyword = this.value.toLowerCase();
            document.querySelectorAll('.permissions-card').forEach(card => {
                let text = card.innerText.toLowerCase();
                card.style.display = text.includes(keyword) ? 'block' : 'none';
            });
        });

        // Tozalash
        document.getElementById('clearBtn').addEventListener('click', () => {
            document.getElementById('searchInput').value = '';
            document.querySelectorAll('.permissions-card').forEach(card => card.style.display = 'block');
        });



        // "Barcasini belgilash" funksiyasi
        document.querySelectorAll('.select-all').forEach(master => {
            master.addEventListener('change', function () {
                let targetClass = this.dataset.target;
                let items = document.querySelectorAll('.' + targetClass);

                items.forEach(ch => ch.checked = master.checked);
            });
        });

    </script>
@endpush
