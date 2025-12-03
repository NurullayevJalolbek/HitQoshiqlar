@extends('layouts.app')

@push('customCss')
    <style>
        /* Kartochkalar dizayni - Rasmdagi uslub */
        .directory-card {
            border: none;
            border-radius: 12px; /* Burchaklar biroz yumshoqroq */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); /* Yengil soya */
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            text-decoration: none !important;
            height: 100%;
            background-color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
        }

        /* Hover effekti */
        .directory-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .directory-card .card-body {
            text-align: center;
            width: 100%;
        }

        /* Iconlar stili */
        .directory-icon {
            font-size: 2.5rem;
            color: #344767; /* To'q ko'k/kulrang tus (rasmdagidek) */
            margin-bottom: 1rem;
        }

        /* Matn stili */
        .directory-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #344767;
            margin-bottom: 0.5rem;
        }

        /* Kichik tavsif matni (ixtiyoriy, agar kerak bo'lsa) */
        .directory-subtitle {
            font-size: 0.85rem;
            color: #7b809a;
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
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.references') }}</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection


@section('content')
    <div class="row mt-3">
        {{-- 1. Geografik ma'lumotlar (Hujjatdan) --}}
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <a href="#" class="card directory-card">
                <div class="card-body">
                    <i class="fas fa-map-marked-alt directory-icon"></i>
                    <h5 class="directory-title">Geografik ma'lumotlar</h5>
                    <p class="directory-subtitle">Davlatlar, mintaqalar, shaharlar va pochta indekslari</p>
                </div>
            </a>
        </div>

        {{-- 2. Mahsulot va xizmat toifalari (Hujjatdan) --}}
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <a href="#" class="card directory-card">
                <div class="card-body">
                    <i class="fas fa-layer-group directory-icon"></i>
                    <h5 class="directory-title">Mahsulot va xizmat toifalari</h5>
                    <p class="directory-subtitle">Kategoriyalar va tasniflash elementlari</p>
                </div>
            </a>
        </div>

        {{-- 3. O'lchov birliklari va Valyutalar (Hujjatdan - kategoriyalar ichida aytilgan) --}}
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <a href="#" class="card directory-card">
                <div class="card-body">
                    <i class="fas fa-coins directory-icon"></i>
                    <h5 class="directory-title">Valyutalar va O'lchov birliklari</h5>
                    <p class="directory-subtitle">Tizimda ishlatiladigan birliklar ro'yxati</p>
                </div>
            </a>
        </div>

        {{-- 4. Tashkilotga oid ma'lumotlar (Hujjatdan) --}}
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <a href="#" class="card directory-card">
                <div class="card-body">
                    <i class="fas fa-building directory-icon"></i>
                    <h5 class="directory-title">Tashkilot ma'lumotlari</h5>
                    <p class="directory-subtitle">Kontaktlar, filiallar, bo'limlar va lavozimlar</p>
                </div>
            </a>
        </div>

        {{-- 5. Bank rekvizitlari va Banklar (Hujjatdan) --}}
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <a href="#" class="card directory-card">
                <div class="card-body">
                    <i class="fas fa-university directory-icon"></i>
                    <h5 class="directory-title">Banklar va Rekvizitlar</h5>
                    <p class="directory-subtitle">Banklar ro'yxati va hisob raqamlar</p>
                </div>
            </a>
        </div>

        {{-- 6. Huquqiy hujjatlar va Siyosat (Hujjatdan: Maxfiylik, shartlar, ta'sis) --}}
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <a href="#" class="card directory-card">
                <div class="card-body">
                    <i class="fas fa-file-contract directory-icon"></i>
                    <h5 class="directory-title">Huquqiy hujjatlar</h5>
                    <p class="directory-subtitle">Maxfiylik siyosati, Foydalanish va Ta'sis shartlari</p>
                </div>
            </a>
        </div>
    </div>
@endsection

@push('customJs')
    <script>
        // Hozircha statik sahifa, shuning uchun JS shart emas
    </script>
@endpush
