<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - TembakauGIS Pamekasan</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --sidebar-width: 270px;
            --topbar-height: 70px;
            --primary-color: #10b981;
            --primary-hover: #059669;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #ffffff;
            --main-bg: #f8fafc;
        }

        * {
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--main-bg);
            color: #334155;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        /* --- SIDEBAR STYLING --- */
        #sidebar-wrapper {
            width: var(--sidebar-width);
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1040;
            overflow-y: auto;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(180deg, rgba(16, 185, 129, 0.1) 0%, rgba(15, 23, 42, 0) 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .sidebar-brand .brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #10b981 0%, #047857 100%);
            color: #fff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        }

        .sidebar-brand .brand-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: #ffffff;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .sidebar-brand .brand-subtitle {
            font-size: 0.72rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 600;
        }

        .sidebar-heading {
            padding: 1.2rem 1.5rem 0.5rem;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.09em;
            color: #64748b;
        }

        .nav-sidebar {
            padding: 0.75rem 1rem;
            flex-grow: 1;
        }

        .nav-sidebar .nav-item {
            margin-bottom: 4px;
        }

        .nav-sidebar .nav-link {
            color: var(--sidebar-text);
            padding: 0.75rem 1rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-sidebar .nav-link i {
            font-size: 1.2rem;
            transition: transform 0.2s ease;
        }

        .nav-sidebar .nav-link:hover {
            color: var(--sidebar-text-active);
            background-color: var(--sidebar-hover);
        }

        .nav-sidebar .nav-link:hover i {
            transform: translateX(2px);
        }

        .nav-sidebar .nav-link.active {
            color: #ffffff;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
            font-weight: 600;
        }

        .nav-sidebar .nav-link.active i {
            color: #ffffff;
        }

        /* Sidebar User Card */
        .sidebar-user {
            padding: 1rem 1.25rem;
            margin: 1rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-user .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
        }

        .sidebar-user .user-info {
            overflow: hidden;
        }

        .sidebar-user .user-name {
            color: #f8fafc;
            font-size: 0.85rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user .user-role {
            font-size: 0.72rem;
            color: #10b981;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* --- PAGE CONTENT & TOPBAR --- */
        #page-content-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .top-navbar {
            height: var(--topbar-height);
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .btn-toggle-sidebar {
            background: #f1f5f9;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-toggle-sidebar:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .content-body {
            padding: 2rem;
            flex-grow: 1;
        }

        .footer {
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 1rem 2rem;
            font-size: 0.85rem;
            color: #64748b;
        }

        /* --- CARDS & BADGES --- */
        .card {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }

        /* --- DESKTOP COLLAPSIBLE SIDEBAR --- */
        body.sidebar-collapsed #sidebar-wrapper {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        body.sidebar-collapsed #page-content-wrapper {
            margin-left: 0 !important;
        }

        /* --- MOBILE RESPONSIVENESS --- */
        @media (max-width: 991.98px) {
            #sidebar-wrapper {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #sidebar-wrapper.show {
                margin-left: 0 !important;
            }

            body.sidebar-collapsed #sidebar-wrapper {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #page-content-wrapper {
                margin-left: 0 !important;
            }

            body.sidebar-collapsed #page-content-wrapper {
                margin-left: 0 !important;
            }

            .content-body {
                padding: 1.25rem;
            }

            .top-navbar {
                padding: 0 1.25rem;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(15, 23, 42, 0.6);
                z-index: 1030;
                backdrop-filter: blur(2px);
            }

            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="sidebar-overlay"></div>

    <div class="d-flex">
        <!-- SIDEBAR -->
        <aside id="sidebar-wrapper">
            <!-- Brand -->
            <div class="sidebar-brand">
                <div class="brand-icon" style="background: rgba(255, 255, 255, 0.1); padding: 4px;">
                    <img src="{{ asset('images/logo-tembakau.png') }}" alt="Logo" style="width: 32px; height: 32px; object-fit: contain;">
                </div>
                <div>
                    <div class="brand-title">TembakauGIS</div>
                    <div class="brand-subtitle">Kab. Pamekasan</div>
                </div>
            </div>

            <!-- Navigation Links -->
            <ul class="nav flex-column nav-sidebar">
                <li class="sidebar-heading">Menu Utama</li>
                
                <!-- 1. Dashboard Statistik -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard Statistik</span>
                    </a>
                </li>

                <!-- Peta WebGIS Publik -->
                <li class="nav-item">
                    <a href="{{ route('peta') }}" target="_blank" class="nav-link text-info">
                        <i class="bi bi-globe-americas"></i>
                        <span>Peta WebGIS Publik <i class="bi bi-box-arrow-up-right ms-1 small"></i></span>
                    </a>
                </li>

                <li class="sidebar-heading mt-2">Manajemen Data</li>

                <!-- 2. Kelola Data Kecamatan -->
                <li class="nav-item">
                    <a href="{{ route('admin.kecamatan.index') }}" class="nav-link {{ request()->routeIs('admin.kecamatan.*') ? 'active' : '' }}">
                        <i class="bi bi-map"></i>
                        <span>Kelola Data Kecamatan</span>
                    </a>
                </li>

                <!-- 3. Kelola Data Kategori Usaha -->
                <li class="nav-item">
                    <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i>
                        <span>Kelola Kategori Usaha</span>
                    </a>
                </li>

                <!-- 4. Kelola Data UMKM -->
                <li class="nav-item">
                    <a href="{{ route('admin.umkm.index') }}" class="nav-link {{ request()->routeIs('admin.umkm.*') ? 'active' : '' }}">
                        <i class="bi bi-shop"></i>
                        <span>Kelola Data UMKM</span>
                    </a>
                </li>

                <!-- 5. Kelola Data Produk -->
                <li class="nav-item">
                    <a href="{{ route('admin.produk.index') }}" class="nav-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i>
                        <span>Kelola Data Produk</span>
                    </a>
                </li>

                <li class="sidebar-heading mt-2">Akun</li>

                <!-- Logout -->
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link text-danger" onclick="document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>

            <!-- User Info Card at Sidebar Bottom -->
            <div class="sidebar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="user-info">
                    <div class="user-name" title="{{ Auth::user()->name ?? 'Administrator' }}">
                        {{ Auth::user()->name ?? 'Administrator' }}
                    </div>
                    <div class="user-role">
                        <i class="bi bi-patch-check-fill me-1"></i>Administrator
                    </div>
                </div>
            </div>
        </aside>

        <!-- PAGE CONTENT WRAPPER -->
        <div id="page-content-wrapper">
            <!-- TOP NAVBAR -->
            <nav class="top-navbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn-toggle-sidebar" id="sidebar-toggle" title="Toggle Sidebar">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">@yield('page-title', 'Admin Panel')</h5>
                        <small class="text-muted d-none d-sm-inline">Sistem Informasi Geografis UMKM Tembakau</small>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <!-- Date badge -->
                    <div class="d-none d-md-flex align-items-center gap-2 bg-light px-3 py-1.5 rounded-pill text-muted small">
                        <i class="bi bi-calendar3 text-success"></i>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>

                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-light d-flex align-items-center gap-2 border-0 rounded-pill px-3 py-1.5 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-weight: 600; font-size: 0.85rem;">
                                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            </div>
                            <span class="fw-semibold small d-none d-sm-inline">{{ Auth::user()->name ?? 'Admin' }}</span>
                            <i class="bi bi-chevron-down small text-muted"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3" style="min-width: 200px;">
                            <li class="px-3 py-2 border-bottom">
                                <div class="fw-bold small">{{ Auth::user()->name ?? 'Administrator' }}</div>
                                <div class="text-muted small text-truncate">{{ Auth::user()->email ?? 'admin@tembakau.com' }}</div>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 text-danger small d-flex align-items-center gap-2" href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> Keluar (Logout)
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- FLASH ALERTS -->
            <div class="content-body pb-0">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show border-0 shadow-sm rounded-3 d-flex align-items-center gap-2" role="alert">
                        <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                        <div>{{ session('info') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(isset($errors) && $errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                        <div class="fw-bold mb-1 d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-circle-fill"></i> Terdapat beberapa kesalahan input:
                        </div>
                        <ul class="mb-0 ps-3 small">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            <!-- MAIN CONTENT BODY -->
            <main class="content-body">
                @yield('content')
            </main>

            <!-- FOOTER -->
            <footer class="footer d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <div>
                    &copy; {{ date('Y') }} <strong>TembakauGIS Pamekasan</strong>. Hak Cipta Dilindungi.
                </div>
                <div class="text-muted small">
                    Sistem Informasi Geografis &bull; Versi 1.0.0
                </div>
            </footer>
        </div>
    </div>

    <!-- Hidden Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <!-- Bootstrap 5.3 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Responsive Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar-wrapper');
            const overlay = document.getElementById('sidebar-overlay');
            const toggleBtn = document.getElementById('sidebar-toggle');
            const body = document.body;

            function isMobile() {
                return window.innerWidth < 992;
            }

            function toggleSidebar() {
                if (isMobile()) {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                } else {
                    body.classList.toggle('sidebar-collapsed');
                    const isCollapsed = body.classList.contains('sidebar-collapsed');
                    localStorage.setItem('sidebar_collapsed', isCollapsed ? '1' : '0');
                }
            }

            // Pulihkan status collapse di desktop dari localStorage
            if (!isMobile() && localStorage.getItem('sidebar_collapsed') === '1') {
                body.classList.add('sidebar-collapsed');
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    toggleSidebar();
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function () {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }

            // Tutup sidebar mobile saat resize ke desktop
            window.addEventListener('resize', function () {
                if (!isMobile()) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
