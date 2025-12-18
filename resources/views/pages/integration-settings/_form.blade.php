@extends('layouts.app')

@push('customCss')
<style>
    .input-group-text {
        width: 45px;
        justify-content: center;
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
                <li class="breadcrumb-item active" aria-current="page">
                    Integratsiyani tahrirlash
                </li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')

<div class="row mt-3">
    <div class="col-12">
        <div class="card card-body border-0 shadow mb-4">
            <h2 class="h5 mb-4">{{ $data['name'] ?? ' Yangi' }} Integratsiyasini tahrirlash</h2>

            <form method="POST" action="#" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <div class="row">

                    {{-- Name --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Xizmat nomi</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-tag"></i>
                            </span>
                            <input type="text"
                                name="name"
                                class="form-control"
                                placeholder="Masalan: SMS Xizmati (Eskiz)"
                                value="{{ $data['name'] ?? '' }}"
                                required>
                        </div>
                    </div>
                    @php
                    $statuses = [
                    "1" => "Faol",
                    "0" => "Nofaol",
                    ];
                    @endphp
                    {{-- Status --}}
                    <x-select-with-search
                        name="integrationFormStatus"
                        label="Holati"
                        :datas="$statuses"
                        colMd="6"
                        placeholder="Barchasi"
                        :selected="$data['status'] ?? ''"
                        :selectSearch=false
                        icon="fa-toggle-on" />



                    {{-- API URL --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">API URL</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-link"></i>
                            </span>
                            <input type="url"
                                name="api"
                                class="form-control"
                                placeholder="https://api.eskiz.uz"
                                value="{{ $data['api'] ?? '' }}">
                        </div>
                    </div>

                    {{-- Token --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">API Token</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-key"></i>
                            </span>
                            <input type="text"
                                name="token"
                                class="form-control"
                                placeholder="Eskiz API token"
                                value="{{ $data['token'] ?? '' }}">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Parol</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" autocomplete="new-password"
                                name="password"
                                class="form-control"
                                placeholder="SMS xizmat paroli"
                                value="{{ $data['password'] ?? '' }}">
                        </div>
                    </div>

                    {{-- Secret Key --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Secret Key (ixtiyoriy)</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-shield-alt"></i>
                            </span>
                            <input type="text"
                                name="secret_key"
                                class="form-control"
                                placeholder="Agar mavjud bo‘lsa"
                                value="{{ $data['secret_key'] ?? '' }}">
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="col-12 mb-3">
                        <label class="form-label">Tavsif</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-align-left"></i>
                            </span>
                            <textarea name="description"
                                class="form-control"
                                rows="3"
                                placeholder="Integratsiya haqida qisqacha izoh">{{ $data['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3 gap-2">
                        <a href="{{ route('admin.integration-settings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Bekor qilish
                        </a>

                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-save me-1"></i>
                            @isset($user) Yangilash @else Saqlash @endisset
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection