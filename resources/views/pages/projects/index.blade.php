@extends('layouts.app')

@push('customCss')
<style>
/* Optimallashtrilgan CSS */
.filter-card {
    background: #ffffff;
    border: 1px solid rgba(0, 0, 0, 0.05);
    border-radius: 0.75rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
}

.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 0.75rem;
    padding: 1.25rem;
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
}

.stats-card .stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.stats-card .stat-label {
    font-size: 0.85rem;
    opacity: 0.9;
}

/* Jadval optimizatsiyasi */
.project-table {
    font-size: 0.875rem;
    margin-bottom: 0;
}

.project-table thead th {
    background: #1f2937;
    color: white;
    font-weight: 600;
    padding: 0.875rem 0.75rem;
    font-size: 0.8125rem;
    white-space: nowrap;
    border: none;
    vertical-align: middle;
}

.project-table tbody td {
    padding: 0.875rem 0.75rem;
    vertical-align: middle;
    border-color: #e5e7eb;
}

.project-table tbody tr {
    transition: background-color 0.15s ease;
}

.project-table tbody tr:hover {
    background-color: #f9fafb;
}

/* Rasm optimizatsiyasi */
.project-img {
    width: 56px;
    height: 56px;
    object-fit: cover;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border: 2px solid #fff;
}

/* Badge'lar - Optimized */
.badge-custom {
    padding: 0.35rem 0.65rem;
    border-radius: 0.35rem;
    font-size: 0.7rem;
    font-weight: 600;
    display: inline-block;
    white-space: nowrap;
    text-transform: capitalize;
}

.badge-category-yer {
    background: #d1fae5;
    color: #065f46;
}

.badge-category-qurilish {
    background: #dbeafe;
    color: #1e40af;
}

.badge-category-ijara {
    background: #fef3c7;
    color: #92400e;
}

.badge-status-faol {
    background: #d1fae5;
    color: #065f46;
}

.badge-status-rejalashtirilgan {
    background: #dbeafe;
    color: #1e40af;
}

.badge-status-yakunlangan {
    background: #e5e7eb;
    color: #374151;
}

.badge-status-nofaol {
    background: #fee2e2;
    color: #991b1b;
}

/* Progress bar with dynamic colors */
.progress-wrapper {
    min-width: 100px;
}

.progress-custom {
    height: 6px;
    background: #e5e7eb;
    border-radius: 1rem;
    overflow: hidden;
    margin-bottom: 0.25rem;
}

.progress-bar-custom {
    height: 100%;
    border-radius: 1rem;
    transition: width 0.3s ease;
}

.progress-bar-danger {
    background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%);
}

.progress-bar-warning {
    background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
}

