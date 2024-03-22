<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_kode' => 'BRG001',
                'barang_nama' => 'Air Mineral',
                'kategori_id' => 1,
                'harga_beli' => 5000,
                'harga_jual' => 10000,
            ],
            [
                'barang_kode' => 'BRG002',
                'barang_nama' => 'Teh Botol',
                'kategori_id' => 1,
                'harga_beli' => 7000,
                'harga_jual' => 14000,
            ],
            [
                'barang_kode' => 'BRG003',
                'barang_nama' => 'Kopi Sachet',
                'kategori_id' => 1,
                'harga_beli' => 5000,
                'harga_jual' => 10000,
            ],
            [
                'barang_kode' => 'BRG004',
                'barang_nama' => 'Mie Instan',
                'kategori_id' => '2',
                'harga_beli' => 3000,
                'harga_jual' => 6000,
            ],
            [
                'barang_kode' => 'BRG005',
                'barang_nama' => 'Roti Tawar',
                'kategori_id' => '2',
                'harga_beli' => 5000,
                'harga_jual' => 10000,
            ],
            [
                'barang_kode' => 'BRG006',
                'barang_nama' => 'Kerupuk',
                'kategori_id' => 3,
                'harga_beli' => 2000,
                'harga_jual' => 4000,
            ],
            [
                'barang_kode' => 'BRG007',
                'barang_nama' => 'Permen',
                'kategori_id' => 3,
                'harga_beli' => 1000,
                'harga_jual' => 2000,
            ],
            [
                'barang_kode' => 'BRG008',
                'barang_nama' => 'Gula Pasir',
                'kategori_id' => 4,
                'harga_beli' => 10000,
                'harga_jual' => 30000,
            ],
            [
                'barang_kode' => 'BRG009',
                'barang_nama' => 'Minyak Goreng',
                'kategori_id' => 4,
                'harga_beli' => 15000,
                'harga_jual' => 30000,
            ],
            [
                'barang_kode' => 'BRG010',
                'barang_nama' => 'Telur',
                'kategori_id' => 4,
                'harga_beli' => 20000,
                'harga_jual' => 40000,
            ],
        ];

        DB::table('m_barang')->insert($data);
    }
}
