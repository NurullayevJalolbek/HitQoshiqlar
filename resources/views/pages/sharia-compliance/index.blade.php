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

    /* User Preview */
    .user-preview {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 0.5rem;
        padding: 0.5rem;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
    }

    .user-preview img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .user-info {
        flex: 1;
    }

    .user-info h6 {
        margin: 0;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .user-info p {
        margin: 0;
        font-size: 0.8rem;
        color: #6c757d;
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

    /* Status select */
    .status-select {
        max-width: 200px;
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
                    Shariatga muvofiqlik
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
            <i class="fas fa-scale-balanced me-2"></i>Shariatga muvofiqlik sahifasi
        </h1>

        <div class="info-badge">
            <i class="fas fa-info-circle"></i>
            «Envast» platformasining Shariat qonunlariga muvofiqligi va halol investitsiya tamoyillari.
        </div>

        <!-- 1. Asosiy banner -->
        <div class="setting-card">
            <div class="section-header">
                <h3><i class="fas fa-image me-2"></i>Asosiy banner</h3>
                <p class="setting-description">Sahifaning yuqori qismidagi asosiy banner</p>
            </div>

            <!-- Language Tabs for Main Banner -->
            <ul class="nav section-tabs" id="shariaBannerTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="shb-uz-tab" data-bs-toggle="tab" data-bs-target="#shb-uz-content" type="button" role="tab">
                        🇺🇿 O'zbek
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="shb-ru-tab" data-bs-toggle="tab" data-bs-target="#shb-ru-content" type="button" role="tab">
                        🇷🇺 Русский
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="shb-en-tab" data-bs-toggle="tab" data-bs-target="#shb-en-content" type="button" role="tab">
                        🇬🇧 English
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="shariaBannerTabContent">
                <!-- Uzbek -->
                <div class="tab-pane fade show active" id="shb-uz-content" role="tabpanel">
                    <div class="banner-items-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Banner tanlash</label>
                                    <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                                        <option value="" selected>Banner tanlang...</option>
                                        <option value="sharia1">Shariat banner - 1</option>
                                        <option value="sharia2">Shariat banner - 2</option>
                                        <option value="sharia3">Halol banner</option>
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

                    <button type="button" class="add-new-btn" onclick="addShariaBannerItem('shb-uz-content')">
                        <i class="fas fa-plus"></i> Yangi banner qo'shish
                    </button>
                </div>

                <!-- Russian -->
                <div class="tab-pane fade" id="shb-ru-content" role="tabpanel">
                    <div class="banner-items-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Выбор баннера</label>
                                    <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                                        <option value="" selected>Выберите баннер...</option>
                                        <option value="sharia1">Баннер Шариата - 1</option>
                                        <option value="sharia2">Баннер Шариата - 2</option>
                                        <option value="sharia3">Халяльный баннер</option>
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

                    <button type="button" class="add-new-btn" onclick="addShariaBannerItem('shb-ru-content')">
                        <i class="fas fa-plus"></i> Добавить новый баннер
                    </button>
                </div>

                <!-- English -->
                <div class="tab-pane fade" id="shb-en-content" role="tabpanel">
                    <div class="banner-items-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Select Banner</label>
                                    <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                                        <option value="" selected>Select banner...</option>
                                        <option value="sharia1">Sharia banner - 1</option>
                                        <option value="sharia2">Sharia banner - 2</option>
                                        <option value="sharia3">Halal banner</option>
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

                    <button type="button" class="add-new-btn" onclick="addShariaBannerItem('shb-en-content')">
                        <i class="fas fa-plus"></i> Add New Banner
                    </button>
                </div>
            </div>
        </div>

        <!-- 2. Shariat Asoslari -->
        <div class="setting-card">
            <div class="section-header">
                <h3><i class="fas fa-book-quran me-2"></i>Shariat Asoslari</h3>
                <p class="setting-description">Shariat qonunlarining asosiy tamoyillari</p>
            </div>

            <!-- Language Tabs for Sharia Principles -->
            <ul class="nav section-tabs" id="shariaPrinciplesTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="sp-uz-tab" data-bs-toggle="tab" data-bs-target="#sp-uz-content" type="button" role="tab">
                        🇺🇿 O'zbek
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sp-ru-tab" data-bs-toggle="tab" data-bs-target="#sp-ru-content" type="button" role="tab">
                        🇷🇺 Русский
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sp-en-tab" data-bs-toggle="tab" data-bs-target="#sp-en-content" type="button" role="tab">
                        🇬🇧 English
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="shariaPrinciplesTabContent">
                <!-- Uzbek -->
                <div class="tab-pane fade show active" id="sp-uz-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Sarlavha</label>
                            <input type="text" class="form-control" value="Shariat Asoslari">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Tavsif</label>
                            <textarea class="form-control" rows="3">Envast platformasi Islom moliyaviy qonunlariga qat'iy rioya qiladi va barcha operatsiyalar Shariat kengashi tomonidan tekshiriladi.</textarea>
                        </div>
                    </div>

                    <!-- Principles Items -->
                    <div class="principles-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Icon</label>
                                        <input type="file" class="form-control" value="fas fa-ban">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Tamoyil turi</label>
                                        <select class="form-select">
                                            <option value="halol" selected>Halol tamoyillar</option>
                                            <option value="harom">Harom tamoyillar</option>
                                            <option value="asosiy">Asosiy tamoyillar</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Sarlavha</label>
                                        <input type="text" class="form-control" value="Foizsiz (Ribo yo'q)">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Tavsif</label>
                                        <textarea class="form-control" rows="3">Barcha moliyaviy operatsiyalar foizsiz asosda amalga oshiriladi. Faqat foyda ulushiga asoslangan sheriklik modeli qo'llaniladi.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addShariaPrincipleItem('sp-uz-content')">
                        <i class="fas fa-plus"></i> Yangi tamoyil qo'shish
                    </button>

                    <!-- Shariat asoslari banneri -->
                    <div class="mt-4 pt-3 border-top">
                        <h5 class="mb-3"><i class="fas fa-image me-2"></i>Shariat asoslari banneri</h5>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label">Asosiy sarlavha</label>
                                <input type="text" class="form-control" value="Shariat qonunlari">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">Asosiy tavsif</label>
                                <textarea class="form-control" rows="3">Barcha operatsiyalar Islom moliyaviy qonunlariga qat'iy rioya qiladi</textarea>
                            </div>
                        </div>

                        <div class="sharia-principles-banner-container">
                            <div class="dynamic-item">
                                <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Icon</label>
                                            <input type="file" class="form-control" value="fas fa-book">
                                        </div>
                                    </div>

                                    <div class="col-md-10">
                                        <div class="mb-3">
                                            <label class="form-label">Sarlavha</label>
                                            <input type="text" class="form-control" value="Qur'an va Sunna">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="add-new-btn" onclick="addShariaPrinciplesBannerItem('sp-uz-content')">
                            <i class="fas fa-plus"></i> Yangi element qo'shish
                        </button>
                    </div>
                </div>

                <!-- Russian -->
                <div class="tab-pane fade" id="sp-ru-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Заголовок</label>
                            <input type="text" class="form-control" value="Основы Шариата">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Описание</label>
                            <textarea class="form-control" rows="3">Платформа Envast строго соблюдает исламские финансовые законы, и все операции проверяются Советом Шариата.</textarea>
                        </div>
                    </div>

                    <!-- Principles Items -->
                    <div class="principles-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Иконка</label>
                                        <input type="file" class="form-control" value="fas fa-ban">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Тип принципа</label>
                                        <select class="form-select">
                                            <option value="halol" selected>Халяльные принципы</option>
                                            <option value="harom">Харамные принципы</option>
                                            <option value="asosiy">Основные принципы</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Заголовок</label>
                                        <input type="text" class="form-control" value="Без процентов (Нет риба)">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Описание</label>
                                        <textarea class="form-control" rows="3">Все финансовые операции осуществляются на беспроцентной основе. Используется только модель партнерства, основанная на разделении прибыли.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addShariaPrincipleItem('sp-ru-content')">
                        <i class="fas fa-plus"></i> Добавить принцип
                    </button>

                    <!-- Shariat asoslari banneri -->
                    <div class="mt-4 pt-3 border-top">
                        <h5 class="mb-3"><i class="fas fa-image me-2"></i>Баннер основ Шариата</h5>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label">Основной заголовок</label>
                                <input type="text" class="form-control" value="Законы Шариата">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">Основное описание</label>
                                <textarea class="form-control" rows="3">Все операции строго соответствуют исламским финансовым законам</textarea>
                            </div>
                        </div>

                        <div class="sharia-principles-banner-container">
                            <div class="dynamic-item">
                                <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Иконка</label>
                                            <input type="file" class="form-control" value="fas fa-book">
                                        </div>
                                    </div>

                                    <div class="col-md-10">
                                        <div class="mb-3">
                                            <label class="form-label">Заголовок</label>
                                            <input type="text" class="form-control" value="Коран и Сунна">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="add-new-btn" onclick="addShariaPrinciplesBannerItem('sp-ru-content')">
                            <i class="fas fa-plus"></i> Добавить элемент
                        </button>
                    </div>
                </div>

                <!-- English -->
                <div class="tab-pane fade" id="sp-en-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" value="Sharia Principles">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3">The Envast platform strictly complies with Islamic financial laws, and all operations are verified by the Sharia Board.</textarea>
                        </div>
                    </div>

                    <!-- Principles Items -->
                    <div class="principles-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Icon</label>
                                        <input type="file" class="form-control" value="fas fa-ban">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Principle Type</label>
                                        <select class="form-select">
                                            <option value="halol" selected>Halal Principles</option>
                                            <option value="harom">Haram Principles</option>
                                            <option value="asosiy">Basic Principles</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" value="Interest-free (No Riba)">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" rows="3">All financial transactions are conducted on an interest-free basis. Only profit-sharing partnership model is used.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addShariaPrincipleItem('sp-en-content')">
                        <i class="fas fa-plus"></i> Add New Principle
                    </button>

                    <!-- Shariat asoslari banneri -->
                    <div class="mt-4 pt-3 border-top">
                        <h5 class="mb-3"><i class="fas fa-image me-2"></i>Sharia Principles Banner</h5>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label">Main Title</label>
                                <input type="text" class="form-control" value="Sharia Laws">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">Main Description</label>
                                <textarea class="form-control" rows="3">All operations strictly comply with Islamic financial laws</textarea>
                            </div>
                        </div>

                        <div class="sharia-principles-banner-container">
                            <div class="dynamic-item">
                                <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Icon</label>
                                            <input type="file" class="form-control" value="fas fa-book">
                                        </div>
                                    </div>

                                    <div class="col-md-10">
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" value="Quran and Sunnah">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="add-new-btn" onclick="addShariaPrinciplesBannerItem('sp-en-content')">
                            <i class="fas fa-plus"></i> Add New Element
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Halollik mexanizmi -->
        <div class="setting-card">
            <div class="section-header">
                <h3><i class="fas fa-handshake me-2"></i>Halollik mexanizmi</h3>
                <p class="setting-description">Halol investitsiya mexanizmlari va jarayonlari</p>
            </div>

            <!-- Language Tabs for Halal Mechanism -->
            <ul class="nav section-tabs" id="halalMechanismTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="hm-uz-tab" data-bs-toggle="tab" data-bs-target="#hm-uz-content" type="button" role="tab">
                        🇺🇿 O'zbek
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="hm-ru-tab" data-bs-toggle="tab" data-bs-target="#hm-ru-content" type="button" role="tab">
                        🇷🇺 Русский
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="hm-en-tab" data-bs-toggle="tab" data-bs-target="#hm-en-content" type="button" role="tab">
                        🇬🇧 English
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="halalMechanismTabContent">
                <!-- Uzbek -->
                <div class="tab-pane fade show active" id="hm-uz-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Asosiy sarlavha</label>
                            <input type="text" class="form-control" value="Halollik mexanizmi">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Asosiy tavsif</label>
                            <textarea class="form-control" rows="3">Envast platformasida barcha investitsiya loyihalari Shariat kengashi tomonidan tekshiriladi va sertifikatlangan halol mexanizmlar orqali amalga oshiriladi.</textarea>
                        </div>
                    </div>

                    <!-- Halol banneri -->
                    <div class="halal-banner-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Banner tanlash</label>
                                    <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                                        <option value="" selected>Banner tanlang...</option>
                                        <option value="halal1">Halol mexanizm - 1</option>
                                        <option value="halal2">Halol mexanizm - 2</option>
                                        <option value="halal3">Sertifikat banner</option>
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

                    <button type="button" class="add-new-btn" onclick="addHalalBannerItem('hm-uz-content')">
                        <i class="fas fa-plus"></i> Yangi banner qo'shish
                    </button>
                </div>

                <!-- Russian -->
                <div class="tab-pane fade" id="hm-ru-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Основной заголовок</label>
                            <input type="text" class="form-control" value="Механизм халяльности">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Основное описание</label>
                            <textarea class="form-control" rows="3">На платформе Envast все инвестиционные проекты проверяются Советом Шариата и реализуются через сертифицированные халяльные механизмы.</textarea>
                        </div>
                    </div>

                    <!-- Halol banneri -->
                    <div class="halal-banner-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Выбор баннера</label>
                                    <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                                        <option value="" selected>Выберите баннер...</option>
                                        <option value="halal1">Механизм халяль - 1</option>
                                        <option value="halal2">Механизм халяль - 2</option>
                                        <option value="halal3">Баннер сертификата</option>
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

                    <button type="button" class="add-new-btn" onclick="addHalalBannerItem('hm-ru-content')">
                        <i class="fas fa-plus"></i> Добавить баннер
                    </button>
                </div>

                <!-- English -->
                <div class="tab-pane fade" id="hm-en-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Main Title</label>
                            <input type="text" class="form-control" value="Halal Mechanism">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Main Description</label>
                            <textarea class="form-control" rows="3">On the Envast platform, all investment projects are reviewed by the Sharia Board and implemented through certified halal mechanisms.</textarea>
                        </div>
                    </div>

                    <!-- Halol banneri -->
                    <div class="halal-banner-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Select Banner</label>
                                    <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                                        <option value="" selected>Select banner...</option>
                                        <option value="halal1">Halal mechanism - 1</option>
                                        <option value="halal2">Halal mechanism - 2</option>
                                        <option value="halal3">Certificate banner</option>
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

                    <button type="button" class="add-new-btn" onclick="addHalalBannerItem('hm-en-content')">
                        <i class="fas fa-plus"></i> Add New Banner
                    </button>
                </div>
            </div>
        </div>

        <!-- 4. Nazorat qismi -->
        <div class="setting-card">
            <div class="section-header">
                <h3><i class="fas fa-eye me-2"></i>Nazorat qismi</h3>
                <p class="setting-description">Shariat kengashi va nazorat mexanizmlari</p>
            </div>

            <!-- Language Tabs for Control Section -->
            <ul class="nav section-tabs" id="controlSectionTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="cs-uz-tab" data-bs-toggle="tab" data-bs-target="#cs-uz-content" type="button" role="tab">
                        🇺🇿 O'zbek
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cs-ru-tab" data-bs-toggle="tab" data-bs-target="#cs-ru-content" type="button" role="tab">
                        🇷🇺 Русский
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cs-en-tab" data-bs-toggle="tab" data-bs-target="#cs-en-content" type="button" role="tab">
                        🇬🇧 English
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="controlSectionTabContent">
                <!-- Uzbek -->
                <div class="tab-pane fade show active" id="cs-uz-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Asosiy sarlavha</label>
                            <input type="text" class="form-control" value="Nazorat va monitoring">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Asosiy tavsif</label>
                            <textarea class="form-control" rows="3">Har bir operatsiya Shariat kengashi tomonidan tekshiriladi va mustaqil auditorlar nazorati ostida amalga oshiriladi.</textarea>
                        </div>
                    </div>

                    <!-- User selection -->
                    <div class="users-container mb-4">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Foydalanuvchi tanlash</label>
                                        <select class="form-select user-select" onchange="updateUserPreview(this)">
                                            <option value="" selected>Foydalanuvchi tanlang...</option>
                                            <option value="1">Shariat kengashi raisi</option>
                                            <option value="2">Moliyaviy auditor</option>
                                            <option value="3">Nazoratchi</option>
                                            <option value="4">Kompaniya rahbari</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="user-preview">
                                        <img src="{{ asset('assets/img/default.jpg') }}" alt="User preview">
                                        <div class="user-info">
                                            <h6>Tanlanmagan</h6>
                                            <p>Foydalanuvchi tanlang</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addControlUserItem('cs-uz-content')">
                        <i class="fas fa-plus"></i> Yangi foydalanuvchi qo'shish
                    </button>

                    <!-- Kengash vazifalari -->
                    <div class="mt-4 pt-3 border-top">
                        <h5 class="mb-3"><i class="fas fa-tasks me-2"></i>Kengash vazifalari</h5>

                        <div class="council-tasks-container">
                            <div class="dynamic-item">
                                <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Icon</label>
                                            <input type="file" class="form-control" value="fas fa-check-circle">
                                        </div>
                                    </div>

                                    <div class="col-md-10">
                                        <div class="mb-3">
                                            <label class="form-label">Sarlavha</label>
                                            <input type="text" class="form-control" value="Loyihalarni tekshirish">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Tavsif</label>
                                            <textarea class="form-control" rows="3">Har bir investitsiya loyihasi Shariat qonunlariga muvofiqligi uchun diqqat bilan tekshiriladi.</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="add-new-btn" onclick="addCouncilTaskItem('cs-uz-content')">
                            <i class="fas fa-plus"></i> Yangi vazifa qo'shish
                        </button>
                    </div>

                    <!-- Nazorat banneri -->
                    <div class="mt-4 pt-3 border-top">
                        <h5 class="mb-3"><i class="fas fa-image me-2"></i>Nazorat banneri</h5>

                        <div class="control-banner-container">
                            <div class="dynamic-item">
                                <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Icon</label>
                                            <input type="file" class="form-control" value="fas fa-eye">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Sarlavha</label>
                                            <input type="text" class="form-control" value="Nazorat banneri">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Index</label>
                                            <input type="number" class="form-control" value="1" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="add-new-btn" onclick="addControlBannerItem('cs-uz-content')">
                            <i class="fas fa-plus"></i> Yangi nazorat banneri qo'shish
                        </button>
                    </div>
                </div>

                <!-- Russian -->
                <div class="tab-pane fade" id="cs-ru-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Основной заголовок</label>
                            <input type="text" class="form-control" value="Контроль и мониторинг">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Основное описание</label>
                            <textarea class="form-control" rows="3">Каждая операция проверяется Советом Шариата и осуществляется под контролем независимых аудиторов.</textarea>
                        </div>
                    </div>

                    <!-- User selection -->
                    <div class="users-container mb-4">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Выбор пользователя</label>
                                        <select class="form-select user-select" onchange="updateUserPreview(this)">
                                            <option value="" selected>Выберите пользователя...</option>
                                            <option value="1">Председатель Шариатского совета</option>
                                            <option value="2">Финансовый аудитор</option>
                                            <option value="3">Контролер</option>
                                            <option value="4">Руководитель компании</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="user-preview">
                                        <img src="https://via.placeholder.com/40x40" alt="User preview">
                                        <div class="user-info">
                                            <h6>Не выбрано</h6>
                                            <p>Выберите пользователя</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addControlUserItem('cs-ru-content')">
                        <i class="fas fa-plus"></i> Добавить пользователя
                    </button>

                    <!-- Kengash vazifalari -->
                    <div class="mt-4 pt-3 border-top">
                        <h5 class="mb-3"><i class="fas fa-tasks me-2"></i>Задачи совета</h5>

                        <div class="council-tasks-container">
                            <div class="dynamic-item">
                                <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Иконка</label>
                                            <input type="file" class="form-control" value="fas fa-check-circle">
                                        </div>
                                    </div>

                                    <div class="col-md-10">
                                        <div class="mb-3">
                                            <label class="form-label">Заголовок</label>
                                            <input type="text" class="form-control" value="Проверка проектов">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Описание</label>
                                            <textarea class="form-control" rows="3">Каждый инвестиционный проект тщательно проверяется на соответствие законам Шариата.</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="add-new-btn" onclick="addCouncilTaskItem('cs-ru-content')">
                            <i class="fas fa-plus"></i> Добавить задачу
                        </button>
                    </div>

                    <!-- Nazorat banneri -->
                    <div class="mt-4 pt-3 border-top">
                        <h5 class="mb-3"><i class="fas fa-image me-2"></i>Баннер контроля</h5>

                        <div class="control-banner-container">
                            <div class="dynamic-item">
                                <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Иконка</label>
                                            <input type="file" class="form-control" value="fas fa-eye">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Заголовок</label>
                                            <input type="text" class="form-control" value="Баннер контроля">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Индекс</label>
                                            <input type="number" class="form-control" value="1" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="add-new-btn" onclick="addControlBannerItem('cs-ru-content')">
                            <i class="fas fa-plus"></i> Добавить баннер контроля
                        </button>
                    </div>
                </div>

                <!-- English -->
                <div class="tab-pane fade" id="cs-en-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Main Title</label>
                            <input type="text" class="form-control" value="Control and Monitoring">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Main Description</label>
                            <textarea class="form-control" rows="3">Each operation is verified by the Sharia Board and carried out under the supervision of independent auditors.</textarea>
                        </div>
                    </div>

                    <!-- User selection -->
                    <div class="users-container mb-4">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">User Selection</label>
                                        <select class="form-select user-select" onchange="updateUserPreview(this)">
                                            <option value="" selected>Select user...</option>
                                            <option value="1">Sharia Board Chairman</option>
                                            <option value="2">Financial Auditor</option>
                                            <option value="3">Controller</option>
                                            <option value="4">Company Manager</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="user-preview">
                                        <img src="https://via.placeholder.com/40x40" alt="User preview">
                                        <div class="user-info">
                                            <h6>Not selected</h6>
                                            <p>Select user</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addControlUserItem('cs-en-content')">
                        <i class="fas fa-plus"></i> Add New User
                    </button>

                    <!-- Kengash vazifalari -->
                    <div class="mt-4 pt-3 border-top">
                        <h5 class="mb-3"><i class="fas fa-tasks me-2"></i>Council Tasks</h5>

                        <div class="council-tasks-container">
                            <div class="dynamic-item">
                                <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Icon</label>
                                            <input type="file" class="form-control" value="fas fa-check-circle">
                                        </div>
                                    </div>

                                    <div class="col-md-10">
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" value="Project Review">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" rows="3">Each investment project is carefully reviewed for compliance with Sharia laws.</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="add-new-btn" onclick="addCouncilTaskItem('cs-en-content')">
                            <i class="fas fa-plus"></i> Add New Task
                        </button>
                    </div>

                    <!-- Nazorat banneri -->
                    <div class="mt-4 pt-3 border-top">
                        <h5 class="mb-3"><i class="fas fa-image me-2"></i>Control Banner</h5>

                        <div class="control-banner-container">
                            <div class="dynamic-item">
                                <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Icon</label>
                                            <input type="file" class="form-control" value="fas fa-eye">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" value="Control Banner">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Index</label>
                                            <input type="number" class="form-control" value="1" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="add-new-btn" onclick="addControlBannerItem('cs-en-content')">
                            <i class="fas fa-plus"></i> Add Control Banner
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Rasmiy hujjatlar -->
        <div class="setting-card">
            <div class="section-header">
                <h3><i class="fas fa-file-contract me-2"></i>Rasmiy hujjatlar</h3>
                <p class="setting-description">Shariat sertifikatlari va rasmiy hujjatlar</p>
            </div>

            <!-- Language Tabs for Documents -->
            <ul class="nav section-tabs" id="documentsTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="doc-uz-tab" data-bs-toggle="tab" data-bs-target="#doc-uz-content" type="button" role="tab">
                        🇺🇿 O'zbek
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="doc-ru-tab" data-bs-toggle="tab" data-bs-target="#doc-ru-content" type="button" role="tab">
                        🇷🇺 Русский
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="doc-en-tab" data-bs-toggle="tab" data-bs-target="#doc-en-content" type="button" role="tab">
                        🇬🇧 English
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="documentsTabContent">
                <!-- Uzbek -->
                <div class="tab-pane fade show active" id="doc-uz-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Asosiy sarlavha</label>
                            <input type="text" class="form-control" value="Rasmiy hujjatlar">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Asosiy tavsif</label>
                            <textarea class="form-control" rows="3">Envast platformasining barcha Shariat sertifikatlari va rasmiy hujjatlari.</textarea>
                        </div>
                    </div>

                    <!-- Documents Items -->
                    <div class="documents-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Hujjat tanlash</label>
                                        <select class="form-select">
                                            <option value="" selected>Hujjat tanlang...</option>
                                            <option value="1" selected>Shariat sertifikati</option>
                                            <option value="2">Audit hisoboti</option>
                                            <option value="3">Moliyaviy hisobot</option>
                                            <option value="4">Litsenziya</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addDocumentItem('doc-uz-content')">
                        <i class="fas fa-plus"></i> Yangi hujjat qo'shish
                    </button>
                </div>

                <!-- Russian -->
                <div class="tab-pane fade" id="doc-ru-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Основной заголовок</label>
                            <input type="text" class="form-control" value="Официальные документы">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Основное описание</label>
                            <textarea class="form-control" rows="3">Все сертификаты Шариата и официальные документы платформы Envast.</textarea>
                        </div>
                    </div>

                    <!-- Documents Items -->
                    <div class="documents-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Выбор документа</label>
                                        <select class="form-select">
                                            <option value="" selected>Выберите документ...</option>
                                            <option value="1" selected>Сертификат Шариата</option>
                                            <option value="2">Аудиторский отчет</option>
                                            <option value="3">Финансовый отчет</option>
                                            <option value="4">Лицензия</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addDocumentItem('doc-ru-content')">
                        <i class="fas fa-plus"></i> Добавить документ
                    </button>
                </div>

                <!-- English -->
                <div class="tab-pane fade" id="doc-en-content" role="tabpanel">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Main Title</label>
                            <input type="text" class="form-control" value="Official Documents">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Main Description</label>
                            <textarea class="form-control" rows="3">All Sharia certificates and official documents of the Envast platform.</textarea>
                        </div>
                    </div>

                    <!-- Documents Items -->
                    <div class="documents-container">
                        <div class="dynamic-item">
                            <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Select Document</label>
                                        <select class="form-select">
                                            <option value="" selected>Select document...</option>
                                            <option value="1" selected>Sharia Certificate</option>
                                            <option value="2">Audit Report</option>
                                            <option value="3">Financial Report</option>
                                            <option value="4">License</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="add-new-btn" onclick="addDocumentItem('doc-en-content')">
                        <i class="fas fa-plus"></i> Add New Document
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
<template id="sharia-banner-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Banner tanlash</label>
                <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                    <option value="" selected>Banner tanlang...</option>
                    <option value="sharia1">Shariat banner - 1</option>
                    <option value="sharia2">Shariat banner - 2</option>
                    <option value="sharia3">Halol banner</option>
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

<template id="sharia-principle-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Icon</label>
                    <input type="file" class="form-control" placeholder="fas fa-icon">
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Tamoyil turi</label>
                    <select class="form-select">
                        <option value="halol" selected>Halol tamoyillar</option>
                        <option value="harom">Harom tamoyillar</option>
                        <option value="asosiy">Asosiy tamoyillar</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Sarlavha</label>
                    <input type="text" class="form-control" placeholder="Tamoyil nomi">
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Tavsif</label>
                    <textarea class="form-control" rows="3" placeholder="Tamoyil tavsifi"></textarea>
                </div>
            </div>
        </div>
    </div>
</template>

<template id="sharia-principles-banner-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row align-items-center">
            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Icon</label>
                    <input type="file" class="form-control" placeholder="fas fa-icon">
                </div>
            </div>

            <div class="col-md-10">
                <div class="mb-3">
                    <label class="form-label">Sarlavha</label>
                    <input type="text" class="form-control" placeholder="Element nomi">
                </div>
            </div>
        </div>
    </div>
</template>

<template id="halal-banner-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Banner tanlash</label>
                <select class="form-select banner-select" onchange="updateBannerPreview(this)">
                    <option value="" selected>Banner tanlang...</option>
                    <option value="halal1">Halol mexanizm - 1</option>
                    <option value="halal2">Halol mexanizm - 2</option>
                    <option value="halal3">Sertifikat banner</option>
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

<template id="control-user-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Foydalanuvchi tanlash</label>
                    <select class="form-select user-select" onchange="updateUserPreview(this)">
                        <option value="" selected>Foydalanuvchi tanlang...</option>
                        <option value="1">Shariat kengashi raisi</option>
                        <option value="2">Moliyaviy auditor</option>
                        <option value="3">Nazoratchi</option>
                        <option value="4">Kompaniya rahbari</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="user-preview">
                    <img src="https://via.placeholder.com/40x40" alt="User preview">
                    <div class="user-info">
                        <h6>Tanlanmagan</h6>
                        <p>Foydalanuvchi tanlang</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<template id="council-task-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row align-items-center">
            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Icon</label>
                    <input type="file" class="form-control" placeholder="fas fa-icon">
                </div>
            </div>

            <div class="col-md-10">
                <div class="mb-3">
                    <label class="form-label">Sarlavha</label>
                    <input type="text" class="form-control" placeholder="Vazifa nomi">
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Tavsif</label>
                    <textarea class="form-control" rows="3" placeholder="Vazifa tavsifi"></textarea>
                </div>
            </div>
        </div>
    </div>
</template>

<template id="control-banner-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row align-items-center">
            <div class="col-md-2">
                <div class="mb-3">
                    <label class="form-label">Icon</label>
                    <input type="file" class="form-control" placeholder="fas fa-icon">
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Sarlavha</label>
                    <input type="text" class="form-control" placeholder="Banner nomi">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Index</label>
                    <input type="number" class="form-control" value="1" min="1">
                </div>
            </div>
        </div>
    </div>
</template>

<template id="document-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="showRemoveConfirmation(this)">×</button>

        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Hujjat tanlash</label>
                    <select class="form-select">
                        <option value="" selected>Hujjat tanlang...</option>
                        <option value="1">Shariat sertifikati</option>
                        <option value="2">Audit hisoboti</option>
                        <option value="3">Moliyaviy hisobot</option>
                        <option value="4">Litsenziya</option>
                    </select>
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
                'sharia1': {
                    img: 'https://via.placeholder.com/100x60/4361ee/ffffff',
                    title: 'Shariat banner - 1',
                    desc: '1920×800 px'
                },
                'sharia2': {
                    img: 'https://via.placeholder.com/100x60/10b981/ffffff',
                    title: 'Shariat banner - 2',
                    desc: '1920×800 px'
                },
                'sharia3': {
                    img: 'https://via.placeholder.com/100x60/3a56d4/ffffff',
                    title: 'Halol banner',
                    desc: '1920×800 px'
                },
                'halal1': {
                    img: 'https://via.placeholder.com/100x60/2ecc71/ffffff',
                    title: 'Halol mexanizm - 1',
                    desc: '1920×800 px'
                },
                'halal2': {
                    img: 'https://via.placeholder.com/100x60/3498db/ffffff',
                    title: 'Halol mexanizm - 2',
                    desc: '1920×800 px'
                },
                'halal3': {
                    img: 'https://via.placeholder.com/100x60/9b59b6/ffffff',
                    title: 'Sertifikat banner',
                    desc: '1920×800 px'
                },
                'control1': {
                    img: 'https://via.placeholder.com/100x60/f39c12/ffffff',
                    title: 'Nazorat banner - 1',
                    desc: '1920×800 px'
                },
                'control2': {
                    img: 'https://via.placeholder.com/100x60/e74c3c/ffffff',
                    title: 'Nazorat banner - 2',
                    desc: '1920×800 px'
                },
                'audit': {
                    img: 'https://via.placeholder.com/100x60/34495e/ffffff',
                    title: 'Audit banner',
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

        // User preview update function
        window.updateUserPreview = function(select) {
            const previewContainer = select.closest('.row').querySelector('.user-preview');
            if (!previewContainer) return;

            const img = previewContainer.querySelector('img');
            const title = previewContainer.querySelector('h6');
            const description = previewContainer.querySelector('p');

            const users = {
                '1': {
                    img: 'https://via.placeholder.com/40x40/4361ee/ffffff',
                    name: 'Shariat kengashi raisi',
                    position: 'Rahbar'
                },
                '2': {
                    img: 'https://via.placeholder.com/40x40/10b981/ffffff',
                    name: 'Moliyaviy auditor',
                    position: 'Auditor'
                },
                '3': {
                    img: 'https://via.placeholder.com/40x40/3a56d4/ffffff',
                    name: 'Nazoratchi',
                    position: 'Nazoratchi'
                },
                '4': {
                    img: 'https://via.placeholder.com/40x40/9b59b6/ffffff',
                    name: 'Kompaniya rahbari',
                    position: 'Direktor'
                }
            };

            if (select.value && users[select.value]) {
                img.src = users[select.value].img;
                title.textContent = users[select.value].name;
                description.textContent = users[select.value].position;
            } else {
                img.src = 'https://via.placeholder.com/40x40';
                title.textContent = 'Tanlanmagan';
                description.textContent = 'Foydalanuvchi tanlang';
            }
        };

        // Show remove confirmation
        window.showRemoveConfirmation = function(button) {
            const item = button.closest('.dynamic-item');
            if (item) {
                item.remove();
            }
        };

        // Add sharia banner item
        window.addShariaBannerItem = function(tabContentId) {
            const template = document.getElementById('sharia-banner-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabContentId);
            if (!tabContent) return;

            const addButton = tabContent.querySelector('[onclick*="addShariaBannerItem"]');
            if (addButton) {
                const container = tabContent.querySelector('.banner-items-container') || tabContent;
                if (container) {
                    addButton.before(clone);
                }
            }
        };

        // Add sharia principle item
        window.addShariaPrincipleItem = function(tabContentId) {
            const template = document.getElementById('sharia-principle-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabContentId);
            if (!tabContent) return;

            const addButton = tabContent.querySelector('[onclick*="addShariaPrincipleItem"]');
            if (addButton) {
                const container = tabContent.querySelector('.principles-container') || tabContent;
                if (container) {
                    addButton.before(clone);
                }
            }
        };

        // Add sharia principles banner item
        window.addShariaPrinciplesBannerItem = function(tabContentId) {
            const template = document.getElementById('sharia-principles-banner-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabContentId);
            if (!tabContent) return;

            const addButton = tabContent.querySelector('[onclick*="addShariaPrinciplesBannerItem"]');
            if (addButton) {
                const container = tabContent.querySelector('.sharia-principles-banner-container') || tabContent;
                if (container) {
                    addButton.before(clone);
                }
            }
        };

        // Add halal banner item
        window.addHalalBannerItem = function(tabContentId) {
            const template = document.getElementById('halal-banner-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabContentId);
            if (!tabContent) return;

            const addButton = tabContent.querySelector('[onclick*="addHalalBannerItem"]');
            if (addButton) {
                const container = tabContent.querySelector('.halal-banner-container') || tabContent;
                if (container) {
                    addButton.before(clone);
                }
            }
        };

        // Add control user item
        window.addControlUserItem = function(tabContentId) {
            const template = document.getElementById('control-user-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabContentId);
            if (!tabContent) return;

            const addButton = tabContent.querySelector('[onclick*="addControlUserItem"]');
            if (addButton) {
                const container = tabContent.querySelector('.users-container') || tabContent;
                if (container) {
                    addButton.before(clone);
                }
            }
        };

        // Add council task item
        window.addCouncilTaskItem = function(tabContentId) {
            const template = document.getElementById('council-task-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabContentId);
            if (!tabContent) return;

            const addButton = tabContent.querySelector('[onclick*="addCouncilTaskItem"]');
            if (addButton) {
                const container = tabContent.querySelector('.council-tasks-container') || tabContent;
                if (container) {
                    addButton.before(clone);
                }
            }
        };

        // Add control banner item
        window.addControlBannerItem = function(tabContentId) {
            const template = document.getElementById('control-banner-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabContentId);
            if (!tabContent) return;

            const addButton = tabContent.querySelector('[onclick*="addControlBannerItem"]');
            if (addButton) {
                const container = tabContent.querySelector('.control-banner-container') || tabContent;
                if (container) {
                    addButton.before(clone);
                }
            }
        };

        // Add document item
        window.addDocumentItem = function(tabContentId) {
            const template = document.getElementById('document-item-template');
            const clone = template.content.cloneNode(true);

            const tabContent = document.getElementById(tabContentId);
            if (!tabContent) return;

            const addButton = tabContent.querySelector('[onclick*="addDocumentItem"]');
            if (addButton) {
                const container = tabContent.querySelector('.documents-container') || tabContent;
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

                alert('"Shariatga muvofiqlik" sahifasi sozlamalari saqlandi');

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

        // Initialize all user previews
        document.querySelectorAll('.user-select').forEach(select => {
            select.addEventListener('change', function() {
                updateUserPreview(this);
            });
        });
    });
</script>
@endpush