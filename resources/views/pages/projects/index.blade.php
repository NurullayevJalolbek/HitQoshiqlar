@extends('layouts.app')

@push('customCss')
@endpush

@section('breadcrumb')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Loyihalar ro'yxati</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm px-3 py-1" id="addProjectBtn" style="min-width: 90px;">
                <i class="fas fa-plus me-1" style="font-size: 0.85rem;"></i> Qo'shish
            </a>
            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#projectsFilterContent" aria-expanded="true"
                    aria-controls="projectsFilterContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="filter-card mb-3 mt-2 collapse show" id="projectsFilterContent" style="transition: all 0.3s ease;">
        <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="searchInput">Qidiruv</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control"
                               placeholder="Loyiha nomi, ID...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="categoryFilter">Kategoriya bo'yicha</label>
                    <select id="categoryFilter" class="form-select">
                        <option value="">Barchasi</option>
                        <option value="yer">Yer</option>
                        <option value="qurilish">Qurilish</option>
                        <option value="ijara">Ijara</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="statusFilter">Holat bo'yicha</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">Barchasi</option>
                        <option value="faol">Faol</option>
                        <option value="rejalashtirilgan">Rejalashtirilgan</option>
                        <option value="yakunlangan">Yakunlangan</option>
                        <option value="nofaol">Nofaol</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button id="filterBtn" class="btn btn-primary w-50">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <button id="clearBtn" class="btn btn-warning w-50">
                        Tozalash
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table project-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Rasm</th>
                <th>Code</th>
                <th>Loyiha nomi</th>
                <th>Kategoriya</th>
                <th>Holat</th>
                <th>Xavf</th>
                <th>Qiymati</th>
                <th>Min. Inv.</th>
                <th>Progress</th>
                <th>Moliyalashtirish</th>
                <th>Raundlar</th>
                <th>Davomiyligi</th>
                <th>Rentabellik</th>
                <th>Amallar</th>
            </tr>
            </thead>
            <tbody id="projectTableBody">
            </tbody>
        </table>
    </div>
@endsection

