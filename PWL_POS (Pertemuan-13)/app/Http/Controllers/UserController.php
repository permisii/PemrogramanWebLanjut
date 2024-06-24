<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\userModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Manajemen User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar User yang terdaftar dalam sistem',
        ];

        $activeMenu = 'user';

        $level = LevelModel::all();

        $user = userModel::all();

        return view('user.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu,
            'user' => userModel::all()

        ]);
    }

    public function list(Request $request)
    {
        $users = userModel::with('level');

        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" 
        class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' .
                    url('/user/' . $user->user_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" 
        onclick="return confirm(\'Apakah Anda yakit menghapus data 
        ini?\');">Delete</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all();
        $activeMenu = 'user';

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu, 'user' => UserModel::all()]);
    }

    public function store(Request $request)
    {
        $newUser = $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:100',
            'no_ktp' => 'required|string|max:100',
            'no_telp' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer',
            'profile_img' => 'nullable|mimes:jpg,png,jpeg',
        ]);

        if ($request->only('profile_img')) {
            // Store profile image
            $profileImg = $newUser['profile_img'];
            $profileName = Str::random(10) . $newUser['profile_img']->getClientOriginalName();
            $profileImg->storeAs('public/profile', $profileName);
            // Overide profile_img name
            $newUser['profile_img'] = $profileName;
        }

        userModel::create($newUser);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    public function show(string $id)
    {
        $user = userModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user';

        return view('user.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit(string $id)
    {
        $user = UserModel::find($id);


        $level = LevelModel::all();


        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'user', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit User',
        ];

        $activeMenu = 'user';

        return view('user.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'userEdit' => $user,
            'level' => $level,
            'activeMenu' => $activeMenu,
            'user' => userModel::all()
        ]);
    }

    public function update(Request $request, string $id)
    {

        // dd($request->all(), $id);
        $newUser = $request->validate([
            'username' => 'required|string|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:100',
            'no_ktp' => 'required|string|max:100',
            'no_telp' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer',
            'profile_img' => 'nullable|mimes:jpg,png,jpeg',

        ]);

        $oldData = UserModel::find($id);

        if ($request->profile_img) {
            // Store profile image
            $profileImg = $newUser['profile_img'];
            $profileName = Str::random(10) . $newUser['profile_img']->getClientOriginalName();
            $profileImg->storeAs('public/profile', $profileName);
            // Overide profile_img name
            $newUser['profile_img'] = $profileName;

            Storage::delete('public/profile/' . $oldData->profile_img);
        }


        $oldData->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_telp' => $request->no_telp,
            'password' => $request->password ? bcrypt($request->password) : $oldData->password,
            'level_id' => $request->level_id,
            'profile_img' => isset($newUser['profile_img']) ? $newUser['profile_img'] : $oldData->profile_img
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    public function destroy(string $id)
    {
        $member = UserModel::find($id);

        if (!$member) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {

            if (!empty($member->profile_img)) {
                Storage::delete('public/profile/' . $member->profile_img);
            }

            $member->delete();

            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
