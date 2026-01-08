// =================== STAGES TAB SCRIPT ===================
// File: resources/views/pages/projects/scripts/stages.blade.php

let stagesEditMode = false;
let nextStageId = 7;
let stageInsertAfterId = '';
let dragStageId = null;

function displayStages(stages) {
if (!Array.isArray(stages)) stages = [];
if (projectData && Array.isArray(projectData.stages)) {
uiEnsurePriority(projectData.stages, 'order');
stages = projectData.stages;
} else {
uiEnsurePriority(stages, 'order');
}

const totalProgress = stages.reduce((sum, stage) => {
return sum + (stage.status === 'completed' ? (Number(stage.progress) || 0) : 0);
}, 0);

const progressBar = document.getElementById('progressBar');
const progressBarLabel = document.getElementById('progressBarLabel');

const progress = Math.min(100, Math.max(0, totalProgress));
if (progressBar) progressBar.style.width = progress + '%';
if (progressBarLabel) progressBarLabel.textContent = progress + '%';
if (progressBar && !progressBarLabel) progressBar.textContent = progress + '%';

const timeline = document.getElementById('timeline');
timeline.innerHTML = '';

const statusMap = {
'completed': { icon: 'bi-check-circle', badgeClass: 'badge-stage-status badge-stage-completed', text: 'Bajarildi' },
'in_progress': { icon: 'bi-arrow-clockwise', badgeClass: 'badge-stage-status badge-stage-in-progress', text: 'Jarayonda'
},
'planned': { icon: 'bi-circle', badgeClass: 'badge-stage-status badge-stage-planned', text: 'Rejalashtirilgan' }
};

stages.forEach((stage, index) => {
const status = statusMap[stage.status] || statusMap.planned;
const itemEl = document.createElement('div');
itemEl.className = 'list-group-item border-0 stage-item';
itemEl.setAttribute('data-stage-id', stage.id);

if (!stagesEditMode) {
itemEl.innerHTML = `
<div class="row ps-lg-1 align-items-center">
    <div class="col-auto">
        <div class="${status.badgeClass}">
            <i class="${status.icon}"></i>
            ${status.text}
        </div>
    </div>
    <div class="col ms-n2 mb-2">
        <h3 class="fs-6 fw-bold mb-1">${stage.name}</h3>
        <div class="d-flex align-items-center small text-muted">
            <i class="bi bi-calendar3 me-1"></i>
            <span>${stage.start_date} - ${stage.end_date}</span>
        </div>
    </div>
    <div class="col-auto">
        <span class="badge bg-white text-dark">${Number(stage.progress) || 0}%</span>
    </div>
</div>
`;
} else {
itemEl.setAttribute('draggable', 'true');
itemEl.setAttribute('ondragstart', `onStageDragStart(event, ${stage.id})`);
itemEl.setAttribute('ondragover', `onStageDragOver(event, ${stage.id})`);
itemEl.setAttribute('ondragleave', `onStageDragLeave(event, ${stage.id})`);
itemEl.setAttribute('ondrop', `onStageDrop(event, ${stage.id})`);

itemEl.innerHTML = `
<div class="row ps-lg-1 align-items-start gy-2">
    <div class="col-auto">
        <div class="drag-handle" title="Joyini o'zgartirish">
            <i class="bi bi-grip-vertical"></i>
        </div>
    </div>
    <div class="col-auto">
        <span class="priority-pill">#${stage.order}</span>
    </div>
    <div class="col-12 col-md-4">
        <label class="form-label small mb-1">Bosqich nomi</label>
        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(stage.name)}"
            onchange="updateStageField(${stage.id}, 'name', this.value)">
    </div>
    <div class="col-6 col-md-3">
        <label class="form-label small mb-1">Holati</label>
        <select class="form-select form-select-sm" onchange="updateStageField(${stage.id}, 'status', this.value)">
            <option value="planned" ${stage.status==='planned' ? 'selected' : '' }>Rejalashtirilgan</option>
            <option value="in_progress" ${stage.status==='in_progress' ? 'selected' : '' }>Jarayonda</option>
            <option value="completed" ${stage.status==='completed' ? 'selected' : '' }>Bajarildi</option>
        </select>
    </div>
    <div class="col-6 col-md-2">
        <label class="form-label small mb-1">% bajarilgan</label>
        <input type="number" min="0" max="100" class="form-control form-control-sm"
            value="${Number(stage.progress) || 0}"
            onchange="updateStageField(${stage.id}, 'progress', Number(this.value) || 0)">
    </div>
    <div class="col-6 col-md-1">
        <label class="form-label small mb-1">Boshlanish</label>
        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(stage.start_date || '')}"
            onchange="updateStageField(${stage.id}, 'start_date', this.value)">
    </div>
    <div class="col-6 col-md-1">
        <label class="form-label small mb-1">Yakun</label>
        <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(stage.end_date || '')}"
            onchange="updateStageField(${stage.id}, 'end_date', this.value)">
    </div>
</div>
`;
}

timeline.appendChild(itemEl);
});
}

