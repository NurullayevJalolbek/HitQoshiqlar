    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon-16.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/envast_logo.svg') }}">
    <!-- Font Awesome 6 Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="mask-icon" href="{{ asset('assets/img/bicon.png') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <style>
        .swal2-actions {
            gap: 16px;
        }

        .btn-outline-secondary {
            color: #6A7D9C;
            background-color: #ffffff;
            border-color: #6A7D9C;
            padding: 10px;
            max-width: 150px;
            width: 100%;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-danger {
            display: flex;
            align-items: center;
            gap: 6px;
            background-color: #FF4C4C !important;
            color: #ffffff;
            border: none !important;
            padding: 10px;
            max-width: 150px;
            width: 100%;
            box-shadow: none !important;
            font-weight: 600;
            font-size: 14px;
        }

        /* === MEGA SCROLLNI BUTUNLAY YO'Q QILISH === */
        .sidebar {
            overflow: hidden !important;
            height: 100vh !important;
        }

        .sidebar-inner {
            overflow: hidden !important;
            max-height: 100% !important;
        }

        #sidebarMenu {
            overflow-y: auto !important;
            height: 100vh;
        }

        /* Plaseholerni kamaytirish */
        <style>

        /* Input va selectlarni bir xil qiyofa qilish */
        .input-group .form-control,
        .input-group .form-select,
        .form-control,
        textarea {
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        /* Input-group ichidagi textni chiroyli qilish */
        .input-group-text {
            border-right: none;
            background-color: #fff;
        }

        /* Input va select borderlarini uyg‘unlash */
        .input-group .form-control,
        .input-group .form-select {
            border-left: none;
        }

        /* Placeholder 60% opacity */
        ::placeholder {
            opacity: 0.6 !important;
            color: #6c757d;
        }

        /* Focus bo‘lganda border va shadow */
        .form-control:focus,
        .form-select:focus,
        textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
            outline: none;
        }

        /* Input va select kengligi va style bir xil bo‘lsin */
        .form-control,
        .form-select,
        textarea {
            width: 100%;
            transition: all 0.2s ease-in-out;
        }

        /* Barcha input va select ichidagi ikonlar rangini sozlash */
        .input-group-text i {
            color: #6c757d;
        }
    </style>

    </style>
    <!-- Sweet Alert -->
    <link type="text/css" href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">

    <!-- Notyf -->
    <link type="text/css" href="{{ asset('vendor/notyf/notyf.min.css') }}" rel="stylesheet">

    <!-- Full Calendar  -->
    <link type="text/css" href="{{ asset('vendor/fullcalendar/main.min.css') }}" rel="stylesheet">

    <!-- Apex Charts -->
    {{-- <link type="text/css" href="{{ asset('vendor/apexcharts/dist/apexcharts.css') }}" rel="stylesheet"> --}}

    <!-- Dropzone -->
    <link type="text/css" href="{{ asset('vendor/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">

    <!-- Choices  -->
    <link type="text/css" href="{{ asset('vendor/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet">

    <!-- Leaflet JS -->
    <link type="text/css" href="{{ asset('vendor/leaflet/dist/leaflet.css') }}" rel="stylesheet">


    <!-- Volt CSS -->
    <link type="text/css" href="{{ asset('css/volt.css') }}" rel="stylesheet">



    <style>
        .swal2-actions {
            gap: 16px;
        }

        .btn-outline-secondary {
            color: #6A7D9C;
            background-color: #ffffff;
            border-color: #6A7D9C;
            padding: 10px;
            max-width: 150px;
            width: 100%;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-danger {
            display: flex;
            align-items: center;
            gap: 6px;
            background-color: #FF4C4C !important;
            color: #ffffff;
            border: none !important;
            padding: 10px;
            max-width: 150px;
            width: 100%;
            box-shadow: none !important;
            font-weight: 600;
            font-size: 14px;
        }

        /* === MEGA SCROLLNI BUTUNLAY YO'Q QILISH === */
        .sidebar {
            overflow: hidden !important;
            height: 100vh !important;
        }

        .sidebar-inner {
            overflow: hidden !important;
            max-height: 100% !important;
        }

        .sidebar .nav-link {
            width: 250px;
        }

        .sidebar-close-figure {
            position: fixed;
            top: 0;
            right: 0;
            display: flex;
            justify-content: center;
            background: rgb(31, 41, 55);
            display: none;
            z-index: 100;
            padding: 13px 18px 13px 10px;
        }

        @media (max-width: 768px) {
            .sidebar-close-figure {
                display: block;
            }
        }

        .sidebar-close-icon {
            width: 32px;
            height: 32px;
        }

        #project-logo {
            position: fixed;
            top: 0;
            z-index: 100;
            background: #1F2937;
        }

        @media (max-width: 768px) {
            #project-logo {
                width: 100% !important;
            }
        }

        .pagination-block .mx-4 {
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .breadcrumb-block {
                margin-bottom: 10px;
                height: 0;
                padding: 0 !important;
            }
        }

        @media (max-width: 768px) {
            .column-mobile {
                position: unset !important;
                left: unset !important;
            }
        }

        /* === SUBMENU CHAPGA QAYTARISH === */
        .sidebar .multi-level {
            padding-left: 0 !important;
        }

        .sidebar .multi-level .nav {
            padding-left: 0 !important;
        }

        .sidebar .multi-level .nav-link {
            padding-left: 2.75rem !important;
            /* Standart volt ko‘rinishi */
            margin-left: 0 !important;
        }

        /* ==== CONTRACTED SIDEBAR FIX ==== */
        #sidebarMenu.contracted {
            width: 80px !important;
        }

        #sidebarMenu.contracted .sidebar-text,
        #sidebarMenu.contracted .logo-text {
            display: none !important;
        }

        /* Nav-link width ni faqat normal holatda beramiz */
        #sidebarMenu:not(.contracted) .nav-link {
            width: 250px;
        }

        #sidebarMenu.contracted .nav-link {
            width: 80px !important;
            justify-content: center;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* ICON markazda turishi uchun */
        #sidebarMenu.contracted .nav-link i {
            margin-right: 0 !important;
        }

        /* DROPDOWN CONTRACTED PAYTIDA FLOAT QILIB CHIQSIN */
        #sidebarMenu.contracted .multi-level {
            position: absolute;
            left: 80px;
            top: 0;
            width: 220px;
            background: #1F2937;
            border-radius: 8px;
            padding: 8px 0;
            z-index: 9999;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .4);
        }

        /* Submenu textlari ko‘rinsin */
        #sidebarMenu.contracted .multi-level .sidebar-text {
            display: inline-block !important;
        }

        /* Arrow yo‘q bo‘lsin */
        #sidebarMenu.contracted .link-arrow {
            display: none !important;
        }

        /* Hoverda ko‘rsatish */
        #sidebarMenu.contracted li.nav-item:hover>.multi-level.collapse {
            display: block !important;
            visibility: visible;
            opacity: 1;
            height: auto !important;
        }

        /* Sidebar contracted umumiy holat */
        #sidebarMenu.contracted {
            width: 80px;
        }

        #sidebarMenu.contracted .sidebar-text {
            display: none !important;
        }

        /* Barcha nav-linklar bir xil bo‘lsin */
        #sidebarMenu.contracted .nav-link {
            justify-content: center !important;
            padding: 12px 0 !important;
        }

        /* ICONLARNI MARKAZGA KELTIRISH */
        #sidebarMenu.contracted .nav-link i,
        #sidebarMenu.contracted .nav-link svg {
            margin: 0 !important;
            font-size: 20px;
        }

        /* DROPDOWN O‘QINI YASHIRISH */
        #sidebarMenu.contracted .link-arrow {
            display: none !important;
        }

        /* DROPDOWN TO‘LIQ YOPIQ TURADI */
        #sidebarMenu.contracted .multi-level {
            display: none !important;
        }

        /* DROPDOWNNI HOVERDA OCHISH (xohlasangiz) */
        #sidebarMenu.contracted .nav-item:hover>.multi-level {
            display: block !important;
            position: absolute;
            left: 80px;
            top: 0;
            background: #1f2937;
            min-width: 220px;
            z-index: 999;
            border-radius: 8px;
            padding: 8px 0;
        }

        /* DROPDOWN ICHIDAGI LINKLAR */
        #sidebarMenu.contracted .multi-level .nav-link {
            justify-content: flex-start !important;
            padding: 10px 16px !important;
        }

        /* NAV-LINK NI HAQIQIY FLEX CENTER QILAMIZ */
        #sidebarMenu.contracted .nav-link {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            width: 100% !important;
        }

        /* ICONLARNI HAQIQIY O‘RTAGA KIRITISH */
        #sidebarMenu.contracted .nav-link i,
        #sidebarMenu.contracted .nav-link svg {
            display: block !important;
            margin-left: auto !important;
            margin-right: auto !important;
            text-align: center !important;
        }

        /* AGAR ICHIDA SPAN BOR BO‘LSA HAM MARKAZDA QOLSIN */
        #sidebarMenu.contracted .nav-link>* {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
