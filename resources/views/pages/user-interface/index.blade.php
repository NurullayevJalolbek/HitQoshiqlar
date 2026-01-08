@extends('layouts.app')

@push('customCss')
<style>
    /* Avvalgi kod bilan bir xil dizayn */
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
        /* Linklar uchun */
    }

    /* Hover effekti */
    .directory-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        background-color: #1F2937;
        /* Hover fon rangi */
    }

    /* Hover bo‘lganda ichidagi icon va matnlarni oq rangga aylantirish */
    .directory-card:hover .directory-icon,
    .directory-card:hover .directory-title {
        color: #ffffff;
        transition: color 0.3s ease-in-out;
    }

    .directory-card .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 1rem;
        /* Ichki hoshiya kattalashtirildi */
        min-height: 180px;
        /* Eng kam balandlik belgilandi (bir xil turishi uchun) */
    }

    /* Iconlar stili */
    .directory-icon {
        font-size: 2.5rem;
        color: #2e3e52;
        margin-bottom: 1.5rem;
        transition: color 0.3s ease-in-out;
    }

    /* Matn stili */
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
<div
    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
    style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
    <!-- Breadcrumb -->
    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('admin.user_interface') }}</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
<div class="row mt-3">

    {{-- 1. Tillarni boshqarish --}}
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="{{ route('admin.user-interface.language-management.index', ['go_back' => url()->full()]) }}" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-language directory-icon"></i>
                <h5 class="directory-title">Tillarni boshqarish</h5>
            </div>
        </a>
    </div>

    {{-- 2. Interfeys matnlarini tarjima qilish --}}
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="{{ route('admin.user-interface.system-translations.index', ['go_back' => url()->full()]) }}" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-globe directory-icon"></i>
                <h5 class="directory-title">Interfeys matnlarini tarjima qilish</h5>
            </div>
        </a>
    </div>

    {{-- 3. Statik sahifalar va ma'lumotlar --}}
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        {{-- Agar link bo'lmasa href="#" qoldirildi, stil buzilmasligi uchun --}}
        <a href="{{ route('admin.user-interface.static-pages.index') }}" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-file-alt directory-icon"></i>
                <h5 class="directory-title">Statik sahifalar va ma’lumotlar</h5>
            </div>
        </a>
    </div>

    {{-- 4. Multimedia va vizual elementlar --}}
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="{{ route('admin.user-interface.multimedia.index') }}" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-image directory-icon"></i>
                <h5 class="directory-title">Multimedia va vizual elementlar</h5>
            </div>
        </a>
    </div>

    {{-- 5. Shablon xabarlar matni --}}
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="{{ route('admin.user-interface.template-messages.index') }}" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-envelope directory-icon"></i>
                <h5 class="directory-title">Shablon xabarlar matni</h5>
            </div>
        </a>
    </div>

    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="#" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-handshake directory-icon"></i>
                <h5 class="directory-title">Hamkorlar</h5>
            </div>
        </a>
    </div>
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="#" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-comments directory-icon"></i>
                <h5 class="directory-title">Murojaatlar</h5>
            </div>
        </a>
    </div>



</div>
@endsection

@push('customJs')
<script>
    // JS Kodlar
</script>
@endpush