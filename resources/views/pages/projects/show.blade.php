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

.status-inprogress {
    background: #DBEAFE;
    color: #1E40AF;
    border-color: #93c5fd;
}

.status-planned {
    background: #dbeafe;
    color: #1e40af;
    border-color: #93c5fd;
}

.status-completed {
    background: #dcfce7;
    color: #10B981;
    border-color: #86efac;
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

/* --------------------- Tab menu css start ------------------------------ */

.nav-tabs-container {
    position: relative;
    margin-bottom: 1rem;
    padding: 0 0.75rem;
}

.nav-tabs {
    border-bottom: 2px solid #e5e7eb;
    overflow-x: auto;
    white-space: nowrap;
    flex-wrap: nowrap;
    overflow-y: hidden;
    padding-bottom: 0.5rem;
    scroll-behavior: smooth;
}

.nav-tabs::-webkit-scrollbar {
    height: 8px;
}

.nav-tabs::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.nav-tabs::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.nav-tabs::-webkit-scrollbar-thumb:hover {
    background: #555;
}

.scroll-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 36px;
    height: 36px;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0;
    color: #1F2937;
    z-index: 10;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
    pointer-events: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.scroll-btn i {
    font-size: 0.875rem;
    transition: transform 0.3s;
}

.nav-tabs-container:hover .scroll-btn {
    opacity: 1;
    pointer-events: all;
}

.scroll-btn:hover {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    color: #2563eb;
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.scroll-btn:hover i {
    transform: scale(1.2);
}

.scroll-btn:active {
    transform: translateY(-50%) scale(0.95);
}

.scroll-btn-left {
    left: 8px;
}

.scroll-btn-right {
    right: 8px;
}

.scroll-btn.hidden {
    display: none;
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
    color: #fff;
    background: #1F2937;
    border-bottom: 3px solid #2a3441;
    font-weight: 600;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

/* --------------------- Tab menu css end ------------------------------ */


.info-card {
    background: #ffffff;
    border-radius: var(--border-radius);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--gray-200);
}

..info-card-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex: 1 1 auto;
    /* let title take remaining space */
    min-width: 0;
    /* allow truncation when space is limited */
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Make header row show full-width HR and keep actions vertically centered */
.info-card>.d-flex.justify-content-between.align-items-center {
    align-items: center;
    gap: 0.5rem;
    border-bottom: 2px solid var(--gray-200);
    padding-bottom: 0.75rem;
    margin-bottom: 1rem;
    flex-wrap: nowrap;
    /* prevent button from wrapping to next line */
}

/* Prevent action buttons text from wrapping and keep them vertically centered */
.info-card .d-flex.align-items-center .btn {
    white-space: nowrap;
    margin-top: 0;
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

.stage-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    justify-content: flex-end;
}

.badge-stage-status {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 0.75rem;
    font-weight: 500;
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.badge-stage-completed {
    background: rgba(22, 163, 74, 0.12);
    color: #166534;
}

.badge-stage-in-progress {
    background: rgba(37, 99, 235, 0.12);
    color: #1d4ed8;
}

.badge-stage-planned {
    background: rgba(148, 163, 184, 0.2);
    color: #4b5563;
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
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.stat-icon {
    font-size: 2.5rem;
    color: var(--primary-color);
    margin-bottom: 0.75rem;
    display: flex;
    justify-content: center;
    align-items: center;
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
    padding: 1.25rem;
    background: var(--gray-50);
    border-radius: var(--border-radius);
    margin-bottom: 1rem;
    border-left: 4px solid var(--warning-color);
    transition: all 0.2s;
    border: 1px solid var(--gray-200);
    border-left: 4px solid var(--warning-color);
}

.risk-item:hover {
    background: white;
    box-shadow: var(--shadow-sm);
}

.risk-title {
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
}

.risk-title i {
    color: var(--warning-color);
}

.risk-description {
    color: var(--gray-600);
    font-size: 0.9rem;
    margin: 0;
    line-height: 1.6;
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
    transition: width 0.3s ease;
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

.dividend-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: var(--border-radius);
    overflow: hidden;
    border: 1px solid var(--gray-200);
    margin-top: 1rem;
}

.dividend-table thead {
    background: var(--gray-100);
}

.dividend-table th {
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: var(--gray-900);
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--gray-200);
}

.dividend-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--gray-100);
    color: var(--gray-700);
}

.dividend-table tbody tr:hover {
    background: var(--gray-50);
}

.dividend-table tbody tr:last-child td {
    border-bottom: none;
}

.dividend-table .status-badge-paid {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 500;
    background: #dcfce7;
    color: #166534;
    border: 1px solid #86efac;
}

.dividend-table .status-badge-pending {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 500;
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fde047;
}

/* === Pagination (x-pagination bilan bir xil stil) === */
.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 5px;
    align-items: center;
    position: relative;
}

.page-item {
    margin: 0;
    position: relative;
}

.page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 32px;
    height: 32px;
    padding: 0 8px;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    color: #1F2937;
    text-decoration: none;
    background-color: #fff;
    transition: all 0.3s;
    font-size: 14px;
    cursor: pointer;
    user-select: none;
}

.page-link:hover:not(.disabled) {
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.page-item.active .page-link {
    background-color: #1F2937;
    border-color: #1F2937;
    color: #fff;
}

.page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
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

.gallery-item.video-item {
    position: relative;
    background: var(--gray-900);
    display: flex;
    align-items: center;
    justify-content: center;
}

.gallery-item.video-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.3);
    z-index: 1;
    transition: background 0.3s;
}

.gallery-item.video-item:hover::before {
    background: rgba(0, 0, 0, 0.5);
}

.gallery-item.video-item .play-icon {
    position: absolute;
    z-index: 2;
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    font-size: 1.5rem;
    transition: all 0.3s;
}

.gallery-item.video-item:hover .play-icon {
    transform: scale(1.1);
    background: white;
}

.gallery-item.video-item iframe {
    width: 100%;
    height: 100%;
    border: 0;
    pointer-events: none;
}

.video-embed {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
    border-radius: var(--border-radius);
    margin-bottom: 1rem;
    max-width: 480px;
    margin-left: auto;
    margin-right: auto;
    box-shadow: var(--shadow-sm);
    cursor: pointer;
}

.video-embed iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
    pointer-events: none;
}

.image-slider {
    position: relative;
    border-radius: var(--border-radius);
    overflow: hidden;
    height: 260px;
    background: var(--gray-100);
    cursor: pointer;
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

    .nav-tabs .nav-link {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
    }
}

/* Tab header action buttonlari (Tahrirlash / Saqlash) texti 2-qatorga tushmasligi uchun */
.info-card .btn {
    white-space: nowrap;
}
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
                        Karakteristik ma'lumotlar
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
            </ul>
            <button class="scroll-btn scroll-btn-right" onclick="scrollTabs('right')" id="scrollRightBtn"
                aria-label="Scroll right">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <div id="characteristics" class="tab-content active">
        <!-- Main Images -->
        <div class="info-card" id="mainImagesCard">
            <h5 class="info-card-title">
                <i class="bi bi-images"></i>
                Asosiy fon rasmlari
            </h5>
            <div class="gallery-grid" id="mainImagesContainer"></div>
        </div>

        <!-- Videos Section -->
        <div class="info-card" id="videosCard">
            <h5 class="info-card-title">
                <i class="bi bi-camera-video"></i>
                Loyiha videolari
            </h5>
            <div class="gallery-grid" id="videosContainer"></div>
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
                    <h5 class="info-card-title">
                        <i class="bi bi-geo-alt"></i>
                        Joylashuv manzili
                    </h5>
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
                    <h5 class="info-card-title">
                        <i class="bi bi-building"></i>
                        Qurilish tashkiloti haqida ma'lumot
                    </h5>
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
        </div>
    </div>

    <div id="stages" class="tab-content">
        <div class="info-card">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="info-card-title mb-0">
                    <i class="bi bi-diagram-3"></i>
                    Loyiha (mulk) bosqichlari
                </h5>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleStagesEditBtn"
                        onclick="toggleStagesEdit()">
                        <i class="bi bi-pencil-square me-1"></i>
                        Tahrirlash
                    </button>
                </div>
            </div>
            <div class="progress-section">
                <div class="progress-bar-wrapper">
                    <div class="progress-bar-fill" id="progressBar" style="width: 0%">0%</div>
                </div>
            </div>
            <div class="list-group list-group-flush list-group-timeline" id="timeline"></div>
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
            <div class="info-grid" id="distributionContent">
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
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-success btn-sm" id="addRoundBtn" onclick="addNewRound()"
                        style="display: none;">
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
            <h5 class="info-card-title">
                <i class="bi bi-people"></i>
                To'liq sheriklar rekvizit ma'lumotlari
            </h5>
            <div id="partnersContainer"></div>
        </div>
    </div>

    <div id="risks" class="tab-content">
        <div class="info-card">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="info-card-title mb-0">
                    <i class="bi bi-exclamation-triangle"></i>
                    Xatarlar (Risklar)
                </h5>
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-success btn-sm" id="addRiskBtn" onclick="addNewRisk()"
                        style="display: none;">
                        <i class="bi bi-plus-lg me-1"></i>
                        Yangi xatar qo'shish
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="toggleRisksEditBtn"
                        onclick="toggleRisksEdit()">
                        <i class="bi bi-pencil-square me-1"></i>
                        Tahrirlash
                    </button>
                </div>
            </div>
            <div class="info-grid" id="risksInfoContent">
                <div class="info-row">
                    <span class="info-label">
                        <i class="bi bi-diagram-3 me-1 text-muted"></i>
                        Loyihaning boshqarilish modeli nomi
                    </span>
                    <span class="info-value" id="managementModel">-</span>
                </div>
                <div class="info-row">
                    <span class="info-label">
                        <i class="bi bi-file-text me-1 text-muted"></i>
                        Loyihaning boshqarilish modeli to'liq tavsifi
                    </span>
                    <span class="info-value" id="managementDescription">-</span>
                </div>
                <div class="info-row">
                    <span class="info-label">
                        <i class="bi bi-shield-exclamation me-1 text-muted"></i>
                        Loyihaning xatar darajasi
                    </span>
                    <span class="info-value">
                        <span class="status-badge" id="riskLevel">-</span>
                    </span>
                </div>
            </div>

            <h6
                style="margin-top: 2rem; margin-bottom: 1rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                <i class="bi bi-exclamation-circle"></i>
                Mumkin bo'lgan xatarlar
            </h6>
            <div id="risksContainer"></div>
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
    distribution: {
        full_partner_own_share: 100,
        full_partner_investor_share: 30,
        investors_own_share: 70
    },
    distribution_indicators: "To'liq sheriklar: 30%, Kommanditchilar: 70%",
    distribution_start: "2025-yil yanvar",
    last_dividend: 4.5,
    dividend_history: [{
            date: "2024-12",
            amount: 4.5,
            status: "To'langan"
        },
        {
            date: "2024-09",
            amount: 4.2,
            status: "To'langan"
        },
        {
            date: "2024-06",
            amount: 4.0,
            status: "To'langan"
        },
        {
            date: "2024-03",
            amount: 3.8,
            status: "To'langan"
        },
        {
            date: "2023-12",
            amount: 3.5,
            status: "To'langan"
        },
        {
            date: "2023-09",
            amount: 3.2,
            status: "To'langan"
        },
        {
            date: "2023-06",
            amount: 3.0,
            status: "To'langan"
        },
        {
            date: "2023-03",
            amount: 2.8,
            status: "To'langan"
        },
        {
            date: "2022-12",
            amount: 2.5,
            status: "To'langan"
        },
        {
            date: "2022-09",
            amount: 2.2,
            status: "To'langan"
        }
    ],
    stages: [{
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
    rounds: [{
            id: 1,
            name: "1-raund (Boshlang'ich)",
            status: "completed",
            min_share: 5000000
        },
        {
            id: 2,
            name: "2-raund (Asosiy)",
            status: "in_progress",
            min_share: 10000000
        },
        {
            id: 3,
            name: "3-raund (Yakunlovchi)",
            status: "inactive",
            min_share: 15000000
        }
    ],
    partners: [{
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
        management_description: "Loyiha boshqaruvi markazlashgan tuzilmada amalga oshiriladi. Barcha strategik qarorlar markaziy boshqaruv idorasi tomonidan qabul qilinadi. Operativ qarorlar esa loyiha menejerlariga topshirilgan. Har hafta hisobotlar taqdim etiladi va barcha qarorlar investorlar kengashida muhokama qilinadi. Bu model loyihaning samarali boshqarilishini va shaffoflikni ta'minlaydi.",
        risk_level: "low",
        risk_items: [{
                id: 1,
                name: "Bozor riski",
                description: "Ko'chmas mulk bozoridagi narxlarning kutilmagan pasayishi, talab-talabning kamayishi. Bu risk bozor sharoitlarining o'zgarishi, iqtisodiy inqirozlar yoki mintaqaviy omillar tufayli yuzaga kelishi mumkin. Riskni kamaytirish uchun bozor tendentsiyalarini doimiy kuzatish va diversifikatsiya strategiyasini qo'llash tavsiya etiladi."
            },
            {
                id: 2,
                name: "Qurilish riski",
                description: "Qurilish materiallarining narxining oshishi, qurilish jarayonida texnik muammolar. Materiallar narxining o'zgarishi, yetkazib beruvchilar bilan muammolar, iqlim sharoitlari va texnik xatolar qurilish jarayoniga ta'sir qilishi mumkin. Bu riskni minimallashtirish uchun ehtiyotkorlik bilan rejalashtirish va professional qurilish kompaniyalari bilan ishlash muhimdir."
            },
            {
                id: 3,
                name: "Moliyaviy risk",
                description: "Investorlar tomonidan mablag'larning o'z vaqtida kiritilmasligi, valyuta kursining o'zgarishi. Moliyaviy risklar loyihaning moliyalashtirilishiga ta'sir qilishi mumkin. Valyuta kursining o'zgarishi, investorlarning moliyaviy qiyinchiliklari yoki makroiqtisodiy omillar bu risklarni keltirib chiqarishi mumkin. Moliyaviy rejalashtirish va zaxira mablag'larini yaratish bu risklarni kamaytirishga yordam beradi."
            },
            {
                id: 4,
                name: "Huquqiy risk",
                description: "Qonunchilikdagi o'zgarishlar, ruxsatnomalarni olishdagi kechikishlar. Huquqiy risklar loyihaning amalga oshirilishiga to'sqinlik qilishi mumkin. Qonunchilikdagi o'zgarishlar, ruxsatnomalarni olishdagi kechikishlar yoki huquqiy muammolar loyihani kechiktirishi yoki to'xtatishi mumkin. Bu riskni kamaytirish uchun barcha huquqiy hujjatlarni vaqtida tayyorlash va huquqiy maslahatchilar bilan ishlash tavsiya etiladi."
            }
        ]
    },
    documents: [{
            id: 1,
            name: "Yer uchastkasi hujjatlari",
            file: "land_documents.pdf"
        },
        {
            id: 2,
            name: "Investitsiya shartnomasi",
            file: "investment_contract.pdf"
        },
        {
            id: 3,
            name: "Qurilish ruxsatnomasi",
            file: "construction_license.pdf"
        },
        {
            id: 4,
            name: "Loyiha-smeta hujjatlari",
            file: "project_estimate.pdf"
        },
        {
            id: 5,
            name: "Texnik shartlar",
            file: "technical_specs.pdf"
        }
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
        'active': {
            text: 'Faol',
            class: 'status-active'
        },
        'planned': {
            text: 'Rejalashtirilgan',
            class: 'status-planned'
        },
        'completed': {
            text: 'Yakunlangan',
            class: 'status-completed'
        },
        'inactive': {
            text: 'Nofaol',
            class: 'status-inactive'
        }
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

    const mapUrl =
        `https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2996.5!2d${p.location_lng}!3d${p.location_lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDHCsDE4JzM5LjkiTiA2OcKwMTQnMjYuMCJF!5e0!3m2!1sen!2s!4v1234567890`;
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
    displayDistribution(p.distribution);
    displayRounds(p.rounds);
    displayFinancial(p);
    displayPartners(p.partners);
    displayRisks(p.risks);
    displayDocuments(p.documents);
}

function displayMainImages(images) {
    if (!images || images.length === 0) {
        document.getElementById('mainImagesCard').style.display = 'none';
        return;
    }

    document.getElementById('mainImagesCard').style.display = 'block';
    mainImages = images;
    currentMainImageIndex = 0;

    const container = document.getElementById('mainImagesContainer');
    container.innerHTML = images.map((img, index) => `
                <div class="gallery-item" onclick="openImageModal('${img}')">
                    <img src="${img}" alt="Asosiy fon rasmi ${index + 1}" loading="lazy">
                </div>
            `).join('');
}

function displayVideos(videos) {
    if (!videos || videos.length === 0) {
        document.getElementById('videosCard').style.display = 'none';
        return;
    }

    document.getElementById('videosCard').style.display = 'block';
    const container = document.getElementById('videosContainer');
    container.innerHTML = videos.map((url, index) => {
        // YouTube URL dan thumbnail olish
        const videoId = url.match(/(?:youtube\.com\/embed\/|youtu\.be\/)([^&\n?#]+)/)?. [1];
        const thumbnailUrl = videoId ?
            `https://img.youtube.com/vi/${videoId}/maxresdefault.jpg` :
            '';

        return `
                    <div class="gallery-item video-item" onclick="openVideoModal('${url}')">
                        ${thumbnailUrl ? `<img src="${thumbnailUrl}" alt="Video ${index + 1}" loading="lazy">` : ''}
                        <div class="play-icon">
                            <i class="bi bi-play-fill"></i>
                        </div>
                    </div>
                `;
    }).join('');
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
    const modalEl = document.getElementById('mediaModal');
    const bsModal = new bootstrap.Modal(modalEl);
    const imgEl = document.getElementById('mediaModalImage');
    const videoWrapper = document.getElementById('mediaModalVideoWrapper');
    const videoEl = document.getElementById('mediaModalVideo');

    // faqat rasm ko'rsatamiz
    imgEl.classList.remove('d-none');
    videoWrapper.classList.add('d-none');
    videoEl.src = '';
    imgEl.src = imageUrl;

    bsModal.show();
}

function openVideoModal(videoUrl) {
    const modalEl = document.getElementById('mediaModal');
    const bsModal = new bootstrap.Modal(modalEl);
    const imgEl = document.getElementById('mediaModalImage');
    const videoWrapper = document.getElementById('mediaModalVideoWrapper');
    const videoEl = document.getElementById('mediaModalVideo');

    // faqat video ko'rsatamiz
    imgEl.classList.add('d-none');
    videoWrapper.classList.remove('d-none');
    videoEl.src = videoUrl;

    bsModal.show();
}

let stagesEditMode = false;

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
        'completed': {
            icon: 'bi-check-circle',
            badgeClass: 'badge-stage-status badge-stage-completed',
            text: 'Bajarildi'
        },
        'in_progress': {
            icon: 'bi-arrow-clockwise',
            badgeClass: 'badge-stage-status badge-stage-in-progress',
            text: 'Jarayonda'
        },
        'planned': {
            icon: 'bi-circle',
            badgeClass: 'badge-stage-status badge-stage-planned',
            text: 'Rejalashtirilgan'
        }
    };

    stages.forEach((stage, index) => {
        const status = statusMap[stage.status];
        const itemEl = document.createElement('div');
        itemEl.className = 'list-group-item border-0';

        if (!stagesEditMode) {
            // Ko'rish rejimi
            itemEl.innerHTML = `
                        <div class="row ps-lg-1 align-items-center">
                            <div class="col-auto">
                                <div class="${status.badgeClass}">
                                    <i class="${status.icon}"></i>
                                    ${status.text}
                                </div>
                            </div>
                            <div class="col ms-n2 mb-2">
                                <h3 class="fs-6 fw-bold mb-1">${stage.name}</h3>
                                <div class="d-flex align-items-center small text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    <span>${stage.start_date} - ${stage.end_date}</span>
                                </div>
                            </div>
                            <div class="col-auto text-end">
                                <span class="badge rounded-pill bg-light text-dark">
                                    <i class="bi bi-bar-chart-fill me-1 text-primary"></i>${stage.progress}%
                                </span>
                            </div>
                        </div>
                    `;
        } else {
            // Tahrirlash rejimi
            itemEl.innerHTML = `
                        <div class="row ps-lg-1 align-items-start gy-2">
                            <div class="col-12 col-md-4">
                                <label class="form-label small mb-1">Bosqich nomi</label>
                                <input type="text" class="form-control form-control-sm" value="${stage.name}"
                                    onchange="updateStageField(${index}, 'name', this.value)">
                            </div>
                            <div class="col-6 col-md-3">
                                <label class="form-label small mb-1">Holati</label>
                                <select class="form-select form-select-sm"
                                    onchange="updateStageField(${index}, 'status', this.value)">
                                    <option value="planned" ${stage.status === 'planned' ? 'selected' : ''}>Rejalashtirilgan</option>
                                    <option value="in_progress" ${stage.status === 'in_progress' ? 'selected' : ''}>Jarayonda</option>
                                    <option value="completed" ${stage.status === 'completed' ? 'selected' : ''}>Bajarilgan</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-2">
                                <label class="form-label small mb-1">% bajarilgan</label>
                                <input type="number" min="0" max="100" class="form-control form-control-sm" value="${stage.progress}"
                                    onchange="updateStageField(${index}, 'progress', Number(this.value) || 0)">
                            </div>
                            <div class="col-6 col-md-1">
                                <label class="form-label small mb-1">Boshlanish</label>
                                <input type="text" class="form-control form-control-sm" value="${stage.start_date}"
                                    onchange="updateStageField(${index}, 'start_date', this.value)">
                            </div>
                            <div class="col-6 col-md-1">
                                <label class="form-label small mb-1">Yakun</label>
                                <input type="text" class="form-control form-control-sm" value="${stage.end_date}"
                                    onchange="updateStageField(${index}, 'end_date', this.value)">
                            </div>
                        </div>
                    `;
        }

        timeline.appendChild(itemEl);
    });
}

function toggleStagesEdit() {
    stagesEditMode = !stagesEditMode;
    const btn = document.getElementById('toggleStagesEditBtn');
    btn.innerHTML = stagesEditMode ?
        '<i class="bi bi-check-lg me-1"></i> Saqlash' :
        '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';

    displayStages(projectData.stages);
}

function updateStageField(index, field, value) {
    if (!projectData || !projectData.stages || !projectData.stages[index]) return;
    projectData.stages[index][field] = value;
    // progress bar va ko‘rinish yangilanishi uchun qayta chizamiz
    displayStages(projectData.stages);
}

let distributionEditMode = false;

function displayDistribution(distribution) {
    if (!distribution) return;

    const content = document.getElementById('distributionContent');

    if (!distributionEditMode) {
        // Ko'rish rejimi
        content.innerHTML = `
                    <div class="info-row">
                        <span class="info-label">To'liq sherikning investitsion loyihadagi o'ziga tegishli ulushining
                            realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                        <span class="info-value" id="fullPartnerOwnShare">${distribution.full_partner_own_share}%</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">To'liq sherikning investitsion Kommanditchilarning loyihadagi tegishli
                            ulushining realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                        <span class="info-value" id="fullPartnerInvestorShare">${distribution.full_partner_investor_share}%</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kommanditchilarning investitsion loyihadagi o'ziga tegishli ulushining
                            realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                        <span class="info-value" id="investorsOwnShare">${distribution.investors_own_share}%</span>
                    </div>
                `;
    } else {
        // Tahrirlash rejimi
        content.innerHTML = `
                    <div class="info-row">
                        <span class="info-label">To'liq sherikning investitsion loyihadagi o'ziga tegishli ulushining
                            realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                        <div class="d-flex align-items-center gap-2">
                            <input type="number" min="0" max="100" step="0.1" 
                                class="form-control form-control-sm" style="max-width: 120px;" 
                                value="${distribution.full_partner_own_share}"
                                onchange="updateDistributionField('full_partner_own_share', Number(this.value) || 0)"
                                id="editFullPartnerOwnShare">
                            <span class="text-muted">%</span>
                        </div>
                    </div>
                    <div class="info-row">
                        <span class="info-label">To'liq sherikning investitsion Kommanditchilarning loyihadagi tegishli
                            ulushining realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                        <div class="d-flex align-items-center gap-2">
                            <input type="number" min="0" max="100" step="0.1" 
                                class="form-control form-control-sm" style="max-width: 120px;" 
                                value="${distribution.full_partner_investor_share}"
                                onchange="updateDistributionField('full_partner_investor_share', Number(this.value) || 0)"
                                id="editFullPartnerInvestorShare">
                            <span class="text-muted">%</span>
                        </div>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kommanditchilarning investitsion loyihadagi o'ziga tegishli ulushining
                            realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                        <div class="d-flex align-items-center gap-2">
                            <input type="number" min="0" max="100" step="0.1" 
                                class="form-control form-control-sm" style="max-width: 120px;" 
                                value="${distribution.investors_own_share}"
                                onchange="updateDistributionField('investors_own_share', Number(this.value) || 0)"
                                id="editInvestorsOwnShare">
                            <span class="text-muted">%</span>
                        </div>
                    </div>
                `;
    }

    // Vizual taqsimotni yangilash
    updateDistributionVisual(distribution);
}

function updateDistributionVisual(distribution) {
    const partnersPercent = distribution.full_partner_investor_share;
    const investorsPercent = distribution.investors_own_share;

    const partnersSegment = document.getElementById('partnersSegment');
    const investorsSegment = document.getElementById('investorsSegment');

    if (partnersSegment && investorsSegment) {
        partnersSegment.style.width = partnersPercent + '%';
        partnersSegment.textContent = `To'liq sheriklar: ${partnersPercent}%`;

        investorsSegment.style.width = investorsPercent + '%';
        investorsSegment.textContent = `Kommanditchilar: ${investorsPercent}%`;
    }
}

function toggleDistributionEdit() {
    distributionEditMode = !distributionEditMode;
    const btn = document.getElementById('toggleDistributionEditBtn');
    btn.innerHTML = distributionEditMode ?
        '<i class="bi bi-check-lg me-1"></i> Saqlash' :
        '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';

    if (projectData && projectData.distribution) {
        displayDistribution(projectData.distribution);
    }
}

function updateDistributionField(field, value) {
    if (!projectData || !projectData.distribution) return;

    // Qiymatni cheklash
    if (value < 0) value = 0;
    if (value > 100) value = 100;

    projectData.distribution[field] = value;

    // Agar full_partner_investor_share o'zgarsa, investors_own_share ni avtomatik hisoblaymiz
    if (field === 'full_partner_investor_share') {
        projectData.distribution.investors_own_share = 100 - value;
        // Input qiymatini yangilaymiz
        const investorsInput = document.getElementById('editInvestorsOwnShare');
        if (investorsInput) {
            investorsInput.value = projectData.distribution.investors_own_share;
        }
    }

    // Agar investors_own_share o'zgarsa, full_partner_investor_share ni avtomatik hisoblaymiz
    if (field === 'investors_own_share') {
        projectData.distribution.full_partner_investor_share = 100 - value;
        // Input qiymatini yangilaymiz
        const partnerInput = document.getElementById('editFullPartnerInvestorShare');
        if (partnerInput) {
            partnerInput.value = projectData.distribution.full_partner_investor_share;
        }
    }

    // Vizual taqsimotni yangilash
    updateDistributionVisual(projectData.distribution);
}

let roundsEditMode = false;
let nextRoundId = 4; // Yangi roundlar uchun ID

function displayRounds(rounds) {
    const container = document.getElementById('roundsContainer');
    const statusMap = {
        'in_progress': {
            text: 'Jarayonda',
            class: 'status-inprogress'
        },
        'completed': {
            text: 'Yakunlangan',
            class: 'status-completed'
        },
        'inactive': {
            text: 'Nofaol',
            class: 'status-inactive'
        }
    };

    if (!rounds || rounds.length === 0) {
        container.innerHTML = '<p class="text-muted text-center py-4">Raundlar mavjud emas</p>';
        return;
    }

    if (!roundsEditMode) {
        // Ko'rish rejimi
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
    } else {
        // Tahrirlash rejimi
        container.innerHTML = rounds.map((round, index) => {
            const status = statusMap[round.status];
            return `
                        <div class="round-item" style="flex-direction: column; align-items: stretch; gap: 1rem;">
                            <div class="row g-2 align-items-center">
                                <div class="col-12 col-md-4">
                                    <label class="form-label small mb-1">Raund nomi</label>
                                    <input type="text" class="form-control form-control-sm" value="${round.name}"
                                        onchange="updateRoundField(${round.id}, 'name', this.value)"
                                        id="roundName_${round.id}">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label small mb-1">Holati</label>
                                    <select class="form-select form-select-sm"
                                        onchange="updateRoundField(${round.id}, 'status', this.value)"
                                        id="roundStatus_${round.id}">
                                        <option value="inactive" ${round.status === 'inactive' ? 'selected' : ''}>Nofaol</option>
                                        <option value="in_progress" ${round.status === 'in_progress' ? 'selected' : ''}>Jarayonda</option>
                                        <option value="completed" ${round.status === 'completed' ? 'selected' : ''}>Yakunlangan</option>
                                    </select>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label small mb-1">Minimal ulush (so'm)</label>
                                    <input type="number" min="0" step="1000" class="form-control form-control-sm" 
                                        value="${round.min_share}"
                                        onchange="updateRoundField(${round.id}, 'min_share', Number(this.value) || 0)"
                                        id="roundMinShare_${round.id}">
                                </div>
                                <div class="col-12 col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm w-100" 
                                        onclick="deleteRound(${round.id})">
                                        <i class="bi bi-trash"></i> O'chirish
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
        }).join('');
    }
}

function toggleRoundsEdit() {
    roundsEditMode = !roundsEditMode;
    const btn = document.getElementById('toggleRoundsEditBtn');
    const addBtn = document.getElementById('addRoundBtn');

    btn.innerHTML = roundsEditMode ?
        '<i class="bi bi-check-lg me-1"></i> Saqlash' :
        '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';

    addBtn.style.display = roundsEditMode ? 'inline-flex' : 'none';

    if (projectData && projectData.rounds) {
        displayRounds(projectData.rounds);
    }
}

function addNewRound() {
    if (!projectData || !projectData.rounds) return;

    const newRound = {
        id: nextRoundId++,
        name: `Yangi raund ${nextRoundId - 3}`,
        status: 'inactive',
        min_share: 0
    };

    projectData.rounds.push(newRound);
    displayRounds(projectData.rounds);
}

function updateRoundField(roundId, field, value) {
    if (!projectData || !projectData.rounds) return;

    const round = projectData.rounds.find(r => r.id === roundId);
    if (!round) return;

    round[field] = value;

    // Agar edit rejimida bo'lsa, ko'rinishni yangilaymiz
    if (roundsEditMode) {
        displayRounds(projectData.rounds);
    }
}

function deleteRound(roundId) {
    if (!projectData || !projectData.rounds) return;

    if (confirm('Bu raundni o\'chirishni xohlaysizmi?')) {
        projectData.rounds = projectData.rounds.filter(r => r.id !== roundId);
        displayRounds(projectData.rounds);
    }
}

let currentDividendPage = 1;
const itemsPerPage = 5;

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

    displayDividendHistory(p.dividend_history);
}

function displayDividendHistory(dividendHistory) {
    if (!dividendHistory || dividendHistory.length === 0) {
        document.getElementById('dividendHistory').innerHTML = `
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                        <p>Dividendlar tarixi mavjud emas</p>
                    </div>
                `;
        const paginationEl = document.getElementById('dividendPagination');
        const summaryEl = document.getElementById('dividendSummary');
        if (paginationEl) paginationEl.innerHTML = '';
        if (summaryEl) summaryEl.textContent = '';
        return;
    }

    const totalPages = Math.ceil(dividendHistory.length / itemsPerPage);
    const startIndex = (currentDividendPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const paginatedItems = dividendHistory.slice(startIndex, endIndex);

    // Summary text (1 - 5 / Jami: 10) user page uslubida
    const total = dividendHistory.length;
    const start = startIndex + 1;
    const end = Math.min(endIndex, total);
    const summaryEl = document.getElementById('dividendSummary');
    if (summaryEl) {
        summaryEl.textContent = `${start} - ${end} / Jami: ${total}`;
    }

    const historyContainer = document.getElementById('dividendHistory');
    historyContainer.innerHTML = `
                <table class="table user-table table-bordered table-hover table-striped align-items-center">
                    <thead class="table-dark">
                        <tr>
                            <th>
                                <i class="bi bi-calendar3 me-1"></i>
                                Sana
                            </th>
                            <th>
                                <i class="bi bi-percent me-1"></i>
                                Dividend foizi
                            </th>
                            <th>
                                <i class="bi bi-check-circle me-1"></i>
                                Holati
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        ${paginatedItems.map(item => {
                            const statusClass = item.status === 'To\'langan' ? 'status-badge-paid' : 'status-badge-pending';
                            const statusIcon = item.status === 'To\'langan' ? 'bi-check-circle-fill' : 'bi-clock';
                            return `
                                <tr>
                                    <td>
                                        <i class="bi bi-calendar-event me-1 text-muted"></i>
                                        <strong>${item.date}</strong>
                                    </td>
                                    <td>
                                        <span style="font-size: 1.1rem; font-weight: 600; color: var(--success-color);">
                                            ${item.amount}%
                                        </span>
                                    </td>
                                    <td>
                                        <span class="${statusClass}">
                                            <i class="bi ${statusIcon}"></i>
                                            ${item.status}
                                        </span>
                                    </td>
                                </tr>
                            `;
                        }).join('')}
                    </tbody>
                </table>
            `;

    // Pagination
    if (totalPages > 1) {
        displayDividendPagination(totalPages);
    } else {
        document.getElementById('dividendPagination').innerHTML = '';
    }
}

function displayDividendPagination(totalPages) {
    const paginationContainer = document.getElementById('dividendPagination');
    let paginationHTML = '<ul class="pagination pagination-sm mb-0 mt-2">';

    // Previous
    paginationHTML += `
                <li class="page-item ${currentDividendPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0)" onclick="changeDividendPage(${currentDividendPage - 1})">
                        <i class="fa-solid fa-angle-left"></i>
                    </a>
                </li>
            `;

    // Page numbers (simple version: all pages, with active state)
    for (let i = 1; i <= totalPages; i++) {
        paginationHTML += `
                    <li class="page-item ${i === currentDividendPage ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0)" onclick="changeDividendPage(${i})">
                            ${i}
                        </a>
                    </li>
                `;
    }

    // Next
    paginationHTML += `
                <li class="page-item ${currentDividendPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0)" onclick="changeDividendPage(${currentDividendPage + 1})">
                        <i class="fa-solid fa-angle-right"></i>
                    </a>
                </li>
            `;

    paginationHTML += '</ul>';
    paginationContainer.innerHTML = paginationHTML;
}

function changeDividendPage(page) {
    if (page < 1 || !projectData || !projectData.dividend_history) return;
    const totalPages = Math.ceil(projectData.dividend_history.length / itemsPerPage);
    if (page > totalPages) return;

    currentDividendPage = page;
    displayDividendHistory(projectData.dividend_history);

    // Scroll to top of table
    const historyContainer = document.getElementById('dividendHistory');
    historyContainer.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

function displayPartners(partners) {
    const container = document.getElementById('partnersContainer');
    container.innerHTML = partners.map(partner => `
                                    <div class="partner-card" style="margin-bottom: 1.5rem;">
                                        <div class="partner-header">
                                            <i class="bi bi-building me-2"></i>
                                            ${partner.company_name}
                                        </div>
                                        <div class="info-grid">
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-hash me-1 text-muted"></i>
                                                    To'liq sherikning identifikatori (ID)
                                                </span>
                                                <span class="info-value">${partner.id}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-building me-1 text-muted"></i>
                                                    Korxona to'liq nomi
                                                </span>
                                                <span class="info-value">${partner.company_name}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-card-text me-1 text-muted"></i>
                                                    INN
                                                </span>
                                                <span class="info-value">${partner.inn}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-upc-scan me-1 text-muted"></i>
                                                    IFUT kodi
                                                </span>
                                                <span class="info-value">${partner.ifut}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-briefcase me-1 text-muted"></i>
                                                    Faoliyat turi
                                                </span>
                                                <span class="info-value">${partner.type}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-geo-alt me-1 text-muted"></i>
                                                    Manzil
                                                </span>
                                                <span class="info-value">${partner.address}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-person-badge me-1 text-muted"></i>
                                                    Direktor F.I.O.
                                                </span>
                                                <span class="info-value">${partner.director}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-telephone me-1 text-muted"></i>
                                                    Bog'lanish uchun telefon raqami
                                                </span>
                                                <span class="info-value">${partner.phone}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-envelope me-1 text-muted"></i>
                                                    Email
                                                </span>
                                                <span class="info-value">${partner.email}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-calendar-check me-1 text-muted"></i>
                                                    Ro'yxatdan o'tkazilgan sana
                                                </span>
                                                <span class="info-value">${partner.registration_date}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-file-earmark-text me-1 text-muted"></i>
                                                    Ro'yxatdan o'tkazish raqami
                                                </span>
                                                <span class="info-value">${partner.registration_number}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-building-check me-1 text-muted"></i>
                                                    Ro'yxatdan o'tkazuvchi davlat tashkiloti nomi
                                                </span>
                                                <span class="info-value">${partner.registration_org}</span>
                                            </div>
                                            ${partner.type === 'YaTT' ? `
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-person-vcard me-1 text-muted"></i>
                                                    Pasport ma'lumoti
                                                </span>
                                                <span class="info-value">${partner.passport_data}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-fingerprint me-1 text-muted"></i>
                                                    JSHSHIR
                                                </span>
                                                <span class="info-value">${partner.pinfl}</span>
                                            </div>
                                            ` : ''}
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-toggle-on me-1 text-muted"></i>
                                                    Akkount holati
                                                </span>
                                                <span class="info-value">
                                                    ${partner.account_status === 'active' 
                                                        ? '<span class="status-badge status-active"><i class="bi bi-check-circle me-1"></i>Faol</span>' 
                                                        : '<span class="status-badge status-inactive"><i class="bi bi-x-circle me-1"></i>Bloklangan</span>'}
                                                </span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-handshake me-1 text-muted"></i>
                                                    To'liq sheriklik holati sanasi
                                                </span>
                                                <span class="info-value">${partner.partnership_date}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-file-earmark-pdf me-1 text-muted"></i>
                                                    Investorlik sertifikati fayli
                                                </span>
                                                <span class="info-value">${partner.investor_certificate}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-cash-stack me-1 text-muted"></i>
                                                    Loyihadagi jami ulushi (summada)
                                                </span>
                                                <span class="info-value">${formatMoney(partner.share_amount)}</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="bi bi-percent me-1 text-muted"></i>
                                                    Loyihadagi jami ulushi (foizda)
                                                </span>
                                                <span class="info-value">${partner.share_percent}%</span>
                                            </div>
                                        </div>
                                    </div>
                                `).join('');
}

let risksEditMode = false;
let nextRiskId = 5; // Yangi risklar uchun ID

function displayRisks(risks) {
    const infoContent = document.getElementById('risksInfoContent');

    if (!risksEditMode) {
        // Ko'rish rejimi
        infoContent.innerHTML = `
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-diagram-3 me-1 text-muted"></i>
                            Loyihaning boshqarilish modeli nomi
                        </span>
                        <span class="info-value" id="managementModel">${risks.management_model || '-'}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-file-text me-1 text-muted"></i>
                            Loyihaning boshqarilish modeli to'liq tavsifi
                        </span>
                        <span class="info-value" id="managementDescription">${risks.management_description || risks.management_info || '-'}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-shield-exclamation me-1 text-muted"></i>
                            Loyihaning xatar darajasi
                        </span>
                        <span class="info-value">
                            <span class="status-badge" id="riskLevel">-</span>
                        </span>
                    </div>
                `;
    } else {
        // Tahrirlash rejimi
        infoContent.innerHTML = `
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-diagram-3 me-1 text-muted"></i>
                            Loyihaning boshqarilish modeli nomi
                        </span>
                        <input type="text" class="form-control" value="${risks.management_model || ''}"
                            onchange="updateRiskField('management_model', this.value)"
                            id="editManagementModel">
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-file-text me-1 text-muted"></i>
                            Loyihaning boshqarilish modeli to'liq tavsifi
                        </span>
                        <textarea class="form-control" rows="4" 
                            onchange="updateRiskField('management_description', this.value)"
                            id="editManagementDescription">${risks.management_description || risks.management_info || ''}</textarea>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-shield-exclamation me-1 text-muted"></i>
                            Loyihaning xatar darajasi
                        </span>
                        <select class="form-select" style="max-width: 200px;"
                            onchange="updateRiskField('risk_level', this.value)"
                            id="editRiskLevel">
                            <option value="low" ${risks.risk_level === 'low' ? 'selected' : ''}>Past</option>
                            <option value="medium" ${risks.risk_level === 'medium' ? 'selected' : ''}>O'rta</option>
                            <option value="high" ${risks.risk_level === 'high' ? 'selected' : ''}>Yuqori</option>
                        </select>
                    </div>
                `;
    }

    const riskMap = {
        'low': {
            text: 'Past',
            class: 'status-active'
        },
        'medium': {
            text: "O'rta",
            class: 'status-planned'
        },
        'high': {
            text: 'Yuqori',
            class: 'status-inactive'
        }
    };

    const risk = riskMap[risks.risk_level];
    const riskEl = document.getElementById('riskLevel');
    if (riskEl) {
        riskEl.textContent = risk.text;
        riskEl.className = `status-badge ${risk.class}`;
    }

    // Risk items
    const container = document.getElementById('risksContainer');
    if (!risks.risk_items || risks.risk_items.length === 0) {
        container.innerHTML = '<p class="text-muted text-center py-4">Xatarlar mavjud emas</p>';
        return;
    }

    if (!risksEditMode) {
        // Ko'rish rejimi
        container.innerHTML = risks.risk_items.map(item => `
                    <div class="risk-item">
                        <div class="risk-title">
                            <i class="bi bi-exclamation-triangle"></i>
                            ${item.name}
                        </div>
                        <p class="risk-description">${item.description}</p>
                    </div>
                `).join('');
    } else {
        // Tahrirlash rejimi
        container.innerHTML = risks.risk_items.map((item, index) => `
                    <div class="risk-item" style="border: 1px solid var(--gray-200); padding: 1.5rem;">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label small mb-1">
                                    <i class="bi bi-exclamation-triangle me-1 text-warning"></i>
                                    Xatar nomi
                                </label>
                                <input type="text" class="form-control form-control-sm" value="${item.name}"
                                    onchange="updateRiskItemField(${item.id || index}, 'name', this.value)"
                                    id="riskName_${item.id || index}">
                            </div>
                            <div class="col-12">
                                <label class="form-label small mb-1">
                                    <i class="bi bi-file-text me-1 text-muted"></i>
                                    Xatar tavsifi
                                </label>
                                <textarea class="form-control form-control-sm" rows="3"
                                    onchange="updateRiskItemField(${item.id || index}, 'description', this.value)"
                                    id="riskDesc_${item.id || index}">${item.description}</textarea>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-danger btn-sm" 
                                    onclick="deleteRisk(${item.id || index})">
                                    <i class="bi bi-trash me-1"></i>
                                    O'chirish
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('');
    }
}

function toggleRisksEdit() {
    risksEditMode = !risksEditMode;
    const btn = document.getElementById('toggleRisksEditBtn');
    const addBtn = document.getElementById('addRiskBtn');

    btn.innerHTML = risksEditMode ?
        '<i class="bi bi-check-lg me-1"></i> Saqlash' :
        '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';

    addBtn.style.display = risksEditMode ? 'inline-flex' : 'none';

    if (projectData && projectData.risks) {
        displayRisks(projectData.risks);
    }
}

function updateRiskField(field, value) {
    if (!projectData || !projectData.risks) return;

    projectData.risks[field] = value;

    // Agar risk_level o'zgarsa, ko'rinishni yangilaymiz
    if (field === 'risk_level') {
        const riskMap = {
            'low': {
                text: 'Past',
                class: 'status-active'
            },
            'medium': {
                text: "O'rta",
                class: 'status-planned'
            },
            'high': {
                text: 'Yuqori',
                class: 'status-inactive'
            }
        };
        const risk = riskMap[value];
        const riskEl = document.getElementById('riskLevel');
        if (riskEl) {
            riskEl.textContent = risk.text;
            riskEl.className = `status-badge ${risk.class}`;
        }
    }
}

function updateRiskItemField(riskId, field, value) {
    if (!projectData || !projectData.risks || !projectData.risks.risk_items) return;

    const riskItem = projectData.risks.risk_items.find(r => r.id === riskId) ||
        projectData.risks.risk_items[riskId];
    if (!riskItem) return;

    riskItem[field] = value;
}

function addNewRisk() {
    if (!projectData || !projectData.risks || !projectData.risks.risk_items) return;

    const newRisk = {
        id: nextRiskId++,
        name: 'Yangi xatar',
        description: 'Xatar tavsifini kiriting...'
    };

    projectData.risks.risk_items.push(newRisk);
    displayRisks(projectData.risks);
}

function deleteRisk(riskId) {
    if (!projectData || !projectData.risks || !projectData.risks.risk_items) return;

    if (confirm('Bu xatarni o\'chirishni xohlaysizmi?')) {
        projectData.risks.risk_items = projectData.risks.risk_items.filter(r => r.id !== riskId);
        displayRisks(projectData.risks);
    }
}

let documentsEditMode = false;
let nextDocumentId = 6; // Yangi hujjatlar uchun ID

function displayDocuments(documents) {
    const container = document.getElementById('documentsContainer');

    if (!documents || documents.length === 0) {
        container.innerHTML = '<p class="text-muted text-center py-4">Hujjatlar mavjud emas</p>';
        return;
    }

    if (!documentsEditMode) {
        // Ko'rish rejimi
        container.innerHTML = documents.map(doc => `
                    <div class="document-item">
                        <div class="document-info">
                            <div class="document-icon">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-900);">${doc.name}</div>
                                <div style="font-size: 0.85rem; color: var(--gray-600);">
                                    <i class="bi bi-file-earmark me-1"></i>
                                    ${doc.file}
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-1"
                            onclick="downloadDocument('${doc.file}')">
                            <i class="bi bi-download"></i> Yuklash
                        </button>
                    </div>
                `).join('');
    } else {
        // Tahrirlash rejimi
        container.innerHTML = documents.map((doc, index) => `
                    <div class="document-item" style="flex-direction: column; align-items: stretch; gap: 1rem; padding: 1.5rem;">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-5">
                                <label class="form-label small mb-1">
                                    <i class="bi bi-file-text me-1 text-muted"></i>
                                    Hujjat nomi
                                </label>
                                <input type="text" class="form-control form-control-sm" value="${doc.name}"
                                    onchange="updateDocumentField(${doc.id || index}, 'name', this.value)"
                                    id="docName_${doc.id || index}">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label small mb-1">
                                    <i class="bi bi-file-earmark me-1 text-muted"></i>
                                    Hozirgi fayl
                                </label>
                                <div class="form-control form-control-sm" style="background: var(--gray-50); padding: 0.5rem;">
                                    <i class="bi bi-file-earmark-pdf me-1"></i>
                                    <span style="font-size: 0.875rem;">${doc.file}</span>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label small mb-1">
                                    <i class="bi bi-upload me-1 text-muted"></i>
                                    Yangi fayl yuklash
                                </label>
                                <input type="file" class="form-control form-control-sm" 
                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                                    onchange="handleFileUpload(${doc.id || index}, this)"
                                    id="docFile_${doc.id || index}">
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-1"
                                onclick="downloadDocument('${doc.file}')">
                                <i class="bi bi-download"></i> Yuklash
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" 
                                onclick="deleteDocument(${doc.id || index})">
                                <i class="bi bi-trash me-1"></i>
                                O'chirish
                            </button>
                        </div>
                    </div>
                `).join('');
    }
}

function toggleDocumentsEdit() {
    documentsEditMode = !documentsEditMode;
    const btn = document.getElementById('toggleDocumentsEditBtn');
    const addBtn = document.getElementById('addDocumentBtn');

    btn.innerHTML = documentsEditMode ?
        '<i class="bi bi-check-lg me-1"></i> Saqlash' :
        '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';

    addBtn.style.display = documentsEditMode ? 'inline-flex' : 'none';

    if (projectData && projectData.documents) {
        displayDocuments(projectData.documents);
    }
}

function updateDocumentField(docId, field, value) {
    if (!projectData || !projectData.documents) return;

    const doc = projectData.documents.find(d => d.id === docId) ||
        projectData.documents[docId];
    if (!doc) return;

    doc[field] = value;
}

function handleFileUpload(docId, input) {
    if (!input.files || input.files.length === 0) return;

    const file = input.files[0];
    const fileName = file.name;

    if (!projectData || !projectData.documents) return;

    const doc = projectData.documents.find(d => d.id === docId) ||
        projectData.documents[docId];
    if (!doc) return;

    // Fayl nomini yangilaymiz
    doc.file = fileName;

    // Bu yerda haqiqiy fayl yuklash API chaqiruvini qo'shish mumkin
    // Masalan: uploadFileToServer(file, docId)

    // Ko'rinishni yangilaymiz
    displayDocuments(projectData.documents);

    // Input ni tozalaymiz (yangi fayl yuklash uchun)
    input.value = '';
}

function addNewDocument() {
    if (!projectData || !projectData.documents) return;

    const newDoc = {
        id: nextDocumentId++,
        name: 'Yangi hujjat',
        file: 'fayl_yuklanmagan.pdf'
    };

    projectData.documents.push(newDoc);
    displayDocuments(projectData.documents);
}

function deleteDocument(docId) {
    if (!projectData || !projectData.documents) return;

    if (confirm('Bu hujjatni o\'chirishni xohlaysizmi?')) {
        projectData.documents = projectData.documents.filter(d => d.id !== docId);
        displayDocuments(projectData.documents);
    }
}

function switchTab(tabName) {
    document.querySelectorAll('.nav-link').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));

    event.target.classList.add('active');
    document.getElementById(tabName).classList.add('active');
    currentTab = tabName;
}

function scrollTabs(direction) {
    const navTabs = document.getElementById('projectTabs');
    const scrollAmount = 200;

    if (direction === 'left') {
        navTabs.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    } else {
        navTabs.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }

    // Scroll tugmalarini tekshirish
    setTimeout(() => {
        checkScrollButtons();
    }, 300);
}

function checkScrollButtons() {
    const navTabs = document.getElementById('projectTabs');
    const scrollLeftBtn = document.getElementById('scrollLeftBtn');
    const scrollRightBtn = document.getElementById('scrollRightBtn');

    // Chap tugma
    if (navTabs.scrollLeft <= 0) {
        scrollLeftBtn.classList.add('hidden');
    } else {
        scrollLeftBtn.classList.remove('hidden');
    }

    // O'ng tugma
    if (navTabs.scrollLeft >= navTabs.scrollWidth - navTabs.clientWidth - 1) {
        scrollRightBtn.classList.add('hidden');
    } else {
        scrollRightBtn.classList.remove('hidden');
    }
}

// Scroll holatini kuzatish
document.addEventListener('DOMContentLoaded', function() {
    const navTabs = document.getElementById('projectTabs');
    if (navTabs) {
        checkScrollButtons();
        navTabs.addEventListener('scroll', checkScrollButtons);
    }
});

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