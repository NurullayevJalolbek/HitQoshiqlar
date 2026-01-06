@extends('layouts.app')

@push('customCss')
{{-- CSS Ko'dlari--}}
@endpush


@section('breadcrumb')
<div
    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
    style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
    <!-- Breadcrumb -->
    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.user-interface.index') }}">
                        {{ __('admin.user_interface') }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Tillarni boshqarish
                </li>
            </ol>
        </nav>
    </div>

    <!-- Tugmalar guruhi -->
    <div class="d-flex gap-2 align-items-center flex-wrap">

        <a href="    {{ route('admin.user-interface.language-management.create', ['go_back' => url()->full()]) }}" class="btn btn-primary btn-sm px-3 py-1" id="addUserBtn"
            style="min-width: 90px;">
            <i class="fas fa-plus me-1" style="font-size: 0.85rem;"></i> {{ __('admin.create') }}
        </a>


    </div>
</div>
@endsection

@section('content')

@php
$datas = getLanguagesData();

@endphp


{{-- 1. TILLARNI BOSHQARISH --}}
<div class="card card-body shadow-sm mb-3 mt-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="section-title">
            <i class="fas fa-language me-1"></i> Tillarni boshqarish
        </div>


    </div>

    <table class="table language-table table-bordered table-hover table-striped align-items-center">
        <thead class="table-dark">
            <tr>
                <th style="width:3%">№</th>
                <th class="text-center">Til nomi</th>
                <th style="width:90px;">Kodi</th>
                <th style="width:120px;">Holati</th>
                <th style="width:120px;">Asosiy til</th>
                <th style="width:120px;" class="text-center">Amallar</th>
            </tr>
        </thead>

        <tbody>
            @foreach($datas as $data)
            <tr>
                <td>{{ $data['id'] }}</td>
                <td class="text-center">{{ $data['name'] }}</td>
                <td>{{ $data['code'] }}</td>
                <td>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="active_{{ $data['id'] }}"
                            {{ $data['is_active'] ? 'checked' : '' }}>
                    </div>
                </td>

                <td>
                    <div class="form-check form-switch">
                        <input
                            class="form-check-input set-default-language"
                            type="checkbox"
                            onchange="setDefaultLanguage(this)"
                            data-id="{{ $data['id'] }}"
                            {{ $data['is_default'] ? 'checked' : '' }}
                            {{ $data['is_default'] ? 'disabled' : '' }}>
                    </div>
                </td>



                <td class="text-center  justify-content-center gap-1">
                    <x-edit-button href="{{ route('admin.user-interface.language-management.edit', [$data['id'], 'go_back' => url()->full()]) }}" />
                    <x-delete-button class="disabled" />
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('customJs')
<script>
    //
</script>

@endpush