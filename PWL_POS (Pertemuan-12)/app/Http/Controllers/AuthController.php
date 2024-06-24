<?php

namespace App\Http\Controllers;

use App\Models\userModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if($user){
                return redirect()->intended('user');
        //     if($user->level_id =='1')
        //     {
        //         return redirect()->intended('admin');
        //     }elseif($user->level == '2')
        //     {
        //         return redirect()->intended('manager');
        //     }
        // 
    }
        
        return view('login');
    }

    public function proses_login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials =  $request->only(['username', 'password']);

        if(Auth::attempt($credentials))
        {
            $user = Auth::user();

            if($user->level_id == '1')
            {
                return redirect()->intended('admin');
            }
            elseif ($user->level_id == '2') {
                return redirect()->intended('manager');
            }

            return redirect()->intended('/');
        }

        return redirect()
        ->withInput()
        ->withErrors(['login_gagal' => 'Pastikan kembali usernamedan password yang dimasukkan sudah benar']);
    }

    public function register()
    {
        return view('register');
    }

    public function proses_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'username' => 'required|unique:m_user',
            'password' => 'required',
        ]);

        if($validator->fails())
        {
            return redirect('/register')
            ->withErrors($validator)
            ->withInput();
        }

        $request['level_id'] = '2';
        $request['password'] = Hash::make($request->password);

        userModel::create($request->all());

        return redirect()->route('login');

    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->flush();

        Auth::logout();

        return redirect('login');
    }

   
}
