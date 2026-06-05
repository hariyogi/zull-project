<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Zull Logbook</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-color: #0f172a;       /* Slate 900 */
            --card-bg: #1e293b;        /* Slate 800 */
            --card-border: #334155;    /* Slate 700 */
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --text-muted: #64748b;
            
            /* Admin Theme default - Flat Gold */
            --accent-color: #eab308;   /* Yellow 500 */
            --accent-hover: #ca8a04;   /* Yellow 600 */
            
            --font-family: 'Outfit', sans-serif;
            --transition-smooth: all 0.2s ease-in-out;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-color);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        /* Auth Container with simple fade-in */
        .auth-container {
            width: 100%;
            max-width: 440px;
            padding: 20px;
            animation: fadeIn 0.4s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Flat Card */
        .auth-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 40px 32px;
            position: relative;
        }

        /* Top decorative flat border bar */
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--accent-color);
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        /* Header styling */
        .auth-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .auth-logo {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--accent-color);
            margin-bottom: 8px;
            display: inline-block;
        }

        .auth-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .auth-subtitle {
            font-size: 14px;
            color: var(--text-secondary);
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 8px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            background: #0f172a;      /* Slate 900 */
            border: 1px solid #334155; /* Slate 700 */
            border-radius: 8px;
            padding: 12px 14px;
            color: var(--text-primary);
            font-family: var(--font-family);
            font-size: 15px;
            outline: none;
            transition: var(--transition-smooth);
        }

        .form-input:focus {
            border-color: var(--accent-color);
        }

        /* Flat Primary Button */
        .btn-primary {
            width: 100%;
            background-color: var(--accent-color);
            border: none;
            border-radius: 8px;
            padding: 14px;
            color: var(--accent-text, #0f172a);            /* Dark text by default */
            font-family: var(--font-family);
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition-smooth);
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
        }

        /* Flat Secondary Switch Button */
        .btn-secondary {
            display: block;
            width: 100%;
            background: transparent;
            border: 1px solid #334155;  /* Slate 700 */
            border-radius: 8px;
            padding: 12px;
            color: var(--text-secondary);
            font-family: var(--font-family);
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: var(--transition-smooth);
            margin-top: 16px;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: #475569;      /* Slate 600 */
            color: var(--text-primary);
        }

        /* Flat Alerts & Errors */
        .alert-error {
            background: #2d1212;        /* Dark Red */
            border: 1px solid #ef4444;  /* Red 500 */
            border-radius: 8px;
            color: #fca5a5;             /* Red 300 */
            padding: 12px 16px;
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Footer styling */
        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 12px;
            color: var(--text-muted);
        }

        /* Custom overrides if needed */
        @yield('styles')
    </style>
</head>
<body>
    <div class="auth-container">
        @yield('content')
        <div class="auth-footer">
            &copy; {{ date('Y') }} Zull Logbook. All rights reserved.
        </div>
    </div>
    
    @yield('scripts')
</body>
</html>
