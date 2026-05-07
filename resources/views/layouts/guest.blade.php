<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Tourism Marketplace</title>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #2D6A4F;
            --secondary: #1B4332;
            --accent: #D8F3DC;
            --white: #ffffff;
            --glass: rgba(255, 255, 255, 0.92);
        }

        body {
            margin: 0;
            font-family: 'Inter', Arial, sans-serif;
        }

        .auth-page {
            min-height: 100vh;
            background:
                linear-gradient(rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0.35)),
                url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-card {
            background: var(--glass);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 38px;
            border-radius: 24px;
            box-shadow: 0 25px 55px rgba(0, 0, 0, 0.28);
            width: 100%;
            max-width: 430px;
            border: 1px solid rgba(255, 255, 255, 0.45);
        }

        .auth-logo-area {
            text-align: center;
            margin-bottom: 26px;
        }

        .auth-logo-icon {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .auth-logo-title {
            font-size: 1.55rem;
            font-weight: 800;
            color: var(--secondary);
            margin: 0;
            line-height: 1.3;
        }

        .auth-logo-subtitle {
            margin-top: 8px;
            color: #5f6f65;
            font-size: 0.92rem;
        }

        .auth-label {
            display: block;
            font-weight: 700;
            margin-bottom: 7px;
            color: var(--secondary);
            font-size: 0.93rem;
        }

        .auth-input,
        .auth-select {
            width: 100%;
            padding: 13px 14px;
            border: 2px solid #e1e7e4;
            border-radius: 12px;
            outline: none;
            background: rgba(255, 255, 255, 0.85);
            color: #1f2937;
            transition: 0.25s ease;
        }

        .auth-input:focus,
        .auth-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(45, 106, 79, 0.14);
            background: white;
        }

        .auth-group {
            margin-bottom: 18px;
        }

        .auth-button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary), #40916C);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.25s ease;
            box-shadow: 0 10px 20px rgba(45, 106, 79, 0.22);
        }

        .auth-button:hover {
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            transform: translateY(-2px);
        }

        .auth-link {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        .auth-bottom-text {
            text-align: center;
            margin-top: 18px;
            font-size: 0.9rem;
            color: #526057;
        }

        .auth-error {
            color: #dc2626;
            font-size: 0.82rem;
            margin-top: 6px;
        }

        .auth-status {
            background: #dcfce7;
            color: #166534;
            padding: 12px 14px;
            border-radius: 12px;
            margin-bottom: 16px;
            font-size: 0.9rem;
        }

        .auth-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #526057;
            font-size: 0.9rem;
        }

        .auth-footer-note {
            text-align: center;
            color: rgba(255,255,255,0.85);
            margin-top: 18px;
            font-size: 0.8rem;
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 28px 22px;
            }

            .auth-logo-title {
                font-size: 1.35rem;
            }
        }
    </style>
</head>

<body>
    <main class="auth-page">
        <div>
            {{ $slot }}

            <p class="auth-footer-note">
                Smart Tourism & Travel Marketplace | CSE470 Project
            </p>
        </div>
    </main>
</body>
</html>