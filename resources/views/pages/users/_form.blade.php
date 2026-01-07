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

    .photo-preview {
        width: 220px;
        height: 240px;
        object-fit: cover;
        padding: 5px;
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    /* Input va selectlarni bir xil qiyofa qilish */
    .form-control,
    .form-select {
        border-radius: 0.25rem;
        border: 1px solid #ced4da;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }

    /* Placeholder 60% opacity */
    ::placeholder {
        opacity: 0.6 !important;
        color: #6c757d;
    }

    /* Input-group text style */
    .input-group-text {
        border-right: none;
        background-color: #fff;
    }

    .input-group .form-control,
    .input-group .form-select {
        border-left: none;
    }

    /* Focus effekti */
    .form-control:focus,
    .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        outline: none;
    }

    /* Input-group ichidagi ikonalar */
    .input-group-text i {
        color: #6c757d;
    }
</style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
    style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
    <!-- Breadcrumb -->
    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.users.index') }}">
                        {{ __('admin.users') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    @isset($user)
                    Foydalanuvchi tahrirlash
                    @else
                    Foydalanuvchi qo'shish
                    @endisset
                </li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2 align-items-center flex-wrap">

        <x-go-back />
    </div>
</div>
@endsection


@section('content')

@php
$roles = [
'Admin' => 'Admin',
'Moliyaviy auditor' => 'Moliyaviy auditor',
'Moderator' => 'Moderator',
'Islom moliyasi nazorati' => 'Islom moliyasi nazorati',
];

$statuses = [
'Faol' => 'Faol',
'Kutilmoqda' => 'Kutilmoqda',
'Bloklangan' => 'Bloklangan',
];
@endphp

<div class="row mt-3">
    <div class="col-12 col-xl-12">
        <div class="card card-body border-0 shadow mb-4">
            <h2 class="h5 mb-4">
                @isset($user) Foydalanuvchi tahrirlash @else Foydalanuvchi qo'shish @endisset
            </h2>

            <form method="POST" action="#" class="needs-validation" enctype="multipart/form-data" novalidate>
                @csrf
                @isset($user) @method('PUT') @endisset

                <div class="row">
                    {{-- Chap tomonda rasm --}}
                    <div class="col-md-3 text-center mb-3">
                        @php
                        $photo = isset($user) && !empty($user['photo'])
                        ? asset('storage/' . $user['photo'])
                        : asset('assets/img/default.jpg');
                        @endphp
                        <img id="photo-preview" src="{{ $photo }}" alt="Foto" class="photo-preview mb-3">
                        <input type="file" class="form-control form-control-sm" id="photo" name="photo"
                            onchange="previewImage(this)">
                    </div>

                    {{-- O'ng tomonda inputlar --}}
                    <div class="col-md-9">
                        <div class="row g-3">

                            <!-- F.I.O -->
                            <div class="col-md-6">
                                <label for="name" class="form-label required">F.I.O</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user['name'] ?? '') }}" required
                                        placeholder="F.I.O">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="col-md-6">
                                <label for="username" class="form-label required">Username (Login)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-image-portrait"></i></span>
                                    <input type="text" autocomplete="new-username" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username"
                                        value="{{ old('username', $user['username'] ?? '') }}" required
                                        placeholder="Login">
                                    @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label required">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user['email'] ?? '') }}"
                                        required placeholder="Email">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Telefon -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Telefon</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $user['phone'] ?? '') }}"
                                        placeholder="+998 ...">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Role -->
                            <x-select-with-search
                                name="roleFilter"
                                label="Role boyicha"
                                :datas="$roles"
                                colMd="6"
                                placeholder="Barchasi"
                                :selected="$user['role'] ?? ''"
                                icon="fa-user-shield" />



                            <x-select-with-search
                                name="statusFilter"
                                label="Holati boyicha"
                                :datas="$statuses"
                                colMd="6"
                                placeholder="Barchasi"
                                :selected="$user['status'] ?? ''" />


                            <!-- Parol -->
                            <div class="col-md-6">
                                <label for="password" class="form-label @if(!isset($user)) required @endif">Parol
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" autocomplete="new-password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" @if(!isset($user)) required @endif
                                        placeholder="Parol">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label @if(!isset($user)) required @endif">
                                    Parolni takrorlang
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input type="password" autocomplete="new-password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" @if(!isset($user)) required @endif
                                        placeholder="Parolni takrorlang">
                                </div>
                            </div>

                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-end mt-3 gap-2">
                            <!-- <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Bekor qilish
                            </a> -->

                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-save me-1"></i>
                                @isset($user) Yangilash @else Saqlash @endisset
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('customJs')
<script>
    // Oddiy frontend validatsiya
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()

    // Rasmni oldindan ko'rish
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('photo-preview').src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Update uchun parol validatsiyasini sozlash
    document.addEventListener('DOMContentLoaded', function() {
        @if(isset($user))
        // Update holatida parol maydonlarini majburiy emas qilish
        const passwordFields = ['password', 'password_confirmation'];
        passwordFields.forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                input.required = false;

                // Form submit bo'lishidan oldin tekshirish
                const form = input.closest('form');
                form.addEventListener('submit', function(e) {
                    const password = document.getElementById('password').value;
                    const passwordConfirmation = document.getElementById('password_confirmation').value;

                    // Agar bitta parol kiritilsa, ikkinchisi ham talab qilinadi
                    if (password && !passwordConfirmation) {
                        e.preventDefault();
                        alert('Parolni takrorlang maydonini ham to\'ldiring');
                        document.getElementById('password_confirmation').focus();
                    }
                    if (!password && passwordConfirmation) {
                        e.preventDefault();
                        alert('Parol maydonini ham to\'ldiring');
                        document.getElementById('password').focus();
                    }
                    if (password !== passwordConfirmation) {
                        e.preventDefault();
                        alert('Parollar mos kelmadi');
                        document.getElementById('password_confirmation').focus();
                    }
                });
            }
        });
        @endif
    });
</script>
@endpush