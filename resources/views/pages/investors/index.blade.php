@extends('layouts.app')

@push('customCss')
    <style>
        .status-active {
            color: #1e7e34;
            font-weight: bold;
        }

        .status-blocked {
            color: #bd2130;
            font-weight: bold;
        }

        .label-verified {
            background-color: #1e7e34;
            color: #fff;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 0.7rem;
            margin-left: 5px;
        }

        .label-unverified {
            background-color: #d39e00;
            color: #fff;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 0.7rem;
            margin-left: 5px;
        }

        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px 8px;
            color: #0d6efd;
        }

        .action-btn:hover {
            color: #0a58ca;
        }

        .action-btn i {
            font-size: 18px;
        }

        .table td {
            vertical-align: middle;
        }

        .text-wrap {
            white-space: normal;
            max-width: 250px;
        }

        .modal-body table {
            font-size: 0.9rem;
        }

        .modal-body td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .modal-body td:first-child {
            font-weight: 600;
            width: 35%;
            background-color: #f8f9fa;
        }

        .badge-pill {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
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
                    <li class="breadcrumb-item active" aria-current="page">{{ __('admin.investors') }}</li>
                </ol>
            </nav>
        </div>

        <!-- Tugmalar guruhi -->
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <button class="btn btn-success btn-sm px-2 py-1" id="exportExcelBtn">
                <i class="fas fa-file-excel me-1" style="font-size: 0.85rem;"></i> Excel
            </button>

            <button class="btn btn-info btn-sm text-white px-2 py-1" id="exportCsvBtn">
                <i class="fas fa-file-csv me-1" style="font-size: 0.85rem;"></i> CSV
            </button>

            <button class="btn btn-sm p-2 d-flex align-items-center justify-content-center" type="button"
                data-bs-toggle="collapse" data-bs-target="#investorFilterContent" aria-expanded="true"
                aria-controls="investorFilterContent">
                <i class="bi bi-sliders2" style="font-size: 1.3rem;"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')
    <!-- Filter card -->
    <div class="filter-card mb-3 mt-2 collapse show" id="investorFilterContent" style="transition: all 0.3s ease;">
        <div class="border rounded p-3" style="border-color: rgba(0,0,0,0.05); background-color: #fff;">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="searchInput">{{ __('admin.search') }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="{{ __('admin.search') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="activityTypeFilter">{{ __('admin.activity_type') }}</label>
                    <select id="activityTypeFilter" class="form-select">
                        <option value="">{{ __('admin.all') }}</option>
                        <option value="МЧЖ">{{ __('admin.mchj') }}</option>
                        <option value="АЖ">{{ __('admin.aj') }}</option>
                        <option value="ЯТТ">{{ __('admin.yatt') }}</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="statusFilter">{{ __('admin.status') }}</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">{{ __('admin.all') }}</option>
                        <option value="Faol">{{ __('admin.active') }}</option>
                        <option value="Bloklangan">{{ __('admin.blocked') }}</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button id="filterBtn" class="btn btn-primary w-50">
                        <i class="fas fa-filter"></i> {{ __('admin.search') }}
                    </button>

                    <button id="clearBtn" class="btn btn-warning w-50">
                        {{ __('admin.clear') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-body py-3 px-3 shadow border-0 table-wrapper table-responsive mt-3">
        <table class="table user-table table-bordered table-hover table-striped align-items-center">
            <thead class="table-dark">
                <tr>
                    <th style="width: 50px;">№</th>
                    <th style="min-width: 220px;">{{ __('admin.company_name') }}</th>
                    <th style="min-width: 110px;">{{ __('admin.inn') }}</th>
                    <th style="min-width: 130px;">{{ __('admin.ifut') }}</th>
                    <th style="min-width: 100px;">{{ __('admin.activity_type') }}</th>
                    <th style="min-width: 160px;">{{ __('admin.director') }}</th>
                    <th style="min-width: 130px;">{{ __('admin.phone') }}</th>
                    <th style="min-width: 100px;">{{ __('admin.status') }}</th>
                    <th style="min-width: 120px;">{{ __('admin.total_share') }}</th>
                    <th style="min-width: 100px;">{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody id="investorTableBody"></tbody>
        </table>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-between align-items-center p-2">
            <div class="text-muted">
                <span id="showingInfo"></span>
            </div>
            <nav>
                <ul class="pagination pagination-sm mb-0" id="pagination"></ul>
            </nav>
        </div>
    </div>

    <!-- Modal - Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('admin.investor_details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="{{ __('admin.close') }}"></button>
                </div>
                <div class="modal-body" id="modalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('admin.close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customJs')
    <script>
        // STATIC DATA - Texnik topshiriq asosida (25 ta investor)
        const investors = [{
                id: 1,
                companyName: '"Toshkent Savdo Markazi" МЧЖ',
                inn: '123456789',
                ifut: '00001234567890',
                activityType: 'МЧЖ',
                address: 'Toshkent sh., Mirzo Ulug\'bek t-ni, Buyuk Ipak Yo\'li ko\'chasi, 25-uy',
                directorName: 'Alimov Bobur Karimovich',
                login: 'toshkent_savdo',
                phone: '+998901234567',
                email: 'info@toshkentsavdo.uz',
                registrationDate: '2023-05-15',
                registrationNumber: 'ГРОЮЛ №123456789',
                registrationAuthority: 'Toshkent shahar Adliya boshqarmasi',
                passport: null,
                jshir: null,
                accountStatus: 'Faol',
                investorStatusDate: '2024-11-20',
                certificate: 'investor_certificate_001.pdf',
                totalShareAmount: '500 000 000',
                totalSharePercent: '25%'
            },
            {
                id: 2,
                companyName: '"Innovatsion Texnologiyalar" АЖ',
                inn: '234567890',
                ifut: '00002345678901',
                activityType: 'АЖ',
                address: 'Toshkent sh., Yunusobod t-ni, Amir Temur shoh ko\'chasi, 108-uy',
                directorName: 'Karimova Dilnoza Rustamovna',
                login: 'inno_tech',
                phone: '+998909876543',
                email: 'contact@innotech.uz',
                registrationDate: '2022-08-22',
                registrationNumber: 'ГРОЮЛ №234567890',
                registrationAuthority: 'Toshkent shahar Adliya boshqarmasi',
                passport: null,
                jshir: null,
                accountStatus: 'Faol',
                investorStatusDate: '2024-10-15',
                certificate: 'investor_certificate_002.pdf',
                totalShareAmount: '750 000 000',
                totalSharePercent: '37.5%'
            },
            {
                id: 3,
                companyName: 'Maxmudov Jasur Anvarovich (ЯТТ)',
                inn: '345678901',
                ifut: '00003456789012',
                activityType: 'ЯТТ',
                address: 'Samarqand sh., Registon ko\'chasi, 45-uy, 12-xonadon',
                directorName: 'Maxmudov Jasur Anvarovich',
                login: 'maxmudov_j',
                phone: '+998933445566',
                email: 'jasur.maxmudov@mail.ru',
                registrationDate: '2024-01-10',
                registrationNumber: 'ГРОИП №345678901',
                registrationAuthority: 'Samarqand viloyat Soliq qo\'mitasi',
                passport: 'AC1234567',
                jshir: '12345678901234',
                accountStatus: 'Faol',
                investorStatusDate: '2024-09-05',
                certificate: 'investor_certificate_003.pdf',
                totalShareAmount: '150 000 000',
                totalSharePercent: '7.5%'
            },
            {
                id: 4,
                companyName: '"Qurilish Texnika Savdo" МЧЖ',
                inn: '456789012',
                ifut: '00004567890123',
                activityType: 'МЧЖ',
                address: 'Andijon sh., Bobur ko\'chasi, 78-uy',
                directorName: 'Rahmonov Abbos Shavkatovich',
                login: 'qurilish_savdo',
                phone: '+998922334455',
                email: 'info@qurilishsavdo.uz',
                registrationDate: '2021-11-30',
                registrationNumber: 'ГРОЮЛ №456789012',
                registrationAuthority: 'Andijon viloyat Adliya boshqarmasi',
                passport: null,
                jshir: null,
                accountStatus: 'Bloklangan',
                investorStatusDate: '2023-12-18',
                certificate: 'investor_certificate_004.pdf',
                totalShareAmount: '300 000 000',
                totalSharePercent: '15%'
            },
            {
                id: 5,
                companyName: '"Oziq-ovqat Mahsulotlari" АЖ',
                inn: '567890123',
                ifut: '00005678901234',
                activityType: 'АЖ',
                address: 'Namangan sh., Navoiy ko\'chasi, 120-uy',
                directorName: 'Tursunova Malika Davronovna',
                login: 'oziq_ovqat',
                phone: '+998911223344',
                email: 'malika@oziqovqat.uz',
                registrationDate: '2020-07-20',
                registrationNumber: 'ГРОЮЛ №567890123',
                registrationAuthority: 'Namangan viloyat Adliya boshqarmasi',
                passport: null,
                jshir: null,
                accountStatus: 'Faol',
                investorStatusDate: '2024-08-22',
                certificate: 'investor_certificate_005.pdf',
                totalShareAmount: '200 000 000',
                totalSharePercent: '10%'
            },
            {
                id: 6,
                companyName: 'Ibragimova Nilufar Komilovna (ЯТТ)',
                inn: '678901234',
                ifut: '00006789012345',
                activityType: 'ЯТТ',
                address: 'Buxoro sh., Alpomish ko\'chasi, 33-uy, 7-xonadon',
                directorName: 'Ibragimova Nilufar Komilovna',
                login: 'nilufar_i',
                phone: '+998900112233',
                email: 'nilufar.ibragimova@gmail.com',
                registrationDate: '2023-09-12',
                registrationNumber: 'ГРОИП №678901234',
                registrationAuthority: 'Buxoro viloyat Soliq qo\'mitasi',
                passport: 'AB9876543',
                jshir: '98765432109876',
                accountStatus: 'Faol',
                investorStatusDate: '2024-07-14',
                certificate: 'investor_certificate_006.pdf',
                totalShareAmount: '100 000 000',
                totalSharePercent: '5%'
            },
            {
                id: 7,
                companyName: '"Zamonaviy Logistika" МЧЖ',
                inn: '789012345',
                ifut: '00007890123456',
                activityType: 'МЧЖ',
                address: 'Farg\'ona sh., Mustaqillik ko\'chasi, 65-uy',
                directorName: 'Yusupov Otabek Rahimovich',
                login: 'zamonaviy_log',
                phone: '+998905554433',
                email: 'info@zamlog.uz',
                registrationDate: '2022-03-18',
                registrationNumber: 'ГРОЮЛ №789012345',
                registrationAuthority: 'Farg\'ona viloyat Adliya boshqarmasi',
                passport: null,
                jshir: null,
                accountStatus: 'Faol',
                investorStatusDate: '2024-06-30',
                certificate: 'investor_certificate_007.pdf',
                totalShareAmount: '450 000 000',
                totalSharePercent: '22.5%'
            },
            {
                id: 8,
                companyName: '"Raqamli Yechimlar" АЖ',
                inn: '890123456',
                ifut: '00008901234567',
                activityType: 'АЖ',
                address: 'Toshkent sh., Chilonzor t-ni, O\'zbekiston ko\'chasi, 55-uy',
                directorName: 'Ergashev Sardor Baxromovich',
                login: 'raqamli_uz',
                phone: '+998909998877',
                email: 'sardor@raqamli.uz',
                registrationDate: '2021-05-25',
                registrationNumber: 'ГРОЮЛ №890123456',
                registrationAuthority: 'Toshkent shahar Adliya boshqarmasi',
                passport: null,
                jshir: null,
                accountStatus: 'Faol',
                investorStatusDate: '2024-05-18',
                certificate: 'investor_certificate_008.pdf',
                totalShareAmount: '600 000 000',
                totalSharePercent: '30%'
            },
            {
                id: 9,
                companyName: 'Qodirov Sirojiddin Mamurovich (ЯТТ)',
                inn: '901234567',
                ifut: '00009012345678',
                activityType: 'ЯТТ',
                address: 'Xorazm sh., Ibn Sino ko\'chasi, 22-uy, 5-xonadon',
                directorName: 'Qodirov Sirojiddin Mamurovich',
                login: 'siroj_q',
                phone: '+998900011223',
                email: 'siroj.qodirov@inbox.ru',
                registrationDate: '2024-02-14',
                registrationNumber: 'ГРОИП №901234567',
                registrationAuthority: 'Xorazm viloyat Soliq qo\'mitasi',
                passport: 'AD5544332',
                jshir: '55443322110099',
                accountStatus: 'Faol',
                investorStatusDate: '2024-11-01',
                certificate: 'investor_certificate_009.pdf',
                totalShareAmount: '80 000 000',
                totalSharePercent: '4%'
            },
            {
                id: 10,
                companyName: '"Tibbiyot Markazi" МЧЖ',
                inn: '012345678',
                ifut: '00000123456789',
                activityType: 'МЧЖ',
                address: 'Toshkent sh., Shayxontohur t-ni, Beruniy ko\'chasi, 90-uy',
                directorName: 'Aminova Sevara Ilxomovna',
                login: 'tibbiyot_uz',
                phone: '+998933301122',
                email: 'info@tibbiyot.uz',
                registrationDate: '2020-12-05',
                registrationNumber: 'ГРОЮЛ №012345678',
                registrationAuthority: 'Toshkent shahar Adliya boshqarmasi',
                passport: null,
                jshir: null,
                accountStatus: 'Faol',
                investorStatusDate: '2024-04-25',
                certificate: 'investor_certificate_010.pdf',
                totalShareAmount: '350 000 000',
                totalSharePercent: '17.5%'
            },
            {
                id: 11,
                companyName: '"Avtomobil Ehtiyot Qismlari" АЖ',
                inn: '111222333',
                ifut: '00011122233344',
                activityType: 'АЖ',
                address: 'Qashqadaryo sh., Qarshi ko\'chasi, 45-uy',
                directorName: 'Normatov Komil Alisherovich',
                login: 'avto_ehtiyot',
                phone: '+998930045612',
                email: 'komil@avtoehtiyot.uz',
                registrationDate: '2021-10-08',
                registrationNumber: 'ГРОЮЛ №111222333',
                registrationAuthority: 'Qashqadaryo viloyat Adliya boshqarmasi',
                passport: null,
                jshir: null,
                accountStatus: 'Bloklangan',
                investorStatusDate: '2023-06-12',
                certificate: 'investor_certificate_011.pdf',
                totalShareAmount: '250 000 000',
                totalSharePercent: '12.5%'
            },
            {
                id: 12,
                companyName: 'Saidov Jamshid Rustamovich (ЯТТ)',
                inn: '222333444',
                ifut: '00022233344455',
                activityType: 'ЯТТ',
                address: 'Sirdaryo sh., Guliston ko\'chasi, 18-uy, 3-xonadon',
                directorName: 'Saidov Jamshid Rustamovich',
                login: 'jamshid_s',
                phone: '+998950033221',
                email: 'jamshid.saidov@mail.ru',
                registrationDate: '2023-07-22',
                registrationNumber: 'ГРОИП №222333444',
                registrationAuthority: 'Sirdaryo viloyat Soliq qo\'mitasi',
                passport: 'AC7788112',
                jshir: '77881122334455',
                accountStatus: 'Faol',
                investorStatusDate: '2024-10-08',
                certificate: 'investor_certificate_012.pdf',
                totalShareAmount: '120 000 000',
                totalSharePercent: '6%'
            },
            {
                id: 13,
                companyName: '"Qishloq Xo\'jaligi Mahsulotlari" МЧЖ',
                inn: '333444555',
                ifut: '00033344455566',
                activityType: 'МЧЖ',
                address: 'Jizzax sh., Sharof Rashidov ko\'chasi, 77-uy',
                directorName: 'Abdullayev Shohjahon Akramovich',
                login: 'qishloq_xoj',
                phone: '+998977712345',
                email: 'info@qishloqxoj.uz',
                registrationDate: '2020-09-15',
                registrationNumber: 'ГРОЮЛ №333444555',
                registrationAuthority: 'Jizzax viloyat Adliya boshqarmasi',
                passport: null,
                jshir: null,
                accountStatus: 'Faol',
                investorStatusDate: '2024-03-20',
                certificate: 'investor_certificate_013.pdf',
                totalShareAmount: '400 000 000',
                totalSharePercent: '20%'
            },
            {
                id: 14,
                companyName: 'Qodirova Hilola Shavkatovna (ЯТТ)',
                inn: '444555666',
                ifut: '00044455566677',
                activityType: 'ЯТТ',
                address: 'Surxondaryo sh., Termiz ko\'chasi, 56-uy, 9-xonadon',
                directorName: 'Qodirova Hilola Shavkatovna',
                login: 'hilola_q',
                phone: '+998934556677',
                email: 'davron@mebel.uz',
                registrationDate: '2021-08-14',
                registrationNumber: 'ГРОЮЛ №999000111',
                registrationAuthority: 'Samarqand viloyat Adliya boshqarmasi',
                passport: null,
                jshir: null,
                accountStatus: 'Faol',
                investorStatusDate: '2024-06-10',
                certificate: 'investor_certificate_019.pdf',
                totalShareAmount: '280 000 000',
                totalSharePercent: '14%'
            },
            {
                id: 20,
                companyName: 'Mirzayeva Aziza Toxirovna (ЯТТ)',
                inn: '000111222',
                ifut: '00000011122233',
                activityType: 'ЯТТ',
                address: 'Namangan sh., Uchqo\'rg\'on ko\'chasi, 29-uy, 11-xonadon',
                directorName: 'Mirzayeva Aziza Toxirovna',
                login: 'aziza_m',
                phone: '+998945566778',
                email: 'aziza.mirzayeva@gmail.com',
                registrationDate: '2024-01-22',
                registrationNumber: 'ГРОИП №000111222',
                registrationAuthority: 'Namangan viloyat Soliq qo\'mitasi',
                passport: 'AA4455667',
                jshir: '44556677889911',
                accountStatus: 'Faol',
                investorStatusDate: '2024-11-08',
                certificate: 'investor_certificate_020.pdf',
                totalShareAmount: '70 000 000',
                totalSharePercent: '3.5%'
            },
            {
                id: 21,
                companyName: '"IT Konsalting" АЖ',
                inn: '111222444',
                ifut: '00111222444555',
                activityType: 'АЖ',
                address: 'Toshkent sh., Yashnobod t-ni, Farobiy ko\'chasi, 62-uy',
                directorName: 'Xasanov Bekzod Ulug\'bekovich',
                login: 'it_konsalt',
                phone: '+998956677889',
                email: 'bekzod@itkonsalt.uz',
                registrationDate: '2022-05-19',
                registrationNumber: 'ГРОЮЛ №111222444',
                registrationAuthority: 'Toshkent shahar Adliya boshqarmasi',
                passport: null,
                jshir: null,
                accountStatus: 'Faol',
                investorStatusDate: '2024-05-30',
                certificate: 'investor_certificate_021.pdf',
                totalShareAmount: '420 000 000',
                totalSharePercent: '21%'
            },
            {
                id: 22,
                companyName: '"Ta\'lim Markazi" МЧЖ',
                inn: '222444555',
                ifut: '00222444555666',
                activityType: 'МЧЖ',
                address: 'Farg\'ona sh., Hamza ko\'chasi, 51-uy',
                directorName: 'Sodiqova Feruza Ikromovna',
                login: 'talim_uz',
                phone: '+998967788990',
                email: 'feruza@talim.uz',
                registrationDate: '2020-11-27',
                registrationNumber: 'ГРОЮЛ №222444555',
                registrationAuthority: 'Farg\'ona viloyat Adliya boshqarmasi',
                passport: null,
                jshir: null,
                accountStatus: 'Bloklangan',
                investorStatusDate: '2023-09-14',
                certificate: 'investor_certificate_022.pdf',
                totalShareAmount: '180 000 000',
                totalSharePercent: '9%'
            },
            {
                id: 23,
                companyName: '"Ekologik Texnologiyalar" АЖ',
                inn: '333555666',
                ifut: '00333555666777',
                activityType: 'АЖ',
                address: 'Buxoro sh., Nakshband ko\'chasi, 35-uy',
                directorName: 'Yoqubov Anvar Saidovich',
                login: 'eko_tech',
                phone: '+998978899001',
                email: 'anvar@ekotech.uz',
                registrationDate: '2021-07-09',
                registrationNumber: 'ГРОЮЛ №333555666',
                registrationAuthority: 'Buxoro viloyat Adliya boshqarmasi',
                passport: null,
                jshir: null,
                accountStatus: 'Faol',
                investorStatusDate: '2024-04-17',
                certificate: 'investor_certificate_023.pdf',
                totalShareAmount: '520 000 000',
                totalSharePercent: '26%'
            },
            {
                id: 24,
                companyName: 'Nurmatov Eldor Ravshanbek o\'g\'li (ЯТТ)',
                inn: '444666777',
                ifut: '00444666777888',
                activityType: 'ЯТТ',
                address: 'Xorazm sh., Urgench ko\'chasi, 72-uy, 6-xonadon',
                directorName: 'Nurmatov Eldor Ravshanbek o\'g\'li',
                login: 'eldor_n',
                phone: '+998989900112',
                email: 'eldor.nurmatov@mail.ru',
                registrationDate: '2023-06-15',
                registrationNumber: 'ГРОИП №444666777',
                registrationAuthority: 'Xorazm viloyat Soliq qo\'mitasi',
                passport: 'AD6677885',
                jshir: '66778855332211',
                accountStatus: 'Faol',
                investorStatusDate: '2024-10-22',
                certificate: 'investor_certificate_024.pdf',
                totalShareAmount: '95 000 000',
                totalSharePercent: '4.75%'
            },
            {
                id: 25,
                companyName: '"Sanoat Avtomat" МЧЖ',
                inn: '555777888',
                ifut: '00555777888999',
                activityType: 'МЧЖ',
                address: 'Toshkent sh., Sergeli t-ni, Qatortol ko\'chasi, 128-uy',
                directorName: 'Sharipov Otabek Zakirovich',
                login: 'sanoat_avto',
                phone: '+998990011223',
                email: 'otabek@sanoatavto.uz',
                registrationDate: '2019-12-20',
                registrationNumber: 'ГРОЮЛ №555777888',
                registrationAuthority: 'Toshkent shahar Adliya boshqarmasi',
                passport: null,
                jshir: null,
                accountStatus: 'Faol',
                investorStatusDate: '2024-03-05',
                certificate: 'investor_certificate_025.pdf',
                totalShareAmount: '640 000 000',
                totalSharePercent: '32%'
            }
        ];

        // PAGINATION SETTINGS
        const perPage = 10;
        let currentPage = 1;
        let filteredInvestors = [...investors];

        // TABLE RENDER
        function renderTable() {
            const tbody = document.getElementById('investorTableBody');
            tbody.innerHTML = "";

            const start = (currentPage - 1) * perPage;
            const end = start + perPage;
            const pageData = filteredInvestors.slice(start, end);

            if (pageData.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                            Ma'lumot topilmadi
                        </td>
                    </tr>
                `;
                document.getElementById('showingInfo').textContent = 'Jami: 0';
                document.getElementById('pagination').innerHTML = '';
                return;
            }

            pageData.forEach((inv, index) => {
                const globalIndex = start + index + 1;

                tbody.innerHTML += `
                    <tr>
                        <td>${globalIndex}</td>
                        <td class="text-wrap">${inv.companyName}</td>
                        <td>${inv.inn}</td>
                        <td>${inv.ifut}</td>
                        <td>
                            <span class="badge badge-pill ${
                                inv.activityType === 'МЧЖ' ? 'bg-primary' :
                                inv.activityType === 'АЖ' ? 'bg-info' : 'bg-success'
                            }">${inv.activityType}</span>
                        </td>
                        <td class="text-wrap">${inv.directorName}</td>
                        <td>${inv.phone}</td>
                        <td>
                            ${inv.accountStatus === 'Faol'
                                ? '<span class="status-active">Faol</span>'
                                : '<span class="status-blocked">Bloklangan</span>'}
                        </td>
                        <td>
                            <div>${inv.totalShareAmount} so'm</div>
                            <small class="text-muted">(${inv.totalSharePercent})</small>
                        </td>
                        <td class="text-center">
                            <button class="action-btn" onclick="showDetail(${inv.id})" title="Batafsil">
                                <x-show-button />
                            </button>
                        </td>
                    </tr>
                `;
            });

            updatePaginationInfo();
            renderPagination();
        }

        // UPDATE PAGINATION INFO
        function updatePaginationInfo() {
            const start = (currentPage - 1) * perPage + 1;
            const end = Math.min(currentPage * perPage, filteredInvestors.length);
            const total = filteredInvestors.length;

            document.getElementById('showingInfo').textContent =
                `Ko'rsatilmoqda: ${start}-${end} / ${total}`;
        }

        // PAGINATION BUTTONS
        function renderPagination() {
            const totalPages = Math.ceil(filteredInvestors.length / perPage);
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = "";

            if (totalPages <= 1) return;

            // Previous button
            pagination.innerHTML += `
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <button class="page-link" onclick="goPage(${currentPage - 1})">«</button>
                </li>
            `;

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (
                    i === 1 ||
                    i === totalPages ||
                    (i >= currentPage - 1 && i <= currentPage + 1)
                ) {
                    pagination.innerHTML += `
                        <li class="page-item ${currentPage === i ? 'active' : ''}">
                            <button class="page-link" onclick="goPage(${i})">${i}</button>
                        </li>
                    `;
                } else if (i === currentPage - 2 || i === currentPage + 2) {
                    pagination.innerHTML += `
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    `;
                }
            }

            // Next button
            pagination.innerHTML += `
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <button class="page-link" onclick="goPage(${currentPage + 1})">»</button>
                </li>
            `;
        }

        // GO TO PAGE
        function goPage(page) {
            const totalPages = Math.ceil(filteredInvestors.length / perPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable();
        }

        // SHOW DETAIL MODAL
        function showDetail(id) {
            const investor = investors.find(inv => inv.id === id);
            if (!investor) return;

            const modalBody = document.getElementById('modalBody');
            modalBody.innerHTML = `
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>Investor ID:</td>
                            <td>${investor.id}</td>
                        </tr>
                        <tr>
                            <td>Korxona to'liq nomi:</td>
                            <td>${investor.companyName}</td>
                        </tr>
                        <tr>
                            <td>INN:</td>
                            <td>${investor.inn}</td>
                        </tr>
                        <tr>
                            <td>IFUT kodi:</td>
                            <td>${investor.ifut}</td>
                        </tr>
                        <tr>
                            <td>Faoliyat turi:</td>
                            <td><span class="badge badge-pill ${
                                investor.activityType === 'МЧЖ' ? 'bg-primary' :
                                investor.activityType === 'АЖ' ? 'bg-info' : 'bg-success'
                            }">${investor.activityType}</span></td>
                        </tr>
                        <tr>
                            <td>Manzil:</td>
                            <td>${investor.address}</td>
                        </tr>
                        <tr>
                            <td>Direktor F.I.O:</td>
                            <td>${investor.directorName}</td>
                        </tr>
                        <tr>
                            <td>Login:</td>
                            <td>${investor.login}</td>
                        </tr>
                        <tr>
                            <td>Telefon:</td>
                            <td>${investor.phone}</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>${investor.email}</td>
                        </tr>
                        <tr>
                            <td>Ro'yxatdan o'tgan sana:</td>
                            <td>${investor.registrationDate}</td>
                        </tr>
                        <tr>
                            <td>Ro'yxat raqami:</td>
                            <td>${investor.registrationNumber}</td>
                        </tr>
                        <tr>
                            <td>Ro'yxatga oluvchi tashkilot:</td>
                            <td>${investor.registrationAuthority}</td>
                        </tr>
                        ${investor.passport ? `
                                <tr>
                                    <td>Passport seriya va raqami:</td>
                                    <td>${investor.passport}</td>
                                </tr>
                                ` : ''}
                        ${investor.jshir ? `
                                <tr>
                                    <td>JSHIR:</td>
                                    <td>${investor.jshir}</td>
                                </tr>
                                ` : ''}
                        <tr>
                            <td>Akkount holati:</td>
                            <td>
                                ${investor.accountStatus === 'Faol'
                                    ? '<span class="status-active">Faol</span>'
                                    : '<span class="status-blocked">Bloklangan</span>'}
                            </td>
                        </tr>
                        <tr>
                            <td>Investorlik holati sanasi:</td>
                            <td>${investor.investorStatusDate}</td>
                        </tr>
                        <tr>
                            <td>Investorlik sertifikati:</td>
                            <td><a href="#" class="text-primary"><i class="fas fa-file-pdf"></i> ${investor.certificate}</a></td>
                        </tr>
                        <tr>
                            <td>Jami ulushi (summada):</td>
                            <td><strong>${investor.totalShareAmount} so'm</strong></td>
                        </tr>
                        <tr>
                            <td>Jami ulushi (foizda):</td>
                            <td><strong>${investor.totalSharePercent}</strong></td>
                        </tr>
                    </tbody>
                </table>
            `;

            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        }

        // FILTER FUNCTION
        function applyFilter() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase().trim();
            const activityType = document.getElementById('activityTypeFilter').value;
            const status = document.getElementById('statusFilter').value;

            filteredInvestors = investors.filter(inv => {
                const matchSearch = !searchValue ||
                    inv.companyName.toLowerCase().includes(searchValue) ||
                    inv.inn.includes(searchValue) ||
                    inv.phone.includes(searchValue) ||
                    inv.directorName.toLowerCase().includes(searchValue) ||
                    inv.email.toLowerCase().includes(searchValue);

                const matchActivityType = !activityType || inv.activityType === activityType;
                const matchStatus = !status || inv.accountStatus === status;

                return matchSearch && matchActivityType && matchStatus;
            });

            currentPage = 1;
            renderTable();
        }

        // CLEAR FILTER
        function clearFilter() {
            document.getElementById('searchInput').value = '';
            document.getElementById('activityTypeFilter').value = '';
            document.getElementById('statusFilter').value = '';

            filteredInvestors = [...investors];
            currentPage = 1;
            renderTable();
        }

        // EXPORT TO EXCEL
        function exportToExcel() {
            let csvContent = "data:text/csv;charset=utf-8,\uFEFF";
            csvContent +=
                "№,Korxona nomi,INN,IFUT,Faoliyat turi,Direktor,Telefon,Email,Holat,Jami ulushi (so'm),Ulush (%)\n";

            filteredInvestors.forEach((inv, index) => {
                csvContent +=
                    `${index + 1},"${inv.companyName}",${inv.inn},${inv.ifut},${inv.activityType},"${inv.directorName}",${inv.phone},${inv.email},${inv.accountStatus},"${inv.totalShareAmount}",${inv.totalSharePercent}\n`;
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "investorlar_" + new Date().toISOString().split('T')[0] + ".csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // EXPORT TO CSV
        function exportToCSV() {
            exportToExcel(); // Same functionality
        }

        // EVENT LISTENERS
        document.getElementById('filterBtn').addEventListener('click', applyFilter);
        document.getElementById('clearBtn').addEventListener('click', clearFilter);
        document.getElementById('exportExcelBtn').addEventListener('click', exportToExcel);
        document.getElementById('exportCsvBtn').addEventListener('click', exportToCSV);

        // Search on Enter key
        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                applyFilter();
            }
        });

        // INIT
        renderTable();
    </script>
@endpush