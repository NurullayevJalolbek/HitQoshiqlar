// =================== ROUNDS TAB SCRIPT ===================
// File: resources/views/pages/projects/scripts/rounds.blade.php

let roundsEditMode = false;
let nextRoundId = 4;
let dragRoundId = null;

// Helper function to format date as YYYY-MM-DD
function formatDate(dateString) {
    if (!dateString) return 'Belgilanmagan';
    
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return 'Belgilanmagan';
    
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    
    return `${year}-${month}-${day}`;
}

// Helper function to convert dd.mm.yy to YYYY-MM-DD for input
function formatDateForInput(dateString) {
    if (!dateString) return '';
    
    const date = new Date(dateString);
    if (isNaN(date.getTime())) return '';
    
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    
    return `${year}-${month}-${day}`;
}

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
        // View Mode - Card Style
        container.innerHTML = rounds.map(round => {
            const status = statusMap[round.status] || statusMap['inactive'];
            return `
                <div class="card border-0 shadow-sm mb-3" style="border-left: 4px solid ${
                    round.status === 'completed' ? '#10b981' : 
                    round.status === 'in_progress' ? '#3b82f6' : 
                    '#6b7280'
                } !important;">
                    <div class="card-body py-3 px-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-start gap-3 flex-grow-1">
                                <div class="badge-circle" style="
                                    width: 40px;
                                    height: 40px;
                                    border-radius: 8px;
                                    background: ${
                                        round.status === 'completed' ? '#d1fae5' : 
                                        round.status === 'in_progress' ? '#dbeafe' : 
                                        '#f3f4f6'
                                    };
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-weight: 700;
                                    color: ${
                                        round.status === 'completed' ? '#10b981' : 
                                        round.status === 'in_progress' ? '#3b82f6' : 
                                        '#6b7280'
                                    };
                                ">
                                    #${round.priority}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold" style="font-size: 15px; color: #1f2937;">
                                        ${uiEscapeHtml(round.name)}
                                    </div>
                                    <div class="mt-2">
                                        <span class="badge ${status.class}" style="font-size: 11px; padding: 4px 8px;">
                                            ${status.text}
                                        </span>
                                    </div>
                                    <div class="mt-2 text-muted small">
                                        <i class="bi bi-calendar-range me-1"></i>
                                        ${formatDate(round.start_date)} - ${formatDate(round.end_date)}
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold" style="font-size: 24px; color: ${
                                    round.status === 'completed' ? '#10b981' : 
                                    round.status === 'in_progress' ? '#3b82f6' : 
                                    '#6b7280'
                                };">
                                    ${formatMoney(round.min_share)}
                                </div>
                                <div class="text-muted small">Minimal ulush</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    } else {
        // Edit Mode - Table Style
        container.innerHTML = rounds.map(round => {
            const status = statusMap[round.status] || statusMap['inactive'];
            const canDelete = String(round.status) === 'inactive';

            return `
                <div class="card border mb-3" data-round-id="${round.id}">
                    <div class="card-body">
                        <div class="row g-3 align-items-end">
                            <div class="col-12 col-md-1">
                                <label class="form-label small mb-1">№</label>
                                <div class="priority-pill" style="font-size: 16px; padding: 8px; text-align: center;">#${round.priority}</div>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label small mb-1">Raund nomi</label>
                                <input type="text" class="form-control" value="${uiEscapeHtml(round.name)}"
                                    onchange="updateRoundField(${round.id}, 'name', this.value)">
                            </div>
                            <div class="col-6 col-md-2">
                                <label class="form-label small mb-1">Holati</label>
                                <select class="form-select"
                                    onchange="updateRoundField(${round.id}, 'status', this.value)">
                                    <option value="inactive" ${round.status === 'inactive' ? 'selected' : ''}>Nofaol</option>
                                    <option value="in_progress" ${round.status === 'in_progress' ? 'selected' : ''}>Jarayonda</option>
                                    <option value="completed" ${round.status === 'completed' ? 'selected' : ''}>Yakunlangan</option>
                                </select>
                            </div>
                            <div class="col-6 col-md-2">
                                <label class="form-label small mb-1">Boshlanish</label>
                                <input type="date" class="form-control"
                                    value="${formatDateForInput(round.start_date)}"
                                    onchange="updateRoundField(${round.id}, 'start_date', this.value)">
                            </div>
                            <div class="col-6 col-md-2">
                                <label class="form-label small mb-1">Tugash</label>
                                <input type="date" class="form-control"
                                    value="${formatDateForInput(round.end_date)}"
                                    onchange="updateRoundField(${round.id}, 'end_date', this.value)">
                            </div>
                            <div class="col-6 col-md-2">
                                <label class="form-label small mb-1">Minimal ulush</label>
                                <input type="number" min="0" step="1000" class="form-control"
                                    value="${Number(round.min_share) || 0}"
                                    onchange="updateRoundField(${round.id}, 'min_share', Number(this.value) || 0)">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <button type="button" class="btn btn-danger btn-sm"
                                    ${canDelete ? '' : 'disabled'}
                                    onclick="deleteRound(${round.id})">
                                    <i class="bi bi-trash"></i> O'chirish
                                </button>
                            </div>
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
        start_date: '2001-09-11',
        end_date: '2001-09-11',
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