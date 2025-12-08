@extends('layouts.app')
@push('customCss')
    <style>
        .project-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 1rem;
            padding: 2rem;
            color: white;
            margin-bottom: 2rem;
        }

        .project-image-gallery {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            height: 400px;
        }

        .project-image-gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .info-card {
            background: #ffffff;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .info-card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f7fafc;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #718096;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .info-value {
            color: #2d3748;
            font-weight: 600;
            text-align: right;
        }

        .status-badge {
            padding: 0.4rem 1rem;
            border-radius: 2rem;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-active {
            background: #c6f6d5;
            color: #22543d;
        }

        .status-planned {
            background: #bee3f8;
            color: #2c5282;
        }

        .status-completed {
            background: #e9d8fd;
            color: #44337a;
        }

        .status-inactive {
            background: #fed7d7;
            color: #742a2a;
        }

        .progress-container {
            background: #edf2f7;
            border-radius: 1rem;
            height: 2rem;
            overflow: hidden;
            position: relative;
        }

        .progress-bar-custom {
            height: 100%;
            background: linear-gradient(90deg, #48bb78 0%, #38a169 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            transition: width 0.3s ease;
        }

        .timeline-container {
            position: relative;
            padding-left: 2rem;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 2rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -2rem;
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            z-index: 2;
        }

        .timeline-dot.completed {
            background: #48bb78;
            color: white;
        }

        .timeline-dot.in-progress {
            background: #4299e1;
            color: white;
        }

        .timeline-dot.planned {
            background: #cbd5e0;
            color: #4a5568;
        }

        .timeline-line {
            position: absolute;
            left: -1rem;
            top: 2rem;
            bottom: 0;
            width: 2px;
            background: #e2e8f0;
        }

        .timeline-item:last-child .timeline-line {
            display: none;
        }

        .timeline-content {
            background: #f7fafc;
            padding: 1rem;
            border-radius: 0.5rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 0.75rem;
            text-align: center;
        }

        .stat-card.green {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        }

        .stat-card.blue {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
        }

        .stat-card.orange {
            background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .risk-badge {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            display: inline-block;
        }

        .risk-low {
            background: #c6f6d5;
            color: #22543d;
        }

        .risk-medium {
            background: #feebc8;
            color: #7c2d12;
        }

        .risk-high {
            background: #fed7d7;
            color: #742a2a;
        }

        .image-slider {
            position: relative;
            overflow: hidden;
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
        }

        .slider-nav.prev {
            left: 1rem;
        }

        .slider-nav.next {
            right: 1rem;
        }

        .infrastructure-list {
            list-style: none;
            padding: 0;
        }

        .infrastructure-list li {
            padding: 0.75rem;
            background: #f7fafc;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .infrastructure-list li:before {
            content: "✓";
            background: #48bb78;
            color: white;
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            flex-shrink: 0;
        }
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
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
            <a href="#" class="btn btn-sm btn-primary d-flex align-items-center gap-2">
                <i class="bi bi-pencil"></i> Tahrirlash
            </a>
        </div>
    </div>
@endsection

@section('content')
    <!-- Project Header -->
    <div class="project-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-2" id="projectName">Yuklanmoqda...</h2>
                <p class="mb-2 opacity-90" id="projectCode">-</p>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="status-badge" id="projectStatus">-</span>
                    <span class="status-badge" style="background: rgba(255,255,255,0.2);" id="projectCategory">-</span>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <div class="stat-value" id="fundingPercent">0%</div>
                <div class="stat-label">Moliyalashtirilganlik</div>
            </div>
        </div>
    </div>

    <!-- Main Image Gallery -->
    <div class="card card-body shadow border-0 mb-4">
        <div class="project-image-gallery image-slider" id="imageGallery">
            <button class="slider-nav prev" onclick="changeSlide(-1)"><i class="bi bi-chevron-left"></i></button>
            <img src="" alt="Project Image" id="mainImage">
            <button class="slider-nav next" onclick="changeSlide(1)"><i class="bi bi-chevron-right"></i></button>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Karakteristik Ma'lumotlar -->
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-info-circle text-primary"></i>
                    Charakteristik ma'lumotlar
                </h5>
                <div class="info-row">
                    <span class="info-label">Qisqacha tavsif:</span>
                    <span class="info-value" id="shortDesc">-</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Maqsad:</span>
                    <span class="info-value" id="purpose">-</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Joylashuv:</span>
                    <span class="info-value" id="location">-</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Yer maydoni:</span>
                    <span class="info-value" id="landArea">-</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Xatar darajasi:</span>
                    <span class="info-value">
                        <span class="risk-badge" id="riskLevel">-</span>
                    </span>
                </div>
            </div>

            <!-- Moliyaviy Ko'rsatkichlar -->
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-cash-stack text-success"></i>
                    Moliyaviy ko'rsatkichlar
                </h5>
                <div class="row mb-3">
                    <div class="col-md-6 mb-3">
                        <div class="stat-card green">
                            <div class="stat-value" id="totalValue">0</div>
                            <div class="stat-label">Umumiy qiymati</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="stat-card blue">
                            <div class="stat-value" id="collectedAmount">0</div>
                            <div class="stat-label">Yig'ilgan</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="stat-card orange">
                            <div class="stat-value" id="profitability">0%</div>
                            <div class="stat-label">Rentabellik</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="stat-card">
                            <div class="stat-value" id="duration">0</div>
                            <div class="stat-label">Investitsiya davri</div>
                        </div>
                    </div>
                </div>
                <div class="info-row">
                    <span class="info-label">Minimal investitsiya:</span>
                    <span class="info-value" id="minInvestment">-</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Yillik foyda:</span>
                    <span class="info-value" id="yearlyProfit">-</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Foyda turi:</span>
                    <span class="info-value" id="profitType">-</span>
                </div>
            </div>

            <!-- Loyiha Bosqichlari -->
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-diagram-3 text-info"></i>
                    Loyiha bosqichlari
                </h5>
                <div class="mb-3">
                    <div class="progress-container">
                        <div class="progress-bar-custom" id="progressBar" style="width: 0%">0%</div>
                    </div>
                </div>
                <div class="timeline-container" id="timeline">
                    <!-- Timeline items will be inserted here -->
                </div>
            </div>

            <!-- Infratuzilma -->
            <div class="info-card" id="infrastructureCard" style="display: none;">
                <h5 class="info-card-title">
                    <i class="bi bi-building text-warning"></i>
                    Infratuzilma
                </h5>
                <ul class="infrastructure-list" id="infrastructureList">
                    <!-- Infrastructure items will be inserted here -->
                </ul>
            </div>

            <!-- Loyiha Boshqaruvchisi -->
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-person-badge text-primary"></i>
                    Loyiha boshqaruvchisi
                </h5>
                <div class="info-row">
                    <span class="info-label">F.I.O.:</span>
                    <span class="info-value" id="managerName">-</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Telefon:</span>
                    <span class="info-value" id="managerPhone">-</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tajriba:</span>
                    <span class="info-value" id="managerExperience">-</span>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-4">
            <!-- Raund Ma'lumotlari -->
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-arrow-repeat text-primary"></i>
                    Raund ma'lumotlari
                </h5>
                <div class="info-row">
                    <span class="info-label">Joriy raund:</span>
                    <span class="info-value" id="currentRound">-</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Raund holati:</span>
                    <span class="info-value">
                        <span class="status-badge" id="roundStatus">-</span>
                    </span>
                </div>
            </div>

            <!-- Sana Ma'lumotlari -->
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-calendar-event text-success"></i>
                    Sana ma'lumotlari
                </h5>
                <div class="info-row">
                    <span class="info-label">Boshlanish sanasi:</span>
                    <span class="info-value" id="startDate">-</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tugash sanasi:</span>
                    <span class="info-value" id="endDate">-</span>
                </div>
            </div>

            <!-- Yer Ma'lumotlari -->
            <div class="info-card" id="landInfoCard" style="display: none;">
                <h5 class="info-card-title">
                    <i class="bi bi-geo-alt text-danger"></i>
                    Yer ma'lumotlari
                </h5>
                <div class="info-row">
                    <span class="info-label">Yer turi:</span>
                    <span class="info-value" id="landType">-</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sotib olish narxi:</span>
                    <span class="info-value" id="buyPrice">-</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sotish narxi:</span>
                    <span class="info-value" id="sellPrice">-</span>
                </div>
            </div>

            <!-- Ulushlar Taqsimoti -->
            <div class="info-card">
                <h5 class="info-card-title">
                    <i class="bi bi-pie-chart text-info"></i>
                    Ulushlar taqsimoti
                </h5>
                <div class="info-row">
                    <span class="info-label">Kompaniya ulushi:</span>
                    <span class="info-value" id="companyShare">-</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Investorlar ulushi:</span>
                    <span class="info-value" id="investorShare">-</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customJs')
    <script>
        let projectData = null;
        let currentImageIndex = 0;
        let images = [];

        // Load project data
        async function loadProjectData() {
            try {
                const projectId = 1; // O'zgartirishingiz mumkin
                const response = await fetch(`http://localhost:8000/api/projects/${projectId}`);
                const data = await response.json();

                if (data.result) {
                    projectData = data.result;
                    displayProjectData();
                }
            } catch (error) {
                console.error('Xatolik:', error);
            }
        }

        function displayProjectData() {
            const p = projectData;

            // Header
            document.getElementById('projectName').textContent = p.name;
            document.getElementById('projectCode').textContent = p.code;
            document.getElementById('fundingPercent').textContent = p.funding_status_percent + '%';

            // Status
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
            const status = statusMap[p.status] || statusMap['inactive'];
            const statusEl = document.getElementById('projectStatus');
            statusEl.textContent = status.text;
            statusEl.className = `status-badge ${status.class}`;

            // Category
            const categoryMap = {
                'land': 'Yer',
                'construction': 'Qurilish',
                'rental': 'Ijara'
            };
            document.getElementById('projectCategory').textContent = categoryMap[p.category] || p.category;

            // Images
            images = p.main_images || [];
            if (images.length > 0) {
                document.getElementById('mainImage').src = images[0];
            }

            // Charakteristik ma'lumotlar
            document.getElementById('shortDesc').textContent = p.short_description;
            document.getElementById('purpose').textContent = p.purpose;
            document.getElementById('location').textContent = `${p.region}, ${p.district}, ${p.address}`;
            document.getElementById('landArea').textContent = `${p.land_area_hectare} ga (${p.land_area_sqm} m²)`;

            // Risk level
            const riskMap = {
                'low': {
                    text: 'Past',
                    class: 'risk-low'
                },
                'medium': {
                    text: "O'rta",
                    class: 'risk-medium'
                },
                'high': {
                    text: 'Yuqori',
                    class: 'risk-high'
                }
            };
            const risk = riskMap[p.risk_level] || riskMap['medium'];
            const riskEl = document.getElementById('riskLevel');
            riskEl.textContent = risk.text;
            riskEl.className = `risk-badge ${risk.class}`;

            // Moliyaviy ko'rsatkichlar
            document.getElementById('totalValue').textContent = formatMoney(p.total_value);
            document.getElementById('collectedAmount').textContent = formatMoney(p.collected);
            document.getElementById('profitability').textContent = p.profitability_percent + '%';
            document.getElementById('duration').textContent = p.investment_duration;
            document.getElementById('minInvestment').textContent = formatMoney(p.min_investment);
            document.getElementById('yearlyProfit').textContent = p.yearly_profit_percent + '%';

            const profitTypeMap = {
                'end_of_project': 'Loyiha oxirida',
                'monthly': 'Oylik',
                'quarterly': 'Choraklik'
            };
            document.getElementById('profitType').textContent = profitTypeMap[p.profit_type] || p.profit_type;

            // Progress
            document.getElementById('progressBar').style.width = p.progress.percent + '%';
            document.getElementById('progressBar').textContent = p.progress.percent + '%';

            // Timeline
            displayTimeline(p.progress.timeline);

            // Infrastructure
            if (p.infrastructure && p.infrastructure.length > 0) {
                document.getElementById('infrastructureCard').style.display = 'block';
                const list = document.getElementById('infrastructureList');
                list.innerHTML = '';
                p.infrastructure.forEach(item => {
                    const li = document.createElement('li');
                    li.textContent = item;
                    list.appendChild(li);
                });
            }

            // Manager
            document.getElementById('managerName').textContent = p.project_manager.name;
            document.getElementById('managerPhone').textContent = p.project_manager.phone;
            document.getElementById('managerExperience').textContent = p.project_manager.experience_years + ' yil';

            // Round
            document.getElementById('currentRound').textContent = p.round;
            const roundStatusMap = {
                'in_progress': {
                    text: 'Jarayonda',
                    class: 'status-active'
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
            const roundStatus = roundStatusMap[p.rounds_status[0].status] || roundStatusMap['inactive'];
            const roundEl = document.getElementById('roundStatus');
            roundEl.textContent = roundStatus.text;
            roundEl.className = `status-badge ${roundStatus.class}`;

            // Dates
            document.getElementById('startDate').textContent = formatDate(p.start_date);
            document.getElementById('endDate').textContent = formatDate(p.end_date);

            // Land info
            if (p.category === 'land') {
                document.getElementById('landInfoCard').style.display = 'block';
                const landTypeMap = {
                    'commercial': 'Tijorat',
                    'residential': 'Turar joy',
                    'agricultural': 'Qishloq xo\'jaligi'
                };
                document.getElementById('landType').textContent = landTypeMap[p.land_type] || p.land_type;
                document.getElementById('buyPrice').textContent = formatMoney(p.buy_price_sqm) + '/m²';
                document.getElementById('sellPrice').textContent = formatMoney(p.sell_price_sqm) + '/m²';
            }

            // Shares
            document.getElementById('companyShare').textContent = formatMoney(p.company_share);
            document.getElementById('investorShare').textContent = formatMoney(p.investor_share);
        }

        function displayTimeline(timeline) {
            const container = document.getElementById('timeline');
            container.innerHTML = '';

            const statusMap = {
                'completed': {
                    icon: '✓',
                    class: 'completed',
                    text: 'Bajarilgan'
                },
                'in_progress': {
                    icon: '◐',
                    class: 'in-progress',
                    text: 'Jarayonda'
                },
                'planned': {
                    icon: '○',
                    class: 'planned',
                    text: 'Rejalashtirilgan'
                }
            };

            timeline.forEach((item, index) => {
                const status = statusMap[item.status] || statusMap['planned'];
                const itemEl = document.createElement('div');
                itemEl.className = 'timeline-item';
                itemEl.innerHTML = `
            <div class="timeline-dot ${status.class}">${status.icon}</div>
            ${index < timeline.length - 1 ? '<div class="timeline-line"></div>' : ''}
            <div class="timeline-content">
                <strong>${item.stage}</strong>
                <div class="text-muted mt-1">${status.text}</div>
            </div>
        `;
                container.appendChild(itemEl);
            });
        }

        function changeSlide(direction) {
            if (images.length === 0) return;

            currentImageIndex += direction;
            if (currentImageIndex < 0) currentImageIndex = images.length - 1;
            if (currentImageIndex >= images.length) currentImageIndex = 0;

            document.getElementById('mainImage').src = images[currentImageIndex];
        }

        function formatMoney(amount) {
            return new Intl.NumberFormat('uz-UZ', {
                style: 'currency',
                currency: 'UZS',
                minimumFractionDigits: 0
            }).format(amount).replace('UZS', 'so\'m');
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('uz-UZ', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        // Load data on page load
        document.addEventListener('DOMContentLoaded', loadProjectData);
    </script>
@endpush
