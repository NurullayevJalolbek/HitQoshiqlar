@extends('layouts.app')
@push('customCss')
    <style>
        @include('pages.projects.css.main-css')
        @include('pages.projects.css.stages')
    </style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 px-3 mt-3"
    style="border: 1px solid var(--gray-200); border-radius: var(--border-radius); background-color: #ffffff;">
    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Loyihalar</a></li>
                <li class="breadcrumb-item active" aria-current="page">Loyiha kartochkasi</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        @php($projectId = request()->route('project'))
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
        <div style="border-color: rgba(0,0,0,0.05); background-color: #fff; padding: 0;">
            <!-- Tab Navigation -->
            <div class="nav-tabs-container">
                <button class="scroll-btn scroll-btn-left" onclick="scrollTabs('left')" id="scrollLeftBtn"
                    aria-label="Scroll left">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <ul class="nav nav-tabs" id="projectTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" onclick="switchTab('characteristics')" type="button">
                            Xarakteristik ma'lumotlar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('stages')" type="button">
                            Loyiha bosqichlari
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('distribution')" type="button">
                            Taqsimot sozlamalari
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('rounds')" type="button">
                            Loyiha raundlari
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('financial')" type="button">
                            Moliyaviy ko'rsatkichlar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('partners')" type="button">
                            To'liq sheriklar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('risks')" type="button">
                            Risklar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('documents')" type="button">
                            Loyiha hujjatlari
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('investors')" type="button">
                            Investorlar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('buyers')" type="button">
                            Xaridorlar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('company_details')" type="button">
                            Rekvizit ma'lumotlar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('project_expenses')" type="button">
                            Loyiha xarajatlari
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('distributions')" type="button">
                            Taqsimot
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" onclick="switchTab('paid_dividend')" type="button">
                            To'langan dividentlar
                        </button>
                    </li>
                </ul>
                <button class="scroll-btn scroll-btn-right" onclick="scrollTabs('right')" id="scrollRightBtn"
                    aria-label="Scroll right">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <div id="characteristics" class="tab-content active">
            <!-- Basic Information -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="info-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="info-card-title">
                                <i class="bi bi-info-circle"></i>
                                Asosiy ma'lumotlar
                            </h5>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleBasicInfoBtn"
                                    onclick="toggleBasicInfoEdit()">
                                    <i class="bi bi-pencil-square me-1"></i>
                                    Tahrirlash
                                </button>
                            </div>
                        </div>
                        <div class="info-grid">
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-hash me-1 text-muted"></i>
                                    Loyihaning unikal IDsi
                                </span>
                                <span class="info-value" id="projectId">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-type me-1 text-muted"></i>
                                    Nomi
                                </span>
                                <span class="info-value" id="name">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-card-text me-1 text-muted"></i>
                                    Qisqacha tavsif
                                </span>
                                <span class="info-value" id="shortDesc">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-bullseye me-1 text-muted"></i>
                                    Maqsadi
                                </span>
                                <span class="info-value" id="purpose">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-tags me-1 text-muted"></i>
                                    Kategoriya
                                </span>
                                <span class="info-value" id="category">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-flag me-1 text-muted"></i>
                                    Holati
                                </span>
                                <span class="info-value" id="status">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="info-card-title">
                                <i class="bi bi-geo-alt"></i>
                                Joylashuv manzili
                            </h5>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleLocationBtn"
                                    onclick="toggleLocationEdit()">
                                    <i class="bi bi-pencil-square me-1"></i>
                                    Tahrirlash
                                </button>
                            </div>
                        </div>
                        <div class="info-grid">
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-building me-1 text-muted"></i>
                                    Shahar
                                </span>
                                <span class="info-value" id="city">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-geo-alt me-1 text-muted"></i>
                                    Tuman
                                </span>
                                <span class="info-value" id="district">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-signpost-2 me-1 text-muted"></i>
                                    Ko'cha
                                </span>
                                <span class="info-value" id="street">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-house-door me-1 text-muted"></i>
                                    Uy
                                </span>
                                <span class="info-value" id="house">-</span>
                            </div>
                        </div>
                        <h6 style="margin-top: 1.5rem; margin-bottom: 0.5rem; font-weight: 600;">Joylashuv lokatsiyasi</h6>
                        <div class="map-container">
                            <iframe id="mapFrame" width="100%" height="100%" frameborder="0" style="border:0"></iframe>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="info-card-title">
                                <i class="bi bi-briefcase"></i>
                                Loyiha boshqaruvchisi
                            </h5>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleManagerBtn"
                                    onclick="toggleManagerEdit()">
                                    <i class="bi bi-pencil-square me-1"></i>
                                    Tahrirlash
                                </button>
                            </div>
                        </div>
                        <div class="info-grid">
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-building me-1 text-muted"></i>
                                    Tashkilot nomi
                                </span>
                                <span class="info-value" id="managerOrg">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-file-earmark-text me-1 text-muted"></i>
                                    Litsenziya raqami
                                </span>
                                <span class="info-value" id="licenseNumber">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" id="constructionCard" style="display: none;">
                    <div class="info-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="info-card-title">
                                <i class="bi bi-building"></i>
                                Qurilish tashkiloti haqida ma'lumot
                            </h5>
                            <div class="d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleConstructionBtn"
                                    onclick="toggleConstructionEdit()">
                                    <i class="bi bi-pencil-square me-1"></i>
                                    Tahrirlash
                                </button>
                            </div>
                        </div>
                        <div class="info-grid">
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-building me-1 text-muted"></i>
                                    Tashkilot nomi
                                </span>
                                <span class="info-value" id="constructionName">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-image me-1 text-muted"></i>
                                    Logotipi
                                </span>
                                <span class="info-value" id="constructionLogo">-</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">
                                    <i class="bi bi-card-text me-1 text-muted"></i>
                                    Qisqacha tavsif
                                </span>
                                <span class="info-value" id="constructionDesc">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Images -->
                <div class="info-card" id="mainImagesCard">
                    <h5 class="info-card-title">
                        <i class="bi bi-images"></i>
                        Asosiy fon rasmlari
                    </h5>
                    <div class="gallery-grid" id="mainImagesContainer"></div>
                </div>
                <!-- Construction Process Images -->
                <div class="info-card" id="processImagesCard">
                    <h5 class="info-card-title">
                        <i class="bi bi-camera"></i>
                        Qurilish jarayoniga doir rasmlar
                    </h5>
                    <div class="gallery-grid" id="processImagesContainer"></div>
                </div>
                <!-- Videos Section -->
                <div class="info-card" id="videosCard">
                    <h5 class="info-card-title">
                        <i class="bi bi-camera-video"></i>
                        Loyiha videolari
                    </h5>
                    <div class="gallery-grid" id="videosContainer"></div>
                </div>
            </div>
        </div>

        <div id="stages" class="tab-content">
        <div class="info-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="info-card-title mb-0">
                    <i class="bi bi-diagram-3"></i>
                    Loyiha (mulk) bosqichlari
                </h5>
                <div class="tab-header-actions">
                    <div class="input-group input-group-sm w-auto tab-tools" id="stagesTools">
                        <span class="input-group-text"><i class="bi bi-node-plus"></i></span>
                        <select class="form-select form-select-sm" id="stageInsertAfterSelect"
                            onchange="setStageInsertAfter(this.value)">
                            <option value="">Oxiriga qo'shish</option>
                        </select>
                    </div>

                    <span class="drop-hint" id="stagesHint">
                        <i class="bi bi-grip-vertical"></i>
                        Ushlab tortib joyini o'zgartiring
                    </span>

                    <button type="button" class="btn btn-primary btn-sm d-none" id="addStageBtn"
                        onclick="addNewStage()">
                        <i class="bi bi-plus-lg me-1"></i>
                        Yangi bosqich qo'shish
                    </button>

                    <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleStagesEditBtn"
                        onclick="toggleStagesEdit()">
                        <i class="bi bi-pencil-square me-1"></i>
                        Tahrirlash
                    </button>
                </div>
            </div>

            <!-- Progress Section -->
            <div class="progress-section">
                <div class="progress-bar-wrapper">
                    <div class="progress-bar-fill" id="progressBar" style="width: 0%"></div>
                    <div class="progress-bar-label" id="progressBarLabel">
                        <span class="d-inline-flex align-items-center" id="progressIcon">
                            <!-- Icon shu yerga qo'shiladi -->
                        </span>
                        <span id="progressText">0%</span>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="stage-timeline" id="timeline">
                <!-- Bosqichlar shu yerga qo'shiladi -->
            </div>
        </div>
    </div>

        <div id="distribution" class="tab-content">
            <div class="info-card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="info-card-title mb-0">
                        <i class="bi bi-pie-chart"></i>
                        Taqsimot sozlamalari
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleDistributionEditBtn"
                            onclick="toggleDistributionEdit()">
                            <i class="bi bi-pencil-square me-1"></i>
                            Tahrirlash
                        </button>
                    </div>
                </div>

                <h6 style="margin-top: 2rem; margin-bottom: 1rem; font-weight: 600;">Vizual taqsimot</h6>
                <div class="distribution-visual" id="distributionVisual">
                    <div class="distribution-segment segment-partners" id="partnersSegment" style="width: 30%">
                        To'liq sheriklar: 30%
                    </div>
                    <div class="distribution-segment segment-investors" id="investorsSegment" style="width: 70%">
                        Kommanditchilar: 70%
                    </div>
                </div>
            </div>
        </div>

        <div id="rounds" class="tab-content">
            <div class="info-card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="info-card-title mb-0">
                        <i class="bi bi-arrow-repeat"></i>
                        Loyiha raundlari
                    </h5>

                    <div class="tab-header-actions">
                        <div class="input-group input-group-sm w-auto tab-tools" id="roundsTools">
                            <span class="input-group-text"><i class="bi bi-node-plus"></i></span>
                            <select class="form-select form-select-sm" id="roundInsertAfterSelect"
                                onchange="setRoundInsertAfter(this.value)">
                                <option value="">Oxiriga qo‘shish</option>
                            </select>
                        </div>
                        <span class="drop-hint" id="roundsHint">
                            <i class="bi bi-grip-vertical"></i>
                            Ushlab tortib joyini o‘zgartiring
                        </span>
                        <button type="button" class="btn btn-primary btn-sm d-none" id="addRoundBtn"
                            onclick="addNewRound()">
                            <i class="bi bi-plus-lg me-1"></i>
                            Yangi raund qo'shish
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleRoundsEditBtn"
                            onclick="toggleRoundsEdit()">
                            <i class="bi bi-pencil-square me-1"></i>
                            Tahrirlash
                        </button>
                    </div>
                </div>
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
                        <div class="stat-icon">
                            <i class="bi bi-currency-exchange"></i>
                        </div>
                        <div class="stat-value" id="totalValue">0</div>
                        <div class="stat-label">Umumiy qiymati</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                        <div class="stat-value" id="minShare">0</div>
                        <div class="stat-label">Minimal ulush miqdori narxi</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <div class="stat-value" id="yearlyProfit">0%</div>
                        <div class="stat-label">Kutilayotgan daromad (yillik, foizlarda)</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-pie-chart-fill"></i>
                        </div>
                        <div class="stat-value" id="fundingStatus">0%</div>
                        <div class="stat-label">Moliyalashtirilganlik holati ko'rsatkichi</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-calendar-range"></i>
                        </div>
                        <div class="stat-value" id="investmentPeriod">-</div>
                        <div class="stat-label">Investitsiya davri yoki davomiyligi</div>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-percent me-1 text-muted"></i>
                            Rentabellik ko'rsatkichi (%) yoki prognoz qilingan daromad summasi
                        </span>
                        <span class="info-value" id="profitability">-</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-share me-1 text-muted"></i>
                            To'liq sheriklar va Kommanditchilar o'rtasidagi foyda/zararning taqsimot
                            ko'rsatkichlari
                        </span>
                        <span class="info-value" id="distributionIndicators">-</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-calendar-event me-1 text-muted"></i>
                            Taqsimot amaga oshirilishi boshlanadigan davr
                        </span>
                        <span class="info-value" id="distributionStart">-</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-cash-stack me-1 text-muted"></i>
                            Eng oxirgi marta taqsimlangan dividend foiz ko'rsatkichi
                        </span>
                        <span class="info-value" id="lastDividend">-</span>
                    </div>
                </div>

                <h6
                    style="margin-top: 2rem; margin-bottom: 1rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="bi bi-clock-history"></i>
                    Loyiha doirasida taqsimlangan dividendlar tarixi
                </h6>
                <div id="dividendHistory"></div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div class="text-muted" id="dividendSummary"></div>
                    <div id="dividendPagination"></div>
                </div>
            </div>
        </div>

        <div id="partners" class="tab-content">
            <div class="info-card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="info-card-title mb-0">
                        <i class="bi bi-people"></i>
                        To'liq sheriklar rekvizit ma'lumotlari
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-primary btn-sm" id="addPartnerBtn" onclick="addNewPartner()"
                            style="display: none;">
                            <i class="bi bi-plus-lg me-1"></i>
                            Yangi sherik qo'shish
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="togglePartnersEditBtn"
                            onclick="togglePartnersEdit()">
                            <i class="bi bi-pencil-square me-1"></i>
                            Tahrirlash
                        </button>
                    </div>
                </div>
                <div id="partnersContainer"></div>
            </div>
        </div>

        <div id="risks" class="tab-content">

            {{-- === RISKS INFO CARD === --}}
            <div class="info-card">
                <div class="d-flex justify-content-between align-items-center" id="risksListContent">
                    <h5 class="info-card-title mb-0">
                        <i class="bi bi-diagram-3"></i>
                        Loyihaning boshqarilish modeli va xatar darajasi
                    </h5>
                    <div class="tab-header-actions">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleRisksInfoEditBtn"
                            onclick="toggleRisksInfoEdit()">
                            <i class="bi bi-pencil-square me-1"></i>
                            Tahrirlash
                        </button>
                    </div>
                </div>

                <div class="info-grid" id="risksInfoContent">
                    {{-- JS orqali to‘ldiriladi --}}
                </div>
            </div>

            {{-- === RISKS LIST CARD === --}}
            <div class="info-card mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="info-card-title mb-0">
                        <i class="bi bi-exclamation-triangle"></i>
                        Loyihadagi asosiy xatarlar
                    </h5>
                    <div class="tab-header-actions">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleRisksListEditBtn"
                            onclick="toggleRisksListEdit()">
                            <i class="bi bi-pencil-square me-1"></i>
                            Tahrirlash
                        </button>
                    </div>
                </div>

                <div id="risksContainer" class="sortable-risks-list"></div>
            </div>


        </div>

        <div id="documents" class="tab-content">
            <div class="info-card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="info-card-title mb-0">
                        <i class="bi bi-file-earmark-text"></i>
                        Loyiha (mulk) hujjatlari
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-success btn-sm" id="addDocumentBtn" onclick="addNewDocument()"
                            style="display: none;">
                            <i class="bi bi-plus-lg me-1"></i>
                            Yangi hujjat qo'shish
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleDocumentsEditBtn"
                            onclick="toggleDocumentsEdit()">
                            <i class="bi bi-pencil-square me-1"></i>
                            Tahrirlash
                        </button>
                    </div>
                </div>
                <div class="document-list" id="documentsContainer"></div>
            </div>
        </div>
        <div id="investors" class="tab-content">


    <!-- Filter qismi -->
    <div class="filter-card mb-3 collapse show" id="projectInvestorFilterContent">
        <div class="p-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="searchInput" class="form-label mb-2">{{ __('admin.search') }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0"
                            placeholder="{{ __('admin.enterprise_name') }}">
                    </div>
                </div>

                <x-select-with-search name="activityTypeFilter" label="Faoliyat turi" :datas="$activityTypes" colMd="3"
                    placeholder="Barchasi" :selected="request()->get('activityTypeFilter', '')" :selectSearch=false
                    icon="fa-building text-primary" />

                <x-select-with-search name="statusFilter" label="Holati boyicha" :datas="$statuses" colMd="3"
                    placeholder="Barchasi" :selected="request()->get('statusFilter', '')" :selectSearch=false />

                <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />
            </div>
        </div>
    </div>

    <!-- Jadval -->
    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table investor-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
                <tr>
                    <th style="width: 50px;">{{ __('admin.id') }}</th>
                    <th style="min-width: 200px;">{{ __('Korxona to\'liq nomi') }}</th>

                    <th class="col-inn" style="width: 100px;">{{ __('INN') }}</th>

                    <th style="width: 90px;">{{ __('IFUT') }}</th>
                    <th style="width: 90px;">{{ __('Faoliyat turi') }}</th>
                    <th style="min-width: 200px;">{{ __('Manzil') }}</th>
                    <th style="min-width: 180px;">{{ __('Direktor F.I.O') }}</th>

                    <th style="width: 120px;">{{ __('Login') }}</th>
                    <th class="col-phone" style="width: 130px;">{{ __('Telefon') }}</th>
                    <th class="col-email" style="min-width: 150px;">{{ __('Email') }}</th>

                    <th style="width: 110px;">{{ __('Ro\'yxatdan o\'tgan sana') }}</th>
                    <th class="col-regno" style="width: 140px;">{{ __('Ro\'yxatdan o\'tkazish raqami') }}</th>
                    <th class="col-regorg" style="min-width: 200px;">{{ __('Ro\'yxatdan o\'tkazuvchi tashkilot') }}</th>

                    <th style="width: 120px;">{{ __('Pasport (YaTT)') }}</th>
                    <th class="col-jshshir" style="width: 130px;">{{ __('JSHSHIR (YaTT)') }}</th>

                    <th style="width: 90px;">{{ __('Holat') }}</th>
                    <th style="width: 110px;">{{ __('Investorlik holati sanasi') }}</th>
                    <th style="width: 120px;">{{ __('Sertifikat') }}</th>

                    <th style="width: 140px; text-align: right;">{{ __('Ulush (summa)') }}</th>
                    <th class="col-sharepct" style="width: 90px; text-align: center;">{{ __('Ulush (%)') }}</th>

                    <th style="width: 110px;">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody id="investorTableBody">
                <tr class="loading-row">
                    <td colspan="21">
                        <i class="fas fa-spinner loading-spinner me-2"></i>
                        <span>Investorlar yuklanmoqda...</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
        </div>
        <div id="buyers" class="tab-content">
        <div class="filter-card mb-3 mt-2 collapse show" id="projectBuyerFilterContent" style="transition: all 0.3s ease;">
    <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
        <div class="row g-3 align-items-end">

            <!-- Qidiruv -->
            <div class="col-md-3">
                <label for="searchInput" class="form-label">{{ __('Qidiruv') }}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input
                        type="text"
                        id="searchInput"
                        class="form-control"
                        placeholder="{{ __('korxona_nomi') }}, {{ __('direktor_fio') }}, {{ __('inn') }}..."
                    >
                </div>
            </div>

            <x-select-with-search
                name="filter_direction"
                label="Yo'nalish"
                :datas="$directions"
                colMd="3"
                placeholder="{{ __('barchasi') }}"
                :selected="request()->get('filter_direction', '')"
                :selectSearch="false"
                icon="fa-layer-group text-primary"
            />

            <x-select-with-search
                name="filter_activity"
                label="{{ __('Faoliyat turi') }}"
                :datas="$activityTypes"
                colMd="3"
                placeholder="{{ __('barchasi') }}"
                :selected="request()->get('filter_activity', '')"
                :selectSearch="false"
            />

            <!-- Filter tugmalari -->
            <x-filter-buttons />
        </div>
    </div>
