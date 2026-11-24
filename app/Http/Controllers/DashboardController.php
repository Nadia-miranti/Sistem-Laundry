<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    public function index() {
        // Data statistik umum
        $totalTransaksi       = Transaksi::count();
        $totalProses          = Transaksi::where('status', 'Proses')->count();
        $totalSelesai         = Transaksi::where('status', 'Selesai')->count();
        
        // HANYA menghitung transaksi yang berstatus 'Lunas'
        $totalPendapatan      = Transaksi::where('status_bayar', 'Lunas')->sum('total_harga');
        $totalBelumLunas      = Transaksi::where('status_bayar', 'Belum Lunas')->count();
        $totalLayanan         = Layanan::count();

        // 5 Transaksi terbaru untuk Admin
        $recentTransaksi      = Transaksi::with('layanan')->latest()->take(5)->get();

        // Data statistik fokus operasional harian untuk Kasir
        $transaksiHariIni     = Transaksi::whereDate('created_at', today())->count();
        $selesaiHariIni       = Transaksi::where('status', 'Selesai')->whereDate('updated_at', today())->count();

        // Antrean cucian aktif (status 'Proses') untuk operasional Kasir
        $antreanProses        = Transaksi::with('layanan')
            ->where('status', 'Proses')
            ->oldest()
            ->get();

        return view('dashboard', compact(
            'totalTransaksi',
            'totalProses',
            'totalSelesai',
            'totalPendapatan',
            'totalBelumLunas',
            'totalLayanan',
            'recentTransaksi',
            'transaksiHariIni',
            'selesaiHariIni',
            'antreanProses'
        ));
    }
}
