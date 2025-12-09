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

    .input-group-text {
        border-right: none;
    }

    .input-group .form-control {
        border-left: none;
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
                    <a href="{{ route('admin.investors.index') }}">Investorlar</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Investorni tahrirlash</li>
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

            <form method="POST" action="{{ route('admin.investors.update', $investor['id']) }}" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <!-- F.I.O -->
                    <div class="col-md-6">
                        <label class="form-label required">F.I.O</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-solid fa-user text-muted"></i></span>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $investor['name']) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="col-md-6">
                        <label class="form-label required">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-solid fa-image-portrait text-muted"></i></span>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $investor['username']) }}" required>
                            @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Telefon -->
                    <div class="col-md-6">
                        <label class="form-label required">Telefon</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-solid fa-phone text-muted"></i></span>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $investor['phone']) }}" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Pasport (readonly) -->
                    <div class="col-md-6">
                        <label class="form-label">Passport</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-solid fa-id-card text-muted"></i></span>
                            <input type="text" name="passport" class="form-control" value="{{ $investor['passport'] }}" readonly>
                        </div>
                    </div>

                    <!-- JSHIR (readonly) -->
                    <div class="col-md-6">
                        <label class="form-label">JSHIR</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-solid fa-fingerprint text-muted"></i></span>
                            <input type="text" name="inn" class="form-control" value="{{ $investor['inn'] }}" readonly>
                        </div>
                    </div>

                    <!-- Status (readonly) -->
                    <div class="col-md-6">
                        <label class="form-label">Holati (Status)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-solid fa-toggle-on text-muted"></i></span>
                            <input type="text" class="form-control" value="{{ $investor['status'] }}" readonly>
                        </div>
                    </div>

                    <!-- Kirgan vaqt (readonly) -->
                    <div class="col-md-6">
                        <label class="form-label">Ro‘yxatdan o‘tgan vaqt</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fa-solid fa-calendar-days text-muted"></i></span>
                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($investor['created_at'])->format('H:i d.m.Y') }}" readonly>
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
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
    (function() {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
@endpush