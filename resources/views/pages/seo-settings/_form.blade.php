@extends('layouts.app')

@push('customCss')
<style>
    .seo-section {
        background: #ffffff;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        border-left: 5px solid #1F2937;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .seo-section-title {
        font-weight: 600;
        font-size: 16px;
        color: #1F2937;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 500;
        color: #374151;
    }

    .form-control {
        border-radius: 8px;
        padding: 10px 14px;
    }

    .form-control:focus {
        border-color: #1F2937;
        box-shadow: 0 0 0 0.15rem rgba(31, 41, 55, 0.15);
    }

    .input-group-text {
        /* background: #1F2937; */
        color: #ffffff;
        border: -4px solid #1F2937;
        border-radius: 8px 0 0 8px;
    }

    .btn-save {
        background: #1F2937;
        border-color: #1F2937;
        padding: 10px 24px;
        font-weight: 500;
    }

    .btn-save:hover {
        background: #111827;
        border-color: #111827;
    }

    textarea {
        resize: vertical;
    }
</style>
@endpush

@section('breadcrumb')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
    style="border:1px solid rgba(0,0,0,0.05);border-radius:0.5rem;background:#fff;height:60px">

    <div class="d-block mb-2 mb-md-0">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-transparent mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Umumiy sozlamalar
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.seo-settings.index') }}">SEO Sozlamalari</a>
                </li>
                <li class="breadcrumb-item active">Tahrirlash</li>
            </ol>
        </nav>
    </div>


    <div class="d-flex gap-2 align-items-center flex-wrap">

        <x-go-back url="{{ $go_back }}" />
    </div>
</div>

@endsection

@section('content')

<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow">
            <div class="card-body">

                <h2 class="h5 mb-4">
                    <i class="fas fa-search text-dark"></i> SEO ma’lumotlarini tahrirlash
                </h2>

                <form method="POST" action="#" novalidate>
                    @csrf

                    <div class="seo-section">
                        <div class="seo-section-title">
                            <i class="fas {{ $model->icon }}"></i>
                            <span>{{ $model->name }}</span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                <input type="text" name="general[title]" class="form-control"
                                    value="{{ $model->title }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keywords</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="text" name="general[keywords]" class="form-control"
                                    value="{{ $model->keywords }}">
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Description</label>
                            <textarea name="general[description]" rows="3"
                                class="form-control">{{ $model->description }}</textarea>
                        </div>
                    </div>


                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end mt-3 gap-2">
                        <!-- <a href="{{ route('admin.seo-settings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Bekor qilish
                        </a> -->

                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-save me-1"></i>
                            Yangilash
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection