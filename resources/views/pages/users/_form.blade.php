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
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <!-- Breadcrumb -->
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
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
    </div>
@endsection

@section('content')
    <div class="row mt-3">
        <div class="col-12 col-xl-12">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">
                    @isset($user)
                        Foydalanuvchi tahrirlash
                    @else
                        Foydalanuvchi qo'shish
                    @endisset
                </h2>

                @isset($user)
                    <form method="POST" action="#" class="needs-validation" enctype="multipart/form-data" novalidate>
                        @method('PUT')
                @else
                        <form method="POST" action="#" class="needs-validation" enctype="multipart/form-data" novalidate>
                    @endisset

                        @csrf

                        <div class="row">
                            {{-- Chap tomonda rasm --}}
                            <div class="col-md-3 text-center mb-3">
                                @php
                                    // Agar modelda photo maydoni bo'lsa, shuni ishlating
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
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label required">F.I.O</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $user['name'] ?? '--') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="username" class="form-label required">Username (Login)</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            id="username" name="username"
                                            value="{{ old('username', $user['username'] ?? '') }}" required>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label required">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $user['email'] ?? '') }}"
                                            required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Telefon</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" name="phone" value="{{ old('phone', $user['phone'] ?? '') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="role" class="form-label required">Roli</label>
                                        <select id="role" class="form-select @error('role') is-invalid @enderror"
                                            name="role" required>
                                            <option value="">Tanlang</option>
                                            <option value="Admin" @selected(old('role', $user['role'] ?? '') == 'Admin')>Admin
                                            </option>
                                            <option value="Moliyaviy auditor" @selected(old('role', $user['rp;e'] ?? '') == 'Moliyaviy auditor')>Moliyaviy auditor</option>
                                            <option value="Moderator" @selected(old('role', $user['role'] ?? '') == 'Moderator')>Moderator</option>
                                            <option value="Islom moliyasi nazorati" @selected(old('role', $user['rp;e'] ?? '') == 'Islom moliyasi nazorati')>Islom moliyasi nazorati</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label required">Holati</label>
                                        <select id="status" class="form-select @error('status') is-invalid @enderror"
                                            name="status" required>
                                            <option value="">Tanlang</option>
                                            <option value="Faol" @selected(old('status', $user['status'] ?? '') == 'Faol')>
                                                Faol
                                            </option>
                                            <option value="Nofaol" @selected(old('status', $user['status'] ?? '') == 'Nofaol')>
                                                Nofaol</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Parol faqat yaratishda majburiy --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label @if(!isset($user)) required @endif">
                                            Parol
                                        </label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" @if(!isset($user)) required @endif>
                                        <!-- @if(isset($user))
                                                <small class="text-muted">Agar parolni o'zgartirmoqchi bo'lmasangiz, bo'sh
                                                    qoldiring</small>
                                            @endif -->
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation"
                                            class="form-label @if(!isset($user)) required @endif">
                                            Parolni takrorlang
                                        </label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" @if(!isset($user)) required @endif>
                                    </div>


                                </div>

                                <div class="d-flex justify-content-end mt-3 gap-2">
                                    <!-- Bekor qilish -->
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" type="reset">
                                        <i class="fas fa-times me-1"></i> Bekor qilish
                                    </a>

                                    <!-- Saqlash -->
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-save me-1"></i>
                                        @isset($user)
                                            Yangilash
                                        @else
                                            Saqlash
                                        @endisset
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
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
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

                reader.onload = function (e) {
                    document.getElementById('photo-preview').src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Update uchun parol validatsiyasini sozlash
        document.addEventListener('DOMContentLoaded', function () {
            @if(isset($user))
                // Update holatida parol maydonlarini majburiy emas qilish
                const passwordFields = ['password', 'password_confirmation'];
                passwordFields.forEach(field => {
                    const input = document.getElementById(field);
                    if (input) {
                        input.required = false;

                        // Form submit bo'lishidan oldin tekshirish
                        const form = input.closest('form');
                        form.addEventListener('submit', function (e) {
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