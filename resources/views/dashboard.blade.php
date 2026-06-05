@php
    $user = Auth::user();
    $isAdmin = $user->role === 'ADMIN';

    // Generate initials from name
    $words = explode(' ', $user->name);
    $initials = '';
    foreach ($words as $word) {
        $initials .= strtoupper(substr($word, 0, 1));
    }
    $initials = substr($initials, 0, 2);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Zull Logbook</title>
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
            
            @if($isAdmin)
                --accent-color: #f59e0b;   /* Yellow/Gold 500 */
                --accent-hover: #d97706;   /* Yellow/Gold 600 */
                --accent-text: #0f172a;
            @else
                --accent-color: #3b82f6;   /* Blue 500 */
                --accent-hover: #2563eb;   /* Blue 600 */
                --accent-text: #ffffff;
            @endif
            
            --sidebar-bg: #090d16;     /* Darker slate/navy for contrast */
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
            overflow: hidden;
        }

        /* Dashboard Container */
        .dashboard-container {
            display: flex;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--card-border);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px;
            flex-shrink: 0;
            z-index: 10;
        }

        .sidebar-top {
            display: flex;
            flex-direction: column;
        }

        /* Sidebar Logo */
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 36px;
            padding-left: 8px;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background: var(--accent-color);
            color: var(--accent-text);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 18px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .logo-text {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-primary);
        }

        /* Menu Groups */
        .menu-group {
            margin-bottom: 28px;
        }

        .menu-title {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 12px;
            padding-left: 12px;
        }

        .menu-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .menu-item a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            transition: var(--transition-smooth);
        }

        .menu-item a:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.03);
        }

        .menu-item a svg {
            width: 20px;
            height: 20px;
            stroke-width: 2;
            color: var(--text-muted);
            transition: var(--transition-smooth);
        }

        .menu-item a:hover svg {
            color: var(--text-primary);
        }

        .menu-item.active a {
            background: var(--accent-color);
            color: var(--accent-text);
            font-weight: 600;
        }

        .menu-item.active a svg {
            color: var(--accent-text);
        }

        /* Sidebar Footer / Logout */
        .sidebar-footer {
            border-top: 1px solid var(--card-border);
            padding-top: 16px;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            color: #ef4444;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            background: transparent;
            border: none;
            width: 100%;
            cursor: pointer;
            text-align: left;
            font-family: var(--font-family);
            transition: var(--transition-smooth);
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.08);
        }

        .logout-btn svg {
            width: 20px;
            height: 20px;
            stroke-width: 2;
        }

        /* Main Panel styling */
        .main-panel {
            flex-grow: 1;
            background-color: var(--bg-color);
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        /* Top Bar Styling */
        .top-bar {
            height: 80px;
            border-bottom: 1px solid var(--card-border);
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--bg-color);
            flex-shrink: 0;
        }

        .search-container {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 8px;
            padding: 8px 12px;
            width: 280px;
        }

        .search-container svg {
            color: var(--text-muted);
            width: 16px;
            height: 16px;
        }

        .search-input {
            background: transparent;
            border: none;
            outline: none;
            color: var(--text-primary);
            font-family: var(--font-family);
            font-size: 14px;
            width: 100%;
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .icon-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition-smooth);
        }

        .icon-btn:hover {
            color: var(--text-primary);
        }

        .icon-btn svg {
            width: 20px;
            height: 20px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            text-align: right;
        }

        .user-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .user-email {
            font-size: 12px;
            color: var(--text-muted);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent-color);
            color: var(--accent-text);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* Content Area Container */
        .content-area {
            flex-grow: 1;
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
        }

        /* Beautiful Centered Welcome Card */
        .welcome-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 48px;
            text-align: center;
            max-width: 600px;
            width: 100%;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: cardFadeIn 0.5s ease-out forwards;
        }

        @keyframes cardFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-card::before {
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

        .welcome-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--card-border);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 24px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .welcome-message {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.4;
            margin-bottom: 32px;
        }

        /* Clock display */
        .clock-container {
            border-top: 1px solid var(--card-border);
            padding-top: 24px;
            margin-top: 24px;
        }

        .clock-date {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .clock-time {
            font-size: 40px;
            font-weight: 800;
            color: var(--text-primary);
            font-variant-numeric: tabular-nums;
            letter-spacing: -0.5px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-top">
                <div class="sidebar-logo">
                    <div class="logo-icon">Z</div>
                    <span class="logo-text">Zull Logbook</span>
                </div>
                
                <!-- General Menu -->
                <div class="menu-group">
                    <div class="menu-title">General</div>
                    <ul class="menu-list">
                        <li class="menu-item active">
                            <a href="#">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="7" height="9" rx="1"></rect>
                                    <rect x="14" y="3" width="7" height="5" rx="1"></rect>
                                    <rect x="14" y="12" width="7" height="9" rx="1"></rect>
                                    <rect x="3" y="16" width="7" height="5" rx="1"></rect>
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" style="pointer-events: none; opacity: 0.5;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="2" y="4" width="20" height="16" rx="2" ry="2"></rect>
                                    <line x1="12" y1="4" x2="12" y2="20"></line>
                                </svg>
                                <span>My Wallet</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" style="pointer-events: none; opacity: 0.5;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="9" y1="3" x2="9" y2="21"></line>
                                </svg>
                                <span>Bank & Card</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" style="pointer-events: none; opacity: 0.5;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                                <span>Transaction</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" style="pointer-events: none; opacity: 0.5;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                </svg>
                                <span>Notification</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Preferences Menu -->
                <div class="menu-group">
                    <div class="menu-title">Preferences</div>
                    <ul class="menu-list">
                        <li class="menu-item">
                            <a href="#" style="pointer-events: none; opacity: 0.5;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="3"></circle>
                                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                                </svg>
                                <span>Account Setting</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" style="pointer-events: none; opacity: 0.5;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                                </svg>
                                <span>Help Center</span>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="#" style="pointer-events: none; opacity: 0.5;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <span>Privacy and Policy</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Sidebar Footer / Logout -->
            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                    @csrf
                </form>
                <button onclick="document.getElementById('logout-form').submit();" class="logout-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span>Sign Out</span>
                </button>
            </div>
        </aside>

        <!-- Main Panel -->
        <main class="main-panel">
            <!-- Top Bar -->
            <header class="top-bar">
                <div class="search-container">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" placeholder="Search..." class="search-input" disabled>
                </div>

                <div class="top-bar-right">
                    <button class="icon-btn" style="opacity: 0.6; pointer-events: none;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </button>
                    
                    <!-- User Profile Badge -->
                    <div class="user-profile">
                        <div class="user-info">
                            <span class="user-name">{{ $user->name }}</span>
                            <span class="user-email">{{ $user->email }}</span>
                        </div>
                        <div class="user-avatar">
                            {{ $initials }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <div class="content-area">
                <div class="welcome-card">
                    <div class="welcome-badge">
                        {{ $user->role }} Dashboard
                    </div>
                    <div class="welcome-message">
                        @if($isAdmin)
                            Selamat pagi, {{ $user->username }}. Anda login sebagai admin
                        @else
                            Selamat pagi, {{ $user->username }}, Anda login sebagai staff.
                        @endif
                    </div>
                    
                    <!-- Digital Clock -->
                    <div class="clock-container">
                        <div class="clock-date" id="clock-date">---</div>
                        <div class="clock-time" id="clock-time">00:00:00</div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Clock ticking script -->
    <script>
        function updateClock() {
            const now = new Date();
            
            // Format Time (HH:MM:SS)
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock-time').textContent = `${hours}:${minutes}:${seconds}`;
            
            // Format Date in Indonesian (Hari, DD Bulan YYYY)
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dateString = now.toLocaleDateString('id-ID', options);
            document.getElementById('clock-date').textContent = dateString;
        }

        // Run immediately and update every second
        updateClock();
        setInterval(updateClock, 1000);
    </script>
</body>
</html>
