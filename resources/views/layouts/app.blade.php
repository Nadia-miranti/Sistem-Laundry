<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sistem Laundry') — Sistem Informasi Manajemen Laundry</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --nav-bg: #0C3E4A;            /* Deep Cyan-Navy: harmonis dengan #B9E4E8 */
            --nav-bg-dark: #082F38;       /* Shaded Cyan-Navy */
            --theme-ice: #B9E4E8;         /* Soft Ice Cyan */
            --theme-ice-dark: #76C7CE;    /* Ice Cyan Border/Hover */
            --theme-ice-light: #F0F9FA;   /* Soft Cyan Tint */
            --text-dark: #0F172A;         /* Slate Dark */
            --text-teal: #134E4A;         /* Deep Teal */
            --btn-primary: #0F766E;       /* Teal Primary */
            --btn-primary-hover: #115E59;
            --app-bg: #F8FAFC;
            --card-border: #E2E8F0;
        }

        body {
            background-color: var(--app-bg);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
        }

        /* Top Navbar Selaras Warna Biru/Cyan */
        .navbar-custom {
            background: linear-gradient(180deg, var(--nav-bg) 0%, var(--nav-bg-dark) 100%);
            border-bottom: 2px solid var(--theme-ice-dark);
            box-shadow: 0 4px 12px rgba(12, 62, 74, 0.15);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.01em;
            font-size: 1.05rem;
            color: #FFFFFF !important;
        }

        .brand-badge {
            background-color: var(--theme-ice);
            color: var(--nav-bg);
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            font-size: 1.15rem;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Nav links dengan tema Cyan-Navy */
        .nav-link {
            font-size: 0.88rem;
            font-weight: 500;
            color: #CFFAFE !important;
            padding: 0.45rem 0.95rem !important;
            border-radius: 8px;
            transition: all 0.15s ease-in-out;
            display: inline-flex;
            align-items: center;
        }

        .nav-link:hover {
            color: #FFFFFF !important;
            background-color: rgba(185, 228, 232, 0.15);
        }

        .nav-link.active {
            background-color: var(--theme-ice) !important;
            color: var(--nav-bg) !important;
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
        }

        /* User Capsule di Kanan Navbar */
        .user-capsule {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(185, 228, 232, 0.25);
            border-radius: 50px;
            padding: 4px 6px 4px 12px;
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.12);
            color: #E2F5F7;
            border: 1px solid rgba(185, 228, 232, 0.3);
            border-radius: 50px;
            padding: 4px 12px;
            font-size: 0.8rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background: #DC2626;
            border-color: #DC2626;
            color: #FFFFFF;
        }

        @media (max-width: 991.98px) {
            .user-capsule {
                border-radius: 12px;
                padding: 10px 14px;
                flex-direction: column;
                align-items: flex-start !important;
                gap: 8px !important;
                width: 100%;
                margin-top: 8px;
            }
            .btn-logout {
                width: 100%;
                justify-content: center;
                padding: 6px 12px;
            }
        }

        /* Card Konten Bersih & Elegan */
        .card {
            background: #FFFFFF;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        .card-header {
            background: #FFFFFF;
            border-bottom: 1px solid var(--card-border);
        }

        .card-header-accent {
            background: linear-gradient(to right, rgba(185, 228, 232, 0.4), rgba(240, 249, 250, 0.6));
            border-bottom: 1px solid rgba(118, 199, 206, 0.4);
        }

        /* Tombol Aksi Utama Tegas */
        .btn-primary {
            background-color: var(--btn-primary);
            border-color: var(--btn-primary);
            color: #FFFFFF;
            font-weight: 500;
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--btn-primary-hover);
            border-color: var(--btn-primary-hover);
            color: #FFFFFF;
        }

        .btn-ice {
            background-color: var(--theme-ice);
            border-color: var(--theme-ice-dark);
            color: var(--text-teal);
            font-weight: 600;
        }

        .btn-ice:hover {
            background-color: var(--theme-ice-dark);
            color: var(--text-dark);
        }

        /* Format Angka Monospace/Tabular */
        .tabular-nums {
            font-variant-numeric: tabular-nums;
            letter-spacing: -0.01em;
        }

        /* Status Pengerjaan Badges */
        .badge-status-proses {
            background-color: #FEF9C3 !important;
            color: #854D0E !important;
            border: 1px solid #FEF08A !important;
            font-weight: 600;
        }

        .badge-status-selesai {
            background-color: #DCFCE7 !important;
            color: #166534 !important;
            border: 1px solid #BBF7D0 !important;
            font-weight: 600;
        }

        /* Status Pembayaran Badges (Lunas & Belum Lunas) */
        .badge-bayar-lunas {
            background-color: #DCFCE7 !important;
            color: #166534 !important;
            border: 1px solid #86EFAC !important;
            font-weight: 600;
        }

        .badge-bayar-belum {
            background-color: #FEE2E2 !important;
            color: #991B1B !important;
            border: 1px solid #FCA5A5 !important;
            font-weight: 600;
        }

        /* Mode Cetak Bersih */
        @media print {
            .d-print-none {
                display: none !important;
            }
            body {
                background-color: #FFFFFF !important;
                color: #000000 !important;
            }
            .card {
                border: 1px solid #CBD5E1 !important;
                box-shadow: none !important;
                border-radius: 0 !important;
            }
            .container {
                max-width: 100% !important;
                padding: 0 !important;
            }
            .table {
                width: 100% !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Top Navbar Responsif Selaras Warna Biru/Cyan -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-2 shadow-sm d-print-none">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                <span class="brand-badge">
                    <i class="bi bi-droplet-half"></i>
                </span>
                <span>Sistem Laundry</span>
            </a>

            <!-- Hamburger Button untuk Layar HP -->
            <button class="navbar-toggler border-0 shadow-none px-2 py-1" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Navbar -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 mt-2 mt-lg-0 gap-1 ps-lg-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('layanan.*') ? 'active' : '' }}" href="{{ route('layanan.index') }}">
                            <i class="bi bi-tags me-1"></i> Data Layanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}" href="{{ route('transaksi.index') }}">
                            <i class="bi bi-receipt-cutoff me-1"></i> Transaksi & Rekap
                        </a>
                    </li>
                </ul>

                <hr class="d-lg-none text-secondary my-2">

                <!-- Info User & Tombol Logout (Kapsul Rapi) -->
                <div class="user-capsule d-flex align-items-center gap-2">
                    <!-- Pill Badge Indikator Role Aktif -->
                    @if(auth()->user()->role === 'admin')
                        <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 small fw-bold">
                            <i class="bi bi-shield-check me-1"></i>ADMIN
                        </span>
                    @else
                        <span class="badge rounded-pill px-2 py-1 small fw-bold" style="background-color: var(--theme-ice); color: var(--nav-bg); border: 1px solid var(--theme-ice-dark);">
                            <i class="bi bi-person-badge me-1"></i>KASIR
                        </span>
                    @endif

                    <span class="text-white small fw-medium text-truncate me-1" style="max-width: 140px;" title="{{ auth()->user()->name }}">
                        {{ auth()->user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-logout d-flex align-items-center gap-1" title="Logout" onclick="return confirm('Keluar dari aplikasi?')">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Utama Halaman -->
    <main class="container py-3 py-md-4 flex-grow-1">
        <!-- Notifikasi Flash Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-print-none shadow-sm py-2 px-3 small d-flex align-items-center gap-2 mb-3 rounded-3" role="alert">
                <i class="bi bi-check-circle-fill text-success fs-6"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show d-print-none shadow-sm py-2 px-3 small d-flex align-items-center gap-2 mb-3 rounded-3" role="alert">
                <i class="bi bi-info-circle-fill text-info fs-6"></i>
                <div class="flex-grow-1">{{ session('info') }}</div>
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-print-none shadow-sm py-2 px-3 small d-flex align-items-center gap-2 mb-3 rounded-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill text-danger fs-6"></i>
                <div class="flex-grow-1">{{ session('error') }}</div>
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer Standar Sederhana -->
    <footer class="bg-white border-top py-3 text-center text-muted small d-print-none mt-auto">
        <div class="container">
            <span>&copy; {{ date('Y') }} <strong>Sistem Informasi Manajemen Laundry</strong> &bull; Proyek Siswa RPL</span>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