@push('customJs')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        /* CSS uslublar */
        .project-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 0.25rem;
        }
        .badge-category.category-yer { background-color: #4CAF50; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; }
        .badge-category.category-qurilish { background-color: #2196F3; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; }
        .badge-category.category-ijara { background-color: #FFC107; color: black; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; }
        .badge-status.status-faol { background-color: #008000; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; }
        .badge-status.status-yakunlangan { background-color: #6C757D; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; }
        .badge-risk.risk-past { background-color: #4CAF50; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; }
        .badge-risk.risk-o\'rta { background-color: #FFC107; color: black; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; }
        .badge-risk.risk-yuqori { background-color: #F44336; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; }
        .round-badge { display: inline-block; padding: 2px 5px; border-radius: 50%; font-size: 0.75rem; margin-right: 2px; }
        .round-active { background-color: #2196F3; color: white; }
        .round-completed { background-color: #4CAF50; color: white; }
        .round-pending { background-color: #E5E7EB; color: #6B7280; }
    </style>

    <script>
        let projects = [];
        let defaultProjects = [];

        const projectTableBody = document.getElementById('projectTableBody');
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const statusFilter = document.getElementById('statusFilter');
        const filterBtn = document.getElementById('filterBtn');
        const clearBtn = document.getElementById('clearBtn');
        const addProjectBtn = document.getElementById('addProjectBtn');

        // --- Yordamchi Funksiyalar ---

        function formatCurrency(num) {
            if (num === null || num === undefined) return '-';
            const formatter = new Intl.NumberFormat('uz-UZ', { minimumFractionDigits: 0 });
            return formatter.format(num) + ' sum';
        }

        function getCategoryName(category) {
            const names = {
                'yer': 'Yer',
                'qurilish': 'Qurilish',
                'ijara': 'Ijara'
            };
            return names[category] || category;
        }

        function getRiskClass(risk) {
            const classes = {
                'past': 'risk-past',
                'o\'rta': 'risk-o\'rta',
                'yuqori': 'risk-yuqori'
            };
            return classes[risk] || `risk-${risk}`;
        }

        function renderRounds(current, total) {
            let html = '';
            const effectiveTotal = Math.max(current + 1, total || 1);

            for (let i = 1; i <= effectiveTotal; i++) {
                const statusClass = i < current ? 'round-completed' :
                    i === current ? 'round-active' : 'round-pending';
                html += `<span class="round-badge ${statusClass}">${i}</span>`;
            }
            return html;
        }

        // --- Asosiy Ma'lumotlarni Qayta Ishlash ---
        function preprocessProjects(list) {
            // API javobi massiv ichidagi massiv bo'lsa, uni tekislaymiz
            const flatList = list.flat();

            return flatList.map(p => {
                let category_key;
                let risk_uz;
                let status_uz;

                // Kategoriyalar
                switch (p.category) {
                    case 'land': category_key = 'yer'; break;
                    case 'construction': category_key = 'qurilish'; break;
                    case 'rent': category_key = 'ijara'; break;
                    default: category_key = p.category;
                }

                // Xavf darajasi
                switch (p.risk_level) {
                    case 'low': risk_uz = 'past'; break;
                    case 'medium': risk_uz = 'o\'rta'; break;
                    case 'high': risk_uz = 'yuqori'; break;
                    default: risk_uz = p.risk_level;
                }

                // Holatlar
                switch (p.status) {
                    case 'active': status_uz = 'faol'; break;
                    case 'planned': status_uz = 'rejalashtirilgan'; break;
                    case 'completed': status_uz = 'yakunlangan';
                    case 'inactive': status_uz = 'nofaol';
                    default: status_uz = p.status;
                }

                // Moliyalashtirish foizi
                // Investor share (maqsad) 0 bo'lsa, bo'linish xatolarini oldini olish
                const fundingPercent = p.investor_share > 0 ? ((p.collected / p.investor_share) * 100) : 0;

                // Progress hisoblash
                let progressPercent;
                if (p.category === 'construction') {
                    if (p.construction_stage === 'foundation') progressPercent = 20;
                    else if (p.construction_stage === 'structure') progressPercent = 50;
                    else if (p.construction_stage === 'finishing') progressPercent = 80;
                    else progressPercent = 10;
                } else {
                    progressPercent = fundingPercent;
                }

                // Davomiylik
                const durationYears = Math.floor(p.duration_months / 12);
                const durationMonths = p.duration_months % 12;
                let durationStr = '';
                if (durationYears > 0) durationStr += `${durationYears} yil `;
                if (durationMonths > 0) durationStr += `${durationMonths} oy`;
                durationStr = durationStr.trim();

                // Rentabellik va Dividend
                const roi = p.yearly_profit_percent || 0;
                const lastDividend = p.yearly_yield ? p.yearly_yield.toFixed(1) : (roi / 4).toFixed(1);

                // Rasm (Picsum Photos - ID'ni seed sifatida ishlatish)
                const imageUrl = p.image

                return {
                    ...p,
                    id: p.id,
                    code: p.code,
                    category: category_key,
                    category_uz: getCategoryName(category_key),
                    risk: risk_uz,
                    status: status_uz,
                    image: imageUrl,
                    location: `${p.address}, ${p.district}, ${p.region}`,
                    value: p.total_value,
                    min_investment_uz: formatCurrency(p.min_investment),
                    progress: parseFloat(progressPercent.toFixed(1)),
                    funding: parseFloat(fundingPercent.toFixed(1)),
                    totalRounds: p.round ? p.round + 1 : 1,
                    currentRound: p.round || 1,
                    duration: durationStr,
                    roi: roi,
                    lastDividend: lastDividend,
                };
            });
        }

        // --- Loyihalarni Render Qilish ---
        function renderProjects(list) {
            projectTableBody.innerHTML = '';
            if (list.length === 0) {
                projectTableBody.innerHTML = `<tr><td colspan="14" class="text-center py-4 text-muted">Hech qanday loyiha topilmadi.</td></tr>`;
                return;
            }

            list.forEach((p, idx) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td><strong>${p.id}</strong></td>
                    <td><img src="${p.image}" class="project-img" alt="${p.name}"></td>
                    <td>${p.code}</td>
                    <td><strong>${p.name}</strong><br><small class="text-muted">${p.region}</small></td>
                    <td><span class="badge-category category-${p.category}">${p.category_uz}</span></td>
                    <td><span class="badge-status status-${p.status}">${p.status}</span></td>
                    <td><span class="badge-risk ${getRiskClass(p.risk)}">${p.risk}</span></td>
                    <td><strong>${formatCurrency(p.value)}</strong></td>
                     <td><small class="text-nowrap">${p.min_investment_uz}</small></td>
                    <td>
                        <div class="progress" style="height: 8px; margin-bottom: 2px;">
                            <div class="progress-bar" role="progressbar" style="width: ${p.progress}%; color: #1F2937"></div>
                        </div>
                        <small>Bosqich: ${p.progress}%</small>
                    </td>
                    <td>
                        <div class="progress" style="height: 8px; margin-bottom: 2px;">
                            <div class="progress-bar" role="progressbar" style="width: ${p.funding}%; color: #1F2937"></div>
                        </div>
                        <small>Yig'ilgan: ${p.funding}%</small>
                    </td>
                    <td>
                        ${renderRounds(p.currentRound, p.totalRounds)}
                        <div><small>Raund: ${p.currentRound}/${p.totalRounds}</small></div>
                    </td>
                    <td>${p.duration}</td>
                    <td><strong>${p.roi}%</strong><br><small>Dividend: ${p.lastDividend}%</small></td>
                     <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="color:#1F2937;" title="Ko'rish"><i class="bi bi-eye-fill"></i></a>
                        <a href="#" class="btn btn-sm p-1" style="color:#f0bc74;" title="Tahrirlash"><i class="bi bi-pencil-fill"></i></a>
                        <a href="#" class="btn btn-sm p-1" style="color:#DC2626;" title="O'chirish"><i class="fas fa-trash"></i></a>
                    </td>
                `;
                projectTableBody.appendChild(row);
            });
        }

        // --- API'dan Ma'lumotlarni Yuklash Funksiyasi ---

        function fetchProjects() {
            // Yuklanish holatini ko'rsatish
            projectTableBody.innerHTML = `<tr><td colspan="14" class="text-center py-5"><i class="fas fa-spinner fa-spin me-2"></i> Loyihalar yuklanmoqda...</td></tr>`;

            const API_URL = '/api/projects/list';

            // 1. Axios orqali API chaqirig'i
            axios.get(API_URL)
                .then(response => {
                    // API javobining to'g'ri joyidan (result) ma'lumotni olish
                    const apiResult = response.data.result;

                    // API'dan 'result' maydoni bo'sh yoki massiv bo'lmasa, xato berish
                    if (!apiResult || !Array.isArray(apiResult)) {
                        console.error("API javobi 'result' massivini o'z ichiga olmaydi yoki noto'g'ri formatda.");
                        projectTableBody.innerHTML = `<tr><td colspan="14" class="text-center py-5 text-danger">Serverdan ma'lumot olish formati noto'g'ri.</td></tr>`;
                        return;
                    }

                    // Ma'lumotni qayta ishlash
                    projects = preprocessProjects(apiResult);
                    defaultProjects = JSON.parse(JSON.stringify(projects));
                    renderProjects(projects);
                })
                .catch(error => {
                    // API xato bersa, faqat xatolik xabarini ko'rsatish
                    console.error("API'dan ma'lumot yuklashda xato ro'y berdi:", error);
                    projectTableBody.innerHTML = `<tr><td colspan="14" class="text-center py-5 text-danger">Ma'lumotlarni yuklashda xato! (API bilan ulanishni tekshiring).</td></tr>`;
                });
        }


        // --- Filter va Tugmalar Amallari ---
        function applyFilter() {
            const search = searchInput.value.toLowerCase();
            const cat = categoryFilter.value;
            const stat = statusFilter.value;

            const filtered = defaultProjects.filter(p => {
                const matchesSearch = p.name.toLowerCase().includes(search) || p.id.toLowerCase().includes(search) || p.location.toLowerCase().includes(search);
                const matchesCategory = !cat || p.category === cat;
                const matchesStatus = !stat || p.status === stat;
                return matchesSearch && matchesCategory && matchesStatus;
            });

            renderProjects(filtered);
        }

        // --- Dastlabki Yuklanish va Event Listeners ---
        document.addEventListener('DOMContentLoaded', function () {
            fetchProjects();

            filterBtn.addEventListener('click', applyFilter);
            clearBtn.addEventListener('click', function () {
                searchInput.value = '';
                categoryFilter.value = '';
                statusFilter.value = '';
                renderProjects(defaultProjects);
            });
            searchInput.addEventListener('keyup', function (e) {
                if (e.key === 'Enter') {
                    applyFilter();
                }
            });
            addProjectBtn.addEventListener('click', function () {
                alert('Yangi loyiha qo\'shish oynasi ochiladi (demo)');
            });
        });
    </script>
@endpush
