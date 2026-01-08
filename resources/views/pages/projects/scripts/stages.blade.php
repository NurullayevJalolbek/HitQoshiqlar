// =================== STAGES TAB SCRIPT ===================

let stagesEditMode = false;

// 1) SVG ICON PATHS - Har bir bosqich turi uchun fayl manzili
const STAGE_ICON_PATHS = {
  land: '/assets/img/icons/progress-bar/permission.svg',
  build: '/assets/img/icons/progress-bar/brick.svg',
  karkas: '/assets/img/icons/progress-bar/karkas.svg',
  docs: '/assets/img/icons/progress-bar/permission.svg',
  money: '/assets/img/icons/progress-bar/sale.svg',
  survey: '/assets/img/icons/progress-bar/decoration.svg',
  keys: '/assets/img/icons/progress-bar/keys.svg',
  default: '/assets/img/icons/progress-bar/default.svg',
};

// SVG iconni IMG tag sifatida qaytarish
function stageIconImgByKey(key) {
  const iconPath = STAGE_ICON_PATHS[key] || STAGE_ICON_PATHS.default;
  return `<img src="${iconPath}" alt="${key}" class="stage-icon-img">`;
}

// Stage nomiga qarab icon kalitini aniqlash
function getIconKeyFromStageName(stageName) {
  if (!stageName) return 'default';
  
  const name = stageName.toLowerCase();
  
  // Ruxsatnoma/Hujjatlar bilan bog'liq
  if (name.includes('ruxsat')  || name.includes('qayd')) {
    return 'docs';
  }
  // Yer/Joy bilan bog'liq
  if (name.includes('yer') || name.includes('joy') || name.includes('land')) {
    return 'land';
  }
  // Qurilish bilan bog'liq
  if (name.includes('qurilish') || name.includes('bino') || name.includes('karkas')) {
    return 'build';
  }
  // Pul/To'lov bilan bog'liq
  if (name.includes('to\'lov') || name.includes('tolov') || name.includes('kredit') || name.includes('bank') || name.includes('sotish')) {
    return 'money';
  }
  // Kalit topshirish
  if (name.includes('kalit') || name.includes('topshir') || name.includes('keys') || name.includes('foydalanishga topshirish va hujjatlashtirish')) {
    return 'keys';
  }
  // Inspeksiya/Tekshiruv
  if (name.includes('inspeks') || name.includes('tekshir') || name.includes('nazorat') || name.includes('bezatish')) {
    return 'survey';
  }
  if(name.includes('konstruksiya')){
    return 'karkas'
  }
  return 'default';
}

// 2) Hozirgi aktiv bosqichni aniqlash
function getCurrentActiveStage(stages) {
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  
  // Avval tugallanmagan, lekin boshlangan bosqichni topamiz
  for (let stage of stages) {
    if (stage.status === 'completed') continue;
    
    const startDate = stage.start_date ? new Date(stage.start_date) : null;
    const endDate = stage.end_date ? new Date(stage.end_date) : null;
    
    if (startDate && startDate <= today) {
      if (!endDate || endDate >= today) {
        return stage;
      }
    }
  }
  
  // Agar topilmasa, birinchi tugallanmagan bosqichni qaytaramiz
  return stages.find(s => s.status !== 'completed') || stages[stages.length - 1];
}

