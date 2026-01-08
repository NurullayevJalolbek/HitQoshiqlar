@extends('layouts.app')

@push('customCss')
<style>
    :root {
        --primary-color: #4361ee;
        --primary-dark: #3a56d4;
        --success-color: #2ecc71;
        --danger-color: #e74c3c;
        --warning-color: #f39c12;
        --border-color: #eaeaea;
    }

    .setting-card {
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        background-color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .setting-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: #1F2937;
        border-radius: 16px 0 0 16px;
        z-index: 1;
    }

    .setting-card:hover {
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
    }

    .setting-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .setting-title i {
        margin-right: 0.75rem;
        color: #1F2937;
    }

    .setting-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1.25rem;
    }

    /* Language Tabs */
    .section-tabs {
        border-bottom: 2px solid #e5e7eb;
        margin-bottom: 1.5rem;
        margin-top: 1rem;
    }

    .section-tabs .nav-link {
        padding: 0.5rem 1rem;
        font-weight: 500;
        color: #6c757d;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .section-tabs .nav-link.active {
        color: #1F2937;
        border-bottom-color: #1F2937;
        font-weight: 600;
    }

    /* Section Header */
    .section-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .section-header h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    /* Dynamic Items */
    .dynamic-item {
        background: #f8f9fa;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.25rem;
        margin-bottom: 1rem;
        position: relative;
    }

    .dynamic-item .remove-btn {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: #ef4444;
        color: white;
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .dynamic-item .remove-btn:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    .add-new-btn {
        background: #10b981;
        color: white;
        border: none;
        border-radius: 0.375rem;
        padding: 0.5rem 1rem;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .add-new-btn:hover {
        background: #0da271;
        transform: translateY(-2px);
    }

    .add-new-btn i {
        margin-right: 0.5rem;
    }

    /* Banner Preview */
    .banner-preview {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.5rem;
        padding: 0.5rem;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
    }

    .banner-preview img {
        width: 60px;
        height: 40px;
        object-fit: cover;
        border-radius: 0.25rem;
    }

    .banner-info {
        flex: 1;
    }

    .banner-info h6 {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .banner-info p {
        margin: 0;
        font-size: 0.8rem;
        color: #6c757d;
    }

    /* App Links */
    .app-links-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9f7fe 100%);
        border: 1px solid #d1ecf1;
        border-radius: 0.5rem;
        padding: 1.5rem;
    }

    /* Section Title */
    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border-color);
    }

    .info-badge {
        background-color: #e7f1ff;
        color: var(--primary-color);
        padding: 0.75rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        border-left: 3px solid var(--primary-color);
    }

    .info-badge i {
        margin-right: 0.5rem;
    }

    .save-btn {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        transition: all 0.3s ease;
    }

    .save-btn:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-2px);
    }

    /* Form Elements */
    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
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
                    <a href="{{ route('admin.user-interface.index') }}">
                        Interfeys
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.user-interface.static-pages.index') }}">
                        Statik sahifalar
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Bosh sahifa
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
<div class="py-3">
    <div class="content-container" style="background-color: white; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.625rem rgba(0,0,0,0.08); padding: 1.5rem;">
        <h1 class="section-title">
            <i class="fas fa-home me-2"></i>Bosh sahifa sozlamalari
        </h1>

        <div class="info-badge">
            <i class="fas fa-info-circle"></i>
            «Envast» investitsiya platformasining bosh sahifasidagi kontentni boshqaring.
        </div>

        <!-- 1. Asosiy banner -->
        <div class="setting-card">
            <div class="section-header">
                <h3><i class="fas fa-image me-2"></i>Asosiy banner</h3>
                <p class="setting-description">Bosh sahifaning yuqori qismidagi asosiy banner</p>
            </div>

            <!-- Language Tabs for Main Banner -->
            <ul class="nav section-tabs" id="mainBannerTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="mb-uz-tab" data-bs-toggle="tab" data-bs-target="#mb-uz-content" type="button" role="tab">
                        🇺🇿 O'zbek
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="mb-ru-tab" data-bs-toggle="tab" data-bs-target="#mb-ru-content" type="button" role="tab">
                        🇷🇺 Русский
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="mb-en-tab" data-bs-toggle="tab" data-bs-target="#mb-en-content" type="button" role="tab">
                        🇬🇧 English
                    </button>
                </li>
            </ul>

            <!-- Main Banner Language Content -->
            <div class="tab-content" id="mainBannerTabContent">
                <!-- Uzbek -->
                <div class="tab-pane fade show active" id="mb-uz-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Sarlavha</label>
                            <input type="text" class="form-control" value="Halol investitsiya platformasi">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Tavsif</label>
                            <textarea class="form-control" rows="3">Envast - ko'chmas mulkka halol va xavfsiz investitsiya platformasi</textarea>
                        </div>
                    </div>

                    <div class="banner-items-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Banner tanlash</label>
                                    <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                                        <option value="" selected>Banner tanlang...</option>
                                        <option value="1">Asosiy banner - 1</option>
                                        <option value="2">Asosiy banner - 2</option>
                                        <option value="3">Investitsiya banner</option>
                                        <option value="4">Halol banner</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <div class="banner-preview">
                                        <img src="https://via.placeholder.com/100x60" alt="Banner preview">
                                        <div class="banner-info">
                                            <h6>Tanlanmagan</h6>
                                            <p>Banner tanlang</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addBannerItem('mb-uz')">
                        <i class="fas fa-plus"></i> Yangi banner qo'shish
                    </button>
                </div>

                <!-- Russian -->
                <div class="tab-pane fade" id="mb-ru-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Заголовок</label>
                            <input type="text" class="form-control" value="Платформа халяльных инвестиций">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Описание</label>
                            <textarea class="form-control" rows="3">Envast - платформа для халяльных и безопасных инвестиций в недвижимость</textarea>
                        </div>
                    </div>

                    <div class="banner-items-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Выбор баннера</label>
                                    <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                                        <option value="" selected>Выберите баннер...</option>
                                        <option value="1">Главный баннер - 1</option>
                                        <option value="2">Главный баннер - 2</option>
                                        <option value="3">Инвестиционный баннер</option>
                                        <option value="4">Халяльный баннер</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <div class="banner-preview">
                                        <img src="https://via.placeholder.com/100x60" alt="Banner preview">
                                        <div class="banner-info">
                                            <h6>Не выбрано</h6>
                                            <p>Выберите баннер</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addBannerItem('mb-ru')">
                        <i class="fas fa-plus"></i> Добавить новый баннер
                    </button>
                </div>

                <!-- English -->
                <div class="tab-pane fade" id="mb-en-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" value="Halal Investment Platform">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3">Envast - platform for halal and secure real estate investments</textarea>
                        </div>
                    </div>

                    <div class="banner-items-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Select Banner</label>
                                    <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                                        <option value="" selected>Select banner...</option>
                                        <option value="1">Main banner - 1</option>
                                        <option value="2">Main banner - 2</option>
                                        <option value="3">Investment banner</option>
                                        <option value="4">Halal banner</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <div class="banner-preview">
                                        <img src="https://via.placeholder.com/100x60" alt="Banner preview">
                                        <div class="banner-info">
                                            <h6>Not selected</h6>
                                            <p>Select banner</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addBannerItem('mb-en')">
                        <i class="fas fa-plus"></i> Add New Banner
                    </button>
                </div>
            </div>
        </div>

        <!-- 2. Afzalliklar -->
        <div class="setting-card">
            <div class="section-header">
                <h3><i class="fas fa-star me-2"></i>Afzalliklar</h3>
                <p class="setting-description">Platformaning asosiy afzalliklari</p>
            </div>

            <!-- Language Tabs for Benefits -->
            <ul class="nav section-tabs" id="benefitsTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="bf-uz-tab" data-bs-toggle="tab" data-bs-target="#bf-uz-content" type="button" role="tab">
                        🇺🇿 O'zbek
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bf-ru-tab" data-bs-toggle="tab" data-bs-target="#bf-ru-content" type="button" role="tab">
                        🇷🇺 Русский
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="bf-en-tab" data-bs-toggle="tab" data-bs-target="#bf-en-content" type="button" role="tab">
                        🇬🇧 English
                    </button>
                </li>
            </ul>

            <!-- Benefits Language Content -->
            <div class="tab-content" id="benefitsTabContent">
                <!-- Uzbek -->
                <div class="tab-pane fade show active" id="bf-uz-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Sarlavha</label>
                            <input type="text" class="form-control" value="Nega ENVAST?">
                        </div>
                    </div>

                    <!-- Benefits Items -->
                    <div class="benefits-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Icon</label>
                                    <input type="text" class="form-control" value="fas fa-handshake" placeholder="fas fa-icon">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Sarlavha</label>
                                    <input type="text" class="form-control" value="Halol hamkorlik">
                                </div>

                                <div class="col-md-5">
                                    <label class="form-label">Tavsif</label>
                                    <input type="text" class="form-control" value="Islom olimlari tomonidan tasdiqlangan to'liq Shariatga mos investitsiyalar">
                                </div>
                            </div>
                        </div>

                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Icon</label>
                                    <input type="text" class="form-control" value="fas fa-building" placeholder="fas fa-icon">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Sarlavha</label>
                                    <input type="text" class="form-control" value="Haqiqiy ulushlar">
                                </div>

                                <div class="col-md-5">
                                    <label class="form-label">Tavsif</label>
                                    <input type="text" class="form-control" value="Binolar va yerlaming haqiqiy ulushlariga ega bo'ling">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addBenefitItem('bf-uz')">
                        <i class="fas fa-plus"></i> Yangi afzallik qo'shish
                    </button>

                    <!-- Shariatga mos investitsiya -->
                    <div class="mt-4 pt-3 border-top">
                        <h5 class="mb-3"><i class="fas fa-scale-balanced me-2"></i>Shariatga mos investitsiya</h5>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label">Asosiy tavsif</label>
                                <textarea class="form-control" rows="2">Envast'dagi har bir loyiha Shariat kengashi tomonidan sertifikatlangan. Biz bilan sarmoyangiz halol va shaffof.</textarea>
                            </div>
                        </div>

                        <!-- Principles Items -->
                        <div class="principles-container">
                            <div class="dynamic-item">
                                <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Icon</label>
                                        <input type="text" class="form-control" value="fas fa-ban" placeholder="fas fa-icon">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Sarlavha</label>
                                        <input type="text" class="form-control" value="Foizsiz (Ribo yo'q)">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Tavsif</label>
                                        <input type="text" class="form-control" value="Foydaga sheriklik modeli">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="add-new-btn" onclick="addPrincipleItem('bf-uz')">
                            <i class="fas fa-plus"></i> Yangi tamoyil qo'shish
                        </button>
                    </div>
                </div>

                <!-- Russian -->
                <div class="tab-pane fade" id="bf-ru-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Заголовок</label>
                            <input type="text" class="form-control" value="Почему ENVAST?">
                        </div>
                    </div>

                    <!-- Benefits Items -->
                    <div class="benefits-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Иконка</label>
                                    <input type="text" class="form-control" value="fas fa-handshake" placeholder="fas fa-icon">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Заголовок</label>
                                    <input type="text" class="form-control" value="Халяльное партнерство">
                                </div>

                                <div class="col-md-5">
                                    <label class="form-label">Описание</label>
                                    <input type="text" class="form-control" value="Полностью соответствующие Шариату инвестиции, одобренные исламскими учеными">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addBenefitItem('bf-ru')">
                        <i class="fas fa-plus"></i> Добавить преимущество
                    </button>

                    <!-- Shariatga mos investitsiya -->
                    <div class="mt-4 pt-3 border-top">
                        <h5 class="mb-3"><i class="fas fa-scale-balanced me-2"></i>Соответствие Шариату</h5>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label">Основное описание</label>
                                <textarea class="form-control" rows="2">Каждый проект в Envast сертифицирован Советом Шариата. С нами ваши инвестиции халяльны и прозрачны.</textarea>
                            </div>
                        </div>

                        <!-- Principles Items -->
                        <div class="principles-container">
                            <div class="dynamic-item">
                                <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Иконка</label>
                                        <input type="text" class="form-control" value="fas fa-ban" placeholder="fas fa-icon">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Заголовок</label>
                                        <input type="text" class="form-control" value="Без процентов (Нет риба)">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Описание</label>
                                        <input type="text" class="form-control" value="Модель партнерства в прибыли">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="add-new-btn" onclick="addPrincipleItem('bf-ru')">
                            <i class="fas fa-plus"></i> Добавить принцип
                        </button>
                    </div>
                </div>

                <!-- English -->
                <div class="tab-pane fade" id="bf-en-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" value="Why ENVAST?">
                        </div>
                    </div>

                    <!-- Benefits Items -->
                    <div class="benefits-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Icon</label>
                                    <input type="text" class="form-control" value="fas fa-handshake" placeholder="fas fa-icon">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" value="Halal Partnership">
                                </div>

                                <div class="col-md-5">
                                    <label class="form-label">Description</label>
                                    <input type="text" class="form-control" value="Fully Sharia-compliant investments approved by Islamic scholars">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addBenefitItem('bf-en')">
                        <i class="fas fa-plus"></i> Add New Benefit
                    </button>

                    <!-- Shariatga mos investitsiya -->
                    <div class="mt-4 pt-3 border-top">
                        <h5 class="mb-3"><i class="fas fa-scale-balanced me-2"></i>Sharia Compliance</h5>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label">Main Description</label>
                                <textarea class="form-control" rows="2">Every project in Envast is certified by the Sharia Board. With us, your investments are halal and transparent.</textarea>
                            </div>
                        </div>

                        <!-- Principles Items -->
                        <div class="principles-container">
                            <div class="dynamic-item">
                                <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Icon</label>
                                        <input type="text" class="form-control" value="fas fa-ban" placeholder="fas fa-icon">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" value="Interest-free (No Riba)">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Description</label>
                                        <input type="text" class="form-control" value="Profit-sharing partnership model">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="add-new-btn" onclick="addPrincipleItem('bf-en')">
                            <i class="fas fa-plus"></i> Add New Principle
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Sarmoya -->
        <div class="setting-card">
            <div class="section-header">
                <h3><i class="fas fa-route me-2"></i>Sarmoya</h3>
                <p class="setting-description">Sarmoya yo'li va jarayoni</p>
            </div>

            <!-- Language Tabs for Investment -->
            <ul class="nav section-tabs" id="investmentTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="inv-uz-tab" data-bs-toggle="tab" data-bs-target="#inv-uz-content" type="button" role="tab">
                        🇺🇿 O'zbek
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="inv-ru-tab" data-bs-toggle="tab" data-bs-target="#inv-ru-content" type="button" role="tab">
                        🇷🇺 Русский
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="inv-en-tab" data-bs-toggle="tab" data-bs-target="#inv-en-content" type="button" role="tab">
                        🇬🇧 English
                    </button>
                </li>
            </ul>

            <!-- Investment Language Content -->
            <div class="tab-content" id="investmentTabContent">
                <!-- Uzbek -->
                <div class="tab-pane fade show active" id="inv-uz-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Asosiy tavsif</label>
                            <textarea class="form-control" rows="2">Sizga qulay bo'lishi uchun ilovani sodda qildik: bir necha qadam, aniq jarayon va toza ma'lumot.</textarea>
                        </div>
                    </div>

                    <!-- Investment Steps -->
                    <div class="steps-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Banner tanlash</label>
                                    <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                                        <option value="" selected>Banner tanlang...</option>
                                        <option value="5">Sarmoya banner - 1</option>
                                        <option value="6">Sarmoya banner - 2</option>
                                        <option value="7">Qadamlar banner</option>
                                    </select>

                                    <div class="banner-preview mt-2">
                                        <img src="https://via.placeholder.com/100x60" alt="Banner preview">
                                        <div class="banner-info">
                                            <h6>Tanlanmagan</h6>
                                            <p>Banner tanlang</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Icon</label>
                                            <input type="text" class="form-control" value="fas fa-clipboard-list" placeholder="fas fa-icon">
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">Sarlavha</label>
                                            <input type="text" class="form-control" value="Ro'yxatdan o'tish">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Tavsif</label>
                                            <textarea class="form-control" rows="2">Envast ilovasini yuklab oling va ro'yxatdan o'ting</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addStepItem('inv-uz')">
                        <i class="fas fa-plus"></i> Yangi qadam qo'shish
                    </button>
                </div>

                <!-- Russian -->
                <div class="tab-pane fade" id="inv-ru-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Основное описание</label>
                            <textarea class="form-control" rows="2">Мы сделали приложение простым для вас: несколько шагов, четкий процесс и прозрачная информация.</textarea>
                        </div>
                    </div>

                    <!-- Investment Steps -->
                    <div class="steps-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Выбор баннера</label>
                                    <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                                        <option value="" selected>Выберите баннер...</option>
                                        <option value="5">Инвестиционный баннер - 1</option>
                                        <option value="6">Инвестиционный баннер - 2</option>
                                        <option value="7">Баннер шагов</option>
                                    </select>

                                    <div class="banner-preview mt-2">
                                        <img src="https://via.placeholder.com/100x60" alt="Banner preview">
                                        <div class="banner-info">
                                            <h6>Не выбрано</h6>
                                            <p>Выберите баннер</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Иконка</label>
                                            <input type="text" class="form-control" value="fas fa-clipboard-list" placeholder="fas fa-icon">
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">Заголовок</label>
                                            <input type="text" class="form-control" value="Регистрация">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Описание</label>
                                            <textarea class="form-control" rows="2">Скачайте приложение Envast и зарегистрируйтесь</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addStepItem('inv-ru')">
                        <i class="fas fa-plus"></i> Добавить шаг
                    </button>
                </div>

                <!-- English -->
                <div class="tab-pane fade" id="inv-en-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Main Description</label>
                            <textarea class="form-control" rows="2">We made the app simple for you: a few steps, clear process, and transparent information.</textarea>
                        </div>
                    </div>

                    <!-- Investment Steps -->
                    <div class="steps-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Select Banner</label>
                                    <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                                        <option value="" selected>Select banner...</option>
                                        <option value="5">Investment banner - 1</option>
                                        <option value="6">Investment banner - 2</option>
                                        <option value="7">Steps banner</option>
                                    </select>

                                    <div class="banner-preview mt-2">
                                        <img src="https://via.placeholder.com/100x60" alt="Banner preview">
                                        <div class="banner-info">
                                            <h6>Not selected</h6>
                                            <p>Select banner</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Icon</label>
                                            <input type="text" class="form-control" value="fas fa-clipboard-list" placeholder="fas fa-icon">
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" value="Registration">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" rows="2">Download the Envast app and register</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addStepItem('inv-en')">
                        <i class="fas fa-plus"></i> Add New Step
                    </button>
                </div>
            </div>
        </div>

        <!-- 4. Envast ilovasi -->
        <div class="setting-card">
            <div class="section-header">
                <h3><i class="fas fa-mobile-alt me-2"></i>Envast ilovasi</h3>
                <p class="setting-description">Ilovani yuklash va imkoniyatlari</p>
            </div>

            <!-- Language Tabs for App -->
            <ul class="nav section-tabs" id="appTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="app-uz-tab" data-bs-toggle="tab" data-bs-target="#app-uz-content" type="button" role="tab">
                        🇺🇿 O'zbek
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="app-ru-tab" data-bs-toggle="tab" data-bs-target="#app-ru-content" type="button" role="tab">
                        🇷🇺 Русский
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="app-en-tab" data-bs-toggle="tab" data-bs-target="#app-en-content" type="button" role="tab">
                        🇬🇧 English
                    </button>
                </li>
            </ul>

            <!-- App Language Content -->
            <div class="tab-content" id="appTabContent">
                <!-- Uzbek -->
                <div class="tab-pane fade show active" id="app-uz-content" role="tabpanel">
                    <div class="app-links-section">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Sarlavha</label>
                                    <input type="text" class="form-control" value="Ilovani yuklab oling">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tavsif</label>
                                    <textarea class="form-control" rows="3">Sizga qulay bo'lishi uchun ilovani sodda qildik: bir necha qadam, aniq jarayon va toza ma'lumot. Yuklab oling va sinab ko'ring.</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">App Store Link</label>
                                    <input type="url" class="form-control" value="https://apps.apple.com/app/envast">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Google Play Link</label>
                                    <input type="url" class="form-control" value="https://play.google.com/store/apps/details?id=com.envast">
                                </div>
                            </div>
                        </div>

                        <!-- App Features -->
                        <div class="mt-4 pt-3 border-top">
                            <h5 class="mb-3">Ilova imkoniyatlari</h5>

                            <div class="features-container">
                                <div class="dynamic-item">
                                    <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Icon</label>
                                            <input type="text" class="form-control" value="fas fa-folder-open" placeholder="fas fa-icon">
                                        </div>

                                        <div class="col-md-9">
                                            <label class="form-label">Sarlavha</label>
                                            <input type="text" class="form-control" value="Obyektlar katalogi">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="add-new-btn" onclick="addFeatureItem('app-uz')">
                                <i class="fas fa-plus"></i> Yangi imkoniyat qo'shish
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Russian -->
                <div class="tab-pane fade" id="app-ru-content" role="tabpanel">
                    <div class="app-links-section">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Заголовок</label>
                                    <input type="text" class="form-control" value="Скачайте приложение">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Описание</label>
                                    <textarea class="form-control" rows="3">Мы сделали приложение простым для вас: несколько шагов, четкий процесс и прозрачная информация. Скачайте и попробуйте.</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ссылка на App Store</label>
                                    <input type="url" class="form-control" value="https://apps.apple.com/app/envast">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Ссылка на Google Play</label>
                                    <input type="url" class="form-control" value="https://play.google.com/store/apps/details?id=com.envast">
                                </div>
                            </div>
                        </div>

                        <!-- App Features -->
                        <div class="mt-4 pt-3 border-top">
                            <h5 class="mb-3">Возможности приложения</h5>

                            <div class="features-container">
                                <div class="dynamic-item">
                                    <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Иконка</label>
                                            <input type="text" class="form-control" value="fas fa-folder-open" placeholder="fas fa-icon">
                                        </div>

                                        <div class="col-md-9">
                                            <label class="form-label">Заголовок</label>
                                            <input type="text" class="form-control" value="Каталог объектов">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="add-new-btn" onclick="addFeatureItem('app-ru')">
                                <i class="fas fa-plus"></i> Добавить возможность
                            </button>
                        </div>
                    </div>
                </div>

                <!-- English -->
                <div class="tab-pane fade" id="app-en-content" role="tabpanel">
                    <div class="app-links-section">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" value="Download the App">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" rows="3">We made the app simple for you: a few steps, clear process, and transparent information. Download and try it.</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">App Store Link</label>
                                    <input type="url" class="form-control" value="https://apps.apple.com/app/envast">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Google Play Link</label>
                                    <input type="url" class="form-control" value="https://play.google.com/store/apps/details?id=com.envast">
                                </div>
                            </div>
                        </div>

                        <!-- App Features -->
                        <div class="mt-4 pt-3 border-top">
                            <h5 class="mb-3">App Features</h5>

                            <div class="features-container">
                                <div class="dynamic-item">
                                    <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Icon</label>
                                            <input type="text" class="form-control" value="fas fa-folder-open" placeholder="fas fa-icon">
                                        </div>

                                        <div class="col-md-9">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" value="Objects Catalog">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="add-new-btn" onclick="addFeatureItem('app-en')">
                                <i class="fas fa-plus"></i> Add New Feature
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="form-text">
                Oxirgi o'zgarish: 2023-yil 15-oktabr, 14:30
            </div>


            <button type="button" class="btn btn-primary" id="saveSettingsBtn">
                <i class="fas fa-save me-1"></i>Sazlamalarni saqlash
            </button>
        </div>


    </div>
