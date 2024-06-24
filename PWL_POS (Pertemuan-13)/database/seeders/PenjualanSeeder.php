<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
            [
                'user_id' => 1,
                'pembeli' => 'Fahmi',
                'penjualan_kode' => 'jual' . Carbon::now()->format('dmY'),
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Fahmi',
                'penjualan_kode' => 'jual' . Carbon::now()->format('dmY'),
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Fahmi',
                'penjualan_kode' => 'jual' . Carbon::now()->format('dmY'),
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Fahmi',
                'penjualan_kode' => 'jual' . Carbon::now()->format('dmY'),
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'pembeli' => 'Fahmi',
                'penjualan_kode' => 'jual' . Carbon::now()->format('dmY'),
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Fajar',
                'penjualan_kode' => 'jual' . Carbon::now()->format('dmY'),
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Fajar',
                'penjualan_kode' => 'jual' . Carbon::now()->format('dmY'),
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'pembeli' => 'Fajar',
                'penjualan_kode' => 'jual' . Carbon::now()->format('dmY'),
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Vira',
                'penjualan_kode' => 'jual' . Carbon::now()->format('dmY'),
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'pembeli' => 'Vira',
                'penjualan_kode' => 'jual' . Carbon::now()->format('dmY'),
                'penjualan_tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('t_penjualan')->insert($data);
    }
}
