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
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-transparent mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.seo-settings.index') }}">SEO</a>
            </li>
            <li class="breadcrumb-item active">Tahrirlash</li>
        </ol>
    </nav>
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

                    {{-- ================== GENERAL SEO ================== --}}
                    <div class="seo-section">
                        <div class="seo-section-title">
                            <i class="fas fa-globe"></i> Umumiy SEO
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                <input type="text" name="general[title]" class="form-control"
                                    value="{{ $model['general']['title'] }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keywords</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="text" name="general[keywords]" class="form-control"
                                    value="{{ $model['general']['keywords'] }}">
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Description</label>
                            <textarea name="general[description]" rows="3"
                                class="form-control">{{ $model['general']['description'] }}</textarea>
                        </div>
                    </div>

                    {{-- ================== HOME PAGE ================== --}}
                    <div class="seo-section">
                        <div class="seo-section-title">
                            <i class="fas fa-home"></i> Asosiy sahifa SEO
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="home[title]" class="form-control"
                                value="{{ $model['home']['title'] }}">
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Meta Description</label>
                            <textarea name="home[description]" rows="2"
                                class="form-control">{{ $model['home']['description'] }}</textarea>
                        </div>
                    </div>

                    {{-- ================== PROJECTS ================== --}}
                    <div class="seo-section">
                        <div class="seo-section-title">
                            <i class="fas fa-building"></i> Loyihalar sahifasi SEO
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" name="projects[title]" class="form-control"
                                value="{{ $model['projects']['title'] }}">
                        </div>

                        <div class="mb-0">
                            <label class="form-label">Meta Description</label>
                            <textarea name="projects[description]" rows="2"
                                class="form-control">{{ $model['projects']['description'] }}</textarea>
                        </div>
                    </div>

                    {{-- ================== OPEN GRAPH ================== --}}
                    <div class="seo-section">
                        <div class="seo-section-title">
                            <i class="fab fa-facebook"></i> Open Graph (Social)
                        </div>

                        <div class="mb-3">
                            <label class="form-label">OG Title</label>
                            <input type="text" name="og[title]" class="form-control"
                                value="{{ $model['og']['title'] }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">OG Description</label>
                            <textarea name="og[description]" rows="2"
                                class="form-control">{{ $model['og']['description'] }}</textarea>
                        </div>

                        <div class="mb-0">
                            <label class="form-label">OG Image URL</label>
                            <input type="text" name="og[image]" class="form-control"
                                value="{{ $model['og']['image'] }}">
                        </div>
                    </div>

                    {{-- ================== SAVE ================== --}}
                    <div class="d-flex justify-content-end mt-4">
                        <button class="btn btn-save">
                            <i class="fas fa-save"></i> Saqlash
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection