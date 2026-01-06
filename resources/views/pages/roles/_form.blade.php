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

    /* Placeholder opacity 60% */
    ::placeholder {
        opacity: 0.6 !important;
    }

    .input-group-text i {
        width: 16px;
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
                    <a href="{{ route('admin.roles.index') }}">
                        {{ __('admin.roles') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    @isset($role)
                    Rolni tahrirlash
                    @else
                    Yangi rol yaratish
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
                @isset($role)
                Rolni tahrirlash
                @else
                Yangi rol yaratish
                @endisset
            </h2>

            <form method="POST"
                action="#"
                class="needs-validation"
                enctype="multipart/form-data"
                novalidate>

                @csrf
                @isset($role)
                @method('PUT')
                @endisset

                <div class="row g-3">
                    <!-- Role nomi -->
                    <div class="col-md-6">
                        <label for="roleName" class="form-label required">Rol nomi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                            <input type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                id="roleName"
                                name="name"
                                value="{{ old('name', $role['name'] ?? '') }}"
                                required
                                placeholder="Rol nomini kiriting">
                            <div class="invalid-feedback">Rol nomini kiriting.</div>
                        </div>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Role kodi -->
                    <div class="col-md-6">
                        <label for="roleCode" class="form-label required">Rol kodi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-code"></i></span>
                            <input type="text"
                                class="form-control @error('code') is-invalid @enderror"
                                id="roleCode"
                                name="code"
                                value="{{ old('code', $role['code'] ?? '') }}"
                                required
                                placeholder="Rol kodini kiriting"
                                @isset($role) readonly @endisset>
                            <div class="invalid-feedback">Rol kodini kiriting.</div>
                        </div>
                        @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Tavsifi -->
                <div class="mb-3">
                    <label for="roleDescription" class="form-label">Tavsifi</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                            id="roleDescription"
                            name="description"
                            rows="3"
                            placeholder="Rol tavsifini kiriting">{{ old('description', $role['description'] ?? '') }}</textarea>
                    </div>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Ikonka (fayl yuklash) -->
                <div class="mb-3">
                    <label class="form-label">Ikonka (png, jpg, jpeg, svg)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-image"></i></span>
                        <input type="file"
                            class="form-control @error('icon') is-invalid @enderror"
                            name="icon_file"
                            accept=".png,.jpg,.jpeg,.svg">
                    </div>
                    @error('icon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    @isset($role['icon'])
                    <div class="mt-2">
                        <span>Joriy ikonka:</span>
                        <img src="{{ asset('storage/' . $role['icon']) }}" alt="Icon" style="height:40px;">
                    </div>
                    @endisset
                </div>

                <div class="d-flex justify-content-end mt-3 gap-2">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Bekor qilish
                    </a>
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save me-1"></i>
                        @isset($role) Yangilash @else Saqlash @endisset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('customJs')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Form validatsiyasi
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });

        // Rol kodi avtomatik generatsiya
        const nameInput = document.getElementById('roleName');
        const codeInput = document.getElementById('roleCode');

        if (nameInput && codeInput && !codeInput.readOnly) {
            nameInput.addEventListener('blur', function() {
                if (!codeInput.value.trim()) {
                    const value = this.value.trim()
                        .toLowerCase()
                        .replace(/[^a-z0-9\s]/g, '')
                        .replace(/\s+/g, '_')
                        .replace(/_+/g, '_');
                    codeInput.value = value;
                }
            });
        }

        // Kod faqat kichik harflar, raqam va _
        if (codeInput) {
            codeInput.addEventListener('input', function() {
                this.value = this.value.toLowerCase().replace(/[^a-z0-9_]/g, '');
            });
        }
    });
</script>
@endpush