@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<!-- Sapaan Pengguna & Banner Header -->
<div class="card mb-4">
    <div class="card-body card-header-accent py-3">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
            <div>
                <h5 class="fw-bold mb-1" style="color: var(--text-teal);">
                    Selamat Datang, {{ auth()->user()->name }}
                </h5>
                <p class="text-muted small mb-0">
                    @if(auth()->user()->role === 'admin')
                        Panel Manajemen Administrator &mdash; Pantau performa bisnis, data master layanan, dan omzet pembayaran lunas.
                    @else
                        Operasional Kasir Meja Depan &mdash; Melayani penerimaan pesanan cucian dan pembayaran pelanggan.
                    @endif
                </p>
            </div>
            <div>
                @if(auth()->user()->role === 'admin')
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 small fw-bold">
                        <i class="bi bi-shield-check me-1"></i>AKUN ADMINISTRATOR
                    </span>
                @else
                    <div class="d-flex gap-2">
                        <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1 shadow-sm">
                            <i class="bi bi-plus-circle"></i> Input Transaksi Baru
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ========================================================== --}}
{{-- TAMPILAN DASHBOARD ROLE ADMIN                              --}}
{{-- ========================================================== --}}
@if(auth()->user()->role === 'admin')
    <!-- 4 Kartu Statistik Lengkap Administrator -->
    <div class="row g-3 mb-4">
        <!-- 1) Total Semua Transaksi -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Total Transaksi</span>
                            <h3 class="fw-bold my-1 text-dark tabular-nums">{{ $totalTransaksi }}</h3>
                            <span class="text-muted small">Semua riwayat cucian</span>
                        </div>
                        <span class="p-2 rounded-3 border" style="background-color: var(--theme-ice); color: var(--nav-bg);">
                            <i class="bi bi-receipt fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2) Cucian Sedang Proses -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Sedang Proses</span>
                            <h3 class="fw-bold my-1 text-warning-emphasis tabular-nums">{{ $totalProses }}</h3>
                            <span class="text-muted small">Dalam pengerjaan</span>
                        </div>
                        <span class="p-2 bg-warning-subtle text-warning-emphasis rounded-3 border border-warning-subtle">
                            <i class="bi bi-hourglass-split fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3) Cucian Selesai -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Cucian Selesai</span>
                            <h3 class="fw-bold my-1 text-success tabular-nums">{{ $totalSelesai }}</h3>
                            <span class="text-muted small">Siap diserahkan</span>
                        </div>
                        <span class="p-2 bg-success-subtle text-success rounded-3 border border-success-subtle">
                            <i class="bi bi-check2-circle fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4) Total Pendapatan (HANYA DARI TRANSAKSI LUNAS) -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card h-100 border-start border-4" style="border-left-color: var(--theme-ice-dark) !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Total Pendapatan</span>
                            <h4 class="fw-bold my-1 tabular-nums text-truncate" style="color: var(--btn-primary);">
                                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </h4>
                            <span class="text-success small fw-semibold">
                                <i class="bi bi-shield-check me-1"></i>Hanya transaksi Lunas
                            </span>
                        </div>
                        <span class="p-2 rounded-3 border" style="background-color: var(--theme-ice); color: var(--nav-bg);">
                            <i class="bi bi-cash-stack fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel 5 Transaksi Terbaru untuk Admin -->
    <div class="card">
        <div class="card-header py-3">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                <h6 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-clock-history me-1" style="color: var(--btn-primary);"></i> 5 Transaksi Laundry Terbaru
                </h6>
                <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary btn-sm">
                    Lihat Seluruh Rekap <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="ps-3" style="width: 50px;">#</th>
                            <th>Pelanggan</th>
                            <th>Paket Layanan</th>
                            <th class="text-center text-nowrap">Berat</th>
                            <th class="text-end text-nowrap">Total Harga</th>
                            <th class="text-center text-nowrap">Status Cucian</th>
                            <th class="text-center text-nowrap">Status Bayar</th>
                            <th class="text-center text-nowrap">Tanggal</th>
                            <th class="text-center text-nowrap pe-3" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($recentTransaksi as $t)
                        <tr>
                            <td class="ps-3 text-muted tabular-nums">{{ $loop->iteration }}</td>
                            <td>
                                <span class="fw-semibold text-dark">{{ $t->nama_pelanggan }}</span>
                                <div class="text-muted font-monospace" style="font-size: 0.8rem;">
                                    <i class="bi bi-telephone me-1"></i>{{ $t->no_hp }}
                                </div>
                            </td>
                            <td>{{ $t->layanan->nama_layanan ?? '-' }}</td>
                            <td class="text-center text-nowrap tabular-nums">{{ $t->berat }} kg</td>
                            <td class="text-end text-nowrap tabular-nums fw-semibold text-dark">
                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="text-center text-nowrap">
                                @if($t->status === 'Selesai')
                                    <span class="badge badge-status-selesai px-2 py-1">
                                        <i class="bi bi-check-circle me-1"></i>Selesai
                                    </span>
                                @else
                                    <span class="badge badge-status-proses px-2 py-1">
                                        <i class="bi bi-hourglass me-1"></i>Proses
                                    </span>
                                @endif
                            </td>
                            <td class="text-center text-nowrap">
                                @if($t->status_bayar === 'Lunas')
                                    <span class="badge badge-bayar-lunas px-2 py-1">
                                        <i class="bi bi-check-circle-fill me-1"></i>Lunas
                                    </span>
                                @else
                                    <span class="badge badge-bayar-belum px-2 py-1">
                                        <i class="bi bi-exclamation-circle-fill me-1"></i>Belum Lunas
                                    </span>
                                @endif
                            </td>
                            <td class="text-center text-nowrap tabular-nums text-muted">
                                {{ $t->created_at->format('d/m/Y') }}
                            </td>
                            <td class="text-center text-nowrap pe-3">
                                @if($t->status === 'Proses')
                                    <form action="{{ route('transaksi.updateStatus', $t) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success d-inline-flex align-items-center gap-1 shadow-sm py-1 px-2" title="Tandai Selesai" onclick="return confirm('Tandai cucian pelanggan {{ $t->nama_pelanggan }} sudah Selesai?')">
                                            <i class="bi bi-check-lg"></i> Selesai
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-light text-secondary border py-1 px-2">
                                        <i class="bi bi-check2-all text-success me-1"></i>Selesai
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                Belum ada riwayat transaksi tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

