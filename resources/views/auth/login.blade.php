<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="utf-8" />
    <title>Hit Qo'shiqlar Bot | Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon-16.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/envast_logo.svg') }}">

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
        :root {
            /* ✅ ORQA FONGA MOS (NEON CYAN/BLUE) */
            --accent: #5ad7ff;
            /* asosiy cyan */
            --accent2: #a7f1ff;
            /* light cyan */
            --accentGlow: rgba(90, 215, 255, .28);

            /* glass */
            --cardBg: rgba(255, 255, 255, .10);
            --cardBorder: rgba(255, 255, 255, .22);

            /* input */
            --inputBg: rgba(255, 255, 255, .16);
            --inputBorder: rgba(255, 255, 255, .22);
            --textWhite: rgba(255, 255, 255, .92);

            /* button */
            --btnBg: rgba(5, 14, 32, .78);
            --btnBgHover: rgba(5, 14, 32, .92);
        }

        body {
            min-height: 100vh;
            margin: 0;
            background: radial-gradient(circle at 30% 20%, rgba(90, 215, 255, .18), transparent 45%),
            radial-gradient(circle at 70% 60%, rgba(167, 241, 255, .12), transparent 50%),
            linear-gradient(rgba(3, 10, 25, .55), rgba(3, 10, 25, .72)),
            url("{{ asset('assets/img/hitqoshiqlarbot.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        /* ✅ Glass card */
        .login-card {
            border-radius: 18px;
            border: 1px solid var(--cardBorder);
            background: var(--cardBg);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow:
                0 18px 55px rgba(0, 0, 0, .42),
                0 0 0 1px rgba(90, 215, 255, .10) inset;
            position: relative;
            overflow: hidden;
            padding: 2rem;
        }

        .login-card::before {
            content: "";
            position: absolute;
            inset: -90px -90px auto -90px;
            height: 240px;
            background: radial-gradient(circle, rgba(90, 215, 255, .22), transparent 62%);
            pointer-events: none;
        }

        /* ✅ TITLE (FONGA MOS) */
        .login-title {
            font-size: 1.55rem;
            font-weight: 900;
            letter-spacing: 1.2px;
            margin: 0 0 6px 0;
            text-align: center;

            /* cyan gradient text */
            background: linear-gradient(90deg, var(--accent), var(--accent2), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;

            text-shadow:
                0 0 12px rgba(90, 215, 255, .45),
                0 0 28px rgba(90, 215, 255, .22);
        }

        .login-subtitle {
            text-align: center;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .78);
            display: block;
            margin-bottom: 18px;
            position: relative;
        }

        .login-subtitle::after {
            content: "";
            display: block;
            width: 120px;
            height: 1px;
            margin: 10px auto 0;
            background: linear-gradient(90deg, transparent, rgba(90, 215, 255, .95), transparent);
        }

        .envast-label {
            font-size: .92rem;
            font-weight: 650;
            color: var(--textWhite);
        }

        .form-control {
            height: 44px;
            border-radius: 999px;
            background: var(--inputBg);
            border: 1px solid var(--inputBorder);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, .72);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, .19);
            border-color: rgba(90, 215, 255, .90);
            box-shadow: 0 0 0 .22rem var(--accentGlow);
            color: #fff;
        }

        .input-group-text {
            border-radius: 999px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid var(--inputBorder);
        }

        /* ✅ ICONS (FONGA MOS) */
        .envast-icon {
            color: var(--accent);
            font-size: 18px;
            filter: drop-shadow(0 0 8px rgba(90, 215, 255, .35));
        }

        #togglePassword:hover .envast-icon {
            color: var(--accent2);
            filter: drop-shadow(0 0 12px rgba(167, 241, 255, .40));
        }

        /* ✅ Button */
        .btn-envast {
            height: 46px;
            border-radius: 999px;
            background: var(--btnBg);
            border: 1px solid rgba(255, 255, 255, .18);
            color: #fff;
            font-weight: 800;
            letter-spacing: .3px;
            box-shadow:
                0 12px 26px rgba(0, 0, 0, .38),
                0 0 0 1px rgba(90, 215, 255, .08) inset;
        }

        .btn-envast:hover {
            background: var(--btnBgHover);
            border-color: rgba(90, 215, 255, .55);
            box-shadow:
                0 14px 30px rgba(0, 0, 0, .44),
                0 0 18px rgba(90, 215, 255, .20);
        }

        .invalid-feedback {
            color: #ffb4b4;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 1.65rem !important;
            }

            .login-title {
                font-size: 1.35rem;
            }
        }
    </style>
</head>

<body>
    <main>
        <section class="login-wrapper">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-11 col-sm-9 col-md-7 col-lg-5">

                        <div class="login-card">

                            <!-- ✅ Sarlavha (fonga mos rangda) -->
                            <div class="mb-3">
                                <h1 class="login-title">Hit Qo'shiqlar Bot</h1>
                                <span class="login-subtitle">Admin Panel</span>
                            </div>

                            <form id="formAuthentication" action="{{ route('login.post') }}" method="POST">
                                @csrf

                                @error('login')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror

                                <!-- Username -->
                                <div class="mb-3">
                                    <label for="username" class="envast-label mb-1">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0">
                                            <i class="bi bi-person envast-icon"></i>
                                        </span>
                                        <input
                                            type="text"
                                            id="username"
                                            name="username"
                                            class="form-control border-start-0 @error('username') is-invalid @enderror"
                                            placeholder="Username kiriting"
                                            autofocus
                                            required>
                                        @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="mb-4">
                                    <label for="password" class="envast-label mb-1">Parol</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-end-0">
                                            <i class="bi bi-lock envast-icon"></i>
                                        </span>

                                        <input
                                            type="password"
                                            id="password"
                                            name="password"
                                            class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror"
                                            placeholder="Parolni kiriting"
                                            required>

                                        <button type="button"
                                            class="input-group-text border-start-0"
                                            id="togglePassword"
                                            style="cursor:pointer;">
                                            <i id="togglePasswordIcon" class="bi bi-eye envast-icon"></i>
                                        </button>

                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-envast">Kirish</button>
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        (function() {
            const password = document.getElementById('password');
            const btn = document.getElementById('togglePassword');
            const icon = document.getElementById('togglePasswordIcon');

            if (btn && password && icon) {
                btn.addEventListener('click', function() {
                    password.type = (password.type === "password") ? "text" : "password";
                    icon.classList.toggle('bi-eye');
                    icon.classList.toggle('bi-eye-slash');
                });
            }
        })();
    </script>
</body>

</html>