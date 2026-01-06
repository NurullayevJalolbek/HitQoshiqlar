{{--
    Risk management partial.

    This partial defines functions to display and edit the risk information
    (management model and risk level) as well as the list of individual risk
    items. It overrides any earlier risk-related functions defined in the
    main project scripts. The functions here rely on global variables such
    as `projectData`, `risksInfoEditMode`, `risksListEditMode`, and
    `dragRiskIndex` which are assumed to be declared elsewhere. Fallback
    assignments are applied in case they are undefined.
--}}

// Fallback assignments for risk-related state. These variables may already
// be defined by the main script. If not, initialise them here.
if (typeof risksInfoEditMode === 'undefined') {
    risksInfoEditMode = false;
}
if (typeof risksListEditMode === 'undefined') {
    risksListEditMode = false;
}
if (typeof dragRiskIndex === 'undefined') {
    dragRiskIndex = null;
}

// Toggle editing state for risk information (management model and level)
function toggleRisksInfoEdit() {
    risksInfoEditMode = !risksInfoEditMode;
    const btn = document.getElementById('toggleRisksInfoEditBtn');
    if (btn) {
        btn.innerHTML = risksInfoEditMode
            ? '<i class="bi bi-check-lg me-1"></i> Saqlash'
            : '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';
        btn.classList.toggle('btn-success', risksInfoEditMode);
        btn.classList.toggle('btn-outline-secondary', !risksInfoEditMode);
    }

    // If leaving edit mode ensure priorities are sorted
    if (!risksInfoEditMode && projectData && projectData.risks) {
        uiEnsurePriority(projectData.risks.risk_items || [], 'priority');
    }

    displayRisks(projectData?.risks);
}

// Toggle editing state for risk items list
function toggleRisksListEdit() {
    risksListEditMode = !risksListEditMode;
    const btn = document.getElementById('toggleRisksListEditBtn');
    if (btn) {
        btn.innerHTML = risksListEditMode
            ? '<i class="bi bi-check-lg me-1"></i> Saqlash'
            : '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';
        btn.classList.toggle('btn-success', risksListEditMode);
        btn.classList.toggle('btn-outline-secondary', !risksListEditMode);
    }

    // When leaving edit mode, sort by priority
    if (!risksListEditMode && projectData && projectData.risks) {
        uiEnsurePriority(projectData.risks.risk_items || [], 'priority');
    }
    displayRisks(projectData?.risks);
}

// Delete a risk item by index. After deletion the list is re-rendered.
function deleteRiskByIndex(idx) {
    if (!projectData || !projectData.risks || !Array.isArray(projectData.risks.risk_items)) return;
    projectData.risks.risk_items.splice(idx, 1);
    // Renumber priorities
    uiEnsurePriority(projectData.risks.risk_items, 'priority');
    displayRisks(projectData.risks);
}

// Drag event handlers for reordering risk items
function onRiskDragStart(event) {
    const idx = Number(event.currentTarget.dataset.index);
    dragRiskIndex = isNaN(idx) ? null : idx;
    event.dataTransfer.effectAllowed = 'move';
}

function onRiskDragOver(event) {
    event.preventDefault();
}

function onRiskDrop(event) {
    event.preventDefault();
    const targetIndex = Number(event.currentTarget.dataset.index);
    if (dragRiskIndex === null || targetIndex === dragRiskIndex) return;
    if (!projectData || !projectData.risks || !Array.isArray(projectData.risks.risk_items)) return;

    const items = projectData.risks.risk_items;
    const moved = items.splice(dragRiskIndex, 1)[0];
    items.splice(targetIndex, 0, moved);
    // Reassign priorities and reset index
    uiEnsurePriority(items, 'priority');
    dragRiskIndex = null;
    displayRisks(projectData.risks);
}

