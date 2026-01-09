@extends('layouts.app')

@push('customCss')
<style>
    /* Directory Cards Styling */
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

    /* Hover efekti */
    .directory-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        background-color: #1F2937;
    }

    /* Hover bo'lganda ichidagi icon va matnlarni oq rangga aylantirish */
    .directory-card:hover .directory-icon,
    .directory-card:hover .directory-title,
    .directory-card:hover .directory-description {
        color: #ffffff;
        transition: color 0.3s ease-in-out;
    }

    .directory-card .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 1rem;
        min-height: 220px;
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
        font-size: 1.25rem;
        font-weight: 600;
        color: #2e3e52;
        text-align: center;
        margin: 0 0 0.5rem 0;
        transition: color 0.3s ease-in-out;
    }

    /* Tavsif stili */
    .directory-description {
        font-size: 0.875rem;
        color: #6c757d;
        text-align: center;
        margin: 0;
        transition: color 0.3s ease-in-out;
    }

    /* Grid tizimi */
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding-right: 15px;
        padding-left: 15px;
    }

    @media (min-width: 992px) {
        .col-lg-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }
    }

    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* Breadcrumb stili */
    .breadcrumb-block {
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 0.5rem;
        background-color: #ffffff;
        height: 60px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 1rem;
    }

    .breadcrumb {
        margin-bottom: 0;
    }

    .breadcrumb-item a {
        color: #6c757d;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: #495057;
    }

    /* Sahifa umumiy stili */
    .mt-3 {
        margin-top: 1rem !important;
    }
</style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3">
    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.user-interface.index') }}">
                        Interfeys
                    </a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    Statik sahifalar
                </li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2 align-items-center flex-wrap">


        <x-go-back />
    </div>
</div>
@endsection

@section('content')
<div class="row mt-3">
    {{-- 1. Bosh sahifa --}}
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="{{ route('admin.user-interface.static-pages.home-page.index') }}" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-home directory-icon"></i>
                <h5 class="directory-title">Bosh sahifa</h5>
                <p class="directory-description">Bosh sahifa kontenti, bannerlar va asosiy bo'limlarni boshqarish</p>
            </div>
        </a>
    </div>

    {{-- 2. Biz haqimizda --}}
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="{{ route('admin.user-interface.static-pages.about-us.index') }}" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-info-circle directory-icon"></i>
                <h5 class="directory-title">Biz haqimizda</h5>
                <p class="directory-description">Kompaniya haqida ma'lumot, missiya, viziya va jamoa</p>
            </div>
        </a>
    </div>

    {{-- 3. Loyihalar --}}
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="#" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-project-diagram directory-icon"></i>
                <h5 class="directory-title">Loyihalar</h5>
                <p class="directory-description">Loyihalar katalogi, turkumlari va tafsilotlari</p>
            </div>
        </a>
    </div>

    {{-- 4. Shariatga muvofiqlik --}}
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="{{ route('admin.user-interface.static-pages.sharia-compliance.index') }}" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-scale-balanced directory-icon"></i>
                <h5 class="directory-title">Shariatga muvofiqlik</h5>
                <p class="directory-description">Shariat qoidalari, fatvolar va halollik sertifikatlari</p>
            </div>
        </a>
    </div>

    {{-- 5. Media --}}
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="#" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-photo-film directory-icon"></i>
                <h5 class="directory-title">Media</h5>
                <p class="directory-description">Foto va video galereya, yangiliklar va tadbirlar</p>
            </div>
        </a>
    </div>

    {{-- 6. Aloqa --}}
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <a href="#" class="card directory-card">
            <div class="card-body">
                <i class="fas fa-address-book directory-icon"></i>
                <h5 class="directory-title">Aloqa</h5>
                <p class="directory-description">Aloqa ma'lumotlari, joylashuv va feedback formasi</p>
            </div>
        </a>
    </div>
</div>
@endsection

@push('customJs')
<script>
    // Kerak bo'lsa JavaScript qo'shishingiz mumkin
    document.addEventListener('DOMContentLoaded', function() {
        // Karta hover effekti uchun qo'shimcha JavaScript
        const cards = document.querySelectorAll('.directory-card');

        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.zIndex = '10';
            });

            card.addEventListener('mouseleave', function() {
                this.style.zIndex = '1';
            });
        });
    });
</script>
@endpush