</div>

<!-- Templates -->
<template id="banner-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Banner tanlash</label>
                <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                    <option value="" selected>Banner tanlang...</option>
                    <option value="1">Yangi banner</option>
                    <option value="2">Asosiy banner - 2</option>
                    <option value="3">Investitsiya banner</option>
                    <option value="4">Halol banner</option>
                </select>
            </div>

            <div class="col-md-6">
                <div class="banner-preview">
                    <img src="https://via.placeholder.com/100x60" alt="Banner preview">
                    <div class="banner-info">
                        <h6>Tanlanmagan</h6>
                        <p>Banner tanlang</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<template id="benefit-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row">
            <div class="col-md-3">
                <label class="form-label">Icon</label>
                <input type="text" class="form-control" placeholder="fas fa-icon">
            </div>

            <div class="col-md-4">
                <label class="form-label">Sarlavha</label>
                <input type="text" class="form-control" placeholder="Afzallik nomi">
            </div>

            <div class="col-md-5">
                <label class="form-label">Tavsif</label>
                <input type="text" class="form-control" placeholder="Afzallik tavsifi">
            </div>
        </div>
    </div>
</template>

<template id="principle-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row">
            <div class="col-md-3">
                <label class="form-label">Icon</label>
                <input type="text" class="form-control" placeholder="fas fa-icon">
            </div>

            <div class="col-md-3">
                <label class="form-label">Sarlavha</label>
                <input type="text" class="form-control" placeholder="Tamoyil nomi">
            </div>

            <div class="col-md-6">
                <label class="form-label">Tavsif</label>
                <input type="text" class="form-control" placeholder="Tamoyil tavsifi">
            </div>
        </div>
    </div>
