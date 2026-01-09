// =================== DISTRIBUTION TAB SCRIPT ===================
// File: resources/views/pages/projects/scripts/distribution.blade.php

let distributionEditMode = false;
let distributionAllocations = [];

// Initialize with default allocations
function initializeDefaultAllocations() {
    if (distributionAllocations.length === 0) {
        // Default: 50% partners, 45% investors, 5% charity
        distributionAllocations = [
            {
                type: 'partner',
                entityId: null,
                name: 'To\'liq sheriklar',
                percentage: 50,
                description: 'Boshqaruvda ishtirok etuvchi sheriklar',
                isDefault: true
            },
            {
                type: 'investor',
                entityId: null,
                name: 'Kommanditchilar',
                percentage: 45,
                description: 'Faqat moliyaviy hissa qo\'shuvchi investorlar',
                isDefault: true
            },
            {
                type: 'charity',
                entityId: null,
                name: 'Xayriya',
                percentage: 5,
                description: 'Ijtimoiy mas\'uliyat uchun ajratilgan ulush',
                isDefault: true
            }
        ];
    }
}

function displayDistribution(distribution) {
    const content = document.getElementById('distributionContent');

    if (!distributionEditMode) {
        // View mode - Card Style
        content.innerHTML = `
            ${distributionAllocations.length > 0 ? `
                <div class="mt-3">
                    <h6 class="mb-3" style="font-weight: 600; color: #1f2937;">
                        <i class="bi bi-list-check me-2"></i>Taqsimlangan ulushlar
                    </h6>
                    <div class="row g-3">
                        ${distributionAllocations.map((alloc, index) => `
                            <div class="col-12">
                                <div class="card border-0 shadow-sm" style="border-left: 4px solid ${alloc.type === 'charity' ? '#ef4444' : alloc.type === 'partner' ? '#3b82f6' : '#10b981'} !important;">
                                    <div class="card-body py-3 px-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center gap-3 flex-grow-1">
                                                <div class="badge-circle" style="
                                                    width: 40px;
                                                    height: 40px;
                                                    border-radius: 8px;
                                                    background: ${alloc.type === 'charity' ? '#fee2e2' : alloc.type === 'partner' ? '#dbeafe' : '#d1fae5'};
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    font-weight: 700;
                                                    color: ${alloc.type === 'charity' ? '#ef4444' : alloc.type === 'partner' ? '#3b82f6' : '#10b981'};
                                                ">
                                                    #${index + 1}
                                                </div>
                                                <div>
                                                    <div class="fw-bold" style="font-size: 15px; color: #1f2937;">
                                                        ${alloc.name}
                                                    </div>
                                                    <div class="mt-1">
                                                        <!-- <span class="badge ${alloc.type === 'charity' ? 'bg-danger' : alloc.type === 'partner' ? 'bg-primary' : 'bg-success'}" style="font-size: 11px; padding: 4px 8px;">
                                                            ${alloc.type === 'charity' ? 'Xayriya' : alloc.type === 'partner' ? 'Sherik' : 'Kommanditchi'}
                                                        </span> -->
                                                        ${alloc.description ? `<div class="text-muted small mt-1">${alloc.description}</div>` : ''}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <div class="fw-bold" style="font-size: 24px; color: ${alloc.type === 'charity' ? '#ef4444' : alloc.type === 'partner' ? '#3b82f6' : '#10b981'};">
                                                    ${alloc.percentage.toFixed(1)}%
                                                </div>
                                                <div class="text-muted small">Minimal ulush</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                    
                    <!-- Total Summary Card -->
                    <div class="card border-0 mt-3" style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);">
                        <div class="card-body py-3 px-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="fw-bold" style="font-size: 16px; color: #374151;">
                                    <i class="bi bi-calculator me-2"></i>JAMI TAQSIMLANGAN
                                </div>
                                <div class="fw-bold" style="font-size: 24px; color: #1f2937;">
                                    ${distributionAllocations.reduce((sum, a) => sum + a.percentage, 0).toFixed(1)}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ` : `
                <div class="alert alert-info border-0" style="background: #e0f2fe;">
                    <i class="bi bi-info-circle me-2"></i>
                    Hozircha taqsimot qo'shilmagan. "Tahrirlash" tugmasini bosib, taqsimot qo'shing.
                </div>
            `}
        `;
    } else {
        // Edit mode
        const remainingPercentage = calculateRemainingPercentage();
        
        content.innerHTML = `
            <div class="mb-4 p-4" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 12px; border: 2px solid #3b82f6;">
                <h6 class="mb-3" style="font-weight: 600; color: #1e40af;">
                    <i class="bi bi-plus-circle-fill me-2"></i>Yangi ulush qo'shish
                </h6>
                
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-muted">TURI</label>
                        <select class="form-select select2-with-icon" id="allocationType" 
                                onchange="handleAllocationTypeChange()" 
                                data-allow-clear="true">
                            <option value="">Tanlang...</option>
                            <option value="partner">To'liq sherik</option>
                            <option value="investor">Kommanditchi</option>
                            <option value="charity">Xayriya</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4" id="entitySelectWrapper" style="display: none;">
                        <label class="form-label fw-semibold small text-muted">SHAXS</label>
                        <select class="form-select select2-with-icon" id="entitySelect" 
                                data-allow-clear="true">
                            <option value="">Tanlang...</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4" id="charityInputWrapper" style="display: none;">
                        <label class="form-label fw-semibold small text-muted">XAYRIYA NOMI</label>
                        <input type="text" class="form-control" id="charityName" placeholder="Masalan: Mehribonlik fondi">
                    </div>
                    
                    <div class="col-md-4" id="descriptionWrapper" style="display: none;">
                        <label class="form-label fw-semibold small text-muted">TAVSIF</label>
                        <input type="text" class="form-control" id="allocationDescription" placeholder="Qisqacha tavsif...">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small text-muted">ULUSH (%)</label>
                        <input type="number" min="0.1" max="${remainingPercentage}" step="0.1" 
                            class="form-control" id="allocationPercentage" 
                            placeholder="0.0"
                            oninput="validateAllocationPercentage(this)">
                        <small class="text-muted d-block mt-1">
                            <i class="bi bi-info-circle me-1"></i>Qolgan: <strong>${remainingPercentage.toFixed(1)}%</strong>
                        </small>
                    </div>
                    
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-primary w-100" onclick="addAllocation()" style="height: 38px;">
                            <i class="bi bi-plus-lg me-1"></i>Qo'shish
                        </button>
                    </div>
                </div>
            </div>

            ${distributionAllocations.length > 0 ? `
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0" style="font-weight: 600; color: #1f2937;">
                            <i class="bi bi-list-ul me-2"></i>Taqsimlangan ulushlar
                        </h6>
                        <!-- <span class="badge bg-secondary">${distributionAllocations.length} ta</span> -->
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table-dark">
                            <thead class="table-dark">
                                <tr>
                                    <th>Turi</th>
                                    <th>Nomi</th>
                                    <th>Ulush (%)</th>
                                    <th class="text-end">Amallar</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${distributionAllocations.map((alloc, index) => `
                                    <tr>
                                        <td>
                                            <!-- <span class="badge ${alloc.type === 'charity' ? 'bg-danger' : alloc.type === 'partner' ? 'bg-primary' : 'bg-success'}">
                                                ${alloc.type === 'charity' ? 'Xayriya' : alloc.type === 'partner' ? 'Sherik' : 'Kommandit'}
                                            </span> -->
                                        </td>
                                        <td>
                                            <strong>${alloc.name}</strong>
                                            ${alloc.isDefault}
                                        </td>
                                        <td>
                                            <input type="number" min="0.1" max="100" step="0.1" 
                                                class="form-control form-control-sm" style="width: 100px;" 
                                                value="${alloc.percentage}"
                                                onchange="updateAllocationPercentage(${index}, parseFloat(this.value))">
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="removeAllocation(${index})"
                                                ${alloc.isDefault ? 'title="Standart taqsimotni o\'chirib bo\'lmaydi"' : ''}>
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `).join('')}
                                <tr class="table-dark border-top-2">
                                    <td colspan="2" class="fw-bold">JAMI TAQSIMLANGAN</td>
                                    <td colspan="2">
                                        <!-- <span class="badge ${remainingPercentage > 0 ? 'bg-warning text-dark' : 'bg-success'} fs-6">
                                            ${(100 - remainingPercentage).toFixed(1)}%
                                        </span> -->
                                        ${remainingPercentage > 0 ? `
                                            <span class="ms-3 text-muted">
                                                <i class="bi bi-hourglass-split me-1"></i>Qolgan: <strong>${remainingPercentage.toFixed(1)}%</strong>
                                            </span>
                                        ` : ''}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            ` : ''}
        `;
    }

    updateDistributionVisual();
}

function handleAllocationTypeChange() {
    const type = document.getElementById('allocationType').value;
    const entityWrapper = document.getElementById('entitySelectWrapper');
    const charityWrapper = document.getElementById('charityInputWrapper');
    const descriptionWrapper = document.getElementById('descriptionWrapper');
    const entitySelect = document.getElementById('entitySelect');

    entityWrapper.style.display = 'none';
    charityWrapper.style.display = 'none';
    descriptionWrapper.style.display = 'none';
    
    // Destroy Select2 if exists
    if ($(entitySelect).hasClass("select2-hidden-accessible")) {
        $(entitySelect).select2('destroy');
    }
    
    entitySelect.innerHTML = '<option value="">Tanlang...</option>';

    if (type === 'charity') {
        charityWrapper.style.display = 'block';
        descriptionWrapper.style.display = 'block';
    } else if (type === 'partner' || type === 'investor') {
        entityWrapper.style.display = 'block';
        descriptionWrapper.style.display = 'block';
        
        // Load appropriate list from backend via AJAX
        loadEntities(type, entitySelect);
    }
}

// Function to load partners or investors
function loadEntities(type, selectElement) {
    // Show loading state
    selectElement.innerHTML = '<option value="">Yuklanmoqda...</option>';
    
    // Get project ID from page
    const projectId = window.projectId || document.querySelector('[data-project-id]')?.dataset.projectId;
    
    if (!projectId) {
        console.error('Project ID not found');
        loadFallbackData(type, selectElement);
        return;
    }
    
    // Determine endpoint based on type
    const endpoint = type === 'partner' ? `/api/projects/${projectId}/partners` : `/api/projects/${projectId}/investors`;
    
    // Fetch data
    fetch(endpoint)
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            selectElement.innerHTML = '<option value="">Tanlang...</option>';
            
            const entities = data.data || data;
            
            if (entities && entities.length > 0) {
                entities.forEach(entity => {
                    const option = document.createElement('option');
                    option.value = entity.id;
                    option.textContent = entity.name || entity.full_name || entity.first_name + ' ' + entity.last_name;
                    selectElement.appendChild(option);
                });
            } else {
                selectElement.innerHTML = '<option value="">Ma\'lumot topilmadi</option>';
            }
            
            // Initialize Select2
            initializeSelect2(selectElement);
        })
        .catch(error => {
            console.error('Error loading entities:', error);
            loadFallbackData(type, selectElement);
        });
}

// Fallback function to load data from projectData or demo data
function loadFallbackData(type, selectElement) {
    selectElement.innerHTML = '<option value="">Tanlang...</option>';
    
    // Try projectData first
    if (type === 'partner' && projectData?.partners && projectData.partners.length > 0) {
        projectData.partners.forEach(partner => {
            const option = document.createElement('option');
            option.value = partner.id;
            option.textContent = partner.name || partner.full_name;
            selectElement.appendChild(option);
        });
    } else if (type === 'investor' && projectData?.investors && projectData.investors.length > 0) {
        projectData.investors.forEach(investor => {
            const option = document.createElement('option');
            option.value = investor.id;
            option.textContent = investor.name || investor.full_name;
            selectElement.appendChild(option);
        });
    } else {
        // Use demo data
        const demoData = getDemoData(type);
        demoData.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.name;
            selectElement.appendChild(option);
        });
    }
    
    initializeSelect2(selectElement);
}

// Demo data for testing
function getDemoData(type) {
    if (type === 'partner') {
        return [
            { id: 1, name: 'Alisher Karimov' },
            { id: 2, name: 'Dilshod Rahimov' },
            { id: 3, name: 'Sardor Mahmudov' }
        ];
    } else if (type === 'investor') {
        return [
            { id: 1, name: 'Nodira Yusupova' },
            { id: 2, name: 'Jamshid Toshmatov' },
            { id: 3, name: 'Gulnora Azimova' },
            { id: 4, name: 'Rustam Ismoilov' }
        ];
    }
    return [];
}

// Initialize Select2 with your styling
function initializeSelect2(element) {
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $(element).select2({
            placeholder: 'Tanlang...',
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "Natija topilmadi";
                },
                searching: function() {
                    return "Qidirilmoqda...";
                }
            }
        });
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
    const description = document.getElementById('allocationDescription').value.trim();
    
    if (!type) {
        alert('⚠️ Iltimos, turni tanlang!');
        return;
    }
    
    if (!percentage || percentage <= 0) {
        alert('⚠️ Iltimos, to\'g\'ri ulush foizini kiriting!');
        return;
    }
    
    const remaining = calculateRemainingPercentage();
    if (percentage > remaining) {
        alert(`⚠️ Faqat ${remaining.toFixed(1)}% qolgan!`);
        return;
    }
    
    let name = '';
    let entityId = null;
    
    if (type === 'charity') {
        name = document.getElementById('charityName').value.trim();
        if (!name) {
            alert('⚠️ Iltimos, xayriya nomini kiriting!');
            return;
        }
    } else {
        const entitySelect = document.getElementById('entitySelect');
        entityId = entitySelect.value;
        name = entitySelect.options[entitySelect.selectedIndex].text;
        
        if (!entityId) {
            alert('⚠️ Iltimos, shaxsni tanlang!');
            return;
        }
        
        // Check if already allocated
        const exists = distributionAllocations.find(a => a.type === type && a.entityId === entityId);
        if (exists) {
            alert('⚠️ Bu shaxs uchun allaqachon ulush ajratilgan!');
            return;
        }
    }
    
    distributionAllocations.push({
        type,
        entityId,
        name,
        percentage,
        description: description || null,
        isDefault: false
    });
    
    // Reset form
    document.getElementById('allocationType').value = '';
    document.getElementById('allocationPercentage').value = '';
    document.getElementById('allocationDescription').value = '';
    document.getElementById('charityName').value = '';
    document.getElementById('entitySelectWrapper').style.display = 'none';
    document.getElementById('charityInputWrapper').style.display = 'none';
    document.getElementById('descriptionWrapper').style.display = 'none';
    
    displayDistribution(projectData?.distribution);
    
    showToast('✅ Ulush muvaffaqiyatli qo\'shildi!', 'success');
}

function removeAllocation(index) {
    const allocation = distributionAllocations[index];
    
    // Prevent removing default allocations
    if (allocation.isDefault) {
        alert('⚠️ Standart taqsimotni o\'chirib bo\'lmaydi! Faqat foizini o\'zgartiring.');
        return;
    }
    
    if (confirm('Ushbu taqsimotni o\'chirmoqchimisiz?')) {
        distributionAllocations.splice(index, 1);
        displayDistribution(projectData?.distribution);
        showToast('🗑️ Ulush o\'chirildi', 'info');
    }
}

function updateAllocationPercentage(index, newValue) {
    if (newValue <= 0) {
        alert('⚠️ Foiz 0 dan katta bo\'lishi kerak!');
        displayDistribution(projectData?.distribution);
        return;
    }
    
    const allocation = distributionAllocations[index];
    const oldValue = allocation.percentage;
    
    // Calculate remaining without this allocation
    const otherAllocations = distributionAllocations.filter((_, i) => i !== index);
    const otherTotal = otherAllocations.reduce((sum, alloc) => sum + alloc.percentage, 0);
    
    if (otherTotal + newValue > 100) {
        alert(`⚠️ Jami 100% dan oshib ketdi! Qolgan: ${(100 - otherTotal).toFixed(1)}%`);
        displayDistribution(projectData?.distribution);
        return;
    }
    
    allocation.percentage = parseFloat(newValue.toFixed(1));
    displayDistribution(projectData?.distribution);
    showToast('✅ Ulush yangilandi!', 'success');
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
    
    if (distributionEditMode) {
        btn.innerHTML = '<i class="bi bi-check-lg me-1"></i> Saqlash';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');
    } else {
        btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';
        btn.classList.remove('btn-success');
        btn.classList.add('btn-outline-secondary');
        
        // Save allocations to backend
        saveDistributionToBackend();
    }

    displayDistribution(projectData?.distribution);
}

// Save distribution to backend
function saveDistributionToBackend() {
    const projectId = window.projectId || document.querySelector('[data-project-id]')?.dataset.projectId;
    
    if (!projectId) {
        console.error('Project ID not found');
        showToast('⚠️ Xatolik: Project ID topilmadi', 'error');
        return;
    }
    
    // Show loading state
    const btn = document.getElementById('toggleDistributionEditBtn');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saqlanmoqda...';
    
    fetch(`/api/projects/${projectId}/distribution`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: JSON.stringify({
            allocations: distributionAllocations
        })
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showToast('💾 Taqsimot muvaffaqiyatli saqlandi!', 'success');
            
            // Update projectData if exists
            if (projectData) {
                projectData.distributionAllocations = distributionAllocations;
            }
        } else {
            throw new Error(data.message || 'Xatolik yuz berdi');
        }
    })
    .catch(error => {
        console.error('Error saving distribution:', error);
        showToast('⚠️ Xatolik: ' + error.message, 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

// Helper function for toast notifications
function showToast(message, type = 'info') {
    console.log(`[${type.toUpperCase()}] ${message}`);
    // You can integrate with your existing toast/notification system here
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Initialize default allocations
    initializeDefaultAllocations();
    
    // Initialize Select2 for allocation type
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('#allocationType').select2({
            placeholder: 'Tanlang...',
            allowClear: true,
            width: '100%'
        });
    }
    
    // Display initial distribution
    if (projectData) {
        displayDistribution(projectData.distribution);
    }
    
    // Store project ID globally
    const projectIdElement = document.querySelector('[data-project-id]');
    if (projectIdElement) {
        window.projectId = projectIdElement.dataset.projectId;
    }
});

// Function to be called when tab is activated
function initDistributionTab() {
    initializeDefaultAllocations();
    displayDistribution(projectData?.distribution);
    
    // Re-initialize Select2 if needed
    if (typeof $ !== 'undefined' && $.fn.select2) {
        if (!$('#allocationType').hasClass("select2-hidden-accessible")) {
            $('#allocationType').select2({
                placeholder: 'Tanlang...',
                allowClear: true,
                width: '100%'
            });
        }
    }
}