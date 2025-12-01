@extends('layouts.app')

@push('customCss')
<style>
    .invalid-feedback {
        position: absolute;
        margin-top: 2px;
        font-size: 12px;
    }
</style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#"><img src="{{ asset('svg/home-2.svg') }}" alt="Home"></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.investors.index') }}">{{ __('admin.Investors') }}</a>
                </li>
                <li class="breadcrumb-item active">{{ $label }}</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-xl-12">
        <div class="card card-body border-0 shadow mb-4">

            <form id="investor-form">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>F.I.O <span class="text-danger">*</span></label>
                        <input type="text" id="full_name" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Login <span class="text-danger">*</span></label>
                        <input type="text" id="login" class="form-control" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Telefon</label>
                        <input type="text" id="phone" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Passport</label>
                        <input type="text" id="passport" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>JSHSHIR</label>
                        <input type="text" id="jshshir" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select id="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="blocked">Blocked</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Ro‘yxatdan o‘tgan sana</label>
                        <input type="date" id="registered_at" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Investor sertifikati</label>
                        <input type="file" id="certificate" class="form-control" onchange="previewCertificate(event)">
                        <img id="certificate_preview" class="mt-2" src="" width="120">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Ulash (summa)</label>
                        <input type="number" id="share_amount" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Ulash (foiz)</label>
                        <input type="number" id="share_percent" class="form-control">
                    </div>

                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ $back_route }}" class="btn btn-gray-800">{{ __('admin.Back') }}</a>
                    <button type="submit" class="btn btn-success text-white">{{ __('admin.Save') }}</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