function toggleStagesEdit() {
stagesEditMode = !stagesEditMode;

const btn = document.getElementById('toggleStagesEditBtn');
const addBtn = document.getElementById('addStageBtn');

if (btn) {
btn.innerHTML = stagesEditMode
? '<i class="bi bi-check-lg me-1"></i> Saqlash'
: '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';
}

uiToggleEditButton(btn, stagesEditMode);
if (addBtn) addBtn.classList.toggle('d-none', !stagesEditMode);

displayStages(projectData.stages || []);
}

function updateStageField(stageId, field, value) {
if (!projectData || !Array.isArray(projectData.stages)) return;
const stage = projectData.stages.find(s => String(s.id) === String(stageId));
if (!stage) return;

stage[field] = value;
displayStages(projectData.stages);
}

function addNewStage() {
if (!projectData || !Array.isArray(projectData.stages)) return;

const newStage = {
id: nextStageId++,
name: 'Yangi bosqich',
status: 'planned',
icon: 'bi-circle',
order: projectData.stages.length + 1,
start_date: '',
end_date: '',
progress: 0
};

projectData.stages.push(newStage);
uiEnsurePriority(projectData.stages, 'order');
displayStages(projectData.stages);
showToast('Yangi bosqich qo\'shildi', 'success');
}

function onStageDragStart(e, stageId) {
dragStageId = stageId;
try { e.dataTransfer.setData('text/plain', String(stageId)); } catch (err) { }
e.dataTransfer.effectAllowed = 'move';
}

function onStageDragOver(e, targetId) {
e.preventDefault();
e.dataTransfer.dropEffect = 'move';
const target = document.querySelector(`.stage-item[data-stage-id="${targetId}"]`);
if (target) target.classList.add('is-drag-over');
}

function onStageDragLeave(e, targetId) {
const target = document.querySelector(`.stage-item[data-stage-id="${targetId}"]`);
if (target) target.classList.remove('is-drag-over');
}

function onStageDrop(e, targetId) {
e.preventDefault();
const targetEl = document.querySelector(`.stage-item[data-stage-id="${targetId}"]`);
if (targetEl) targetEl.classList.remove('is-drag-over');

const draggedId = dragStageId;
if (!draggedId || String(draggedId) === String(targetId)) return;
if (!projectData || !Array.isArray(projectData.stages)) return;

const list = projectData.stages.slice();
const fromIndex = list.findIndex(s => String(s.id) === String(draggedId));
const toIndex = list.findIndex(s => String(s.id) === String(targetId));
if (fromIndex === -1 || toIndex === -1) return;

const [dragged] = list.splice(fromIndex, 1);
list.splice(toIndex, 0, dragged);

projectData.stages = list;
uiEnsurePriority(projectData.stages, 'order');
displayStages(projectData.stages);
}