</template>

<template id="step-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Banner tanlash</label>
                <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                    <option value="" selected>Banner tanlang...</option>
                    <option value="5">Sarmoya banner - 1</option>
                    <option value="6">Sarmoya banner - 2</option>
                    <option value="7">Qadamlar banner</option>
                </select>

                <div class="banner-preview mt-2">
                    <img src="https://via.placeholder.com/100x60" alt="Banner preview">
                    <div class="banner-info">
                        <h6>Tanlanmagan</h6>
                        <p>Banner tanlang</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Icon</label>
                        <input type="text" class="form-control" placeholder="fas fa-icon">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Sarlavha</label>
                        <input type="text" class="form-control" placeholder="Qadam nomi">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Tavsif</label>
                        <textarea class="form-control" rows="2" placeholder="Qadam tavsifi"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<template id="feature-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row">
            <div class="col-md-3">
                <label class="form-label">Icon</label>
                <input type="text" class="form-control" placeholder="fas fa-icon">
            </div>

            <div class="col-md-9">
                <label class="form-label">Sarlavha</label>
                <input type="text" class="form-control" placeholder="Imkoniyat nomi">
            </div>
        </div>
    </div>
</template>
@endsection

@push('customJs')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap tabs
        const tabTriggers = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabTriggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                const target = this.getAttribute('data-bs-target');
                const tabContent = document.querySelector(target);
                if (tabContent) {
                    // Update all active tabs in this section
                    const parent = this.closest('.section-tabs');
                    if (parent) {
                        parent.querySelectorAll('.nav-link').forEach(link => {
                            link.classList.remove('active');
                        });
                        this.classList.add('active');
                    }
                }
            });
        });

        // Banner preview update function
        window.updateBannerPreview = function(select) {
            const previewContainer = select.closest('.row').querySelector('.banner-preview');
            if (!previewContainer) return;

            const img = previewContainer.querySelector('img');
            const title = previewContainer.querySelector('h6');
            const description = previewContainer.querySelector('p');

            const banners = {
                '1': {
                    img: 'https://via.placeholder.com/100x60/4361ee/ffffff',
                    title: 'Asosiy banner - 1',
                    desc: '1920×800 px'
                },
                '2': {
                    img: 'https://via.placeholder.com/100x60/10b981/ffffff',
                    title: 'Asosiy banner - 2',
                    desc: '1920×800 px'
                },
                '3': {
                    img: 'https://via.placeholder.com/100x60/3a56d4/ffffff',
                    title: 'Investitsiya banner',
                    desc: '1920×800 px'
                },
                '4': {
                    img: 'https://via.placeholder.com/100x60/2ecc71/ffffff',
                    title: 'Halol banner',
                    desc: '1920×800 px'
                },
                '5': {
                    img: 'https://via.placeholder.com/100x60/9b59b6/ffffff',
                    title: 'Sarmoya banner - 1',
                    desc: '1920×800 px'
                },
                '6': {
                    img: 'https://via.placeholder.com/100x60/f39c12/ffffff',
                    title: 'Sarmoya banner - 2',
                    desc: '1920×800 px'
                },
                '7': {
                    img: 'https://via.placeholder.com/100x60/e74c3c/ffffff',
                    title: 'Qadamlar banner',
                    desc: '1920×800 px'
                }
            };

            if (select.value && banners[select.value]) {
                img.src = banners[select.value].img;
                title.textContent = banners[select.value].title;
                description.textContent = banners[select.value].desc;
            } else {
                img.src = 'https://via.placeholder.com/100x60';
                title.textContent = 'Tanlanmagan';
                description.textContent = 'Banner tanlang';
            }
        };

        // Show remove confirmation
        window.showRemoveConfirmation = function(button) {
            // Just remove without confirmation for demo purposes
            const item = button.closest('.dynamic-item');
            if (item) {
                item.remove();
            }
        };

        // Add banner item
        window.addBannerItem = function(tabId) {
            const template = document.getElementById('banner-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabId + '-content');
            if (!tabContent) return;

            const addButton = tabContent.querySelector('.add-new-btn');
            if (addButton) {
                // Add before the button
                const container = tabContent.querySelector('.banner-items-container') || tabContent;
                if (container) {
                    addButton.before(clone);
                }
            }
        };

        // Add benefit item
        window.addBenefitItem = function(tabId) {
            const template = document.getElementById('benefit-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabId + '-content');
            if (!tabContent) return;

            const addButton = tabContent.querySelector('.add-new-btn');
            if (addButton) {
                const container = tabContent.querySelector('.benefits-container') || tabContent;
                if (container) {
                    addButton.before(clone);
                }
            }
        };

        // Add principle item
        window.addPrincipleItem = function(tabId) {
            const template = document.getElementById('principle-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabId + '-content');
            if (!tabContent) return;

            const addButton = tabContent.querySelector('[onclick*="addPrincipleItem"]');
            if (addButton) {
                const container = tabContent.querySelector('.principles-container') || tabContent;
                if (container) {
                    addButton.before(clone);
                }
            }
        };

        // Add step item
        window.addStepItem = function(tabId) {
            const template = document.getElementById('step-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabId + '-content');
            if (!tabContent) return;

            const addButton = tabContent.querySelector('.add-new-btn');
            if (addButton) {
                const container = tabContent.querySelector('.steps-container') || tabContent;
                if (container) {
                    addButton.before(clone);

                    // Initialize banner preview for the new item
                    const newSelect = container.querySelector('.dynamic-item:last-child .banner-select');
                    if (newSelect) {
                        newSelect.addEventListener('change', function() {
                            updateBannerPreview(this);
                        });
                    }
                }
            }
        };

        // Add feature item
        window.addFeatureItem = function(tabId) {
            const template = document.getElementById('feature-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabId + '-content');
            if (!tabContent) return;

            const addButton = tabContent.querySelector('[onclick*="addFeatureItem"]');
            if (addButton) {
                const container = tabContent.querySelector('.features-container') || tabContent;
                if (container) {
                    addButton.before(clone);
                }
            }
        };

        // Save button click - just show notification
        const saveBtn = document.querySelector('.save-btn');
        saveBtn.addEventListener('click', function() {
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Saqlanmoqda...';
            saveBtn.disabled = true;

            // Simulate save process
            setTimeout(function() {
                saveBtn.innerHTML = '<i class="fas fa-check me-1"></i>Sozlamalar saqlandi!';
                saveBtn.classList.remove('btn-primary');
                saveBtn.classList.add('btn-success');

                // Show simple alert instead of toast
                alert('Sozlamalar muvaffaqiyatli saqlandi (demo rejim)');

                setTimeout(function() {
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                    saveBtn.classList.remove('btn-success');
                    saveBtn.classList.add('btn-primary');
                }, 2000);
            }, 1000);
        });

        // Initialize all banner previews
        document.querySelectorAll('.banner-select').forEach(select => {
            select.addEventListener('change', function() {
                updateBannerPreview(this);
            });
        });
    });
</script>
@endpush