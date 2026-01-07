// =================== DOCUMENTS TAB SCRIPT ===================
// File: resources/views/pages/projects/scripts/documents.blade.php

let documentsEditMode = false;
let nextDocumentId = 6;

function displayDocuments(documents) {
    const container = document.getElementById('documentsContainer');

    if (!documents || documents.length === 0) {
        container.innerHTML = '<p class="text-muted text-center py-4">Hujjatlar mavjud emas</p>';
        return;
    }

    if (!documentsEditMode) {
        container.innerHTML = documents.map(doc => `
            <div class="document-item">
                <div class="document-info">
                    <div class="document-icon"><i class="bi bi-file-earmark-pdf"></i></div>
                    <div>
                        <div style="font-weight: 600;">${doc.name}</div>
                        <div style="font-size: 0.85rem; color: var(--gray-600);">${doc.file}</div>
                    </div>
                </div>
                <button class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-download"></i> Yuklash
                </button>
            </div>
        `).join('');
    } else {
        container.innerHTML = documents.map(doc => `
            <div class="document-item" style="flex-direction: column; gap: 1rem;">
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="form-label small">Hujjat nomi</label>
                        <input type="text" class="form-control" value="${doc.name}"
                            onchange="updateDocumentField(${doc.id}, 'name', this.value)">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Fayl yuklash</label>
                        <input type="file" class="form-control">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-danger btn-sm w-100" onclick="deleteDocument(${doc.id})">
                            <i class="bi bi-trash"></i> O'chirish
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }
}

function toggleDocumentsEdit() {
    documentsEditMode = !documentsEditMode;
    const btn = document.getElementById('toggleDocumentsEditBtn');
    const addBtn = document.getElementById('addDocumentBtn');

    btn.innerHTML = documentsEditMode ?
        '<i class="bi bi-check-lg me-1"></i> Saqlash' :
        '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';

    uiToggleEditButton(btn, documentsEditMode);
    if (addBtn) addBtn.style.display = documentsEditMode ? 'inline-flex' : 'none';

    if (projectData && projectData.documents) displayDocuments(projectData.documents);
}

function addNewDocument() {
    if (!projectData || !projectData.documents) return;

    const newDoc = {
        id: nextDocumentId++,
        name: 'Yangi hujjat',
        file: 'fayl_yuklanmagan.pdf'
    };

    projectData.documents.push(newDoc);
    displayDocuments(projectData.documents);
    showToast('Yangi hujjat qo\'shildi', 'success');
}

function updateDocumentField(docId, field, value) {
    if (!projectData || !projectData.documents) return;
    const doc = projectData.documents.find(d => d.id === docId);
    if (!doc) return;

    doc[field] = value;
}

function deleteDocument(docId) {
    if (!projectData || !projectData.documents) return;
    if (confirm('Bu hujjatni o\'chirishni xohlaysizmi?')) {
        projectData.documents = projectData.documents.filter(d => d.id !== docId);
        displayDocuments(projectData.documents);
        showToast('Hujjat o\'chirildi', 'success');
    }
}