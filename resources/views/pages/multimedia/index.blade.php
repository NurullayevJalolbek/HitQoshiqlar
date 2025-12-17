@extends('layouts.app')

@push('customCss')
<style>
    /* ===============================
   MEDIA CARD – FINAL CLEAN VERSION
================================ */

    .media-card {
        position: relative;
        border-radius: 16px;
        background: #ffffff;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.06);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .media-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.12);
    }

    .media-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        display: block;
        transition: transform .35s ease;
    }

    .media-card:hover .media-img {
        transform: scale(1.05);
    }

    .media-card::before,
    .media-card::after {
        content: none !important;
    }

    .media-actions {
        position: absolute;
        top: 14px;
        right: 14px;
        display: flex;
        gap: 8px;
        z-index: 3;
        opacity: 1;
        transform: none;
    }

    .media-actions button,
    .media-actions .btn {
        border: none;
        box-shadow: none;
        background-clip: padding-box;
    }

    .media-actions a {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.18);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .media-actions a:hover {
        transform: scale(1.12);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.25);
    }

    .media-actions a i {
        pointer-events: none;
    }

    .media-card .p-3 {
        background: #ffffff;
    }

    .media-title {
        font-size: 15px;
        font-weight: 600;
        color: #212529;
    }

    .media-desc {
        font-size: 13px;
        color: #6c757d;
        line-height: 1.5;
        margin-top: 4px;
    }

    .media-badge {
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 600;
        border-radius: 20px;
        background: rgba(35, 97, 206, 0.12);
        color: #2361ce;
        letter-spacing: .4px;
        text-transform: uppercase;
    }

    @media (max-width: 768px) {
        .media-card:hover {
            transform: none;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
        }

        .media-card:hover .media-img {
            transform: none;
        }
    }

    /* Image preview styles */
    #imagePreview {
        max-width: 100%;
        border-radius: 8px;
        margin-top: 10px;
        display: none;
    }
</style>
@endpush

@section('breadcrumb')
<div
    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
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
                    Multimedia va vizual elementlar
            </ol>
        </nav>
    </div>

    <div class="d-flex gap-2 align-items-center flex-wrap">
        <a href="#" class="btn btn-primary btn-sm px-3 py-1" style="min-width: 90px;" onclick="openCreateModal()">
            <i class="fas fa-plus me-1" style="font-size: 0.85rem;"></i> {{ __('admin.create') }}
        </a>
    </div>
</div>
@endsection

@section('content')
@php
$datas = getMediaItems();
@endphp

<div class="card card-body shadow-sm mb-4 mt-3">
    <div class="section-title mb-3 d-flex align-items-center">
        <i class="fas fa-photo-video me-2"></i>
        Multimedia va vizual elementlar
    </div>

    <div class="row g-3">
        @foreach($datas as $media)
        <div class="col-md-4">
            <div class="media-card">
                <div class="media-actions">
                    <button class="btn btn-sm p-0" onclick="openEditModal({{ $media['id'] }})"
                        style="background:none; color: #f0bc74;">
                        <i class="fa-jelly-duo fa-solid fa-pencil"></i>
                    </button>
                    <x-delete-button />
                </div>

                <img src="{{ $media['image_url'] }}" class="media-img" alt="{{ $media['title'] }}">

                <div class="p-3">
                    <div class="d-flex justify-content-between mb-1">
                        <div class="media-title">{{ $media['title'] }}</div>
                        <span class="media-badge">{{ $media['type'] }}</span>
                    </div>
                    <div class="media-desc">
                        {{ $media['description'] }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="multimediaContent" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shablon Xabar Yaratish / Tahrirlash</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="multimediaModalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('customJs')
<script>
    let currentModal = null;

    function openCreateModal() {
        const modalBody = document.getElementById('multimediaModalBody');
        const modalTitle = document.querySelector('#multimediaContent .modal-title');

        modalTitle.textContent = 'Yangi Kontent Yaratish';

        modalBody.innerHTML = `
        <form id="contentForm">
            <div class="mb-3">
                <label class="form-label">Sarlavha <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" placeholder="Sarlavha kiriting..." required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tur <span class="text-danger">*</span></label>
                <select class="form-select" name="type" required>
                    <option value="">Tanlang</option>
                    <option value="AUTH">AUTH</option>
                    <option value="BANNER">BANNER</option>
                    <option value="LOGO">LOGO</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Tavsif</label>
                <textarea class="form-control" name="description" rows="3" placeholder="Tavsif kiriting..."></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Rasm</label>
                <input type="file" class="form-control" name="image" accept="image/*" id="imageInput">
                <small class="text-muted">JPG, PNG formatlari, maksimum 5MB</small>
                <img id="imagePreview" alt="Preview">
            </div>
            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <button type="button" class="btn btn-primary" onclick="saveContent()">Saqlash</button>
            </div>
        </form>
        `;

        // Image preview event
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '';
                imagePreview.style.display = 'none';
            }
        });

        if (currentModal) currentModal.hide();
        currentModal = new bootstrap.Modal(document.getElementById('multimediaContent'));
        currentModal.show();
    }



    function openEditModal(id) {
        const modalBody = document.getElementById('multimediaModalBody');
        const modalTitle = document.querySelector('#multimediaContent .modal-title');

        modalTitle.textContent = 'Multimedia Tahrirlash';
        modalBody.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Yuklanmoqda...</p></div>';

        const url = "{{ route('admin.user-interface.multimedia.edit', ':id') }}";

        axios.get(url, {
                params: {
                    id: id
                }
            })
            .then(response => {
                const data = response.data.data;

                console.log(data);
                modalBody.innerHTML = `
            <form id="contentForm">
                <div class="mb-3">
                    <label class="form-label">Sarlavha <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="title" value="${data.title}" placeholder="Sarlavha kiriting..." required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tur <span class="text-danger">*</span></label>
                    <select class="form-select" name="type" required>
                        <option value="">Tanlang</option>
                        <option value="AUTH" ${data.type === 'AUTH' ? 'selected' : ''}>AUTH</option>
                        <option value="BANNER" ${data.type === 'BANNER' ? 'selected' : ''}>BANNER</option>
                        <option value="LOGO" ${data.type === 'LOGO' ? 'selected' : ''}>LOGO</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tavsif</label>
                    <textarea class="form-control" name="description" rows="3" placeholder="Tavsif kiriting...">${data.description}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rasm</label>
                    <input type="file" class="form-control" name="image" accept="image/*" id="imageInput">
                    <small class="text-muted">JPG, PNG formatlari, maksimum 5MB</small>
                    <img id="imagePreview" src="${data.image_url}" style="display:block; max-width:100%; margin-top:10px; border-radius:8px;" alt="Preview">
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="button" class="btn btn-primary" onclick="saveContent(${data.id})">Saqlash</button>
                </div>
            </form>
            `;

                // Image preview o‘zgartirish uchun event
                const imageInput = document.getElementById('imageInput');
                const imagePreview = document.getElementById('imagePreview');

                imageInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    }
                });

                if (currentModal) currentModal.hide();
                currentModal = new bootstrap.Modal(document.getElementById('multimediaContent'));
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
                currentModal = new bootstrap.Modal(document.getElementById('multimediaContent'));
                currentModal.show();
            });
    }
</script>
@endpush