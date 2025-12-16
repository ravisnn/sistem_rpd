<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Aplikasi Rencana Kegiatan')</title>
<link rel="icon" type="image/png" href="{{ asset('images/Logo_PPATK_(2014).png') }}">

<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/rencana-modern.css') }}">
<link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.tailwindcss.com"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
/* ===== BASE LAYOUT ===== */
.layout {
    display: flex;
    min-height: 100vh;
    align-items: stretch;
}

.sidebar {
    display: flex;
    flex-direction: column;
    height: 100vh;
    width: 220px;
    background: #fff;
    box-shadow: 2px 0 10px rgba(0,0,0,0.08);
    overflow-y: auto;
    flex-shrink: 0;
}

.konten {
    flex: 1;
    padding: 48px 32px 32px 32px;
    min-width: 0;
    box-sizing: border-box;
}

/* ===== TOGGLE BUTTON DEFAULT (selalu ada, yang ngontrol media query) ===== */
#sidebarToggle {
    position: fixed;
    top: 14px;
    left: 14px;
    background: #007bff;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    z-index: 200;
    display: none;
}

/* ===== MOBILE ===== */
@media(max-width: 768px) {
    .sidebar {
        position: fixed;
        top: 0;
        left: -100%;
        height: 100vh;
        transition: left 0.3s ease;
        z-index: 100;
        overflow-y: auto;
    }

    body.sidebar-open .sidebar {
        left: 0;
    }

    .sidebar-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        display: none;
        z-index: 90;
    }

    body.sidebar-open .sidebar-overlay {
        display: block;
    }

    .konten {
        margin-left: 0 !important;
        padding: 64px 16px 16px 16px;
        width: 100%;
        min-height: 100vh;
        overflow-x: hidden;
        overflow-y: auto;
        font-size: 16px;
    }

    /* TAMPILKAN TOGGLE HANYA DI MOBILE */
    #sidebarToggle {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 10px;
    }

    /* SEMBUNYIKAN TOGGLE SAAT SIDEBAR TERBUKA */
    body.sidebar-open #sidebarToggle {
        display: none;
    }
}
</style>
</head>
<body>

<!-- Toggle Button -->
<button id="sidebarToggle">☰</button>

<!-- Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="layout">
    <!-- SIDEBAR -->
    <div class="sidebar">
        @auth
            @if(auth()->user()->role === 'user')
                @include('layouts.sidebar_user')
            @else
                @include('layouts.sidebar')
            @endif
        @else
            @include('layouts.sidebar')
        @endauth
    </div>

    <!-- MAIN CONTENT -->
    <div class="konten">
        <main class="main-content-area">
            @yield('content')
        </main>
    </div>
</div>

<script src="{{ asset('js/session-monitor.js') }}"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("sidebarToggle");
    const overlay = document.getElementById("sidebarOverlay");

    toggle.addEventListener("click", () => {
        document.body.classList.add("sidebar-open");
    });

    overlay.addEventListener("click", () => {
        document.body.classList.remove("sidebar-open");
    });

    window.addEventListener("resize", () => {
        if (window.innerWidth > 768) {
            document.body.classList.remove("sidebar-open");
        }
    });
});
</script>

</body>
</html>
