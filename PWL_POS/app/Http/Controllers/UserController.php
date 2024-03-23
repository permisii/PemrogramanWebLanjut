<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // $data = [
        //     'username' => 'lia12',
        //     'nama' => 'Pelanggan',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 3,
        // ];

        // UserModel::insert($data);

        // $user = UserModel::all();
        // return view('user', ['data' => $user]);

        $data = [
            'nama' => 'pelanggan kedua',
        ];

        UserModel::where('username', 'customer2')->update($data);

        $user = UserModel::all();
        return view('user', ['data' => $user]);


    }

}
