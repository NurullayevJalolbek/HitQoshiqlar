@extends('layouts.app')

@push('customCss')
<style>
    .settings-container {
        margin: 0 auto;
    }

    .settings-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .settings-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 32px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e5e7eb;
    }

    .settings-icon {
        font-size: 28px;
        color: #1F2937;
    }

    .settings-header h1 {
        font-size: 24px;
        font-weight: 600;
        color: #1F2937;
        margin: 0;
    }

    .form-section {
        margin-bottom: 32px;
    }

    .form-section:last-child {
        margin-bottom: 0;
    }

    .section-label {
        font-size: 14px;
        font-weight: 600;
        color: #1F2937;
        margin-bottom: 12px;
        display: block;
    }

    .form-select {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        color: #1F2937;
        background-color: #ffffff;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .form-select:hover {
        border-color: #9ca3af;
    }

    .form-select:focus {
        outline: none;
        border-color: #1F2937;
        box-shadow: 0 0 0 3px rgba(31, 41, 55, 0.1);
    }

    .form-hint {
        font-size: 13px;
        color: #6b7280;
        margin-top: 8px;
        display: block;
    }

    .format-options {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 12px;
    }

    .format-option {
        display: flex;
        align-items: center;
        padding: 14px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .format-option:hover {
        border-color: #9ca3af;
        background: #f9fafb;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .format-option.selected {
        border-color: #1F2937;
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        box-shadow: 0 4px 16px rgba(31, 41, 55, 0.1);
    }

    /* .format-option::before {
                            content: '';
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 4px;
                            height: 100%;
                            background: #1F2937;
                            opacity: 0;
                            transition: opacity 0.3s ease;
                        } */

    .format-option.selected::before {
        opacity: 1;
    }

    .radio-indicator {
        width: 20px;
        height: 20px;
        border: 2px solid #d1d5db;
        border-radius: 50%;
        margin-right: 16px;
        position: relative;
        flex-shrink: 0;
        transition: all 0.3s ease;
        background: white;
    }

    .format-option.selected .radio-indicator {
        border-color: #1F2937;
        background: #1F2937;
        box-shadow: 0 0 0 4px rgba(31, 41, 55, 0.1);
    }

    .radio-indicator::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        width: 8px;
        height: 8px;
        background: white;
        border-radius: 50%;
        transition: transform 0.3s ease;
    }

    .format-option.selected .radio-indicator::after {
        transform: translate(-50%, -50%) scale(1);
    }

    .format-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .format-example {
        font-size: 14px;
        color: #374151;
        font-weight: 500;
        letter-spacing: 0.2px;
    }

    .format-option.selected .format-example {
        color: #1F2937;
        font-weight: 600;
    }

    .format-code {
        font-family: 'SF Mono', Monaco, 'Courier New', monospace;
        font-size: 13px;
        color: #6b7280;
        background: #f9fafb;
        padding: 6px 10px;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .format-option.selected .format-code {
        color: #1F2937;
        background: #f3f4f6;
        border-color: #d1d5db;
        font-weight: 500;
    }

    .preview-box {
        margin-top: 16px;
        padding: 16px;
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
    }

    .preview-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: #1F2937;
    }

    .preview-label {
        font-size: 11px;
        color: #6b7280;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .preview-label::before {
        content: '👁️';
        font-size: 10px;
    }

    .preview-value {
        font-size: 15px;
        color: #1F2937;
        font-weight: 600;
        font-family: 'SF Mono', Monaco, 'Courier New', monospace;
        padding: 8px 12px;
        background: white;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
    }

    .dual-select {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 32px;
    }

    .row-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 32px;
    }

    @media (max-width: 768px) {

        .dual-select,
        .row-layout {
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .settings-card {
            padding: 16px;
        }

        .format-option {
            padding: 12px 14px;
        }
    }

    .select-wrapper {
        position: relative;
    }

    .custom-input-wrapper {
        margin-top: 16px;
        display: none;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .custom-input-wrapper.active {
        display: block;
    }

    .custom-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        font-family: 'SF Mono', Monaco, 'Courier New', monospace;
        color: #1F2937;
        background: #f9fafb;
        transition: all 0.3s ease;
    }

    .custom-input:focus {
        outline: none;
        border-color: #1F2937;
        background: white;
        box-shadow: 0 0 0 3px rgba(31, 41, 55, 0.1);
    }

    .custom-input::placeholder {
        color: #9ca3af;
        font-style: italic;
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
                    Sana, vaqt va lokal sozlamalar
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
<div class="settings-container mt-3">
    <div class="settings-card">
        <!-- <div class="settings-header">
                                <span class="settings-icon">🌍</span>
                                <h1>Sana, vaqt va lokal sozlamalar</h1>
                            </div> -->

        {{-- Davlat va vaqt mintaqasi --}}

        @php
        $countries = [
        'uz' => "🇺🇿 O'zbekiston",
        'ru' => '🇷🇺 Rossiya',
        'us' => '🇺🇸 AQSh',
        'ae' => '🇦🇪 BAA',
        ];

        @endphp


        <div class="dual-select row g-3">
            {{-- Country select --}}
            <x-select-with-search name="countrySelect" label="Davlat" :datas="[
                    'uz' => '🇺🇿 O\'zbekiston',
                    'ru' => '🇷🇺 Rossiya',
                    'us' => '🇺🇸 AQSh',
                    'ae' => '🇦🇪 BAA',
                ]" colMd="12" :selectSearch="false"
                icon="fa-earth-africa" placeholder="Davlatni tanlang" />

            {{-- Timezone select --}}
            <x-select-with-search name="timezoneSelect" label="Vaqt mintaqasi (Timezone)" :datas="['' => 'Avtomatik aniqlanadi']"
                icon="fa-clock" colMd="12" :selectSearch="false" placeholder="Timezone" />
        </div>


        {{-- 1-qator: Sana formati va vaqt formati --}}
        <div class="row-layout">
            {{-- Sana formati --}}
            <div class="form-section">
                <label class="section-label">Sana formati</label>
                <div class="format-options">
                    <div class="format-option selected" data-value="F j, Y">
                        <div class="radio-indicator"></div>
                        <div class="format-content">
                            <span class="format-example">November 23, 2018</span>
                            <span class="format-code">F j, Y</span>
                        </div>
                    </div>

                    <div class="format-option" data-value="Y-m-d">
                        <div class="radio-indicator"></div>
                        <div class="format-content">
                            <span class="format-example">2018-11-23</span>
                            <span class="format-code">Y-m-d</span>
                        </div>
                    </div>

                    <div class="format-option" data-value="d/m/Y">
                        <div class="radio-indicator"></div>
                        <div class="format-content">
                            <span class="format-example">23/11/2018</span>
                            <span class="format-code">d/m/Y</span>
                        </div>
                    </div>

                    <div class="format-option" data-value="m/d/Y">
                        <div class="radio-indicator"></div>
                        <div class="format-content">
                            <span class="format-example">11/23/2018</span>
                            <span class="format-code">m/d/Y</span>
                        </div>
                    </div>
                    <div class="format-option" data-value="d.m.Y">
                        <div class="radio-indicator"></div>
                        <div class="format-content">
                            <span class="format-example">23.11.2018</span>
                            <span class="format-code">d.m.Y</span>
                        </div>
                    </div>


                    <div class="format-option" data-value="custom">
                        <div class="radio-indicator"></div>
                        <div class="format-content">
                            <span class="format-example">Boshqa format</span>
                            <span class="format-code">Custom</span>
                        </div>
                    </div>


                </div>

                <div class="custom-input-wrapper" id="customDateInput">
                    <input type="text" class="custom-input" placeholder="Masalan: d.m.Y yoki Y-m-d"
                        id="customDateFormat">
                </div>

                <div class="preview-box">
                    <div>Namuna</div>
                    <div class="preview-value" id="datePreview">November 23, 2018</div>
                </div>
            </div>

            {{-- Vaqt formati --}}
            <div class="form-section">
                <label class="section-label">Vaqt formati</label>
                <div class="format-options">
                    <div class="format-option selected" data-value="g:i a">
                        <div class="radio-indicator"></div>
                        <div class="format-content">
                            <span class="format-example">2:34 pm</span>
                            <span class="format-code">g:i a</span>
                        </div>
                    </div>

                    <div class="format-option" data-value="g:i A">
                        <div class="radio-indicator"></div>
                        <div class="format-content">
                            <span class="format-example">2:34 PM</span>
                            <span class="format-code">g:i A</span>
                        </div>
                    </div>

                    <div class="format-option" data-value="H:i">
                        <div class="radio-indicator"></div>
                        <div class="format-content">
                            <span class="format-example">14:34</span>
                            <span class="format-code">H:i</span>
                        </div>
                    </div>

                    <div class="format-option" data-value="H:i:s">
                        <div class="radio-indicator"></div>
                        <div class="format-content">
                            <span class="format-example">14:34:25</span>
                            <span class="format-code">H:i:s</span>
                        </div>
                    </div>

                    <div class="format-option" data-value="custom">
                        <div class="radio-indicator"></div>
                        <div class="format-content">
                            <span class="format-example">Boshqa format</span>
                            <span class="format-code">Custom</span>
                        </div>
                    </div>
                </div>

                <div class="custom-input-wrapper" id="customTimeInput">
                    <input type="text" class="custom-input" placeholder="Masalan: H:i:s yoki g:i A"
                        id="customTimeFormat">
                </div>

                <div class="preview-box">
                    <div>Namuna</div>
                    <div class="preview-value" id="timePreview">2:34 pm</div>
                </div>
            </div>
        </div>

        {{-- 2-qator: Til va valyuta --}}
        <div class="row-layout row g-3">
            {{-- Til select --}}
            <x-select-with-search name="languageSelect" label="Tizimning asosiy tili" :datas="[
                    'uz' => '🇺🇿 O\'zbek tili (uz)',
                    'en' => '🇬🇧 Ingliz tili (en)',
                    'ru' => '🇷🇺 Rus tili (ru)',
                    'ar' => '🇸🇦 Arab tili (ar)',
                ]"
                icon="fa-earth-africa"
                colMd="12" :selectSearch="false" placeholder="Tilni tanlang" :selected="'uz'" />

            {{-- Valyuta select --}}
            <x-select-with-search name="currencySelect" label="Valyuta" :datas="[
                    'uzs' => '🇺🇿 UZS – O\'zbekiston so\'mi',
                    'usd' => '🇺🇸 USD – AQSh dollari',
                    'eur' => '🇪🇺 EUR – Yevro',
                    'rub' => '🇷🇺 RUB – Rossiya rubli',
                    'aed' => '🇦🇪 AED – BAA dirhami',
                ]" colMd="12"
                icon="fa-money-bills"
                :selectSearch="false" placeholder="Valyutani tanlang" :selected="'uzs'" />
        </div>


        <div class="d-flex justify-content-end mt-3 gap-2">
            <!-- <a href="{{ route('admin.general-settings.index') }}" class="btn btn-secondary">
                <i class="fas fa-times me-1"></i> Bekor qilish
            </a> -->

            <button class="btn btn-primary" type="submit">
                <i class="fas fa-save me-1"></i>
                @isset($user)
                Yangilash
                @else
                Saqlash
                @endisset
            </button>
        </div>
    </div>
