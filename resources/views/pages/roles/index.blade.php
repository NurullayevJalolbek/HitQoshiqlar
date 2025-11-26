@extends('layouts.app')

@push('customCss')
    <style>
        /* Umumiy */
        .hover-lift {
            position: relative; /* hover effekti uchun kerak, lekin transform yo'q */
        }

        /* Ichki elementlar transform bo'ladi — bu holatda stacking-context tr ga qo'llanmaydi */
        .hover-lift .lift-inner {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.3s;
            will-change: transform;
            background-color: transparent;
            display: block;
        }

        /* Jadval konteyneri */
        .table-wrapper {
            overflow: hidden;
        }

        /* Modal tepa rangini #1F2937 rangga o'zgartirish */
        .modal-header.custom-dark {
            background-color: #1F2937;
            color: #fff;
        }

        /* Actions ustunidagi dropdown menu uchun yuqori z-index (umid qilamizki stacking-context'tan tashqarida) */
        .dropdown-menu {
            z-index: 1200;
        }

        /* Agar kerak bo'lsa, actions ustuni uchun hizalash */
        .text-end .dropdown {
            display: inline-block;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4 breadcrumb-block">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rollar</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    {{-- Filter--}}
    <div class="filter-card p-3 mb-3" style="border: 1px solid #fff; border-radius: 0.5rem; background-color: #fff;">
        <div class="row g-3 align-items-end">
            <div class="col-md-9">
                <label for="searchInput">Qidiruv</label>
                <input type="text" id="searchInput" class="form-control" placeholder="Role nomi, kod...">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button id="filterBtn" class="btn btn-primary w-50"><i class="fas fa-filter"></i> Filter</button>
                <button id="clearBtn" class="btn btn-warning w-50">Tozalash</button>
            </div>
        </div>
    </div>

    {{--Content--}}
    <div class="card card-body py-1 px-2 shadow border-0 table-wrapper table-responsive">
        <div class="d-flex justify-content-between align-items-center p-3">
            <h5 class="mb-0">Rollar</h5>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary" id="addProjectBtn">
                <i class="fas fa-plus"></i> Yangi role yaratish
            </a>
        </div>

        <table class="table user-table table-hover table-striped align-items-center">
            <thead class="table-dark">
            <tr>
                <th class="border-bottom text-start">№</th>
                <th class="border-bottom text-center">Ikonka</th>
                <th class="border-bottom text-start">Nomi</th>
                <th class="border-bottom text-start">Kodi</th>
                <th class="border-bottom text-center">Foydalanuvchilar soni</th>
                <th class="border-bottom text-start">Tavsifi</th>
                <th class="border-bottom text-end">Amallar</th>
            </tr>
            </thead>
            <tbody>
            {{-- Misol satrlar: har bir td ichida .lift-inner, actions td esa tashqarida --}}
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
                    {{-- Actions ustuni ichida .lift-inner bo'lmasa, dropdown transform tashqarisida qoladi --}}
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle delete-role-btn" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Tahrirlash</a></li>
                            <li><a class="dropdown-item delete-role" href="#"><i class="fas fa-trash me-2"></i>
                                    O‘chirish</a></li>
                        </ul>
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
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle delete-role-btn" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Tahrirlash</a></li>
                            <li><a class="dropdown-item delete-role" href="#"><i class="fas fa-trash me-2"></i>
                                    O‘chirish</a></li>
                        </ul>
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
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle delete-role-btn" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Tahrirlash</a></li>
                            <li><a class="dropdown-item delete-role" href="#"><i class="fas fa-trash me-2"></i>
                                    O‘chirish</a></li>
                        </ul>
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
                    <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle delete-role-btn" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Tahrirlash</a></li>
                            <li><a class="dropdown-item delete-role" href="#"><i class="fas fa-trash me-2"></i>
                                    O‘chirish</a></li>
                        </ul>
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
