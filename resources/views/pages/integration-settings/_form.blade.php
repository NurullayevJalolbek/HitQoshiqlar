@extends('layouts.app')

@push('customCss')
<style>
    .input-group-text {
        width: 45px;
        justify-content: center;
    }

    .form-check-input {
        margin-top: 0.3rem;
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
            <h2 class="h5 mb-4">
                <i class="{{ $integration['icon'] ?? 'fas fa-cog' }} me-2"></i>
                {{ $integration['name'] ?? 'Yangi' }} Integratsiyasini tahrirlash
            </h2>

            <form method="POST" action="#" class="needs-validation" novalidate>
                @csrf
                @method('PUT')

                <div class="row">
                    @php
                    $statuses = [
                    "1" => "Faol",
                    "0" => "Nofaol",
                    ];
                    @endphp

                    <x-select-with-search
                        name="integrationFormStatus"
                        label="Holati"
                        :datas="$statuses"
                        colMd="6"
                        placeholder="Barchasi"
                        :selected="$data['status'] ?? ''"
                        :selectSearch=false
                        icon="fa-toggle-on" />

                    {{-- Dynamic Fields --}}
                    @foreach($integration['fields_config'] ?? [] as $field => $config)
                    @if(in_array($config['type'], ['text', 'url', 'email', 'password', 'number']))
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            {{ $config['label'] }}
                            @if($config['required'] ?? false)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="{{ $config['icon'] ?? 'fas fa-cog' }}"></i>
                            </span>
                            <input type="{{ $config['type'] }}"
                                name="settings[{{ $field }}]"
                                class="form-control"
                                placeholder="{{ $config['placeholder'] ?? '' }}"
                                value="{{ old('settings.' . $field, $data[$field] ?? ($config['default'] ?? '')) }}"
                                @if($config['required'] ?? false) required @endif
                                @if(isset($config['min'])) min="{{ $config['min'] }}" @endif
                                @if(isset($config['max'])) max="{{ $config['max'] }}" @endif
                                @if(isset($config['step'])) step="{{ $config['step'] }}" @endif
                                @if($field=='password' ) autocomplete="new-password" @endif>
                        </div>
                        @error('settings.' . $field)
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    @elseif($config['type'] == 'select')
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            {{ $config['label'] }}
                            @if($config['required'] ?? false)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="{{ $config['icon'] ?? 'fas fa-caret-down' }}"></i>
                            </span>
                            <select name="settings[{{ $field }}]"
                                class="form-control"
                                @if($config['required'] ?? false) required @endif>
                                <option value="">-- Tanlash --</option>
                                @foreach($config['options'] ?? [] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ old('settings.' . $field, $data[$field] ?? '') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('settings.' . $field)
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    @elseif($config['type'] == 'checkbox')
                    <div class="col-md-6 mb-3">
                        <div class="form-check form-switch mt-4">
                            <input type="checkbox"
                                name="settings[{{ $field }}]"
                                id="{{ $field }}"
                                class="form-check-input"
                                value="{{ $config['value'] ?? 1 }}"
                                {{ old('settings.' . $field, $data[$field] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label ms-2" for="{{ $field }}">
                                <i class="{{ $config['icon'] ?? 'fas fa-check' }} me-1"></i>
                                {{ $config['label'] }}
                            </label>
                        </div>
                        @error('settings.' . $field)
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    @elseif($config['type'] == 'textarea')
                    <div class="col-12 mb-3">
                        <label class="form-label">
                            {{ $config['label'] }}
                            @if($config['required'] ?? false)
                            <span class="text-danger">*</span>
                            @endif
                        </label>
                        <div class="input-group">
                            <span class="input-group-text align-items-start pt-2">
                                <i class="{{ $config['icon'] ?? 'fas fa-align-left' }}"></i>
                            </span>
                            <textarea name="settings[{{ $field }}]"
                                class="form-control"
                                rows="3"
                                placeholder="{{ $config['placeholder'] ?? '' }}"
                                @if($config['required'] ?? false) required @endif>{{ old('settings.' . $field, $data[$field] ?? '') }}</textarea>
                        </div>
                        @error('settings.' . $field)
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    @endif
                    @endforeach

                    @if(empty($integration['fields_config']))
                    {{-- Agar fields_config bo'lmasa, oldingi statik form --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">API URL</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-link"></i>
                            </span>
                            <input type="url"
                                name="settings[api]"
                                class="form-control"
                                placeholder="https://api.eskiz.uz"
                                value="{{ old('settings.api', $data['api'] ?? '') }}">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Token</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-key"></i>
                            </span>
                            <input type="text"
                                name="settings[token]"
                                class="form-control"
                                placeholder="API token"
                                value="{{ old('settings.token', $data['token'] ?? '') }}">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Secret Key</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-shield-alt"></i>
                            </span>
                            <input type="text"
                                name="settings[secret_key]"
                                class="form-control"
                                placeholder="Secret key"
                                value="{{ old('settings.secret_key', $data['secret_key'] ?? '') }}">
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Parol</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" autocomplete="new-password"
                                name="settings[password]"
                                class="form-control"
                                placeholder="Parol"
                                value="{{ old('settings.password', $data['password'] ?? '') }}">
                        </div>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Tavsif</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-align-left"></i>
                            </span>
                            <textarea name="settings[description]"
                                class="form-control"
                                rows="3"
                                placeholder="Integratsiya haqida qisqacha izoh">{{ old('settings.description', $data['description'] ?? '') }}</textarea>
                        </div>
                    </div>
                    @endif

                    <div class="d-flex justify-content-end mt-3 gap-2">
                        <a href="{{ route('admin.integration-settings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Bekor qilish
                        </a>

                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-save me-1"></i>
                            @isset($integration) Yangilash @else Saqlash @endisset
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection