@push('customCss')
    <style>
        /* Step Navigation Styles */
        .step-wizard {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
            padding: 20px 0;
        }

        .step-wizard::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 3px;
            background: #e5e7eb;
            z-index: 1;
            transform: translateY(-50%);
        }

        .step-item {
            position: relative;
            z-index: 2;
            flex: 1;
            text-align: center;
        }

        .step-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #e5e7eb;
            color: #6b7280;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            margin: 0 auto;
            transition: all 0.3s ease;
            border: 3px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .step-item.active .step-circle {
            background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);
            /* yumshoq gray-blue gradient */
            color: white;
            transform: scale(1.05);
            /* biroz kichikroq, elegant effekt */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            /* yumshoq shadow */
        }


        .step-item.completed .step-circle {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            color: white;
        }

        .step-label {
            margin-top: 10px;
            font-size: 13px;
            color: #6b7280;
            font-weight: 500;
        }

        .step-item.active .step-label {
            color: #667eea;
            font-weight: 600;
        }

        .step-item.completed .step-label {
            color: #10b981;
        }

        /* Form Content Styles */
        .step-content {
            display: none;
            animation: fadeIn 0.4s ease-in-out;
        }

        .step-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .form-card-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f3f4f6;
        }

        .form-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            /* biroz yumaloqroq */
            background: linear-gradient(145deg, #f1f5f9, #e2e8f0);
            /* yumshoq gray-blue gradient */
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e293b;
            /* yumshoq qora/ko‘k qora */
            font-size: 20px;
            margin-right: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            /* yumshoq, silliq shadow */
            transition: all 0.3s ease;
            /* hover uchun smooth effekt */
            cursor: default;
        }

        .form-card-icon:hover {
            transform: scale(1.05);
            /* biroz kattalashadi hoverda */
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
            /* hoverda shadow biroz kuchayadi */
        }



        .form-card-title {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control,
        .form-select {
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .category-section {
            display: none;
        }

        .category-section.active {
            display: block;
        }

        /* Button Styles */
        .btn-step {
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-primary-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }

        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-outline-secondary {
            border: 2px solid #e5e7eb;
            color: #6b7280;
        }

        .btn-outline-secondary:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }

        /* File Upload Area */
        .file-upload-wrapper {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            background: #f9fafb;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-wrapper:hover {
            border-color: #667eea;
            background: #f3f4ff;
        }

        .file-upload-icon {
            font-size: 40px;
            color: #9ca3af;
            margin-bottom: 10px;
        }

        /* Timeline Styles */
        .timeline-container {
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
        }

        .timeline-item {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #e5e7eb;
        }

        .remove-timeline-btn {
            padding: 8px 12px;
            border-radius: 6px;
        }

        /* Progress Indicator */
        .progress-indicator {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #f3f4f6;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .step-wizard {
                flex-wrap: wrap;
            }

            .step-item {
                flex: 0 0 50%;
                margin-bottom: 20px;
            }
        }
    </style>
@endpush

