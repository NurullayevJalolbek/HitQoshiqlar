@extends('layouts.app')

@push('customCss')
<style>
    /* Tab Navigation */
    .nav-tabs {
        border-bottom: 2px solid #e5e7eb;
        overflow-x: auto;
        white-space: nowrap;
        flex-wrap: nowrap;
        overflow-y: hidden;
    }

    .nav-tabs .nav-link {
        height: 40px;
        color: #1F2937;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
        background: #ebeaeaff;
        margin-right: 0.25rem;
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .nav-tabs .nav-link.active {
        color: #fff !important;
        background: #1F2937 !important;
        border-bottom: 3px solid #2a3441 !important;
        font-weight: 600;
    }

    /* Method Badges */
    .method-badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 0.375rem;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .method-get {
        background: #059669;
        color: #fff;
    }

    .method-post {
        background: #2563eb;
        color: #fff;
    }

    .method-put {
        background: #f59e0b;
        color: #fff;
    }

    .method-delete {
        background: #dc2626;
        color: #fff;
    }

    .method-default {
        background: #6b7280;
        color: #fff;
    }

    /* Toggle Switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: 0.3s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #2a3441;
    }

    input:checked+.slider:before {
        transform: translateX(26px);
    }


    .tab-content {
        background: #fff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-top: none;
        border-radius: 0 0 0.5rem 0.5rem;
        padding: 1rem;
        margin-top: -1px;
    }




    /* Table styling */
    .menu-table {
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .menu-table thead th {
        font-weight: 600;
        font-size: 0.95rem;
        border: none;
    }

    .menu-table tbody tr {
        vertical-align: middle;
    }

    .text-center-cell {
        text-align: center;
    }
</style>
@endpush


@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
    style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
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
                    Shablon Xabarlar
                </li>
            </ol>
        </nav>
    </div>

    <div class="d-flex gap-2 align-items-center flex-wrap">

        <!-- Yangi foydalanuvchi qo'shish -->
        <a href="#" class="btn btn-primary btn-sm px-3 py-1" onclick="openCreateModal()"
            style="min-width: 90px;">
            <i class="fas fa-plus me-1" style="font-size: 0.85rem;"></i> {{ __('admin.create') }}
        </a>

    </div>
</div>
@endsection

@section('content')
@php
$datas = getNotificationsData();

// Categories for dropdown
$categories = [
'sms' => 'SMS',
'email' => 'Email',
'push' => 'Push'
];
@endphp

<div class="card card-body shadow-sm mb-4 mt-3">
    <!-- Tabs -->
    <div class="collapse show" id="messageTabsContent">
        <ul class="nav nav-tabs" id="permissionTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active text-primary fw-semibold" id="sms-tab" data-bs-toggle="tab"
                    data-bs-target="#sms" type="button" role="tab">
                    <i class="fas fa-sms me-1"></i> SMS
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-primary fw-semibold" id="email-tab" data-bs-toggle="tab"
                    data-bs-target="#email" type="button" role="tab">
                    <i class="fas fa-envelope me-1"></i> Email
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-primary fw-semibold" id="push-tab" data-bs-toggle="tab"
                    data-bs-target="#push" type="button" role="tab">
                    <i class="fas fa-bell me-1"></i> Push
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- SMS Tab -->
            <div class="tab-pane fade show active" id="sms" role="tabpanel">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">ID</th>
                            <th>SMS turi</th>
                            <th style="max-width: 350px;">SMS shablon</th>
                            <th>Yuborilishi sharti</th>
                            <th>Izoh</th>
                            <th width="100">Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($datas->where('category', 'sms') as $item)
                        <tr>
                            <td>{{ $item['id'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td style="white-space: normal;">{{ $item['template'] }}</td>
                            <td>{{ $item['condition'] }}</td>
                            <td>{{ $item['description'] }}</td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <button class="btn btn-sm p-0" onclick="openEditModal({{ $item['id'] }})"
                                        style="background:none; color: #f0bc74;">
                                        <i class="fa-jelly-duo fa-solid fa-pencil"></i>
                                    </button>
                                    <x-delete-button />
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">SMS shablonlar yo'q</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Email Tab -->
            <div class="tab-pane fade" id="email" role="tabpanel">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">ID</th>
                            <th>Email turi</th>
                            <th style="max-width: 350px;">Email shablon</th>
                            <th>Yuborilishi sharti</th>
                            <th>Izoh</th>
                            <th width="100">Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($datas->where('category', 'email') as $item)
                        <tr>
                            <td>{{ $item['id'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td style="white-space: normal;">{!! nl2br(e($item['template'])) !!}</td>
                            <td>{{ $item['condition'] }}</td>
                            <td>{{ $item['description'] }}</td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <button class="btn btn-sm p-0" onclick="openEditModal({{ $item['id'] }})"
                                        style="background:none; color: #f0bc74;">
                                        <i class="fa-jelly-duo fa-solid fa-pencil"></i>
                                    </button>
                                    <x-delete-button />

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Email shablonlar yo'q</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Push Tab -->
            <div class="tab-pane fade" id="push" role="tabpanel">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">ID</th>
                            <th>Push turi</th>
                            <th style="max-width: 350px;">Push shablon</th>
                            <th>Yuborilishi sharti</th>
                            <th>Izoh</th>
                            <th width="100">Amallar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($datas->where('category', 'push') as $item)
                        <tr>
                            <td>{{ $item['id'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td style="white-space: normal;">{{ $item['template'] }}</td>
                            <td>{{ $item['condition'] }}</td>
                            <td>{{ $item['description'] }}</td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <button class="btn btn-sm p-0" onclick="openEditModal({{ $item['id'] }})"
                                        style="background:none; color: #f0bc74;">
                                        <i class="fa-jelly-duo fa-solid fa-pencil"></i>
                                    </button>
                                    <x-delete-button />

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Push shablonlar yo'q</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="templateMessageCreateOrUpdateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shablon Xabar Yaratish / Tahrirlash</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="templateMessageModalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('customJs')
<script>
    let currentModal = null;

    // Yangi shablon yaratish modali
    function openCreateModal() {
        const modalBody = document.getElementById('templateMessageModalBody');
        const modalTitle = document.querySelector('#templateMessageCreateOrUpdateModal .modal-title');

        modalTitle.textContent = 'Yangi Shablon Yaratish';

        modalBody.innerHTML = `
            <form id="templateMessageForm">
                <div class="mb-3">
                    <label class="form-label">Xabar turi <span class="text-danger">*</span></label>
                    <select class="form-select" name="category" required>
                        <option value="">Tanlang</option>
                        <option value="sms">SMS</option>
                        <option value="email">Email</option>
                        <option value="push">Push</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Shablon turi <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="type" placeholder="Masalan: Tasdiqlash xabari" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Shablon matni <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="template" rows="6" placeholder="Xabar matnini kiriting..." required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Yuborilishi sharti</label>
                    <input type="text" class="form-control" name="condition" placeholder="Masalan: Yangi buyurtma">
                </div>
                <div class="mb-3">
                    <label class="form-label">Izoh</label>
                    <textarea class="form-control" name="description" rows="2" placeholder="Qo'shimcha izoh..."></textarea>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="button" class="btn btn-primary" onclick="saveTemplate()">Saqlash</button>
                </div>
            </form>
        `;

        if (currentModal) {
            currentModal.hide();
        }
        currentModal = new bootstrap.Modal(document.getElementById('templateMessageCreateOrUpdateModal'));
        currentModal.show();
    }

    // Tahrirlash modali
    function openEditModal(id) {
        const modalBody = document.getElementById('templateMessageModalBody');
        const modalTitle = document.querySelector('#templateMessageCreateOrUpdateModal .modal-title');

        modalTitle.textContent = 'Shablonni Tahrirlash';
        modalBody.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Yuklanmoqda...</p></div>';

        const url = "{{ route('admin.user-interface.template-messages.edit', ':id') }}";

        axios.get(url, {
                params: {
                    id: id
                }
            }).then(response => {
                const data = response.data.data;
                console.log(data);

                // Kategoriya uchun tanlov variantlari
                let categoryOptions = '';
                const categories = [{
                        value: 'sms',
                        label: 'SMS'
                    },
                    {
                        value: 'email',
                        label: 'Email'
                    },
                    {
                        value: 'push',
                        label: 'Push'
                    }
                ];

                categories.forEach(cat => {
                    const selected = cat.value === data.category ? 'selected' : '';
                    categoryOptions += `<option value="${cat.value}" ${selected}>${cat.label}</option>`;
                });

                modalBody.innerHTML = `
                <form id="templateMessageForm">
                    <input type="hidden" name="id" value="${data.id}">
                    <div class="mb-3">
                        <label class="form-label">Xabar turi <span class="text-danger">*</span></label>
                        <select class="form-select" name="category" required ${data.id ? 'disabled' : ''}>
                            <option value="">Tanlang</option>
                            ${categoryOptions}
                        </select>
                        ${data.id ? '<small class="text-muted">Xabar turini o\'zgartirib bo\'lmaydi</small>' : ''}
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Shablon turi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="type" value="${data.type}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Shablon matni <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="template" rows="6" required>${data.template}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Yuborilishi sharti</label>
                        <input type="text" class="form-control" name="condition" value="${data.condition}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Izoh</label>
                        <textarea class="form-control" name="description" rows="2">${data.description}</textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                        <button type="button" class="btn btn-primary" onclick="saveTemplate()">Saqlash</button>
                    </div>
                </form>
            `;

                if (currentModal) {
                    currentModal.hide();
                }
                currentModal = new bootstrap.Modal(document.getElementById('templateMessageCreateOrUpdateModal'));
                currentModal.show();
            })
            .catch(error => {
                modalBody.innerHTML = `
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Xatolik yuz berdi: ${error.response?.data?.message || error.message}
                </div>
                <div class="text-center">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
                </div>
            `;

                if (currentModal) {
                    currentModal.hide();
                }
                currentModal = new bootstrap.Modal(document.getElementById('templateMessageCreateOrUpdateModal'));
                currentModal.show();
            });
    }

    // Shablonni saqlash
    function saveTemplate() {
        const form = document.getElementById('templateMessageForm');
        const formData = new FormData(form);
        const id = formData.get('id');

        // Agar edit bo'lsa, category select disabled bo'lganligi uchun qiymat qo'shamiz
        if (id) {
            const categorySelect = form.querySelector('[name="category"]');
            if (categorySelect.disabled) {
                // Eng yaqin kategoriya qiymatini olamiz
                const existingCategory = categorySelect.value;
                formData.set('category', existingCategory);
            }
        }

        const url = id ?
            "{{ route('admin.user-interface.template-messages.update', ':id') }}".replace(':id', id) :
            "{{ route('admin.user-interface.template-messages.store') }}";

        const method = id ? 'PUT' : 'POST';

        // Form validation
        if (!formData.get('category')) {
            alert('Xabar turi tanlanishi shart!');
            return;
        }

        if (!formData.get('type') || !formData.get('template')) {
            alert('Shablon turi va matni to\'ldirilishi shart!');
            return;
        }

        // Show loading
        const saveBtn = form.querySelector('.btn-primary');
        const originalText = saveBtn.innerHTML;
        saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saqlanmoqda...';
        saveBtn.disabled = true;

        axios({
                method: method,
                url: url,
                data: formData,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                // Show success message
                alert(response.data.message || 'Muvaffaqiyatli saqlandi!');

                // Close modal
                if (currentModal) {
                    currentModal.hide();
                }

                // Reload page or update specific tab content
                location.reload();
            })
            .catch(error => {
                saveBtn.innerHTML = originalText;
                saveBtn.disabled = false;

                let errorMessage = 'Xatolik yuz berdi';
                if (error.response?.data?.errors) {
                    errorMessage = Object.values(error.response.data.errors).flat().join('\n');
                } else if (error.response?.data?.message) {
                    errorMessage = error.response.data.message;
                }

                alert(errorMessage);
            });
    }

    // Initialize modal on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Bootstrap tab switching
        const tabEl = document.querySelector('button[data-bs-toggle="tab"]');
        if (tabEl) {
            tabEl.addEventListener('shown.bs.tab', function(event) {
                // Tab o'zgarganda kerak bo'lsa qo'shimcha amallar
            });
        }

        // Modal yopilganda
        const modal = document.getElementById('templateMessageCreateOrUpdateModal');
        if (modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                document.getElementById('templateMessageModalBody').innerHTML = '';
            });
        }
    });
</script>
@endpush