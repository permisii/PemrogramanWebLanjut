<?php

namespace Database\Seeders;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Carbon\Carbon;
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
                'kategori_id' => '1',
                'barang_kode' => 'FRT',
                'barang_nama' => 'Fruit Tes',
                'harga_beli' => '3000',
                'harga_jual' => '5000',
                'image' => '1_G1WhZ.png',
            ],
            [
                'kategori_id' => '1',
                'barang_kode' => 'IMK',
                'barang_nama' => 'Indomilk Coklat',
                'harga_beli' => '2500',
                'harga_jual' => '4000',
                'image' => '1_G1WhZ.png',
            ],
            [
                'kategori_id' => '2',
                'barang_kode' => 'SKR',
                'barang_nama' => 'SUKRO',
                'harga_beli' => '3500',
                'harga_jual' => '4000',
                'image' => '1_G1WhZ.png',
            ],
            [
                'kategori_id' => '2',
                'barang_kode' => 'GRD',
                'barang_nama' => 'Kacang Garuda',
                'harga_beli' => '1500',
                'harga_jual' => '3300',
                'image' => '1_G1WhZ.png',
            ],
            [
                'kategori_id' => '3',
                'barang_kode' => 'PRX',
                'barang_nama' => 'Paramex',
                'harga_beli' => '1500',
                'harga_jual' => '2300',
                'image' => '1_G1WhZ.png',
            ],
            [
                'kategori_id' => '3',
                'barang_kode' => 'PMG',
                'barang_nama' => 'Promag',
                'harga_beli' => '1500',
                'harga_jual' => '2500',
                'image' => '1_G1WhZ.png',
            ],
            [
                'kategori_id' => '4',
                'barang_kode' => 'BTR',
                'barang_nama' => 'Baterai',
                'harga_beli' => '1500',
                'harga_jual' => '3000',
                'image' => '1_G1WhZ.png',
            ],
            [
                'kategori_id' => '4',
                'barang_kode' => 'TLV',
                'barang_nama' => 'Televisi',
                'harga_beli' => '300000',
                'harga_jual' => '400000',
                'image' => '1_G1WhZ.png',
            ],
            [
                'kategori_id' => '5',
                'barang_kode' => 'CLJN',
                'barang_nama' => 'Celana Jeans',
                'harga_beli' => '150000',
                'harga_jual' => '230000',
                'image' => '1_G1WhZ.png',
            ],
            [
                'kategori_id' => '5',
                'barang_kode' => 'DRS',
                'barang_nama' => 'Dress Panjang',
                'harga_beli' => '100000',
                'harga_jual' => '220000',
                'image' => '1_G1WhZ.png',
            ],
        ];

        for ($i = 0; $i < count($data); $i++) {
            $kategori = KategoriModel::find($data[$i]['kategori_id']);
            $dateNow = Carbon::now()->format('dmY');
            $barangKategori = 1 + $i;
            $data[$i]['barang_kode'] = $kategori->kategori_kode . ($barangKategori < 10 ? ('0' . $barangKategori) : $barangKategori) . '-' . $dateNow;

            BarangModel::create($data[$i]);
        }
    }
}