// 3) MAIN RENDER
function displayStages(stages) {
  if (!Array.isArray(stages)) stages = [];

  // --- Progress hisoblash ---
  const totalProgress = stages.reduce((sum, s) => {
    return sum + (s.status === 'completed' ? (Number(s.progress) || 0) : 0);
  }, 0);

  const progress = Math.min(100, Math.max(0, totalProgress));
  const progressBar = document.getElementById('progressBar');
  const progressBarLabel = document.getElementById('progressBarLabel');
  const progressIconEl = document.getElementById('progressIcon');
  const progressTextEl = document.getElementById('progressText');

  // Progress bar rangini o'zgartirish
  if (progressBar) {
    progressBar.style.width = progress + '%';
    
    // Rang o'zgarishi
    let gradientColor1, gradientColor2, shadowColor;
    
    if (progress < 25) {
      // Qizil
      gradientColor1 = '#ef4444';
      gradientColor2 = '#dc2626';
      shadowColor = 'rgba(239, 68, 68, 0.3)';
    } else if (progress < 50) {
      // Sariq
      gradientColor1 = '#f59e0b';
      gradientColor2 = '#d97706';
      shadowColor = 'rgba(245, 158, 11, 0.3)';
    } else if (progress < 75) {
      // Ko'k/Havorang
      gradientColor1 = '#3b82f6';
      gradientColor2 = '#2563eb';
      shadowColor = 'rgba(59, 130, 246, 0.3)';
    } else {
      // Yashil
      gradientColor1 = '#10b981';
      gradientColor2 = '#059669';
      shadowColor = 'rgba(16, 185, 129, 0.3)';
    }
    
    progressBar.style.background = `linear-gradient(90deg, ${gradientColor1} 0%, ${gradientColor2} 100%)`;
    progressBar.style.boxShadow = `0 2px 8px ${shadowColor}`;
  }
  
  if (progressTextEl) progressTextEl.textContent = progress + '%';
  else if (progressBarLabel) progressBarLabel.textContent = progress + '%';

  // Hozirgi aktiv bosqichning iconini ko'rsatish
  if (progressIconEl) {
    const activeStage = getCurrentActiveStage(stages);
    const iconKey = activeStage?.iconKey || getIconKeyFromStageName(activeStage?.name);
    progressIconEl.innerHTML = stageIconImgByKey(iconKey);
  }

  // --- Timeline render ---
  const timeline = document.getElementById('timeline');
  if (!timeline) return;

  timeline.innerHTML = '';
  timeline.classList.add('stage-timeline');

  const activeStage = getCurrentActiveStage(stages);

  stages.forEach((stage, index) => {
    const iconKey = stage.iconKey || getIconKeyFromStageName(stage.name);
    const iconImg = stageIconImgByKey(iconKey);
    const isCompleted = stage.status === 'completed';
    const isActive = activeStage?.id === stage.id;
    const isLast = index === stages.length - 1;

    // Sana formatlash (oy nomlari)
    const formatDate = (dateStr) => {
      if (!dateStr) return '-';
      const date = new Date(dateStr);
      const months = ['yan', 'fev', 'mar', 'apr', 'may', 'iyun', 'iyul', 'avg', 'sen', 'okt', 'noy', 'dek'];
      return `${date.getDate().toString().padStart(2, '0')}-${months[date.getMonth()]}, ${date.getFullYear()}`;
    };

    // Muddat hisoblash
    const calculateDuration = () => {
      if (!stage.start_date || !stage.end_date) return '';
      const start = new Date(stage.start_date);
      const end = new Date(stage.end_date);
      const diffTime = Math.abs(end - start);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      
      if (diffDays < 7) return `≈${diffDays} kun`;
      if (diffDays < 30) return `≈${Math.ceil(diffDays / 7)} hafta`;
      return `≈${Math.round(diffDays / 30)} oy`;
    };

    const item = document.createElement('div');
    item.className = `stage-item ${isCompleted ? 'completed' : ''} ${isActive ? 'active' : ''}`;
    item.setAttribute('data-stage-id', stage.id);

    item.innerHTML = `
      <div class="stage-marker-wrap">
        <div class="stage-marker ${isCompleted ? 'completed' : ''} ${isActive ? 'active' : ''}">
          ${iconImg}
        </div>
        ${!isLast ? '<div class="stage-line"></div>' : ''}
      </div>

      <div class="stage-content">
        <div class="stage-title">${uiEscapeHtml(stage.name || '')}</div>
        <div class="stage-dates">
          ${formatDate(stage.start_date)} → ${formatDate(stage.end_date)}
          ${calculateDuration() ? `<span class="stage-duration">(${calculateDuration()})</span>` : ''}
        </div>
      </div>
    `;

    timeline.appendChild(item);
  });
}

