<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Kasir — Sistem Informasi Manajemen Laundry</title>

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
            --text-teal: #134E4A;
            --btn-primary: #0F766E;
            --btn-primary-hover: #115E59;
        }

        body {
            background: linear-gradient(135deg, #F0F9FA 0%, #E0F4F6 50%, #F8FAFC 100%);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .auth-card {
            background: #FFFFFF;
            border: 1px solid #CBD5E1;
            border-top: 5px solid var(--theme-ice-dark);
            border-radius: 14px;
            box-shadow: 0 10px 25px -5px rgba(15, 118, 110, 0.08), 0 8px 10px -6px rgba(15, 118, 110, 0.04);
        }

        .brand-badge {
            background-color: var(--theme-ice);
            color: var(--text-teal);
            width: 52px;
            height: 52px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            border: 1px solid var(--theme-ice-dark);
        }

        .btn-primary {
            background-color: var(--btn-primary);
            border-color: var(--btn-primary);
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: var(--btn-primary-hover);
            border-color: var(--btn-primary-hover);
        }

        .form-control:focus {
            border-color: var(--theme-ice-dark);
            box-shadow: 0 0 0 0.25rem rgba(185, 228, 232, 0.5);
        }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-11 col-sm-8 col-md-5 col-lg-4 mx-auto my-3">
            
            <!-- Card Register -->
            <div class="auth-card p-4">
                <!-- Header Brand -->
                <div class="text-center mb-3">
                    <div class="brand-badge mb-2 shadow-sm">
                        <i class="bi bi-person-plus fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-1" style="color: var(--text-teal);">Daftar Akun Kasir</h5>
                    <p class="text-muted small mb-0">Registrasi akun petugas operasional laundry</p>
                    <div class="mt-2">
                        <span class="badge rounded-pill px-3 py-1 small fw-semibold" style="background-color: var(--theme-ice); color: var(--text-teal); border: 1px solid var(--theme-ice-dark);">
                            <i class="bi bi-shield-check me-1"></i>Role: Kasir Operasional
                        </span>
                    </div>
                </div>

                <!-- Notifikasi Error Validasi -->
                @if($errors->any())
                    <div class="alert alert-danger py-2 px-3 small d-flex align-items-center gap-2 mb-3 rounded-2" role="alert">
                        <i class="bi bi-exclamation-circle-fill text-danger flex-shrink-0"></i>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    
                    <!-- Input Nama Lengkap -->
                    <div class="mb-3">
                        <label for="name" class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" name="name" id="name" class="form-control border-start-0 py-2 @error('name') is-invalid @enderror" placeholder="Contoh: Rina Melati" value="{{ old('name') }}" required autofocus>
                        </div>
                    </div>

                    <!-- Input Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label small fw-semibold text-secondary">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" name="email" id="email" class="form-control border-start-0 py-2 @error('email') is-invalid @enderror" placeholder="kasir.baru@laundry.com" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <!-- Input Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label small fw-semibold text-secondary">Password (Min. 6 Karakter)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" name="password" id="password" class="form-control border-start-0 py-2 @error('password') is-invalid @enderror" placeholder="••••••••" required>
                        </div>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label small fw-semibold text-secondary">Ulangi Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted border-end-0">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control border-start-0 py-2" placeholder="••••••••" required>
                        </div>
                    </div>

                    <!-- Tombol Register -->
                    <button type="submit" class="btn btn-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2 shadow-sm">
                        <i class="bi bi-check-circle"></i>
                        <span>Daftar Sekarang</span>
                    </button>
                </form>

                <!-- Link Kembali ke Login -->
                <div class="text-center mt-3 pt-3 border-top">
                    <span class="small text-muted">Sudah memiliki akun?</span>
                    <a href="{{ route('login') }}" class="small fw-semibold d-block mt-1 text-decoration-none" style="color: var(--btn-primary);">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Masuk ke Akun Anda
                    </a>
                </div>
            </div>

            <!-- Copyright -->
            <p class="text-center text-muted small mt-3 mb-0">
                &copy; {{ date('Y') }} Sistem Informasi Manajemen Laundry
            </p>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3 JS Bundle CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