</div>

        <div class="card card-body py-3 px-3 shadow-sm border-0 mt-3">
        <div class="table-responsive">
            <table class="table buyer-table table-bordered table-hover table-striped align-items-center mb-0">
                <thead class="table-dark">
                    @include('pages.project-buyers._columns')
                </thead>
                <tbody id="buyerTableBody">
                    <tr class="loading-row">
                        <td colspan="14" class="text-center py-4 text-muted">
                            <i class="fas fa-spinner fa-spin me-2"></i>{{ __('yuklanmoqda') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="emptyState" class="empty-state text-center" style="display: none;">
            <i class="fas fa-inbox"></i>
            <h5 class="mt-3 mb-2 text-muted">{{ __('malumotlar_topilmadi') }}</h5>
            <p class="text-muted mb-0">{{ __('hali_malumot_qoshilmagan') }}</p>
        </div>
    </div>

    {{-- Create / Edit modal --}}
    <div class="modal fade" id="createBuyerModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('xaridor_qoshish') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="buyerForm">
                        @csrf
                        <input type="hidden" id="buyerId" name="id">

                        <div class="mb-3">
                            <label class="form-label">
                                {{ __('yonalish') }} <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="direction" required>
                                <option value="">{{ __('tanlang') }}</option>
                                <option value="land">{{ __('yer_uchastkasi') }}</option>
                                <option value="construction">{{ __('qurilish') }}</option>
                                <option value="rent">{{ __('ijara') }}</option>
                            </select>
                        </div>

                        <h6 class="mb-3 text-primary">{{ __('korxona_malumotlari') }}</h6>

                        <div class="mb-3">
                            <label class="form-label">
                                {{ __('korxona_toliq_nomi') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="company_name" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('inn') }} *</label>
                                <input type="text" class="form-control" name="inn" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('faoliyat_turi') }} *</label>
                                <select class="form-select" name="activity_type" required>
                                    <option value="">{{ __('tanlang') }}</option>
                                    <option value="llc">{{ __('mchj') }}</option>
                                    <option value="jsc">{{ __('aj') }}</option>
                                    <option value="individual">{{ __('yatt') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('direktor_fio') }} *</label>
                                <input type="text" class="form-control" name="director_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('telefon_raqami') }} *</label>
                                <input type="text" class="form-control" name="phone" placeholder="+998" required>
                            </div>
                        </div>

                        <h6 class="mb-3 text-primary mt-4">{{ __('shartnoma_malumotlari') }}</h6>

                        <div class="mb-3">
                            <label class="form-label">{{ __('shartnoma_fayli') }}</label>
                            <input type="file" class="form-control" name="contract_file">
                            <small class="text-muted">{{ __('pdf_doc_docx_format') }}</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('shartnoma_raqami') }} *</label>
                                <input type="text" class="form-control" name="contract_number" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('shartnoma_sanasi') }} *</label>
                                <input type="date" class="form-control" name="contract_date" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('tolov_shartlari') }}</label>
                            <textarea class="form-control" name="payment_terms"></textarea>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('bekor_qilish') }}
                    </button>
                    <button class="btn btn-primary" id="saveBuyerBtn">
                        {{ __('saqlash') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('ochirishni_tasdiqlash') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{ __('rostdan_ham_ochirmoqchimisiz') }}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('yoq') }}
                    </button>
                    <button class="btn btn-danger" id="confirmDeleteBtn">
                        {{ __('ha_ochirish') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
        </div>
        <div id="company_details" class="tab-content">
        <div class="filter-card mb-3 collapse show" id="companyFilterContent">
        <div class="p-3">
            <div class="row g-3 align-items-end">
                {{-- Qidiruv --}}
                <div class="col-md-4">
                    <label for="searchInput" class="form-label mb-2">{{ __('admin.search') ?? 'Qidiruv' }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0"
                            placeholder="{{ __('admin.search') ?? 'Nom, INN, direktor...' }}">
                    </div>
                </div>

                {{-- Korxona kategoriyasi --}}
                <x-select-with-search
                    name="companyCategoryFilter"
                    label="Korxona kategoriyasi"
                    :datas="[
                        'full_partner' => 'To‘liq sherik',
                        'subsidiary' => 'Shu\'ba korxona',
                        'commandite' => 'Komandit shirkati',
                    ]"
                    colMd="3"
                    placeholder="Barchasi"
                    :selected="request()->get('companyCategoryFilter', '')"
                    :selectSearch="false"
                    icon="fa-layer-group" />

                {{-- Faoliyat turi --}}
                <x-select-with-search
                    name="activityTypeFilter"
                    label="{{ __('admin.activity_type') ?? 'Faoliyat turi' }}"
                    :datas="['MChJ' => 'MChJ', 'AJ' => 'AJ', 'YaTT' => 'YaTT']"
                    colMd="3"
                    placeholder="Barchasi"
                    :selected="request()->get('activityTypeFilter', '')"
                    :selectSearch="false"
                    icon="fa-briefcase" />

                <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />
            </div>
        </div>
    </div>

    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table user-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>{{ 'Korxona to‘liq nomi' }}</th>
                    <th>{{ 'Korxona kategoriyasi' }}</th>

                    {{-- INN ustuni kodda bor, lekin ko‘rinmaydi --}}
                    <th class="col-inn">{{ 'INN' }}</th>

                    <th>{{ 'IFUT kodi' }}</th>
                    <th>{{ 'Faoliyat turi' }}</th>
                    <th>{{ 'Manzili' }}</th>

                    <th>{{ 'Direktor F.I.O.' }}</th>

                    {{-- Telefon ustuni kodda bor, lekin ko‘rinmaydi --}}
                    <th class="col-phone">{{ __('admin.phone') ?? 'Telefon' }}</th>

                    <th>{{ __('admin.email') ?? 'Email' }}</th>

                    <th>{{ __('admin.registered_at') ?? 'Ro‘yxatdan o‘tgan sana' }}</th>

                    {{-- ro‘yxat raqami + organ ustunlari kodda bor, lekin ko‘rinmaydi --}}
                    <th class="col-regnum">{{ __('admin.registration_number') ?? 'Ro‘yxat raqami' }}</th>
                    <th class="col-regorg">{{ __('admin.registration_org') ?? 'Ro‘yxatdan o‘tkazgan tashkilot' }}</th>

                    <th>{{ 'Pasport (YaTT)' }}</th>

                    {{-- JSHSHIR ustuni kodda bor, lekin ko‘rinmaydi --}}
                    <th class="col-jshshir">{{ __('admin.jshshir') ?? 'JSHSHIR (YaTT)' }}</th>

                    <th class="text-center">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody id="companyTableBody">
                <tr>
                    <td colspan="16">
                        <div class="empty-state">
                            <i class="fas fa-spinner fa-spin"></i>
                            <div class="mt-2">
                                <h5>{{ __('admin.loading') ?? 'Ma‘lumotlar yuklanmoqda...' }}</h5>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
        </div>
        <div id="project_expenses" class="tab-content">

        </div>
        <div id="distributions" class="tab-content">

        </div>
        <div id="paid_dividend" class="tab-content">

        </div>
    </div>

    <!-- Media Modal (images & videos) -->
    <div class="modal fade" id="mediaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background: transparent; border: none;">
                <button type="button" class="btn-close bg-white rounded-circle shadow position-absolute"
                    style="top: 10px; right: 10px; z-index: 1051;" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body p-0 d-flex justify-content-center align-items-center">
                    <img id="mediaModalImage" src="" alt="Media" class="img-fluid d-none"
                        style="border-radius: 0.5rem; max-height: 80vh; object-fit: contain;">
                    <div id="mediaModalVideoWrapper" class="ratio ratio-16x9 d-none" style="width: 100%;">
                        <iframe id="mediaModalVideo" src="" allowfullscreen
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            style="border-radius: 0.5rem;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customJs')
    @include('pages.projects._scripts')
@endpush