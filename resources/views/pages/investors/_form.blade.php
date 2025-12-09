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
                    <a href="{{ route('admin.investors.index') }}">
                        Investorlar
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Investorni tahrirlash
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

            <h2 class="h5 mb-4">Investorni tahrirlash</h2>

            <form method="POST"
                action="{{ route('admin.investors.update', $investor['id']) }}"
                class="needs-validation"
                novalidate>

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label required">F.I.O</label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $investor['name']) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Username</label>
                        <input type="text" name="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username', $investor['username']) }}" required>
                        @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Telefon</label>
                        <input type="text" name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            value="{{ old('phone', $investor['phone']) }}" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Passport</label>
                        <input type="text" name="passport"
                            class="form-control @error('passport') is-invalid @enderror"
                            value="{{ old('passport', $investor['passport']) }}" required>
                        @error('passport') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label required">JSHIR</label>
                        <input type="text" name="inn"
                            class="form-control @error('inn') is-invalid @enderror"
                            value="{{ old('inn', $investor['inn']) }}" required>
                        @error('inn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- READONLY STATUS — ADMIN O'ZGARTIRA OLMAYDI --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Holati (Status)</label>
                        <input type="text"
                            class="form-control"
                            value="{{ $investor['status'] }}"
                            readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ro‘yxatdan o‘tgan vaqt</label>
                        <input type="text" class="form-control"
                            value="{{ $investor['created_at'] }}" readonly>
                    </div>

                </div>

                <div class="d-flex justify-content-end mt-3 gap-2">
                    <a href="{{ route('admin.investors.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Bekor qilish
                    </a>

                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save me-1"></i> Yangilash
                    </button>
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
    })();
</script>
@endpush