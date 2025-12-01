@extends('layouts.app')

@push('customCss')
<style>
    .stat-card {
        border-left: 4px solid #3b82f6;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .stat-card.success { border-left-color: #16a34a; }
    .stat-card.warning { border-left-color: #f59e0b; }
    .stat-card.info { border-left-color: #06b6d4; }
    .tab-button {
        border-bottom: 2px solid transparent;
        transition: all 0.3s;
    }
    .tab-button.active {
        border-bottom-color: #3b82f6;
        color: #3b82f6;
        font-weight: 600;
    }
    .tab-content-item {
        display: none;
    }
    .tab-content-item.active {
        display: block;
        animation: fadeIn 0.3s;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 14px;
    }
    .status-paid { background-color: #dcfce7; color: #166534; }
    .status-pending { background-color: #fef3c7; color: #92400e; }
    .status-rejected { background-color: #fee2e2; color: #991b1b; }
</style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4 breadcrumb-block">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.incomes.index') }}">{{ __('Даромадлар') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __('Бизнес Марказ — Даромадлар') }}
                </li>
            </ol>
        </nav>
        <h2 class="h4">{{ __('Бизнес Марказ — Даромадлар тафсилоти') }}</h2>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.incomes.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('Орқага') }}
        </a>
    </div>
</div>
@endsection

@section('content')
    {{-- SUMMARY STATISTICS --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card p-4 stat-card success">
                <div class="text-muted small">{{ __('Жами даромад') }}</div>
                <div class="h3 mb-0 mt-2">120,000,000 {{ __('сўм') }}</div>
                <div class="text-muted small mt-2">
                    <i class="fas fa-arrow-up text-success"></i> 
                    {{ __('15% ўсиш') }}
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card p-4 stat-card warning">
                <div class="text-muted small">{{ __('Тўлов ҳолати') }}</div>
                <div class="mt-2">
                    <span class="status-badge status-paid">
                        <i class="fas fa-check-circle"></i> {{ __('Тўланди') }}
                    </span>
                </div>
                <div class="text-muted small mt-2">{{ __('12.11.2025 санада') }}</div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card p-4 stat-card info">
                <div class="text-muted small">{{ __('Тақсимот муддати') }}</div>
                <div class="h3 mb-0 mt-2">01.12.2025</div>
                <div class="text-muted small mt-2">
                    <i class="fas fa-clock"></i> {{ __('Режалаштирилган') }}
                </div>
            </div>
        </div>
    </div>

    {{-- TABS --}}
    <div class="card shadow border-0">
        <div class="card-header bg-white">
            <div class="d-flex gap-4 border-bottom">
                <button class="btn btn-link tab-button active" data-tab="ijara">
                    <i class="fas fa-building"></i> {{ __('Ижара') }}
                </button>
                <button class="btn btn-link tab-button" data-tab="qurilish">
                    <i class="fas fa-hard-hat"></i> {{ __('Қурилиш') }}
                </button>
                <button class="btn btn-link tab-button" data-tab="yer">
                    <i class="fas fa-map"></i> {{ __('Ер') }}
                </button>
            </div>
        </div>

        <div class="card-body">
            {{-- IJARA TAB --}}
            <div class="tab-content-item active" data-tab-content="ijara">
                <h5 class="mb-3">{{ __('Ижара даромадлари') }}</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('Объект номи') }}</th>
                                <th>{{ __('Ижарачи') }}</th>
                                <th>{{ __('Ойлик тўлов') }}</th>
                                <th>{{ __('Шартнома') }}</th>
                                <th>{{ __('Ҳолат') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Офис №12, 3-қават</td>
                                <td>ООО "TechSoft"</td>
                                <td class="fw-bold">5,000,000 {{ __('сўм') }}</td>
                                <td>№ 2024/45</td>
                                <td><span class="status-badge status-paid">{{ __('Тўланди') }}</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Савдо майдони №8</td>
                                <td>ИП Karimov A.</td>
                                <td class="fw-bold">3,500,000 {{ __('сўм') }}</td>
                                <td>№ 2024/67</td>
                                <td><span class="status-badge status-paid">{{ __('Тўланди') }}</span></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Офис №25, 5-қават</td>
                                <td>ООО "Digital Agency"</td>
                                <td class="fw-bold">4,000,000 {{ __('сўм') }}</td>
                                <td>№ 2024/89</td>
                                <td><span class="status-badge status-pending">{{ __('Кутилмоқда') }}</span></td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">{{ __('Жами:') }}</th>
                                <th class="text-primary">12,500,000 {{ __('сўм') }}</th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- QURILISH TAB --}}
            <div class="tab-content-item" data-tab-content="qurilish">
                <h5 class="mb-3">{{ __('Қурилиш сотувлари') }}</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('Квартира') }}</th>
                                <th>{{ __('Харидор') }}</th>
                                <th>{{ __('Сумма') }}</th>
                                <th>{{ __('Тўлов режаси') }}</th>
                                <th>{{ __('Ҳолат') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2-хонали, 65м², 12-қават</td>
                                <td>Rahimov Bekzod</td>
                                <td class="fw-bold">45,000,000 {{ __('сўм') }}</td>
                                <td>Бир марталик</td>
                                <td><span class="status-badge status-paid">{{ __('Тўланди') }}</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>1-хонали, 42м², 8-қават</td>
                                <td>Toshmatova Malika</td>
                                <td class="fw-bold">28,000,000 {{ __('сўм') }}</td>
                                <td>12 ой</td>
                                <td><span class="status-badge status-pending">{{ __('Кутилмоқда') }}</span></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>3-хонали, 95м², 15-қават</td>
                                <td>Ergashev Aziz</td>
                                <td class="fw-bold">62,000,000 {{ __('сўм') }}</td>
                                <td>24 ой</td>
                                <td><span class="status-badge status-paid">{{ __('Тўланди') }}</span></td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">{{ __('Жами:') }}</th>
                                <th class="text-primary">135,000,000 {{ __('сўм') }}</th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- YER TAB --}}
            <div class="tab-content-item" data-tab-content="yer">
                <h5 class="mb-3">{{ __('Ер даромадлари') }}</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('Участка') }}</th>
                                <th>{{ __('Харидор') }}</th>
                                <th>{{ __('Майдон') }}</th>
                                <th>{{ __('Сумма') }}</th>
                                <th>{{ __('Ҳолат') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Участка №15, Сектор А</td>
                                <td>Xolmatov Sardor</td>
                                <td>600 м²</td>
                                <td class="fw-bold">18,000,000 {{ __('сўм') }}</td>
                                <td><span class="status-badge status-paid">{{ __('Тўланди') }}</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Участка №22, Сектор Б</td>
                                <td>Sodiqova Nilufar</td>
                                <td>450 м²</td>
                                <td class="fw-bold">13,500,000 {{ __('сўм') }}</td>
                                <td><span class="status-badge status-paid">{{ __('Тўланди') }}</span></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Участка №8, Сектор В</td>
                                <td>Aliyev Jasur</td>
                                <td>800 м²</td>
                                <td class="fw-bold">24,000,000 {{ __('сўм') }}</td>
                                <td><span class="status-badge status-pending">{{ __('Кутилмоқда') }}</span></td>
                            </tr>
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end">{{ __('Жами:') }}</th>
                                <th class="text-primary">55,500,000 {{ __('сўм') }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="card-footer bg-light">
            <div class="row">
                <div class="col-md-6">
                    <div class="text-muted small">
                        <i class="fas fa-info-circle"></i> 
                        {{ __('Маълумотлар охирги янгиланиш: 01.12.2025 14:30') }}
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-download"></i> {{ __('Ҳисоботни юклаш') }}
                    </button>
                    <button class="btn btn-sm btn-outline-success">
                        <i class="fas fa-print"></i> {{ __('Босиб чиқариш') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- CHARTS SECTION (Optional) --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">{{ __('Даромадлар динамикаси') }}</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="200"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">{{ __('Категориялар бўйича') }}</h6>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('customJs')
<script>
(function() {
    'use strict';

    // TAB SWITCHING
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content-item');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.dataset.tab;

            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            // Add active class to clicked button and corresponding content
            this.classList.add('active');
            document.querySelector(`[data-tab-content="${targetTab}"]`).classList.add('active');
        });
    });

    // CHARTS (Optional - requires Chart.js)
    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx && typeof Chart !== 'undefined') {
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Январ', 'Феврал', 'Март', 'Апрел', 'Май', 'Июн'],
                    datasets: [{
                        label: '{{ __("Даромад (млн сўм)") }}',
                        data: [85, 92, 105, 98, 115, 120],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart');
        if (categoryCtx && typeof Chart !== 'undefined') {
            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: ['{{ __("Ижара") }}', '{{ __("Қурилиш") }}', '{{ __("Ер") }}'],
                    datasets: [{
                        data: [12.5, 135, 55.5],
                        backgroundColor: ['#3b82f6', '#16a34a', '#f59e0b']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }
    });

})();
</script>
@endpush