<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_kode' => 'MNN',
                'kategori_nama' => 'Minuman',
            ],
            [
                'kategori_kode' => 'MKN',
                'kategori_nama' => 'Makanan',
            ],
            [
                'kategori_kode' => 'KSTN',
                'kategori_nama' => 'Kesehatan',
            ],
            [
                'kategori_kode' => 'OTMF',
                'kategori_nama' => 'Otomotif',
            ],
            [
                'kategori_kode' => 'ELK',
                'kategori_nama' => 'Elektronik',
            ],
            [
                'kategori_kode' => 'PKN',
                'kategori_nama' => 'Pakaian',
            ],
        ];

        DB::table('m_kategori')->insert($data);
    }
}
