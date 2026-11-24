@extends('layouts.app')
@section('title', 'Tambah Layanan')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <!-- Card Form Tambah Layanan -->
        <div class="card">
            <div class="card-header card-header-accent py-3">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('layanan.index') }}" class="btn btn-outline-secondary btn-sm" title="Kembali ke Daftar Layanan">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">Tambah Paket Layanan Baru</h6>
                        <small class="text-muted">Master data paket laundry</small>
                    </div>
                </div>
            </div>
            <div class="card-body p-3 p-md-4">
                <form action="{{ route('layanan.store') }}" method="POST">
                    @csrf
                    
                    <!-- Nama Layanan -->
                    <div class="mb-3">
                        <label for="nama_layanan" class="form-label small fw-semibold text-secondary">
                            Nama Layanan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_layanan" id="nama_layanan" class="form-control py-2 @error('nama_layanan') is-invalid @enderror" value="{{ old('nama_layanan') }}" placeholder="Contoh: Cuci Kering Setrika, Bed Cover" required autofocus>
                        @error('nama_layanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Harga per Kg -->
                    <div class="mb-3">
                        <label for="harga_per_kg" class="form-label small fw-semibold text-secondary">
                            Tarif Harga per Kg (Rp) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted">Rp</span>
                            <input type="number" name="harga_per_kg" id="harga_per_kg" class="form-control py-2 tabular-nums @error('harga_per_kg') is-invalid @enderror" value="{{ old('harga_per_kg') }}" placeholder="Contoh: 7000" min="1" required>
                        </div>
                        @error('harga_per_kg')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estimasi Waktu -->
                    <div class="mb-4">
                        <label for="estimasi_waktu" class="form-label small fw-semibold text-secondary">
                            Estimasi Waktu Pengerjaan <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="estimasi_waktu" id="estimasi_waktu" class="form-control py-2 @error('estimasi_waktu') is-invalid @enderror" value="{{ old('estimasi_waktu') }}" placeholder="Contoh: 2-3 hari, 1 hari, 5 jam" required>
                        @error('estimasi_waktu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex flex-column flex-sm-row gap-2">
                        <button type="submit" class="btn btn-primary py-2 d-inline-flex align-items-center justify-content-center gap-1 shadow-sm">
                            <i class="bi bi-save"></i> Simpan Paket Layanan
                        </button>
                        <a href="{{ route('layanan.index') }}" class="btn btn-outline-secondary py-2 d-inline-flex align-items-center justify-content-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
