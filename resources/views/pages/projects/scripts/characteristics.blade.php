// =================== CHARACTERISTICS TAB SCRIPT ===================
// File: resources/views/pages/projects/scripts/characteristics.blade.php

let editModes = {
basicInfo: false,
location: false,
manager: false,
construction: false
};

let originalData = {
basicInfo: {},
location: {},
manager: {},
construction: {}
};

// =================== BASIC INFO EDIT ===================
function toggleBasicInfoEdit() {
editModes.basicInfo = !editModes.basicInfo;
const btn = document.getElementById('toggleBasicInfoBtn');

if (editModes.basicInfo) {
btn.innerHTML = '<i class="bi bi-check-lg me-1"></i>Saqlash';
btn.classList.remove('btn-outline-secondary');
btn.classList.add('btn-success');

originalData.basicInfo = {
projectId: document.getElementById('projectId').textContent,
name: document.getElementById('name').textContent,
shortDesc: document.getElementById('shortDesc').textContent,
purpose: document.getElementById('purpose').textContent,
category: document.getElementById('category').textContent,
status: document.getElementById('status').textContent
};

convertBasicInfoToInputs();

const cancelBtn = document.createElement('button');
cancelBtn.type = 'button';
cancelBtn.className = 'btn btn-outline-danger btn-sm';
cancelBtn.id = 'cancelBasicInfoBtn';
cancelBtn.innerHTML = '<i class="bi bi-x-lg me-1"></i>Bekor qilish';
cancelBtn.onclick = cancelBasicInfoEdit;
btn.parentElement.insertBefore(cancelBtn, btn);

} else {
saveBasicInfoChanges();

btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i>Tahrirlash';
btn.classList.remove('btn-success');
btn.classList.add('btn-outline-secondary');

const cancelBtn = document.getElementById('cancelBasicInfoBtn');
if (cancelBtn) cancelBtn.remove();

convertBasicInfoToText();
}
}

function convertBasicInfoToInputs() {
const fields = [
{ id: 'projectId', type: 'text', readonly: true },
{ id: 'name', type: 'text' },
{ id: 'shortDesc', type: 'textarea' },
{ id: 'purpose', type: 'textarea' },
{ id: 'category', type: 'text' },
{ id: 'status', type: 'text' }
];

fields.forEach(field => {
const element = document.getElementById(field.id);
const value = element.textContent;

if (field.type === 'textarea') {
element.innerHTML = `<textarea class="form-control" rows="3">${value}</textarea>`;
} else {
element.innerHTML = `<input type="text" class="form-control" value="${value}" ${field.readonly ? 'readonly' : '' }>`;
}
});
}

function convertBasicInfoToText() {
const fields = ['projectId', 'name', 'shortDesc', 'purpose', 'category', 'status'];

fields.forEach(fieldId => {
const element = document.getElementById(fieldId);
const input = element.querySelector('input, textarea');
if (input) {
element.textContent = input.value;
}
});
}

function saveBasicInfoChanges() {
const fields = ['projectId', 'name', 'shortDesc', 'purpose', 'category', 'status'];
const newData = {};

fields.forEach(fieldId => {
const element = document.getElementById(fieldId);
const input = element.querySelector('input, textarea');
if (input) {
newData[fieldId] = input.value;
}
});

console.log('Asosiy ma\'lumotlar saqlandi:', newData);
showToast('Asosiy ma\'lumotlar muvaffaqiyatli saqlandi', 'success');
}

function cancelBasicInfoEdit() {
editModes.basicInfo = false;

Object.keys(originalData.basicInfo).forEach(key => {
const element = document.getElementById(key);
if (element) {
element.textContent = originalData.basicInfo[key];
}
});

const btn = document.getElementById('toggleBasicInfoBtn');
btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i>Tahrirlash';
btn.classList.remove('btn-success');
btn.classList.add('btn-outline-secondary');

const cancelBtn = document.getElementById('cancelBasicInfoBtn');
if (cancelBtn) cancelBtn.remove();

showToast('O\'zgarishlar bekor qilindi', 'info');
}

