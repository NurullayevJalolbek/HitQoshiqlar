@extends('layouts.app')

@push('customCss')
<style>
    .profile-photo {
        max-width: 100%;
        width: 180px;
        height: 220px;
        object-fit: cover;
        padding: 5px;
    }

    /* MacBook va kichik laptoplar */
    @media (max-width: 1200px) {
        .profile-photo {
            width: 160px;
            height: 200px;
        }
    }

    /* Telefon */
    @media (max-width: 576px) {
        .profile-photo {
            width: 140px;
            height: 180px;
            margin-bottom: 1rem;
        }
    }
</style>
@endpush

@section('breadcrumb')
<div
    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
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
                <li class="breadcrumb-item active" aria-current="page">
                    Profile
                </li>

            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
@php
$photo = $model->image ? asset('uploads/'.$model->image) : asset('assets/img/default.jpg');
$fullname = trim($model->surname.' '.$model->name.' '.$model->patronymic);
@endphp

<div class="row">
    <div class="col-12 col-xl-12 mt-2">
        <div class="card card-body border-0 shadow mb-4 rounded-4 bg-light">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <h5 class="fw-bold">{{ __('admin.Personal information') }}</h5>
                <x-edit-button-border url="{{ route('admin.profile.edit', $model->id) }}" />
            </div>

            <div class="row g-4 align-items-start">

                <!-- PHOTO -->
                <div class="col-12 col-sm-4 col-md-3 col-lg-2 text-center">
                    <img id="photo-preview"
                        src="{{ $photo }}"
                        alt="{{ __('admin.Photo') }}"
                        class="profile-photo img-fluid rounded border">
                </div>

                {{-- RIGHT SIDE — INFO --}}
                <div class="col-12 col-sm-8 col-md-9 col-lg-10">
                    <div class="row">

                        <div class="col-md-4 mb-4">
                            <div class="fw-semibold text-dark fs-6">{{ __('admin.Fullname') }}</div>
                            <div class="fw-bold text-muted fs-6">{{ $fullname ?: '-' }}</div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="fw-semibold text-dark fs-6">{{ __('admin.Email') }}</div>
                            <div class="fw-bold text-muted fs-6">{{ $model->email ?: '-' }}</div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="fw-semibold text-dark fs-6">{{ __('admin.Phone Number') }}</div>
                            <div class="fw-bold text-muted fs-6">{{ $model->phone ?: '-' }}</div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="fw-semibold text-dark fs-6">{{ __('admin.Birthdate') }}</div>
                            <div class="fw-bold text-muted fs-6">
                                {{ $model->birthdate ? \Carbon\Carbon::parse($model->birthdate)->format('Y-m-d') : '-' }}
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="fw-semibold text-dark fs-6">{{__('admin.Passport')}}</div>
                            <div class="fw-bold text-muted fs-6">{{ $model->passport ?: '-' }}</div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="fw-semibold text-dark fs-6">{{__('admin.PINFL')}}</div>
                            <div class="fw-bold text-muted fs-6">{{ $model->pinfl ?: '-' }}</div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="fw-semibold text-dark fs-6">{{__('admin.Registered_by')}}</div>
                            <div class="fw-bold text-muted fs-6">{{ $model->registered_by ?: '-' }}</div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="fw-semibold text-dark fs-6">{{__('admin.Username')}}</div>
                            <div class="fw-bold text-muted fs-6">{{ $model->username ?: '-' }}</div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="fw-semibold text-dark fs-6">{{__('admin.Status')}}</div>
                            <div class="fw-bold text-muted fs-6">{{ $model->status }}</div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection