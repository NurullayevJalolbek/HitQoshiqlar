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

    .status-indicator {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .status-active {
        background-color: rgba(46, 204, 113, 0.1);
        color: var(--success-color);
    }

    .status-inactive {
        background-color: rgba(231, 76, 60, 0.1);
        color: var(--danger-color);
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

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border-color);
    }

    /* SEO uchun maxsus stillar */
    .seo-card {
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        background-color: #ffffff;
        position: relative;
        overflow: hidden;
    }


    .seo-card::before {
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

    .seo-card:hover {
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
    }

    /* .seo-card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    } */

    .seo-card-title {
        font-size: 20px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .seo-card-title i {
        margin-right: 0.75rem;
        color: #1F2937;
    }

    .preview-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }

    .seo-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1.25rem;
    }

    /* .card-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
        margin-bottom: 20px;
        box-shadow: 0 4px 12px rgba(31, 41, 55, 0.2);
    } */



    .meta-field {
        background: #F9FAFB;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 16px;
        border: 2px solid #E5E7EB;
        transition: all 0.3s ease;
    }

    .meta-field:hover {
        border-color: var(--primary-color);
        background: white;
    }

    .meta-label {
        font-size: 13px;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .meta-label i {
        color: #1F2937;
        font-size: 14px;
    }

    .meta-value {
        background: white;
        padding: 14px 16px;
        border-radius: 8px;
        border: 1px solid #E5E7EB;
        color: #1F2937;
        font-size: 14px;
        line-height: 1.6;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .meta-value:hover {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    .grid-2 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 18px;
    }

    .grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 18px;
    }

    @media (max-width: 768px) {

        .grid-2,
        .grid-3 {
            grid-template-columns: 1fr;
        }
    }
</style>


@endpush


@section('breadcrumb')
@php
$model = getSEOSettings();
@endphp
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
    style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
    <!-- Breadcrumb -->
    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.general-settings.index') }}">
                        Umumiy sozlamalar
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    SEO Sozlamalari
                </li>
            </ol>
        </nav>
    </div>

    <div class="d-flex gap-2 align-items-center flex-wrap">

        <x-go-back url="{{ $go_back }}" />
    </div>



</div>
@endsection

@section('content')

<div class=" py-3">
    <div class="content-container" style="background-color: white; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.625rem rgba(0,0,0,0.08); padding: 1.5rem;">

        <h1 class="section-title">
            <i class="fas fa-search directory-icon"></i>
            SEO Sozlamalari
        </h1>

        <div class="info-badge">
            <i class="fas fa-info-circle"></i>
            Ushbu sahifada «Envast» platformasining SEO meta ma'lumotlarini sozlashingiz mumkin.
            To'g'ri meta ma'lumotlar qidiruv tizimlarida yuqori o'rinlarda chiqishga yordam beradi.
        </div>


        <!-- Umumiy SEO Sozlamalari -->
        <div class="seo-card">
            <div class="card-icon">
                <i class="fas fa-globe"></i>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <h3 class="seo-card-title">Umumiy SEO Sozlamalari</h3>

                <x-edit-button-border
                    :url="route('admin.seo-settings.edit', [$model['general']['key'], 'go_back' => url()->full()])"
                    text="Tahrirlash" />
            </div>




            <div class="grid-2">
                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-heading"></i>
                        Sayt Sarlavhasi (Title)
                    </div>
                    <div class="meta-value">
                        {{ $model['general']['title'] }}
                    </div>

                </div>

                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-key"></i>
                        Sayt Kalit So'zlari (Keywords)
                    </div>
                    <div class="meta-value">
                        {{ $model['general']['keywords'] }}
                    </div>

                </div>
            </div>

            <div class="meta-field">
                <div class="meta-label">
                    <i class="fas fa-align-left"></i>
                    Sayt Tavsifi (Description)
                </div>
                <div class="meta-value">
                    {{ $model['general']['description'] }}
                </div>

            </div>
        </div>

        <!-- Asosiy Sahifa SEO -->
        <div class="seo-card">
            <div class="card-icon">
                <i class="fas fa-home"></i>
            </div>


            <div class="d-flex justify-content-between align-items-center">
                <h3 class="seo-card-title">Asosiy Sahifa SEO Sozlamalari</h3>

                <x-edit-button-border
                    :url="route('admin.seo-settings.edit', [$model['home']['key'], 'go_back' => url()->full()])"
                    text="Tahrirlash" />
            </div>

            <div class="grid-2">
                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-text-height"></i>
                        Meta Title
                    </div>
                    <div class="meta-value">
                        {{ $model['home']['title'] }}
                    </div>
                </div>
                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-key"></i>
                        Kalit So'zlar (Keywords)
                    </div>
                    <div class="meta-value">
                        {{ $model['home']['keywords'] }}
                    </div>
                </div>



            </div>
            <div class="meta-field">
                <div class="meta-label">
                    <i class="fas fa-paragraph"></i>
                    Meta Description
                </div>
                <div class="meta-value">
                    {{ $model['home']['description'] }}
                </div>
            </div>

        </div>

        <!-- Biz haqimizda Sahifasi SEO -->
        <div class="seo-card">
            <div class="card-icon">
                <i class="fas fa-info-circle"></i>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <h3 class="seo-card-title">Biz Haqimizda Sahifasi SEO</h3>


                <x-edit-button-border
                    :url="route('admin.seo-settings.edit', [$model['about']['key'], 'go_back' => url()->full()])"
                    text="Tahrirlash" />
            </div>

            <div class="grid-2">
                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-text-height"></i>
                        Meta Title
                    </div>
                    <div class="meta-value">
                        {{ $model['about']['title'] }}
                    </div>
                </div>


                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-key"></i>
                        Kalit So'zlar (Keywords)
                    </div>
                    <div class="meta-value">
                        {{ $model['about']['keywords'] }}
                    </div>
                </div>
            </div>

            <div class="meta-field">
                <div class="meta-label">
                    <i class="fas fa-paragraph"></i>
                    Meta Description
                </div>
                <div class="meta-value">
                    {{ $model['about']['description'] }}
                </div>
            </div>
        </div>

        <!-- Investitsion Loyihalar Sahifasi SEO -->
        <div class="seo-card">
            <div class="card-icon">
                <i class="fas fa-building"></i>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <h3 class="seo-card-title">Investitsion Loyihalar Sahifasi SEO</h3>


                <x-edit-button-border
                    :url="route('admin.seo-settings.edit', [$model['projects']['key'], 'go_back' => url()->full()])"
                    text="Tahrirlash" />
            </div>

            <div class="grid-2">
                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-text-height"></i>
                        Meta Title
                    </div>
                    <div class="meta-value">
                        {{ $model['projects']['title'] }}
                    </div>
                </div>


                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-key"></i>
                        Kalit So'zlar (Keywords)
                    </div>
                    <div class="meta-value">
                        {{ $model['projects']['keywords'] }}
                    </div>
                </div>
            </div>
            <div class="meta-field">
                <div class="meta-label">
                    <i class="fas fa-paragraph"></i>
                    Meta Description
                </div>
                <div class="meta-value">
                    {{ $model['projects']['description'] }}
                </div>
            </div>

        </div>

        <!-- Shariatga Muvofiqligi Sahifasi SEO -->
        <div class="seo-card">
            <div class="card-icon">
                <i class="fas fa-star-and-crescent"></i>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <h3 class="seo-card-title">Shariatga Muvofiqligi Sahifasi SEO</h3>


                <x-edit-button-border
                    :url="route('admin.seo-settings.edit', [$model['shariah']['key'], 'go_back' => url()->full()])"
                    text="Tahrirlash" />
            </div>

            <div class="grid-2">
                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-text-height"></i>
                        Meta Title
                    </div>
                    <div class="meta-value">
                        {{ $model['shariah']['title'] }}
                    </div>
                </div>



                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-key"></i>
                        Kalit So'zlar (Keywords)
                    </div>
                    <div class="meta-value">
                        {{ $model['shariah']['keywords'] }}
                    </div>
                </div>
            </div>
            <div class="meta-field">
                <div class="meta-label">
                    <i class="fas fa-paragraph"></i>
                    Meta Description
                </div>
                <div class="meta-value">
                    {{ $model['shariah']['description'] }}
                </div>
            </div>
        </div>

        <!-- Media Sahifasi SEO -->
        <div class="seo-card">
            <div class="card-icon">
                <i class="fas fa-photo-video"></i>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <h3 class="seo-card-title">Media Sahifasi SEO</h3>


                <x-edit-button-border
                    :url="route('admin.seo-settings.edit', [$model['media']['key'], 'go_back' => url()->full()])"
                    text="Tahrirlash" />
            </div>

            <div class="grid-2">
                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-text-height"></i>
                        Meta Title
                    </div>
                    <div class="meta-value">
                        {{ $model['media']['title'] }}
                    </div>
                </div>



                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-key"></i>
                        Kalit So'zlar (Keywords)
                    </div>
                    <div class="meta-value">
                        {{ $model['media']['keywords'] }}
                    </div>
                </div>
            </div>
            <div class="meta-field">
                <div class="meta-label">
                    <i class="fas fa-paragraph"></i>
                    Meta Description
                </div>
                <div class="meta-value">
                    {{ $model['media']['description'] }}
                </div>
            </div>
        </div>

        <!-- Aloqa Sahifasi SEO -->
        <div class="seo-card">
            <div class="card-icon">
                <i class="fas fa-phone-alt"></i>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <h3 class="seo-card-title">Aloqa Sahifasi SEO</h3>


                <x-edit-button-border
                    :url="route('admin.seo-settings.edit', [$model['contact']['key'], 'go_back' => url()->full()])"
                    text="Tahrirlash" />
            </div>

            <div class="grid-2">
                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-text-height"></i>
                        Meta Title
                    </div>
                    <div class="meta-value">
                        {{ $model['contact']['title'] }}
                    </div>
                </div>



                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-key"></i>
                        Kalit So'zlar (Keywords)
                    </div>
                    <div class="meta-value">
                        {{ $model['contact']['keywords'] }}
                    </div>
                </div>
            </div>
            <div class="meta-field">
                <div class="meta-label">
                    <i class="fas fa-paragraph"></i>
                    Meta Description
                </div>
                <div class="meta-value">
                    {{ $model['contact']['description'] }}
                </div>
            </div>
        </div>

        <!-- Open Graph Sozlamalari -->
        <div class="seo-card">
            <div class="card-icon">
                <i class="fab fa-facebook"></i>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <h3 class="seo-card-title">Open Graph (Social Media) Sozlamalari</h3>


                <x-edit-button-border
                    :url="route('admin.seo-settings.edit', [$model['og']['key'], 'go_back' => url()->full()])"
                    text="Tahrirlash" />
            </div>

            <div class="grid-3">
                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-heading"></i>
                        OG Title
                    </div>
                    <div class="meta-value">
                        {{ $model['og']['title'] }}
                    </div>
                </div>



                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-image"></i>
                        OG Image URL
                    </div>
                    <div class="meta-value">
                        {{ $model['og']['image'] }}
                    </div>
                </div>
            </div>
            <div class="meta-field">
                <div class="meta-label">
                    <i class="fas fa-align-left"></i>
                    OG Description
                </div>
                <div class="meta-value">
                    {{ $model['og']['description'] }}
                </div>
            </div>
        </div>

        @php
        $seo = getSEOSettings('general'); // yoki kerakli sahifa: 'home', 'projects' va h.k.
        @endphp


        <!-- Google Preview -->
        <div class="preview-box"
            style="border: 1px solid #E5E7EB; border-radius: 12px; padding: 16px; background-color: #ffffff;">
            <div class="preview-header">
                <div class="preview-icon">
                    <img src="{{ asset('assets/img/icons/chrome.svg') }}" alt="Chrome Icon">
                </div>
                <h3 style="margin: 0; color: #1F2937; font-size: 18px; font-weight: 600;">
                    Google Qidiruv Natijasida Ko'rinishi
                </h3>
            </div>

            <div class="search-result">
                <div class="search-title" style="color:#1a0dab; font-size:16px; font-weight:500;">
                    {{ $seo->title }}
                </div>
                <div class="search-url" style="color:#006621; font-size:12px; margin:4px 0;">
                    <img src="{{ asset('assets/img/envast_logo.svg') }}" alt="Favicon"
                        style="width:12px; height:12px; margin-right:4px; vertical-align:middle;">

                    https://envast.uz › investitsiya
                </div>
                <div class="search-description" style="color:#545454; font-size:13px; line-height:1.5;">
                    {{ $seo->description }}
                </div>
            </div>
        </div>



        <div
            style="border: 1px solid #FACC15; border-radius: 12px; padding: 20px; background-color: #FEF3C7; margin-top: 16px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">

            <!-- Card Title -->
            <div style="font-weight: 700; font-size: 18px; color: #92400E; margin-bottom: 12px;">SEO bo‘yicha maslahatlar
            </div>

            <!-- Intro Text -->
            <div style="color: #92400E; font-size: 14px; line-height: 1.7; margin-bottom: 16px;">
                Ushbu tavsiyalar yordamida sahifangizning SEO meta ma'lumotlarini to‘g‘ri sozlash va qidiruv tizimlarida
                yuqori o‘rinlarga chiqish imkoniyatini oshirishingiz mumkin.
                Meta sarlavhalar, kalit so‘zlar va tavsiflar sahifa reytingiga bevosita ta’sir qiladi.
            </div>

            <!-- Tips List -->
            <ul style="color: #78350F; font-size: 14px; line-height: 1.8; padding-left: 20px; margin: 0;">
                <li>Sayt sarlavhasi (Title) <strong>50-60 belgidan oshmasligi</strong> kerak.</li>
                <li>Kalit so‘zlar (Keywords) ni <strong>vergul bilan ajrating</strong> va ortiqcha so‘zlardan saqlaning.
                </li>
                <li>Tavsif (Description) <strong>150-160 belgi</strong> oralig‘ida bo‘lsin.</li>
                <li>Har bir sahifa uchun meta ma’lumotlar <strong>noyob</strong> bo‘lishi kerak.</li>
                <li>Sahifa URL manzili qisqa, tushunarli va kalit so‘zni o‘z ichiga olishi kerak.</li>
                <li>Rasm alt attributlarini (alt text) to‘g‘ri to‘ldiring, qidiruv tizimi uchun optimallashtirilgan bo‘lsin.
                </li>
            </ul>

            <!-- Optional Note -->
            <div style="margin-top: 16px; color: #92400E; font-size: 13px; line-height: 1.6;">
                <strong>Izoh:</strong> Yuqoridagi maslahatlar SEO asosiy qoidalariga asoslangan bo‘lib, sahifangizni qidiruv
                tizimlariga moslashtirishda yordam beradi.
            </div>
        </div>
    </div>
</div>
@endsection

@push('customJs')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Copy functionality
        document.querySelectorAll('.meta-value').forEach(function(element) {
            element.addEventListener('click', function() {
                const text = this.textContent.trim();
                navigator.clipboard.writeText(text).then(function() {
                    const originalBg = element.style.backgroundColor;
                    const originalBorder = element.style.borderColor;
                    const originalText = element.textContent;

                    element.style.backgroundColor = '#D1FAE5';
                    element.style.borderColor = '#10B981';
                    element.innerHTML =
                        '<i class="fas fa-check" style="color: #10B981; margin-right: 8px;"></i>Nusxalandi!';

                    setTimeout(function() {
                        element.textContent = originalText;
                        element.style.backgroundColor = originalBg;
                        element.style.borderColor = originalBorder;
                    }, 1500);
                });
            });
        });

        // Save button functionality
        document.querySelector('.save-button').addEventListener('click', function() {
            const button = this;
            const originalHTML = button.innerHTML;

            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saqlanmoqda...';
            button.disabled = true;
            button.style.opacity = '0.7';

            setTimeout(function() {
                button.innerHTML =
                    '<i class="fas fa-check-circle"></i> Muvaffaqiyatli saqlandi!';
                button.style.background = 'linear-gradient(135deg, #10B981 0%, #059669 100%)';
                button.style.opacity = '1';

                setTimeout(function() {
                    button.innerHTML = originalHTML;
                    button.style.background =
                        'linear-gradient(135deg, #1F2937 0%, #374151 100%)';
                    button.disabled = false;
                }, 2500);
            }, 1500);
        });
    });
</script>
@endpush