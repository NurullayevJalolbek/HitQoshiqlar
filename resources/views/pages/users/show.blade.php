@extends('layouts.app')

@push('customCss')
    <style>
        .form-label {
            font-weight: 500;
        }

        .photo-preview {
            width: 220px;
            height: 240px;
            object-fit: cover;
            padding: 5px;
            border-radius: 6px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }

        .info-label {
            font-weight: 500;
        }

        .info-value {
            font-weight: 400;
        }

        .info-row {
            margin-bottom: 1rem;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
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
                        Foydalanuvchi tafsilotlari
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
                <h2 class="h5 mb-4">Foydalanuvchi tafsilotlari</h2>

                <div class="row">

                    {{-- Chap tomonda rasm placeholder --}}
                    <div class="col-md-3 text-center mb-3">
                        <img src="{{ asset('assets/img/default.jpg') }}" alt="Foto" class="photo-preview mb-3">
                    </div>

                    {{-- O'ng tomonda ma'lumotlar --}}
                    <div class="col-md-9">
                        <div class="row">

                            <div class="col-md-6 info-row">
                                <div class="info-label">F.I.O</div>
                                <div class="info-value">{{ $model['name'] }}</div>
                            </div>

                            <div class="col-md-6 info-row">
                                <div class="info-label">Login</div>
                                <div class="info-value">{{ $model['username'] }}</div>
                            </div>

                            <div class="col-md-6 info-row">
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ $model['email'] }}</div>
                            </div>

                            <div class="col-md-6 info-row">
                                <div class="info-label">Telefon</div>
                                <div class="info-value">{{ $model['phone'] ?? '-' }}</div>
                            </div>

                            <div class="col-md-6 info-row">
                                <div class="info-label">Roli</div>
                                <div class="info-value">{{ $model['role'] }}</div>
                            </div>

                            <div class="col-md-6 info-row">
                                <div class="info-label">Holati</div>
                                <div class="info-value">
                                    @if($model['status'] === 'Faol')
                                        <span class="badge bg-success">Faol</span>
                                    @else
                                        <span class="badge bg-danger">Bloklangan</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 info-row">
                                <div class="info-label">Yaratilgan sanasi</div>
                                <div class="info-value">{{ $model['created_at'] }}</div>
                            </div>

                        </div>

                        {{-- Tugmalar --}}
                        <div class="d-flex justify-content-end mt-3 gap-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Orqaga
                            </a>
                            <a href="{{ route('admin.users.edit', $model['id']) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i> Tahrirlash
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
