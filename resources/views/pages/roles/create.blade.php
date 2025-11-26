@extends('layouts.app')

@push('customCss')

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
                    <li class="breadcrumb-item">
                        <a href="#">Rollar</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Role yaratish</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-xl-12">
            <div class="card card-body border-0 shadow mb-4">
                <h2 class="h5 mb-4">Role Yaratish</h2>
                <form method="POST" action="#" class="needs-validation" enctype="multipart/form-data" novalidate>

                    <div class="row g-3">
                        <!-- Role nomi -->
                        <div class="col-md-6">
                            <label for="roleName" class="form-label">Role Nomi</label>
                            <input type="text" class="form-control" id="roleName"  required>
                            <div class="invalid-feedback">
                                Role nomini kiriting.
                            </div>
                        </div>

                        <!-- Role kodi -->
                        <div class="col-md-6">
                            <label for="roleCode" class="form-label">Role Kodi</label>
                            <input type="text" class="form-control" id="roleCode" required>
                            <div class="invalid-feedback">
                                Role kodini kiriting.
                            </div>
                        </div>
                    </div>

                    <!-- Tavsifi -->
                    <div class="mb-3">
                        <label for="roleDescription" class="form-label">Tavsifi</label>
                        <textarea class="form-control" id="roleDescription" rows="3"
                                  ></textarea>
                    </div>

                    <!-- Ikonka (ixtiyoriy) -->
                    <div class="mb-3">
                        <label class="form-label">Ikonka (ixtiyoriy)</label>
                        <div class="input-group">
                            <input type="text" class="form-control" >
                        </div>
                    </div>
                    <!-- Submit tugma -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary me-2" type="reset">Bekor qilish</a>
                        <button class="btn btn-primary" type="submit">Saqlash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('customJs')
@endpush
