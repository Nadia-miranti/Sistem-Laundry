<?php
namespace App\Http\Controllers;
use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller {
    public function index() {
        $layanans = Layanan::latest()->paginate(10);
        return view('layanan.index', compact('layanans'));
    }
    public function create() {
        return view('layanan.create');
    }
    public function store(Request $request) {
        $request->validate([
            'nama_layanan'   => 'required|string|max:100',
            'harga_per_kg'   => 'required|integer|min:1',
            'estimasi_waktu' => 'required|string|max:50',
        ]);
        Layanan::create($request->only('nama_layanan','harga_per_kg','estimasi_waktu'));
        return redirect()->route('layanan.index')->with('success','Layanan berhasil ditambahkan.');
    }
    public function edit(Layanan $layanan) {
        return view('layanan.edit', compact('layanan'));
    }
    public function update(Request $request, Layanan $layanan) {
        $request->validate([
            'nama_layanan'   => 'required|string|max:100',
            'harga_per_kg'   => 'required|integer|min:1',
            'estimasi_waktu' => 'required|string|max:50',
        ]);
        $layanan->update($request->only('nama_layanan','harga_per_kg','estimasi_waktu'));
        return redirect()->route('layanan.index')->with('success','Layanan berhasil diperbarui.');
    }
    public function destroy(Layanan $layanan) {
        $layanan->delete();
        return redirect()->route('layanan.index')->with('success','Layanan berhasil dihapus.');
    }
}
