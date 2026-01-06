@extends('layouts.app')

@push('customCss')
<style>
    .form-label {
        font-weight: 500;
    }

    .required:after {
        content: " *";
        color: red;
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
                    <a href="{{ route('admin.user-interface.language-management.index') }}">
                        {{ __('admin.user_interface') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    @isset($model)
                    Tilni tahrirlash
                    @else
                    Yangi til yaratish
                    @endisset
                </li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <x-go-back url="{{ $go_back }}" />
    </div>
</div>
@endsection

@section('content')
<div class="row mt-3">
    <div class="col-12 col-xl-12">
        <div class="card card-body border-0 shadow mb-4">
            <h2 class="h5 mb-4">
                @isset($model)
                Tilni tahrirlash
                @else
                Yangi til yaratish
                @endisset
            </h2>

            <form method="POST"
                action="{{ isset($model) ? route('admin.user-interface.language-management.update', $model['id']) : route('admin.user-interface.language-management.store') }}"
                class="needs-validation"
                enctype="multipart/form-data"
                novalidate>

                @csrf
                @isset($model)
                @method('PUT')
                @endisset

                <!-- Til nomi -->
                <div class="mb-3">
                    <label class="form-label required" for="name">Til nomi</label>
                    <input type="text"
                        name="name"
                        id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $model['name'] ?? '') }}"
                        required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Til kodi -->
                <div class="mb-3">
                    <label class="form-label required" for="code">Til kodi</label>
                    <input type="text"
                        name="code"
                        id="code"
                        class="form-control @error('code') is-invalid @enderror"
                        value="{{ old('code', $model['code'] ?? '') }}"
                        required>
                    @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Aktivligi -->
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input"
                            type="checkbox"
                            name="is_active"
                            id="is_active"
                            value="1"
                            {{ old('is_active', $model['is_active'] ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Faol</label>
                    </div>
                </div>


                <!-- Default tili -->
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input set-default-language"
                            type="checkbox"
                            onchange="setDefaultLanguage(this)"
                            data-id="{{ $model['id'] ?? 0 }}"
                            {{ isset($model) && $model['is_default'] ? 'checked disabled' : '' }}>
                        <label class="form-check-label">Asosiy til</label>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3 gap-2">
                    <!-- <a href="{{ route('admin.user-interface.language-management.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Bekor qilish
                    </a> -->

                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save me-1"></i>
                        @isset($user) Yangilash @else Saqlash @endisset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('customJs')
<script>
    window.setDefaultLanguage = function(checkbox) {
        if (!checkbox.checked) return; // o‘chirishga ruxsat bermaymiz
        Swal.fire({
            title: "Default tilni o‘zgartirish",
            text: "Haqiqatan ham ushbu tilni default qilmoqchimisiz?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Tasdiqlash",
            cancelButtonText: "Bekor qilish",
            customClass: {
                confirmButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-secondary',
            },
            buttonsStyling: false
        }).then((result) => {
            if (!result.isConfirmed) {
                checkbox.checked = false;
            } else {
                // AJAX orqali backendga yuborish mumkin
                console.log('Default til ID:', checkbox.dataset.id);
            }
        });
    };
</script>
@endpush