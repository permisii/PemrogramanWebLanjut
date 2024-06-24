<?php

namespace App\Http\Controllers;

use App\Models\userModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';

        // return view('welcome', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
        return view('welcome', compact('breadcrumb', 'activeMenu'));
    }
    


}
