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
        display: flex;
        align-items: center;
        gap: 0.4rem;
        color: #1F2937;
        /* label va icon uchun umumiy rang */
    }

    .info-label i {
        color: #1F2937;
        /* barcha iconlar shu rangda bo‘lsin */
    }

    .info-value {
        font-weight: 400;
    }

    .info-row {
        margin-bottom: 1rem;
    }

    .badge i {
        color: #fff;
        /* badge ichidagi iconlar oq rangda qoladi */
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
                            <div class="info-label"><i class="fa-solid fa-user"></i> F.I.O</div>
                            <div class="info-value">{{ $model['name'] }}</div>
                        </div>

                        <div class="col-md-6 info-row">
                            <div class="info-label"><i class="fa-solid fa-image-portrait"></i> Login</div>
                            <div class="info-value">{{ $model['username'] }}</div>
                        </div>

                        <div class="col-md-6 info-row">
                            <div class="info-label"><i class="fa-solid fa-envelope"></i> Email</div>
                            <div class="info-value">{{ $model['email'] }}</div>
                        </div>

                        <div class="col-md-6 info-row">
                            <div class="info-label"><i class="fa-solid fa-phone"></i> Telefon</div>
                            <div class="info-value">{{ $model['phone'] ?? '-' }}</div>
                        </div>

                        <div class="col-md-6 info-row">
                            <div class="info-label"><i class="fa-solid fa-user-shield"></i> Roli</div>
                            <div class="info-value">{{ $model['role'] }}</div>
                        </div>

                        <div class="col-md-6 info-row">
                            <div class="info-label"><i class="fa-solid fa-toggle-on"></i> Holati</div>
                            <div class="info-value">
                                @if($model['status'] === 'Faol')
                                <span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i>Faol</span>
                                @elseif($model['status'] === 'Kutilmoqda')
                                <span class="badge bg-warning"><i class="fa-solid fa-hourglass-half me-1"></i>Kutilmoqda</span>
                                @else
                                <span class="badge bg-danger"><i class="fa-solid fa-circle-xmark me-1"></i>Bloklangan</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 info-row">
                            <div class="info-label"><i class="fa-solid fa-calendar-days"></i> Yaratilgan sanasi</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($model['created_at'])->format('H:i  d.m.Y') }}</div>
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