<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'level_id' => 1,
                'username' => 'administrator',
                'password' => Hash::make('12345'),
                'nama' => 'Administrator',
                'alamat' => 'Kepanjen',
                'no_ktp' => '12121232',
                'no_telp' => '23232',
                'profile_img' => '1_G1WhZ.png',
                'status' => 1,
            ],
            [
                'level_id' => 2,
                'username' => 'manager',
                'password' => Hash::make('12345'),
                'nama' => 'Manager',
                'alamat' => 'Kepanjen',
                'no_ktp' => '12121232',
                'no_telp' => '23232',
                'status' => 1,
                'profile_img' => '1_G1WhZ.png',

            ],
            [
                'level_id' => 3,
                'username' => 'staff',
                'password' => Hash::make('12345'),
                'nama' => 'Kasir-1',
                'alamat' => 'Kepanjen',
                'no_ktp' => '12121232',
                'no_telp' => '23232',
                'status' => 1,
                'profile_img' => '1_G1WhZ.png',

            ],
            [
                'level_id' => 4,
                'username' => 'admin',
                'password' => Hash::make('12345'),
                'nama' => 'admin',
                'alamat' => 'Kepanjen',
                'no_ktp' => '12121232',
                'no_telp' => '23232',
                'status' => 1,
                'profile_img' => '1_G1WhZ.png',
            ],
            [
                'level_id' => 5,
                'username' => 'member',
                'password' => Hash::make('12345'),
                'nama' => 'member',
                'alamat' => 'Kepanjen',
                'no_ktp' => '12121232',
                'no_telp' => '23232',
                'status' => 1,
                'profile_img' => '1_G1WhZ.png',
            ],

        ];

        DB::table('m_user')->insert($data);
    }
}
