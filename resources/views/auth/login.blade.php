<!DOCTYPE html>
<html lang="uz">

<head>
    <meta charset="utf-8" />
    <title>Envast | Login</title>
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
            /* 🎨 Rasmga mos "neon blue/cyan" palitra */
            --accent: #4cc9f0;
            /* ikonka/outline */
            --accent2: #72e6ff;
            /* hover/focus */
            --accentGlow: rgba(76, 201, 240, .28);

            --cardBg: rgba(255, 255, 255, .10);
            --cardBorder: rgba(255, 255, 255, .22);

            --inputBg: rgba(255, 255, 255, .16);
            --inputBorder: rgba(255, 255, 255, .22);
            --textWhite: rgba(255, 255, 255, .92);

            --btnBg: rgba(8, 15, 30, .80);
            --btnBgHover: rgba(8, 15, 30, .95);
        }

        /* ✅ Orqa fon: to‘liq rasm + overlay */
        body {
            min-height: 100vh;
            margin: 0;
            background: radial-gradient(circle at 30% 20%, rgba(76, 201, 240, .18), transparent 45%),
            radial-gradient(circle at 70% 60%, rgba(114, 230, 255, .12), transparent 50%),
            linear-gradient(rgba(3, 10, 25, .55), rgba(3, 10, 25, .70)),
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

        /* ✅ Card: glass */
        .login-card {
            border-radius: 18px;
            border: 1px solid var(--cardBorder);
            background: var(--cardBg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow:
                0 18px 50px rgba(0, 0, 0, .38),
                0 0 0 1px rgba(76, 201, 240, .10) inset;
            position: relative;
            overflow: hidden;
        }

        /* card ichida yumshoq glow */
        .login-card::before {
            content: "";
            position: absolute;
            inset: -80px -80px auto -80px;
            height: 220px;
            background: radial-gradient(circle, rgba(76, 201, 240, .20), transparent 60%);
            pointer-events: none;
        }

        .envast-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--textWhite);
            letter-spacing: 0.2px;
        }

        /* ✅ Inputlar */
        .form-control {
            border-radius: 999px;
            background: var(--inputBg);
            border: 1px solid var(--inputBorder);
            color: #fff;
            height: 44px;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, .70);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, .18);
            color: #fff;
            border-color: rgba(76, 201, 240, .85);
            box-shadow: 0 0 0 .22rem var(--accentGlow);
        }

        /* ✅ Input-group */
        .input-group-text {
            border-radius: 999px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid var(--inputBorder);
        }

        /* ✅ Ikonkalar rangi + glow */
        .envast-icon {
            color: var(--accent);
            font-size: 18px;
            filter: drop-shadow(0 0 6px rgba(76, 201, 240, .28));
        }

        /* eye button hover */
        #togglePassword:hover .envast-icon {
            color: var(--accent2);
            filter: drop-shadow(0 0 10px rgba(114, 230, 255, .35));
        }

        /* ✅ Button */
        .btn-envast {
            background: var(--btnBg);
            border: 1px solid rgba(255, 255, 255, .18);
            color: #ffffff;
            border-radius: 999px;
            font-weight: 700;
            letter-spacing: 0.3px;
            height: 46px;
            box-shadow:
                0 10px 22px rgba(0, 0, 0, .35),
                0 0 0 1px rgba(76, 201, 240, .08) inset;
        }

        .btn-envast:hover {
            background: var(--btnBgHover);
            border-color: rgba(76, 201, 240, .45);
            box-shadow:
                0 12px 26px rgba(0, 0, 0, .40),
                0 0 18px rgba(76, 201, 240, .18);
        }

        /* invalid feedback agar qorong‘ida bilinmay qolsa */
        .invalid-feedback {
            color: #ffb4b4;
        }

        /* Mobile */
        @media (max-width: 576px) {
            .login-card {
                padding: 1.75rem !important;
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
                        <div class="login-card p-4 p-lg-5">

                            <form id="formAuthentication" action="{{ route('login.post') }}" method="POST">
                                @csrf

                                @error('login')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror

                                <!-- ✅ Username -->
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

                                <!-- ✅ Password -->
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