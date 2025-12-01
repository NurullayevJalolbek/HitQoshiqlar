<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="utf-8"/>
    <title>Envast | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon-16.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/envast_logo.svg') }}">

    <link rel="manifest" href="{{ asset('assets/img/favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/img/favicon/safari-pinned-tab.svg') }}" color="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link type="text/css" href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('vendor/notyf/notyf.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('vendor/fullcalendar/main.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('vendor/apexcharts/dist/apexcharts.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('vendor/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('vendor/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('vendor/leaflet/dist/leaflet.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('css/volt.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background: #f3f4f6;
        }

        .bg-soft-envast {
            background: radial-gradient(circle at top, #f9fafb 0, #e5e7eb 40%, #d1d5db 100%);
        }

        .login-wrapper {
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .login-card {
            border-radius: 18px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
            background-color: #ffffff;
            position: relative;
            width: 1200px !important;
            z-index: 2;
        }

        .btn-envast {
            background-color: #111827;
            border-color: #111827;
            color: #ffffff;
            border-radius: 999px;
            font-weight: 600;
        }

        .btn-envast:hover {
            background-color: #000000;
            border-color: #000000;
        }

        .form-control {
            border-radius: 999px;
        }

        .input-group-text {
            border-radius: 999px;
        }

        .envast-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #4b5563;
        }

        .envast-link {
            color: #BF9B63;
        }

        .envast-link:hover {
            color: #a27f3f;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 1.75rem !important;
            }
        }

        /* Tolqin fon – chap va o‘ng tomonda */
        .envast-wave-wrapper {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 46%;
            pointer-events: none;
            display: flex;
            align-items: center;
            opacity: 0.45;
            z-index: 1;
        }

        .envast-wave-left {
            position: absolute; /* container ichida erkin surish */
            top: 0; /* yuqori qirrasiga birlashtirish */
            left: 0; /* chap qirrasiga yopishtirish */
            z-index: 1; /* login kartadan orqada bo‘lsin */
            width: 1000px; /* xohlashcha kenglik */
            height: 570px; /* xohlashcha bo‘y */
        }

        .envast-wave-right {
            right: -95px;
            justify-content: flex-end;

        }


        .envast-wave {
            width: 520px;
            max-width: 40vw;
        }

        .newoption {
            width: 3000px;
        }

        .iconsnew {
            position: absolute;
            z-index: 5;
        }

        .envast-wave svg {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Chiziqlar animatsiyasi */
        .envast-wave-line {
            stroke: #BF9B63;
            stroke-width: 0.7;
            fill: none;
            stroke-linecap: round;
            stroke-dasharray: 520;
            stroke-dashoffset: 520;
            animation: waveStroke 7s linear infinite;
            animation-delay: calc(var(--i) * 0.25s);
        }

        @keyframes waveStroke {
            0% {
                stroke-dashoffset: 520;
                transform: translateY(0);
            }
            40% {
                stroke-dashoffset: 0;
                transform: translateY(-3px);
            }
            70% {
                stroke-dashoffset: -160;
                transform: translateY(2px);
            }
            100% {
                stroke-dashoffset: -520;
                transform: translateY(0);
            }
        }

        .login-card-container {
            position: relative; /* SVG bilan bog‘lash uchun containerga relative */
            z-index: 2; /* login kartani SVG ustida ko‘rsatish */
        }

        @keyframes waveSideLeft {
            0% {
                transform: translateX(-10%);
            }
            100% {
                transform: translateX(0%);
            }
        }

        @keyframes waveSideRight {
            0% {
                transform: translateX(10%);
            }
            100% {
                transform: translateX(0%);
            }
        }

        @media (max-width: 992px) {
            .envast-wave-wrapper {
                opacity: 0.28;
                width: 55%;
            }

            .envast-wave {
                max-width: 65vw;
            }
        }

        @media (max-width: 768px) {
            .envast-wave-right {
                display: none;
            }

            .envast-wave-left {
                width: 100%;
                justify-content: center;
                /*animation: waveSideLeft 20s ease-in-out infinite alternate;*/
            }

            .envast-wave {
                max-width: 90vw;
            }
        }
    </style>
</head>

<body>
<main>
    <section class="login-wrapper d-flex align-items-center bg-soft-envast">

        <!-- Chap tomondagi tolqin -->

        <div class="container login-container newoption">
            <div class="row justify-content-center">
                <div
                    class="col-11 col-sm-9 col-md-7 col-lg-5 d-flex align-items-center justify-content-center login-card-container">
                    <div class="login-card p-4 p-lg-5 w-100 wave-overlap">

                        <div class="text-center mb-4">
                            <img src="{{ asset('assets/img/envast_logo_1.svg') }}" alt="Envast"
                                 style="height: 55px;" class="mb-2">
                        </div>

                        <form id="formAuthentication" action="{{ route('login.post') }}" method="POST" class="mt-4">
                            @csrf
                            @error('login')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror

                            <div class="mb-3">
                                <label for="username" class="envast-label mb-1">Login</label>
                                <div class="input-group">
                                        <span class="input-group-text bg-gray-100 border-end-0">
                                            <i class="bi bi-person" style="color: #BF9B63;"></i>
                                        </span>
                                    <input type="text" id="username" name="username"  class="form-control border-start-0 @error('username') is-invalid @enderror""
                                           placeholder="Loginni kiriting" autofocus required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-2">
                                <label for="password" class="envast-label mb-1">Parol</label>
                                <div class="input-group">
                                        <span class="input-group-text bg-gray-100 border-end-0">
                                            <i class="bi bi-lock" style="color: #BF9B63;"></i>
                                        </span>
                                    <input type="password" id="password" name="password"
                                           class="form-control border-start-0 @error('password') is-invalid @enderror" placeholder="Parolni kiriting" required>
                                    <button type="button" class="input-group-text bg-white border-start-0"
                                            id="togglePassword" style="cursor: pointer;">
                                        <i id="togglePasswordIcon" class="bi bi-eye"
                                           style="font-size: 18px; color: #BF9B63;"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember" style="font-size: 0.85rem;">
                                        Loginni eslab qolish
                                    </label>
                                </div>

                                <a href="#" class="envast-link" style="font-size: 0.85rem;">Parolni unutdingizmi?</a>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-envast py-2">Kirish</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="envast-wave-wrapper envast-wave-left">
            <div class="envast-wave"
                 style="width: 920px !important; height: 400px !important; position:absolute; top: 230px !important;">
                {!! file_get_contents(public_path('assets/img/newanimation.svg')) !!}
            </div>
        </div>


        <!-- O‘ng tomondagi tolqin -->
        <div class="envast-wave-wrapper envast-wave-right">
            <div class="envast-wave"
                 style="width: 2000px !important; height: 400px; position:absolute; top: -15px !important; left: 10px;">
                {!! file_get_contents(public_path('assets/img/newanimation.svg')) !!}
            </div>
        </div>


    </section>
</main>

<script>
    (function () {
        // SVG chiziqlariga klass va delay berish
        const lines = document.querySelectorAll('.envast-wave svg polyline, .envast-wave svg path');
        lines.forEach((el, index) => {
            el.classList.add('envast-wave-line');
            el.style.setProperty('--i', index);
        });

        // Parol ko‘rsatish/yashirish
        const password = document.getElementById('password');
        const btn = document.getElementById('togglePassword');
        const icon = document.getElementById('togglePasswordIcon');

        if (btn && password && icon) {
            btn.addEventListener('click', function () {
                const type = password.type === "password" ? "text" : "password";
                password.type = type;

                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        }
    })();
</script>
</body>
</html>
