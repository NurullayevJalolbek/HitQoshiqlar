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
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <!-- Breadcrumb -->
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.project_buyers') }}</li>
                </ol>
            </nav>
        </div>

        <!-- Tugmalar guruhi -->
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center"
                    type="button" data-bs-toggle="collapse"
                    data-bs-target="#projectBuyerFilterContent" aria-expanded="true"
                    aria-controls="projectBuyerFilterContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
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

    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table user-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
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