<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
        </div>
    </div>

    <!-- Step Wizard -->
    <div class="step-wizard">
        <div class="step-item active" data-step="1">
            <div class="step-circle">1</div>
            <div class="step-label">Asosiy Ma'lumotlar</div>
        </div>
        <div class="step-item" data-step="2">
            <div class="step-circle">2</div>
            <div class="step-label">Moliyaviy</div>
        </div>
        <div class="step-item" data-step="3">
            <div class="step-circle">3</div>
            <div class="step-label">Kategoriya</div>
        </div>
        <div class="step-item" data-step="4">
            <div class="step-circle">4</div>
            <div class="step-label">Joylashuv</div>
        </div>
        <div class="step-item" data-step="5">
            <div class="step-circle">5</div>
            <div class="step-label">Yakunlash</div>
        </div>
    </div>

    <!-- Form -->
    <form id="projectForm" action="{{ $action }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($method === 'PUT')
            @method('PUT')
        @endif

        <!-- Step 1: Asosiy Ma'lumotlar -->
        <div class="step-content active" data-step="1">
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-icon">
                        {!! file_get_contents(public_path('/svg/info-circle.svg')) !!}
                    </div>
                    <h5 class="form-card-title">Asosiy Ma'lumotlar</h5>
                </div>


                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Loyiha nomi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name"
                            value="{{ old('name', $project->name ?? '') }}" required
                            placeholder="Masalan: Chilonzor Turar-joy Majmuasi">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Loyiha kodi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="code"
                            value="{{ old('code', $project->code ?? '') }}" required
                            placeholder="Masalan: PRJ-2024-001">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Kategoriya <span class="text-danger">*</span></label>
                        <select class="form-select" name="category" id="category" required>
                            <option value="">Tanlang...</option>
                            <option value="land"
                                {{ old('category', $project->category ?? '') == 'land' ? 'selected' : '' }}>
                                Yer (Land)
                            </option>
                            <option value="construction"
                                {{ old('category', $project->category ?? '') == 'construction' ? 'selected' : '' }}>
                                Qurilish
                            </option>
                            <option value="rent"
                                {{ old('category', $project->category ?? '') == 'rent' ? 'selected' : '' }}>
                                Ijara
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" name="status" required>
                            <option value="planned"
                                {{ old('status', $project->status ?? '') == 'planned' ? 'selected' : '' }}>
                                Rejalashtirilgan
                            </option>
                            <option value="active"
                                {{ old('status', $project->status ?? 'active') == 'active' ? 'selected' : '' }}>
                                Faol
                            </option>
                            <option value="completed"
                                {{ old('status', $project->status ?? '') == 'completed' ? 'selected' : '' }}>
                                Yakunlangan
                            </option>
                            <option value="inactive"
                                {{ old('status', $project->status ?? '') == 'inactive' ? 'selected' : '' }}>
                                Nofaol
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Xavf darajasi <span class="text-danger">*</span></label>
                        <select class="form-select" name="risk_level" required>
                            <option value="low"
                                {{ old('risk_level', $project->risk_level ?? '') == 'low' ? 'selected' : '' }}>
                                Past
                            </option>
                            <option value="medium"
                                {{ old('risk_level', $project->risk_level ?? 'medium') == 'medium' ? 'selected' : '' }}>
                                O'rta
                            </option>
                            <option value="high"
                                {{ old('risk_level', $project->risk_level ?? '') == 'high' ? 'selected' : '' }}>
                                Yuqori
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Progress bosqichi <span class="text-danger">*</span></label>
                        <select class="form-select" name="progress_stage" required>
                            <option value="planning"
                                {{ old('progress_stage', $project->progress_stage ?? '') == 'planning' ? 'selected' : '' }}>
                                Rejalashtirish
                            </option>
                            <option value="preparation"
                                {{ old('progress_stage', $project->progress_stage ?? '') == 'preparation' ? 'selected' : '' }}>
                                Tayyorgarlik
                            </option>
                            <option value="execution"
                                {{ old('progress_stage', $project->progress_stage ?? '') == 'execution' ? 'selected' : '' }}>
                                Amalga oshirish
                            </option>
                            <option value="finalizing"
                                {{ old('progress_stage', $project->progress_stage ?? '') == 'finalizing' ? 'selected' : '' }}>
                                Yakunlash
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Investitsiya davri <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="investment_period" id="investment_period"
                                required min="1"
                                value="{{ old('investment_period', $project->investment_period ?? '') }}">
                            <select class="form-select" name="investment_period_unit" id="period_unit"
                                style="max-width: 100px;">
                                <option value="months"
                                    {{ old('investment_period_unit', $project->investment_period_unit ?? 'months') == 'months' ? 'selected' : '' }}>
                                    oy
                                </option>
                                <option value="years"
                                    {{ old('investment_period_unit', $project->investment_period_unit ?? '') == 'years' ? 'selected' : '' }}>
                                    yil
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Joriy raund <span class="text-danger">*</span></label>
                        <select class="form-select" name="current_round" required>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}"
                                    {{ old('current_round', $project->current_round ?? 2) == $i ? 'selected' : '' }}>
                                    {{ $i }}-Raund
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Qisqacha tavsif <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="short_description" rows="3" required
                            placeholder="Loyiha haqida qisqacha ma'lumot bering...">{{ old('short_description', $project->short_description ?? '') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Loyiha maqsadi <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="purpose" rows="3" required
                            placeholder="Loyihaning asosiy maqsadini kiriting...">{{ old('purpose', $project->purpose ?? '') }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Asosiy rasm <span class="text-danger">*</span></label>
                        <div class="file-upload-wrapper" onclick="document.getElementById('main_image').click()">
                            <div class="file-upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <p class="mb-0"><strong>Rasm yuklash</strong></p>
                            <small class="text-muted">PNG, JPG (maks. 5MB)</small>
                        </div>
                        <input type="file" id="main_image" class="d-none" name="main_image" accept="image/*"
                            {{ $project ? '' : 'required' }}>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Qurilish rasmlari</label>
                        <div class="file-upload-wrapper" onclick="document.getElementById('progress_images').click()">
                            <div class="file-upload-icon">
                                <i class="fas fa-images"></i>
                            </div>
                            <p class="mb-0"><strong>Ko'p rasmlar</strong></p>
                            <small class="text-muted">PNG, JPG (bir nechta)</small>
                        </div>
                        <input type="file" id="progress_images" class="d-none" name="progress_images[]" multiple
                            accept="image/*">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Video fayllar</label>
                        <div class="file-upload-wrapper" onclick="document.getElementById('videos').click()">
                            <div class="file-upload-icon">
                                <i class="fas fa-video"></i>
                            </div>
                            <p class="mb-0"><strong>Video yuklash</strong></p>
                            <small class="text-muted">MP4, MOV</small>
                        </div>
                        <input type="file" id="videos" class="d-none" name="videos[]" multiple
                            accept="video/*">
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2: Moliyaviy Ma'lumotlar -->
        <div class="step-content" data-step="2">
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h5 class="form-card-title">Moliyaviy Ma'lumotlar</h5>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label">Umumiy qiymati (Sum) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="total_value" id="total_value" required
                            min="0" value="{{ old('total_value', $project->total_value ?? '') }}"
                            placeholder="100000000">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Investor ulushi (Sum) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="investor_share" id="investor_share"
                            required min="0"
                            value="{{ old('investor_share', $project->investor_share ?? '') }}"
                            placeholder="50000000">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Kompaniya ulushi (Sum)</label>
                        <input type="number" class="form-control" name="company_share" id="company_share" readonly
                            value="{{ old('company_share', $project->company_share ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Moliyalashtirilgan % <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="funded_percentage" required
                                min="0" max="100" step="0.1"
                                value="{{ old('funded_percentage', $project->funded_percentage ?? 0) }}">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Minimal investitsiya (Sum) <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="min_investment" required min="100000"
                            value="{{ old('min_investment', $project->min_investment ?? '') }}"
                            placeholder="1000000">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Raunddagi minimal ulush (Sum) <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="min_share_per_round" required
                            min="100000"
                            value="{{ old('min_share_per_round', $project->min_share_per_round ?? '') }}"
                            placeholder="5000000">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Yillik rentabellik <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="yearly_profit_percent" required
                                step="0.1" min="0"
                                value="{{ old('yearly_profit_percent', $project->yearly_profit_percent ?? '') }}"
                                placeholder="15.5">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Oxirgi dividend foizi</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="last_dividend_percent" step="0.1"
                                min="0" max="100"
                                value="{{ old('last_dividend_percent', $project->last_dividend_percent ?? '') }}"
                                placeholder="3.5">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Foyda taqsimoti turi <span class="text-danger">*</span></label>
                        <select class="form-select" name="profit_distribution_type" required>
                            <option value="monthly"
                                {{ old('profit_distribution_type', $project->profit_distribution_type ?? '') == 'monthly' ? 'selected' : '' }}>
                                Oylik
                            </option>
                            <option value="quarterly"
                                {{ old('profit_distribution_type', $project->profit_distribution_type ?? '') == 'quarterly' ? 'selected' : '' }}>
                                Choraklik
                            </option>
                            <option value="biannual"
                                {{ old('profit_distribution_type', $project->profit_distribution_type ?? '') == 'biannual' ? 'selected' : '' }}>
                                Yarim yillik
                            </option>
                            <option value="annual"
                                {{ old('profit_distribution_type', $project->profit_distribution_type ?? '') == 'annual' ? 'selected' : '' }}>
                                Yillik
                            </option>
                            <option value="end_of_project"
                                {{ old('profit_distribution_type', $project->profit_distribution_type ?? '') == 'end_of_project' ? 'selected' : '' }}>
                                Loyiha yakunida
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">To'liq sheriklar ulushi (%)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="full_partner_share" min="0"
                                max="100" step="0.1"
                                value="{{ old('full_partner_share', $project->full_partner_share ?? '') }}"
                                placeholder="60">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Komanditchilar ulushi (%)</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="limited_partner_share" min="0"
                                max="100" step="0.1"
                                value="{{ old('limited_partner_share', $project->limited_partner_share ?? '') }}"
                                placeholder="40">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3: Kategoriya Ma'lumotlari -->
        <div class="step-content" data-step="3">
            <!-- Yer uchun -->
            <div class="form-card category-section" id="land-section">
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <i class="fas fa-mountain"></i>
                    </div>
                    <h5 class="form-card-title">Yer Uchastkasi Ma'lumotlari</h5>
                </div>

                <div class="row g-4">
                    <div class="col-md-3">
                        <label class="form-label">Maydoni (kv.m)</label>
                        <input type="number" class="form-control" name="land_area_sqm"
                            value="{{ old('land_area_sqm', $project->land_area_sqm ?? '') }}" placeholder="10000">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Maydoni (ga)</label>
                        <input type="number" class="form-control" name="land_area_hectare" step="0.01"
                            value="{{ old('land_area_hectare', $project->land_area_hectare ?? '') }}"
                            placeholder="1.5">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Yer turi</label>
                        <select class="form-select" name="land_type">
                            <option value="commercial"
                                {{ old('land_type', $project->land_type ?? '') == 'commercial' ? 'selected' : '' }}>
                                Tijorat
                            </option>
                            <option value="residential"
                                {{ old('land_type', $project->land_type ?? '') == 'residential' ? 'selected' : '' }}>
                                Turar-joy
                            </option>
                            <option value="agricultural"
                                {{ old('land_type', $project->land_type ?? '') == 'agricultural' ? 'selected' : '' }}>
                                Qishloq xo'jaligi
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">1 kv.m narxi (Sum)</label>
                        <input type="number" class="form-control" name="price_per_sqm"
                            value="{{ old('price_per_sqm', $project->price_per_sqm ?? '') }}" placeholder="5000000">
                    </div>
                </div>
            </div>

            <!-- Qurilish uchun -->
            <div class="form-card category-section" id="construction-section">
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <i class="fas fa-hard-hat"></i>
                    </div>
                    <h5 class="form-card-title">Qurilish Ma'lumotlari</h5>
                </div>

                <div class="row g-4">
                    <div class="col-md-3">
                        <label class="form-label">Bino turi</label>
                        <select class="form-select" name="building_type">
                            <option value="residential"
                                {{ old('building_type', $project->building_type ?? '') == 'residential' ? 'selected' : '' }}>
                                Turar-joy
                            </option>
                            <option value="commercial"
                                {{ old('building_type', $project->building_type ?? '') == 'commercial' ? 'selected' : '' }}>
                                Tijorat
                            </option>
                            <option value="mixed"
                                {{ old('building_type', $project->building_type ?? '') == 'mixed' ? 'selected' : '' }}>
                                Aralash
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Qavatlar soni</label>
                        <input type="number" class="form-control" name="floors"
                            value="{{ old('floors', $project->floors ?? '') }}" placeholder="12">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Kvartiralar soni</label>
                        <input type="number" class="form-control" name="apartments"
                            value="{{ old('apartments', $project->apartments ?? '') }}" placeholder="144">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Qurilish bosqichi</label>
                        <select class="form-select" name="construction_stage">
                            <option value="planning"
                                {{ old('construction_stage', $project->construction_stage ?? '') == 'planning' ? 'selected' : '' }}>
                                Rejalashtirish
                            </option>
                            <option value="foundation"
                                {{ old('construction_stage', $project->construction_stage ?? '') == 'foundation' ? 'selected' : '' }}>
                                Poydevor
                            </option>
                            <option value="structure"
                                {{ old('construction_stage', $project->construction_stage ?? '') == 'structure' ? 'selected' : '' }}>
                                Karkas
                            </option>
                            <option value="finishing"
                                {{ old('construction_stage', $project->construction_stage ?? '') == 'finishing' ? 'selected' : '' }}>
                                Tugatish
                            </option>
                            <option value="completed"
                                {{ old('construction_stage', $project->construction_stage ?? '') == 'completed' ? 'selected' : '' }}>
                                Yakunlangan
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Ijara uchun -->
            <div class="form-card category-section" id="rent-section">
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h5 class="form-card-title">Ijara Ma'lumotlari</h5>
                </div>

                <div class="row g-4">
                    <div class="col-md-3">
                        <label class="form-label">Mulk turi</label>
                        <select class="form-select" name="property_type">
                            <option value="office"
                                {{ old('property_type', $project->property_type ?? '') == 'office' ? 'selected' : '' }}>
                                Ofis
                            </option>
                            <option value="retail"
                                {{ old('property_type', $project->property_type ?? '') == 'retail' ? 'selected' : '' }}>
                                Chakana savdo
                            </option>
                            <option value="warehouse"
                                {{ old('property_type', $project->property_type ?? '') == 'warehouse' ? 'selected' : '' }}>
                                Omborxona
                            </option>
                            <option value="residential"
                                {{ old('property_type', $project->property_type ?? '') == 'residential' ? 'selected' : '' }}>
                                Turar-joy
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Jami birliklar</label>
                        <input type="number" class="form-control" name="total_units"
                            value="{{ old('total_units', $project->total_units ?? '') }}" placeholder="50">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Bandlik darajasi (%)</label>
                        <input type="number" class="form-control" name="occupancy_rate" step="0.1"
                            min="0" max="100"
                            value="{{ old('occupancy_rate', $project->occupancy_rate ?? '') }}" placeholder="85.5">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Oylik ijara (Sum)</label>
                        <input type="number" class="form-control" name="monthly_rent_per_unit"
                            value="{{ old('monthly_rent_per_unit', $project->monthly_rent_per_unit ?? '') }}"
                            placeholder="10000000">
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4: Joylashuv va Timeline -->
        <div class="step-content" data-step="4">
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h5 class="form-card-title">Joylashuv</h5>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label">Viloyat/Shahar <span class="text-danger">*</span></label>
                        <select class="form-select" name="region" required id="region">
                            <option value="">Tanlang...</option>
                            @foreach (['Toshkent shahri', 'Toshkent viloyati', 'Samarqand', 'Farg\'ona', 'Andijon', 'Buxoro'] as $region)
                                <option value="{{ $region }}"
                                    {{ old('region', $project->region ?? '') == $region ? 'selected' : '' }}>
                                    {{ $region }}
                                </option>
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
                        <input type="text" class="form-control" name="address" required
                            value="{{ old('address', $project->address ?? '') }}" placeholder="Ko'cha, uy raqami">
                    </div>
                </div>
            </div>

            <div class="form-card mt-3">
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h5 class="form-card-title">Loyiha Bosqichlari (Timeline)</h5>
                </div>

                <div class="timeline-container">
                    <div id="timeline-fields">
                        <div class="timeline-item">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Bosqich nomi</label>
                                    <input type="text" class="form-control" name="timeline[0][name]"
                                        value="{{ old('timeline.0.name', '') }}"
                                        placeholder="Masalan: Poydevor ishlari">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Boshlanish</label>
                                    <input type="date" class="form-control" name="timeline[0][start_date]"
                                        value="{{ old('timeline.0.start_date', '') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Yakunlanish</label>
                                    <input type="date" class="form-control" name="timeline[0][end_date]"
                                        value="{{ old('timeline.0.end_date', '') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Progress %</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="timeline[0][progress]"
                                            min="0" max="100"
                                            value="{{ old('timeline.0.progress', '') }}">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm mt-3" id="add-timeline-item">
                        <i class="fas fa-plus me-1"></i> Bosqich qo'shish
                    </button>
                </div>
            </div>
        </div>

        <!-- Step 5: Boshqaruv va Yakunlash -->
        <div class="step-content" data-step="5">
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="form-card-title">Boshqaruv va Hujjatlar</h5>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label">Qurilish tashkiloti</label>
                        <input type="text" class="form-control" name="construction_company"
                            value="{{ old('construction_company', $project->construction_company ?? '') }}"
                            placeholder="MChJ 'Qurilish Kompaniyasi'">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Loyiha boshqaruvchisi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="project_manager" required
                            value="{{ old('project_manager', $project->project_manager ?? '') }}"
                            placeholder="F.I.Sh">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Boshqaruvchi kompaniya</label>
                        <input type="text" class="form-control" name="management_company"
                            value="{{ old('management_company', $project->management_company ?? '') }}"
                            placeholder="MChJ 'Boshqaruv'">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Loyiha hujjatlari</label>
                        <div class="file-upload-wrapper" onclick="document.getElementById('documents').click()">
                            <div class="file-upload-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <p class="mb-0"><strong>Hujjatlarni yuklash</strong></p>
                            <small class="text-muted">PDF, DOC, DOCX, XLSX</small>
                        </div>
                        <input type="file" id="documents" class="d-none" name="documents[]" multiple
                            accept=".pdf,.doc,.docx,.xlsx">
                    </div>
                </div>
            </div>

            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Eslatma:</strong> Barcha majburiy maydonlar to'ldirilganligini tekshiring. Forma yuborilgandan
                so'ng ma'lumotlar ko'rib chiqiladi.
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="progress-indicator">
            <button type="button" class="btn btn-outline-secondary btn-step" id="prevBtn" style="display: none;">
                <i class="fas fa-arrow-left me-2"></i>Orqaga
            </button>
            <button type="button" class="btn btn-primary-gradient btn-step" id="nextBtn">
                Keyingi <i class="fas fa-arrow-right ms-2"></i>
            </button>
            <button type="submit" class="btn btn-primary-gradient btn-step" id="submitBtn" style="display: none;">
                <i class="fas fa-check me-2"></i>{{ $submitText }}
            </button>
        </div>
    </form>
</div>

@push('customJs')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 1;
            const totalSteps = 5;

            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitBtn');

            const categorySelect = document.getElementById('category');
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

            // Step navigatsiyasi
            function showStep(step) {
                document.querySelectorAll('.step-content').forEach(content => {
                    content.classList.remove('active');
                });
                document.querySelectorAll('.step-item').forEach(item => {
                    item.classList.remove('active', 'completed');
                });

                document.querySelector(`.step-content[data-step="${step}"]`).classList.add('active');

                for (let i = 1; i <= totalSteps; i++) {
                    const stepItem = document.querySelector(`.step-item[data-step="${i}"]`);
                    if (i < step) {
                        stepItem.classList.add('completed');
                    } else if (i === step) {
                        stepItem.classList.add('active');
                    }
                }

                // Tugmalarni boshqarish
                prevBtn.style.display = step === 1 ? 'none' : 'inline-block';
                nextBtn.style.display = step === totalSteps ? 'none' : 'inline-block';
                submitBtn.style.display = step === totalSteps ? 'inline-block' : 'none';
            }

            nextBtn.addEventListener('click', function() {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            });

            prevBtn.addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            // Kategoriya bo'yicha maydonlarni ko'rsatish
            function toggleCategoryFields() {
                const selected = categorySelect.value;

                document.querySelectorAll('.category-section').forEach(section => {
                    section.classList.remove('active');
                });

                if (selected) {
                    const sectionId = selected + '-section';
                    const section = document.getElementById(sectionId);
                    if (section) {
                        section.classList.add('active');
                    }
                }

                setInvestmentPeriodByCategory(selected);
            }

            // Investitsiya davrini avtomatik sozlash
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
                }
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

            // Timeline qo'shish
            function addTimelineItem() {
                const newItem = document.createElement('div');
                newItem.className = 'timeline-item';
                newItem.innerHTML = `
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="timeline[${timelineCounter}][name]" placeholder="Bosqich nomi">
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
                    <button type="button" class="btn btn-danger btn-sm remove-timeline-btn w-100">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;

                timelineFields.appendChild(newItem);
                timelineCounter++;
            }

            // Event listeners
            categorySelect.addEventListener('change', toggleCategoryFields);
            totalValueInput.addEventListener('input', calculateCompanyShare);
            investorShareInput.addEventListener('input', calculateCompanyShare);
            regionSelect.addEventListener('change', populateDistricts);
            addTimelineBtn.addEventListener('click', addTimelineItem);

            // Timeline o'chirish
            timelineFields.addEventListener('click', function(e) {
                if (e.target.closest('.remove-timeline-btn')) {
                    e.target.closest('.timeline-item').remove();
                }
            });

            // Dastlabki yuklash
            showStep(1);
            toggleCategoryFields();
            calculateCompanyShare();
            populateDistricts();
        });
    </script>
@endpush
