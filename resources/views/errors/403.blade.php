<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — Akses Ditolak</title>

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
            --theme-ice: #B9E4E8;
            --theme-ice-dark: #76C7CE;
            --text-dark: #0F172A;
            --btn-primary: #0F766E;
            --btn-primary-hover: #115E59;
        }

        body {
            background-color: #F8FAFC;
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .error-card {
            background: #FFFFFF;
            border: 1px solid #CBD5E1;
            border-top: 5px solid #EF4444;
            border-radius: 14px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background-color: var(--btn-primary);
            border-color: var(--btn-primary);
        }

        .btn-primary:hover {
            background-color: var(--btn-primary-hover);
            border-color: var(--btn-primary-hover);
        }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-11 col-sm-8 col-md-6 col-lg-5 mx-auto text-center">
            <div class="error-card p-4 p-md-5">
                <div class="text-danger mb-3">
                    <span class="d-inline-flex p-3 rounded-circle bg-danger-subtle text-danger border border-danger-subtle">
                        <i class="bi bi-shield-lock-fill fs-2"></i>
                    </span>
                </div>
                <h2 class="fw-bold text-dark mb-1">403 Forbidden</h2>
                <h6 class="text-danger fw-semibold mb-2">Hak Akses Dibatasi</h6>
                <p class="text-muted small mb-4">
                    {{ $exception->getMessage() ?: 'Akses ditolak: Anda tidak memiliki izin atau hak akses untuk membuka halaman ini.' }}
                </p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary d-inline-flex align-items-center gap-1 shadow-sm">
                        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
            <p class="text-muted small mt-3 mb-0">
                &copy; {{ date('Y') }} Sistem Informasi Manajemen Laundry
            </p>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3 JS Bundle CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
