@extends('layouts.app')

@push('customCss')
    <style>
        /* Modal tepa rangini #1F2937 rangga o'zgartirish */
        .modal-header.custom-dark {
            background-color: #1F2937;
            color: #fff;
        }

        /* Actions ustunidagi dropdown menu uchun yuqori z-index (umid qilamizki stacking-context'tan tashqarida) */
        .dropdown-menu {
            z-index: 2000 !important; /* modal va boshqa elementlardan ustun turishi uchun */
        }

        .dropdown {
            position: static !important; /* stacking-contextdan chiqish uchun */
        }
    </style>
@endpush


@section('breadcrumb')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <!-- Breadcrumb -->
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.users') }}</li>
                </ol>
            </nav>
        </div>

        <!-- Tugmalar guruhi -->
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <!-- Yangi foydalanuvchi qo'shish -->
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm px-3 py-1" id="addUserBtn"
               style="min-width: 90px;">
                <i class="fas fa-plus me-1" style="font-size: 0.85rem;"></i> {{ __('admin.create') }}
            </a>


            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#roleFilterContent" aria-expanded="true"
                    aria-controls="roleFilterContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')

    {{-- Filter--}}
    <div class="filter-card mb-3 mt-2 collapse show" id="roleFilterContent" style="transition: all 0.3s ease;">
        <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
            <div class="row g-3 align-items-end">
                <div class="col-md-10">
                    <label>{{__('admin.search')}}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control"
                               placeholder="{{__('admin.role_name')}}, {{__('admin.code')}}...">
                    </div>
                </div>

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

    {{--Content--}}
    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table user-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
            <tr>
                <th class="border-bottom text-start">№</th>
                <th class="border-bottom text-center">{{__('admin.icon')}}</th>
                <th class="border-bottom text-start">{{__('admin.name')}}</th>
                <th class="border-bottom text-start">{{__('admin.code')}}</th>
                <th class="border-bottom text-center">{{__('admin.users_count')}}</th>
                <th class="border-bottom text-start">{{__('admin.description')}}</th>
                <th class="border-bottom">{{__('admin.actions')}}</th>
            </tr>
            </thead>
            <tbody>
            <tr class="hover-lift">
                <td class="text-start">
                    <div class="lift-inner">1</div>
                </td>
                <td class="text-center">
                    <div class="lift-inner"><i class="fas fa-shield-alt"></i></div>
                </td>
                <td class="text-start">
                    <div class="lift-inner">Admin</div>
                </td>
                <td class="text-start">
                    <div class="lift-inner">admin</div>
                </td>
                <td class="text-center">
                    <div class="lift-inner" data-users="0">0</div>
                </td>
                <td class="text-start">
                    <div class="lift-inner">Tizimni to‘liq boshqarish</div>
                </td>
                <td class="text-end">
                    <div class="action-buttons d-flex gap-2">
                        <!-- Ruxsatlar (kalit) -->
                        <a href="{{ route('admin.role-permissions.index') }}" class="btn btn-sm p-1 disabled"
                           style="background: none; border: none; color: #1F2937;">
                            <i class="fas fa-key"></i>
                        </a>

                        <!-- Tahrirlash (qalam) -->
                        <a href="#" class="btn btn-sm p-1" style="background: none; border: none; color: #f0bc74;">
                            <i class="bi bi-pencil-fill"></i> </a>

                        <!-- O‘chirish (savatcha) -->
                        <a href="#" class="btn btn-sm p-1 delete-role"
                           style="background: none; border: none; color: #DC2626;">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>


            </tr>
            <tr class="hover-lift">
                <td class="text-start">
                    <div class="lift-inner">2</div>
                </td>
                <td class="text-center">
                    <div class="lift-inner"><i class="fas fa-briefcase"></i></div>
                </td>
                <td class="text-start">
                    <div class="lift-inner">Moliyaviy auditor</div>
                </td>
                <td class="text-start">
                    <div class="lift-inner">finance</div>
                </td>
                <td class="text-center">
                    <div class="lift-inner" data-users="3">3</div>
                </td>
                <td class="text-start">
                    <div class="lift-inner">Moliyaviy ma’lumotlarni tekshirish</div>
                </td>
                <td class="text-end">
                    <div class="action-buttons d-flex gap-2">
                        <!-- Ruxsatlar (kalit) -->
                        <a href="{{ route('admin.role-permissions.index') }}" class="btn btn-sm p-1"
                           style="background: none; border: none; color: #1F2937;">
                            <i class="fas fa-key"></i>
                        </a>

                        <!-- Tahrirlash (qalam) -->
                        <a href="#" class="btn btn-sm p-1" style="background: none; border: none; color: #f0bc74;">
                            <i class="bi bi-pencil-fill"></i> </a>

                        <!-- O‘chirish (savatcha) -->
                        <a href="#" class="btn btn-sm p-1 delete-role"
                           style="background: none; border: none; color: #DC2626;">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>

            </tr>

            <tr class="hover-lift">
                <td class="text-start">
                    <div class="lift-inner">3</div>
                </td>
                <td class="text-center">
                    <div class="lift-inner"><i class="fas fa-cog"></i></div>
                </td>
                <td class="text-start">
                    <div class="lift-inner">Moderator</div>
                </td>
                <td class="text-start">
                    <div class="lift-inner">moderator</div>
                </td>
                <td class="text-center">
                    <div class="lift-inner" data-users="5">5</div>
                </td>
                <td class="text-start">
                    <div class="lift-inner">Kontent va foydalanuvchilarni nazorat qilish</div>
                </td>
                <td class="text-end">
                    <div class="action-buttons d-flex gap-2">
                        <!-- Ruxsatlar (kalit) -->
                        <a href="{{ route('admin.role-permissions.index') }}" class="btn btn-sm p-1"
                           style="background: none; border: none; color: #1F2937;">
                            <i class="fas fa-key"></i>
                        </a>

                        <!-- Tahrirlash (qalam) -->
                        <a href="#" class="btn btn-sm p-1" style="background: none; border: none; color: #f0bc74;">
                            <i class="bi bi-pencil-fill"></i> </a>

                        <!-- O‘chirish (savatcha) -->
                        <a href="#" class="btn btn-sm p-1 delete-role"
                           style="background: none; border: none; color: #DC2626;">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>

            </tr>


            <tr class="hover-lift">
                <td class="text-start">
                    <div class="lift-inner">4</div>
                </td>
                <td class="text-center">
                    <div class="lift-inner"><i class="fas fa-scroll"></i></div>
                </td>
                <td class="text-start">
                    <div class="lift-inner">Islom moliyasi nazorati</div>
                </td>
                <td class="text-start">
                    <div class="lift-inner">islamic_fin</div>
                </td>
                <td class="text-center">
                    <div class="lift-inner" data-users="1">1</div>
                </td>
                <td class="text-start">
                    <div class="lift-inner">Shariat asosida moliyaviy nazorat</div>
                </td>
                <td class="text-end">
                    <div class="action-buttons d-flex gap-2">
                        <!-- Ruxsatlar (kalit) -->
                        <a href="{{ route('admin.role-permissions.index') }}" class="btn btn-sm p-1"
                           style="background: none; border: none; color: #1F2937;">
                            <i class="fas fa-key"></i>
                        </a>

                        <!-- Tahrirlash (qalam) -->
                        <a href="#" class="btn btn-sm p-1" style="background: none; border: none; color: #f0bc74;">
                            <i class="bi bi-pencil-fill"></i> </a>

                        <!-- O‘chirish (savatcha) -->
                        <a href="#" class="btn btn-sm p-1 delete-role"
                           style="background: none; border: none; color: #DC2626;">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </td>

            </tr>

            </tbody>

        </table>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="warningModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header custom-dark">
                    <h5 class="modal-title" style="color: #fff;"><i class="fas fa-exclamation-triangle me-2"
                                                                    style="color: #fff;"></i> Ogohlantirish</h5>
                    <button type="button" class="btn-close" style="color: #fff;" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bu rolga foydalanuvchilar biriktirilgan. Avval ularni boshqa ro‘lga o‘tkazishingiz kerak.
                </div>
            </div>
        </div>
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
            initFilterToggle('roleToggleFilterBtn', 'roleFilterContent', 'roleFilterIcon', 'roleFilterText');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const table = document.querySelector('.user-table tbody');
            const rows = table.querySelectorAll('tr');

            // Qidiruv
            searchInput.addEventListener('input', function () {
                const filter = searchInput.value.toLowerCase();
                rows.forEach(row => {
                    // row ichidagi barcha textlarni tekshiramiz
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });

            // Tozalash
            const clearBtn = document.getElementById('clearBtn');
            clearBtn.addEventListener('click', function () {
                searchInput.value = '';
                rows.forEach(row => row.style.display = '');
            });

            // Role o'chirish
            const deleteButtons = document.querySelectorAll('.delete-role');
            let currentRow;
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    currentRow = this.closest('tr');
                    const userCountEl = currentRow.querySelector('[data-users]');
                    const userCount = userCountEl ? parseInt(userCountEl.dataset.users) : 0;
                    if (userCount > 0) {
                        const warningModal = new bootstrap.Modal(document.getElementById('warningModal'));
                        warningModal.show();
                    } else {
                        currentRow.remove();
                    }
                });
            });
        });
    </script>
@endpush
