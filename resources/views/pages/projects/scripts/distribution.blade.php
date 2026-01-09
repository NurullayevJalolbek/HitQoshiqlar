// =================== DISTRIBUTION TAB SCRIPT ===================
// File: resources/views/pages/projects/scripts/distribution.blade.php

let distributionEditMode = false;
let distributionAllocations = [];

function displayDistribution(distribution) {
    if (!distribution) return;

    const content = document.getElementById('distributionContent');

    if (!distributionEditMode) {
        // View mode
        content.innerHTML = `
            ${distributionAllocations.length > 0 ? `
                <div class="mt-3">
                    <h6 class="mb-3" style="font-weight: 600; color: #1f2937;">Taqsimlangan ulushlar</h6>
                    ${distributionAllocations.map(alloc => `
                        <div class="allocation-item mb-2 p-3" style="background: #f9fafb; border-radius: 8px; border-left: 4px solid ${alloc.type === 'charity' ? '#ef4444' : alloc.type === 'partner' ? '#3b82f6' : '#10b981'};">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge ${alloc.type === 'charity' ? 'bg-danger' : alloc.type === 'partner' ? 'bg-primary' : 'bg-success'} me-2">
                                        ${alloc.type === 'charity' ? 'Xayriya' : alloc.type === 'partner' ? 'To\'liq sherik' : 'Kommanditchi'}
                                    </span>
                                    <strong>${alloc.name}</strong>
                                </div>
                                <span class="fs-5 fw-bold" style="color: ${alloc.type === 'charity' ? '#ef4444' : alloc.type === 'partner' ? '#3b82f6' : '#10b981'};">${alloc.percentage.toFixed(1)}%</span>
                            </div>
                        </div>
                    `).join('')}
                </div>
            ` : `
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Hozircha taqsimot qo'shilmagan. "Tahrirlash" tugmasini bosib, taqsimot qo'shing.
                </div>
            `}
        `;
    } else {
        // Edit mode
        const remainingPercentage = calculateRemainingPercentage();
        
        content.innerHTML = `
            <div class="mb-4 p-3" style="background: #f0f9ff; border-radius: 8px; border: 2px dashed #3b82f6;">
                <h6 class="mb-3" style="font-weight: 600; color: #1e40af;">
                    <i class="bi bi-plus-circle me-2"></i>Yangi taqsimot qo'shish
                </h6>
                
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Turi</label>
                        <select class="form-select" id="allocationType" onchange="handleAllocationTypeChange()">
                            <option value="">Tanlang...</option>
                            <option value="partner">To'liq sherik</option>
                            <option value="investor">Kommanditchi</option>
                            <option value="charity">Xayriya</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4" id="entitySelectWrapper" style="display: none;">
                        <label class="form-label fw-semibold">Tanlang</label>
                        <select class="form-select" id="entitySelect">
                            <option value="">Tanlang...</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4" id="charityInputWrapper" style="display: none;">
                        <label class="form-label fw-semibold">Xayriya nomi</label>
                        <input type="text" class="form-control" id="charityName" placeholder="Masalan: Mehribonlik fondi">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Ulush (%)</label>
                        <input type="number" min="0.1" max="${remainingPercentage}" step="0.1" 
                            class="form-control" id="allocationPercentage" 
                            placeholder="0.0"
                            oninput="validateAllocationPercentage(this)">
                        <small class="text-muted">Qolgan: ${remainingPercentage.toFixed(1)}%</small>
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-primary w-100" onclick="addAllocation()">
                            <i class="bi bi-plus-lg me-1"></i>Qo'shish
                        </button>
                    </div>
                </div>
            </div>

            ${distributionAllocations.length > 0 ? `
                <div class="mt-4">
                    <h6 class="mb-3" style="font-weight: 600; color: #1f2937;">
                        Taqsimlangan ulushlar
                        <span class="badge bg-secondary ms-2">${distributionAllocations.length}</span>
                    </h6>
                    ${distributionAllocations.map((alloc, index) => `
                        <div class="allocation-item mb-2 p-3" style="background: #f9fafb; border-radius: 8px; border-left: 4px solid ${alloc.type === 'charity' ? '#ef4444' : alloc.type === 'partner' ? '#3b82f6' : '#10b981'};">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="flex-grow-1">
                                    <span class="badge ${alloc.type === 'charity' ? 'bg-danger' : alloc.type === 'partner' ? 'bg-primary' : 'bg-success'} me-2">
                                        ${alloc.type === 'charity' ? 'Xayriya' : alloc.type === 'partner' ? 'To\'liq sherik' : 'Kommanditchi'}
                                    </span>
                                    <strong>${alloc.name}</strong>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <input type="number" min="0.1" max="100" step="0.1" 
                                        class="form-control form-control-sm" style="width: 90px;" 
                                        value="${alloc.percentage}"
                                        onchange="updateAllocationPercentage(${index}, parseFloat(this.value))">
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeAllocation(${index})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            ` : ''}

            <div class="alert alert-info mt-3" style="border-left: 4px solid #3b82f6;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong><i class="bi bi-pie-chart me-2"></i>Jami taqsimlangan:</strong> ${(100 - remainingPercentage).toFixed(1)}%
                    </div>
                    <div>
                        <strong><i class="bi bi-hourglass-split me-2"></i>Qolgan ulush:</strong> 
                        <span class="badge ${remainingPercentage > 0 ? 'bg-warning text-dark' : 'bg-success'} ms-2">
                            ${remainingPercentage.toFixed(1)}%
                        </span>
                    </div>
                </div>
            </div>
        `;
    }

    updateDistributionVisual();
}

function handleAllocationTypeChange() {
    const type = document.getElementById('allocationType').value;
    const entityWrapper = document.getElementById('entitySelectWrapper');
    const charityWrapper = document.getElementById('charityInputWrapper');
    const entitySelect = document.getElementById('entitySelect');

    entityWrapper.style.display = 'none';
    charityWrapper.style.display = 'none';
    entitySelect.innerHTML = '<option value="">Tanlang...</option>';

    if (type === 'charity') {
        charityWrapper.style.display = 'block';
    } else if (type === 'partner' || type === 'investor') {
        entityWrapper.style.display = 'block';
        
        // Load appropriate list
        if (type === 'partner' && projectData?.partners) {
            projectData.partners.forEach(partner => {
                const option = document.createElement('option');
                option.value = partner.id;
                option.textContent = partner.name || partner.full_name;
                entitySelect.appendChild(option);
            });
        } else if (type === 'investor' && projectData?.investors) {
            projectData.investors.forEach(investor => {
                const option = document.createElement('option');
                option.value = investor.id;
                option.textContent = investor.name || investor.full_name;
                entitySelect.appendChild(option);
            });
        }
    }
}

function calculateRemainingPercentage() {
    const totalAllocated = distributionAllocations.reduce((sum, alloc) => sum + alloc.percentage, 0);
    return Math.max(0, 100 - totalAllocated);
}

function validateAllocationPercentage(input) {
    const remaining = calculateRemainingPercentage();
    const value = parseFloat(input.value);
    
    if (value > remaining) {
        input.value = remaining.toFixed(1);
    }
    if (value < 0) {
        input.value = 0;
    }
}

function addAllocation() {
    const type = document.getElementById('allocationType').value;
    const percentage = parseFloat(document.getElementById('allocationPercentage').value);
    
    if (!type) {
        alert('Iltimos, turni tanlang!');
        return;
    }
    
    if (!percentage || percentage <= 0) {
        alert('Iltimos, to\'g\'ri ulush foizini kiriting!');
        return;
    }
    
    const remaining = calculateRemainingPercentage();
    if (percentage > remaining) {
        alert(`Faqat ${remaining.toFixed(1)}% qolgan!`);
        return;
    }
    
    let name = '';
    let entityId = null;
    
    if (type === 'charity') {
        name = document.getElementById('charityName').value.trim();
        if (!name) {
            alert('Iltimos, xayriya nomini kiriting!');
            return;
        }
    } else {
        const entitySelect = document.getElementById('entitySelect');
        entityId = entitySelect.value;
        name = entitySelect.options[entitySelect.selectedIndex].text;
        
        if (!entityId) {
            alert('Iltimos, tanlang!');
            return;
        }
        
        // Check if already allocated
        const exists = distributionAllocations.find(a => a.type === type && a.entityId === entityId);
        if (exists) {
            alert('Bu shaxs uchun allaqachon ulush ajratilgan!');
            return;
        }
    }
    
    distributionAllocations.push({
        type,
        entityId,
        name,
        percentage
    });
    
    // Reset form
    document.getElementById('allocationType').value = '';
    document.getElementById('allocationPercentage').value = '';
    document.getElementById('charityName').value = '';
    document.getElementById('entitySelectWrapper').style.display = 'none';
    document.getElementById('charityInputWrapper').style.display = 'none';
    
    displayDistribution(projectData.distribution);
    
    showToast('Ulush muvaffaqiyatli qo\'shildi!', 'success');
}

function removeAllocation(index) {
    if (confirm('Ushbu taqsimotni o\'chirmoqchimisiz?')) {
        distributionAllocations.splice(index, 1);
        displayDistribution(projectData.distribution);
        showToast('Ulush o\'chirildi', 'info');
    }
}

function updateAllocationPercentage(index, newValue) {
    if (newValue <= 0) {
        alert('Foiz 0 dan katta bo\'lishi kerak!');
        displayDistribution(projectData.distribution);
        return;
    }
    
    const allocation = distributionAllocations[index];
    const oldValue = allocation.percentage;
    
    // Calculate remaining without this allocation
    const otherAllocations = distributionAllocations.filter((_, i) => i !== index);
    const otherTotal = otherAllocations.reduce((sum, alloc) => sum + alloc.percentage, 0);
    
    if (otherTotal + newValue > 100) {
        alert('Jami 100% dan oshib ketdi! Qolgan: ' + (100 - otherTotal).toFixed(1) + '%');
        displayDistribution(projectData.distribution);
        return;
    }
    
    allocation.percentage = parseFloat(newValue.toFixed(1));
    displayDistribution(projectData.distribution);
    showToast('Ulush yangilandi!', 'success');
}

function updateDistributionVisual() {
    // Calculate totals for each type
    const partnerTotal = distributionAllocations
        .filter(a => a.type === 'partner')
        .reduce((sum, a) => sum + a.percentage, 0);
    
    const investorTotal = distributionAllocations
        .filter(a => a.type === 'investor')
        .reduce((sum, a) => sum + a.percentage, 0);
    
    const charityTotal = distributionAllocations
        .filter(a => a.type === 'charity')
        .reduce((sum, a) => sum + a.percentage, 0);

    const partnersSegment = document.getElementById('partnersSegment');
    const investorsSegment = document.getElementById('investorsSegment');
    const charitySegment = document.getElementById('charitySegment');
    const emptyDistribution = document.getElementById('emptyDistribution');

    const hasData = partnerTotal > 0 || investorTotal > 0 || charityTotal > 0;

    if (emptyDistribution) {
        emptyDistribution.style.display = hasData ? 'none' : 'flex';
    }

    if (partnersSegment && investorsSegment && charitySegment) {
        // Update widths
        partnersSegment.style.width = partnerTotal + '%';
        investorsSegment.style.width = investorTotal + '%';
        charitySegment.style.width = charityTotal + '%';
        
        // Update text based on width
        if (partnerTotal > 15) {
            partnersSegment.textContent = `Sheriklar: ${partnerTotal.toFixed(1)}%`;
        } else if (partnerTotal > 5) {
            partnersSegment.textContent = `${partnerTotal.toFixed(1)}%`;
        } else if (partnerTotal > 0) {
            partnersSegment.textContent = `${partnerTotal.toFixed(0)}`;
        } else {
            partnersSegment.textContent = '';
        }

        if (investorTotal > 15) {
            investorsSegment.textContent = `Kommanditchilar: ${investorTotal.toFixed(1)}%`;
        } else if (investorTotal > 5) {
            investorsSegment.textContent = `${investorTotal.toFixed(1)}%`;
        } else if (investorTotal > 0) {
            investorsSegment.textContent = `${investorTotal.toFixed(0)}`;
        } else {
            investorsSegment.textContent = '';
        }

        if (charityTotal > 15) {
            charitySegment.textContent = `Xayriya: ${charityTotal.toFixed(1)}%`;
        } else if (charityTotal > 5) {
            charitySegment.textContent = `${charityTotal.toFixed(1)}%`;
        } else if (charityTotal > 0) {
            charitySegment.textContent = `${charityTotal.toFixed(0)}`;
        } else {
            charitySegment.textContent = '';
        }
        
        // Hide segments with 0%
        partnersSegment.style.display = partnerTotal > 0 ? 'flex' : 'none';
        investorsSegment.style.display = investorTotal > 0 ? 'flex' : 'none';
        charitySegment.style.display = charityTotal > 0 ? 'flex' : 'none';
    }
}

function toggleDistributionEdit() {
    distributionEditMode = !distributionEditMode;
    const btn = document.getElementById('toggleDistributionEditBtn');
    btn.innerHTML = distributionEditMode ?
        '<i class="bi bi-check-lg me-1"></i> Saqlash' :
        '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';

    uiToggleEditButton(btn, distributionEditMode);

    if (!distributionEditMode) {
        // Save allocations to projectData
        if (projectData) {
            projectData.distributionAllocations = distributionAllocations;
        }
        showToast('Taqsimot saqlandi!', 'success');
    }

    if (projectData && projectData.distribution) {
        displayDistribution(projectData.distribution);
    }
}

// Helper function for toast notifications
function showToast(message, type = 'info') {
    console.log(`[${type.toUpperCase()}] ${message}`);
}