<?php

namespace App\Http\Controllers;

use App\Charts\MemberRegisterChart;
use App\Exports\MembersExport;
use App\Models\userModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class WelcomeController extends Controller
{
    public function index(MemberRegisterChart $chart)
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dashboard';

        // return view('welcome', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
        return view('home.index', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'chart' => $chart->build()
        ]);
    }

    public function list(Request $request)
    {
        $users = userModel::with('level')
                ->whereRelation('level', 'level_nama', 'Member' );

        if($request->level_id){
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
        ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
        $btn = '<a href="'.url('/member/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> ';
        $btn .= '<a href="'.url('/member/updateValidation/' . $user->user_id ).'" 
        class="btn btn-warning btn-sm">'.($user->status == 0 ? 'Validate' : 'Unvalidate' ).'</a> ';
        $btn .= '<form class="d-inline-block" method="POST" action="'. 
        url('/member/'.$user->user_id).'">'
        . csrf_field() . method_field('DELETE') . 
        '<button type="submit" class="btn btn-danger btn-sm" 
        onclick="return confirm(\'Apakah Anda yakit menghapus data 
        ini?\');">Delete</button></form>'; 
        return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }
    

    public function exportPdf()
    {
        $members = userModel::with('level')
        ->whereRelation('level', 'level_nama', 'Member' )
        ->get();


        $pdf = Pdf::loadView('export_table.memberTable', [
            'members' => $members,
            'title' => 'Data Member'
        ]);

        return response()->streamDownload(function() use($pdf){
            echo $pdf->stream();
        }, 'Data_Member_PWL_POS.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new MembersExport, 'Data_Member_PWL_POS.xlsx');
    }

    public function show(string $id)
    {
        $member = userModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'Member', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'dashboard';

        return view('home.member', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page,
            'member' => $member,
            'activeMenu' => $activeMenu
        ]);
    }

    public function updateValidation($id)
    {
        $user = userModel::find($id);

        $user->update([
            'status' => !(bool) $user->status
        ]);

        return redirect('/')->with('success', 'Status validasi member berhasil diubah');
    }

    public function destroy(string $id)
    {
        $member = UserModel::find($id);

        if(!$member){
            return redirect('/user')->with('error', 'Data member tidak ditemukan');
        }

        try {
            if(!empty( $member->profile_img)){        
                Storage::delete('public/profile/'.$member->profile_img);
            }

            $member->delete();

            return redirect('/')->with('success', 'Data member berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect('/')->with('/error', 'Data member gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

}
