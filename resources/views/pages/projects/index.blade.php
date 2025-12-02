@extends('layouts.app')

@push('customCss')

@endpush

@section('breadcrumb')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <!-- Breadcrumb -->
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.projects') }}</li>
                </ol>
            </nav>
        </div>

        <!-- Tugmalar guruhi -->
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <!-- Yangi loyiha qo'shish -->
            <button class="btn btn-primary btn-sm px-3 py-1" id="addProjectBtn"
                    style="min-width: 90px;">
                <i class="fas fa-plus me-1" style="font-size: 0.85rem;"></i> {{ __('admin.create') }}
            </button>

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
    <!-- Filter -->
    <div class="filter-card mb-3 mt-2 collapse show" id="projectsFilterContent" style="transition: all 0.3s ease;">
        <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
            <div class="row g-3 align-items-end">
                {{-- Qidiruv --}}
                <div class="col-md-4">
                    <label for="searchInput">{{__('admin.search')}}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control"
                               placeholder="{{__('admin.project_name')}}, ID...">
                    </div>
                </div>

                {{-- Kategoriya bo'yicha filter --}}
                <div class="col-md-3">
                    <label for="categoryFilter">{{__('admin.by_category')}}</label>
                    <select id="categoryFilter" class="form-select">
                        <option value="">{{__('admin.all')}}</option>
                        <option value="yer">Yer</option>
                        <option value="qurilish">Qurilish</option>
                        <option value="ijara">Ijara</option>
                    </select>
                </div>

                {{-- Holat bo'yicha filter --}}
                <div class="col-md-3">
                    <label for="statusFilter">{{__('admin.by_status')}}</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">{{__('admin.all')}}</option>
                        <option value="faol">Faol</option>
                        <option value="rejalashtirilgan">Rejalashtirilgan</option>
                        <option value="yakunlangan">Yakunlangan</option>
                        <option value="nofaol">Nofaol</option>
                    </select>
                </div>

                {{-- Tugmalar --}}
                <div class="col-md-2 d-flex gap-2">
                    <button id="filterBtn" class="btn btn-primary w-50">
                        <i class="fas fa-filter"></i> {{__('admin.filter')}}
                    </button>

                    <button id="clearBtn" class="btn btn-warning w-50">
                        {{__('admin.clear')}}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table project-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Rasm</th>
                <th>Loyiha nomi</th>
                <th>Kategoriya</th>
                <th>Holat</th>
                <th>Xavf</th>
                <th>Manzil</th>
                <th>Qiymati</th>
                <th>Progress</th>
                <th>Moliyalashtirish</th>
                <th>Raundlar</th>
                <th>Davomiyligi</th>
                <th>Rentabellik</th>
                <th>Amallar</th>
            </tr>
            </thead>
            <tbody id="projectTableBody">
            <!-- JS orqali to'ldiriladi -->
            </tbody>
        </table>
    </div>
@endsection

@push('customJs')
    <script>
        const defaultProjects = [
            {
                id: 'YR001',
                name: 'Toshkent Yer Uchastkasi',
                category: 'yer',
                status: 'faol',
                risk: 'past',
                image: 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=400',
                location: 'Toshkent viloyati, Chirchiq',
                value: 2000000,
                progress: 100,
                funding: 100,
                totalRounds: 2,
                currentRound: 2,
                minShare: 5000,
                duration: '12 oy',
                roi: 35.0,
                lastDividend: 12.5,
                builder: '-',
                manager: 'Sardor Abdullayev'
            },
            {
                id: 'YR002',
                name: 'Samarqand Hududiy Rivojlanish',
                category: 'yer',
                status: 'rejalashtirilgan',
                risk: 'orta',
                image: 'https://images.unsplash.com/photo-1418065460487-3e41a6c84dc5?w=400',
                location: 'Samarqand shahri',
                value: 3500000,
                progress: 0,
                funding: 25,
                totalRounds: 3,
                currentRound: 1,
                minShare: 3000,
                duration: '24 oy',
                roi: 28.0,
                lastDividend: 0,
                builder: 'Samarqand Development',
                manager: 'Farrux Ismoilov'
            },
            {
                id: 'QR001',
                name: 'Xonsaroy Residence',
                category: 'qurilish',
                status: 'faol',
                risk: 'orta',
                image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=400',
                location: 'Toshkent, Yunusobod tumani',
                value: 5000000,
                progress: 65,
                funding: 72,
                totalRounds: 3,
                currentRound: 2,
                minShare: 1000,
                duration: '18 oy',
                roi: 25.5,
                lastDividend: 8.2,
                builder: 'Universal Qurilish MMC',
                manager: 'Alisher Karimov'
            },
            {
                id: 'QR002',
                name: 'Navoiy Business Complex',
                category: 'qurilish',
                status: 'faol',
                risk: 'yuqori',
                image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=400',
                location: 'Navoiy shahri, markaz',
                value: 7500000,
                progress: 45,
                funding: 60,
                totalRounds: 4,
                currentRound: 2,
                minShare: 2500,
                duration: '30 oy',
                roi: 32.0,
                lastDividend: 5.5,
                builder: 'Navoiy Construction Group',
                manager: 'Shavkat Rahimov'
            },
            {
                id: 'IJ001',
                name: 'Buxoro Business Center',
                category: 'ijara',
                status: 'faol',
                risk: 'orta',
                image: 'https://images.unsplash.com/photo-1486718448742-163732cd1544?w=400',
                location: 'Buxoro shahri, markaz',
                value: 1500000,
                progress: 90,
                funding: 88,
                totalRounds: 2,
                currentRound: 2,
                minShare: 500,
                duration: '6 oy',
                roi: 18.0,
                lastDividend: 6.5,
                builder: 'Buxoro Invest Group',
                manager: 'Jasur Tursunov'
            },
            {
                id: 'IJ002',
                name: 'Toshkent Savdo Markazi',
                category: 'ijara',
                status: 'yakunlangan',
                risk: 'past',
                image: 'https://images.unsplash.com/photo-1486401899868-0e435ed85128?w=400',
                location: 'Toshkent, Mirzo Ulugʻbek tumani',
                value: 2800000,
                progress: 100,
                funding: 100,
                totalRounds: 3,
                currentRound: 3,
                minShare: 800,
                duration: '15 oy',
                roi: 22.5,
                lastDividend: 9.8,
                builder: 'Capital Builders',
                manager: 'Ravshan Nosirov'
            }
        ];

        let projects = JSON.parse(JSON.stringify(defaultProjects));

        const projectTableBody = document.getElementById('projectTableBody');
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const statusFilter = document.getElementById('statusFilter');
        const filterBtn = document.getElementById('filterBtn');
        const clearBtn = document.getElementById('clearBtn');
        const addProjectBtn = document.getElementById('addProjectBtn');

        // Format currency
        function formatCurrency(num) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 0
            }).format(num);
        }

        // Get category name
        function getCategoryName(category) {
            const names = {
                'yer': 'Yer',
                'qurilish': 'Qurilish',
                'ijara': 'Ijara'
            };
            return names[category] || category;
        }

        // Get category class
        function getCategoryClass(category) {
            return `category-${category}`;
        }

        // Get status class
        function getStatusClass(status) {
            return `status-${status}`;
        }

        // Get risk class
        function getRiskClass(risk) {
            return `risk-${risk}`;
        }

        // Render raundlar
        function renderRounds(current, total) {
            let html = '';
            for (let i = 1; i <= total; i++) {
                const statusClass = i <= current ? 'round-active' :
                    i === current ? 'round-active' : 'round-completed';
                html += `<span class="round-badge ${statusClass}">${i}</span>`;
            }
            return html;
        }

        // Actions menyusini ochish/yopish
        function toggleActionsMenu(button) {
            const menu = button.nextElementSibling;
            const allMenus = document.querySelectorAll('.actions-menu');

            allMenus.forEach(m => {
                if (m !== menu) m.classList.remove('show');
            });

            menu.classList.toggle('show');
        }

        // Tashqariga klik qilganda menyularni yopish
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.actions-dropdown')) {
                document.querySelectorAll('.actions-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });

        // Loyihalarni render qilish
        function renderProjects(list) {
            projectTableBody.innerHTML = '';

            list.forEach((p, idx) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <strong>${p.id}</strong>
                    </td>
                    <td>
                        <img src="${p.image}" class="project-img" alt="${p.name}">
                    </td>
                    <td>
                        <strong>${p.name}</strong><br>
                        <small class="text-muted">${p.manager}</small>
                    </td>
                    <td>
                        <span class="badge-category ${getCategoryClass(p.category)}">
                            ${getCategoryName(p.category)}
                        </span>
                    </td>
                    <td>
                        <span class="badge-status ${getStatusClass(p.status)}">
                            ${p.status}
                        </span>
                    </td>
                    <td>
                        <span class="badge-risk ${getRiskClass(p.risk)}">
                            ${p.risk}
                        </span>
                    </td>
                    <td>
                        ${p.location}
                    </td>
                    <td>
                        <strong>${formatCurrency(p.value)}</strong>
                    </td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar" style="width: ${p.progress}%"></div>
                        </div>
                        <small>${p.progress}%</small>
                    </td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar" style="width: ${p.funding}%"></div>
                        </div>
                        <small>${p.funding}%</small>
                    </td>
                    <td>
                        ${renderRounds(p.currentRound, p.totalRounds)}
                        <div><small>${p.currentRound}/${p.totalRounds}</small></div>
                    </td>
                    <td>
                        ${p.duration}
                    </td>
                    <td>
                        <strong>${p.roi}%</strong><br>
                        <small>Dividend: ${p.lastDividend}%</small>
                    </td>
                     <td class="text-center d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#1F2937;"><i class="bi bi-eye-fill"></i></a>
                        <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;"><i class="bi bi-pencil-fill"></i></a>
                        <a href="#" class="btn btn-sm p-1 delete-role" style="background:none;color:#DC2626;"><i class="fas fa-trash"></i></a>
                    </td>
                `;
                projectTableBody.appendChild(row);
            });
        }

        // Filter qo'llash
        function applyFilter() {
            const search = searchInput.value.toLowerCase();
            const cat = categoryFilter.value;
            const stat = statusFilter.value;

            const filtered = projects.filter(p => {
                const matchesSearch = p.name.toLowerCase().includes(search) ||
                    p.id.toLowerCase().includes(search) ||
                    p.location.toLowerCase().includes(search);
                const matchesCategory = !cat || p.category === cat;
                const matchesStatus = !stat || p.status === stat;

                return matchesSearch && matchesCategory && matchesStatus;
            });

            renderProjects(filtered);
        }

        // Loyihani ko'rish
        function viewProject(idx) {
            const p = projects[idx];
            alert(`Loyiha: ${p.name}\nID: ${p.id}\nManzil: ${p.location}\nQiymat: ${formatCurrency(p.value)}`);
        }

        // Loyihani tahrirlash
        function editProject(idx) {
            const p = projects[idx];
            alert(`"${p.name}" loyihasini tahrirlash oynasi ochiladi (demo)`);
            // Bu yerda modal oynani ochishingiz mumkin
        }

        // Loyihani o'chirish
        function deleteProject(idx) {
            if (confirm(`"${projects[idx].name}" loyihasini o'chirishni tasdiqlaysizmi?`)) {
                projects.splice(idx, 1);
                applyFilter();
                alert('Loyiha o\'chirildi!');
            }
        }

        // Yangi loyiha qo'shish
        addProjectBtn.addEventListener('click', function () {
            alert('Yangi loyiha qo\'shish oynasi ochiladi (demo)');
            // Bu yerda modal oynani ochishingiz mumkin
        });

        // Filter tugmasi
        filterBtn.addEventListener('click', applyFilter);

        // Tozalash tugmasi
        clearBtn.addEventListener('click', function () {
            searchInput.value = '';
            categoryFilter.value = '';
            statusFilter.value = '';
            projects = JSON.parse(JSON.stringify(defaultProjects));
            renderProjects(projects);
        });

        // Dastlabki render
        document.addEventListener('DOMContentLoaded', function () {
            renderProjects(projects);
        });

        // Enter tugmasi bilan filter
        searchInput.addEventListener('keyup', function (e) {
            if (e.key === 'Enter') {
                applyFilter();
            }
        });
    </script>
@endpush
