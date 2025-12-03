@extends('layouts.app')

@push('customCss')
    {{--    CSS Ko'dlari--}}
@endpush


@section('breadcrumb')
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-3 breadcrumb-block px-3 mt-3"
        style="border: 1px solid rgba(0,0,0,0.05); border-radius: 0.5rem; background-color: #ffffff; height: 60px">
        <!-- Breadcrumb -->
        <div class="d-block mb-2 mb-md-0">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.user-interface.index') }}">
                            {{ __('admin.user_interface') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Tillarni boshqarish
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Tugmalar guruhi -->
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <div class="d-flex gap-4">
                <button class="btn btn-primary btn-sm">
                    {{__('admin.create')}}
                </button>
            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- 1. TILLARNI BOSHQARISH --}}
    <div class="card card-body shadow-sm mb-3 mt-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="section-title">
                <i class="fas fa-language me-1"></i> Tillarni boshqarish
            </div>


        </div>

        <table class="table language-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
            <tr>
                <th style="width:50px;">№</th>
                <th>Til nomi</th>
                <th style="width:90px;">Kodi</th>
                <th style="width:120px;">Holati</th>
                <th style="width:120px;">Asosiy til</th>
                <th style="width:120px;" class="text-center">Amallar</th>
            </tr>
            </thead>

            <tbody>
            {{-- 1. Uzbek --}}
            <tr>
                <td>1</td>
                <td>O‘zbek</td>
                <td>uz</td>
                <td><span class="badge bg-success">Faol</span></td>
                <td><span class="badge bg-primary">Default</span></td>
                <td class="text-center d-flex justify-content-center gap-2">
                    <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <a href="#" class="btn btn-sm p-1 delete-role" style="background:none;color:#DC2626;">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>

            {{-- 2. Russian --}}
            <tr>
                <td>2</td>
                <td>Русский</td>
                <td>ru</td>
                <td><span class="badge bg-success">Faol</span></td>
                <td>—</td>
                <td class="text-center d-flex justify-content-center gap-2">
                    <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <a href="#" class="btn btn-sm p-1 delete-role" style="background:none;color:#DC2626;">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>


            {{-- 3. English --}}
            <tr>
                <td>3</td>
                <td>English</td>
                <td>en</td>
                <td><span class="badge bg-secondary">NoFaol</span></td>
                <td>—</td>
                <td class="text-center d-flex justify-content-center gap-2">
                    <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <a href="#" class="btn btn-sm p-1 delete-role" style="background:none;color:#DC2626;">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>

            {{-- 4. Arabic --}}
            <tr>
                <td>4</td>
                <td>العربية</td>
                <td>ar</td>
                <td><span class="badge bg-secondary">NoFaol</span></td>
                <td>—</td>
                <td class="text-center d-flex justify-content-center gap-2">
                    <a href="#" class="btn btn-sm p-1" style="background:none;color:#f0bc74;">
                        <i class="bi bi-pencil-fill"></i>
                    </a>
                    <a href="#" class="btn btn-sm p-1 delete-role" style="background:none;color:#DC2626;">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>

            </tbody>
        </table>
    </div>
@endsection

@push('customJs')
    <script>
        // JS Ko'dlar'
    </script>
@endpush
