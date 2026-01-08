// =================== PARTNERS TAB SCRIPT ===================
// File: resources/views/pages/projects/scripts/partners.blade.php

let partnersEditMode = false;
let nextPartnerId = 3;

function displayPartners(partners) {
    const container = document.getElementById('partnersContainer');

    if (!partners || partners.length === 0) {
        container.innerHTML = '<p class="text-muted text-center py-4">To\'liq sheriklar mavjud emas</p>';
        return;
    }

    if (!partnersEditMode) {
        // Ko'rish rejimi - BARCHA maydonlarni ko'rsatish
        container.innerHTML = partners.map(partner => `
            <div class="partner-card" style="margin-bottom: 1.5rem;">
                <div class="partner-header">
                    <i class="bi bi-building me-2"></i>
                    ${uiEscapeHtml(partner.company_name)}
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
                        <span class="info-value">${uiEscapeHtml(partner.company_name)}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-card-text me-1 text-muted"></i>
                            INN
                        </span>
                        <span class="info-value">${uiEscapeHtml(partner.inn)}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-upc-scan me-1 text-muted"></i>
                            IFUT kodi
                        </span>
                        <span class="info-value">${uiEscapeHtml(partner.ifut || '-')}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-briefcase me-1 text-muted"></i>
                            Faoliyat turi
                        </span>
                        <span class="info-value">${uiEscapeHtml(partner.type)}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-geo-alt me-1 text-muted"></i>
                            Manzil
                        </span>
                        <span class="info-value">${uiEscapeHtml(partner.address || '-')}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-person-badge me-1 text-muted"></i>
                            Direktor F.I.O.
                        </span>
                        <span class="info-value">${uiEscapeHtml(partner.director || '-')}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-telephone me-1 text-muted"></i>
                            Bog'lanish uchun telefon raqami
                        </span>
                        <span class="info-value">${uiEscapeHtml(partner.phone || '-')}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-envelope me-1 text-muted"></i>
                            Email
                        </span>
                        <span class="info-value">${uiEscapeHtml(partner.email || '-')}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-calendar-check me-1 text-muted"></i>
                            Ro'yxatdan o'tkazilgan sana
                        </span>
                        <span class="info-value">${uiEscapeHtml(partner.registration_date || '-')}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-file-earmark-text me-1 text-muted"></i>
                            Ro'yxatdan o'tkazish raqami
                        </span>
                        <span class="info-value">${uiEscapeHtml(partner.registration_number || '-')}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-building-check me-1 text-muted"></i>
                            Ro'yxatdan o'tkazuvchi davlat tashkiloti nomi
                        </span>
                        <span class="info-value">${uiEscapeHtml(partner.registration_org || '-')}</span>
                    </div>
                    ${partner.type === 'YaTT' ? `
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-person-vcard me-1 text-muted"></i>
                            Pasport ma'lumoti
                        </span>
                        <span class="info-value">${uiEscapeHtml(partner.passport_data || '-')}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-fingerprint me-1 text-muted"></i>
                            JSHSHIR
                        </span>
                        <span class="info-value">${uiEscapeHtml(partner.pinfl || '-')}</span>
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
                        <span class="info-value">${uiEscapeHtml(partner.partnership_date || '-')}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-file-earmark-pdf me-1 text-muted"></i>
                            Investorlik sertifikati fayli
                        </span>
                        <span class="info-value">${uiEscapeHtml(partner.investor_certificate || '-')}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-cash-stack me-1 text-muted"></i>
                            Loyihadagi jami ulushi (summada)
                        </span>
                        <span class="info-value">${formatMoney(partner.share_amount || 0)}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-percent me-1 text-muted"></i>
                            Loyihadagi jami ulushi (foizda)
                        </span>
                        <span class="info-value">${partner.share_percent || 0}%</span>
                    </div>
                </div>
            </div>
        `).join('');
    } else {
        // Tahrirlash rejimi - BARCHA maydonlarni tahrirlash
        container.innerHTML = partners.map((partner, index) => `
            <div class="partner-card" style="margin-bottom: 1.5rem; border: 2px solid var(--gray-200);">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="partner-header mb-0">
                        <i class="bi bi-building me-2"></i>
                        Sherik #${index + 1}
                    </div>
                    <button type="button" class="btn btn-danger btn-sm" onclick="deletePartner(${partner.id})">
                        <i class="bi bi-trash me-1"></i>
                        O'chirish
                    </button>
                </div>

                <div class="info-grid">
                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-building me-1 text-muted"></i>
                            Korxona to'liq nomi
                        </span>
                        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.company_name)}"
                            onchange="updatePartnerField(${partner.id}, 'company_name', this.value)">
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-card-text me-1 text-muted"></i>
                            INN
                        </span>
                        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.inn)}"
                            onchange="updatePartnerField(${partner.id}, 'inn', this.value)">
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-upc-scan me-1 text-muted"></i>
                            IFUT kodi
                        </span>
                        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.ifut || '')}"
                            onchange="updatePartnerField(${partner.id}, 'ifut', this.value)">
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-briefcase me-1 text-muted"></i>
                            Faoliyat turi
                        </span>
                        <select class="form-select form-select-sm" onchange="updatePartnerField(${partner.id}, 'type', this.value)">
                            <option value="MChJ" ${partner.type === 'MChJ' ? 'selected' : ''}>MChJ</option>
                            <option value="YaTT" ${partner.type === 'YaTT' ? 'selected' : ''}>YaTT</option>
                            <option value="QMJ" ${partner.type === 'QMJ' ? 'selected' : ''}>QMJ</option>
                            <option value="OAJ" ${partner.type === 'OAJ' ? 'selected' : ''}>OAJ</option>
                        </select>
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-geo-alt me-1 text-muted"></i>
                            Manzil
                        </span>
                        <textarea class="form-control form-control-sm" rows="2"
                            onchange="updatePartnerField(${partner.id}, 'address', this.value)">${uiEscapeHtml(partner.address || '')}</textarea>
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-person-badge me-1 text-muted"></i>
                            Direktor F.I.O.
                        </span>
                        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.director || '')}"
                            onchange="updatePartnerField(${partner.id}, 'director', this.value)">
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-telephone me-1 text-muted"></i>
                            Telefon raqami
                        </span>
                        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.phone || '')}"
                            onchange="updatePartnerField(${partner.id}, 'phone', this.value)">
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-envelope me-1 text-muted"></i>
                            Email
                        </span>
                        <input type="email" class="form-control form-control-sm" value="${uiEscapeHtml(partner.email || '')}"
                            onchange="updatePartnerField(${partner.id}, 'email', this.value)">
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-calendar-check me-1 text-muted"></i>
                            Ro'yxatdan o'tkazilgan sana
                        </span>
                        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.registration_date || '')}"
                            onchange="updatePartnerField(${partner.id}, 'registration_date', this.value)">
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-file-earmark-text me-1 text-muted"></i>
                            Ro'yxatdan o'tkazish raqami
                        </span>
                        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.registration_number || '')}"
                            onchange="updatePartnerField(${partner.id}, 'registration_number', this.value)">
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-building-check me-1 text-muted"></i>
                            Ro'yxatdan o'tkazuvchi tashkilot
                        </span>
                        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.registration_org || '')}"
                            onchange="updatePartnerField(${partner.id}, 'registration_org', this.value)">
                    </div>

                    <div class="info-row" id="partnerPassportRow_${partner.id}" style="display: ${partner.type === 'YaTT' ? 'grid' : 'none'}">
                        <span class="info-label">
                            <i class="bi bi-person-vcard me-1 text-muted"></i>
                            Pasport ma'lumoti
                        </span>
                        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.passport_data || '')}"
                            onchange="updatePartnerField(${partner.id}, 'passport_data', this.value)">
                    </div>

                    <div class="info-row" id="partnerPinflRow_${partner.id}" style="display: ${partner.type === 'YaTT' ? 'grid' : 'none'}">
                        <span class="info-label">
                            <i class="bi bi-fingerprint me-1 text-muted"></i>
                            JSHSHIR
                        </span>
                        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.pinfl || '')}"
                            onchange="updatePartnerField(${partner.id}, 'pinfl', this.value)">
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-toggle-on me-1 text-muted"></i>
                            Akkount holati
                        </span>
                        <select class="form-select form-select-sm" onchange="updatePartnerField(${partner.id}, 'account_status', this.value)">
                            <option value="active" ${partner.account_status === 'active' ? 'selected' : ''}>Faol</option>
                            <option value="blocked" ${partner.account_status === 'blocked' ? 'selected' : ''}>Bloklangan</option>
                        </select>
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-handshake me-1 text-muted"></i>
                            To'liq sheriklik holati sanasi
                        </span>
                        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.partnership_date || '')}"
                            onchange="updatePartnerField(${partner.id}, 'partnership_date', this.value)">
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-file-earmark-pdf me-1 text-muted"></i>
                            Investorlik sertifikati fayli
                        </span>
                        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(partner.investor_certificate || '')}"
                            onchange="updatePartnerField(${partner.id}, 'investor_certificate', this.value)">
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-cash-stack me-1 text-muted"></i>
                            Loyihadagi jami ulushi (summada)
                        </span>
                        <input type="number" class="form-control form-control-sm" value="${partner.share_amount || 0}"
                            onchange="updatePartnerField(${partner.id}, 'share_amount', Number(this.value))">
                    </div>

                    <div class="info-row">
                        <span class="info-label">
                            <i class="bi bi-percent me-1 text-muted"></i>
                            Loyihadagi jami ulushi (foizda)
                        </span>
                        <input type="number" class="form-control form-control-sm" value="${partner.share_percent || 0}"
                            min="0" max="100" step="0.1"
                            onchange="updatePartnerField(${partner.id}, 'share_percent', Number(this.value))">
                    </div>
                </div>
            </div>
        `).join('');
    }
}

function togglePartnersEdit() {
    partnersEditMode = !partnersEditMode;
    const btn = document.getElementById('togglePartnersEditBtn');
    const addBtn = document.getElementById('addPartnerBtn');

    btn.innerHTML = partnersEditMode ? 
        '<i class="bi bi-check-lg me-1"></i> Saqlash' : 
        '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';
    
    uiToggleEditButton(btn, partnersEditMode);
    if (addBtn) addBtn.style.display = partnersEditMode ? 'inline-flex' : 'none';

    displayPartners(projectData.partners || []);
}

function addNewPartner() {
    if (!projectData) return;
    if (!Array.isArray(projectData.partners)) projectData.partners = [];

    const newPartner = {
        id: nextPartnerId++,
        company_name: "Yangi sherik",
        inn: "",
        ifut: "",
        type: "MChJ",
        address: "",
        director: "",
        phone: "",
        email: "",
        registration_date: "",
        registration_number: "",
        registration_org: "",
        passport_data: "",
        pinfl: "",
        account_status: "active",
        partnership_date: "",
        investor_certificate: "",
        share_amount: 0,
        share_percent: 0
    };

    projectData.partners.push(newPartner);
    displayPartners(projectData.partners);
    showToast('Yangi sherik qo\'shildi', 'success');
}

function updatePartnerField(partnerId, field, value) {
    if (!projectData || !Array.isArray(projectData.partners)) return;
    const partner = projectData.partners.find(p => p.id === partnerId);
    if (!partner) return;

    partner[field] = value;

    // Agar faoliyat turi o'zgarsa, YaTT maydonlarini ko'rsatish/yashirish
    if (field === 'type') {
        const passportRow = document.getElementById(`partnerPassportRow_${partnerId}`);
        const pinflRow = document.getElementById(`partnerPinflRow_${partnerId}`);

        if (passportRow && pinflRow) {
            const showYaTTFields = value === 'YaTT';
            passportRow.style.display = showYaTTFields ? 'grid' : 'none';
            pinflRow.style.display = showYaTTFields ? 'grid' : 'none';
        }
    }
}

function deletePartner(partnerId) {
    if (!projectData || !Array.isArray(projectData.partners)) return;
    if (confirm('Bu sherikni o\'chirishni xohlaysizmi?')) {
        projectData.partners = projectData.partners.filter(p => p.id !== partnerId);
        displayPartners(projectData.partners);
        showToast('Sherik o\'chirildi', 'success');
    }
}