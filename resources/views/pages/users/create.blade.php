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
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4 breadcrumb-block">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#"><i class="fas fa-home"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Foydalanuvchilar</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Foydalanuvchi qo‘shish</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-xl-12">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">Foydalanuvchi qo‘shish</h2>

                <form method="POST" action="#" class="needs-validation" enctype="multipart/form-data" novalidate>
                    <div class="row">

                        {{-- Chap tomonda rasm --}}
                        <div class="col-md-3 text-center mb-3">
                            @php
                                $photo = asset('assets/img/default.jpg'); // Default rasm
                            @endphp
                            <img id="photo-preview" src="{{ $photo }}" alt="Foto" class="photo-preview mb-3">
                            <input type="file" class="form-control form-control-sm" id="photo" name="photo">
                        </div>

                        {{-- O'ng tomonda inputlar --}}
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fullName" class="form-label required">F.I.O</label>
                                    <input type="text" class="form-control" id="fullName" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label required">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="login" class="form-label required">Login</label>
                                    <input type="text" class="form-control" id="login" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Telefon</label>
                                    <input type="text" class="form-control" id="phone">
                                </div>

                                {{-- Parol --}}
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label required">Parol</label>
                                    <input type="password" class="form-control" id="password" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label required">Parolni
                                        takrorlang</label>
                                    <input type="password" class="form-control" id="password_confirmation" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="role" class="form-label required">Roli</label>
                                    <select id="role" class="form-select" required>
                                        <option value="">Tanlang</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Moliyaviy auditor">Moliyaviy auditor</option>
                                        <option value="Moderator">Moderator</option>
                                        <option value="Islom moliyasi nazorati">Islom moliyasi nazorati</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Submit tugmalar --}}
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2" type="reset">Bekor
                                    qilish</a>
                                <button class="btn btn-primary" type="submit">Saqlash</button>
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
    </script>
@endpush
