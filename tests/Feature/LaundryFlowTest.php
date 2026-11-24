<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Transaksi;

class LaundryFlowTest extends TestCase {
    public function test_login_and_register_screens_can_be_rendered() {
        $loginRes = $this->get('/login');
        $loginRes->assertStatus(200);
        $loginRes->assertSee('Sistem Laundry');

        $regRes = $this->get('/register');
        $regRes->assertStatus(200);
        $regRes->assertSee('Daftar Akun Kasir');
    }

    public function test_user_can_register_as_kasir_by_default() {
        $email = 'kasir_' . uniqid() . '@laundry.com';
        $response = $this->post('/register', [
            'name'                  => 'Kasir Baru Unit Test',
            'email'                 => $email,
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $user = User::where('email', $email)->first();
        $this->assertNotNull($user);
        $this->assertEquals('kasir', $user->role);

        $user->delete();
    }

    public function test_admin_can_access_dashboard_and_see_lunas_omzet() {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Total Pendapatan');
        $response->assertSee('Hanya transaksi Lunas');
    }

    public function test_kasir_dashboard_does_not_show_omzet() {
        $kasir = User::where('role', 'kasir')->first();
        $response = $this->actingAs($kasir)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertDontSee('Total Pendapatan');
        $response->assertSee('Antrean Sedang Proses');
    }

    public function test_kasir_cannot_access_create_layanan() {
        $kasir = User::where('role', 'kasir')->first();
        $response = $this->actingAs($kasir)->get('/layanan/create');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_create_layanan() {
        $admin = User::where('role', 'admin')->first();
        $response = $this->actingAs($admin)->get('/layanan/create');
        $response->assertStatus(200);
    }

    public function test_kasir_can_create_order_and_update_payment_but_cannot_complete_order() {
        $kasir = User::where('role', 'kasir')->first();
        $admin = User::where('role', 'admin')->first();
        $layanan = Layanan::first();
        $namaPelanggan = 'Pelanggan_' . uniqid();

        // 1. Kasir membuat transaksi dengan status bayar Belum Lunas
        $response = $this->actingAs($kasir)->post('/transaksi', [
            'layanan_id'     => $layanan->id,
            'nama_pelanggan' => $namaPelanggan,
            'no_hp'          => '081233445566',
            'berat'          => 2.5,
            'status_bayar'   => 'Belum Lunas',
        ]);

        $response->assertRedirect('/transaksi');

        $transaksi = Transaksi::where('nama_pelanggan', $namaPelanggan)->first();
        $this->assertNotNull($transaksi);
        $this->assertEquals(2.5 * $layanan->harga_per_kg, $transaksi->total_harga);
        $this->assertEquals('Proses', $transaksi->status);
        $this->assertEquals('Belum Lunas', $transaksi->status_bayar);

        // 2. Kasir dapat melunasi pembayaran transaksi
        $payResponse = $this->actingAs($kasir)->patch("/transaksi/{$transaksi->id}/bayar");
        $payResponse->assertRedirect('/transaksi');
        $this->assertEquals('Lunas', $transaksi->fresh()->status_bayar);

        // 3. Hak Kasir: Kasir TIDAK BISA menyelesaikan orderan (harus 403 Forbidden)
        $kasirCompleteResponse = $this->actingAs($kasir)->patch("/transaksi/{$transaksi->id}/status");
        $kasirCompleteResponse->assertStatus(403);
        $this->assertEquals('Proses', $transaksi->fresh()->status);

        // 4. Admin BISA menyelesaikan orderan
        $adminCompleteResponse = $this->actingAs($admin)->patch("/transaksi/{$transaksi->id}/status");
        $adminCompleteResponse->assertRedirect('/transaksi');
        $this->assertEquals('Selesai', $transaksi->fresh()->status);

        $transaksi->delete();
    }
}
