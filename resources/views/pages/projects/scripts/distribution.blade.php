// =================== DISTRIBUTION TAB SCRIPT ===================
// File: resources/views/pages/projects/scripts/distribution.blade.php

let distributionEditMode = false;

function displayDistribution(distribution) {
    if (!distribution) return;

    const content = document.getElementById('distributionContent');

    if (!distributionEditMode) {
        content.innerHTML = `
            <div class="info-row">
                <span class="info-label">To'liq sherikning investitsion loyihadagi o'ziga tegishli ulushining realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                <span class="info-value" id="fullPartnerOwnShare">${distribution.full_partner_own_share}%</span>
            </div>
            <div class="info-row">
                <span class="info-label">To'liq sherikning investitsion Kommanditchilarning loyihadagi tegishli ulushining realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                <span class="info-value" id="fullPartnerInvestorShare">${distribution.full_partner_investor_share}%</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kommanditchilarning investitsion loyihadagi o'ziga tegishli ulushining realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                <span class="info-value" id="investorsOwnShare">${distribution.investors_own_share}%</span>
            </div>
        `;
    } else {
        content.innerHTML = `
            <div class="info-row">
                <span class="info-label">To'liq sherikning investitsion loyihadagi o'ziga tegishli ulushining realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                <div class="d-flex align-items-center gap-2">
                    <input type="number" min="0" max="100" step="0.1" class="form-control form-control-sm" style="max-width: 120px;" 
                        value="${distribution.full_partner_own_share}" disabled>
                    <span class="text-muted">%</span>
                </div>
            </div>
            <div class="info-row">
                <span class="info-label">To'liq sherikning investitsion Kommanditchilarning loyihadagi tegishli ulushining realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                <div class="d-flex align-items-center gap-2">
                    <input type="number" min="0" max="100" step="0.1" class="form-control form-control-sm" style="max-width: 120px;" 
                        value="${distribution.full_partner_investor_share}"
                        onchange="updateDistributionField('full_partner_investor_share', Number(this.value) || 0)">
                    <span class="text-muted">%</span>
                </div>
            </div>
            <div class="info-row">
                <span class="info-label">Kommanditchilarning investitsion loyihadagi o'ziga tegishli ulushining realizatsiyasidan kutilayotgan sof foyda/zarardan oladigan qiymati (foizda)</span>
                <div class="d-flex align-items-center gap-2">
                    <input type="number" min="0" max="100" step="0.1" class="form-control form-control-sm" style="max-width: 120px;" 
                        value="${distribution.investors_own_share}" disabled>
                    <span class="text-muted">%</span>
                </div>
            </div>
        `;
    }

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

    uiToggleEditButton(btn, distributionEditMode);

    if (projectData && projectData.distribution) {
        displayDistribution(projectData.distribution);
    }
}

function updateDistributionField(field, value) {
    if (!projectData || !projectData.distribution) return;
    if (field !== 'full_partner_investor_share') return;

    if (value < 0) value = 0;
    if (value > 100) value = 100;

    projectData.distribution[field] = value;
    projectData.distribution.investors_own_share = 100 - value;

    displayDistribution(projectData.distribution);
}