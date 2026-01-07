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

    .setting-card:hover::before {
        width: 5px;
        background: #111827;
    }

    .setting-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .setting-title i {
        margin-right: 0.75rem;
        color: #1F2937;
    }

    .setting-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1.25rem;
        position: relative;
        z-index: 2;
    }

    .status-indicator {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
        position: relative;
        z-index: 2;
    }

    .status-active {
        background-color: rgba(46, 204, 113, 0.1);
        color: var(--success-color);
    }

    .status-inactive {
        background-color: rgba(231, 76, 60, 0.1);
        color: var(--danger-color);
    }

    .status-warning {
        background-color: rgba(243, 156, 18, 0.1);
        color: var(--warning-color);
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

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border-color);
    }

    .cache-info {
        background-color: #f8f9fa;
        border-radius: 0.375rem;
        padding: 1rem;
        margin-top: 1rem;
        font-size: 0.875rem;
    }

    .cache-info .row {
        align-items: center;
    }

    .cache-stats {
        background-color: white;
        border: 1px solid var(--border-color);
        border-radius: 0.375rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .log-file-item {
        border: 1px solid var(--border-color);
        border-radius: 0.375rem;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.2s ease;
    }

    .log-file-item:hover {
        background-color: #f8f9fa;
    }

    .log-file-size {
        font-size: 0.875rem;
        color: #6c757d;
    }

    .log-file-actions {
        display: flex;
        gap: 0.5rem;
    }

    .cache-driver-info {
        background-color: #f0f7ff;
        border-left: 3px solid var(--primary-color);
        padding: 0.75rem;
        border-radius: 0 0.375rem 0.375rem 0;
        font-size: 0.875rem;
    }
</style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
    style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
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
                    Ish faoliyati
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
<div class="py-3">
    <div class="content-container" style="background-color: white; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.625rem rgba(0,0,0,0.08); padding: 1.5rem;">
        <h1 class="section-title">
            <i class="fas fa-tachometer-alt me-2"></i>Ish Faoliyati (Performance) Sazlamalari
        </h1>

        <div class="info-badge">
            <i class="fas fa-info-circle"></i>
            «Envast» investitsiya platformasining ish faoliyati va tezligini optimallashtirish uchun kesh va log fayllarini boshqarish sozlamalari.
        </div>

        <!-- Cache Settings -->
        <div class="setting-card">
            <h3 class="setting-title">
                <i class="fas fa-bolt"></i>Kesh (Cache) Boshqaruvi
            </h3>
            <p class="setting-description">
                Sayt tezligini oshirish uchun kesh sozlamalarini boshqaring. Kesh ma'lumotlarni vaqtincha saqlash orqali server yukini kamaytiradi.
            </p>

            <div class="cache-stats">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Kesh holati:</h6>
                        <div class="d-flex align-items-center">
                            <span class="status-indicator status-active me-2">Faol</span>
                            <span class="text-muted">(Joriy kesh hajmi: 45.2 MB)</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Kesh driver:</h6>
                        <span class="badge bg-primary">Redis</span>
                    </div>
                </div>
            </div>

            @php
            $cache_drivers = [
            'file' => 'Fayl (File)',
            'redis' => 'Redis',
            'memcached' => 'Memcached',
            'database' => 'Ma\'lumotlar bazasi',
            ];

            $cache_ttl = [
            '60' => '1 daqiqa',
            '300' => '5 daqiqa',
            '600' => '10 daqiqa',
            '1800' => '30 daqiqa',
            '3600' => '1 soat',
            '7200' => '2 soat',
            '14400' => '4 soat',
            '86400' => '1 kun',
            ];
            @endphp

            <div class="row mb-3">
                <div class="col-md-6">
                    <x-select-with-search
                        name="cacheDriverFilter"
                        label="Kesh driveri"
                        :datas="$cache_drivers"
                        colMd="12"
                        placeholder="Driver tanlang"
                        :selected="'redis'"
                        :selectSearch=false />

                    <div class="cache-driver-info mt-2">
                        <i class="fas fa-info-circle text-primary me-1"></i>
                        <small>Redis - tez va samarali kesh tizimi. Investorlar ma'lumotlari uchun tavsiya etiladi.</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <x-select-with-search
                        name="cacheTtlFilter"
                        label="Kesh saqlanish muddati (TTL)"
                        :datas="$cache_ttl"
                        colMd="12"
                        placeholder="Muddati tanlang"
                        :selected="'3600'"
                        :selectSearch=false />

                    <div class="form-text">
                        Kesh elementlari saqlanish muddati. Investorlar ro'yxati ma'lumotlari uchun 1 soat optimal.
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cachePrefix" class="form-label">Kesh prefiksi</label>
                    <input type="text" class="form-control" id="cachePrefix" value="envast_cache_" placeholder="envast_cache_">
                    <div class="form-text">
                        Kesh kalitlarining old qismi. Har bir muhit uchun boshqacha bo'lishi tavsiya etiladi.
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="cacheCompression" class="form-label">Kesh siqilishi</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="cacheCompression" checked>
                        <label class="form-check-label" for="cacheCompression">
                            Kesh ma'lumotlarini siqish
                        </label>
                    </div>
                    <div class="form-text">
                        Siqilgan kesh hajmi kichikroq bo'ladi, lekin qayta ishlash vaqti biroz oshishi mumkin.
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="button" class="btn btn-outline-primary me-2" id="clearCacheBtn">
                    <i class="fas fa-trash-alt me-1"></i>Keshni tozalash
                </button>
                <button type="button" class="btn btn-outline-secondary me-2" id="preheatCacheBtn">
                    <i class="fas fa-fire me-1"></i>Keshni isitish
                </button>
                <button type="button" class="btn btn-outline-info" id="cacheStatsBtn">
                    <i class="fas fa-chart-bar me-1"></i>Kesh statistikasini ko'rish
                </button>
            </div>
        </div>

        <!-- Log Management -->
        <div class="setting-card">
            <h3 class="setting-title">
                <i class="fas fa-file-alt"></i>Log Fayllarini Boshqarish
            </h3>
            <p class="setting-description">
                Tizim loglarini boshqarish va saqlash parametrlarini sozlang. Loglar tizim xatolari va foydalanuvchi faoliyatini kuzatish uchun muhimdir.
            </p>

            @php
            $log_levels = [
            'debug' => 'Debug (batafsil)',
            'info' => 'Info (ma\'lumot)',
            'notice' => 'Notice (ogohlantirish)',
            'warning' => 'Warning (ogohlantirish)',
            'error' => 'Error (xato)',
            'critical' => 'Critical (jiddiy)',
            'alert' => 'Alert (signal)',
            'emergency' => 'Emergency (favqulodda)',
            ];

            $log_retention = [
            '7' => '7 kun',
            '14' => '14 kun',
            '30' => '30 kun',
            '60' => '60 kun',
            '90' => '90 kun',
            '180' => '180 kun',
            '365' => '1 yil',
            ];
            @endphp

            <div class="row mb-4">
                <div class="col-md-6">
                    <x-select-with-search
                        name="logLevelFilter"
                        label="Log darajasi"
                        :datas="$log_levels"
                        colMd="12"
                        placeholder="Daraja tanlang"
                        :selected="'error'"
                        :selectSearch=false />

                    <div class="form-text">
                        Qaysi darajadagi loglar yozilishi. "Error" - faqat xatolar, "Debug" - barcha amallar.
                    </div>
                </div>

                <div class="col-md-6">
                    <x-select-with-search
                        name="logRetentionFilter"
                        label="Log saqlanish muddati"
                        :datas="$log_retention"
                        colMd="12"
                        placeholder="Muddati tanlang"
                        :selected="'30'"
                        :selectSearch=false />

                    <div class="form-text">
                        Eski log fayllari avtomatik ravishda o'chiriladi. Investor amallari loglari uchun 30 kun tavsiya etiladi.
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="logMaxSize" class="form-label">Maksimal log fayl hajmi (MB)</label>
                    <input type="number" class="form-control" id="logMaxSize" value="50" min="10" max="1000">
                    <div class="form-text">
                        Har bir log faylining maksimal hajmi. Hajm chegarasiga yetganda yangi fayl yaratiladi.
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="logNotifications" class="form-label">Log ogohlantirishlari</label>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="criticalEmail" checked>
                        <label class="form-check-label" for="criticalEmail">
                            Jiddiy xatolarda email jo'natish
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="errorSlack">
                        <label class="form-check-label" for="errorSlack">
                            Error xatolarida Slack bildirishnoma
                        </label>
                    </div>
                </div>
            </div>

            <!-- Log Files List -->
            <h6 class="mt-4 mb-3">Log fayllari ro'yxati:</h6>
            <div class="log-files-list">
                @php
                $log_files = [
                ['name' => 'laravel.log', 'size' => '15.2 MB', 'date' => '2023-10-15', 'type' => 'error'],
                ['name' => 'investor_activity.log', 'size' => '8.7 MB', 'date' => '2023-10-15', 'type' => 'info'],
                ['name' => 'transaction.log', 'size' => '22.5 MB', 'date' => '2023-10-14', 'type' => 'info'],
                ['name' => 'authentication.log', 'size' => '3.1 MB', 'date' => '2023-10-14', 'type' => 'security'],
                ['name' => 'api_requests.log', 'size' => '12.8 MB', 'date' => '2023-10-13', 'type' => 'debug'],
                ];
                @endphp

                @foreach($log_files as $log)
                <div class="log-file-item">
                    <div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-alt text-secondary me-2"></i>
                            <strong>{{ $log['name'] }}</strong>
                            <span class="badge bg-light text-dark ms-2">{{ $log['type'] }}</span>
                        </div>
                        <div class="log-file-size">
                            Hajmi: {{ $log['size'] }} | Oxirgi yangilanish: {{ $log['date'] }}
                        </div>
                    </div>
                    <div class="log-file-actions">
                        <button type="button" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success">
                            <i class="fas fa-download"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-4">
                <button type="button" class="btn btn-outline-danger me-2" id="clearOldLogsBtn">
                    <i class="fas fa-broom me-1"></i>Eski loglarni tozalash
                </button>
                <button type="button" class="btn btn-outline-warning me-2" id="analyzeLogsBtn">
                    <i class="fas fa-chart-pie me-1"></i>Loglarni tahlil qilish
                </button>
                <button type="button" class="btn btn-outline-info">
                    <i class="fas fa-cog me-1"></i>Log rotatsiyasini sozlash
                </button>
            </div>
        </div>

        <!-- Performance Optimization -->
        <div class="setting-card">
            <h3 class="setting-title">
                <i class="fas fa-cogs"></i>Tezlik Optimallashtirish
            </h3>
            <p class="setting-description">
                «Envast» platformasining ish tezligini yaxshilash uchun qo'shimcha optimallashtirish sozlamalari.
            </p>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="imageOptimization" class="form-label">Rasmlarni optimallashtirish</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="imageOptimization" checked>
                        <label class="form-check-label" for="imageOptimization">
                            Avtomatik rasmlarni siqish
                        </label>
                    </div>
                    <div class="form-text">
                        Yuklangan rasmlar avtomatik ravishda optimallashtiriladi va kichikroq hajmda saqlanadi.
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="lazyLoading" class="form-label">Lazy Loading</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="lazyLoading" checked>
                        <label class="form-check-label" for="lazyLoading">
                            Rasmlarni darhol yuklamaslik
                        </label>
                    </div>
                    <div class="form-text">
                        Faqat ko'rinadigan qismdagi rasmlar yuklanadi, bu sahifa ochilish tezligini oshiradi.
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="queryCache" class="form-label">SQL so'rovlari kesh</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="queryCache" checked>
                        <label class="form-check-label" for="queryCache">
                            Takroriy SQL so'rovlarini keshlash
                        </label>
                    </div>
                    <div class="form-text">
                        Investorlar ro'yxati va statistika ma'lumotlari kabi takroriy so'rovlar keshlanadi.
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="assetVersioning" class="form-label">Asset versioning</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="assetVersioning" checked>
                        <label class="form-check-label" for="assetVersioning">
                            CSS/JS fayllar versiyalashtirish
                        </label>
                    </div>
                    <div class="form-text">
                        Brauzer keshi yangilanishini ta'minlash uchun asset fayllari versiyasi o'zgartiriladi.
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="cdnEnabled" class="form-label">CDN (Content Delivery Network)</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="cdnEnabled">
                        <label class="form-check-label" for="cdnEnabled">
                            Statik fayllarni CDN orqali uzatish
                        </label>
                    </div>
                    <div class="form-text">
                        CSS, JS va rasmlarni CDN serverlari orqali yuklash, bu tezlikni sezilarli oshiradi.
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="compressionEnabled" class="form-label">Gzip siqish</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="compressionEnabled" checked>
                        <label class="form-check-label" for="compressionEnabled">
                            Sayt kontentini Gzip bilan siqish
                        </label>
                    </div>
                    <div class="form-text">
                        Sahifa yuklash hajmini 70% gacha kamaytiradi, tezlikni oshiradi.
                    </div>
                </div>
            </div>

            <div class="cache-info mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Joriy tezlik holati:</h6>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <span class="status-indicator status-active">Yaxshi</span>
                            </div>
                            <div>
                                <small>Sahifa ochilish tezligi: 850ms</small><br>
                                <small>Kesh effektivligi: 92%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="button" class="btn btn-sm btn-outline-primary" id="runSpeedTestBtn">
                            <i class="fas fa-play-circle me-1"></i>Tezlikni test qilish
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="form-text">
                Oxirgi optimallashtirish: 2023-yil 15-oktabr, 10:15
            </div>
            <div>
                <button type="button" class="btn btn-outline-secondary me-2" id="cancelBtn">
                    <i class="fas fa-times me-1"></i>Bekor qilish
                </button>
                <button type="button" class="btn save-btn" id="saveSettingsBtn">
                    <i class="fas fa-save me-1"></i>Sazlamalarni saqlash
                </button>
            </div>
        </div>

        <div class="footer-info mt-4 pt-3 border-top" style="color: #6c757d; font-size: 0.875rem;">
            <i class="fas fa-lightbulb me-1"></i>
            Maslahat: Kesh va log sozlamalarini o'zgartirish platformaning barqarorligiga ta'sir qilishi mumkin. O'zgartirishlardan oldin natijalarni sinab ko'ring.
        </div>
    </div>
</div>
@endsection

@push('customJs')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Clear Cache Button
        const clearCacheBtn = document.getElementById('clearCacheBtn');
        clearCacheBtn.addEventListener('click', function() {
            const originalText = clearCacheBtn.innerHTML;
            clearCacheBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Kesh tozalanmoqda...';
            clearCacheBtn.disabled = true;

            setTimeout(function() {
                clearCacheBtn.innerHTML = '<i class="fas fa-check me-1"></i>Kesh tozalandi!';
                clearCacheBtn.classList.remove('btn-outline-primary');
                clearCacheBtn.classList.add('btn-outline-success');

                showToast('Muvaffaqiyatli', 'Kesh muvaffaqiyatli tozalandi', 'success');

                setTimeout(function() {
                    clearCacheBtn.innerHTML = originalText;
                    clearCacheBtn.disabled = false;
                    clearCacheBtn.classList.remove('btn-outline-success');
                    clearCacheBtn.classList.add('btn-outline-primary');
                }, 2000);
            }, 2000);
        });

        // Preheat Cache Button
        const preheatCacheBtn = document.getElementById('preheatCacheBtn');
        preheatCacheBtn.addEventListener('click', function() {
            const originalText = preheatCacheBtn.innerHTML;
            preheatCacheBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Kesh isitilmoqda...';
            preheatCacheBtn.disabled = true;

            setTimeout(function() {
                preheatCacheBtn.innerHTML = '<i class="fas fa-check me-1"></i>Kesh isitildi!';
                preheatCacheBtn.classList.remove('btn-outline-secondary');
                preheatCacheBtn.classList.add('btn-outline-success');

                showToast('Muvaffaqiyatli', 'Kesh muvaffaqiyatli isitildi', 'success');

                setTimeout(function() {
                    preheatCacheBtn.innerHTML = originalText;
                    preheatCacheBtn.disabled = false;
                    preheatCacheBtn.classList.remove('btn-outline-success');
                    preheatCacheBtn.classList.add('btn-outline-secondary');
                }, 2000);
            }, 3000);
        });

        // Clear Old Logs Button
        const clearOldLogsBtn = document.getElementById('clearOldLogsBtn');
        clearOldLogsBtn.addEventListener('click', function() {
            const originalText = clearOldLogsBtn.innerHTML;
            clearOldLogsBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Loglar tozalanmoqda...';
            clearOldLogsBtn.disabled = true;

            setTimeout(function() {
                clearOldLogsBtn.innerHTML = '<i class="fas fa-check me-1"></i>Loglar tozalandi!';
                clearOldLogsBtn.classList.remove('btn-outline-danger');
                clearOldLogsBtn.classList.add('btn-outline-success');

                showToast('Muvaffaqiyatli', 'Eski log fayllari muvaffaqiyatli o\'chirildi', 'success');

                setTimeout(function() {
                    clearOldLogsBtn.innerHTML = originalText;
                    clearOldLogsBtn.disabled = false;
                    clearOldLogsBtn.classList.remove('btn-outline-success');
                    clearOldLogsBtn.classList.add('btn-outline-danger');
                }, 2000);
            }, 2500);
        });

        // Run Speed Test Button
        const runSpeedTestBtn = document.getElementById('runSpeedTestBtn');
        runSpeedTestBtn.addEventListener('click', function() {
            const originalText = runSpeedTestBtn.innerHTML;
            runSpeedTestBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Test bajarilmoqda...';
            runSpeedTestBtn.disabled = true;

            setTimeout(function() {
                runSpeedTestBtn.innerHTML = '<i class="fas fa-check me-1"></i>Test tugadi!';
                runSpeedTestBtn.classList.remove('btn-outline-primary');
                runSpeedTestBtn.classList.add('btn-outline-success');

                showToast('Test tugadi', 'Platforma tezligi testi muvaffaqiyatli bajarildi', 'info');

                setTimeout(function() {
                    runSpeedTestBtn.innerHTML = originalText;
                    runSpeedTestBtn.disabled = false;
                    runSpeedTestBtn.classList.remove('btn-outline-success');
                    runSpeedTestBtn.classList.add('btn-outline-primary');
                }, 2000);
            }, 4000);
        });

        // Save Settings Button
        const saveBtn = document.getElementById('saveSettingsBtn');
        saveBtn.addEventListener('click', function() {
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Saqlanmoqda...';
            saveBtn.disabled = true;

            setTimeout(function() {
                saveBtn.innerHTML = '<i class="fas fa-check me-1"></i>Sazlamalar saqlandi!';
                saveBtn.classList.remove('save-btn');
                saveBtn.classList.add('btn-success');

                showToast('Muvaffaqiyatli', 'Ish faoliyati sozlamalari saqlandi', 'success');

                setTimeout(function() {
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                    saveBtn.classList.remove('btn-success');
                    saveBtn.classList.add('save-btn');
                }, 2000);
            }, 1500);
        });

        // Cancel Button
        const cancelBtn = document.getElementById('cancelBtn');
        cancelBtn.addEventListener('click', function() {
            // Reset all form values
            document.getElementById('cacheDriverFilter').value = 'redis';
            document.getElementById('cacheTtlFilter').value = '3600';
            document.getElementById('cachePrefix').value = 'envast_cache_';
            document.getElementById('cacheCompression').checked = true;
            document.getElementById('logLevelFilter').value = 'error';
            document.getElementById('logRetentionFilter').value = '30';
            document.getElementById('logMaxSize').value = '50';
            document.getElementById('criticalEmail').checked = true;
            document.getElementById('errorSlack').checked = false;
            document.getElementById('imageOptimization').checked = true;
            document.getElementById('lazyLoading').checked = true;
            document.getElementById('queryCache').checked = true;
            document.getElementById('assetVersioning').checked = true;
            document.getElementById('cdnEnabled').checked = false;
            document.getElementById('compressionEnabled').checked = true;

            showToast('Bekor qilindi', 'Barcha o\'zgarishlar bekor qilindi', 'info');
        });

        // Log file view buttons
        document.querySelectorAll('.log-file-actions .btn-outline-primary').forEach(btn => {
            btn.addEventListener('click', function() {
                showToast('Log ko\'rish', 'Log fayli ko\'rish rejimiga o\'tkazildi', 'info');
            });
        });

        // Toast notification function
        function showToast(title, message, type) {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-bg-${type} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <strong>${title}:</strong> ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;

            // Add to container or create container
            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                document.body.appendChild(toastContainer);
            }

            toastContainer.appendChild(toast);

            // Initialize and show toast
            const bsToast = new bootstrap.Toast(toast, {
                delay: 3000
            });
            bsToast.show();

            // Remove toast after hiding
            toast.addEventListener('hidden.bs.toast', function() {
                toast.remove();
            });
        }
    });
</script>
@endpush