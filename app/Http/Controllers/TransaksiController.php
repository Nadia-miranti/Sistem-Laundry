<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Layanan;
use Illuminate\Http\Request;

class TransaksiController extends Controller {
    public function index(Request $request) {
        $query = Transaksi::with('layanan')->latest();

        // Filter berdasarkan status pengerjaan cucian (Proses / Selesai)
        if ($request->filled('status') && in_array($request->status, ['Proses', 'Selesai'])) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan status pembayaran (Belum Lunas / Lunas)
        if ($request->filled('status_bayar') && in_array($request->status_bayar, ['Belum Lunas', 'Lunas'])) {
            $query->where('status_bayar', $request->status_bayar);
        }

        // Pencarian nama pelanggan
        if ($request->filled('search')) {
            $query->where('nama_pelanggan', 'like', '%' . trim($request->search) . '%');
        }

        $transaksis = $query->paginate(10)->withQueryString();

        // Total pendapatan HANYA dari transaksi yang berstatus 'Lunas'
        $totalPendapatanLunas = Transaksi::where('status_bayar', 'Lunas')->sum('total_harga');

        return view('transaksi.index', compact('transaksis', 'totalPendapatanLunas'));
    }

    public function create() {
        $layanans = Layanan::all();
        return view('transaksi.create', compact('layanans'));
    }

    public function store(Request $request) {
        $request->validate([
            'layanan_id'     => 'required|exists:layanans,id',
            'nama_pelanggan' => 'required|string|max:100',
            'no_hp'          => 'required|string|max:20',
            'berat'          => 'required|numeric|min:0.1',
            'status_bayar'   => 'required|in:Belum Lunas,Lunas',
        ], [
            'layanan_id.required'     => 'Pilih salah satu paket layanan.',
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
            'no_hp.required'          => 'Nomor HP/WhatsApp wajib diisi.',
            'berat.required'          => 'Berat cucian wajib diisi.',
            'berat.min'               => 'Berat cucian minimal 0.1 kg.',
            'status_bayar.required'   => 'Pilih status pembayaran.',
        ]);

        // Hitung ulang total harga di backend secara aman
        $layanan     = Layanan::findOrFail($request->layanan_id);
        $total_harga = (int) round($layanan->harga_per_kg * $request->berat);

        Transaksi::create([
            'layanan_id'     => $request->layanan_id,
            'nama_pelanggan' => $request->nama_pelanggan,
            'no_hp'          => $request->no_hp,
            'berat'          => $request->berat,
            'total_harga'    => $total_harga,
            'status'         => 'Proses', // Default status selalu Proses
            'status_bayar'   => $request->status_bayar,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi baru berhasil dicatat dengan status pengerjaan Proses.');
    }

    public function updateStatus(Request $request, Transaksi $transaksi) {
        // Hak kasir: Kasir TIDAK BISA menyelesaikan orderan, hanya Admin!
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak: Hanya Admin yang memiliki hak untuk menyelesaikan orderan cucian.');
        }

        if ($transaksi->status === 'Selesai') {
            return redirect()->route('transaksi.index')->with('info', 'Transaksi ini sudah berstatus Selesai.');
        }

        $transaksi->update(['status' => 'Selesai']);
        return redirect()->route('transaksi.index')->with('success', 'Status cucian pelanggan ' . $transaksi->nama_pelanggan . ' berhasil diubah menjadi Selesai.');
    }

    public function updateStatusBayar(Request $request, Transaksi $transaksi) {
        if ($transaksi->status_bayar === 'Lunas') {
            return redirect()->route('transaksi.index')->with('info', 'Pembayaran transaksi ini sudah berstatus Lunas.');
        }

        $transaksi->update(['status_bayar' => 'Lunas']);
        return redirect()->route('transaksi.index')->with('success', 'Pembayaran transaksi pelanggan ' . $transaksi->nama_pelanggan . ' berhasil diubah menjadi LUNAS.');
    }

    public function destroy(Transaksi $transaksi) {
        $nama = $transaksi->nama_pelanggan;
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Data transaksi pelanggan ' . $nama . ' berhasil dihapus.');
    }
}
