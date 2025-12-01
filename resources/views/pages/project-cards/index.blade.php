@extends('layouts.app')

@push('customCss')
<style>
    .filter-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .projects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .project-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .project-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.2);
    }
    
    .project-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
    }
    
    .project-content {
        padding: 1.5rem;
    }
    
    .project-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }
    
    .project-location {
        color: #718096;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    
    .project-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .stat-item {
        text-align: center;
        padding: 0.8rem;
        background: #f7fafc;
        border-radius: 8px;
    }
    
    .stat-label {
        font-size: 0.75rem;
        color: #718096;
        margin-bottom: 0.3rem;
    }
    
    .stat-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #667eea;
    }
    
    .project-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #e2e8f0;
    }
    
    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .status-nofaol {
        background: #e2e8f0;
        color: #4a5568;
    }
    
    .status-rejalashtirilgan {
        background: #bee3f8;
        color: #2c5282;
    }
    
    .status-faol {
        background: #c6f6d5;
        color: #22543d;
    }
    
    .status-yakunlangan {
        background: #fed7d7;
        color: #742a2a;
    }
    
    .view-details-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    
    .view-details-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .risk-indicator {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }
    
    .risk-past {
        background: rgba(198, 246, 213, 0.9);
        color: #22543d;
    }
    
    .risk-orta {
        background: rgba(254, 235, 200, 0.9);
        color: #744210;
    }
    
    .risk-yuqori {
        background: rgba(254, 215, 215, 0.9);
        color: #742a2a;
    }
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
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="#" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> {{__('admin.add_project')}}
        </a>
    </div>
</div>
@endsection

@section('content')
<!-- Filter -->
@include('pages.project-cards._filter')

<!-- Projects Grid -->
<div class="projects-grid" id="projectsGrid">
    @include('pages.project-cards._project_card', [
        'id' => 1,
        'name' => 'Toshkent Biznes Markazi',
        'location' => 'Toshkent sh., Chilonzor tumani',
        'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=600',
        'min_investment' => '5,000,000',
        'duration' => '18',
        'annual_return' => '28',
        'status' => 'faol',
        'risk' => 'orta'
    ])
    
    @include('pages.project-cards._project_card', [
        'id' => 2,
        'name' => 'Samarqand Turizm Kompleksi',
        'location' => 'Samarqand sh., Registon maydoni',
        'image' => 'https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=600',
        'min_investment' => '10,000,000',
        'duration' => '24',
        'annual_return' => '32',
        'status' => 'rejalashtirilgan',
        'risk' => 'past'
    ])
    
    @include('pages.project-cards._project_card', [
        'id' => 3,
        'name' => 'Andijon Savdo Majmuasi',
        'location' => 'Andijon sh., Markaz',
        'image' => 'https://images.unsplash.com/photo-1582407947304-fd86f028f716?w=600',
        'min_investment' => '3,000,000',
        'duration' => '12',
        'annual_return' => '22',
        'status' => 'faol',
        'risk' => 'past'
    ])
    
    @include('pages.project-cards._project_card', [
        'id' => 4,
        'name' => 'Buxoro Tarixiy Hotel',
        'location' => 'Buxoro sh., Eski shahar',
        'image' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=600',
        'min_investment' => '15,000,000',
        'duration' => '36',
        'annual_return' => '35',
        'status' => 'faol',
        'risk' => 'yuqori'
    ])
    
    @include('pages.project-cards._project_card', [
        'id' => 5,
        'name' => 'Farg\'ona Ishlab Chiqarish Zonasi',
        'location' => 'Farg\'ona sh., Sanoat hududi',
        'image' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=600',
        'min_investment' => '20,000,000',
        'duration' => '30',
        'annual_return' => '40',
        'status' => 'rejalashtirilgan',
        'risk' => 'yuqori'
    ])
    
    @include('pages.project-cards._project_card', [
        'id' => 6,
        'name' => 'Namangan Qishloq Xo\'jaligi',
        'location' => 'Namangan viloyati',
        'image' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=600',
        'min_investment' => '2,000,000',
        'duration' => '15',
        'annual_return' => '25',
        'status' => 'yakunlangan',
        'risk' => 'orta'
    ])
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">{{__('admin.previous')}}</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">{{__('admin.next')}}</a>
            </li>
        </ul>
    </nav>
</div>
@endsection

@push('customJs')
<script>
    // Filter functionality
    document.getElementById('filterBtn').addEventListener('click', function() {
        const search = document.getElementById('searchInput').value;
        const category = document.getElementById('categoryFilter').value;
        const status = document.getElementById('statusFilter').value;
        const risk = document.getElementById('riskFilter').value;
        
        console.log('Filtering...', {search, category, status, risk});
        // AJAX call yoki form submit
    });
    
    document.getElementById('clearBtn').addEventListener('click', function() {
        document.getElementById('searchInput').value = '';
        document.getElementById('categoryFilter').value = 'all';
        document.getElementById('statusFilter').value = 'all';
        document.getElementById('riskFilter').value = 'all';
    });
</script>
@endpush