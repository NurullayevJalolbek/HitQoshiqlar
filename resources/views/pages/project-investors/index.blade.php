@extends('layouts.app')

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#"><img src="{{ asset('svg/home-2.svg') }}" alt="Home"></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('admin.Investors') }}</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')

<div class="table-settings mb-4">
    <div class="row align-items-center g-3">

        {{-- SEARCH + FILTERS --}}
        <div class="col-12 col-md-9 col-lg-8">
            @include('pages.project-investors.filters')
        </div>

        {{-- CREATE BUTTON --}}
        <div class="col-12 col-md-3 col-lg-4">
            <div class="d-flex justify-content-md-end flex-wrap gap-2">
                <a href="{{ route('admin.investors.create') }}"
                   class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                    <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    {{ __('admin.Add') }}
                </a>
            </div>
        </div>

    </div>
</div>

<div class="card card-body shadow border-0 table-wrapper table-responsive">
    @include('pages.project-investors._columns')
</div>

@endsection

@push('customJs')
@include('pages.project-investors._scripts')
@endpush