// =================== LOCATION EDIT ===================
function toggleLocationEdit() {
editModes.location = !editModes.location;
const btn = document.getElementById('toggleLocationBtn');

if (editModes.location) {
btn.innerHTML = '<i class="bi bi-check-lg me-1"></i>Saqlash';
btn.classList.remove('btn-outline-secondary');
btn.classList.add('btn-success');

originalData.location = {
city: document.getElementById('city').textContent,
district: document.getElementById('district').textContent,
street: document.getElementById('street').textContent,
house: document.getElementById('house').textContent
};

convertLocationToInputs();
} else {
saveLocationChanges();
btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i>Tahrirlash';
btn.classList.remove('btn-success');
btn.classList.add('btn-outline-secondary');

convertLocationToText();
}
}

function convertLocationToInputs() {
const fields = ['city', 'district', 'street', 'house'];

fields.forEach(fieldId => {
const element = document.getElementById(fieldId);
const value = element.textContent;
element.innerHTML = `<input type="text" class="form-control" value="${value}">`;
});
}

function convertLocationToText() {
const fields = ['city', 'district', 'street', 'house'];

fields.forEach(fieldId => {
const element = document.getElementById(fieldId);
const input = element.querySelector('input');
if (input) {
element.textContent = input.value;
}
});
}

function saveLocationChanges() {
console.log('Joylashuv ma\'lumotlari saqlandi');
showToast('Joylashuv ma\'lumotlari muvaffaqiyatli saqlandi', 'success');
}

// =================== MANAGER EDIT ===================
function toggleManagerEdit() {
editModes.manager = !editModes.manager;
const btn = document.getElementById('toggleManagerBtn');

if (editModes.manager) {
btn.innerHTML = '<i class="bi bi-check-lg me-1"></i>Saqlash';
btn.classList.remove('btn-outline-secondary');
btn.classList.add('btn-success');

originalData.manager = {
managerOrg: document.getElementById('managerOrg').textContent,
licenseNumber: document.getElementById('licenseNumber').textContent
};

convertManagerToInputs();
} else {
saveManagerChanges();
btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i>Tahrirlash';
btn.classList.remove('btn-success');
btn.classList.add('btn-outline-secondary');

convertManagerToText();
}
}

function convertManagerToInputs() {
const fields = ['managerOrg', 'licenseNumber'];

fields.forEach(fieldId => {
const element = document.getElementById(fieldId);
const value = element.textContent;
element.innerHTML = `<input type="text" class="form-control" value="${value}">`;
});
}

function convertManagerToText() {
const fields = ['managerOrg', 'licenseNumber'];

fields.forEach(fieldId => {
const element = document.getElementById(fieldId);
const input = element.querySelector('input');
if (input) {
element.textContent = input.value;
}
});
}

function saveManagerChanges() {
console.log('Loyiha boshqaruvchisi ma\'lumotlari saqlandi');
showToast('Loyiha boshqaruvchisi ma\'lumotlari muvaffaqiyatli saqlandi', 'success');
}

// =================== CONSTRUCTION EDIT ===================
function toggleConstructionEdit() {
editModes.construction = !editModes.construction;
const btn = document.getElementById('toggleConstructionBtn');

if (editModes.construction) {
btn.innerHTML = '<i class="bi bi-check-lg me-1"></i>Saqlash';
btn.classList.remove('btn-outline-secondary');
btn.classList.add('btn-success');

originalData.construction = {
constructionName: document.getElementById('constructionName').textContent,
constructionDesc: document.getElementById('constructionDesc').textContent
};

convertConstructionToInputs();
} else {
saveConstructionChanges();
btn.innerHTML = '<i class="bi bi-pencil-square me-1"></i>Tahrirlash';
btn.classList.remove('btn-success');
btn.classList.add('btn-outline-secondary');

convertConstructionToText();
}
}

function convertConstructionToInputs() {
const fields = [
{ id: 'constructionName', type: 'text' },
{ id: 'constructionDesc', type: 'textarea' }
];

fields.forEach(field => {
const element = document.getElementById(field.id);
const value = element.textContent;

if (field.type === 'textarea') {
element.innerHTML = `<textarea class="form-control" rows="3">${value}</textarea>`;
} else {
element.innerHTML = `<input type="text" class="form-control" value="${value}">`;
}
});
}