// Helper function (agar mavjud bo'lmasa)
function uiEscapeHtml(text) {
  const map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };
  return String(text).replace(/[&<>"']/g, m => map[m]);
}

// =================== EDIT MODE FUNCTIONS ===================

function toggleStagesEdit() {
  stagesEditMode = !stagesEditMode;
  
  const toggleBtn = document.getElementById('toggleStagesEditBtn');
  const addBtn = document.getElementById('addStageBtn');
  const stagesTools = document.getElementById('stagesTools');
  const stagesHint = document.getElementById('stagesHint');
  const timeline = document.getElementById('timeline');
  
  if (stagesEditMode) {
    // Edit mode ochish
    toggleBtn.innerHTML = '<i class="bi bi-check-lg me-1"></i> Saqlash';
    toggleBtn.classList.remove('btn-outline-secondary');
    toggleBtn.classList.add('btn-success');
    
    if (addBtn) addBtn.classList.remove('d-none');
    if (stagesTools) stagesTools.classList.add('show');
    if (stagesHint) stagesHint.classList.add('show');
    
    // Timeline elementlarini draggable qilish
    makeStagesDraggable();
    
    // Edit buttonlarini qo'shish
    addEditButtonsToStages();
    
  } else {
    // Edit mode yopish va saqlash
    toggleBtn.innerHTML = '<i class="bi bi-pencil-square me-1"></i> Tahrirlash';
    toggleBtn.classList.remove('btn-success');
    toggleBtn.classList.add('btn-outline-secondary');
    
    if (addBtn) addBtn.classList.add('d-none');
    if (stagesTools) stagesTools.classList.remove('show');
    if (stagesHint) stagesHint.classList.remove('show');
    
    // Draggable ni o'chirish
    removeStagesDraggable();
    
    // Edit buttonlarini o'chirish
    removeEditButtonsFromStages();
    
    // Ma'lumotlarni saqlash
    saveStagesOrder();
  }
}

function makeStagesDraggable() {
  const items = document.querySelectorAll('.stage-item');
  
  items.forEach(item => {
    item.setAttribute('draggable', 'true');
    item.style.cursor = 'move';
    
    item.addEventListener('dragstart', handleDragStart);
    item.addEventListener('dragover', handleDragOver);
    item.addEventListener('drop', handleDrop);
    item.addEventListener('dragend', handleDragEnd);
  });
}

function removeStagesDraggable() {
  const items = document.querySelectorAll('.stage-item');
  
  items.forEach(item => {
    item.setAttribute('draggable', 'false');
    item.style.cursor = 'default';
    
    item.removeEventListener('dragstart', handleDragStart);
    item.removeEventListener('dragover', handleDragOver);
    item.removeEventListener('drop', handleDrop);
    item.removeEventListener('dragend', handleDragEnd);
  });
}

let draggedElement = null;

function handleDragStart(e) {
  draggedElement = this;
  this.classList.add('dragging');
  e.dataTransfer.effectAllowed = 'move';
}

function handleDragOver(e) {
  if (e.preventDefault) {
    e.preventDefault();
  }
  e.dataTransfer.dropEffect = 'move';
  
  const item = e.currentTarget;
  if (item !== draggedElement) {
    item.classList.add('drag-over');
  }
  
  return false;
}

function handleDrop(e) {
  if (e.stopPropagation) {
    e.stopPropagation();
  }
  
  const item = e.currentTarget;
  item.classList.remove('drag-over');
  
  if (draggedElement !== item) {
    const timeline = document.getElementById('timeline');
    const allItems = [...timeline.children];
    const draggedIndex = allItems.indexOf(draggedElement);
    const targetIndex = allItems.indexOf(item);
    
    if (draggedIndex < targetIndex) {
      item.parentNode.insertBefore(draggedElement, item.nextSibling);
    } else {
      item.parentNode.insertBefore(draggedElement, item);
    }
  }
  
  return false;
}

function handleDragEnd(e) {
  this.classList.remove('dragging');
  
  const items = document.querySelectorAll('.stage-item');
  items.forEach(item => {
    item.classList.remove('drag-over');
  });
}

function addEditButtonsToStages() {
  const items = document.querySelectorAll('.stage-item');
  
  items.forEach(item => {
    const stageId = item.getAttribute('data-stage-id');
    const content = item.querySelector('.stage-content');
    
    if (!content.querySelector('.stage-edit-actions')) {
      const actions = document.createElement('div');
      actions.className = 'stage-edit-actions mt-2';
      actions.innerHTML = `
        <button class="btn btn-sm btn-outline-primary" onclick="editStage(${stageId})">
          <i class="bi bi-pencil"></i> O'zgartirish
        </button>
        <button class="btn btn-sm btn-outline-danger" onclick="deleteStage(${stageId})">
          <i class="bi bi-trash"></i> O'chirish
        </button>
      `;
      content.appendChild(actions);
    }
  });
}

function removeEditButtonsFromStages() {
  const actions = document.querySelectorAll('.stage-edit-actions');
  actions.forEach(action => action.remove());
}

function saveStagesOrder() {
  const items = document.querySelectorAll('.stage-item');
  const order = [];
  
  items.forEach((item, index) => {
    const stageId = item.getAttribute('data-stage-id');
    order.push({
      id: stageId,
      order: index + 1
    });
  });
  
  console.log('Saqlash kerak:', order);
  
  // Bu yerda AJAX orqali serverga yuborasiz
  // fetch('/api/stages/reorder', {
  //   method: 'POST',
  //   headers: { 'Content-Type': 'application/json' },
  //   body: JSON.stringify({ order: order })
  // });
}

function addNewStage() {
  // Yangi bosqich qo'shish modal yoki forma
  console.log('Yangi bosqich qo\'shish');
  
  // Modal ochish yoki forma ko'rsatish
  // Misol uchun:
  // $('#addStageModal').modal('show');
}

function editStage(stageId) {
  console.log('Bosqichni tahrirlash:', stageId);
  
  // Tahrirlash modal ochish
  // $('#editStageModal').modal('show');
  // loadStageData(stageId);
}

function deleteStage(stageId) {
  if (confirm('Haqiqatan ham bu bosqichni o\'chirmoqchimisiz?')) {
    console.log('Bosqichni o\'chirish:', stageId);
    
    // AJAX orqali o'chirish
    // fetch(`/api/stages/${stageId}`, {
    //   method: 'DELETE'
    // }).then(() => {
    //   // Timeline'ni qayta yuklash
    //   loadStages();
    // });
  }
}

function setStageInsertAfter(value) {
  console.log('Qo\'shish joyi:', value);
  // Yangi bosqichni qayerga qo'shishni belgilash
}