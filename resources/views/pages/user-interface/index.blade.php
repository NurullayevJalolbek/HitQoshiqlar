@extends('layouts.app')

@push('customCss')
    <style>
        .card-section {
            background-color: #ffffff; /* Kartaning fon rangi oq */
            border: 2px solid #ffffff; /* Border rangi ham oq */
            border-radius: 12px;
            padding: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
            text-align: center;
            /* Ajralib turishi uchun shadow qo‘shish mumkin */
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .card-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card-icon {
            font-size: 2rem;
            color: #374151; /* Icon rangi */
            margin-bottom: 10px;
        }

        .card-title {
            font-weight: 600;
            font-size: 1rem;
            color: #374151; /* Text rangi */
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
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.user_interface') }}</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <div class="row g-4 mt-2">

        <div class="col-md-4">
            <a href="{{ route('admin.user-interface.language-management.index') }}" class="text-decoration-none">
                <div class="card-section">
                    <div class="card-icon">
                        <i class="fas fa-language"></i>
                    </div>
                    <div class="card-title">Tillarni boshqarish</div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('admin.user-interface.system-translations.index') }}" class="text-decoration-none">
                <div class="card-section">
                    <div class="card-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="card-title">Interfeys matnlarini tarjima qilish</div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <div class="card-section">
                <div class="card-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="card-title">Statik sahifalar va ma’lumotlar</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-section">
                <div class="card-icon">
                    <i class="fas fa-image"></i>
                </div>
                <div class="card-title">Multimedia va vizual elementlar</div>
            </div>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.user-interface.template-messages.index') }}" class="text-decoration-none">
                <div class="card-section">
                    <div class="card-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="card-title">Shablon xabarlar matni</div>
                </div>
            </a>
        </div>
    </div>
@endsection

@push('customJs')
    <script>
        // JS Kodlar (agar kerak bo'lsa)
    </script>
@endpush
