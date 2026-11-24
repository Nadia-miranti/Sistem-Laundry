@extends('layouts.app')
@section('title', 'Rekap Transaksi')

@section('content')
<!-- Header Dokumen Cetak (Hanya Tampil Saat Dicetak / window.print) -->
<div class="d-none d-print-block mb-3 text-center border-bottom pb-2">
    <h4 class="fw-bold mb-0 text-uppercase">Sistem Informasi Manajemen Laundry</h4>
    <h5 class="fw-semibold text-secondary mb-1">Laporan Rekapitulasi Transaksi & Status Pembayaran</h5>
    <div class="small text-muted">
        <span>Tanggal Cetak: {{ date('d/m/Y H:i') }}</span> &bull; 
        <span>Petugas Cetak: {{ auth()->user()->name }} ({{ strtoupper(auth()->user()->role) }})</span>
    </div>
</div>

<!-- Header Halaman Responsif & Tombol Aksi -->
<div class="card mb-3 d-print-none">
    <div class="card-body card-header-accent py-3">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
            <div>
                <h5 class="fw-bold mb-1" style="color: var(--text-teal);">
                    <i class="bi bi-receipt-cutoff me-1"></i> Rekap Transaksi Laundry
                </h5>
                <p class="text-muted small mb-0">
                    Kelola catatan pesanan cucian, pantau pengerjaan, dan verifikasi status pelunasan pembayaran.
                </p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <!-- Tombol Cetak Laporan -->
                <button type="button" onclick="window.print()" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1 shadow-sm bg-white">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </button>
                <!-- Tombol Transaksi Baru -->
                <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1 shadow-sm">
                    <i class="bi bi-plus-circle"></i> Input Transaksi Baru
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filter Status & Pencarian Nama Pelanggan (d-print-none) -->
<div class="card mb-3 d-print-none">
    <div class="card-body py-2 px-3">
        <form action="{{ route('transaksi.index') }}" method="GET" class="row g-2 align-items-center">
            <!-- Filter Status Pengerjaan -->
            <div class="col-12 col-md-auto d-flex flex-wrap gap-1 align-items-center">
                <span class="small fw-semibold text-muted me-1"><i class="bi bi-funnel"></i> Pengerjaan:</span>
                <a href="{{ route('transaksi.index', array_merge(request()->except(['status', 'page']), [])) }}" 
                   class="btn btn-sm {{ !request('status') ? 'btn-dark' : 'btn-outline-secondary' }} px-2 py-1">
                    Semua
                </a>
                <a href="{{ route('transaksi.index', array_merge(request()->except('page'), ['status' => 'Proses'])) }}" 
                   class="btn btn-sm {{ request('status') === 'Proses' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' }} px-2 py-1">
                    <i class="bi bi-hourglass me-1"></i>Proses
                </a>
                <a href="{{ route('transaksi.index', array_merge(request()->except('page'), ['status' => 'Selesai'])) }}" 
                   class="btn btn-sm {{ request('status') === 'Selesai' ? 'btn-success' : 'btn-outline-success' }} px-2 py-1">
                    <i class="bi bi-check-circle me-1"></i>Selesai
                </a>
            </div>

            <!-- Filter Status Pembayaran -->
            <div class="col-12 col-md-auto d-flex flex-wrap gap-1 align-items-center border-start-md ps-md-3">
                <span class="small fw-semibold text-muted me-1"><i class="bi bi-cash"></i> Bayar:</span>
                <a href="{{ route('transaksi.index', array_merge(request()->except('page'), ['status_bayar' => 'Lunas'])) }}" 
                   class="btn btn-sm {{ request('status_bayar') === 'Lunas' ? 'btn-success' : 'btn-outline-success' }} px-2 py-1">
                    <i class="bi bi-check-circle-fill me-1"></i>Lunas
                </a>
                <a href="{{ route('transaksi.index', array_merge(request()->except('page'), ['status_bayar' => 'Belum Lunas'])) }}" 
                   class="btn btn-sm {{ request('status_bayar') === 'Belum Lunas' ? 'btn-danger' : 'btn-outline-danger' }} px-2 py-1">
                    <i class="bi bi-exclamation-circle-fill me-1"></i>Belum Lunas
                </a>
            </div>

            <!-- Form Pencarian Nama Pelanggan -->
            <div class="col-12 col-md-auto ms-md-auto">
                <div class="input-group input-group-sm">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    @if(request('status_bayar'))
                        <input type="hidden" name="status_bayar" value="{{ request('status_bayar') }}">
                    @endif
                    <input type="text" name="search" class="form-control" placeholder="Cari nama pelanggan..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit" title="Cari">
                        <i class="bi bi-search"></i>
                    </button>
                    @if(request('search') || request('status') || request('status_bayar'))
                        <a href="{{ route('transaksi.index') }}" class="btn btn-outline-danger" title="Reset Filter">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Card Tabel Transaksi -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small">
                    <tr>
                        <th class="ps-3 text-center text-nowrap" style="width: 50px;">#</th>
                        <th>Nama Pelanggan</th>
                        <th>Paket Layanan</th>
                        <th class="text-center text-nowrap">Berat</th>
                        <th class="text-end text-nowrap">Total Biaya</th>
                        <th class="text-center text-nowrap">Status Cucian</th>
                        <th class="text-center text-nowrap">Status Bayar</th>
                        <th class="text-center text-nowrap">Tanggal Masuk</th>
                        <th class="text-center text-nowrap pe-3 d-print-none" style="width: 170px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @forelse($transaksis as $t)
                    <tr>
                        <td class="ps-3 text-center text-muted tabular-nums">{{ $transaksis->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $t->nama_pelanggan }}</div>
                            <div class="text-muted font-monospace" style="font-size: 0.8rem;">
                                <i class="bi bi-telephone me-1"></i>{{ $t->no_hp }}
                            </div>
                        </td>
                        <td>
                            <div>{{ $t->layanan->nama_layanan ?? '-' }}</div>
                            <small class="text-muted tabular-nums">@ Rp {{ number_format($t->layanan->harga_per_kg ?? 0, 0, ',', '.') }}/kg</small>
                        </td>
                        <td class="text-center text-nowrap tabular-nums">{{ $t->berat }} kg</td>
                        <td class="text-end text-nowrap tabular-nums fw-semibold text-dark">
                            Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                        </td>
                        <!-- Status Pengerjaan Cucian -->
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
                        <!-- Status Pembayaran -->
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
                            {{ $t->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="text-center text-nowrap pe-3 d-print-none">
                            <div class="d-inline-flex align-items-center gap-1">
                                {{-- Tombol Cepat Lunasi Pembayaran jika Belum Lunas (Kasir & Admin) --}}
                                @if($t->status_bayar === 'Belum Lunas')
                                    <form action="{{ route('transaksi.updateStatusBayar', $t) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1 shadow-sm" title="Lunasi Pembayaran Sekarang" onclick="return confirm('Ubah status pembayaran transaksi {{ $t->nama_pelanggan }} menjadi LUNAS?')">
                                            <i class="bi bi-cash-stack"></i> Lunasi
                                        </button>
                                    </form>
                                @endif

                                {{-- AKSI KHUSUS ADMIN: Hanya Admin yang berhak menyelesaikan orderan & menghapus --}}
                                @if(auth()->user()->role === 'admin')
                                    @if($t->status === 'Proses')
                                        <form action="{{ route('transaksi.updateStatus', $t) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success d-inline-flex align-items-center gap-1 shadow-sm" title="Tandai Cucian Selesai" onclick="return confirm('Tandai cucian pelanggan {{ $t->nama_pelanggan }} sudah Selesai?')">
                                                <i class="bi bi-check-lg"></i> Selesai
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge bg-light text-secondary border py-1 px-2" title="Cucian sudah selesai">
                                            <i class="bi bi-check2-all text-success me-1"></i>Selesai
                                        </span>
                                    @endif

                                    <form action="{{ route('transaksi.destroy', $t) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data transaksi ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Transaksi">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    {{-- AKSI UNTUK KASIR: KASIR TIDAK BISA MENYELESAIKAN ORDERAN --}}
                                    @if($t->status === 'Selesai')
                                        <span class="badge bg-light text-secondary border py-1 px-2">
                                            <i class="bi bi-check2-all text-success me-1"></i>Selesai
                                        </span>
                                    @elseif($t->status_bayar === 'Lunas')
                                        <span class="badge bg-light text-muted border py-1 px-2" title="Orderan dalam proses pengerjaan (Hanya Admin yang dapat menyelesaikan)">
                                            <i class="bi bi-hourglass me-1 text-warning-emphasis"></i>Dalam Proses
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3 d-block mb-1 text-secondary"></i>
                            Tidak ada data transaksi yang sesuai kriteria pencarian/filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Ringkasan Total Pendapatan Khusus Admin (Hanya Transaksi LUNAS) -->
    @if(auth()->user()->role === 'admin')
    <div class="card-footer bg-light border-top py-2 px-3">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-1 small">
            <div>
                <span class="fw-semibold text-dark"><i class="bi bi-cash-stack text-success me-1"></i>Ringkasan Keuangan Lunas:</span>
                <span class="text-muted">Total penerimaan dari transaksi yang berstatus Lunas.</span>
            </div>
            <div class="fs-6 fw-bold tabular-nums" style="color: var(--btn-primary);">
                Total Omzet Lunas: Rp {{ number_format($totalPendapatanLunas, 0, ',', '.') }}
            </div>
        </div>
    </div>
    @endif

    <!-- Pagination -->
    @if($transaksis->hasPages())
    <div class="card-footer bg-white border-top py-2 px-3 d-print-none">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
            <small class="text-muted">
                Menampilkan {{ $transaksis->firstItem() }} sampai {{ $transaksis->lastItem() }} dari total {{ $transaksis->total() }} transaksi
            </small>
            <div>
                {{ $transaksis->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
