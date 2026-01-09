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

    /* Team Member Preview */
    .team-member-preview {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.5rem;
        padding: 0.5rem;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
    }

    .team-member-preview img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .team-member-info {
        flex: 1;
    }

    .team-member-info h6 {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .team-member-info p {
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

    /* Index input uchun max-width */
    .index-input {
        max-width: 100px;
    }

    /* Icon input uchun max-width */
    .icon-input {
        max-width: 100%;
    }

    /* Value items uchun responsive */
    .values-container .row {
        align-items: flex-start;
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
                    Biz haqimizda
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
            <i class="fas fa-info-circle me-2"></i>Biz haqimizda sahifasi
        </h1>

        <div class="info-badge">
            <i class="fas fa-info-circle"></i>
            «Envast» kompaniyasi haqida ma'lumotlar va jamoa a'zolari.
        </div>

        <!-- 1. Asosiy banner -->
        <div class="setting-card">
            <div class="section-header">
                <h3><i class="fas fa-image me-2"></i>Asosiy banner</h3>
                <p class="setting-description">Sahifaning yuqori qismidagi asosiy banner</p>
            </div>

            <!-- Language Tabs for Main Banner -->
            <ul class="nav section-tabs" id="aboutBannerTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="ab-uz-tab" data-bs-toggle="tab" data-bs-target="#ab-uz-content" type="button" role="tab">
                        🇺🇿 O'zbek
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="ab-ru-tab" data-bs-toggle="tab" data-bs-target="#ab-ru-content" type="button" role="tab">
                        🇷🇺 Русский
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="ab-en-tab" data-bs-toggle="tab" data-bs-target="#ab-en-content" type="button" role="tab">
                        🇬🇧 English
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="aboutBannerTabContent">
                <!-- Uzbek -->
                <div class="tab-pane fade show active" id="ab-uz-content" role="tabpanel">
                    <div class="banner-items-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Banner tanlash</label>
                                    <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                                        <option value="" selected>Banner tanlang...</option>
                                        <option value="about1">Biz haqimizda banner - 1</option>
                                        <option value="about2">Biz haqimizda banner - 2</option>
                                        <option value="about3">Jamoa banner</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <div class="banner-preview">
                                        <img src="{{ asset('assets/img/default.jpg') }}" alt="Banner preview">
                                        <div class="banner-info">
                                            <h6>Tanlanmagan</h6>
                                            <p>Banner tanlang</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addAboutBannerItem('ab-uz-content')">
                        <i class="fas fa-plus"></i> Yangi banner qo'shish
                    </button>

                    <!-- Title + Description Section -->
                    <div class="title-description-container mt-4">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Sarlavha</label>
                                        <input type="text" class="form-control" value="Envast haqida">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Tavsif</label>
                                        <textarea class="form-control" rows="3">2015-yildan beri xavfsiz va halol investitsiyalarni taqdim etib kelmoqdamiz</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addAboutTitleItem('ab-uz-content')">
                        <i class="fas fa-plus"></i> Yangi sarlavha qo'shish
                    </button>
                </div>

                <!-- Russian -->
                <div class="tab-pane fade" id="ab-ru-content" role="tabpanel">
                    <div class="banner-items-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Выбор баннера</label>
                                    <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                                        <option value="" selected>Выберите баннер...</option>
                                        <option value="about1">Баннер о нас - 1</option>
                                        <option value="about2">Баннер о нас - 2</option>
                                        <option value="about3">Баннер команды</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <div class="banner-preview">
                                        <img src="{{ asset('assets/img/default.jpg') }}" alt="Banner preview">
                                        <div class="banner-info">
                                            <h6>Не выбрано</h6>
                                            <p>Выберите баннер</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addAboutBannerItem('ab-ru-content')">
                        <i class="fas fa-plus"></i> Добавить новый баннер
                    </button>

                    <!-- Title + Description Section -->
                    <div class="title-description-container mt-4">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Заголовок</label>
                                        <input type="text" class="form-control" value="О Envast">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Описание</label>
                                        <textarea class="form-control" rows="3">Предоставляем безопасные и халяльные инвестиции с 2015 года</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addAboutTitleItem('ab-ru-content')">
                        <i class="fas fa-plus"></i> Добавить заголовок
                    </button>
                </div>

                <!-- English -->
                <div class="tab-pane fade" id="ab-en-content" role="tabpanel">
                    <div class="banner-items-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Select Banner</label>
                                    <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                                        <option value="" selected>Select banner...</option>
                                        <option value="about1">About Us banner - 1</option>
                                        <option value="about2">About Us banner - 2</option>
                                        <option value="about3">Team banner</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <div class="banner-preview">
                                        <img src="{{ asset('assets/img/default.jpg') }}" alt="Banner preview">
                                        <div class="banner-info">
                                            <h6>Not selected</h6>
                                            <p>Select banner</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addAboutBannerItem('ab-en-content')">
                        <i class="fas fa-plus"></i> Add New Banner
                    </button>

                    <!-- Title + Description Section -->
                    <div class="title-description-container mt-4">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" value="About Envast">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" rows="3">Providing secure and halal investments since 2015</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addAboutTitleItem('ab-en-content')">
                        <i class="fas fa-plus"></i> Add New Title
                    </button>
                </div>
            </div>
        </div>

        <!-- 2. Qadriyatlar -->
        <div class="setting-card">
            <div class="section-header">
                <h3><i class="fas fa-heart me-2"></i>Qadriyatlar</h3>
                <p class="setting-description">Kompaniya qadriyatlari va tamoyillari</p>
            </div>

            <!-- Language Tabs for Values -->
            <ul class="nav section-tabs" id="valuesTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="val-uz-tab" data-bs-toggle="tab" data-bs-target="#val-uz-content" type="button" role="tab">
                        🇺🇿 O'zbek
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="val-ru-tab" data-bs-toggle="tab" data-bs-target="#val-ru-content" type="button" role="tab">
                        🇷🇺 Русский
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="val-en-tab" data-bs-toggle="tab" data-bs-target="#val-en-content" type="button" role="tab">
                        🇬🇧 English
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="valuesTabContent">
                <!-- Uzbek -->
                <div class="tab-pane fade show active" id="val-uz-content" role="tabpanel">
                    <div class="values-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Icon</label>
                                        <input type="file" class="form-control icon-input" value="fas fa-hands-helping" placeholder="fas fa-icon">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Index</label>
                                        <input type="number" class="form-control" value="1" min="1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Sarlavha</label>
                                        <input type="text" class="form-control" value="Halollik">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Tavsif</label>
                                        <textarea class="form-control" rows="2">Barcha operatsiyalar Shariat qonunlariga to'liq mos keladi</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Icon</label>
                                        <input type="file" class="form-control icon-input" value="fas fa-eye" placeholder="fas fa-icon">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Index</label>
                                        <input type="number" class="form-control" value="2" min="1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Sarlavha</label>
                                        <input type="text" class="form-control" value="Shaffoflik">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Tavsif</label>
                                        <textarea class="form-control" rows="2">Har bir investitsiya harakatini ochiq va tushunarli qilamiz</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addValueItem('val-uz-content')">
                        <i class="fas fa-plus"></i> Yangi qadriyat qo'shish
                    </button>
                </div>

                <!-- Russian -->
                <div class="tab-pane fade" id="val-ru-content" role="tabpanel">
                    <div class="values-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Иконка</label>
                                        <input type="file" class="form-control icon-input" value="fas fa-hands-helping" placeholder="fas fa-icon">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="mb-3">
                                        <label class="form-label">Индекс</label>
                                        <input type="number" class="form-control index-input" value="1" min="1">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Заголовок</label>
                                        <input type="text" class="form-control" value="Халяльность">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Должность</label>
                                        <input type="text" class="form-control" value="Руководитель">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Описание</label>
                                        <textarea class="form-control" rows="2">Все операции полностью соответствуют законам Шариата</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addValueItem('val-ru-content')">
                        <i class="fas fa-plus"></i> Добавить ценность
                    </button>
                </div>

                <!-- English -->
                <div class="tab-pane fade" id="val-en-content" role="tabpanel">
                    <div class="values-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <label class="form-label">Icon</label>
                                        <input type="file" class="form-control icon-input" value="fas fa-hands-helping" placeholder="fas fa-icon">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="mb-3">
                                        <label class="form-label">Index</label>
                                        <input type="number" class="form-control index-input" value="1" min="1">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" value="Halal">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Position</label>
                                        <input type="text" class="form-control" value="Manager">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" rows="2">All operations fully comply with Sharia laws</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addValueItem('val-en-content')">
                        <i class="fas fa-plus"></i> Add New Value
                    </button>
                </div>
            </div>
        </div>

        <!-- 3. Bizning Jamoa -->
        <div class="setting-card">
            <div class="section-header">
                <h3><i class="fas fa-users me-2"></i>Bizning Jamoa</h3>
                <p class="setting-description">Kompaniya rahbarlari va mutaxassislari</p>
            </div>

            <!-- Language Tabs for Team -->
            <ul class="nav section-tabs" id="teamTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="team-uz-tab" data-bs-toggle="tab" data-bs-target="#team-uz-content" type="button" role="tab">
                        🇺🇿 O'zbek
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="team-ru-tab" data-bs-toggle="tab" data-bs-target="#team-ru-content" type="button" role="tab">
                        🇷🇺 Русский
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="team-en-tab" data-bs-toggle="tab" data-bs-target="#team-en-content" type="button" role="tab">
                        🇬🇧 English
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="teamTabContent">
                <!-- Uzbek -->
                <div class="tab-pane fade show active" id="team-uz-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Asosiy tavsif</label>
                            <textarea class="form-control" rows="3">Envast jamoasi - turli sohalardan kelgan tajribali mutaxassislar jamlanmasi bo'lib, ular har bir investorga eng yaxshi xizmatni ko'rsatish uchun birgalikda ishlashmoqda.</textarea>
                        </div>
                    </div>

                    <div class="team-members-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Jamoa a'zosi</label>
                                        <select class="form-select team-member-select" onchange="updateTeamMemberPreview(this)">
                                            <option value="" selected>A'zo tanlang...</option>
                                            <option value="1">Aliyev Sanjar</option>
                                            <option value="2">Karimova Zulfiya</option>
                                            <option value="3">Ismoilov Jahongir</option>
                                            <option value="4">Yusupova Malika</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="team-member-preview">
                                        <img src="{{ asset('assets/img/default.jpg') }}" alt="Team member">
                                        <div class="team-member-info">
                                            <h6>Tanlanmagan</h6>
                                            <p>A'zo tanlang</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addTeamMemberItem('team-uz-content')">
                        <i class="fas fa-plus"></i> Yangi jamoa a'zosi qo'shish
                    </button>
                </div>

                <!-- Russian -->
                <div class="tab-pane fade" id="team-ru-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Основное описание</label>
                            <textarea class="form-control" rows="3">Команда Envast - это собрание опытных специалистов из разных областей, которые работают вместе, чтобы предоставить каждому инвестору лучший сервис.</textarea>
                        </div>
                    </div>

                    <div class="team-members-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Член команды</label>
                                        <select class="form-select team-member-select" onchange="updateTeamMemberPreview(this)">
                                            <option value="" selected>Выберите члена...</option>
                                            <option value="1">Алиев Санжар</option>
                                            <option value="2">Каримова Зульфия</option>
                                            <option value="3">Исмоилов Жахонгир</option>
                                            <option value="4">Юсупова Малика</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="team-member-preview">
                                        <img src="{{ asset('assets/img/default.jpg') }}" alt="Team member">
                                        <div class="team-member-info">
                                            <h6>Не выбрано</h6>
                                            <p>Выберите члена</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addTeamMemberItem('team-ru-content')">
                        <i class="fas fa-plus"></i> Добавить члена команды
                    </button>
                </div>

                <!-- English -->
                <div class="tab-pane fade" id="team-en-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Main Description</label>
                            <textarea class="form-control" rows="3">The Envast team is a gathering of experienced specialists from various fields who work together to provide the best service to each investor.</textarea>
                        </div>
                    </div>

                    <div class="team-members-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Team Member</label>
                                        <select class="form-select team-member-select" onchange="updateTeamMemberPreview(this)">
                                            <option value="" selected>Select member...</option>
                                            <option value="1">Aliyev Sanjar</option>
                                            <option value="2">Karimova Zulfiya</option>
                                            <option value="3">Ismoilov Jahongir</option>
                                            <option value="4">Yusupova Malika</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="team-member-preview">
                                        <img src="{{ asset('assets/img/default.jpg') }}" alt="Team member">
                                        <div class="team-member-info">
                                            <h6>Not selected</h6>
                                            <p>Select member</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addTeamMemberItem('team-en-content')">
                        <i class="fas fa-plus"></i> Add New Team Member
                    </button>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="form-text">
                Oxirgi o'zgarish: 2023-yil 15-oktabr, 14:30
            </div>

            <button type="button" class="btn btn-primary save-btn" id="saveSettingsBtn">
                <i class="fas fa-save me-1"></i>Sazlamalarni saqlash
            </button>
        </div>
    </div>
</div>

<!-- Templates -->
<template id="about-banner-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Banner tanlash</label>
                <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                    <option value="" selected>Banner tanlang...</option>
                    <option value="about1">Biz haqimizda banner - 1</option>
                    <option value="about2">Biz haqimizda banner - 2</option>
                    <option value="about3">Jamoa banner</option>
                </select>
            </div>

            <div class="col-md-6">
                <div class="banner-preview">
                    <img src="{{ asset('assets/img/default.jpg') }}" alt="Banner preview">
                    <div class="banner-info">
                        <h6>Tanlanmagan</h6>
                        <p>Banner tanlang</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<template id="about-title-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Sarlavha</label>
                    <input type="text" class="form-control" placeholder="Sarlavha">
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Tavsif</label>
                    <textarea class="form-control" rows="3" placeholder="Tavsif"></textarea>
                </div>
            </div>
        </div>
    </div>
</template>

<template id="value-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Icon</label>
                    <input type="file" class="form-control icon-input" placeholder="fas fa-icon">
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Index</label>
                    <input type="number" class="form-control" value="1" min="1">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Sarlavha</label>
                    <input type="text" class="form-control" placeholder="Qadriyat nomi">
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Tavsif</label>
                    <textarea class="form-control" rows="2" placeholder="Qadriyat tavsifi"></textarea>
                </div>
            </div>
        </div>
    </div>
</template>

<template id="team-member-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Jamoa a'zosi</label>
                    <select class="form-select team-member-select" onchange="updateTeamMemberPreview(this)">
                        <option value="" selected>A'zo tanlang...</option>
                        <option value="1">Aliyev Sanjar</option>
                        <option value="2">Karimova Zulfiya</option>
                        <option value="3">Ismoilov Jahongir</option>
                        <option value="4">Yusupova Malika</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="team-member-preview">
                    <img src="{{ asset('assets/img/default.jpg') }}" alt="Team member">
                    <div class="team-member-info">
                        <h6>Tanlanmagan</h6>
                        <p>A'zo tanlang</p>
                    </div>
                </div>
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
                'about1': {
                    img: 'https://via.placeholder.com/100x60/4361ee/ffffff',
                    title: 'Biz haqimizda banner - 1',
                    desc: '1920×800 px'
                },
                'about2': {
                    img: 'https://via.placeholder.com/100x60/10b981/ffffff',
                    title: 'Biz haqimizda banner - 2',
                    desc: '1920×800 px'
                },
                'about3': {
                    img: 'https://via.placeholder.com/100x60/3a56d4/ffffff',
                    title: 'Jamoa banner',
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

        // Team member preview update function
        window.updateTeamMemberPreview = function(select) {
            const previewContainer = select.closest('.row').querySelector('.team-member-preview');
            if (!previewContainer) return;

            const img = previewContainer.querySelector('img');
            const title = previewContainer.querySelector('h6');
            const description = previewContainer.querySelector('p');

            const teamMembers = {
                '1': {
                    img: 'https://via.placeholder.com/50x50/4361ee/ffffff',
                    name: 'Aliyev Sanjar',
                    position: 'Bosh direktor'
                },
                '2': {
                    img: 'https://via.placeholder.com/50x50/10b981/ffffff',
                    name: 'Karimova Zulfiya',
                    position: 'Moliyaviy direktori'
                },
                '3': {
                    img: 'https://via.placeholder.com/50x50/3a56d4/ffffff',
                    name: 'Ismoilov Jahongir',
                    position: 'Texnik direktori'
                },
                '4': {
                    img: 'https://via.placeholder.com/50x50/9b59b6/ffffff',
                    name: 'Yusupova Malika',
                    position: 'Marketing menejeri'
                }
            };

            if (select.value && teamMembers[select.value]) {
                img.src = teamMembers[select.value].img;
                title.textContent = teamMembers[select.value].name;
                description.textContent = teamMembers[select.value].position;
            } else {
                img.src = 'https://via.placeholder.com/50x50';
                title.textContent = 'Tanlanmagan';
                description.textContent = 'A\'zo tanlang';
            }
        };

        // Show remove confirmation
        window.showRemoveConfirmation = function(button) {
            const item = button.closest('.dynamic-item');
            if (item) {
                item.remove();
            }
        };

        // Add about banner item
        window.addAboutBannerItem = function(tabContentId) {
            const template = document.getElementById('about-banner-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabContentId);
            if (!tabContent) return;

            const addButton = tabContent.querySelector('[onclick*="addAboutBannerItem"]');
            if (addButton) {
                const container = tabContent.querySelector('.banner-items-container') || tabContent;
                if (container) {
                    addButton.before(clone);
                }
            }
        };

        // Add about title item
        window.addAboutTitleItem = function(tabContentId) {
            const template = document.getElementById('about-title-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabContentId);
            if (!tabContent) return;

            const addButton = tabContent.querySelector('[onclick*="addAboutTitleItem"]');
            if (addButton) {
                const container = tabContent.querySelector('.title-description-container') || tabContent;
                if (container) {
                    addButton.before(clone);
                }
            }
        };

        // Add value item
        window.addValueItem = function(tabContentId) {
            const template = document.getElementById('value-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabContentId);
            if (!tabContent) return;

            const addButton = tabContent.querySelector('[onclick*="addValueItem"]');
            if (addButton) {
                const container = tabContent.querySelector('.values-container') || tabContent;
                if (container) {
                    addButton.before(clone);
                }
            }
        };

        // Add team member item
        window.addTeamMemberItem = function(tabContentId) {
            const template = document.getElementById('team-member-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabContentId);
            if (!tabContent) return;

            const addButton = tabContent.querySelector('[onclick*="addTeamMemberItem"]');
            if (addButton) {
                const container = tabContent.querySelector('.team-members-container') || tabContent;
                if (container) {
                    addButton.before(clone);
                }
            }
        };

        // Save button click
        const saveBtn = document.getElementById('saveSettingsBtn');
        saveBtn.addEventListener('click', function() {
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Saqlanmoqda...';
            saveBtn.disabled = true;

            // Simulate save process
            setTimeout(function() {
                saveBtn.innerHTML = '<i class="fas fa-check me-1"></i>Sozlamalar saqlandi!';
                saveBtn.classList.remove('btn-primary');
                saveBtn.classList.add('btn-success');

                alert('"Biz haqimizda" sahifasi sozlamalari saqlandi');

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

        // Initialize all team member previews
        document.querySelectorAll('.team-member-select').forEach(select => {
            select.addEventListener('change', function() {
                updateTeamMemberPreview(this);
            });
        });
    });
</script>
@endpush