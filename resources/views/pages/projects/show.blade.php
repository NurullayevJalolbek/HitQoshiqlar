@extends('layouts.app')
@push('customCss')
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-dark: #1e40af;
            --success-color: #16a34a;
            --warning-color: #ea580c;
            --danger-color: #dc2626;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-900: #111827;
            --border-radius: 0.5rem;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .project-header {
            background: #ffffff;
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 1.5rem;
            margin-top: 0.5rem;
            border: 1px solid var(--gray-200);
        }

        .project-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .project-code {
            color: var(--gray-600);
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .status-row {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .status-badge {
            padding: 0.375rem 0.875rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-block;
            border: 1px solid;
        }

        .status-active {
            background: #dcfce7;
            color: #166534;
            border-color: #86efac;
        }

        .status-planned {
            background: #dbeafe;
            color: #1e40af;
            border-color: #93c5fd;
        }

        .status-completed {
            background: #f3e8ff;
            color: #6b21a8;
            border-color: #d8b4fe;
        }

        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
            border-color: #fca5a5;
        }

        .funding-display {
            text-align: right;
        }

        .funding-percent {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            line-height: 1;
        }

        .funding-label {
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .tab-navigation {
            display: flex;
            gap: 0;
            border-bottom: 2px solid var(--gray-200);
            margin-bottom: 2rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .tab-button {
            padding: 0.875rem 1.25rem;
            border: none;
            background: transparent;
            color: var(--gray-600);
            font-weight: 500;
            font-size: 0.9rem;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .tab-button.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
        }

        .tab-button:hover {
            color: var(--primary-dark);
            background: var(--gray-50);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .info-card {
            background: #ffffff;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--gray-200);
        }

        .info-card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-grid {
            display: grid;
            gap: 1rem;
        }

        .info-row {
            display: grid;
            grid-template-columns: minmax(180px, 1fr) 2fr;
            gap: 1rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: var(--gray-600);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .info-value {
            color: var(--gray-900);
            font-weight: 600;
        }

        .media-placeholder {
            background: var(--gray-100);
            border: 2px dashed var(--gray-300);
            border-radius: var(--border-radius);
            padding: 3rem 2rem;
            text-align: center;
            color: var(--gray-600);
            margin-bottom: 1rem;
        }

        .media-placeholder i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
            color: var(--gray-400);
        }

        .progress-section {
            margin-bottom: 2rem;
        }

        .progress-bar-wrapper {
            background: var(--gray-100);
            border-radius: 0.5rem;
            height: 2.5rem;
            overflow: hidden;
            position: relative;
            border: 1px solid var(--gray-200);
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            transition: width 0.5s ease;
        }

        .timeline {
            position: relative;
            padding-left: 2.5rem;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 2rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-marker {
            position: absolute;
            left: -2.5rem;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: 600;
            border: 3px solid;
            background: white;
        }

        .timeline-marker.completed {
            color: var(--success-color);
            border-color: var(--success-color);
        }

        .timeline-marker.in-progress {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .timeline-marker.planned {
            color: var(--gray-400);
            border-color: var(--gray-300);
        }

        .timeline-line {
            position: absolute;
            left: -1.3rem;
            top: 2.5rem;
            bottom: 0;
            width: 2px;
            background: var(--gray-200);
        }

        .timeline-item:last-child .timeline-line {
            display: none;
        }

        .timeline-content {
            background: var(--gray-50);
            padding: 1rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-200);
        }

        .timeline-title {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
        }

        .timeline-date {
            color: var(--gray-600);
            font-size: 0.85rem;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-200);
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .partner-card {
            background: var(--gray-50);
            padding: 1.25rem;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-200);
            margin-bottom: 1rem;
        }

        .partner-header {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .risk-item {
            padding: 1rem;
            background: var(--gray-50);
            border-radius: var(--border-radius);
            margin-bottom: 0.75rem;
            border-left: 4px solid var(--warning-color);
        }

        .risk-title {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .risk-description {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin: 0;
        }

        .document-list {
            display: grid;
            gap: 0.75rem;
        }

        .document-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-200);
            transition: all 0.2s;
        }

        .document-item:hover {
            background: white;
            border-color: var(--primary-color);
        }

        .document-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .document-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: var(--primary-color);
            color: white;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .round-item {
            background: var(--gray-50);
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 0.75rem;
            border: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .round-info h6 {
            margin: 0 0 0.5rem 0;
            font-weight: 600;
            color: var(--gray-900);
        }

        .round-amount {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .distribution-visual {
            display: flex;
            height: 3rem;
            border-radius: var(--border-radius);
            overflow: hidden;
            margin: 1.5rem 0;
            border: 1px solid var(--gray-200);
        }

        .distribution-segment {
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .segment-partners {
            background: var(--primary-color);
        }

        .segment-investors {
            background: var(--success-color);
        }

        .map-container {
            width: 100%;
            height: 300px;
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid var(--gray-200);
            margin-top: 1rem;
        }

        .dividend-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.875rem;
            background: var(--gray-50);
            border-radius: var(--border-radius);
            margin-bottom: 0.5rem;
            border: 1px solid var(--gray-200);
        }

        .dividend-date {
            font-weight: 600;
            color: var(--gray-900);
        }

        .dividend-status {
            font-size: 0.85rem;
            color: var(--gray-600);
        }

        .dividend-amount {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--success-color);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .gallery-item {
            position: relative;
            border-radius: var(--border-radius);
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s;
            aspect-ratio: 16/9;
        }

        .gallery-item:hover {
            transform: translateY(-4px);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-embed {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: var(--border-radius);
            margin-bottom: 1rem;
        }

        .video-embed iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .image-slider {
            position: relative;
            border-radius: var(--border-radius);
            overflow: hidden;
            height: 400px;
            background: var(--gray-100);
        }

        .image-slider img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            transition: background 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slider-nav:hover {
            background: rgba(0, 0, 0, 0.7);
        }

        .slider-nav.prev {
            left: 1rem;
        }

        .slider-nav.next {
            right: 1rem;
        }

        .slider-indicators {
            position: absolute;
            bottom: 1rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 0.5rem;
            z-index: 10;
        }

        .indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s;
        }

        .indicator.active {
            background: white;
            width: 30px;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .info-row {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .funding-display {
                text-align: left;
                margin-top: 1rem;
            }

            .stat-grid {
                grid-template-columns: 1fr;
            }

            .tab-navigation {
                gap: 0;
            }

            .tab-button {
                font-size: 0.85rem;
                padding: 0.75rem 1rem;
            }
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: var(--border-radius);
            border: 1px solid;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-success {
            background: var(--success-color);
            color: white;
            border-color: var(--success-color);
        }

        .btn-outline {
            background: white;
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 px-3 mt-3"
        style="border: 1px solid var(--gray-200); border-radius: var(--border-radius); background-color: #ffffff;">
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">Loyihalar</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Loyiha kartochkasi</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button class="btn-action btn-primary" onclick="enableEdit()">
                <i class="bi bi-pencil"></i> Tahrirlash
            </button>
            <button class="btn-action btn-success" id="saveBtn" style="display: none;" onclick="saveChanges()">
                <i class="bi bi-check-lg"></i> Saqlash
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="project-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="project-title" id="projectName">Yuklanmoqda...</h1>
                <p class="project-code" id="projectCode">ID: -</p>
                <div class="status-row">
                    <span class="status-badge" id="projectStatus">-</span>
                    <span class="status-badge" id="projectCategory">-</span>
                </div>
            </div>
            <div class="col-md-4 funding-display">
                <div class="funding-percent" id="fundingPercent">0%</div>
                <div class="funding-label">Moliyalashtirilganlik darajasi</div>
            </div>
        </div>
    </div>

    <div class="card card-body shadow-sm border-0">
        <div class="tab-navigation">
            <button class="tab-button active" onclick="switchTab('characteristics')">Karakteristik ma'lumotlar</button>
            <button class="tab-button" onclick="switchTab('stages')">Loyiha bosqichlari</button>
            <button class="tab-button" onclick="switchTab('distribution')">Taqsimot sozlamalari</button>
            <button class="tab-button" onclick="switchTab('rounds')">Loyiha raundlari</button>
            <button class="tab-button" onclick="switchTab('financial')">Moliyaviy ko'rsatkichlar</button>
            <button class="tab-button" onclick="switchTab('partners')">To'liq sheriklar</button>
            <button class="tab-button" onclick="switchTab('risks')">Risklar</button>
            <button class="tab-button" onclick="switchTab('documents')">Loyiha hujjatlari</button>
        </div>

        <div id="characteristics" class="tab-content active">
            <!-- Main Images Slider -->
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-images"></i>
                    Asosiy fon rasmlari
                </h5>
                <div class="image-slider" id="mainImageSlider">
                    <button class="slider-nav prev" onclick="changeMainSlide(-1)">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <img src="" alt="Loyiha rasmi" id="mainSliderImage">
                    <button class="slider-nav next" onclick="changeMainSlide(1)">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                    <div class="slider-indicators" id="mainSliderIndicators"></div>
                </div>
            </div>

            <!-- Videos Section -->
            <div class="info-card" id="videosCard">
                <h5 class="info-card-title">
                    <i class="bi bi-camera-video"></i>
                    Loyiha videolari
                </h5>
                <div id="videosContainer"></div>
            </div>

            <!-- Construction Process Images -->
            <div class="info-card" id="processImagesCard">
                <h5 class="info-card-title">
                    <i class="bi bi-camera"></i>
                    Qurilish jarayoniga doir rasmlar
                </h5>
                <div class="gallery-grid" id="processImagesContainer"></div>
            </div>

            <!-- Basic Information -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="info-card">
                        <h5 class="info-card-title">
                            <i class="bi bi-info-circle"></i>
                            Asosiy ma'lumotlar
                        </h5>
                        <div class="info-grid">
                            <div class="info-row">
                                <span class="info-label">Loyihaning unikal IDsi</span>
                                <span class="info-value" id="projectId">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Nomi</span>
                                <span class="info-value" id="name">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Qisqacha tavsif</span>
                                <span class="info-value" id="shortDesc">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Maqsadi</span>
                                <span class="info-value" id="purpose">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Kategoriya</span>
                                <span class="info-value" id="category">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Holati</span>
                                <span class="info-value" id="status">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info-card">
                        <h5 class="info-card-title">
                            <i class="bi bi-geo-alt"></i>
                            Joylashuv manzili
                        </h5>
                        <div class="info-grid">
                            <div class="info-row">
                                <span class="info-label">Shahar</span>
                                <span class="info-value" id="city">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Tuman</span>
                                <span class="info-value" id="district">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Ko'cha</span>
                                <span class="info-value" id="street">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Uy</span>
                                <span class="info-value" id="house">-</span>
                            </div>
                        </div>
                        <h6 style="margin-top: 1.5rem; margin-bottom: 0.5rem; font-weight: 600;">Joylashuv lokatsiyasi</h6>
                        <div class="map-container">
                            <iframe id="mapFrame" width="100%" height="100%" frameborder="0" style="border:0"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="info-card">
                        <h5 class="info-card-title">
                            <i class="bi bi-briefcase"></i>
                            Loyiha boshqaruvchisi
                        </h5>
                        <div class="info-grid">
                            <div class="info-row">
                                <span class="info-label">Tashkilot nomi</span>
                                <span class="info-value" id="managerOrg">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Litsenziya raqami</span>
                                <span class="info-value" id="licenseNumber">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" id="constructionCard" style="display: none;">
                    <div class="info-card">
                        <h5 class="info-card-title">
                            <i class="bi bi-building"></i>
                            Qurilish tashkiloti haqida ma'lumot
                        </h5>
                        <div class="info-grid">
                            <div class="info-row">
                                <span class="info-label">Tashkilot nomi</span>
                                <span class="info-value" id="constructionName">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Logotipi</span>
                                <span class="info-value" id="constructionLogo">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Qisqacha tavsif</span>
                                <span class="info-value" id="constructionDesc">-</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="stages" class="tab-content">
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-diagram-3"></i>
                    Loyiha (mulk) bosqichlari
                </h5>
                <div class="progress-section">
                    <div class="progress-bar-wrapper">
                        <div class="progress-bar-fill" id="progressBar" style="width: 0%">0%</div>
                    </div>
                </div>
                <div class="timeline" id="timeline"></div>
            </div>
        </div>

        <div id="distribution" class="tab-content">
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-pie-chart"></i>
                    Taqsimot sozlamalari
                </h5>
                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">To'liq sherikning investitsion loyihadagi o'ziga tegishli ulushining
                            realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                        <span class="info-value" id="fullPartnerOwnShare">100%</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">To'liq sherikning investitsion Kommanditchilarning loyihadagi tegishli
                            ulushining realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                        <span class="info-value" id="fullPartnerInvestorShare">30%</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kommanditchilarning investitsion loyihadagi o'ziga tegishli ulushining
                            realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                        <span class="info-value" id="investorsOwnShare">70%</span>
                    </div>
                </div>

                <h6 style="margin-top: 2rem; margin-bottom: 1rem; font-weight: 600;">Vizual taqsimot</h6>
                <div class="distribution-visual">
                    <div class="distribution-segment segment-partners" style="width: 30%">
                        To'liq sheriklar: 30%
                    </div>
                    <div class="distribution-segment segment-investors" style="width: 70%">
                        Kommanditchilar: 70%
                    </div>
                </div>
            </div>
        </div>

        <div id="rounds" class="tab-content">
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-arrow-repeat"></i>
                    Loyiha raundlari
                </h5>
                <div id="roundsContainer"></div>
            </div>
        </div>

        <div id="financial" class="tab-content">
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-cash-stack"></i>
                    Moliyaviy ko'rsatkichlar
                </h5>
                <div class="stat-grid">
                    <div class="stat-card">
                        <div class="stat-value" id="totalValue">0</div>
                        <div class="stat-label">Umumiy qiymati</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="minShare">0</div>
                        <div class="stat-label">Minimal ulush miqdori narxi</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="yearlyProfit">0%</div>
                        <div class="stat-label">Kutilayotgan daromad (yillik, foizlarda)</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="fundingStatus">0%</div>
                        <div class="stat-label">Moliyalashtirilganlik holati ko'rsatkichi</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="investmentPeriod">-</div>
                        <div class="stat-label">Investitsiya davri yoki davomiyligi</div>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Rentabellik ko'rsatkichi (%) yoki prognoz qilingan daromad summasi</span>
                        <span class="info-value" id="profitability">-</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">To'liq sheriklar va Kommanditchilar o'rtasidagi foyda/zararning taqsimot
                            ko'rsatkichlari</span>
                        <span class="info-value" id="distributionIndicators">-</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Taqsimot amaga oshirilishi boshlanadigan davr</span>
                        <span class="info-value" id="distributionStart">-</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Eng oxirgi marta taqsimlangan dividend foiz ko'rsatkichi</span>
                        <span class="info-value" id="lastDividend">-</span>
                    </div>
                </div>

                <h6 style="margin-top: 2rem; margin-bottom: 1rem; font-weight: 600;">Loyiha doirasida taqsimlangan
                    dividendlar tarixi</h6>
                <div id="dividendHistory"></div>
            </div>
        </div>

        <div id="partners" class="tab-content">
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-people"></i>
                    To'liq sheriklar rekvizit ma'lumotlari
                </h5>
                <div id="partnersContainer"></div>
            </div>
        </div>

        <div id="risks" class="tab-content">
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-exclamation-triangle"></i>
                    Xatarlar (Risklar)
                </h5>
                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">Loyihaning boshqarilish modeli nomi</span>
                        <span class="info-value" id="managementModel">-</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Loyihaning boshqarilish modeli qisqacha tavsifi</span>
                        <span class="info-value" id="managementDesc">-</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Loyihaning boshqarilish modeli haqida ma'lumot</span>
                        <span class="info-value" id="managementInfo">-</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Loyihaning xatar darajasi</span>
                        <span class="info-value">
                            <span class="status-badge" id="riskLevel">-</span>
                        </span>
                    </div>
                </div>

                <h6 style="margin-top: 2rem; margin-bottom: 1rem; font-weight: 600;">Mumkin bo'lgan xatarlar</h6>
                <div id="risksContainer"></div>
            </div>
        </div>

        <div id="documents" class="tab-content">
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-file-earmark-text"></i>
                    Loyiha (mulk) hujjatlari
                </h5>
                <div class="document-list" id="documentsContainer"></div>
            </div>
        </div>
    </div>
@endsection

@push('customJs')
    <script>
        let projectData = null;
        let currentTab = 'characteristics';
        let currentMainImageIndex = 0;
        let mainImages = [];

        const mockData = {
            id: 1,
            project_id: "PRJ-2024-001",
            name: "Premium Turar-joy Majmuasi",
            short_description: "Toshkent shahar markazida zamonaviy turar-joy majmuasi qurilishi loyihasi",
            purpose: "Yuqori sifatli va zamonaviy uy-joy bilan ta'minlash, shahar infratuzilmasini rivojlantirish",
            category: "construction",
            status: "active",
            city: "Toshkent",
            district: "Yunusobod",
            street: "Amir Temur ko'chasi",
            house: "123",
            location_lat: 41.311081,
            location_lng: 69.240562,
            manager_organization: "Envast Construction MChJ",
            license_number: "LIC-2024-12345",
            construction_org: {
                name: "Premium Build MChJ",
                logo: "logo_url_placeholder",
                description: "15 yillik tajribaga ega professional qurilish kompaniyasi"
            },
            main_images: [
                "https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=1200&q=80",
                "https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200&q=80",
                "https://images.unsplash.com/photo-1448630360428-65456885c650?w=1200&q=80",
                "https://images.unsplash.com/photo-1519643381401-22c77e60520e?w=1200&q=80"
            ],
            videos: [
                "https://www.youtube.com/embed/QWIoR7vjpBU",
                "https://www.youtube.com/embed/TlP92LPvUjY"
            ],
            process_images: [
                "https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=800&q=80",
                "https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=800&q=80",
                "https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80",
                "https://images.unsplash.com/photo-1590489702772-d6e776a01551?w=800&q=80",
                "https://images.unsplash.com/photo-1487958449943-2429e8be8625?w=800&q=80",
                "https://images.unsplash.com/photo-1503594384566-461fe158e797?w=800&q=80"
            ],
            funding_percent: 72,
            total_value: 5000000000,
            min_share: 10000000,
            yearly_profit: 18,
            funding_status: 72,
            investment_period: "24 oy",
            profitability: "25%",
            distribution_indicators: "To'liq sheriklar: 30%, Kommanditchilar: 70%",
            distribution_start: "2025-yil yanvar",
            last_dividend: 4.5,
            dividend_history: [
                { date: "2024-12", amount: 4.5, status: "To'langan" },
                { date: "2024-09", amount: 4.2, status: "To'langan" },
                { date: "2024-06", amount: 4.0, status: "To'langan" },
                { date: "2024-03", amount: 3.8, status: "To'langan" }
            ],
            stages: [
                {
                    id: 1,
                    name: "Yer sotib olish va ruxsatnomalar",
                    status: "completed",
                    icon: "bi-check-circle",
                    order: 1,
                    start_date: "2024-01",
                    end_date: "2024-02",
                    progress: 20
                },
                {
                    id: 2,
                    name: "Loyiha-smeta hujjatlari tayyorlash",
                    status: "completed",
                    icon: "bi-check-circle",
                    order: 2,
                    start_date: "2024-03",
                    end_date: "2024-04",
                    progress: 15
                },
                {
                    id: 3,
                    name: "Qurilish ishlari boshlash",
                    status: "completed",
                    icon: "bi-check-circle",
                    order: 3,
                    start_date: "2024-05",
                    end_date: "2024-06",
                    progress: 10
                },
                {
                    id: 4,
                    name: "Asosiy konstruksiyalarni qurish",
                    status: "in_progress",
                    icon: "bi-arrow-clockwise",
                    order: 4,
                    start_date: "2024-07",
                    end_date: "2024-12",
                    progress: 30
                },
                {
                    id: 5,
                    name: "Ichki va tashqi bezatish ishlari",
                    status: "planned",
                    icon: "bi-circle",
                    order: 5,
                    start_date: "2025-01",
                    end_date: "2025-03",
                    progress: 15
                },
                {
                    id: 6,
                    name: "Foydalanishga topshirish va hujjatlashtirish",
                    status: "planned",
                    icon: "bi-circle",
                    order: 6,
                    start_date: "2025-04",
                    end_date: "2025-04",
                    progress: 10
                }
            ],
            rounds: [
                {
                    name: "1-raund (Boshlang'ich)",
                    status: "completed",
                    min_share: 5000000
                },
                {
                    name: "2-raund (Asosiy)",
                    status: "in_progress",
                    min_share: 10000000
                },
                {
                    name: "3-raund (Yakunlovchi)",
                    status: "inactive",
                    min_share: 15000000
                }
            ],
            partners: [
                {
                    id: 1,
                    company_name: "Innovatsiya Invest MChJ",
                    inn: "123456789",
                    ifut: "00001",
                    type: "MChJ",
                    address: "Toshkent sh., Yunusobod t., Amir Temur ko'ch., 100-uy",
                    director: "Karimov Jasur Akmalovich",
                    phone: "+998 90 123-45-67",
                    email: "info@innovatsiya.uz",
                    registration_date: "15.05.2020",
                    registration_number: "REG-2020-12345",
                    registration_org: "Yunusobod tumani Adliya bo'limi",
                    passport_data: "-",
                    pinfl: "-",
                    account_status: "active",
                    partnership_date: "10.01.2024",
                    investor_certificate: "certificate_file.pdf",
                    share_amount: 1500000000,
                    share_percent: 30
                },
                {
                    id: 2,
                    company_name: "Aliyev Aziz Karimovich",
                    inn: "987654321",
                    ifut: "-",
                    type: "YaTT",
                    address: "Toshkent sh., Chilonzor t., Bunyodkor ko'ch., 45-uy",
                    director: "Aliyev Aziz Karimovich",
                    phone: "+998 91 234-56-78",
                    email: "aziz@example.uz",
                    registration_date: "20.03.2019",
                    registration_number: "-",
                    registration_org: "-",
                    passport_data: "AA1234567",
                    pinfl: "12345678901234",
                    account_status: "active",
                    partnership_date: "15.02.2024",
                    investor_certificate: "certificate2_file.pdf",
                    share_amount: 1000000000,
                    share_percent: 20
                }
            ],
            risks: {
                management_model: "Markazlashgan boshqaruv modeli",
                management_desc: "Barcha strategik qarorlar markaziy boshqaruv idorasi tomonidan qabul qilinadi",
                management_info: "Loyiha boshqaruvi markazlashgan tuzilmada amalga oshiriladi. Operativ qarorlar esa loyiha menejerlariga topshirilgan. Har hafta hisobotlar taqdim etiladi.",
                risk_level: "low",
                risk_items: [
                    {
                        name: "Bozor riski",
                        description: "Ko'chmas mulk bozoridagi narxlarning kutilmagan pasayishi, talab-talabning kamayishi"
                    },
                    {
                        name: "Qurilish riski",
                        description: "Qurilish materiallarining narxining oshishi, qurilish jarayonida texnik muammolar"
                    },
                    {
                        name: "Moliyaviy risk",
                        description: "Investorlar tomonidan mablag'larning o'z vaqtida kiritilmasligi, valyuta kursining o'zgarishi"
                    },
                    {
                        name: "Huquqiy risk",
                        description: "Qonunchilikdagi o'zgarishlar, ruxsatnomalarni olishdagi kechikishlar"
                    }
                ]
            },
            documents: [
                { name: "Yer uchastkasi hujjatlari", file: "land_documents.pdf" },
                { name: "Investitsiya shartnomasi", file: "investment_contract.pdf" },
                { name: "Qurilish ruxsatnomasi", file: "construction_license.pdf" },
                { name: "Loyiha-smeta hujjatlari", file: "project_estimate.pdf" },
                { name: "Texnik shartlar", file: "technical_specs.pdf" }
            ]
        };

        function loadProjectData() {
            projectData = mockData;
            displayProjectData();
        }

        function displayProjectData() {
            const p = projectData;

            document.getElementById('projectName').textContent = p.name;
            document.getElementById('projectCode').textContent = `ID: ${p.project_id}`;
            document.getElementById('fundingPercent').textContent = p.funding_percent + '%';

            const statusMap = {
                'active': { text: 'Faol', class: 'status-active' },
                'planned': { text: 'Rejalashtirilgan', class: 'status-planned' },
                'completed': { text: 'Yakunlangan', class: 'status-completed' },
                'inactive': { text: 'Nofaol', class: 'status-inactive' }
            };

            const status = statusMap[p.status];
            const statusEl = document.getElementById('projectStatus');
            statusEl.textContent = status.text;
            statusEl.className = `status-badge ${status.class}`;

            const categoryMap = {
                'land': 'Yer uchastkasi',
                'construction': 'Qurilish',
                'rental': 'Ijara'
            };

            const categoryEl = document.getElementById('projectCategory');
            categoryEl.textContent = categoryMap[p.category];
            categoryEl.className = 'status-badge status-planned';

            document.getElementById('projectId').textContent = p.project_id;
            document.getElementById('name').textContent = p.name;
            document.getElementById('shortDesc').textContent = p.short_description;
            document.getElementById('purpose').textContent = p.purpose;
            document.getElementById('category').textContent = categoryMap[p.category];
            document.getElementById('status').textContent = status.text;

            document.getElementById('city').textContent = p.city;
            document.getElementById('district').textContent = p.district;
            document.getElementById('street').textContent = p.street;
            document.getElementById('house').textContent = p.house;

            const mapUrl = `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2996.5!2d${p.location_lng}!3d${p.location_lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDHCsDE4JzM5LjkiTiA2OcKwMTQnMjYuMCJF!5e0!3m2!1sen!2s!4v1234567890`;
            document.getElementById('mapFrame').src = mapUrl;

            document.getElementById('managerOrg').textContent = p.manager_organization;
            document.getElementById('licenseNumber').textContent = p.license_number;

            if (p.category === 'construction' || p.category === 'rental') {
                document.getElementById('constructionCard').style.display = 'block';
                document.getElementById('constructionName').textContent = p.construction_org.name;
                document.getElementById('constructionLogo').textContent = p.construction_org.logo;
                document.getElementById('constructionDesc').textContent = p.construction_org.description;
            }

            displayMainImages(p.main_images);
            displayVideos(p.videos);
            displayProcessImages(p.process_images);
            displayStages(p.stages);
            displayRounds(p.rounds);
            displayFinancial(p);
            displayPartners(p.partners);
            displayRisks(p.risks);
            displayDocuments(p.documents);
        }

        function displayMainImages(images) {
            if (!images || images.length === 0) return;

            mainImages = images;
            currentMainImageIndex = 0;

            const imageEl = document.getElementById('mainSliderImage');
            imageEl.src = mainImages[0];

            const indicators = document.getElementById('mainSliderIndicators');
            indicators.innerHTML = mainImages.map((_, index) =>
                `<div class="indicator ${index === 0 ? 'active' : ''}" onclick="goToMainSlide(${index})"></div>`
            ).join('');
        }

        function changeMainSlide(direction) {
            currentMainImageIndex += direction;
            if (currentMainImageIndex < 0) currentMainImageIndex = mainImages.length - 1;
            if (currentMainImageIndex >= mainImages.length) currentMainImageIndex = 0;

            document.getElementById('mainSliderImage').src = mainImages[currentMainImageIndex];

            document.querySelectorAll('#mainSliderIndicators .indicator').forEach((ind, idx) => {
                ind.classList.toggle('active', idx === currentMainImageIndex);
            });
        }

        function goToMainSlide(index) {
            currentMainImageIndex = index;
            document.getElementById('mainSliderImage').src = mainImages[index];

            document.querySelectorAll('#mainSliderIndicators .indicator').forEach((ind, idx) => {
                ind.classList.toggle('active', idx === index);
            });
        }

        function displayVideos(videos) {
            if (!videos || videos.length === 0) {
                document.getElementById('videosCard').style.display = 'none';
                return;
            }

            document.getElementById('videosCard').style.display = 'block';
            const container = document.getElementById('videosContainer');
            container.innerHTML = videos.map(url => `
                    <div class="video-embed">
                        <iframe src="${url}" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>
                    </div>
                `).join('');
        }

        function displayProcessImages(images) {
            if (!images || images.length === 0) {
                document.getElementById('processImagesCard').style.display = 'none';
                return;
            }

            document.getElementById('processImagesCard').style.display = 'block';
            const container = document.getElementById('processImagesContainer');
            container.innerHTML = images.map((img, index) => `
                    <div class="gallery-item" onclick="openImageModal('${img}')">
                        <img src="${img}" alt="Qurilish jarayoni ${index + 1}" loading="lazy">
                    </div>
                `).join('');
        }

        function openImageModal(imageUrl) {
            // Bu yerda modal oynani ochish logikasi bo'ladi
            window.open(imageUrl, '_blank');
        }

        function displayStages(stages) {
            const totalProgress = stages.reduce((sum, stage) => {
                return sum + (stage.status === 'completed' ? stage.progress : 0);
            }, 0);

            const progressBar = document.getElementById('progressBar');
            progressBar.style.width = totalProgress + '%';
            progressBar.textContent = totalProgress + '%';

            const timeline = document.getElementById('timeline');
            timeline.innerHTML = '';

            const statusMap = {
                'completed': { icon: '✓', class: 'completed', text: 'Bajarildi' },
                'in_progress': { icon: '◐', class: 'in-progress', text: 'Jarayonda' },
                'planned': { icon: '○', class: 'planned', text: 'Rejalashtirilgan' }
            };

            stages.forEach((stage, index) => {
                const status = statusMap[stage.status];
                const itemEl = document.createElement('div');
                itemEl.className = 'timeline-item';
                itemEl.innerHTML = `
                        <div class="timeline-marker ${status.class}">${status.icon}</div>
                        ${index < stages.length - 1 ? '<div class="timeline-line"></div>' : ''}
                        <div class="timeline-content">
                            <div class="timeline-title">${stage.name}</div>
                            <div style="color: var(--gray-600); font-size: 0.9rem; margin: 0.25rem 0;">${status.text} • ${stage.progress}%</div>
                            <div class="timeline-date">${stage.start_date} - ${stage.end_date}</div>
                        </div>
                    `;
                timeline.appendChild(itemEl);
            });
        }

        function displayRounds(rounds) {
            const container = document.getElementById('roundsContainer');
            const statusMap = {
                'in_progress': { text: 'Jarayonda', class: 'status-active' },
                'completed': { text: 'Yakunlangan', class: 'status-completed' },
                'inactive': { text: 'Nofaol', class: 'status-inactive' }
            };

            container.innerHTML = rounds.map(round => {
                const status = statusMap[round.status];
                return `
                        <div class="round-item">
                            <div class="round-info">
                                <h6>${round.name}</h6>
                                <span class="status-badge ${status.class}">${status.text}</span>
                            </div>
                            <div style="text-align: right;">
                                <div class="round-amount">${formatMoney(round.min_share)}</div>
                                <div style="font-size: 0.85rem; color: var(--gray-600);">Minimal ulush</div>
                            </div>
                        </div>
                    `;
            }).join('');
        }

        function displayFinancial(p) {
            document.getElementById('totalValue').textContent = formatMoney(p.total_value);
            document.getElementById('minShare').textContent = formatMoney(p.min_share);
            document.getElementById('yearlyProfit').textContent = p.yearly_profit + '%';
            document.getElementById('fundingStatus').textContent = p.funding_status + '%';
            document.getElementById('investmentPeriod').textContent = p.investment_period;
            document.getElementById('profitability').textContent = p.profitability;
            document.getElementById('distributionIndicators').textContent = p.distribution_indicators;
            document.getElementById('distributionStart').textContent = p.distribution_start;
            document.getElementById('lastDividend').textContent = p.last_dividend + '%';

            const historyContainer = document.getElementById('dividendHistory');
            historyContainer.innerHTML = p.dividend_history.map(item => `
                    <div class="dividend-item">
                        <div>
                            <div class="dividend-date">${item.date}</div>
                            <div class="dividend-status">${item.status}</div>
                        </div>
                        <div class="dividend-amount">${item.amount}%</div>
                    </div>
                `).join('');
        }

        function displayPartners(partners) {
            const container = document.getElementById('partnersContainer');
            container.innerHTML = partners.map(partner => `
                    <div class="partner-card" style="margin-bottom: 1.5rem;">
                        <div class="partner-header">${partner.company_name}</div>
                        <div class="info-grid">
                            <div class="info-row">
                                <span class="info-label">To'liq sherikning identifikatori (ID)</span>
                                <span class="info-value">${partner.id}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Korxona to'liq nomi</span>
                                <span class="info-value">${partner.company_name}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">INN</span>
                                <span class="info-value">${partner.inn}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">IFUT kodi</span>
                                <span class="info-value">${partner.ifut}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Faoliyat turi</span>
                                <span class="info-value">${partner.type}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Manzil</span>
                                <span class="info-value">${partner.address}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Direktor F.I.O.</span>
                                <span class="info-value">${partner.director}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Bog'lanish uchun telefon raqami</span>
                                <span class="info-value">${partner.phone}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Email</span>
                                <span class="info-value">${partner.email}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Ro'yxatdan o'tkazilgan sana</span>
                                <span class="info-value">${partner.registration_date}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Ro'yxatdan o'tkazish raqami</span>
                                <span class="info-value">${partner.registration_number}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Ro'yxatdan o'tkazuvchi davlat tashkiloti nomi</span>
                                <span class="info-value">${partner.registration_org}</span>
                            </div>
                            ${partner.type === 'YaTT' ? `
                            <div class="info-row">
                                <span class="info-label">Pasport ma'lumoti</span>
                                <span class="info-value">${partner.passport_data}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">JSHSHIR</span>
                                <span class="info-value">${partner.pinfl}</span>
                            </div>
                            ` : ''}
                            <div class="info-row">
                                <span class="info-label">Akkount holati</span>
                                <span class="info-value">${partner.account_status === 'active' ? 'Faol' : 'Bloklangan'}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">To'liq sheriklik holati sanasi</span>
                                <span class="info-value">${partner.partnership_date}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Investorlik sertifikati fayli</span>
                                <span class="info-value">${partner.investor_certificate}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Loyihadagi jami ulushi (summada)</span>
                                <span class="info-value">${formatMoney(partner.share_amount)}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Loyihadagi jami ulushi (foizda)</span>
                                <span class="info-value">${partner.share_percent}%</span>
                            </div>
                        </div>
                    </div>
                `).join('');
        }

        function displayRisks(risks) {
            document.getElementById('managementModel').textContent = risks.management_model;
            document.getElementById('managementDesc').textContent = risks.management_desc;
            document.getElementById('managementInfo').textContent = risks.management_info;

            const riskMap = {
                'low': { text: 'Past', class: 'status-active' },
                'medium': { text: "O'rta", class: 'status-planned' },
                'high': { text: 'Yuqori', class: 'status-inactive' }
            };

            const risk = riskMap[risks.risk_level];
            const riskEl = document.getElementById('riskLevel');
            riskEl.textContent = risk.text;
            riskEl.className = `status-badge ${risk.class}`;

            const container = document.getElementById('risksContainer');
            container.innerHTML = risks.risk_items.map(item => `
                    <div class="risk-item">
                        <div class="risk-title">${item.name}</div>
                        <p class="risk-description">${item.description}</p>
                    </div>
                `).join('');
        }

        function displayDocuments(documents) {
            const container = document.getElementById('documentsContainer');
            container.innerHTML = documents.map(doc => `
                    <div class="document-item">
                        <div class="document-info">
                            <div class="document-icon">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-900);">${doc.name}</div>
                                <div style="font-size: 0.85rem; color: var(--gray-600);">${doc.file}</div>
                            </div>
                        </div>
                        <button class="btn-action btn-outline" onclick="downloadDocument('${doc.file}')">
                            <i class="bi bi-download"></i> Yuklash
                        </button>
                    </div>
                `).join('');
        }

        function switchTab(tabName) {
            document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

            event.target.classList.add('active');
            document.getElementById(tabName).classList.add('active');
            currentTab = tabName;
        }

        function formatMoney(amount) {
            return new Intl.NumberFormat('uz-UZ').format(amount) + " so'm";
        }

        function enableEdit() {
            alert('Tahrirlash rejimi yoqildi');
            document.getElementById('saveBtn').style.display = 'inline-flex';
        }

        function saveChanges() {
            alert("O'zgarishlar saqlandi");
            document.getElementById('saveBtn').style.display = 'none';
        }

        function downloadDocument(filename) {
            alert(`Hujjat yuklanmoqda: ${filename}`);
        }

        document.addEventListener('DOMContentLoaded', loadProjectData);
    </script>
@endpush