function convertConstructionToText() {
const fields = ['constructionName', 'constructionDesc'];

fields.forEach(fieldId => {
const element = document.getElementById(fieldId);
const input = element.querySelector('input, textarea');
if (input) {
element.textContent = input.value;
}
});
}

function saveConstructionChanges() {
console.log('Qurilish tashkiloti ma\'lumotlari saqlandi');
showToast('Qurilish tashkiloti ma\'lumotlari muvaffaqiyatli saqlandi', 'success');
}

// =================== MEDIA MANAGEMENT ===================
function deleteMedia(mediaId, mediaType, mediaSrc) {
if (!confirm('Ushbu faylni o\'chirmoqchimisiz?')) return;

console.log('Deleting media:', { mediaId, mediaType, mediaSrc });

if (projectData) {
if (mediaType === 'main-image' && Array.isArray(projectData.main_images)) {
projectData.main_images = projectData.main_images.filter(u => String(u) !== String(mediaSrc));
displayMainImages(projectData.main_images);
}
if (mediaType === 'process-image' && Array.isArray(projectData.process_images)) {
projectData.process_images = projectData.process_images.filter(u => String(u) !== String(mediaSrc));
displayProcessImages(projectData.process_images);
}
if (mediaType === 'video' && Array.isArray(projectData.videos)) {
projectData.videos = projectData.videos.filter(u => String(u) !== String(mediaSrc));
displayVideos(projectData.videos);
}
}

setTimeout(addMediaControls, 0);
showToast('Fayl muvaffaqiyatli o\'chirildi', 'success');
}

function uploadNewMedia(mediaType) {
const input = document.createElement('input');
input.type = 'file';
input.accept = mediaType === 'video' ? 'video/*' : 'image/*';
input.multiple = true;

input.onchange = function (e) {
const files = e.target.files;
if (files.length === 0) return;

console.log('Uploading files:', files);

Array.from(files).forEach((file, index) => {
setTimeout(() => {
showToast(`${file.name} yuklandi`, 'success');
}, index * 500);
});
};

input.click();
}

function addMediaControls() {
const mainImagesContainer = document.getElementById('mainImagesContainer');
if (mainImagesContainer) addControlsToContainer(mainImagesContainer, 'main-image');

const processImagesContainer = document.getElementById('processImagesContainer');
if (processImagesContainer) addControlsToContainer(processImagesContainer, 'process-image');

const videosContainer = document.getElementById('videosContainer');
if (videosContainer) addControlsToContainer(videosContainer, 'video');
}

function addControlsToContainer(container, mediaType) {
const items = container.querySelectorAll('.gallery-item');

items.forEach((item, index) => {
if (item.classList.contains('media-upload-card')) return;
if (item.querySelector('.media-controls')) return;

const mediaSrc = item.getAttribute('data-media-src') || (item.querySelector('img')?.getAttribute('src') ?? '');
const mediaId = `${mediaType}-${index}`;
item.setAttribute('data-media-id', mediaId);

const controls = document.createElement('div');
controls.className = 'media-controls';

controls.innerHTML = `
<button type="button" class="media-delete-btn" title="O'chirish">
    <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
        <path fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
            clip-rule="evenodd"></path>
    </svg>
</button>
`;

const btn = controls.querySelector('button');
btn.addEventListener('click', function (e) {
e.preventDefault();
e.stopPropagation();
deleteMedia(mediaId, mediaType, mediaSrc);
});
controls.addEventListener('click', function (e) {
e.preventDefault();
e.stopPropagation();
});

item.appendChild(controls);
});

if (!container.querySelector('.media-upload-card')) {
const uploadCard = document.createElement('div');
uploadCard.className = 'gallery-item media-upload-card';
uploadCard.innerHTML = `
<div class="media-upload-content">
    <i class="bi bi-cloud-upload"></i>
    <span>Yangi yuklash</span>
</div>
`;
uploadCard.addEventListener('click', function (e) {
e.preventDefault();
e.stopPropagation();
uploadNewMedia(mediaType);
});

container.appendChild(uploadCard);
}
}

// Initialize media controls after page load
document.addEventListener('DOMContentLoaded', function () {
setTimeout(addMediaControls, 1000);
});