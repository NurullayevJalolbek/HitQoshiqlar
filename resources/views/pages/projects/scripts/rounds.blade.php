// =================== ROUNDS TAB SCRIPT ===================
// File: resources/views/pages/projects/scripts/rounds.blade.php

let roundsEditMode = false;
let nextRoundId = 4;
let dragRoundId = null;

function displayRounds(rounds) {
    const container = document.getElementById('roundsContainer');
    if (!container) return;

    const statusMap = {
        'in_progress': { text: 'Jarayonda', class: 'status-inprogress' },
        'completed': { text: 'Yakunlangan', class: 'status-completed' },
        'inactive': { text: 'Nofaol', class: 'status-inactive' }
    };

    if (!rounds || rounds.length === 0) {
        container.innerHTML = '<p class="text-muted text-center py-4">Raundlar mavjud emas</p>';
        return;
    }

    uiEnsurePriority(rounds, 'priority');

    if (!roundsEditMode) {
        container.innerHTML = rounds.map(round => {
            const status = statusMap[round.status] || statusMap['inactive'];
            return `
                <div class="round-item">
                    <div class="round-info">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="priority-pill">#${round.priority}</span>
                            <h6 class="mb-0">${uiEscapeHtml(round.name)}</h6>
                        </div>
                        <span class="status-badge ${status.class}">${status.text}</span>
                    </div>
                    <div style="text-align: right;">
                        <div class="round-amount">${formatMoney(round.min_share)}</div>
                        <div style="font-size: 0.85rem; color: var(--gray-600);">Minimal ulush</div>
                    </div>
                </div>
            `;
        }).join('');
    } else {
        container.innerHTML = rounds.map(round => {
            const status = statusMap[round.status] || statusMap['inactive'];
            const canDelete = String(round.status) === 'inactive';

            return `
                <div class="round-item" data-round-id="${round.id}">
                    <div class="row g-2 align-items-end">
                        <div class="col-12 col-md-2">
                            <span class="priority-pill">#${round.priority}</span>
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label small mb-1">Raund nomi</label>
                            <input type="text" class="form-control form-control-sm" value="${uiEscapeHtml(round.name)}"
                                onchange="updateRoundField(${round.id}, 'name', this.value)">
                        </div>
                        <div class="col-6 col-md-2">
                            <label class="form-label small mb-1">Holati</label>
                            <select class="form-select form-select-sm"
                                onchange="updateRoundField(${round.id}, 'status', this.value)">
                                <option value="inactive" ${round.status === 'inactive' ? 'selected' : ''}>Nofaol</option>
                                <option value="in_progress" ${round.status === 'in_progress' ? 'selected' : ''}>Jarayonda</option>
                                <option value="completed" ${round.status === 'completed' ? 'selected' : ''}>Yakunlangan</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small mb-1">Minimal ulush (so'm)</label>
                            <input type="number" min="0" step="1000" class="form-control form-control-sm"
                                value="${Number(round.min_share) || 0}"
                                onchange="updateRoundField(${round.id}, 'min_share', Number(this.value) || 0)">
                        </div>
                        <div class="col-12 col-md-2">
                            <button type="button" class="btn btn-danger btn-sm w-100"
                                ${canDelete ? '' : 'disabled'}
                                onclick="deleteRound(${round.id})">
                                <i class="bi bi-trash"></i> O'chirish
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }
}

function toggleRoundsEdit() {
    roundsEditMode = !roundsEditMode;
    const btn = document.getElementById('toggleRoundsEditBtn');
    const addBtn = document.getElementById('addRoundBtn');

    if (btn) {
        btn.innerHTML = roundsEditMode
            ? '<i class="bi bi-check-lg me-1"></i> Saqlash'
            : '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';
    }

    uiToggleEditButton(btn, roundsEditMode);
    if (addBtn) addBtn.classList.toggle('d-none', !roundsEditMode);

    if (projectData && projectData.rounds) displayRounds(projectData.rounds);
}

function addNewRound() {
    if (!projectData || !Array.isArray(projectData.rounds)) return;

    const newRound = {
        id: nextRoundId++,
        name: 'Yangi raund',
        status: 'inactive',
        min_share: 0,
        priority: projectData.rounds.length + 1
    };

    projectData.rounds.push(newRound);
    uiEnsurePriority(projectData.rounds, 'priority');
    displayRounds(projectData.rounds);
    showToast('Yangi raund qo\'shildi', 'success');
}

function updateRoundField(roundId, field, value) {
    if (!projectData || !Array.isArray(projectData.rounds)) return;
    const round = projectData.rounds.find(r => r.id === roundId);
    if (!round) return;

    round[field] = value;
    if (roundsEditMode) displayRounds(projectData.rounds);
}

function deleteRound(roundId) {
    if (!projectData || !Array.isArray(projectData.rounds)) return;
    const round = projectData.rounds.find(r => r.id === roundId);
    if (!round || String(round.status) !== 'inactive') return;

    if (confirm('Bu raundni o\'chirishni xohlaysizmi?')) {
        projectData.rounds = projectData.rounds.filter(r => r.id !== roundId);
        uiEnsurePriority(projectData.rounds, 'priority');
        displayRounds(projectData.rounds);
        showToast('Raund o\'chirildi', 'success');
    }
}
