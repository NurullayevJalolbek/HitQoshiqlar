@extends('layouts.app')

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <img src="{{ asset('svg/home-2.svg') }}" alt="Home">
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="">{{ __('admin.Profile') }}</a>
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
        <div class="col-12 col-xl-12">
            <div class="card card-body border-0 shadow mb-4 rounded-4 bg-light">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <h5 class="fw-bold">{{ __('admin.Personal information') }}</h5>

                    <a href="{{ route('admin.profile.edit', $model->id) }}"
                       class="btn btn-sm btn-warning d-flex align-items-center">
                        {{ __('admin.Edit') }}
                        <img src="{{ asset('svg/edit-2.svg') }}" alt="Edit" class="ms-1" style="width: 14px;">
                    </a>
                </div>

                <div class="row g-4 align-items-start">

                    {{-- LEFT SIDE — PHOTO --}}
                    <div class="col-md-2 mb-3">
                        <div class="my-4 text-center">
                            <img id="photo-preview"
                                 src="{{ $photo }}"
                                 alt="{{ __('admin.Photo') }}"
                                 class="img-fluid border rounded"
                                 style="width: 220px; height: 240px; object-fit: cover; padding: 5px;">
                        </div>
                    </div>

                    {{-- RIGHT SIDE — INFO --}}
                    <div class="col-md-9 mt-5">
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
