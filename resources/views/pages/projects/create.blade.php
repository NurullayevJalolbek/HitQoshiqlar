@extends('layouts.app')

@push('customCss')
    <style>
        .category-fields {
            display: none;
        }

        .form-label {
            font-weight: 600;
        }

        .card-header-main {
            background-color: #f7f9fc;
        }

        .file-upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 0.375rem;
            padding: 2rem;
            text-align: center;
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .file-upload-area:hover {
            border-color: #007bff;
            background-color: #e7f3ff;
        }

        .timeline-container {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-top: 10px;
        }

        .timeline-item {
            margin-bottom: 15px;
        }
    </style>
@endpush
@section('breadcrumb')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <!-- Breadcrumb -->
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.projects.index') }}">
                            {{ __('admin.projects') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('admin.create') }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <div class="mb-4 mt-3">
        <div class="row">
            <div class="col-12">
                <form id="createProjectForm" action="#" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i> Asosiy Ma'lumotlar</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- 1-qator -->
                                <div class="col-md-3">
                                    <label class="form-label">Loyiha nomi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Loyiha kodi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="code" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Kategoriya <span class="text-danger">*</span></label>
                                    <select class="form-select" name="category" required id="category">
                                        <option value="">Tanlang...</option>
                                        <option value="land">Yer (Land)</option>
                                        <option value="construction">Qurilish</option>
                                        <option value="rent">Ijara</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status" required>
                                        <option value="planned">Rejalashtirilgan</option>
                                        <option value="active" selected>Faol</option>
                                        <option value="completed">Yakunlangan</option>
                                        <option value="inactive">Nofaol</option>
                                    </select>
                                </div>

                                <!-- 2-qator -->
                                <div class="col-md-3">
                                    <label class="form-label">Xavf darajasi <span class="text-danger">*</span></label>
                                    <select class="form-select" name="risk_level" required>
                                        <option value="low">Past</option>
                                        <option value="medium" selected>O'rta</option>
                                        <option value="high">Yuqori</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Progress bosqichi <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" name="progress_stage" required>
                                        <option value="planning">Rejalashtirish</option>
                                        <option value="preparation">Tayyorgarlik</option>
                                        <option value="execution">Amalga oshirish</option>
                                        <option value="finalizing">Yakunlash</option>
                                    </select>
                                </div>
                                <!-- ⚡ YANGI: Kategoriyaga bog'liq davomiylik -->
                                <div class="col-md-3">
                                    <label class="form-label">Investitsiya davri <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="investment_period" required
                                               min="1" id="investment_period">
                                        <select class="form-select" name="investment_period_unit" id="period_unit"
                                                style="max-width: 100px;">
                                            <option value="months">oy</option>
                                            <option value="years">yil</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Joriy raund <span class="text-danger">*</span></label>
                                    <select class="form-select" name="current_round" required>
                                        <option value="1">1-Raund</option>
                                        <option value="2" selected>2-Raund</option>
                                        <option value="3">3-Raund</option>
                                        <option value="4">4-Raund</option>
                                        <option value="5">5-Raund</option>
                                    </select>
                                </div>

                                <!-- 3-qator: Tasviriy kontent -->
                                <div class="col-md-4">
                                    <label class="form-label">Asosiy rasm <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="main_image" accept="image/*" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Qurilish jarayoni rasmlari</label>
                                    <input type="file" class="form-control" name="progress_images[]" multiple
                                           accept="image/*">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Video fayllar</label>
                                    <input type="file" class="form-control" name="videos[]" multiple accept="video/*">
                                </div>
                            </div>

                            <!-- Tavsif va maqsad -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="form-label">Qisqacha tavsif <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="short_description" rows="3"
                                              required></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Loyiha maqsadi <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="purpose" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Moliyaviy ma'lumotlar -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="fas fa-chart-line me-2"></i> Moliyaviy Ma'lumotlar
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Umumiy qiymati (Sum) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="total_value" required min="0"
                                           id="total_value">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Investor ulushi (Sum) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="investor_share" required min="0"
                                           id="investor_share">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Kompaniya ulushi (Sum)</label>
                                    <input type="number" class="form-control" name="company_share" readonly
                                           id="company_share">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Moliyalashtirilgan % <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="funded_percentage" required
                                               min="0" max="100" step="0.1" value="0">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>

                                <!-- ⚡ YANGI: Raunddagi minimal ulush narxi -->
                                <div class="col-md-4">
                                    <label class="form-label">Minimal investitsiya (Sum) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="min_investment" required
                                           min="100000">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Raunddagi minimal ulush (Sum) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="min_share_per_round" required
                                           min="100000">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Yillik rentabellik <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="yearly_profit_percent" required
                                               step="0.1" min="0">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Oxirgi dividend foizi</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="last_dividend_percent"
                                               step="0.1" min="0" max="100">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>

                                <!-- Foyda taqsimoti -->
                                <div class="col-md-6">
                                    <label class="form-label">Foyda taqsimoti turi <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" name="profit_distribution_type" required>
                                        <option value="monthly">Oylik</option>
                                        <option value="quarterly">Choraklik</option>
                                        <option value="biannual">Yarim yillik</option>
                                        <option value="annual">Yillik</option>
                                        <option value="end_of_project">Loyiha yakunida</option>
                                    </select>
                                </div>

                                <!-- Sheriklar ulushi -->
                                <div class="col-md-6">
                                    <label class="form-label">To'liq sheriklar ulushi (%)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="full_partner_share" min="0"
                                               max="100" step="0.1">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Komanditchilar ulushi (%)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="limited_partner_share" min="0"
                                               max="100" step="0.1">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Joylashuv ma'lumotlari -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="fas fa-map-marker-alt me-2"></i> Joylashuv</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Viloyat/Shahar <span class="text-danger">*</span></label>
                                    <select class="form-select" name="region" required id="region">
                                        <option value="">Tanlang...</option>
                                        @foreach(['Toshkent shahri','Toshkent viloyati','Samarqand','Farg\'ona','Andijon','Buxoro'] as $region)
                                            <option value="{{ $region }}">{{ $region }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tuman/Shahar <span class="text-danger">*</span></label>
                                    <select class="form-select" name="district" required id="district">
                                        <option value="">Avval viloyatni tanlang</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">To'liq manzil <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="address" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ⚡ YANGI: Timeline (Progress bar uchun) -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="fas fa-tasks me-2"></i> Loyiha Bosqichlari (Timeline)
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline-container">
                                <div id="timeline-fields">
                                    <div class="timeline-item row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Bosqich nomi</label>
                                            <input type="text" class="form-control" name="timeline[0][name]">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Boshlanish sanasi</label>
                                            <input type="date" class="form-control" name="timeline[0][start_date]">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Yakunlanish sanasi</label>
                                            <input type="date" class="form-control" name="timeline[0][end_date]">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Progress %</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="timeline[0][progress]"
                                                       min="0" max="100">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm mt-3"
                                        id="add-timeline-item">
                                    <i class="fas fa-plus me-1"></i> Yana bosqich qo'shish
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Kategoriya maxsus maydonlari -->
                    <div id="category-specific-fields">
                        <!-- Yer uchun -->
                        <div class="card mt-3 category-section" id="land-fields">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="fas fa-mountain me-2"></i> Yer Uchastkasi
                                    Ma'lumotlari</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Maydoni (kv.m)</label>
                                        <input type="number" class="form-control" name="land_area_sqm">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Maydoni (ga)</label>
                                        <input type="number" class="form-control" name="land_area_hectare" step="0.01">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Yer turi</label>
                                        <select class="form-select" name="land_type">
                                            <option value="commercial">Tijorat</option>
                                            <option value="residential">Turar-joy</option>
                                            <option value="agricultural">Qishloq xo'jaligi</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">1 kv.m narxi (Sum)</label>
                                        <input type="number" class="form-control" name="price_per_sqm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Qurilish uchun -->
                        <div class="card mt-3 category-section" id="construction-fields">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="fas fa-hard-hat me-2"></i> Qurilish Ma'lumotlari
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Bino turi</label>
                                        <select class="form-select" name="building_type">
                                            <option value="residential">Turar-joy</option>
                                            <option value="commercial">Tijorat</option>
                                            <option value="mixed">Aralash</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Qavatlar soni</label>
                                        <input type="number" class="form-control" name="floors">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Kvartiralar soni</label>
                                        <input type="number" class="form-control" name="apartments">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Qurilish bosqichi</label>
                                        <select class="form-select" name="construction_stage">
                                            <option value="planning">Rejalashtirish</option>
                                            <option value="foundation">Poydevor</option>
                                            <option value="structure">Karkas</option>
                                            <option value="finishing">Tugatish</option>
                                            <option value="completed">Yakunlangan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ijara uchun -->
                        <div class="card mt-3 category-section" id="rent-fields">
                            <div class="card-header">
                                <h5 class="card-title mb-0"><i class="fas fa-building me-2"></i> Ijara Ma'lumotlari</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Mulk turi</label>
                                        <select class="form-select" name="property_type">
                                            <option value="office">Ofis</option>
                                            <option value="retail">Chakana savdo</option>
                                            <option value="warehouse">Omborxona</option>
                                            <option value="residential">Turar-joy</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Jami birliklar</label>
                                        <input type="number" class="form-control" name="total_units">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Bandlik darajasi (%)</label>
                                        <input type="number" class="form-control" name="occupancy_rate" step="0.1"
                                               min="0" max="100">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Oylik ijara (Sum)</label>
                                        <input type="number" class="form-control" name="monthly_rent_per_unit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boshqa ma'lumotlar -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="fas fa-users me-2"></i> Boshqaruv va Hujjatlar</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Qurilish tashkiloti</label>
                                    <input type="text" class="form-control" name="construction_company">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Loyiha boshqaruvchisi <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="project_manager" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Boshqaruvchi kompaniya</label>
                                    <input type="text" class="form-control" name="management_company">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Loyiha hujjatlari</label>
                                    <input type="file" class="form-control" name="documents[]" multiple
                                           accept=".pdf,.doc,.docx,.xlsx">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit buttons -->
                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-times me-2"></i> Bekor qilish
                        </a>

                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-save me-2"></i>Saqlash
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('customJs')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('category');
            const categorySections = document.querySelectorAll('.category-section');
            const totalValueInput = document.getElementById('total_value');
            const investorShareInput = document.getElementById('investor_share');
            const companyShareInput = document.getElementById('company_share');
            const regionSelect = document.getElementById('region');
            const districtSelect = document.getElementById('district');
            const investmentPeriod = document.getElementById('investment_period');
            const periodUnit = document.getElementById('period_unit');
            const timelineFields = document.getElementById('timeline-fields');
            const addTimelineBtn = document.getElementById('add-timeline-item');

            let timelineCounter = 1;

            // Tumanlar ma'lumotlari
            const districts = {
                "Toshkent shahri": ["Yunusobod", "Chilonzor", "Mirzo Ulug'bek", "Yakkasaroy", "Mirobod"],
                "Toshkent viloyati": ["Chirchiq", "Qibray", "Zangiota", "Parkent", "Olmaliq"],
                "Samarqand": ["Samarqand shahri", "Kattaqo'rg'on", "Urgut", "Pastdarg'om"],
                "Farg'ona": ["Farg'ona shahri", "Marg'ilon", "Quva", "Beshariq"],
                "Andijon": ["Andijon shahri", "Xo'jaobod", "Baliqchi", "Shahrixon"],
                "Buxoro": ["Buxoro shahri", "Qorako'l", "Romitan", "Shofirkon"]
            };

            // Kategoriya maydonlarini boshqarish
            function toggleCategoryFields() {
                const selectedCategory = categorySelect.value;

                // Barcha kategoriya maydonlarini yashirish
                categorySections.forEach(section => {
                    section.style.display = 'none';
                });

                // Tanlangan kategoriyani ko'rsatish
                if (selectedCategory) {
                    const selectedSection = document.getElementById(`${selectedCategory}-fields`);
                    if (selectedSection) {
                        selectedSection.style.display = 'block';
                    }
                }

                // Investitsiya davrini kategoriyaga qarab sozlash
                setInvestmentPeriodByCategory(selectedCategory);
            }

            // Kompaniya ulushini hisoblash
            function calculateCompanyShare() {
                const total = parseFloat(totalValueInput.value) || 0;
                const investor = parseFloat(investorShareInput.value) || 0;

                if (total >= 0 && investor >= 0 && investor <= total) {
                    companyShareInput.value = total - investor;
                } else {
                    companyShareInput.value = 0;
                }
            }

            // Tumanlarni to'ldirish
            function populateDistricts() {
                const selectedRegion = regionSelect.value;
                districtSelect.innerHTML = '<option value="">Tuman/shaharni tanlang</option>';

                if (districts[selectedRegion]) {
                    districts[selectedRegion].forEach(district => {
                        const option = document.createElement('option');
                        option.value = district;
                        option.textContent = district;
                        districtSelect.appendChild(option);
                    });
                }
            }

            // Kategoriyaga qarab investitsiya davrini sozlash
            function setInvestmentPeriodByCategory(category) {
                switch (category) {
                    case 'land':
                        investmentPeriod.value = 24;
                        periodUnit.value = 'months';
                        break;
                    case 'construction':
                        investmentPeriod.value = 10;
                        periodUnit.value = 'months';
                        break;
                    case 'rent':
                        investmentPeriod.value = 3;
                        periodUnit.value = 'months';
                        break;
                    default:
                        investmentPeriod.value = '';
                }
            }

            // Timeline item qo'shish
            function addTimelineItem() {
                const newItem = document.createElement('div');
                newItem.className = 'timeline-item row g-3 mt-2';
                newItem.innerHTML = `
                <div class="col-md-3">
                    <input type="text" class="form-control" name="timeline[${timelineCounter}][name]">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="timeline[${timelineCounter}][start_date]">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" name="timeline[${timelineCounter}][end_date]">
                </div>
                <div class="col-md-2">
                    <div class="input-group">
                        <input type="number" class="form-control" name="timeline[${timelineCounter}][progress]" min="0" max="100">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-timeline">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;

                timelineFields.appendChild(newItem);
                timelineCounter++;
            }

            // Event listenerlar
            categorySelect.addEventListener('change', toggleCategoryFields);
            totalValueInput.addEventListener('input', calculateCompanyShare);
            investorShareInput.addEventListener('input', calculateCompanyShare);
            regionSelect.addEventListener('change', populateDistricts);
            addTimelineBtn.addEventListener('click', addTimelineItem);

            // Timeline elementini o'chirish
            timelineFields.addEventListener('click', function (e) {
                if (e.target.closest('.remove-timeline')) {
                    e.target.closest('.timeline-item').remove();
                }
            });

            // Dastlabki yuklanishda funksiyalarni chaqirish
            toggleCategoryFields();
            calculateCompanyShare();
            populateDistricts();
        });
    </script>
@endpush