</div>
@endsection

@push('customJs')
<script>
    // Timezone data
    document.addEventListener('DOMContentLoaded', function() {
        const timezones = {
            uz: ['Asia/Tashkent (UTC+5)'],
            ru: ['Europe/Moscow (UTC+3)', 'Asia/Yekaterinburg (UTC+5)', 'Asia/Novosibirsk (UTC+7)',
                'Asia/Vladivostok (UTC+10)'
            ],
            us: ['America/New_York (UTC-5)', 'America/Chicago (UTC-6)', 'America/Denver (UTC-7)',
                'America/Los_Angeles (UTC-8)'
            ],
            ae: ['Asia/Dubai (UTC+4)']
        };

        const countrySelect = $('#countrySelect');
        const timezoneSelect = $('#timezoneSelect');

        function updateTimezones() {
            const country = countrySelect.val();
            timezoneSelect.empty(); // selectni tozalaymiz

            if (timezones[country]) {
                timezones[country].forEach(tz => {
                    timezoneSelect.append(new Option(tz, tz));
                });
            }

            // Select2ni yangilash
            timezoneSelect.trigger('change');
        }

        countrySelect.on('change', updateTimezones);

        // Dastlabki holatni o‘rnatish
        updateTimezones();
    });

    // Handle format option selection
    document.querySelectorAll('.format-option').forEach(option => {
        option.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            const isDateOption = this.closest('.form-section').querySelector('.section-label')
                .textContent.includes('Sana');
            const isTimeOption = this.closest('.form-section').querySelector('.section-label')
                .textContent.includes('Vaqt');

            if (isDateOption) {
                // Remove selected class from all date options
                document.querySelectorAll('.form-section:first-child .format-option').forEach(opt => {
                    opt.classList.remove('selected');
                });

                // Add selected class to clicked option
                this.classList.add('selected');

                // Handle custom input visibility
                const customInput = document.getElementById('customDateInput');
                if (value === 'custom') {
                    customInput.classList.add('active');
                    document.getElementById('datePreview').textContent = document.getElementById(
                        'customDateFormat').value || 'Custom format';
                } else {
                    customInput.classList.remove('active');
                    updateDatePreview(value);
                }
            } else if (isTimeOption) {
                // Remove selected class from all time options
                document.querySelectorAll('.form-section:nth-child(2) .format-option').forEach(opt => {
                    opt.classList.remove('selected');
                });

                // Add selected class to clicked option
                this.classList.add('selected');

                // Handle custom input visibility
                const customInput = document.getElementById('customTimeInput');
                if (value === 'custom') {
                    customInput.classList.add('active');
                    document.getElementById('timePreview').textContent = document.getElementById(
                        'customTimeFormat').value || 'Custom format';
                } else {
                    customInput.classList.remove('active');
                    updateTimePreview(value);
                }
            }
        });
    });

    // Date format preview
    function updateDatePreview(format) {
        const previews = {
            'F j, Y': 'November 23, 2018',
            'Y-m-d': '2018-11-23',
            'd/m/Y': '23/11/2018',
            'm/d/Y': '11/23/2018',
            'd.m.Y': '18.12.2025'
        };
        document.getElementById('datePreview').textContent = previews[format] || 'Custom format';
    }

    // Time format preview
    function updateTimePreview(format) {
        const previews = {
            'g:i a': '2:34 pm',
            'g:i A': '2:34 PM',
            'H:i': '14:34',
            'H:i:s': '14:34:25'
        };
        document.getElementById('timePreview').textContent = previews[format] || 'Custom format';
    }

    // Custom format inputs
    document.getElementById('customDateFormat')?.addEventListener('input', function(e) {
        document.getElementById('datePreview').textContent = e.target.value || 'Custom format';
    });

    document.getElementById('customTimeFormat')?.addEventListener('input', function(e) {
        document.getElementById('timePreview').textContent = e.target.value || 'Custom format';
    });

    // Initialize previews
    updateDatePreview('F j, Y');
    updateTimePreview('g:i a');
</script>
@endpush