// Render risk information and list. This function adapts to edit/view modes.
function displayRisks(risks) {
    if (!risks) return;

    // Render management model, descriptions and level
    const infoGrid = document.getElementById('risksInfoContent');
    if (infoGrid) {
        // Map risk levels to badge text and CSS class
        const riskMap = {
            low:    { text: 'Past',  class: 'status-active' },
            medium: { text: "O'rta", class: 'status-planned' },
            high:   { text: 'Yuqori',class: 'status-inactive' }
        };
        const riskMeta = riskMap[risks.risk_level] || { text: '-', class: 'status-inactive' };

        const modelVal = risks.management_model ?? '';
        const descVal  = risks.management_desc ?? risks.management_description ?? '';
        const infoVal  = risks.management_info ?? '';
        const levelVal = risks.risk_level ?? 'low';

        if (!risksInfoEditMode) {
            infoGrid.innerHTML = `
                <div class="info-item">
                    <div class="info-label">Boshqarilish modeli nomi</div>
                    <div class="info-value">${uiEscapeHtml(modelVal || '-')}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Boshqarilish modeli qisqacha tavsifi</div>
                    <div class="info-value">${uiEscapeHtml(descVal || '-')}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Boshqarilish modeli haqida ma’lumot</div>
                    <div class="info-value">${uiEscapeHtml(infoVal || '-')}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Xatar darajasi</div>
                    <div class="info-value"><span class="status-badge ${riskMeta.class}">${riskMeta.text}</span></div>
                </div>
            `;
        } else {
            infoGrid.innerHTML = `
                <div class="info-item">
                    <div class="info-label">Boshqarilish modeli nomi</div>
                    <div class="info-value">
                        <input type="text" class="form-control form-control-sm"
                               value="${uiEscapeHtml(modelVal)}"
                               oninput="projectData.risks.management_model = this.value">
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Boshqarilish modeli qisqacha tavsifi</div>
                    <div class="info-value">
                        <textarea class="form-control form-control-sm" rows="2"
                                  oninput="projectData.risks.management_desc = this.value">${uiEscapeHtml(descVal)}</textarea>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Boshqarilish modeli haqida ma’lumot</div>
                    <div class="info-value">
                        <textarea class="form-control form-control-sm" rows="3"
                                  oninput="projectData.risks.management_info = this.value">${uiEscapeHtml(infoVal)}</textarea>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Xatar darajasi</div>
                    <div class="info-value">
                        <select class="form-select form-select-sm"
                                onchange="projectData.risks.risk_level = this.value">
                            <option value="low" ${levelVal === 'low' ? 'selected' : ''}>Past</option>
                            <option value="medium" ${levelVal === 'medium' ? 'selected' : ''}>O'rta</option>
                            <option value="high" ${levelVal === 'high' ? 'selected' : ''}>Yuqori</option>
                        </select>
                    </div>
                </div>
            `;
        }
    }

    // Render risk items list
    const container = document.getElementById('risksContainer');
    if (!container) return;

    const items = Array.isArray(risks.risk_items) ? risks.risk_items : [];
    if (items.length === 0) {
        container.innerHTML = '<p class="text-muted text-center py-4">Xatarlar mavjud emas</p>';
        return;
    }
    // Ensure ids and priorities are correct
    uiEnsureRiskIds(items);
    uiEnsurePriority(items, 'priority');

    if (!risksListEditMode) {
        container.innerHTML = items
            .map(r => `
                <div class="risk-item">
                    <div class="risk-title" style="display:flex; align-items:center; gap:.5rem;">
                        <span class="priority-pill">#${r.priority}</span>
                        <i class="bi bi-exclamation-triangle"></i>
                        ${uiEscapeHtml(r.name)}
                    </div>
                    <p class="risk-description">${uiEscapeHtml(r.description)}</p>
                </div>
            `).join('');
    } else {
        container.innerHTML = items
            .map((r, index) => `
                <div class="risk-item draggable-risk"
                     draggable="true"
                     data-index="${index}"
                     ondragstart="onRiskDragStart(event)"
                     ondragover="onRiskDragOver(event)"
                     ondrop="onRiskDrop(event)">
                    <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-grip-vertical text-muted"></i>
                            <strong class="priority-pill">#${index + 1}</strong>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm"
                                onclick="deleteRiskByIndex(${index})">
                            <i class="bi bi-trash me-1"></i>
                            O'chirish
                        </button>
                    </div>
                    <label class="form-label small mb-1">Xatar nomi</label>
                    <input type="text" class="form-control form-control-sm mb-2"
                           value="${uiEscapeHtml(r.name)}"
                           oninput="projectData.risks.risk_items[${index}].name = this.value">
                    <label class="form-label small mb-1">Xatar tavsifi</label>
                    <textarea class="form-control form-control-sm" rows="3"
                              oninput="projectData.risks.risk_items[${index}].description = this.value">${uiEscapeHtml(r.description)}</textarea>
                </div>
            `).join('');
    }
}