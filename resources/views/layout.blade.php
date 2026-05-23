<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login App')</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @yield('styles')

    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 0;
            font-size: 1.05rem; /* كبرنا الخط الأساسي */
            line-height: 1.6;
        }

        img, table, iframe, canvas, svg {
            max-width: 100%;
        }

        /* --- Modern Premium Nav --- */
        .main-nav {
            background: #0f172a;
            color: #fff;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            height: 64px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            width: 100%;
        }

        .nav-inner {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
            gap: 1rem;
        }

        .nav-logo {
            font-size: 1.6rem; /* تكبير اللوجو */
            font-weight: 800;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .nav-logo span {
            background: #2563eb;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.85rem;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            margin: 0;
            padding: 0;
            list-style: none;
            height: 100%;
        }

        .nav-item {
            position: relative;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .nav-link {
            color: #94a3b8;
            padding: 0.6rem 0.9rem;
            border-radius: 8px;
            font-size: 1.05rem; /* تكبير خط الروابط */
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            white-space: nowrap;
        }

        .nav-link:hover, .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.05);
        }

        .nav-link.active {
            color: #3b82f6;
        }

        /* Dropdown Logic */
        .dropdown {
            position: relative;
        }

        .dropdown-trigger {
            cursor: pointer;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: #1e293b;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 0.75rem;
            min-width: 210px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s;
            z-index: 1001;
            display: grid;
            gap: 0.15rem;
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-link {
            color: #94a3b8;
            padding: 0.55rem 0.75rem;
            border-radius: 6px;
            font-size: 0.82rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            text-align: right;
        }

        .dropdown-link:hover {
            background: rgba(255,255,255,0.05);
            color: #fff;
        }

        .dropdown-link.active {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .nav-group-label {
            font-size: 9px;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.05em;
            padding: 0.4rem 0.75rem 0.2rem;
            margin-top: 0.3rem;
            border-top: 1px solid rgba(255,255,255,0.05);
            font-weight: 800;
        }

        .nav-group-label:first-child {
            border-top: none;
            margin-top: 0;
        }

        .btn-logout {
            padding: 0.4rem 0.8rem;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444 !important;
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .btn-logout:hover {
            background: #ef4444;
            color: #fff !important;
        }

        .nav-separator {
            width: 1px;
            height: 24px;
            background: rgba(255,255,255,0.1);
            margin: 0 0.4rem;
        }

        /* Mobile Adjustments */
        .hamburger {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            cursor: pointer;
            gap: 4px;
        }

        .hamburger span {
            display: block;
            width: 18px;
            height: 2px;
            background: #fff;
            border-radius: 2px;
            transition: 0.3s;
            transform-origin: center;
        }

        .hamburger.open span:nth-child(1) {
            transform: translateY(6px) rotate(45deg);
        }

        .hamburger.open span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.open span:nth-child(3) {
            transform: translateY(-6px) rotate(-45deg);
        }

        .mobile-menu {
            display: none;
            flex-direction: column;
            background: #0f172a;
            position: fixed;
            top: 64px;
            left: 0;
            right: 0;
            bottom: 0;
            border-top: 1px solid rgba(255,255,255,0.1);
            padding: 1rem 1rem 5rem;
            gap: 0.3rem;
            z-index: 999;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .mobile-menu.open {
            display: flex;
        }

        .mobile-menu a, .mobile-menu button {
            color: #94a3b8;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            text-align: right;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .mobile-menu a.active {
            background: #2563eb;
            color: #fff;
        }

        .mobile-separator {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 0.5rem 0;
        }

        @media (max-width: 1200px) {
            .nav-link { padding: 0.5rem 0.5rem; font-size: 0.8rem; }
        }

        @media (max-width: 1024px) {
            .nav-links { display: none; }
            .hamburger { display: flex; flex-shrink: 0; }
            .nav-logo { flex-shrink: 0; }
            .mobile-current-page {
                display: flex;
                align-items: center;
                justify-content: center;
                flex: 1;
                min-width: 0;
                padding: 0 10px;
            }
            .mobile-current-page-text {
                background: rgba(255,255,255,0.05);
                color: #fff;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 0.85rem;
                font-weight: 700;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 100%;
            }
        }

        .page-content {
            width: 100%;
            max-width: 100%;
            padding: 14px;
            overflow-x: hidden;
        }

        .footer-bar {
            width: 100%;
            background: #1e3a5f;
            color: #e2e8f0;
            border-top: 1px solid rgba(255,255,255,0.08);
            margin-top: 18px;
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 14px 16px;
            text-align: center;
            font-size: 0.92rem;
            line-height: 1.8;
        }

        .footer-inner a {
            color: #93c5fd;
            text-decoration: none;
        }

        .footer-inner a:hover {
            text-decoration: underline;
        }

        @media (min-width: 768px) {
            .page-content {
                padding: 20px;
            }
        }

        @media (max-width: 900px) {
            .nav-inner {
                padding: 0 0.85rem;
                gap: 0.5rem;
            }
            .nav-logo {
                font-size: 1.1rem;
                gap: 0.4rem;
            }
            .nav-logo span {
                font-size: 0.75rem;
                padding: 2px 8px;
            }
        }

        @media (max-width: 576px) {
            body { font-size: 0.95rem; }
            .nav-inner {
                padding: 0 0.5rem;
            }
            .nav-logo {
                font-size: 0.95rem;
            }
            .nav-logo span {
                font-size: 0.7rem;
                padding: 2px 6px;
            }
            .mobile-menu {
                padding: 0.8rem 1rem 1.2rem;
            }
            .mobile-menu a,
            .mobile-menu button {
                font-size: 1rem;
                padding: 0.8rem;
            }
            .mobile-current-page {
                padding: 0 5px;
            }
            .mobile-current-page-text {
                font-size: 0.75rem;
                padding: 3px 8px;
            }
            .page-content {
                padding: 15px;
            }
            .footer-inner {
                font-size: 0.9rem;
                padding: 15px;
            }
        }

        @media (min-width: 1025px) {
            .mobile-current-page {
                display: none !important;
            }
        }

        /* Global Loader Styles */
        #global-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.7); /* slate-900 with opacity */
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.3s ease;
        }

        #global-loader.show {
            display: flex;
        }

        .loader-z {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            filter: drop-shadow(0 0 10px rgba(37, 99, 235, 0.5));
        }

        .loader-z path {
            stroke: #2563eb;
            stroke-width: 8;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
            stroke-dasharray: 300;
            stroke-dashoffset: 300;
            animation: drawZ 2s ease-in-out infinite;
        }

        @keyframes drawZ {
            0% { stroke-dashoffset: 300; }
            50% { stroke-dashoffset: 0; }
            100% { stroke-dashoffset: -300; }
        }

        .loader-text {
            color: #fff;
            font-family: 'Cairo', sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(0.98); }
        }

        /* Tom Select RTL Fixes */
        html[dir="rtl"] .ts-wrapper.single .ts-control {
            padding-left: 2rem !important;
            padding-right: 0.75rem !important;
            background-position: left 0.75rem center !important;
            text-align: right !important;
        }

        html[dir="rtl"] .ts-wrapper.single .ts-control::after {
            left: 12px !important;
            right: auto !important;
        }

        html[dir="rtl"] .ts-dropdown {
            text-align: right !important;
        }

        /* Adjusting for Bootstrap/Tailwind conflict */
        .ts-wrapper .ts-control {
            min-height: 38px;
            display: flex;
            align-items: center;
            border-radius: 0.5rem;
            border-color: #d1d5db;
        }

        .ts-wrapper.focus .ts-control {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            border-color: #2563eb;
        }
    </style>
</head>
<body>
    <!-- Global Loader Overlay -->
    <div id="global-loader">
        <svg class="loader-z" viewBox="0 0 100 100">
            <path d="M 25 25 L 75 25 L 25 75 L 75 75" />
        </svg>
        <div class="loader-text">جاري التحميل...</div>
    </div>

@php
    $currentPageLabel = match(true) {
        request()->routeIs('properties.*') => 'العقارات',
        request()->routeIs('login') => 'تسجيل الدخول',
        request()->routeIs('register') => 'إنشاء حساب',
        default => 'الرئيسية',
    };
@endphp

<nav class="main-nav">
    <div class="nav-inner">
        <a href="/" class="nav-logo">
            <span>Real-Estate</span> Tiba
        </a>

        <div class="mobile-current-page">
            <span class="mobile-current-page-text">{{ $currentPageLabel }}</span>
        </div>

        @auth
        <div class="nav-links">
            {{-- العقارات --}}
            <div class="nav-item dropdown">
                <div class="nav-link dropdown-trigger {{ request()->routeIs('properties.*') ? 'active' : '' }}">
                    🏢 العقارات
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
                <div class="dropdown-menu">
                    <a href="{{ route('properties.create') }}" class="dropdown-link {{ request()->routeIs('properties.create') ? 'active' : '' }}">➕ إضافة عقار/أرض</a>
                    <a href="{{ route('properties.index') }}" class="dropdown-link {{ request()->routeIs('properties.index') ? 'active' : '' }}">📋 العقارات المتاحة</a>
                    @if(auth()->user()->isStaff())
                    <a href="{{ route('properties.sold') }}" class="dropdown-link {{ request()->routeIs('properties.sold') ? 'active' : '' }}">💰 العقارات المباعة</a>
                    @endif
                </div>
            </div>

            @if(auth()->user()->isStaff())
            {{-- إدارة الموظفين --}}
            <div class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">👥 الموظفين</a>
            </div>
            @endif

            @if(auth()->user()->isSuperAdmin())
            {{-- سجل المراقبة --}}
            <div class="nav-item">
                <a href="{{ route('audit.index') }}" class="nav-link {{ request()->routeIs('audit.*') ? 'active' : '' }}">🔍 سجل المراقبة</a>
            </div>
            @endif

            <div class="nav-separator"></div>

            <div class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">🚪 خروج</button>
                </form>
            </div>
        </div>
        @else
        <div class="nav-links">
            <a href="{{ route('login') }}" class="nav-link btn-login">🔑 دخول</a>
        </div>
        @endauth
        
        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu" type="button">
            <span></span><span></span><span></span>
        </button>
    </div>
    
    <div class="mobile-menu" id="mobileMenu">
        @auth
            <a href="{{ route('properties.create') }}" class="{{ request()->routeIs('properties.create') ? 'active' : '' }}">➕ إضافة عقار/أرض</a>
            <a href="{{ route('properties.index') }}" class="{{ request()->routeIs('properties.index') ? 'active' : '' }}">🏢 العقارات المتاحة</a>
            <a href="{{ route('properties.sold') }}" class="{{ request()->routeIs('properties.sold') ? 'active' : '' }}">💰 العقارات المباعة</a>
            <div class="mobile-separator"></div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">🚪 تسجيل خروج</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">🔑 تسجيل دخول</a>
        @endauth
    </div>
</nav>

<div class="page-content">
    @yield('content')
</div>

<footer class="footer-bar">
    <div class="footer-inner">
        Copyright © {{ date('Y') }} — Zeyad Yasser, IT Manager @ Gamma Scan Center<br>
        WhatsApp: <a href="https://wa.me/201024474059" target="_blank" rel="noopener noreferrer">wa.me/201024474059</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    const btn = document.getElementById('hamburgerBtn');
    const menu = document.getElementById('mobileMenu');

    if (btn && menu) {
        btn.addEventListener('click', () => {
            btn.classList.toggle('open');
            menu.classList.toggle('open');
        });

        document.addEventListener('click', (e) => {
            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                btn.classList.remove('open');
                menu.classList.remove('open');
            }
        });
    }

    // --- Global Loader Logic ---
    const loader = document.getElementById('global-loader');

    function showLoader() {
        if (loader) {
            loader.classList.add('show');
        }
    }

    // 1. Show loader on form submissions
    document.addEventListener('submit', (e) => {
        // Don't show if the event was prevented (e.g. by validation)
        if (!e.defaultPrevented) {
            showLoader();
        }
    });

    // 2. Show loader on navigation link clicks
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a');
        
        if (link && 
            link.href && 
            !link.href.includes('#') && 
            !link.href.includes('export') && 
            !link.href.startsWith('javascript:') &&
            link.target !== '_blank' &&
            !e.ctrlKey && !e.metaKey && !e.shiftKey && e.button === 0 // only left click, no modifier
        ) {
            // Check if it's an internal link (optional, but usually desired for same-origin)
            if (link.origin === window.location.origin) {
                showLoader();
            }
        }
    });

    // 3. Hide loader if page is loaded from cache (e.g. back button)
    window.addEventListener('pageshow', (event) => {
        if (event.persisted && loader) {
            loader.classList.remove('show');
        }
    });
</script>
    @if(session('alert_error'))
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            alert("{{ session('alert_error') }}");
        });
    </script>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>