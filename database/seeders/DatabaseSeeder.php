<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Transaksi;

class DatabaseSeeder extends Seeder {
    public function run() {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Layanan::truncate();
        Transaksi::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Akun Default
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);
        User::create([
            'name'     => 'Kasir Operasional',
            'email'    => 'kasir@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'kasir',
        ]);

        // Layanan Default
        $l1 = Layanan::create(['nama_layanan' => 'Reguler',    'harga_per_kg' => 7000,  'estimasi_waktu' => '3-4 hari']);
        $l2 = Layanan::create(['nama_layanan' => 'Ekspres',    'harga_per_kg' => 12000, 'estimasi_waktu' => '1-2 hari']);
        $l3 = Layanan::create(['nama_layanan' => 'Superkilat', 'harga_per_kg' => 25000, 'estimasi_waktu' => '5 jam selesai']);

        // Data Transaksi Awal Contoh (kombinasi status & status_bayar)
        Transaksi::create([
            'layanan_id'     => $l1->id,
            'nama_pelanggan' => 'Siti Rahmawati',
            'no_hp'          => '081234567891',
            'berat'          => 4.5,
            'total_harga'    => 31500,
            'status'         => 'Selesai',
            'status_bayar'   => 'Lunas',
        ]);

        Transaksi::create([
            'layanan_id'     => $l2->id,
            'nama_pelanggan' => 'Ahmad Fauzi',
            'no_hp'          => '082198765432',
            'berat'          => 2.0,
            'total_harga'    => 24000,
            'status'         => 'Proses',
            'status_bayar'   => 'Belum Lunas',
        ]);

        Transaksi::create([
            'layanan_id'     => $l3->id,
            'nama_pelanggan' => 'Dewi Lestari',
            'no_hp'          => '085711223344',
            'berat'          => 3.0,
            'total_harga'    => 75000,
            'status'         => 'Proses',
            'status_bayar'   => 'Lunas',
        ]);

        Transaksi::create([
            'layanan_id'     => $l1->id,
            'nama_pelanggan' => 'Budi Hendrawan',
            'no_hp'          => '081344556677',
            'berat'          => 5.0,
            'total_harga'    => 35000,
            'status'         => 'Selesai',
            'status_bayar'   => 'Lunas',
        ]);
    }
}