.progress-bar-info {
    background: linear-gradient(90deg, #06b6d4 0%, #0891b2 100%);
}

.progress-bar-success {
    background: linear-gradient(90deg, #10b981 0%, #059669 100%);
}

.progress-text {
    font-size: 0.7rem;
    color: #6b7280;
    font-weight: 500;
}

/* Raund ko'rsatkichlari - Horizontal */
.round-indicators {
    display: flex;
    gap: 0.35rem;
    align-items: center;
    flex-wrap: nowrap;
}

.round-dot {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
    font-weight: 600;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
}

.round-active {
    background: #3b82f6;
    color: white;
}

.round-completed {
    background: #10b981;
    color: white;
}

.round-pending {
    background: #f3f4f6;
    color: #9ca3af;
    border: 1px solid #e5e7eb;
}

/* Amallar */
.action-buttons {
    display: flex;
    gap: 0.375rem;
    justify-content: center;
}

.btn-action {
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.375rem;
    border: 1px solid #e5e7eb;
    background: white;
    transition: all 0.2s ease;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
}

.btn-view {
    color: #3b82f6;
}

.btn-view:hover {
    background: #eff6ff;
    border-color: #3b82f6;
}

.btn-edit {
    color: #f59e0b;
}

.btn-edit:hover {
    background: #fffbeb;
    border-color: #f59e0b;
}

.btn-delete {
    color: #ef4444;
}

.btn-delete:hover {
    background: #fef2f2;
    border-color: #ef4444;
}

/* Ma'lumot ko'rinishi */
.project-name {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.125rem;
    font-size: 0.875rem;
}

.project-location {
    font-size: 0.75rem;
    color: #6b7280;
}

.value-primary {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.875rem;
}

.value-secondary {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.125rem;
}

/* Loading state */
.loading-row td {
    text-align: center;
    padding: 3rem !important;
    color: #6b7280;
}

.loading-spinner {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #9ca3af;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

/* Responsive */
@media (max-width: 1400px) {
    .project-table {
        font-size: 0.8125rem;
    }

    .project-img {
        width: 48px;
        height: 48px;
    }
}

/* Table scroll */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.table-responsive::-webkit-scrollbar {
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3 mb-2"
    style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('admin.projects') }}</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm px-3 py-2">
            <i class="fas fa-plus me-1"></i> {{ __('admin.add') }}
        </a>
        <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
            data-bs-toggle="collapse" data-bs-target="#projectsFilterContent" aria-expanded="true"
            aria-controls="projectsFilterContent">
            <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
        </button>
    </div>
</div>
@endsection

@section('content')
<!-- Filter qismi -->
<div class="filter-card mb-3 collapse show" id="projectsFilterContent">
    <div class="p-3">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="searchInput" class="form-label mb-2">Qidiruv</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Loyiha nomi">
                </div>
            </div>
            <div class="col-md-2">
                <label for="categoryFilter" class="form-label mb-2">{{ __('admin.category') }}</label>
                <select id="categoryFilter" class="form-select">
                    <option value="">{{ __('admin.all') }}</option>
                    <option value="yer">{{ __('admin.land') }}</option>
                    <option value="qurilish">{{ __('admin.construction') }}</option>
                    <option value="ijara">{{ __('admin.rent') }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="statusFilter" class="form-label mb-2">{{ __('admin.status') }}</label>
                <select id="statusFilter" class="form-select">
                    <option value="">{{ __('admin.all') }}</option>
                    <option value="faol">{{ __('admin.active') }}</option>
                    <option value="rejalashtirilgan">{{ __('admin.planned') }}</option>
                    <option value="yakunlangan">{{ __('admin.completed') }}</option>
                    <option value="nofaol">{{ __('admin.inactive') }}</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="riskFilter" class="form-label mb-2">{{ __('admin.risk_level') }}</label>
                <select id="riskFilter" class="form-select">
                    <option value="">{{ __('admin.all') }}</option>
                    <option value="past">{{ __('admin.low') }}</option>
                    <option value="o'rta">{{ __('admin.medium') }}</option>
                    <option value="yuqori">{{ __('admin.high') }}</option>
                </select>
            </div>
            <x-filter-buttons :search-text="__('admin.search')" :clear-text="__('admin.clear')" />
        </div>
    </div>
</div>

<!-- Jadval -->
<div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
    <table class="table user-table table-bordered table-hover table-striped align-items-center">
        <thead class="table-dark">
            <tr>
                <th style="width: 50px;">{{ __('admin.id') }}</th>
                <th style="min-width: 200px;">{{ __('admin.project') }}</th>
                <th style="width: 80px;">{{ __('admin.picture') }}</th>
                <th style="width: 100px;">{{ __('admin.category') }}</th>
                <th style="width: 90px;">{{ __('admin.status') }}</th>
                <th style="min-width: 130px;">{{ __('admin.value') }}</th>
                <th style="min-width: 120px;">{{ __('admin.progress') }}</th>
                <!-- <th style="min-width: 120px;">{{ __('admin.financing') }}</th> -->
                <th style="min-width: 140px;">{{ __('admin.rounds') }}</th>
                <th style="width: 110px;">{{ __('admin.duration') }}</th>
                <th style="width: 130px;">{{ __('admin.actions') }}</th>
            </tr>
        </thead>
        <tbody id="projectTableBody">
            <tr class="loading-row">
                <td colspan="14">
                    <i class="fas fa-spinner loading-spinner me-2"></i>
                    <span>Loyihalar yuklanmoqda...</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

@push('customJs')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
let projects = [];
let defaultProjects = [];

const projectTableBody = document.getElementById('projectTableBody');
const searchInput = document.getElementById('searchInput');
const categoryFilter = document.getElementById('categoryFilter');
const statusFilter = document.getElementById('statusFilter');
const riskFilter = document.getElementById('riskFilter');
const filterBtn = document.getElementById('filterBtn');
const clearBtn = document.getElementById('clearBtn');

// Pul formatini o'zgartirish
function formatCurrency(num) {
    if (num === null || num === undefined) return '-';
    if (num >= 1000000000) {
        return (num / 1000000000).toFixed(1) + ' mlrd';
    } else if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + ' mln';
    }
    return new Intl.NumberFormat('uz-UZ').format(num);
}

// Qisqa format
function formatCurrencyShort(num) {
    if (num === null || num === undefined) return '-';
    if (num >= 1000000000) {
        return (num / 1000000000).toFixed(2) + ' mlrd';
    } else if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + ' mln';
    }
    return new Intl.NumberFormat('uz-UZ').format(num) + ' so\'m';
}

// Progress bar rangi
function getProgressBarClass(percent) {
    if (percent >= 0 && percent < 25) return 'progress-bar-danger';
    if (percent >= 25 && percent < 50) return 'progress-bar-warning';
    if (percent >= 50 && percent < 75) return 'progress-bar-info';
    return 'progress-bar-success';
}

// Ma'lumotlarni qayta ishlash
function preprocessProjects(list) {
    const flatList = list.flat();

    return flatList.map(p => {
        // Kategoriya
        const categoryMap = {
            'land': 'yer',
            'construction': 'qurilish',
            'rent': 'ijara'
        };
        const category_key = categoryMap[p.category] || p.category;

        // Xavf
        const riskMap = {
            'low': 'past',
            'medium': 'o\'rta',
            'high': 'yuqori'
        };
        const risk_uz = riskMap[p.risk_level] || p.risk_level;

        // Holat
        const statusMap = {
            'active': 'faol',
            'planned': 'rejalashtirilgan',
            'completed': 'yakunlangan',
            'inactive': 'nofaol'
        };
        const status_uz = statusMap[p.status] || p.status;

        // Moliyalashtirish
        const fundingPercent = p.investor_share > 0 ?
            Math.min(((p.collected || 0) / p.investor_share) * 100, 100) :
            0;

        // Progress
        let progressPercent = fundingPercent;
        if (p.progress && p.progress.percent) {
            progressPercent = p.progress.percent;
        }

        // Davomiylik
        const months = p.duration_months || 0;
        const years = Math.floor(months / 12);
        const remainingMonths = months % 12;
        let duration = '';
        if (years > 0) duration += years + ' yil ';
        if (remainingMonths > 0) duration += remainingMonths + ' oy';
        duration = duration.trim() || '-';

        console.log(p);
        return {
            ...p,
            category: category_key,
            category_display: category_key.charAt(0).toUpperCase() + category_key.slice(1),
            risk: risk_uz,
            status: status_uz,
            progress: Math.round(progressPercent),
            funding: Math.round(fundingPercent),
            currentRound: p.round,
            totalRounds: p.rounds_status.length,
            duration: duration,
            roi: p.yearly_profit_percent || 0, // FIX 1: 0 chiqarish
            location: `${p.district}, ${p.region}`
        };
    });
}

// Raund ko'rsatkichlarini render qilish - HORIZONTAL
function renderRounds(roundsStatus) {
    let html = '<div class="round-indicators">';

    roundsStatus.forEach((round, index) => {
        let statusClass = 'round-pending';
        if (round.status === 'completed') {
            statusClass = 'round-completed';
        } else if (round.status === 'active') {
            statusClass = 'round-active';
        } else if (round.status === 'in_progress') {
            statusClass = 'round-pending';
        }

        html += `<span class="round-dot ${statusClass}">${round.round}</span>`;
    });

    html += '</div>';
    return html;
}

// Loyihalarni render qilish
function renderProjects(list) {
    if (list.length === 0) {
        projectTableBody.innerHTML = `
            <tr>
                <td colspan="14">
                    <div class="empty-state">
                        <i class="fas fa-folder-open"></i>
                        <div class="mt-2">
                            <h5>Loyihalar topilmadi</h5>
                            <p class="text-muted">Filter sozlamalarini o'zgartiring yoki yangi loyiha qo'shing</p>
                        </div>
                    </div>
                </td>
            </tr>
        `;
        return;
    }

    const routes = {
        show: "{{ route('admin.projects.show', ':id') }}",
        edit: "{{ route('admin.projects.edit', ':id') }}",
        delete: "{{ route('admin.project.destroy', ':id') }}"
    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    let html = '';
    list.forEach(p => {
        const showUrl = routes.show.replace(':id', p.id);
        const editUrl = routes.edit.replace(':id', p.id);
        const destroyUrl = routes.delete.replace(':id', p.id);

        // FIX 2: Progress bar rangi
        const progressBarClass = getProgressBarClass(p.progress);
        const fundingBarClass = getProgressBarClass(p.funding);

        html += `
            <tr>
                <td>${p.code}</td>
                <td>
                    <div class="project-name">${p.name}</div>
                    <div class="project-location">
                        <i class="fas fa-map-marker-alt me-1"></i>${p.location}
                    </div>
                </td>
                <td>
                    <img src="${p.image}" class="project-img" alt="${p.name}"
                         onerror="this.src='https://via.placeholder.com/56'">
                </td>
                <td>
                    <span class="badge badge-custom badge-category-${p.category}">
                        ${p.category_display}
                    </span>
                </td>
                <td>
                    <span class="badge badge-custom badge-status-${p.status}">
                        ${p.status.charAt(0).toUpperCase() + p.status.slice(1)}
                    </span>
                </td>
                <td>
                    <div class="value-primary">${formatCurrencyShort(p.total_value)} (${p.funding}%)</div>
                                        <div class="value-secondary">Min: ${formatCurrencyShort(p.min_investment)}</div>
                </td>
                <td>
                    <div class="progress-wrapper">
                        <div class="progress-custom">
                            <div class="progress-bar-custom ${progressBarClass}" style="width: ${p.progress}%"></div>
                        </div>
                        <div class="progress-text">${p.progress}% bajarildi</div>
                    </div>
                </td>
                <td>${renderRounds(p.rounds_status)}</td>
                <td>${p.duration}</td>
                <td>
                    <div class="action-buttons">
                        <x-show-button />
                        <x-edit-button />
                        <x-delete-button/>
                    </div>
                </td>
            </tr>
        `;
    });

    projectTableBody.innerHTML = html;
}

// Statistikani yangilash
function updateStatistics(list) {
    const total = list.length;
    const active = list.filter(p => p.status === 'faol').length;
    const totalValue = list.reduce((sum, p) => sum + (p.total_value || 0), 0);
    const avgFunding = list.length > 0 ?
        Math.round(list.reduce((sum, p) => sum + p.funding, 0) / list.length) :
        0;
}

// API dan ma'lumotlarni yuklash
function fetchProjects() {
    axios.get('/api/projects/list')
        .then(response => {
            const apiResult = response.data.result;

            if (!apiResult || !Array.isArray(apiResult)) {
                throw new Error('Noto\'g\'ri API javobi');
            }

            projects = preprocessProjects(apiResult);
            defaultProjects = [...projects];

            renderProjects(projects);
            updateStatistics(projects);
        })
        .catch(error => {
            console.error('API xatosi:', error);
            projectTableBody.innerHTML = `
                <tr>
                    <td colspan="14">
                        <div class="empty-state">
                            <i class="fas fa-exclamation-triangle text-danger"></i>
                            <div class="mt-2">
                                <h5>Xatolik yuz berdi</h5>
                                <p class="text-muted">Ma'lumotlarni yuklashda muammo yuz berdi. Iltimos, qayta urinib ko'ring.</p>
                                <button class="btn btn-primary btn-sm mt-2" onclick="fetchProjects()">
                                    <i class="fas fa-redo me-1"></i> Qayta yuklash
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            `;
        });
}

// Filterlash
function applyFilter() {
    const search = searchInput.value.toLowerCase();
    const cat = categoryFilter.value;
    const stat = statusFilter.value;
    const risk = riskFilter.value;

    const filtered = defaultProjects.filter(p => {
        const matchesSearch = !search ||
            p.name.toLowerCase().includes(search) ||
            p.code.toLowerCase().includes(search) ||
            p.location.toLowerCase().includes(search);
        const matchesCategory = !cat || p.category === cat;
        const matchesStatus = !stat || p.status === stat;
        const matchesRisk = !risk || p.risk === risk;

        return matchesSearch && matchesCategory && matchesStatus && matchesRisk;
    });

    renderProjects(filtered);
    updateStatistics(filtered);
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    fetchProjects();

    filterBtn.addEventListener('click', applyFilter);

    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        categoryFilter.value = '';
        statusFilter.value = '';
        riskFilter.value = '';
        renderProjects(defaultProjects);
        updateStatistics(defaultProjects);
    });

    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') applyFilter();
    });

    // Real-time qidiruv (debounce bilan)
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(applyFilter, 300);
    });
});
</script>
@endpush