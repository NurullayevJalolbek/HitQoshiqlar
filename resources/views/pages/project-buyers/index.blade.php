@extends('layouts.app')

@push('customCss')
    <style>
        .table-actions button,
        .table-actions a {
            transition: transform 0.2s;
        }
        .table-actions button:hover,
        .table-actions a:hover {
            transform: scale(1.1);
        }
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        .loading-overlay.active {
            display: flex;
        }
        .empty-state {
            padding: 3rem 0;
        }
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
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Лойиҳа сотиб олганлар') }}
                    </li>
                </ol>
            </nav>
            <h2 class="h4">{{ __('Лойиҳа сотиб олганлар (Buyers)') }}</h2>
        </div>
    </div>
@endsection

@section('content')
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">{{ __('Юкланмоқда...') }}</span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- FILTERLAR --}}
    @include('pages.project-buyers.filters')

    <div class="card card-body shadow border-0 table-wrapper table-responsive">
        <table class="table table-hover table-bordered mt-3">
            <thead class="table-light">
                @include('pages.project-buyers._columns')
            </thead>
            <tbody id="purchaser-table-body">
                <!-- JavaScript bilan to'ldiriladi -->
            </tbody>
        </table>

        <div id="emptyState" class="empty-state text-center" style="display: none;">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <p class="text-muted">{{ __('Маълумотлар топилмади') }}</p>
        </div>
    </div>
@endsection

@push('customJs')
    @include('pages.project-buyers._scripts')
@endpush
