@extends('layouts.app')

@push('customCss')
<style>
    .directory-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: all 0.3s ease-in-out;
        cursor: pointer;
        text-decoration: none !important;
        height: 100%;
        background-color: #fff;
        display: block;
    }

    .directory-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        background-color: #1F2937;
    }

    .directory-card:hover .directory-icon,
    .directory-card:hover .directory-title {
        color: #ffffff;
    }

    .directory-card .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 1rem;
        min-height: 180px;
    }

    .directory-icon {
        font-size: 2.5rem;
        color: #2e3e52;
        margin-bottom: 1.5rem;
        transition: color 0.3s ease-in-out;
    }

    .directory-title {
        font-size: 1rem;
        font-weight: 600;
        color: #2e3e52;
        text-align: center;
        margin: 0;
        transition: color 0.3s ease-in-out;
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
                    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Umumiy sozlamalar
                </li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
<div class="row mt-3">

    {{-- 1. Sayt haqida umumiy ma’lumotlar --}}
    <!-- <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="#" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-info-circle directory-icon"></i>
                <h5 class="directory-title">Sayt haqida umumiy ma’lumotlar</h5>
            </div>
        </a>
    </div> -->

    {{-- 2. SEO sozlamalari --}}
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="{{ route('admin.seo-settings.index') }}" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-search directory-icon"></i>
                <h5 class="directory-title">SEO sozlamalari</h5>
            </div>
        </a>
    </div>

    {{-- 3. Xabar yuborish sozlamalari --}}
    <!-- <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="#" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-envelope-open-text directory-icon"></i>
                <h5 class="directory-title">Xabar yuborish sozlamalari</h5>
            </div>
        </a>
    </div> -->

    {{-- 4. Sana, vaqt va til sozlamalari --}}
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="{{ route('admin.localization.index') }}" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-clock directory-icon"></i>
                <h5 class="directory-title">Sana, vaqt va til sozlamalari</h5>
            </div>
        </a>
    </div>

    {{-- 5. Xavfsizlik va xizmat ko‘rsatish --}}
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="#" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-shield-alt directory-icon"></i>
                <h5 class="directory-title">Xavfsizlik va xizmat ko‘rsatish</h5>
            </div>
        </a>
    </div>

    {{-- 6. Performance sozlamalari --}}
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="#" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-tachometer-alt directory-icon"></i>
                <h5 class="directory-title">Ish faoliyati (Performance)</h5>
            </div>
        </a>
    </div>

</div>
@endsection