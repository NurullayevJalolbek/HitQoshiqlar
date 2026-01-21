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
            <div class="modal fade" id="previewsModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                    <div class="modal-content" style="border-radius:14px; overflow:hidden;">
                        <div class="modal-header" style="background:#0f172a; color:#fff;">
                            <h5 class="modal-title" style="margin:0;">Previews</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body" style="padding:14px;">
                            <div id="previewsLoading" style="font-size:14px; color:#64748b;">
                                Yuklanmoqda...
                            </div>

                            <div id="previewsEmpty" class="d-none"
                                style="padding:10px; border-radius:10px; background:#f1f5f9; color:#334155;">
                                Hozircha preview yo‘q.
                            </div>

                            <ul id="previewsList" class="list-unstyled d-none" style="margin:0;"></ul>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        {{-- @include('layouts.footer')--}}
    </main>

    @include('layouts.js')
    @stack('customJs')
</body>

</html>