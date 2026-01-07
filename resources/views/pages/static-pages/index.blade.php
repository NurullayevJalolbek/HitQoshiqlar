@extends('layouts.app')

@push('customCss')
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
    /* Tab Navigation */
    .nav-tabs {
        border-bottom: 2px solid #e5e7eb;
        overflow-x: auto;
        white-space: nowrap;
        flex-wrap: nowrap;
        overflow-y: hidden;
    }

    .nav-tabs .nav-link {
        height: 40px;
        color: #1F2937;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
        background: #ebeaeaff;
        margin-right: 0.25rem;
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .nav-tabs .nav-link.active {
        color: #fff !important;
        background: #1F2937 !important;
        border-bottom: 3px solid #2a3441 !important;
        font-weight: 600;
    }

    .nav-tabs .nav-link i {
        margin-right: 0.5rem;
    }

    .tab-content {
        background: #fff;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-top: none;
        border-radius: 0 0 0.5rem 0.5rem;
        padding: 15px;
        margin-top: -1px;
        min-height: 500px;
    }

    /* Form Styles */
    .form-label {
        font-weight: 500;
        color: #4b5563;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        padding: 0.625rem 0.75rem;
        width: 100%;
        transition: all 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        outline: none;
    }

    /* Icon Preview */
    .icon-preview {
        width: 48px;
        height: 48px;
        background: #f3f4f6;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: #4b5563;
    }

    /* File Upload Items */
    .file-item {
        background: #f8f9fa;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        position: relative;
    }

    .file-item .remove-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: #ef4444;
        color: white;
        border: none;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.75rem;
    }

    /* Add New Button */
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
        transition: all 0.3s;
    }

    .add-new-btn:hover {
        background: #0da271;
    }

    .add-new-btn i {
        margin-right: 0.5rem;
    }

    /* Dynamic Items */
    .dynamic-item {
        background: #f8f9fa;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        position: relative;
    }

    .dynamic-item .remove-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: #ef4444;
        color: white;
        border: none;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.75rem;
    }

    /* Contact Items */
    .contact-item {
        background: #f8f9fa;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        position: relative;
    }

    .contact-item .remove-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: #ef4444;
        color: white;
        border: none;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.75rem;
    }

    /* Social Items */
    .social-item {
        background: #f8f9fa;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
        position: relative;
    }

    .social-item .remove-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: #ef4444;
        color: white;
        border: none;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 0.75rem;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
    }

    /* .btn-primary {
        background: #4361ee;
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
    } */


    /* Info Message */
    .info-message {
        background: #e7f1ff;
        border-left: 4px solid #4361ee;
        padding: 1rem;
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        color: #4361ee;
    }

    .info-message i {
        margin-right: 0.5rem;
        color: #4361ee;
    }

    /* Quill Editor */
    .ql-toolbar {
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .ql-container {
        border-radius: 0 0 0.5rem 0.5rem;
        min-height: 200px;
    }


    .mb-4 {
        margin-bottom: 1.5rem !important;
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
                <li class="breadcrumb-item active" aria-current="page">
                    Footer Sozlamalari
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
<!-- <div class="card card-body shadow-sm mb-4 mt-3"> -->
<!-- Tabs -->
<div class="border rounded p-3 mt-3" id="footerTabsContent" style="border-color: rgba(0,0,0,0.05); background-color: #fff; padding: 0;">

    <!-- <div class="collapse show" id="footerTabsContent"> -->
    <ul class="nav nav-tabs" id="permissionTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active text-primary fw-semibold" id="about-tab" data-bs-toggle="tab"
                data-bs-target="#about" type="button" role="tab">
                <i class="fas fa-info-circle me-1"></i> Biz haqimizda
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-primary fw-semibold" id="company-tab" data-bs-toggle="tab"
                data-bs-target="#company" type="button" role="tab">
                <i class="fas fa-building me-1"></i> Kompaniya
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-primary fw-semibold" id="legal-tab" data-bs-toggle="tab"
                data-bs-target="#legal" type="button" role="tab">
                <i class="fas fa-gavel me-1"></i> Yuridik
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-primary fw-semibold" id="contact-tab" data-bs-toggle="tab"
                data-bs-target="#contact" type="button" role="tab">
                <i class="fas fa-address-book me-1"></i> Aloqa
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-primary fw-semibold" id="social-tab" data-bs-toggle="tab"
                data-bs-target="#social" type="button" role="tab">
                <i class="fas fa-share-alt me-1"></i> Ijtimoiy tarmoqlar
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- 1. Biz haqimizda Tab -->
        <div class="tab-pane fade show active" id="about" role="tabpanel">
            <div class="info-message">
                <i class="fas fa-info-circle"></i>
                «Envast» investitsiya platformasi haqida ma'lumot va hujjatlarni sozlang.
            </div>




            <form>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Sarlavha</label>
                        <input type="text" class="form-control" value="Biz haqimizda">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Logo</label>
                        <input type="file" class="form-control" name="logo" accept="image/*">

                        {{-- Preview --}}
                        <div class="mt-2">
                            <img src="{{ asset('assets/img/envast_logo_1.svg') }}"
                                alt="Logo preview"
                                style="max-width: 120px; height: auto;">
                        </div>
                    </div>

                </div>


                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="form-label">Tavsif</label>
                        <div id="about-editor"></div>
                        <input type="hidden" id="about-description">
                    </div>
                </div>

                <!-- File Upload Items -->
                <div class="row mb-4 mt-8">
                    <div class="col-md-12">
                        <label class="form-label mb-3">Hujjatlar</label>

                        <!-- Existing File Items -->
                        <div class="file-item">
                            <button type="button" class="remove-btn" onclick="removeDynamicItem(this)">×</button>

                            <div class="row">

                                <div class="col-md-5">
                                    <label class="form-label">Hujjat nomi</label>
                                    <input type="text" class="form-control" value="Guvohnoma">
                                </div>

                                <div class="col-md-5">
                                    <label class="form-label">Fayl yuklash</label>
                                    <input type="file" class="form-control">
                                    <small class="text-muted">guvohnoma.pdf</small>
                                </div>


                            </div>
                        </div>


                        <div class="file-item">
                            <button type="button" class="remove-btn" onclick="removeDynamicItem(this)">×</button>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Hujjat nomi</label>
                                    <input type="text" class="form-control" value="Fatvo">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fayl yuklash</label>
                                    <input type="file" class="form-control">
                                    <small class="text-muted">fatvo.pdf</small>
                                </div>
                            </div>
                        </div>

                        <!-- Add New File Button -->
                        <button type="button" class="add-new-btn" onclick="addFileItem()">
                            <i class="fas fa-plus"></i> Yangi hujjat qo'shish
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3 gap-2">
                    <!-- <a href="#" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Bekor qilish
                    </a> -->

                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save me-1"></i>
                        @isset($user) Yangilash @else Saqlash @endisset
                    </button>
                </div>
            </form>
        </div>

        <!-- 2. Kompaniya Tab -->
        <div class="tab-pane fade" id="company" role="tabpanel">
            <div class="info-message">
                <i class="fas fa-info-circle"></i>
                Saytning asosiy bo'limlari uchun linklarni sozlang.
            </div>

            <form>
                <!-- Existing List Items -->
                <div class="dynamic-item">
                    <button type="button" class="remove-btn" onclick="removeDynamicItem(this)">×</button>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Bo'lim nomi</label>
                            <input type="text" class="form-control" value="Bosh sahifa">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">URL manzili</label>
                            <input type="text" class="form-control" value="/">
                        </div>
                    </div>
                </div>

                <div class="dynamic-item">
                    <button type="button" class="remove-btn" onclick="removeDynamicItem(this)">×</button>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Bo'lim nomi</label>
                            <input type="text" class="form-control" value="Biz haqimizda">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">URL manzili</label>
                            <input type="text" class="form-control" value="/about">
                        </div>
                    </div>
                </div>

                <div class="dynamic-item">
                    <button type="button" class="remove-btn" onclick="removeDynamicItem(this)">×</button>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Bo'lim nomi</label>
                            <input type="text" class="form-control" value="Loyihalar">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">URL manzili</label>
                            <input type="text" class="form-control" value="/projects">
                        </div>
                    </div>
                </div>

                <!-- Add New Button -->
                <button type="button" class="add-new-btn" onclick="addCompanyItem()">
                    <i class="fas fa-plus"></i> Yangi bo'lim qo'shish
                </button>

                <div class="d-flex justify-content-end mt-3 gap-2">
                    <!-- <a href="#" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Bekor qilish
                    </a> -->

                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save me-1"></i>
                        @isset($user) Yangilash @else Saqlash @endisset
                    </button>
                </div>
            </form>
        </div>

        <!-- 3. Yuridik Tab -->
        <div class="tab-pane fade" id="legal" role="tabpanel">
            <div class="info-message">
                <i class="fas fa-info-circle"></i>
                Yuridik hujjatlar va shartnomalarni sozlang.
            </div>

            <form>
                <!-- Existing Legal Items -->
                <div class="dynamic-item">
                    <button type="button" class="remove-btn" onclick="removeDynamicItem(this)">×</button>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Hujjat nomi</label>
                            <input type="text" class="form-control" value="Maxfiylik siyosati">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">URL manzili</label>
                            <input type="text" class="form-control" value="/privacy-policy">
                        </div>
                    </div>
                </div>

                <div class="dynamic-item">
                    <button type="button" class="remove-btn" onclick="removeDynamicItem(this)">×</button>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Hujjat nomi</label>
                            <input type="text" class="form-control" value="Foydalanish shartlari">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">URL manzili</label>
                            <input type="text" class="form-control" value="/terms">
                        </div>
                    </div>
                </div>

                <!-- Add New Button -->
                <button type="button" class="add-new-btn" onclick="addLegalItem()">
                    <i class="fas fa-plus"></i> Yangi hujjat qo'shish
                </button>

                <div class="d-flex justify-content-end mt-3 gap-2">
                    <!-- <a href="#" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Bekor qilish
                    </a> -->

                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save me-1"></i>
                        @isset($user) Yangilash @else Saqlash @endisset
                    </button>
                </div>
            </form>
        </div>

        <!-- 4. Aloqa Tab -->
        <div class="tab-pane fade" id="contact" role="tabpanel">
            <div class="info-message">
                <i class="fas fa-info-circle"></i>
                Kompaniya aloqa ma'lumotlarini sozlang.
            </div>

            <form>
                <!-- Existing Contact Items -->
                <div class="contact-item">
                    <button type="button" class="remove-btn" onclick="removeContactItem(this)">×</button>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Icon yuklash</label>
                            <input type="file" class="form-control" accept="image/*">
                            <!-- <div class="icon-preview mt-2">
                                <img src="/assets/icons/phone.png" alt="icon" width="24">
                            </div> -->
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Text</label>
                            <input type="text" class="form-control" value="+998 (77) 123-45-67">
                        </div>
                    </div>
                </div>

                <div class="contact-item">
                    <button type="button" class="remove-btn" onclick="removeContactItem(this)">×</button>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Icon yuklash</label>
                            <input type="file" class="form-control" accept="image/*">
                            <!-- <div class="icon-preview mt-2">
                                <img src="/assets/icons/phone.png" alt="icon" width="24">
                            </div> -->
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Text</label>
                            <input type="text" class="form-control" value="info@envast.uz">
                        </div>
                    </div>
                </div>

                <div class="contact-item">
                    <button type="button" class="remove-btn" onclick="removeContactItem(this)">×</button>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Icon yuklash</label>
                            <input type="file" class="form-control" accept="image/*">
                            <!-- <div class="icon-preview mt-2">
                                <img src="/assets/icons/phone.png" alt="icon" width="24">
                            </div> -->
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Text</label>
                            <input type="text" class="form-control" value="1-mavze, 4. Chilonzor dahasi, Chilonzor tumani, Toshkent">
                        </div>
                    </div>
                </div>

                <!-- Add New Button -->
                <button type="button" class="add-new-btn" onclick="addContactItem()">
                    <i class="fas fa-plus"></i> Yangi aloqa qo'shish
                </button>

                <div class="d-flex justify-content-end mt-3 gap-2">

                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save me-1"></i>
                        @isset($user) Yangilash @else Saqlash @endisset
                    </button>
                </div>
            </form>
        </div>

        <!-- 5. Ijtimoiy tarmoqlar Tab -->
        <div class="tab-pane fade" id="social" role="tabpanel">
            <div class="info-message">
                <i class="fas fa-info-circle"></i>
                Ijtimoiy tarmoqlardagi sahifalaringiz uchun linklarni boshqaring.
            </div>

            <form>
                <!-- Existing Social Items -->
                <div class="social-item">
                    <button type="button" class="remove-btn" onclick="removeSocialItem(this)">×</button>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Icon yuklash</label>
                            <input type="file" class="form-control" accept="image/*">
                            <!-- <div class="icon-preview mt-2">
                                <img src="/assets/icons/telegram.png" alt="icon" width="24">
                            </div> -->
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">URL manzili</label>
                            <input type="text" class="form-control" value="https://t.me/envast">
                        </div>
                    </div>
                </div>

                <div class="social-item">
                    <button type="button" class="remove-btn" onclick="removeSocialItem(this)">×</button>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Icon yuklash</label>
                            <input type="file" class="form-control" accept="image/*">
                            <!-- <div class="icon-preview mt-2">
                                <img src="/assets/icons/telegram.png" alt="icon" width="24">
                            </div> -->
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">URL manzili</label>
                            <input type="text" class="form-control" value="https://instagram.com/envast">
                        </div>
                    </div>
                </div>

                <div class="social-item">
                    <button type="button" class="remove-btn" onclick="removeSocialItem(this)">×</button>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Icon yuklash</label>
                            <input type="file" class="form-control" accept="image/*">
                            <!-- <div class="icon-preview mt-2">
                                <img src="/assets/icons/telegram.png" alt="icon" width="24">
                            </div> -->
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">URL manzili</label>
                            <input type="text" class="form-control" value="https://facebook.com/envast">
                        </div>
                    </div>
                </div>

                <!-- Add New Button -->
                <button type="button" class="add-new-btn" onclick="addSocialItem()">
                    <i class="fas fa-plus"></i> Yangi tarmoq qo'shish
                </button>

                <div class="d-flex justify-content-end mt-3 gap-2">
                    <!-- <a href="#" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Bekor qilish
                    </a> -->

                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-save me-1"></i>
                        @isset($user) Yangilash @else Saqlash @endisset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Templates for new items -->
<template id="file-item-template">
    <div class="file-item">
        <button type="button" class="remove-btn" onclick="removeFileItem(this)">×</button>
        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Hujjat nomi</label>
                <input type="text" class="form-control" placeholder="Hujjat nomi...">
            </div>
            <div class="col-md-6">
                <label class="form-label">Fayl yuklash</label>
                <input type="file" class="form-control">
            </div>
        </div>
    </div>
</template>

<template id="dynamic-item-template">
    <div class="dynamic-item">
        <button type="button" class="remove-btn" onclick="removeDynamicItem(this)">×</button>
        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Nomi</label>
                <input type="text" class="form-control" placeholder="Nomi...">
            </div>
            <div class="col-md-6">
                <label class="form-label">URL manzili</label>
                <input type="text" class="form-control" placeholder="/url">
            </div>
        </div>
    </div>
</template>

<template id="contact-item-template">
    <div class="contact-item">
        <button type="button" class="remove-btn" onclick="removeContactItem(this)">×</button>
        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Icon  yuklash </label>
                <input type="text" class="form-control" placeholder="fas fa-icon">
                <!-- <div class="icon-preview mt-2">
                    <i class="fas fa-icon"></i>
                </div> -->
            </div>
            <div class="col-md-6">
                <label class="form-label">Text</label>
                <input type="text" class="form-control" placeholder="Matn...">
            </div>
        </div>
    </div>
</template>

<template id="social-item-template">
    <div class="social-item">
        <button type="button" class="remove-btn" onclick="removeSocialItem(this)">×</button>
        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Icon yuklash </label>
                <input type="text" class="form-control" placeholder="fab fa-telegram">
                <!-- <div class="icon-preview mt-2">
                    <i class="fab fa-telegram"></i>
                </div> -->
            </div>
            <div class="col-md-6">
                <label class="form-label">URL manzili</label>
                <input type="text" class="form-control" placeholder="https://...">
            </div>
        </div>
    </div>
</template>
@endsection

@push('customJs')
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    // Quill Editor for About section
    const aboutQuill = new Quill('#about-editor', {
        theme: 'snow',
        placeholder: 'Tavsif matnini kiriting...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{
                    'header': 1
                }, {
                    'header': 2
                }],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'script': 'sub'
                }, {
                    'script': 'super'
                }],
                [{
                    'indent': '-1'
                }, {
                    'indent': '+1'
                }],
                [{
                    'direction': 'rtl'
                }],
                [{
                    'size': ['small', false, 'large', 'huge']
                }],
                [{
                    'header': [1, 2, 3, 4, 5, 6, false]
                }],
                [{
                    'color': []
                }, {
                    'background': []
                }],
                [{
                    'font': []
                }],
                [{
                    'align': []
                }],
                ['clean'],
                ['link', 'image']
            ]
        }
    });

    // Set initial content
    aboutQuill.root.innerHTML = '<p><strong>«Envast» platformasi</strong> – bu koʻchmas mulkka halol va ulushli investitsiyalarni amalga oshirish uchun yaratilgan raqamli axborot tizimidir. Platforma investorlarga ulushli moliyalashtirish asosida loyihalarda ishtirok etish, investitsiya shartlarini kuzatish va daromad taqsimotini onlayn nazorat qilish imkonini beradi.</p>';

    // Tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('button[data-bs-toggle="tab"]');
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Icon preview update
        document.querySelectorAll('input[placeholder*="fa-"]').forEach(input => {
            input.addEventListener('input', function() {
                updateIconPreview(this);
            });
        });
    });

    // Update icon preview
    function updateIconPreview(inputElement) {
        const iconClass = inputElement.value;
        const previewDiv = inputElement.closest('.row').querySelector('.icon-preview i');
        if (previewDiv) {
            const oldClasses = Array.from(previewDiv.classList).filter(cls =>
                cls.startsWith('fa-') || cls.startsWith('fab-') || cls.startsWith('fas-')
            );
            previewDiv.classList.remove(...oldClasses);

            // Add new icon classes
            iconClass.split(' ').forEach(cls => {
                if (cls) previewDiv.classList.add(cls);
            });
        }
    }

    // File item functions
    function addFileItem() {
        const template = document.getElementById('file-item-template');
        const clone = template.content.cloneNode(true);
        document.querySelector('#about .add-new-btn').before(clone);
    }

    function removeFileItem(button) {
        button.closest('.file-item').remove();
    }

    // Company item functions
    function addCompanyItem() {
        const template = document.getElementById('dynamic-item-template');
        const clone = template.content.cloneNode(true);
        document.querySelector('#company .add-new-btn').before(clone);
    }

    function removeDynamicItem(button) {
        button.closest('.dynamic-item').remove();
    }

    // Legal item functions
    function addLegalItem() {
        const template = document.getElementById('dynamic-item-template');
        const clone = template.content.cloneNode(true);
        document.querySelector('#legal .add-new-btn').before(clone);
    }

    // Contact item functions
    function addContactItem() {
        const template = document.getElementById('contact-item-template');
        const clone = template.content.cloneNode(true);
        document.querySelector('#contact .add-new-btn').before(clone);
    }

    function removeContactItem(button) {
        button.closest('.contact-item').remove();
    }

    // Social item functions
    function addSocialItem() {
        const template = document.getElementById('social-item-template');
        const clone = template.content.cloneNode(true);
        document.querySelector('#social .add-new-btn').before(clone);
    }

    function removeSocialItem(button) {
        button.closest('.social-item').remove();
    }
</script>
@endpush