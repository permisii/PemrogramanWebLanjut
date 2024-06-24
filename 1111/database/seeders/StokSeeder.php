<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $data = [
        //     [
        //         'barang_id' => 1,
        //         'user_id' => 1,
        //         'stok_tanggal' => now(),
        //         'stok_jumlah' => 100,
        //         'created_at' => now(),
        //         'deleted_at' => now(),
        //     ],
        //     [
        //         'barang_id' => 2,
        //         'user_id' => 1,
        //         'stok_tanggal' => now(),
        //         'stok_jumlah' => 100,
        //         'created_at' => now(),
        //         'deleted_at' => now(),
        //     ],
        //     [
        //         'barang_id' => 3,
        //         'user_id' => 1,
        //         'stok_tanggal' => now(),
        //         'stok_jumlah' => 100,
        //         'created_at' => now(),
        //         'deleted_at' => now(),
        //     ],
        //     [
        //         'barang_id' => 4,
        //         'user_id' => 2,
        //         'stok_tanggal' => now(),
        //         'stok_jumlah' => 100,
        //         'created_at' => now(),
        //         'deleted_at' => now(),
        //     ],
        //     [
        //         'barang_id' => 5,
        //         'user_id' => 1,
        //         'stok_tanggal' => now(),
        //         'stok_jumlah' => 100,
        //         'created_at' => now(),
        //         'deleted_at' => now(),
        //     ],
        //     [
        //         'barang_id' => 1,
        //         'user_id' => 1,
        //         'stok_tanggal' => now(),
        //         'stok_jumlah' => 100,
        //         'created_at' => now(),
        //         'deleted_at' => now(),
        //     ],
        //     [
        //         'barang_id' => 1,
        //         'user_id' => 1,
        //         'stok_tanggal' => now(),
        //         'stok_jumlah' => 100,
        //         'created_at' => now(),
        //         'deleted_at' => now(),
        //     ],
        //     [
        //         'barang_id' => 1,
        //         'user_id' => 1,
        //         'stok_tanggal' => now(),
        //         'stok_jumlah' => 100,
        //         'created_at' => now(),
        //         'deleted_at' => now(),
        //     ],
        //     [
        //         'barang_id' => 1,
        //         'user_id' => 1,
        //         'stok_tanggal' => now(),
        //         'stok_jumlah' => 100,
        //         'created_at' => now(),
        //         'deleted_at' => now(),
        //     ],
        //     [
        //         'barang_id' => 1,
        //         'user_id' => 1,
        //         'stok_tanggal' => now(),
        //         'stok_jumlah' => 100,
        //         'created_at' => now(),
        //         'deleted_at' => now(),
        //     ],
        // ];

        for ($i=0; $i < 10; $i++) { 
            DB::table('t_stok')->insert(
                [
                    'barang_id' => $i+1,
                    'user_id' => $i%3 == 0 ? 1 : $i%3,
                    'stok_tanggal' => now(),
                    'stok_jumlah' => 100,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

    }
}