{{-- ========================================================== --}}
{{-- TAMPILAN DASHBOARD ROLE KASIR                              --}}
{{-- ========================================================== --}}
@else
    <!-- 3 Kartu Fokus Kerja Operasional Kasir (Omzet Utama Disembunyikan) -->
    <div class="row g-3 mb-4">
        <!-- 1) Transaksi Masuk Hari Ini -->
        <div class="col-12 col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Pesanan Masuk Hari Ini</span>
                            <h3 class="fw-bold my-1 tabular-nums" style="color: var(--text-teal);">{{ $transaksiHariIni }}</h3>
                            <span class="text-muted small">Cucian baru diterima</span>
                        </div>
                        <span class="p-2 rounded-3 border" style="background-color: var(--theme-ice); color: var(--nav-bg);">
                            <i class="bi bi-inbox fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2) Cucian Sedang Proses (Antrean) -->
        <div class="col-12 col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Antrean Sedang Proses</span>
                            <h3 class="fw-bold my-1 text-warning-emphasis tabular-nums">{{ $totalProses }}</h3>
                            <span class="text-muted small">Dalam pengerjaan cucian</span>
                        </div>
                        <span class="p-2 bg-warning-subtle text-warning-emphasis rounded-3 border border-warning-subtle">
                            <i class="bi bi-hourglass-split fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3) Cucian Selesai Hari Ini -->
        <div class="col-12 col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="text-muted small fw-semibold text-uppercase">Diselesaikan Hari Ini</span>
                            <h3 class="fw-bold my-1 text-success tabular-nums">{{ $selesaiHariIni }}</h3>
                            <span class="text-muted small">Cucian siap diambil</span>
                        </div>
                        <span class="p-2 bg-success-subtle text-success rounded-3 border border-success-subtle">
                            <i class="bi bi-check2-circle fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Antrean Cucian yang Masih Berstatus 'Proses' (Kasir: Hanya Pantau & Lunasi Bayar, Tidak Bisa Menyelesaikan Orderan) -->
    <div class="card">
        <div class="card-header py-3">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                <div>
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-list-task me-1 text-warning-emphasis"></i> Antrean Cucian Sedang Proses
                    </h6>
                    <small class="text-muted">Daftar cucian pelanggan yang sedang diproses oleh operasional</small>
                </div>
                <a href="{{ route('transaksi.index', ['status' => 'Proses']) }}" class="btn btn-outline-secondary btn-sm">
                    Buka Halaman Transaksi <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary small">
                        <tr>
                            <th class="ps-3" style="width: 50px;">#</th>
                            <th>Pelanggan</th>
                            <th>Paket Layanan</th>
                            <th class="text-center text-nowrap">Berat</th>
                            <th class="text-center text-nowrap">Status Pembayaran</th>
                            <th class="text-center text-nowrap">Tanggal Masuk</th>
                            <th class="text-center text-nowrap pe-3" style="width: 170px;">Status / Aksi Kasir</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($antreanProses as $antrean)
                        <tr>
                            <td class="ps-3 text-muted tabular-nums">{{ $loop->iteration }}</td>
                            <td>
                                <span class="fw-semibold text-dark">{{ $antrean->nama_pelanggan }}</span>
                                <div class="text-muted font-monospace" style="font-size: 0.8rem;">
                                    <i class="bi bi-telephone me-1"></i>{{ $antrean->no_hp }}
                                </div>
                            </td>
                            <td>
                                <div>{{ $antrean->layanan->nama_layanan ?? '-' }}</div>
                                <small class="text-muted">Est: {{ $antrean->layanan->estimasi_waktu ?? '-' }}</small>
                            </td>
                            <td class="text-center text-nowrap tabular-nums">{{ $antrean->berat }} kg</td>
                            <td class="text-center text-nowrap">
                                @if($antrean->status_bayar === 'Lunas')
                                    <span class="badge badge-bayar-lunas px-2 py-1">
                                        <i class="bi bi-check-circle-fill me-1"></i>Lunas
                                    </span>
                                @else
                                    <span class="badge badge-bayar-belum px-2 py-1">
                                        <i class="bi bi-exclamation-circle-fill me-1"></i>Belum Lunas
                                    </span>
                                @endif
                            </td>
                            <td class="text-center text-nowrap tabular-nums text-muted">
                                {{ $antrean->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="text-center text-nowrap pe-3">
                                {{-- Hak Kasir: Kasir TIDAK BISA menyelesaikan orderan, hanya bisa Lunasi Pembayaran jika Belum Lunas --}}
                                @if($antrean->status_bayar === 'Belum Lunas')
                                    <form action="{{ route('transaksi.updateStatusBayar', $antrean) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1 shadow-sm py-1 px-2" title="Tandai Pembayaran LUNAS" onclick="return confirm('Ubah status pembayaran pelanggan {{ $antrean->nama_pelanggan }} menjadi LUNAS?')">
                                            <i class="bi bi-cash-stack"></i> Lunasi
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-light text-muted border px-2 py-1" title="Menunggu pengerjaan selesai oleh Admin/Produksi">
                                        <i class="bi bi-hourglass me-1 text-warning-emphasis"></i>Dalam Proses
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-check-circle text-success fs-3 d-block mb-1"></i>
                                Hebat! Tidak ada antrean cucian yang sedang diproses. Semua pesanan telah selesai.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
@endsection
