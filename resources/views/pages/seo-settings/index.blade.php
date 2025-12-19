@extends('layouts.app')

@push('customCss')
    <style>
        :root {
            --primary-color: #1F2937;
            --primary-light: #374151;
            --primary-dark: #111827;
            --success-color: #10B981;
            --info-color: #3B82F6;
            --warning-color: #F59E0B;
        }

        .seo-container {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
            /* padding: 30px; */
            border-radius: 16px;
        }

        .seo-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(31, 41, 55, 0.08);
            transition: all 0.3s ease;
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
            background: var(--primary-color);
            border-radius: 16px 0 0 16px;
        }

        .seo-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -4px rgba(31, 41, 55, 0.15);
        }

        .card-icon {
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
        }

        .seo-card-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

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
            color: var(--primary-color);
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
            box-shadow: 0 0 0 3px rgba(31, 41, 55, 0.1);
        }

        .meta-value::after {
            content: '📋';
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .meta-value:hover::after {
            opacity: 0.5;
        }

        .meta-hint {
            font-size: 12px;
            color: #9CA3AF;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .meta-hint i {
            font-size: 11px;
        }

        .alert-modern {
            background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%);
            border: 2px solid #3B82F6;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 28px;
            display: flex;
            align-items: start;
            gap: 16px;
        }

        .alert-icon {
            width: 44px;
            height: 44px;
            background: #3B82F6;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            flex-shrink: 0;
        }

        .preview-box {
            background: white;
            border-radius: 12px;
            padding: 24px;
            border: 2px solid #E5E7EB;
            margin-top: 20px;
        }

        .preview-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px solid #E5E7EB;
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

        .search-result {
            max-width: 600px;
            font-family: Arial, sans-serif;
        }

        .search-title {
            color: #1a0dab;
            font-size: 20px;
            font-weight: 500;
            line-height: 1.3;
            margin-bottom: 4px;
            cursor: pointer;
        }

        .search-title:hover {
            text-decoration: underline;
        }

        .search-url {
            color: #006621;
            font-size: 14px;
            line-height: 1.3;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .search-description {
            color: #4d5156;
            font-size: 14px;
            line-height: 1.58;
        }

        .tips-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-top: 24px;
            border: 2px solid #E5E7EB;
        }

        .tips-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 2px solid #E5E7EB;
        }

        .tips-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .tip-item {
            display: flex;
            align-items: start;
            gap: 14px;
            padding: 14px;
            margin-bottom: 10px;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .tip-item:hover {
            background: #F9FAFB;
        }

        .tip-icon {
            width: 32px;
            height: 32px;
            background: #10B981;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 14px;
            flex-shrink: 0;
        }

        .tip-text {
            color: #4B5563;
            font-size: 14px;
            line-height: 1.6;
            flex: 1;
        }

        .tip-text strong {
            color: var(--primary-color);
            font-weight: 600;
        }

        .save-button {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border: none;
            padding: 14px 32px;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(31, 41, 55, 0.3);
        }

        .save-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(31, 41, 55, 0.4);
        }

        .save-button:active {
            transform: translateY(0);
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
            .seo-container {
                padding: 20px;
            }

            .seo-card {
                padding: 20px;
            }

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
            <a href="{{ route('admin.seo-settings.edit', 1) }}" class="btn btn-primary btn-sm px-3 py-1"
                style="min-width: 90px;">
                <i class="fa-jelly-duo fa-solid fa-pencil" style="font-size: 0.85rem;"></i> Tahrirlash
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="seo-container mt-3">
        <!-- Alert -->
        <div class="alert-modern">
            <div class="alert-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div>
                <div style="font-weight: 600; color: #1F2937; margin-bottom: 6px;">SEO Sozlamalari</div>
                <div style="color: #4B5563; font-size: 14px; line-height: 1.6;">
                    Ushbu sahifada <strong>Envast</strong> platformasining SEO meta ma'lumotlarini sozlashingiz mumkin.
                    To'g'ri meta ma'lumotlar qidiruv tizimlarida yuqori o'rinlarda chiqishga yordam beradi.
                </div>
            </div>
        </div>

        <!-- Umumiy SEO Sozlamalari -->
        <div class="seo-card">
            <div class="card-icon">
                <i class="fas fa-globe"></i>
            </div>
            <h3 class="seo-card-title">Umumiy SEO Sozlamalari</h3>

            <div class="grid-2">
                <div class="meta-field">
                    <div class="meta-label">
                        <i class="fas fa-heading"></i>
                        Sayt Sarlavhasi (Title)
                    </div>
                    <div class="meta-value">
                        {{ $model['general']['title'] }}
                    </div>
                    <div class="meta-hint">
                        <i class="fas fa-ruler"></i>
                        Ideal uzunlik: 50-60 belgi
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
                    <div class="meta-hint">
                        <i class="fas fa-tags"></i>
                        Kalit so'zlarni vergul bilan ajrating
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
                <div class="meta-hint">
                    <i class="fas fa-ruler"></i>
                    Ideal uzunlik: 150-160 belgi
                </div>
            </div>
        </div>

        <!-- Asosiy Sahifa SEO -->
        <div class="seo-card">
            <div class="card-icon">
                <i class="fas fa-home"></i>
            </div>
            <h3 class="seo-card-title">Asosiy Sahifa SEO Sozlamalari</h3>

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
            <h3 class="seo-card-title">Biz Haqimizda Sahifasi SEO</h3>

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
            <h3 class="seo-card-title">Investitsion Loyihalar Sahifasi SEO</h3>

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
            <h3 class="seo-card-title">Shariatga Muvofiqligi Sahifasi SEO</h3>

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
            <h3 class="seo-card-title">Media Sahifasi SEO</h3>

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
            <h3 class="seo-card-title">Aloqa Sahifasi SEO</h3>

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
            <h3 class="seo-card-title">Open Graph (Social Media) Sozlamalari</h3>

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

        <!-- Google Preview -->
        <div class="preview-box">
            <div class="preview-header">
                <div class="preview-icon">
                    <img src="{{ asset('assets/img/icons/chrome.svg') }}" alt="Chrome Icon">
                </div>
                <h3 style="margin: 0; color: #1F2937; font-size: 18px; font-weight: 600;">
                    Google Qidiruv Natijasida Ko'rinishi
                </h3>
            </div>

            <div class="search-result">
                <div class="search-title">{{ $model['general']['title'] }}</div>
                <div class="search-url">
                    <i class="fas fa-globe" style="font-size: 12px;"></i>
                    https://envast.uz › investitsiya
                </div>
                <div class="search-description">
                    Envast platformasi orqali ko'chmas mulk investitsiyalari, ulushli moliyalashtirish va daromad kuzatuvi
                    imkoniyati.
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
