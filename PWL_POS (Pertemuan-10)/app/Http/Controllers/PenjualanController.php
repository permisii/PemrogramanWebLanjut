<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\StokModel;
use App\Models\userModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Manajemen Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object) [
            'title' => 'Daftar Penjualan yang terdaftar dalam sistem',
        ];

        $activeMenu = 'penjualan';

        $user = userModel::all();

        return view('penjualan.index', [
        'breadcrumb' => $breadcrumb, 
        'page' => $page, 
        'user' => $user, 
        'activeMenu' => $activeMenu
        ]);
    }

    public function list(Request $request)
    {
        // $transactions = PenjualanModel::with('user');

        $transactions = (object) DB::table('t_penjualan as p')
                ->join('t_penjualan_detail as pd', 'p.penjualan_id','=', 'pd.penjualan_id')
                ->join('m_user as u', 'p.user_id','=', 'u.user_id')
                ->selectRaw('p.penjualan_id,u.nama, p.pembeli, p.penjualan_kode, p.penjualan_tanggal, sum(pd.harga * pd.jumlah) as total')
                ->groupBy('u.nama')
                ->groupBy('p.pembeli')
                ->groupBy('p.penjualan_id')
                ->groupBy('p.penjualan_kode')
                ->groupBy('p.penjualan_tanggal')
                ->get();

        // dd($trans);

        if($request->user_id){
            $transactions->where('user_id', $request->user_id);
        }

        return DataTables::of($transactions)->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
        ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
        $btn = '<a href="'.url('/penjualan/' . $penjualan->penjualan_id).'" class="btn btn-info btn-sm">Detail</a> ';
        $btn .= '<a href="'.url('/penjualan/' . $penjualan->penjualan_id . '/edit').'" 
        class="btn btn-warning btn-sm">Edit</a> ';
        $btn .= '<form class="d-inline-block" method="POST" action="'. 
        url('/penjualan/'.$penjualan->penjualan_id).'">'
        . csrf_field() . method_field('DELETE') . 
        '<button type="submit" class="btn btn-danger btn-sm" 
        onclick="return confirm(\'Apakah Anda yakit menghapus data 
        ini?\');">Hapus</button></form>'; 
        return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }

    public function edit(string $id)
    {
        $penjualan = penjualanModel::with('user')->find($id);
        $penjualanDetail = PenjualanDetailModel::where('penjualan_id', $id)->get();

        // dd($penjualanDetail);

        $barang = StokModel::where('stok_jumlah', '>' ,0)->with('barang')->get();
        $user = UserModel::all();


        $breadcrumb = (object) [
            'title' => 'Edit penjualan',
            'list' => ['Home', 'penjualan', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit penjualan',
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.edit', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page,
            'penjualan' => $penjualan,
            'penjualanDetail' => $penjualanDetail,
            'barang' => $barang,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function show(string $id)
    {
        $penjualan = penjualanModel::with('user')->find($id);
        $penjualanDetail = penjualanDetailModel::where('penjualan_id', $id)->with('barang')->get();

        $breadcrumb = (object) [
            'title' => 'Detail Penjualan',
            'list' => ['Home', 'Penjualan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail penjualan'
        ];

        $activeMenu = 'penjualan';

        return view('penjualan.show', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page,
            'penjualan' => $penjualan,
            'penjualanDetail' => $penjualanDetail,
            'activeMenu' => $activeMenu
        ]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Penjualan',
            'list' => ['Home', 'Penjualan', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah penjualan baru'
        ];

        $barang = StokModel::where('stok_jumlah', '>' ,0)->with('barang')->get();
        $user = UserModel::all();

        $activeMenu = 'penjualan';

        return view('penjualan.create',[
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'barang' => $barang, 
            'user' => $user, 
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'barang_id' => 'required|array',
            'user_id' => 'required|integer',
            'pembeli' => 'required|string',
            'penjualan_kode' => 'required|string',
            'penjualan_tanggal' => 'required|date',
        ]);

        $barang = BarangModel::all();
    

        DB::beginTransaction();

        $penjualan = penjualanModel::create($request->all());


        $barangLaku = $request->only('barang_id');


        foreach ($barangLaku as $key => $item) {

            PenjualanDetailModel::create([
                'penjualan_id' => $penjualan->penjualan_id,
                'barang_id' => $item[0],
                'harga' => $barang->find($item[0])->harga_jual,
                'jumlah' => 1,
            ]);

            $stok = stokModel::where('barang_id', $item[0])->with('barang')->first();
            $stok->decrement('stok_jumlah', 1);

            if($stok->stok_jumlah < 0 ){
            return back()->with('error', 'Stok '.$stok->barang_nama.' Tidak Mencukupi');
            }
        }

        DB::commit();

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil disimpan');
    }

    public function destroy(string $id)
    {
        $check = PenjualanModel::find($id);

        if(!$check){
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
        }

        try {
            PenjualanDetailModel::where('penjualan_id',$id)->first()->delete();

            PenjualanModel::destroy($id);

            return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('/penjualan')->with('error', 'Data penjualan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function update(Request $request, string $id)
    {

        // dd($request->all(), $id);
        $request->validate([
            'barang_id' => 'nullable|array',
            'user_id' => 'nullable|integer',
            'pembeli' => 'nullable|string',
            'penjualan_kode' => 'nullable|string',
            'penjualan_tanggal' => 'nullable|date',
        ]);
        DB::beginTransaction();


        $penjualan = PenjualanModel::find($id);
        $penjualan->update($request->all());
        $barang = BarangModel::all();


        $barangLaku = $request->only('barang_id');

        if(count($barangLaku) > 0){
            PenjualanDetailModel::where('penjualan_id', $id)->delete();

            foreach ($barangLaku as $key => $item) {

                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $item[0],
                    'harga' => $barang->find($item[0])->harga_jual,
                    'jumlah' => 1,
                ]);
    
                $stok = stokModel::where('barang_id', $item[0])->with('barang')->first();
                $stok->decrement('stok_jumlah', 1);
    
                if($stok->stok_jumlah < 0 ){
                return back()->with('error', 'Stok '.$stok->barang_nama.' Tidak Mencukupi');
                }
            }
        }

        DB::commit();

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil diubah');
    }
}
