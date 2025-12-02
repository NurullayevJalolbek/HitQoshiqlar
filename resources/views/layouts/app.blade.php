<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.css')
    @include('layouts.sidebarScroll')

    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">


    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ __('admin.dashboard') }}</title>

    @stack('customCss')

    <style>
        .custom-icon {
            width: 18px;
            height: 18px;
        }
    </style>

</head>

<body>

    @include('layouts.mobile_sidebar')
    @include('layouts.sidebar')

    <main class="content">
        @include('layouts.imageModal')

        @include('layouts.navbar')

        <div class="main-content" style="padding-bottom: 80px; min-height: calc(100vh - 250px)">
            @yield('breadcrumb')

            @yield('content')
        </div>

{{--         @include('layouts.footer')--}}
    </main>

    @include('layouts.js')
    @stack('customJs')
</body>

</html>
