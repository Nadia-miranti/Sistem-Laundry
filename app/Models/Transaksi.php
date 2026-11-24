<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model {
    use HasFactory;
    protected $table = 'transaksis';
    protected $fillable = [
        'layanan_id',
        'nama_pelanggan',
        'no_hp',
        'berat',
        'total_harga',
        'status',
        'status_bayar'
    ];

    public function layanan() {
        return $this->belongsTo(Layanan::class);
    }
}
