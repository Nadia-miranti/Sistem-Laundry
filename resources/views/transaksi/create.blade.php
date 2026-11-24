@extends('layouts.app')
@section('title', 'Transaksi Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
        <!-- Card Form Transaksi Baru -->
        <div class="card">
            <div class="card-header card-header-accent py-3">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary btn-sm" title="Kembali ke Rekap Transaksi">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Form Input Transaksi Laundry Baru</h6>
                        <small class="text-muted">Penerimaan order cucian pelanggan & penentuan status pembayaran</small>
                    </div>
                </div>
            </div>
            <div class="card-body p-3 p-md-4">
                <form action="{{ route('transaksi.store') }}" method="POST" id="transaksiForm">
                    @csrf
                    
                    <div class="row g-3">
                        <!-- Nama Pelanggan -->
                        <div class="col-12 col-md-6">
                            <label for="nama_pelanggan" class="form-label small fw-semibold text-secondary">
                                Nama Pelanggan <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control py-2 @error('nama_pelanggan') is-invalid @enderror" value="{{ old('nama_pelanggan') }}" placeholder="Contoh: Budi Santoso" required autofocus>
                            @error('nama_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- No. HP -->
                        <div class="col-12 col-md-6">
                            <label for="no_hp" class="form-label small fw-semibold text-secondary">
                                No. HP / WhatsApp <span class="text-danger">*</span>
                            </label>
                            <input type="tel" name="no_hp" id="no_hp" class="form-control py-2 font-monospace @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890" required>
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dropdown Jenis Layanan -->
                        <div class="col-12 col-md-6">
                            <label for="layanan_id" class="form-label small fw-semibold text-secondary">
                                Paket Layanan <span class="text-danger">*</span>
                            </label>
                            <select name="layanan_id" id="layanan_id" class="form-select py-2 @error('layanan_id') is-invalid @enderror" required>
                                <option value="">— Pilih Jenis Paket Layanan —</option>
                                @foreach($layanans as $layanan)
                                    <option value="{{ $layanan->id }}" 
                                            data-harga="{{ $layanan->harga_per_kg }}"
                                            {{ old('layanan_id') == $layanan->id ? 'selected' : '' }}>
                                        {{ $layanan->nama_layanan }} (Rp {{ number_format($layanan->harga_per_kg, 0, ',', '.') }}/kg) &mdash; {{ $layanan->estimasi_waktu }}
                                    </option>
                                @endforeach
                            </select>
                            @error('layanan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Berat Cucian (kg) -->
                        <div class="col-12 col-md-6">
                            <label for="berat" class="form-label small fw-semibold text-secondary">
                                Berat Cucian (kg) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" name="berat" id="berat" step="0.1" min="0.1" class="form-control py-2 tabular-nums @error('berat') is-invalid @enderror" value="{{ old('berat') }}" placeholder="Contoh: 2.5" required>
                                <span class="input-group-text bg-light text-muted">Kg</span>
                            </div>
                            @error('berat')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Pilihan Status Pembayaran Baru -->
                        <div class="col-12 col-md-6">
                            <label for="status_bayar" class="form-label small fw-semibold text-secondary">
                                Status Pembayaran <span class="text-danger">*</span>
                            </label>
                            <select name="status_bayar" id="status_bayar" class="form-select py-2 @error('status_bayar') is-invalid @enderror" required>
                                <option value="Belum Lunas" {{ old('status_bayar', 'Belum Lunas') === 'Belum Lunas' ? 'selected' : '' }}>
                                    Belum Lunas (Bayar Nanti Saat Ambil)
                                </option>
                                <option value="Lunas" {{ old('status_bayar') === 'Lunas' ? 'selected' : '' }}>
                                    Lunas (Sudah Dibayar di Muka)
                                </option>
                            </select>
                            @error('status_bayar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Info Status Pengerjaan Otomatis -->
                        <div class="col-12 col-md-6">
                            <label class="form-label small fw-semibold text-secondary">
                                Status Pengerjaan Awal
                            </label>
                            <input type="text" class="form-control py-2 bg-light text-muted" value="Proses (Otomatis Masuk Antrean)" disabled>
                            <small class="text-muted" style="font-size: 0.8rem;">Status cucian awal selalu disetel ke 'Proses'.</small>
                        </div>

                        <!-- Kotak Estimasi Total Biaya Otomatis -->
                        <div class="col-12">
                            <div class="p-3 rounded-3 border d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2" style="background-color: var(--theme-ice-light); border-color: var(--theme-ice) !important;">
                                <div>
                                    <span class="small fw-semibold d-block" style="color: var(--text-teal);">
                                        <i class="bi bi-calculator me-1"></i>Kalkulasi Estimasi Total Biaya:
                                    </span>
                                    <small class="text-muted">(Tarif Paket per Kg &times; Berat Cucian)</small>
                                </div>
                                <div class="text-sm-end">
                                    <span class="fs-4 fw-bold tabular-nums" id="previewTotal" style="color: var(--btn-primary);">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex flex-column flex-sm-row gap-2 mt-4">
                        <button type="submit" class="btn btn-primary py-2 d-inline-flex align-items-center justify-content-center gap-1 shadow-sm">
                            <i class="bi bi-save"></i> Simpan Transaksi
                        </button>
                        <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary py-2 d-inline-flex align-items-center justify-content-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function hitungTotal() {
    const sel = document.getElementById('layanan_id');
    const opt = sel.options[sel.selectedIndex];
    const harga = opt ? parseFloat(opt.dataset.harga || 0) : 0;
    const berat = parseFloat(document.getElementById('berat').value || 0);
    const total = harga * berat;
    
    document.getElementById('previewTotal').textContent = 
        'Rp ' + Math.round(total).toLocaleString('id-ID');
}

document.getElementById('layanan_id').addEventListener('change', hitungTotal);
document.getElementById('berat').addEventListener('input', hitungTotal);

// Inisialisasi saat pertama kali halaman dimuat (misal jika ada old input)
document.addEventListener('DOMContentLoaded', hitungTotal);
</script>
@endpush
