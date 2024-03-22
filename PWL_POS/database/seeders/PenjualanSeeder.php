<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // 10 penjualan data
            [
                'penjualan_tanggal' => now(),
                'user_id' => 3,
                'pembeli' => 'Radit',
                'penjualan_kode' => 'PK001',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_tanggal' => now(),
                'user_id' => 3,
                'pembeli' => 'Andika',
                'penjualan_kode' => 'PK002',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_tanggal' => now(),
                'user_id' => 3,
                'pembeli' => 'Surya',
                'penjualan_kode' => 'PK003',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_tanggal' => now(),
                'user_id' => 3,
                'pembeli' => 'Suhandi',
                'penjualan_kode' => 'PK004',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_tanggal' => now(),
                'user_id' => 3,
                'pembeli' => 'Malik',
                'penjualan_kode' => 'PK005',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_tanggal' => now(),
                'user_id' => 3,
                'pembeli' => 'Aldi',
                'penjualan_kode' => 'PK006',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_tanggal' => now(),
                'user_id' => 3,
                'pembeli' => 'Karyo',
                'penjualan_kode' => 'PK007',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_tanggal' => now(),
                'user_id' => 3,
                'pembeli' => 'Yudi',
                'penjualan_kode' => 'PK008',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_tanggal' => now(),
                'user_id' => 3,
                'pembeli' => 'Ibnu',
                'penjualan_kode' => 'PK009',
                'penjualan_tanggal' => now(),
            ],
            [
                'penjualan_tanggal' => now(),
                'user_id' => 3,
                'pembeli' => 'Firman',
                'penjualan_kode' => 'PK010',
                'penjualan_tanggal' => now(),
            ],
        ];

        DB::table('t_penjualan')->insert($data);
    }
}
