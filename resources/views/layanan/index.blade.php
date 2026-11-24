@extends('layouts.app')
@section('title', 'Data Layanan')

@section('content')
<!-- Header Halaman Responsif -->
<div class="card mb-3">
    <div class="card-body card-header-accent py-3">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
            <div>
                <h5 class="fw-bold mb-1" style="color: var(--text-teal);">
                    <i class="bi bi-tags me-1"></i> Data Paket Layanan Laundry
                </h5>
                <p class="text-muted small mb-0">
                    @if(auth()->user()->role === 'admin')
                        Kelola master tarif layanan, paket cuci, dan estimasi waktu pengerjaan.
                    @else
                        Daftar paket layanan dan tarif per kilogram sebagai acuan penerimaan cucian pelanggan.
                    @endif
                </p>
            </div>
            
            <!-- Tombol Tambah Layanan Khusus Admin -->
            @if(auth()->user()->role === 'admin')
            <div>
                <a href="{{ route('layanan.create') }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1 shadow-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Layanan
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Card Tabel Layanan -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-secondary small">
                    <tr>
                        <th class="ps-3 text-center" style="width: 50px;">#</th>
                        <th>Nama Layanan</th>
                        <th class="text-end text-nowrap">Harga / Kg</th>
                        <th class="text-center text-nowrap">Estimasi Waktu</th>
                        @if(auth()->user()->role === 'admin')
                        <th class="text-center text-nowrap pe-3" style="width: 150px;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="small">
                    @forelse($layanans as $layanan)
                    <tr>
                        <td class="ps-3 text-center text-muted tabular-nums">{{ $layanans->firstItem() + $loop->index }}</td>
                        <td>
                            <span class="fw-semibold text-dark">{{ $layanan->nama_layanan }}</span>
                        </td>
                        <td class="text-end text-nowrap tabular-nums fw-semibold text-dark">
                            Rp {{ number_format($layanan->harga_per_kg, 0, ',', '.') }}
                        </td>
                        <td class="text-center text-nowrap">
                            <span class="badge px-2 py-1" style="background-color: var(--theme-ice-light); color: var(--text-teal); border: 1px solid var(--theme-ice);">
                                <i class="bi bi-clock me-1"></i>{{ $layanan->estimasi_waktu }}
                            </span>
                        </td>

                        {{-- Kolom Aksi Khusus Admin --}}
                        @if(auth()->user()->role === 'admin')
                        <td class="text-center text-nowrap pe-3">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('layanan.edit', $layanan) }}" class="btn btn-outline-secondary" title="Edit Layanan">
                                    <i class="bi bi-pencil-square text-warning-emphasis"></i> Edit
                                </a>
                                <form action="{{ route('layanan.destroy', $layanan) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini? Semua data riwayat transaksi terkait layanan ini akan ikut terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus Layanan">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}" class="text-center text-muted py-4">
                            Belum ada paket layanan laundry yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($layanans->hasPages())
    <div class="card-footer bg-white border-top py-2 px-3">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
            <small class="text-muted">
                Menampilkan {{ $layanans->firstItem() }} sampai {{ $layanans->lastItem() }} dari total {{ $layanans->total() }} layanan
            </small>
            <div>
                {{ $layanans->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
