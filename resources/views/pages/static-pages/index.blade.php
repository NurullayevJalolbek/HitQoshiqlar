@extends('layouts.app')

@push('customCss')
<style>
    .static-page textarea {
        width: 100%;
        min-height: 200px;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ced4da;
        resize: vertical;
        font-family: inherit;
    }

    .static-page .card {
        margin-bottom: 20px;
    }

    /* Edit mode uchun style */
    .static-page .card.editable {
        border: 2px solid #0d6efd;
    }

    .static-page .edit-controls {
        display: none;
    }

    .static-page .card.editable .edit-controls {
        display: block;
    }
</style>
@endpush

@section('breadcrumb')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
    style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
    <!-- Breadcrumb -->
    <div class="d-block mb-2 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent mb-0">
                <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">Statik sahifalar</li>
            </ol>
        </nav>
    </div>

    <!-- Tugmalar guruhi -->
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <!-- Yangi foydalanuvchi qo'shish (Edit mode uchun) -->
        <a href="{{ route('admin.user-interface.static-pages.create') }}" type="button" class="btn btn-primary btn-sm px-3 py-1"
            style="min-width: 90px;">
            <i class="fas fa-edit me-1" style="font-size: 0.85rem;"></i> {{ __('admin.create') }}
        </a>
    </div>
</div>
@endsection
@section('content')
@php
$datas = getStaticPages();
@endphp

<div class="static-page mt-3">

    @foreach($datas as $page)
    <div class="card p-3 mb-3" id="static-page-{{ $page['id'] }}">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">{{ $page['title'] }}</h5>

            <div class="d-flex gap-2">
                <x-edit-button href="{{ route('admin.user-interface.static-pages.edit', $page['id']) }}" />
                <x-delete-button />
            </div>
        </div>


        <textarea
            class="form-control"
            rows="6"
            readonly
            id="content-{{ $page['id'] }}">{{ $page['description'] }}</textarea>

    </div>
    @endforeach

</div>
@endsection


@push('customJs')
<script>
    //
</script>

@endpush