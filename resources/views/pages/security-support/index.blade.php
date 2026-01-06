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
        /* Bu qatorni qo'shing */
        overflow: hidden;
        /* Chiqib ketmasligi uchun */
    }

    .setting-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: #1F2937;
        /* O'zgartirildi */
        border-radius: 16px 0 0 16px;
        z-index: 1;
    }


    .setting-card:hover {
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
    }

    .setting-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .setting-title i {
        margin-right: 0.75rem;
        color: #1F2937;
    }

    .setting-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1.25rem;
    }

    .status-indicator {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .status-active {
        background-color: rgba(46, 204, 113, 0.1);
        color: var(--success-color);
    }

    .status-inactive {
        background-color: rgba(231, 76, 60, 0.1);
        color: var(--danger-color);
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

    .form-check-input:checked {
        background-color: #1F2937;
        border-color: #1F2937;
    }

    .form-check-input:focus {
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
                    Xavfsizlik va xizmat ko'rsatish
                </li>
            </ol>
        </nav>
    </div>

    <div class="d-flex gap-2 align-items-center flex-wrap">

        <x-go-back url="{{ $go_back }}" />
    </div>
</div>
@endsection

@section('content')
<div class=" py-3">
    <div class="content-container" style="background-color: white; border-radius: 0.5rem; box-shadow: 0 0.125rem 0.625rem rgba(0,0,0,0.08); padding: 1.5rem;">
        <h1 class="section-title">
            <i class="fas fa-shield-alt me-2"></i>Xavfsizlik va Xizmat Ko'rsatish Sazlamalari
        </h1>

        <div class="info-badge">
            <i class="fas fa-info-circle"></i>
            «Envast» investitsiya platformasining xavfsizlik va xizmat ko'rsatish sozlamalarini boshqarishingiz mumkin. Platforma Ҳалол инвестицияlar asosida ko'chmas mulk loyihalarini moliyalashtirishga qaratilgan.
        </div>

        <!-- User Session Management -->
        <div class="setting-card">
            <h3 class="setting-title">
                <i class="fas fa-user-clock"></i>Foydalanuvchi Sessiyasi Boshqaruvi
            </h3>
            <p class="setting-description">
                Investor va administratorlar sessiyasining amal qilish muddatini sozlang. Sessiya muddati o'tgach, foydalanuvchi qayta tizimga kiritilishi talab qilinadi.
            </p>

            @php
            $session_duration = [
            '15' => '15 daqiqa',
            '30' => '30 daqiqa',
            '60' => '1 soat',
            '120' => '2 soat',
            '240' => '4 soat',
            '480' => '8 soat',
            '1440' => '1 kun (24 soat)',
            ];
            @endphp

            <div class="row mb-3">
                <div class="col-md-6">
                    <x-select-with-search
                        name="sessionDurationFilter"
                        label="Sessiya muddati (daqiqa)"
                        :datas="$session_duration"
                        colMd="12"
                        placeholder="Barchasi"
                        :selected="request()->get('sessionDurationFilter', '')"
                        :selectSearch=false />

                    <div class="form-text">
                        Hozirgi holat: <span class="status-indicator status-active">Faol (30 daqiqa)</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="sessionExtend" class="form-label">Sessiyani uzaytirish</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="sessionExtend" checked>
                        <label class="form-check-label" for="sessionExtend">
                            Faollik davomida sessiyani avtomatik uzaytirish
                        </label>
                    </div>
                    <div class="form-text">
                        Agar yoqilgan bo'lsa, investor yoki administrator faol bo'lgan vaqt davomida sessiya muddati avtomatik ravishda uzaytiriladi.
                    </div>
                </div>
            </div>
        </div>

        <!-- Login Security -->
        <div class="setting-card">
            <h3 class="setting-title">
                <i class="fas fa-sign-in-alt"></i>Kirish Xavfsizligi
            </h3>
            <p class="setting-description">
                Platformaga investor va administratorlar kirishi uchun xavfsizlik cheklovlarini sozlang. Bu sizga noto'g'ri urinishlardan himoya qilishga yordam beradi.
            </p>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="maxAttempts" class="form-label">Maksimal noto'g'ri urinishlar soni</label>
                    <input type="number" class="form-control" id="maxAttempts" value="5" min="1" max="20">
                    <div class="form-text">
                        Belgilangan son noto'g'ri urinishdan so'ng, foydalanuvchi hisobi vaqtincha bloklanadi.
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="blockDuration" class="form-label">Bloklash muddati (daqiqa)</label>
                    <input type="number" class="form-control" id="blockDuration" value="30" min="5" max="1440">
                    <div class="form-text">
                        Noto'g'ri urinishlar chegarasiga yetgandan keyin bloklash davomiyligi.
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="ipRestriction" class="form-label">IP manzil cheklovi</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="ipRestriction" checked>
                        <label class="form-check-label" for="ipRestriction">
                            Bir IP manzildan maksimal kirish urinishlarini cheklash
                        </label>
                    </div>
                    <div class="form-text">
                        Xavfsizlikni oshirish uchun bir IP manzildan ma'lum vaqt oralig'ida maksimal kirish urinishlari soni cheklanadi.
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="ipMaxAttempts" class="form-label">IP uchun maksimal urinishlar</label>
                    <input type="number" class="form-control" id="ipMaxAttempts" value="20" min="5" max="100" disabled>
                    <div class="form-text">
                        Bir IP manzil uchun ruxsat etilgan maksimal kirish urinishlari soni (soatiga).
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Backup Settings -->
        <div class="setting-card">
            <h3 class="setting-title">
                <i class="fas fa-database"></i>Ma'lumotlar Zaxirasi (Backup)
            </h3>
            <p class="setting-description">
                Investor ma'lumotlari, shartnomalar va moliyaviy hisobotlarning avtomatik zaxiralanishi parametrlarini sozlang. Zaxiralash ma'lumotlaringizni xavfsiz saqlash uchun juda muhimdir.
            </p>

            @php
            $backup_frequency = [
            'daily' => 'Kunlik',
            'weekly' => 'Haftalik',
            'monthly' => 'Oylik',
            ];
            @endphp

            <div class="row mb-3">
                <div class="col-md-6">
                    <x-select-with-search
                        name="backupFrequencyFilter"
                        label="Zaxiralash chastotasi"
                        :datas="$backup_frequency"
                        colMd="12"
                        placeholder="Barchasi"
                        :selected="request()->get('backupFrequency', '')"
                        :selectSearch=false />

                    <div class="form-text">
                        Hozirgi holat: <span class="status-indicator status-active">Haftalik zaxiralash faol</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="backupTime" class="form-label">Zaxiralash vaqti</label>
                    <input type="time" class="form-control" id="backupTime" value="02:00">
                    <div class="form-text">
                        Zaxiralash jarayoni boshlanadigan vaqt (server vaqti bilan). Tanlangan vaqt platforma foydalanuvchilari uchun minimal faollik davrida bo'lishi tavsiya etiladi.
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                @php
                $stockpiling = [
                '7' => '7 kun',
                '14' => '14 kun',
                '30' => '30 kun',
                '90' => '90 kun',
                '180' => '180 kun',
                ];
                @endphp

                <div class="col-md-6">
                    <x-select-with-search
                        name="stockpilingFilter"
                        label="Zaxiralarni saqlash muddati (kun)"
                        :datas="$stockpiling"
                        colMd="12"
                        placeholder="Barchasi"
                        :selected="request()->get('stockpiling', '')"
                        :selectSearch=false />
                    <div class="form-text">
                        Eski zaxiralar avtomatik ravishda o'chiriladi. Investitsiya shartnomalari va moliyaviy hisobotlar uchun 90 kun saqlash tavsiya etiladi.
                    </div>
                </div>

                <div class="col-md-6">
                    @php
                    $backup_location = [
                    'local' => 'Mahalliy',
                    'cloud' => 'Bulut xizmati',
                    'both' => 'Ikkala joyda ham',
                    ];
                    @endphp

                    <x-select-with-search
                        name="backupLocationFilter"
                        label="Zaxira joylashuvi"
                        :datas="$backup_location"
                        colMd="12"
                        placeholder="Barchasi"
                        :selected="request()->get('backupLocation', '')"
                        :selectSearch=false />
                    <div class="form-text">
                        Investor ma'lumotlari, shartnomalar va moliyaviy hisobotlarning saqlanish joyi.
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="backupNotification" checked>
                    <label class="form-check-label" for="backupNotification">
                        Zaxiralash tugagandan so'ng bildirishnoma yuborish
                    </label>
                </div>
                <div class="form-text">
                    Zaxiralash jarayoni tugagandan so'ng administratorlarga elektron pochta orqali xabar yuboriladi.
                </div>
            </div>

            <div class="mt-4">
                <button type="button" class="btn btn-outline-primary me-2" id="manualBackupBtn">
                    <i class="fas fa-play-circle me-1"></i>Zaxirani hozir yaratish
                </button>
                <button type="button" class="btn btn-outline-primary me-2">
                    <i class="fas fa-history me-1"></i>Zaxira tarixini ko'rish
                </button>
            </div>
        </div>

        <!-- System Security Settings -->
        <div class="setting-card">
            <h3 class="setting-title">
                <i class="fas fa-lock"></i>Tizim Xavfsizligi
            </h3>
            <p class="setting-description">
                «Envast» platformasining umumiy xavfsizligi va investorlar ma'lumotlarini himoya qilish uchun qo'shimcha parametrlarni sozlang.
            </p>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="passwordPolicy" class="form-label">Parol siyosati</label>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="strongPassword" checked>
                        <label class="form-check-label" for="strongPassword">
                            Kuchli parol talab qilish
                        </label>
                    </div>
                    <div class="form-text">
                        Investor va administratorlar uchun kuchli parol talab qilinadi (kamida 8 ta belgi, katta-kichik harflar, raqamlar va maxsus belgilar).
                    </div>
                </div>

                <div class="col-md-6">
                    @php
                    $password_expiration_date = [
                    '0' => 'Cheklanmagan',
                    '30' => '30 kun',
                    '60' => '60 kun',
                    '90' => '90 kun',
                    '180' => '180 kun',
                    ];
                    @endphp

                    <x-select-with-search
                        name="passwordExpiryFilter"
                        label="Parol amal qilish muddati (kun)"
                        :datas="$password_expiration_date"
                        colMd="12"
                        placeholder="Barchasi"
                        :selected="request()->get('passwordExpiry', '')"
                        :selectSearch=false />

                    <div class="form-text">
                        Administratorlar uchun parol amal qilish muddati o'tgach, parolni yangilashi talab qilinadi.
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="twoFactorAuth" class="form-label">Ikki faktorli autentifikatsiya (2FA)</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="twoFactorAuth">
                        <label class="form-check-label" for="twoFactorAuth">
                            Administratorlar uchun 2FA ni yoqish
                        </label>
                    </div>
                    <div class="form-text">
                        Agar yoqilgan bo'lsa, administratorlar tizimga kirishda ikki faktorli autentifikatsiyadan foydalanishlari talab qilinadi.
                    </div>
                </div>

                <!-- <div class="col-md-6">
                    <label for="httpsEnforcement" class="form-label">HTTPS majburiyligi</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="httpsEnforcement" checked>
                        <label class="form-check-label" for="httpsEnforcement">
                            Barcha trafikni HTTPS orqali yo'naltirish
                        </label>
                    </div>
                    <div class="form-text">
                        Investorlar ma'lumotlari va moliyaviy transaktsiyalarni himoya qilish uchun barcha trafik HTTPS orqali amalga oshiriladi.
                    </div>
                </div> -->
            </div>
        </div>

        <!-- Maintenance Settings -->
        <div class="setting-card">
            <h3 class="setting-title">
                <i class="fas fa-tools"></i>Xizmat Ko'rsatish Rejimi
            </h3>
            <p class="setting-description">
                «Envast» platformasida texnik ishlar, yangilanishlar yoki tizimni yaxshilash jarayonlarida investorlar uchun kirishni vaqtincha cheklash sozlamalari.
            </p>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Rejim holati</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="maintenanceMode">
                        <label class="form-check-label" for="maintenanceMode">
                            Xizmat ko'rsatish rejimini yoqish
                        </label>
                    </div>
                    <div class="form-text">
                        Hozirgi holat:
                        <span id="maintenanceStatus" class="status-indicator status-inactive">O'chirilgan</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="maintenanceMessage" class="form-label">Investorlar uchun xabar</label>
                    <textarea class="form-control" id="maintenanceMessage" rows="3" placeholder="«Envast» investitsiya platformasida texnik ishlar olib borilmoqda. Iltimos, keyinroq qayta urinib ko'ring. Biz sizning qulayligingiz uchun doim ishlamoqdamiz."></textarea>
                    <div class="form-text">
                        Ushbu xabar mobile ilova va veb sahifada investorlarga ko'rsatiladi.
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="adminAccess" checked>
                    <label class="form-check-label" for="adminAccess">
                        Administratorlarga ruxsat berish
                    </label>
                </div>
                <div class="form-text">
                    Administratorlar xizmat ko'rsatish rejimida ham tizimga kira oladi va investor ma'lumotlarini ko'ra oladi.
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">

            <div class="form-text">
                Oxirgi o'zgarish: 2023-yil 15-oktabr, 14:30
            </div>

            <div>
                <a href="{{ route('admin.general-settings.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Bekor qilish
                </a>

                <button type="button" class="btn btn-primary" id="saveSettingsBtn">
                    <i class="fas fa-save me-1"></i>Sazlamalarni saqlash
                </button>
            </div>
        </div>
    </div>


    <div class="footer-info mt-4 pt-3 border-top" style="color: #6c757d; font-size: 0.875rem;">
        <i class="fas fa-lightbulb me-1"></i>
        Maslahat: Xavfsizlik sozlamalarini o'zgartirishdan oldin, ularning «Envast» platformasidagi investorlar tajribasiga ta'sirini yaxshilab o'ylab ko'ring.
    </div>
</div>
</div>
@endsection

@push('customJs')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle IP restriction and enable/disable related input
        const ipRestriction = document.getElementById('ipRestriction');
        const ipMaxAttempts = document.getElementById('ipMaxAttempts');

        ipRestriction.addEventListener('change', function() {
            ipMaxAttempts.disabled = !this.checked;
        });

        // Toggle maintenance mode
        const maintenanceMode = document.getElementById('maintenanceMode');
        const maintenanceMessage = document.getElementById('maintenanceMessage');
        const maintenanceStatus = document.getElementById('maintenanceStatus');

        maintenanceMode.addEventListener('change', function() {
            if (this.checked) {
                maintenanceStatus.textContent = 'Xizmat ko\'rsatish rejimi yoqilgan';
                maintenanceStatus.classList.remove('status-inactive');
                maintenanceStatus.classList.add('status-active');
                maintenanceMessage.required = true;
            } else {
                maintenanceStatus.textContent = 'Xizmat ko\'rsatish rejimi o\'chirilgan';
                maintenanceStatus.classList.remove('status-active');
                maintenanceStatus.classList.add('status-inactive');
                maintenanceMessage.required = false;
            }
        });

        // Save button functionality
        const saveBtn = document.getElementById('saveSettingsBtn');
        saveBtn.addEventListener('click', function() {
            // Show success message
            const originalText = saveBtn.innerHTML;
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Saqlanmoqda...';
            saveBtn.disabled = true;

            // Simulate API call
            setTimeout(function() {
                saveBtn.innerHTML = '<i class="fas fa-check me-1"></i>Sazlamalar saqlandi!';
                saveBtn.classList.remove('save-btn');
                saveBtn.classList.add('btn-success');

                // Show success message
                showToast('Muvaffaqiyatli', '«Envast» platformasining xavfsizlik sozlamalari saqlandi', 'success');

                // Reset button after 2 seconds
                setTimeout(function() {
                    saveBtn.innerHTML = originalText;
                    saveBtn.disabled = false;
                    saveBtn.classList.remove('btn-success');
                    saveBtn.classList.add('save-btn');
                }, 2000);
            }, 1500);
        });

        // Manual backup button
        const manualBackupBtn = document.getElementById('manualBackupBtn');
        manualBackupBtn.addEventListener('click', function() {
            const originalText = manualBackupBtn.innerHTML;
            manualBackupBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Zaxira yaratilmoqda...';
            manualBackupBtn.disabled = true;

            // Simulate backup process
            setTimeout(function() {
                manualBackupBtn.innerHTML = '<i class="fas fa-check me-1"></i>Zaxira yaratildi!';
                manualBackupBtn.classList.remove('btn-outline-primary');
                manualBackupBtn.classList.add('btn-outline-success');

                // Show success alert
                showToast('Muvaffaqiyat', 'Investor ma\'lumotlari zaxirasi muvaffaqiyatli yaratildi', 'success');

                // Reset button after 2 seconds
                setTimeout(function() {
                    manualBackupBtn.innerHTML = originalText;
                    manualBackupBtn.disabled = false;
                    manualBackupBtn.classList.remove('btn-outline-success');
                    manualBackupBtn.classList.add('btn-outline-primary');
                }, 2000);
            }, 3000);
        });

        // Cancel button
        const cancelBtn = document.getElementById('cancelBtn');
        cancelBtn.addEventListener('click', function() {
            // Reset all form values to their original state
            document.getElementById('sessionDuration').value = '30';
            document.getElementById('sessionExtend').checked = true;
            document.getElementById('maxAttempts').value = '5';
            document.getElementById('blockDuration').value = '30';
            document.getElementById('ipRestriction').checked = true;
            document.getElementById('ipMaxAttempts').value = '20';
            document.getElementById('ipMaxAttempts').disabled = false;
            document.getElementById('backupFrequency').value = 'weekly';
            document.getElementById('backupTime').value = '02:00';
            document.getElementById('backupRetention').value = '30';
            document.getElementById('backupLocation').value = 'local';
            document.getElementById('backupNotification').checked = true;
            document.getElementById('strongPassword').checked = true;
            document.getElementById('passwordExpiry').value = '90';
            document.getElementById('twoFactorAuth').checked = false;
            document.getElementById('httpsEnforcement').checked = true;
            document.getElementById('maintenanceMode').checked = false;
            document.getElementById('maintenanceMessage').value = '';
            document.getElementById('adminAccess').checked = true;

            // Reset maintenance status
            maintenanceStatus.textContent = 'Xizmat ko\'rsatish rejimi o\'chirilgan';
            maintenanceStatus.classList.remove('status-active');
            maintenanceStatus.classList.add('status-inactive');

            showToast('Bekor qilindi', '«Envast» platformasi sozlamalari asl holatiga qaytarildi', 'info');
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