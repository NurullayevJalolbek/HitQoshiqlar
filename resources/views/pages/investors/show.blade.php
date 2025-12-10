@extends('layouts.app')

@push('customCss')
<style>
    .form-label {
        font-weight: 500;
    }

    .info-label {
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
    }

    .info-value {
        font-weight: 400;
        font-size: 1rem;
        color: #212529;
    }

    .info-row {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .status-badge {
        font-size: 0.875rem;
        padding: 0.35rem 0.75rem;
    }

    .detail-card {
        border-radius: 0.5rem;
        border: 1px solid #e0e0e0;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
    }

    .content-wrapper {
        padding: 0 1rem 1rem 1rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .info-card {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1.5rem;
        border: 1px solid #e9ecef;
    }

    .info-card .section-title {
        color: #495057;
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    /* Status ranglari */
    .status-active {
        color: #28a745;
        font-weight: 600;
    }

    .status-blocked {
        color: #dc3545;
        font-weight: 600;
    }

    .status-pending {
        color: #ffc107;
        font-weight: 600;
    }

    /* Ma'lumot to'liqligi progress bar */
    .progress {
        background-color: #e9ecef;
        border-radius: 0.375rem;
    }

    .progress-bar {
        border-radius: 0.375rem;
        transition: width 0.6s ease;
    }



    .user-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .user-avatar {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
    }

    .user-details {
        flex: 1;
    }

    .user-name {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #495057;
    }

    .user-meta {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.875rem;
        color: #6c757d;
    }

    .meta-item i {
        width: 16px;
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
                        {{ __('admin.investors') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Investor tafsilotlari
                </li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
<div class="row mt-3">
    <div class="col-12 col-xl-12">
        <div class="card card-body border-0 shadow mb-4 detail-card p-0">

            {{-- Asosiy kontent --}}
            <div class="content-wrapper">
                {{-- Asosiy ma'lumotlar grid --}}
                <div class="info-grid mb-4">
                    {{-- Shaxsiy ma'lumotlar kartasi --}}
                    <div class="info-card mt-3">
                        <h4 class="section-title">
                            <i class="fas fa-user-circle me-2"></i>
                            Shaxsiy ma'lumotlar
                        </h4>
                        <div class="row">
                            <div class="col-12 info-row">
                                <div class="info-label">To'liq ismi</div>
                                <div class="info-value d-flex align-items-center">
                                    <i class="fas fa-user text-primary me-2"></i>
                                    {{ $investor['name'] }}
                                </div>
                            </div>

                            <div class="col-12 info-row">
                                <div class="info-label">Telefon raqami</div>
                                <div class="info-value d-flex align-items-center">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    {{ $investor['phone'] }}
                                </div>
                            </div>

                            @if($investor['passport'])
                            <div class="col-12 info-row">
                                <div class="info-label">Pasport seriyasi</div>
                                <div class="info-value d-flex align-items-center">
                                    <i class="fas fa-id-card text-primary me-2"></i>
                                    {{ $investor['passport'] }}
                                </div>
                            </div>
                            @endif

                            @if($investor['inn'])
                            <div class="col-12 info-row">
                                <div class="info-label">JSHIR</div>
                                <div class="info-value d-flex align-items-center">
                                    <i class="fas fa-fingerprint me-2"></i>
                                    {{ $investor['inn'] }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Hisob ma'lumotlari kartasi --}}
                    <div class="info-card mt-3">
                        <h4 class="section-title">
                            <i class="fas fa-chart-line me-2"></i>
                            Hisob ma'lumotlari
                        </h4>
                        <div class="row">
                            <div class="col-12 info-row">
                                <div class="info-label">Username</div>
                                <div class="info-value d-flex align-items-center">
                                    <i class="fa-solid fa-image-portrait me-2"></i>
                                    {{ $investor['username'] }}
                                </div>
                            </div>

                            <div class="col-12 info-row">
                                <div class="info-label">Qo'shilgan sana</div>
                                <div class="info-value d-flex align-items-center">
                                    <i class="far fa-calendar-alt text-primary me-2"></i>
                                    {{ \Carbon\Carbon::parse($investor['created_at'])->format('H:i  d.m.Y')}}
                                </div>
                            </div>

                            <div class="col-12 info-row">
                                <div class="info-label">Holati</div>
                                <div class="info-value">
                                    @if($investor['status'] === 'Faol')
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i> Faol
                                    </span>
                                    @elseif($investor['status'] === 'Bloklangan')
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="fas fa-ban me-1"></i> Bloklangan
                                    </span>
                                    @else
                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        <i class="fas fa-clock me-1"></i> Kutilmoqda
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Ma'lumot to'liqligi --}}
                            <div class="col-12 info-row">
                                <div class="info-label">Ma'lumot to'liqligi</div>
                                <div class="info-value">
                                    @php
                                    $status = strtolower(trim($investor['status']));

                                    if ($status === 'kutilmoqda') {
                                    $completionPercentage = 50;
                                    $progressColor = 'warning';
                                    $filledFields = 1;
                                    $totalFields = 2;
                                    } else {
                                    $completionPercentage = 100;
                                    $progressColor = 'success';
                                    $filledFields = 2;
                                    $totalFields = 2;
                                    }
                                    @endphp


                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 10px;">
                                            <div class="progress-bar bg-{{ $progressColor }}" role="progressbar"
                                                style="width: {{ $completionPercentage }}%">
                                            </div>
                                        </div>
                                        <span class="fw-bold">{{ $completionPercentage }}%</span>
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        {{ $filledFields }} / {{ $totalFields }} bosqich yakunlangan
                                    </small>

                                    <div class="mt-2">
                                        @if($investor['status'] === 'Kutilmoqda')
                                        <small class="text-warning">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Investor kutilmoqda holatida - ma'lumotlar yarim to'liq
                                        </small>
                                        @else
                                        <small class="text-success">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Investor faol holatida - barcha ma'lumotlar to'liq
                                        </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Harakatlar paneli --}}
                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex flex-wrap justify-content-end gap-2 py-2">
                        <a href="{{ route('admin.investors.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Orqaga
                        </a>

                        @if($investor['status'] === 'Faol')
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#blockModal">
                            <i class="fas fa-ban me-1"></i> Bloklash
                        </button>

                        @elseif($investor['status'] === 'Bloklangan')
                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#unblockModal">
                            <i class="fas fa-lock-open me-1"></i> Blokdan chiqarish
                        </button>
                        @endif

                        <a href="{{ route('admin.investors.edit', $investor['id']) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i> Tahrirlash
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bloklash modal oynasi -->
@if($investor['status'] === 'Faol')
<div class="modal fade" id="blockModal" tabindex="-1" aria-labelledby="blockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="blockModalLabel">Investorni bloklash</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>{{ $investor['name'] }}</strong> investorini bloklashni istaysizmi?</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Diqqat!</strong> Bloklangan investor tizimga kirishi va barcha harakatlarni amalga oshirish
                    huquqidan mahrum bo'ladi.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <form action="#" method="POST" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger">Bloklash</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Blokdan chiqarish modal oynasi -->
@if($investor['status'] === 'Bloklangan')
<div class="modal fade" id="unblockModal" tabindex="-1" aria-labelledby="unblockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unblockModalLabel">Investorni blokdan chiqarish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>{{ $investor['name'] }}</strong> investorini blokdan chiqarishni istaysizmi?</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Blokdan chiqarilgandan so'ng investor tizimga kirishi va barcha huquqlarni qayta tiklaydi.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <form action="#" method="POST" style="display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">Blokdan chiqarish</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection