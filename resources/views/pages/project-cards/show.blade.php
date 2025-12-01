@extends('layouts.app')

@push('customCss')
<style>
    .project-detail-page {
        background: #f7fafc;
        min-height: 100vh;
        padding: 2rem 0;
    }

    .preview-block {
        position: relative;
        height: 500px;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    .preview-background {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.7);
    }

    .preview-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7));
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 3rem;
    }

    .project-title {
        color: white;
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }

    .start-investment-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 1rem 3rem;
        font-size: 1.2rem;
        font-weight: 600;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .start-investment-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
    }

    .info-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .info-card-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-card-title i {
        color: #667eea;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        padding: 1rem;
        background: #f7fafc;
        border-radius: 10px;
        border-left: 4px solid #667eea;
    }

    .info-label {
        font-size: 0.9rem;
        color: #718096;
        margin-bottom: 0.5rem;
    }

    .info-value {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2d3748;
    }

    .calculator-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 2rem;
        color: white;
    }

    .calculator-input {
        background: rgba(255,255,255,0.2);
        border: 2px solid rgba(255,255,255,0.3);
        color: white;
        padding: 1rem;
        border-radius: 10px;
        font-size: 1.2rem;
        width: 100%;
        margin-bottom: 1rem;
    }

    .calculator-input::placeholder {
        color: rgba(255,255,255,0.7);
    }

    .calculator-result {
        background: rgba(255,255,255,0.2);
        padding: 1.5rem;
        border-radius: 10px;
        margin-top: 1rem;
    }

    .result-label {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
    }

    .result-value {
        font-size: 2rem;
        font-weight: 700;
    }

    .progress-timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 2rem;
        border-left: 2px solid #e2e8f0;
        padding-left: 2rem;
    }

    .timeline-item:last-child {
        border-left: none;
    }

    .timeline-dot {
        position: absolute;
        left: -9px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #667eea;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #667eea;
    }

    .timeline-dot.completed {
        background: #48bb78;
        box-shadow: 0 0 0 2px #48bb78;
    }

    .timeline-date {
        font-weight: 600;
        color: #667eea;
        margin-bottom: 0.5rem;
    }

    .document-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        background: #f7fafc;
        border-radius: 10px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .document-item:hover {
        background: #edf2f7;
        transform: translateX(5px);
    }

    .document-icon {
        width: 50px;
        height: 50px;
        background: #667eea;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-right: 1rem;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
    }

    .gallery-item {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        aspect-ratio: 16/9;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .gallery-item:hover {
        transform: scale(1.05);
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .risk-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .risk-past {
        background: #c6f6d5;
        color: #22543d;
    }

    .risk-orta {
        background: #feebc8;
        color: #744210;
    }

    .risk-yuqori {
        background: #fed7d7;
        color: #742a2a;
    }

    .progress-bar-custom {
        height: 30px;
        border-radius: 15px;
        background: #e2e8f0;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 1rem;
        color: white;
        font-weight: 600;
        transition: width 1s ease;
    }
</style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.project-cards.index') }}">{{__('admin.projects')}}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{__('admin.project_details')}}</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
<div class="project-detail-page">
    <div class="container">
        <!-- Preview Block -->
        <div class="preview-block">
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200" alt="{{__('admin.project')}}" class="preview-background">
            <div class="preview-overlay">
                <h1 class="project-title">Toshkent Biznes Markazi</h1>
                <div>
                    <button class="start-investment-btn">
                        <i class="fas fa-rocket"></i>
                        {{__('admin.start_investment')}}
                    </button>
                </div>
            </div>
        </div>

        <!-- Loyiha haqida -->
        <div class="info-card">
            <h2 class="info-card-title">
                <i class="fas fa-info-circle"></i>
                {{__('admin.about_project')}}
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">{{__('admin.location')}}</div>
                    <div class="info-value">Toshkent sh., Chilonzor tumani</div>
                </div>
                <div class="info-item">
                    <div class="info-label">{{__('admin.purpose')}}</div>
                    <div class="info-value">{{__('admin.commercial_construction')}}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">{{__('admin.min_investment')}}</div>
                    <div class="info-value">5,000,000 {{__('admin.sum')}}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">{{__('admin.construction_company')}}</div>
                    <div class="info-value">Envast Construction {{__('admin.llc')}}</div>
                </div>
            </div>
        </div>

        <!-- Moliyaviy ma'lumotlar -->
        <div class="info-card">
            <h2 class="info-card-title">
                <i class="fas fa-chart-line"></i>
                {{__('admin.financial_info')}}
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">{{__('admin.investment_duration')}}</div>
                    <div class="info-value">18 {{__('admin.months')}}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">{{__('admin.annual_profit')}}</div>
                    <div class="info-value">28%</div>
                </div>
                <div class="info-item">
                    <div class="info-label">{{__('admin.dividend_distribution')}}</div>
                    <div class="info-value">{{__('admin.quarterly')}}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">{{__('admin.risk_level')}}</div>
                    <div class="info-value">
                        <span class="risk-badge risk-orta">
                            {{__('admin.medium')}}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Kalkulyator -->
            <div class="calculator-card mt-4">
                <h3 class="mb-3">
                    <i class="fas fa-calculator"></i>
                    {{__('admin.profit_calculator')}}
                </h3>
                <input type="number" class="calculator-input" id="investAmount" 
                       placeholder="{{__('admin.enter_investment_amount')}}" value="10000000">
                <div class="calculator-result">
                    <div class="result-label">{{__('admin.expected_profit')}} (18 {{__('admin.months')}})</div>
                    <div class="result-value" id="calculatedProfit">2,800,000 {{__('admin.sum')}}</div>
                    <div class="result-label mt-3">{{__('admin.total_value')}}</div>
                    <div class="result-value" id="totalValue">12,800,000 {{__('admin.sum')}}</div>
                </div>
                <button class="start-investment-btn mt-3 w-100">
                    <i class="fas fa-mobile-alt"></i>
                    {{__('admin.invest_via_mobile_app')}}
                </button>
            </div>
        </div>

        <!-- Hujjatlar -->
        <div class="info-card">
            <h2 class="info-card-title">
                <i class="fas fa-file-alt"></i>
                {{__('admin.documents')}}
            </h2>
            <div class="document-item">
                <div class="document-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <div>
                    <div style="font-weight: 600; color: #2d3748;">{{__('admin.investment_contract')}}</div>
                    <div style="font-size: 0.9rem; color: #718096;">PDF, 2.5 MB</div>
                </div>
                <i class="fas fa-download ms-auto" style="color: #667eea;"></i>
            </div>
            <div class="document-item">
                <div class="document-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <div>
                    <div style="font-weight: 600; color: #2d3748;">{{__('admin.sharia_fatwa')}}</div>
                    <div style="font-size: 0.9rem; color: #718096;">PDF, 1.2 MB</div>
                </div>
                <i class="fas fa-download ms-auto" style="color: #667eea;"></i>
            </div>
            <div class="document-item">
                <div class="document-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <div>
                    <div style="font-weight: 600; color: #2d3748;">{{__('admin.land_documents')}}</div>
                    <div style="font-size: 0.9rem; color: #718096;">PDF, 3.1 MB</div>
                </div>
                <i class="fas fa-download ms-auto" style="color: #667eea;"></i>
            </div>
        </div>

        <!-- Qurilish statusi -->
        <div class="info-card">
            <h2 class="info-card-title">
                <i class="fas fa-tasks"></i>
                {{__('admin.construction_status')}}
            </h2>
            <div class="progress-bar-custom">
                <div class="progress-fill" style="width: 45%">
                    45%
                </div>
            </div>

            <div class="progress-timeline">
                <div class="timeline-item">
                    <div class="timeline-dot completed"></div>
                    <div class="timeline-date">2024-yil Yanvar</div>
                    <div style="color: #2d3748; font-weight: 500;">{{__('admin.foundation_work')}}</div>
                    <div style="color: #718096; font-size: 0.9rem;">{{__('admin.foundation_completed')}}</div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot completed"></div>
                    <div class="timeline-date">2024-yil Fevral</div>
                    <div style="color: #2d3748; font-weight: 500;">{{__('admin.construction_started')}}</div>
                    <div style="color: #718096; font-size: 0.9rem;">{{__('admin.frame_construction_progress')}}</div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2025-yil Iyun ({{__('admin.planned')}})</div>
                    <div style="color: #2d3748; font-weight: 500;">{{__('admin.interior_finishing')}}</div>
                    <div style="color: #718096; font-size: 0.9rem;">{{__('admin.interior_finishing_start')}}</div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-date">2025-yil Avgust ({{__('admin.planned')}})</div>
                    <div style="color: #2d3748; font-weight: 500;">{{__('admin.project_completion')}}</div>
                    <div style="color: #718096; font-size: 0.9rem;">{{__('admin.commissioning')}}</div>
                </div>
            </div>
        </div>

        <!-- Foto/Video Galereya -->
        <div class="info-card">
            <h2 class="info-card-title">
                <i class="fas fa-images"></i>
                {{__('admin.photo_video_gallery')}}
            </h2>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=400" alt="{{__('admin.construction_photo')}}">
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=400" alt="{{__('admin.construction_photo')}}">
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=400" alt="{{__('admin.construction_photo')}}">
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=400" alt="{{__('admin.construction_photo')}}">
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=400" alt="{{__('admin.construction_photo')}}">
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1582407947304-fd86f028f716?w=400" alt="{{__('admin.construction_photo')}}">
                </div>
            </div>
        </div>

        <!-- Qo'shimcha ma'lumot -->
        <div class="info-card">
            <h2 class="info-card-title">
                <i class="fas fa-building"></i>
                {{__('admin.additional_info')}}
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">{{__('admin.project_manager')}}</div>
                    <div class="info-value">Envast Construction {{__('admin.llc')}}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">{{__('admin.license_number')}}</div>
                    <div class="info-value">UZ-2024-5678-QR</div>
                </div>
                <div class="info-item">
                    <div class="info-label">{{__('admin.start_date')}}</div>
                    <div class="info-value">2024-yil Yanvar</div>
                </div>
                <div class="info-item">
                    <div class="info-label">{{__('admin.end_date')}}</div>
                    <div class="info-value">2025-yil Avgust</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('customJs')
<script>
    // Kalkulyator
    document.getElementById('investAmount').addEventListener('input', function() {
        const amount = parseFloat(this.value) || 0;
        const returnRate = 0.28; // 28%
        const duration = 18 / 12; // 18 oy = 1.5 yil
        
        const profit = amount * returnRate * duration;
        const total = amount + profit;
        
        document.getElementById('calculatedProfit').textContent = profit.toLocaleString('uz-UZ') + ' so\'m';
        document.getElementById('totalValue').textContent = total.toLocaleString('uz-UZ') + ' so\'m';
    });

    // Progress animation
    window.addEventListener('load', function() {
        const progressFill = document.querySelector('.progress-fill');
        const width = progressFill.style.width;
        progressFill.style.width = '0%';
        setTimeout(() => {
            progressFill.style.width = width;
        }, 100);
    });
</script>
@endpush