@extends('layouts.app')

@push('customCss')
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #6c757d;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
            --sidebar-bg: #1e2a3a;
            --sidebar-active: #2d3e50;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .table-responsive {
            background: #fff;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
        }

        .project-table {
            margin: 0;
        }

        .project-table thead {
            background: #2c3e50;
            color: white;
        }

        .project-table thead th {
            border: none;
            padding: 15px 10px;
            font-weight: 600;
            font-size: 13px;
            white-space: nowrap;
        }

        .project-table tbody tr {
            transition: var(--transition);
            border-bottom: 1px solid #f0f0f0;
        }

        .project-table tbody tr:hover {
            background-color: #f8f9ff;
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.2);
            transform: translateY(-3px);
            transition: all 0.3s ease;
        }

        .project-table tbody td {
            padding: 12px 10px;
            vertical-align: middle;
            font-size: 13px;
        }

        .project-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-nofaol {
            background: #e0e0e0;
            color: #666;
        }

        .status-rejalashtirilgan {
            background: #fff3cd;
            color: #856404;
        }

        .status-faol {
            background: #d4edda;
            color: #155724;
        }

        .status-yakunlangan {
            background: #cce5ff;
            color: #004085;
        }

        .badge-risk {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
        }

        .risk-past {
            background: #d4edda;
            color: #155724;
        }

        .risk-orta {
            background: #fff3cd;
            color: #856404;
        }

        .risk-yuqori {
            background: #f8d7da;
            color: #721c24;
        }

        .progress {
            height: 8px;
            border-radius: 10px;
            background: #e9ecef;
        }

        .progress-bar {
            border-radius: 10px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
        }

        .btn-action {
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 5px;
            margin: 0 2px;
        }

        .filter-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid #e0e0e0;
        }

        .filter-card label {
            color: #333;
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .filter-card .form-control,
        .filter-card .form-select {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 13px;
            background: #fff;
        }

        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            border: none;
        }

        .video-preview {
            width: 100%;
            max-height: 200px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .round-badge {
            display: inline-block;
            padding: 3px 8px;
            margin: 2px;
            background: #e9ecef;
            border-radius: 12px;
            font-size: 11px;
        }

        .round-active {
            background: #d4edda;
            color: #155724;
        }

        .round-completed {
            background: #cce5ff;
            color: #004085;
        }

        /* Actions dropdown styles */
        .actions-dropdown {
            position: relative;
            display: inline-block;
        }

        .actions-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            min-width: 150px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            z-index: 1000;
            padding: 8px 0;
        }

        .actions-menu.show {
            display: block;
        }

        .action-item {
            display: flex;
            align-items: center;
            width: 100%;
            border: none;
            background: none;
            padding: 8px 15px;
            text-align: left;
            cursor: pointer;
            transition: background-color 0.2s;
            font-size: 13px;
            color: #333;
        }

        .action-item:hover {
            background-color: #f8f9fa;
        }

        .action-item.text-info:hover {
            background-color: #e7f3ff;
            color: #0d6efd;
        }

        .action-item.text-warning:hover {
            background-color: #fff3cd;
            color: #ffc107;
        }

        .action-item.text-danger:hover {
            background-color: #f8d7da;
            color: #dc3545;
        }

        .action-item i {
            margin-right: 8px;
            width: 16px;
            text-align: center;
        }

        /* Gallery styles */
        .gallery-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }

        .gallery-img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .gallery-img:hover {
            transform: scale(1.05);
        }

        /* Timeline styles */
        .timeline {
            position: relative;
            padding-left: 20px;
            margin-top: 15px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 15px;
            padding-left: 20px;
        }

        .timeline-item:before {
            content: '';
            position: absolute;
            left: -8px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary);
        }

        .timeline-item.completed:before {
            background: var(--success);
        }

        .timeline-item.active:before {
            background: var(--warning);
        }

        .timeline-item.pending:before {
            background: var(--secondary);
        }

        /* Documents styles */
        .documents-list {
            margin-top: 10px;
        }

        .document-item {
            display: flex;
            align-items: center;
            padding: 8px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            margin-bottom: 5px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.2s;
        }

        .document-item:hover {
            background-color: #f8f9fa;
            text-decoration: none;
            color: #333;
        }

        .document-icon {
            margin-right: 10px;
            font-size: 18px;
        }

        .pdf-icon { color: #dc3545; }
        .doc-icon { color: #0d6efd; }
        .xls-icon { color: #198754; }
    </style>
@endpush

@section('breadcrumb')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4 breadcrumb-block">
        <div class="d-block mb-4 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('admin.projects')}}</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <!-- Filter -->
    <div class="filter-card mb-3 border rounded"
         style="border-color: rgba(0,0,0,0.1); border-radius: 0.5rem; background-color: #fff;">


        <!-- Filter header -->
        <div class="d-flex justify-content-between align-items-center p-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-search"></i>
                <span>Filterlar</span>
            </div>

            <button class="btn btn-sm rounded-pill px-3 py-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#userFilterContent" aria-expanded="true"
                    aria-controls="userFilterContent" id="userToggleFilterBtn"
                    style="background-color: #1F2937; color: #ffffff;">
                <i class="bi bi-caret-down-fill me-2" id="userFilterIcon" style="color: #ffffff;"> </i>
                <span id="userFilterText">Yopish</span>
            </button>
        </div>

        <!-- Filter content -->
        <div class="collapse show" id="userFilterContent">
            <div class="row g-3 align-items-end p-3">
                {{-- Qidiruv --}}
                <div class="col-md-4">
                    <label for="searchInput">{{__('admin.search')}}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="searchInput" class="form-control"
                               placeholder="{{__('admin.full_name')}}, {{__('admin.login')}}, {{__('admin.email')}}...">
                    </div>
                </div>

                {{-- Rol bo‘yicha filter --}}
                <div class="col-md-3">
                    <label for="roleFilter">{{__('admin.by_role')}}</label>
                    <select id="roleFilter" class="form-select">
                        <option value="">{{__('admin.all')}}</option>
                        <option value="Admin">Admin</option>
                        <option value="Moliyaviy auditor">Moliyaviy auditor</option>
                        <option value="Moderator">Moderator</option>
                        <option value="Islom moliyasi nazorati">Islom moliyasi nazorati</option>
                    </select>
                </div>

                {{-- Holat bo‘yicha filter --}}
                <div class="col-md-3">
                    <label for="statusFilter">{{__('admin.by_status')}}</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">{{__('admin.all')}}</option>
                        <option value="Faol">Faol</option>
                        <option value="Bloklangan">Bloklangan</option>
                    </select>
                </div>

                {{-- Tugmalar --}}
                <div class="col-md-2 d-flex gap-2">
                    <button id="filterBtn" class="btn btn-primary w-50">
                        <i class="fas fa-filter"></i> {{__('admin.search')}}
                    </button>

                    <button id="clearBtn" class="btn btn-warning w-50">
                        {{__('admin.clear')}}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <div class="d-flex justify-content-between align-items-center p-3">
            <h5 class="mb-0">Investitsion Loyihalar</h5>
            <button class="btn btn-primary" id="addProjectBtn">
                <i class="fas fa-plus"></i> Yangi loyiha
            </button>
        </div>
        <table class="table project-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Rasm</th>
                <th>Nomi</th>
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

    <!-- Create/Edit Modal -->
    <div class="modal fade" id="projectModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle" style="color: #fff;">Yangi loyiha qo'shish</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Loyiha nomi *</label>
                            <input type="text" id="projectName" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategoriya *</label>
                            <select id="projectCategory" class="form-select">
                                <option value="yer">Yer</option>
                                <option value="qurilish">Qurilish</option>
                                <option value="ijara">Ijara</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Holat *</label>
                            <select id="projectStatus" class="form-select">
                                <option value="nofaol">Nofaol</option>
                                <option value="rejalashtirilgan">Rejalashtirilgan</option>
                                <option value="faol">Faol</option>
                                <option value="yakunlangan">Yakunlangan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Xavf darajasi *</label>
                            <select id="projectRisk" class="form-select">
                                <option value="past">Past</option>
                                <option value="orta">O'rta</option>
                                <option value="yuqori">Yuqori</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Asosiy rasm URL</label>
                            <input type="text" id="projectImage" class="form-control" placeholder="https://...">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Video URL (YouTube)</label>
                            <input type="text" id="projectVideo" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Qurilish jarayoni rasmlari (URLlar, vergul bilan ajrating)</label>
                            <textarea id="projectConstructionImages" class="form-control" rows="2" placeholder="https://image1.jpg, https://image2.jpg, https://image3.jpg"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Qisqacha tavsif</label>
                            <textarea id="projectDescription" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Maqsad</label>
                            <textarea id="projectGoal" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Manzil</label>
                            <input type="text" id="projectLocation" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Umumiy qiymati (USD)</label>
                            <input type="number" id="projectValue" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Progress (%)</label>
                            <input type="number" id="projectProgress" class="form-control" min="0" max="100">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Moliyalashtirish (%)</label>
                            <input type="number" id="projectFunding" class="form-control" min="0" max="100">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jami raundlar</label>
                            <input type="number" id="projectTotalRounds" class="form-control" min="1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Joriy raund</label>
                            <input type="number" id="projectCurrentRound" class="form-control" min="1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Min. ulush narxi (USD)</label>
                            <input type="number" id="projectMinShare" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Davomiyligi</label>
                            <input type="text" id="projectDuration" class="form-control" placeholder="12 oy">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rentabellik (%)</label>
                            <input type="number" id="projectROI" class="form-control" step="0.1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Oxirgi dividend (%)</label>
                            <input type="number" id="projectLastDividend" class="form-control" step="0.1">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Timeline (Bosqichlar, format: Bosqich|Sana|Holat)</label>
                            <textarea id="projectTimeline" class="form-control" rows="3" placeholder="Loyihalashtirish|2024-01-15|completed&#10;Ruxsatnomalar|2024-02-20|completed&#10;Qurilish ishlari|2024-03-10|active"></textarea>
                            <small class="text-muted">Har bir bosqich yangi qatorda, format: Nomi|YYYY-MM-DD|completed/active/pending</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Hujjatlar (Nomi|URL|Turi)</label>
                            <textarea id="projectDocuments" class="form-control" rows="3" placeholder="Loyiha rejasi|https://example.com/plan.pdf|pdf&#10;Shartnoma|https://example.com/contract.doc|doc&#10;Moliyaviy hisobot|https://example.com/finance.xlsx|xls"></textarea>
                            <small class="text-muted">Har bir hujjat yangi qatorda, format: Nomi|URL|pdf/doc/xls</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Quruvchi tashkilot</label>
                            <input type="text" id="projectBuilder" class="form-control">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Loyiha boshqaruvchisi</label>
                            <input type="text" id="projectManager" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="button" class="btn btn-primary" id="saveProjectBtn">Saqlash</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Loyiha tafsilotlari</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailModalBody">
                    <!-- JS orqali to'ldiriladi -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customJs')
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script>
        const defaultProjects = [
            // Yer kategoriyasi - 2 ta loyiha
            {
                id: 'YR001',
                name: 'Toshkent Yer Uchastkasi',
                category: 'yer',
                status: 'faol',
                risk: 'past',
                image: 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=400',
                video: 'https://www.youtube.com/watch?v=zO8N2ZRq-4E',
                constructionImages: [
                    'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=400',
                    'https://images.unsplash.com/photo-1519996529931-28324d5a630e?w=400',
                    'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=400'
                ],
                description: '50 gektar yer uchastkasi, kommertsiya maqsadlari uchun',
                goal: 'Strategik joylashuvdagi yer sotish',
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
                timeline: [
                    { stage: 'Loyihalashtirish', date: '2024-01-15', status: 'completed' },
                    { stage: 'Ruxsatnomalar', date: '2024-02-20', status: 'completed' },
                    { stage: 'Marketing', date: '2024-03-10', status: 'completed' },
                    { stage: 'Sotuv jarayoni', date: '2024-04-01', status: 'active' }
                ],
                documents: [
                    { name: 'Yer hujjatlari', url: 'https://example.com/land.pdf', type: 'pdf' },
                    { name: 'Kadastr rejasi', url: 'https://example.com/cadaster.pdf', type: 'pdf' }
                ],
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
                video: 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                constructionImages: [
                    'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=400',
                    'https://images.unsplash.com/photo-1486401899868-0e435ed85128?w=400'
                ],
                description: '100 gektar yer uchastkasi, turar-joy va savdo markazi qurilishi uchun',
                goal: 'Samarqand shahrini rivojlantirish',
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
                timeline: [
                    { stage: 'Loyihalashtirish', date: '2024-05-01', status: 'completed' },
                    { stage: 'Ruxsatnomalar', date: '2024-06-15', status: 'active' },
                    { stage: 'Infratuzilma', date: '2024-08-01', status: 'pending' }
                ],
                documents: [
                    { name: 'Rivojlanish rejasi', url: 'https://example.com/development.pdf', type: 'pdf' },
                    { name: 'Ekologik hisobot', url: 'https://example.com/ecology.pdf', type: 'pdf' }
                ],
                builder: 'Samarqand Development',
                manager: 'Farrux Ismoilov'
            },
            // Qurilish kategoriyasi - 2 ta loyiha
            {
                id: 'QR001',
                name: 'Xonsaroy Residence',
                category: 'qurilish',
                status: 'faol',
                risk: 'orta',
                image: 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=400',
                video: 'https://www.youtube.com/watch?v=jNQXAC9IVRw',
                constructionImages: [
                    'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=400',
                    'https://images.unsplash.com/photo-1486401899868-0e435ed85128?w=400',
                    'https://images.unsplash.com/photo-1486718448742-163732cd1544?w=400'
                ],
                description: 'Zamonaviy turar-joy majmuasi, barcha qulayliklar bilan',
                goal: 'Toshkent shahrida yuqori sifatli uy-joy taqdim etish',
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
                timeline: [
                    { stage: 'Loyihalashtirish', date: '2023-11-01', status: 'completed' },
                    { stage: 'Poydevor qurilishi', date: '2024-01-15', status: 'completed' },
                    { stage: 'Qavatlar qurilishi', date: '2024-03-01', status: 'active' },
                    { stage: 'Tugatish ishlari', date: '2024-07-01', status: 'pending' }
                ],
                documents: [
                    { name: 'Qurilish loyihasi', url: 'https://example.com/construction.pdf', type: 'pdf' },
                    { name: 'Texnik shartnoma', url: 'https://example.com/contract.doc', type: 'doc' },
                    { name: 'Budjet hisobi', url: 'https://example.com/budget.xlsx', type: 'xls' }
                ],
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
                video: 'https://www.youtube.com/watch?v=9xwazD5SyVg',
                constructionImages: [
                    'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=400',
                    'https://images.unsplash.com/photo-1497366216548-37526070297c?w=400'
                ],
                description: 'Zamonaviy biznes kompleksi, ofislar va konferentsiya zallari',
                goal: 'Navoiy shahrida biznes infratuzilmasini yaratish',
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
                timeline: [
                    { stage: 'Loyihalashtirish', date: '2023-09-01', status: 'completed' },
                    { stage: 'Poydevor qurilishi', date: '2024-01-01', status: 'completed' },
                    { stage: 'Asosiy qurilish', date: '2024-03-15', status: 'active' },
                    { stage: 'Ichki qurilish', date: '2024-09-01', status: 'pending' }
                ],
                documents: [
                    { name: 'Arxitektura loyihasi', url: 'https://example.com/architecture.pdf', type: 'pdf' },
                    { name: 'Texnik hisobot', url: 'https://example.com/technical.doc', type: 'doc' }
                ],
                builder: 'Navoiy Construction Group',
                manager: 'Shavkat Rahimov'
            },
            // Ijara kategoriyasi - 2 ta loyiha
            {
                id: 'IJ001',
                name: 'Buxoro Business Center',
                category: 'ijara',
                status: 'faol',
                risk: 'orta',
                image: 'https://images.unsplash.com/photo-1486718448742-163732cd1544?w=400',
                video: 'https://www.youtube.com/watch?v=9xwazD5SyVg',
                constructionImages: [
                    'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=400',
                    'https://images.unsplash.com/photo-1497366216548-37526070297c?w=400',
                    'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=400'
                ],
                description: 'Zamonaviy biznes markaz, ofislar ijarasi',
                goal: 'Barqaror passiv daromad olish',
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
                timeline: [
                    { stage: 'Loyihalashtirish', date: '2024-01-10', status: 'completed' },
                    { stage: 'Investitsiya yigish', date: '2024-02-01', status: 'completed' },
                    { stage: 'Ijara boshlanishi', date: '2024-03-15', status: 'active' },
                    { stage: 'Daromad taqsimoti', date: '2024-04-01', status: 'pending' }
                ],
                documents: [
                    { name: 'Ijara shartnomasi', url: 'https://example.com/lease.pdf', type: 'pdf' },
                    { name: 'Biznes reja', url: 'https://example.com/business.doc', type: 'doc' }
                ],
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
                video: 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                constructionImages: [
                    'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=400',
                    'https://images.unsplash.com/photo-1519996529931-28324d5a630e?w=400'
                ],
                description: 'Katta savdo markazi, doʻkonlar ijarasi',
                goal: 'Savdo maydonchalarini ijaraga berish',
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
                timeline: [
                    { stage: 'Loyihalashtirish', date: '2023-06-01', status: 'completed' },
                    { stage: 'Qurilish', date: '2023-08-01', status: 'completed' },
                    { stage: 'Ijara boshlanishi', date: '2024-01-01', status: 'completed' },
                    { stage: 'Daromad taqsimoti', date: '2024-04-01', status: 'completed' }
                ],
                documents: [
                    { name: 'Savdo markazi loyihasi', url: 'https://example.com/mall.pdf', type: 'pdf' },
                    { name: 'Ijara shartnomalari', url: 'https://example.com/leases.doc', type: 'doc' },
                    { name: 'Moliyaviy hisobot', url: 'https://example.com/finance.xlsx', type: 'xls' }
                ],
                builder: 'Capital Builders',
                manager: 'Ravshan Nosirov'
            }
        ];

        let projects = JSON.parse(JSON.stringify(defaultProjects));
        let editingIndex = null;

        const projectTableBody = document.getElementById('projectTableBody');
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const statusFilter = document.getElementById('statusFilter');
        const riskFilter = document.getElementById('riskFilter');
        const filterBtn = document.getElementById('filterBtn');
        const clearBtn = document.getElementById('clearBtn');

        const addProjectBtn = document.getElementById('addProjectBtn');
        const projectModal = new bootstrap.Modal(document.getElementById('projectModal'));
        const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
        const modalTitle = document.getElementById('modalTitle');
        const saveProjectBtn = document.getElementById('saveProjectBtn');

        function formatCurrency(num) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
                minimumFractionDigits: 0
            }).format(num);
        }

        function toggleActionsMenu(button) {
            const menu = button.nextElementSibling;
            const allMenus = document.querySelectorAll('.actions-menu');

            allMenus.forEach(m => {
                if (m !== menu) m.classList.remove('show');
            });

            menu.classList.toggle('show');
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.actions-dropdown')) {
                document.querySelectorAll('.actions-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });

        function renderProjects(list) {
            projectTableBody.innerHTML = '';
            list.forEach((p, idx) => {
                const row = document.createElement('tr');

                const roundInfo = `
            ${Array.from({length: p.totalRounds}, (_, i) => {
                    const roundNum = i + 1;
                    const status = roundNum < p.currentRound ? 'round-completed' :
                        roundNum === p.currentRound ? 'round-active' : '';
                    return `<span class="round-badge ${status}">R${roundNum}</span>`;
                }).join('')}
        `;

                row.innerHTML = `
            <td><strong>${p.id}</strong></td>
            <td><img src="${p.image}" class="project-img" alt="${p.name}"></td>
            <td><strong>${p.name}</strong></td>
            <td>${p.category}</td>
            <td><span class="badge-status status-${p.status}">${p.status}</span></td>
            <td><span class="badge-risk risk-${p.risk}">${p.risk}</span></td>
            <td>${p.location}</td>
            <td><strong>${formatCurrency(p.value)}</strong></td>
            <td>
                <div class="progress">
                    <div class="progress-bar" style="width: ${p.progress}%"></div>
                </div>
                <small>${p.progress}%</small>
            </td>
            <td><strong>${p.funding}%</strong></td>
            <td>${roundInfo}</td>
            <td>${p.duration}</td>
            <td><strong style="color: #28a745;">${p.roi}%</strong></td>
            <td class="text-nowrap">
                <div class="actions-dropdown">
                    <button class="btn btn-sm btn-light btn-action" onclick="toggleActionsMenu(this)">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="actions-menu">
                        <button class="action-item text-info" onclick="showDetail(projects[${idx}])">
                            <i class="fas fa-eye"></i>Ko'rish
                        </button>
                        <button class="action-item text-warning" onclick="editProject(${idx}, projects[${idx}])">
                            <i class="fas fa-edit"></i>Tahrirlash
                        </button>
                        <button class="action-item text-danger" onclick="deleteProject(${idx})">
                            <i class="fas fa-trash"></i>O'chirish
                        </button>
                    </div>
                </div>
            </td>
        `;

                projectTableBody.appendChild(row);
            });
        }

        function showDetail(p) {
            const timelineHtml = p.timeline ? p.timeline.map(item => `
                <div class="timeline-item ${item.status}">
                    <strong>${item.stage}</strong>
                    <div class="text-muted">${item.date}</div>
                    <small class="badge-status status-${item.status}">${item.status}</small>
                </div>
            `).join('') : '';

            const galleryHtml = p.constructionImages ? `
                <h6>Qurilish jarayoni rasmlari:</h6>
                <div class="gallery-container">
                    ${p.constructionImages.map(img => `
                        <img src="${img}" class="gallery-img" alt="Construction">
                    `).join('')}
                </div>
            ` : '';

            const documentsHtml = p.documents ? `
                <h6>Hujjatlar:</h6>
                <div class="documents-list">
                    ${p.documents.map(doc => {
                const iconClass = doc.type === 'pdf' ? 'pdf-icon' :
                    doc.type === 'doc' ? 'doc-icon' : 'xls-icon';
                const icon = doc.type === 'pdf' ? 'fa-file-pdf' :
                    doc.type === 'doc' ? 'fa-file-word' : 'fa-file-excel';
                return `
                            <a href="${doc.url}" target="_blank" class="document-item">
                                <i class="fas ${icon} document-icon ${iconClass}"></i>
                                <span>${doc.name}</span>
                            </a>
                        `;
            }).join('')}
                </div>
            ` : '';

            const videoHtml = p.video ? `
                <h6>Video:</h6>
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/${getYouTubeId(p.video)}"
                            title="${p.name}" allowfullscreen></iframe>
                </div>
            ` : '';

            const detailBody = document.getElementById('detailModalBody');
            detailBody.innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <img src="${p.image}" class="img-fluid rounded mb-3" alt="${p.name}">
                ${videoHtml}
                ${galleryHtml}
            </div>
            <div class="col-md-6">
                <h4>${p.name}</h4>
                <p><strong>ID:</strong> ${p.id}</p>
                <p><strong>Tavsif:</strong> ${p.description}</p>
                <p><strong>Maqsad:</strong> ${p.goal}</p>
                <p><strong>Kategoriya:</strong> ${p.category}</p>
                <p><strong>Holat:</strong> <span class="badge-status status-${p.status}">${p.status}</span></p>
                <p><strong>Xavf:</strong> <span class="badge-risk risk-${p.risk}">${p.risk}</span></p>
                <p><strong>Manzil:</strong> ${p.location}</p>
                <p><strong>Qiymati:</strong> ${formatCurrency(p.value)}</p>
                <p><strong>Progress:</strong> ${p.progress}%</p>
                <p><strong>Moliyalashtirish:</strong> ${p.funding}%</p>
                <p><strong>Raundlar:</strong> ${p.currentRound}/${p.totalRounds}</p>
                <p><strong>Min. ulush:</strong> ${formatCurrency(p.minShare)}</p>
                <p><strong>Davomiyligi:</strong> ${p.duration}</p>
                <p><strong>Rentabellik:</strong> ${p.roi}%</p>
                <p><strong>Oxirgi dividend:</strong> ${p.lastDividend}%</p>
                <p><strong>Quruvchi:</strong> ${p.builder}</p>
                <p><strong>Boshqaruvchi:</strong> ${p.manager}</p>

                ${documentsHtml}
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <h5>Loyiha Timeline</h5>
                <div class="timeline">
                    ${timelineHtml}
                </div>
            </div>
        </div>
    `;
            detailModal.show();
        }

        function getYouTubeId(url) {
            const match = url.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/);
            return match ? match[1] : null;
        }

        function editProject(idx, p) {
            editingIndex = idx;
            modalTitle.textContent = 'Loyihani tahrirlash';

            document.getElementById('projectName').value = p.name;
            document.getElementById('projectCategory').value = p.category;
            document.getElementById('projectStatus').value = p.status;
            document.getElementById('projectRisk').value = p.risk;
            document.getElementById('projectImage').value = p.image;
            document.getElementById('projectVideo').value = p.video || '';
            document.getElementById('projectConstructionImages').value = p.constructionImages ? p.constructionImages.join(', ') : '';
            document.getElementById('projectDescription').value = p.description;
            document.getElementById('projectGoal').value = p.goal;
            document.getElementById('projectLocation').value = p.location;
            document.getElementById('projectValue').value = p.value;
            document.getElementById('projectProgress').value = p.progress;
            document.getElementById('projectFunding').value = p.funding;
            document.getElementById('projectTotalRounds').value = p.totalRounds;
            document.getElementById('projectCurrentRound').value = p.currentRound;
            document.getElementById('projectMinShare').value = p.minShare;
            document.getElementById('projectDuration').value = p.duration;
            document.getElementById('projectROI').value = p.roi;
            document.getElementById('projectLastDividend').value = p.lastDividend;
            document.getElementById('projectBuilder').value = p.builder;
            document.getElementById('projectManager').value = p.manager;

            // Timeline
            const timelineText = p.timeline ? p.timeline.map(item =>
                `${item.stage}|${item.date}|${item.status}`
            ).join('\n') : '';
            document.getElementById('projectTimeline').value = timelineText;

            // Documents
            const documentsText = p.documents ? p.documents.map(doc =>
                `${doc.name}|${doc.url}|${doc.type}`
            ).join('\n') : '';
            document.getElementById('projectDocuments').value = documentsText;

            projectModal.show();
        }

        function deleteProject(idx) {
            if (confirm('Rostdan ham bu loyihani o\'chirmoqchimisiz?')) {
                projects.splice(idx, 1);
            }
        }

        function applyFilter() {
            const search = searchInput.value.toLowerCase();
            const cat = categoryFilter.value;
            const stat = statusFilter.value;
            const risk = riskFilter.value;

            const filtered = projects.filter(p => {
                return (p.name.toLowerCase().includes(search) || p.id.toLowerCase().includes(search)) &&
                    (cat === 'all' || p.category === cat) &&
                    (stat === 'all' || p.status === stat) &&
                    (risk === 'all' || p.risk === risk);
            });

            renderProjects(filtered);
        }

        filterBtn.addEventListener('click', applyFilter);
        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            categoryFilter.value = 'all';
            statusFilter.value = 'all';
            riskFilter.value = 'all';
        });

        searchInput.addEventListener('input', applyFilter);

        addProjectBtn.addEventListener('click', () => {
            editingIndex = null;
            modalTitle.textContent = 'Yangi loyiha qo\'shish';

            // Reset all fields
            document.getElementById('projectName').value = '';
            document.getElementById('projectCategory').value = 'yer';
            document.getElementById('projectStatus').value = 'faol';
            document.getElementById('projectRisk').value = 'orta';
            document.getElementById('projectImage').value = '';
            document.getElementById('projectVideo').value = '';
            document.getElementById('projectConstructionImages').value = '';
            document.getElementById('projectDescription').value = '';
            document.getElementById('projectGoal').value = '';
            document.getElementById('projectLocation').value = '';
            document.getElementById('projectValue').value = '';
            document.getElementById('projectProgress').value = '0';
            document.getElementById('projectFunding').value = '0';
            document.getElementById('projectTotalRounds').value = '1';
            document.getElementById('projectCurrentRound').value = '1';
            document.getElementById('projectMinShare').value = '';
            document.getElementById('projectDuration').value = '';
            document.getElementById('projectROI').value = '';
            document.getElementById('projectLastDividend').value = '0';
            document.getElementById('projectBuilder').value = '';
            document.getElementById('projectManager').value = '';
            document.getElementById('projectTimeline').value = '';
            document.getElementById('projectDocuments').value = '';

            projectModal.show();
        });

        saveProjectBtn.addEventListener('click', () => {
            // Parse timeline
            const timelineText = document.getElementById('projectTimeline').value;
            const timeline = timelineText ? timelineText.split('\n').map(line => {
                const [stage, date, status] = line.split('|');
                return { stage: stage?.trim(), date: date?.trim(), status: status?.trim() || 'pending' };
            }).filter(item => item.stage && item.date) : [];

            // Parse documents
            const documentsText = document.getElementById('projectDocuments').value;
            const documents = documentsText ? documentsText.split('\n').map(line => {
                const [name, url, type] = line.split('|');
                return { name: name?.trim(), url: url?.trim(), type: type?.trim() || 'pdf' };
            }).filter(doc => doc.name && doc.url) : [];

            // Parse construction images
            const constructionImagesText = document.getElementById('projectConstructionImages').value;
            const constructionImages = constructionImagesText ?
                constructionImagesText.split(',').map(url => url.trim()).filter(url => url) : [];

            const newProject = {
                id: editingIndex === null ? `PRJ${String(projects.length + 1).padStart(3, '0')}` : projects[editingIndex].id,
                name: document.getElementById('projectName').value,
                category: document.getElementById('projectCategory').value,
                status: document.getElementById('projectStatus').value,
                risk: document.getElementById('projectRisk').value,
                image: document.getElementById('projectImage').value || 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=400',
                video: document.getElementById('projectVideo').value,
                constructionImages: constructionImages,
                description: document.getElementById('projectDescription').value,
                goal: document.getElementById('projectGoal').value,
                location: document.getElementById('projectLocation').value,
                value: parseFloat(document.getElementById('projectValue').value) || 0,
                progress: parseInt(document.getElementById('projectProgress').value) || 0,
                funding: parseInt(document.getElementById('projectFunding').value) || 0,
                totalRounds: parseInt(document.getElementById('projectTotalRounds').value) || 1,
                currentRound: parseInt(document.getElementById('projectCurrentRound').value) || 1,
                minShare: parseFloat(document.getElementById('projectMinShare').value) || 0,
                duration: document.getElementById('projectDuration').value,
                roi: parseFloat(document.getElementById('projectROI').value) || 0,
                lastDividend: parseFloat(document.getElementById('projectLastDividend').value) || 0,
                timeline: timeline,
                documents: documents,
                builder: document.getElementById('projectBuilder').value,
                manager: document.getElementById('projectManager').value
            };

            if (editingIndex !== null) {
                projects[editingIndex] = newProject;
            } else {
                projects.push(newProject);
            }

            projectModal.hide();
            applyFilter();
        });

        // Dastlabki render
        renderProjects(projects);
    </script>
@endpush
