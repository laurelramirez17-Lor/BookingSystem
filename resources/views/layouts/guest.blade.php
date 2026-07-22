<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ARAUM Hotel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-white antialiased">
        <style>
            body {
                margin: 0;
                background:
                    linear-gradient(rgba(0,0,0,.72), rgba(0,0,0,.9)),
                    url("https://images.unsplash.com/photo-1584132967334-10e028bd69f7?auto=format&fit=crop&w=2000&q=80") center/cover fixed;
            }

            .auth-shell {
                min-height: 100vh;
                display: grid;
                grid-template-columns: minmax(0, .95fr) minmax(360px, 520px);
            }

            .auth-brand {
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 72px;
            }

            .auth-brand h1 {
                margin: 0 0 18px;
                color: #FFD700;
                font-size: clamp(48px, 7vw, 92px);
                letter-spacing: 10px;
                font-weight: 800;
            }

            .auth-brand p {
                max-width: 430px;
                color: #e7e0c8;
                line-height: 1.8;
                font-size: 16px;
            }

            .auth-panel {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 48px 24px;
                background: rgba(8,8,8,.88);
                border-left: 1px solid rgba(255,215,0,.22);
                backdrop-filter: blur(16px);
            }

            .auth-card {
                width: 100%;
                max-width: 430px;
                padding: 34px;
                background: rgba(18,18,18,.9);
                border: 1px solid rgba(255,215,0,.28);
                border-radius: 8px;
                box-shadow: 0 24px 70px rgba(0,0,0,.55);
            }

            .auth-mark {
                display: inline-flex;
                margin-bottom: 26px;
                color: #FFD700;
                text-decoration: none;
                font-size: 22px;
                font-weight: 800;
                letter-spacing: 5px;
            }

            .auth-card a {
                color: #FFD700;
                text-decoration: none;
            }

            .auth-card a:hover {
                color: #fff2a8;
            }

            .auth-card p,
            .auth-card .text-gray-600 {
                color: #cfc7ad !important;
            }

            @media (max-width: 900px) {
                .auth-shell {
                    grid-template-columns: 1fr;
                }

                .auth-brand {
                    padding: 52px 28px 28px;
                    text-align: center;
                    align-items: center;
                }

                .auth-panel {
                    border-left: 0;
                    padding-top: 24px;
                }
            }
        </style>

        <div class="auth-shell">
            <section class="auth-brand">
                <h1>ARAUM</h1>
                <p>Secure access for reservations, guest details, and the quieter work of keeping every stay polished.</p>
            </section>

            <section class="auth-panel">
                <div class="auth-card">
                    <a href="/" class="auth-mark">ARAUM</a>
                    {{ $slot }}
                </div>
            </section>
        </div>
    </body>
</html>
