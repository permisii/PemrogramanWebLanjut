<?php

namespace App\Http\Controllers;

use App\Charts\ForecastingChart;
use App\Charts\TransactionsChart;
use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\StokModel;
use App\Models\userModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function index(TransactionsChart $chart, ForecastingChart $forecastingChart)
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
            'activeMenu' => $activeMenu,
            'chart' => $chart->build(),
            'forecastingChart' => $forecastingChart->build()
        ]);
    }

    public function list(Request $request)
    {
        // $transactions = PenjualanModel::with('user');
        // dd($trans);

        if ($request->user_id) {
            // $transactions->where('user_id', $request->user_id);

            $transactions = (object) DB::table('t_penjualan as p')
                ->join('t_penjualan_detail as pd', 'p.penjualan_id', '=', 'pd.penjualan_id')
                ->join('m_user as u', 'p.user_id', '=', 'u.user_id')
                ->selectRaw("p.penjualan_id,u.nama, p.pembeli, p.penjualan_kode, DATE_FORMAT(p.penjualan_tanggal, '%d-%m-%Y') as penjualan_tanggal, sum(pd.harga * pd.jumlah) as total")
                ->where('p.user_id', $request->user_id)
                ->groupBy('u.nama')
                ->groupBy('p.pembeli')
                ->groupBy('p.penjualan_id')
                ->groupBy('p.penjualan_kode')
                ->groupBy('penjualan_tanggal')
                ->orderBy('p.penjualan_id', 'desc')
                ->get();
        } else {

            if (auth()->user()->level->level_nama == 'Member') {
                $transactions = (object) DB::table('t_penjualan as p')
                    ->join('t_penjualan_detail as pd', 'p.penjualan_id', '=', 'pd.penjualan_id')
                    ->join('m_user as u', 'p.user_id', '=', 'u.user_id')
                    ->selectRaw("p.penjualan_id,u.nama, p.pembeli, p.penjualan_kode, DATE_FORMAT(p.penjualan_tanggal, '%d-%m-%Y') as penjualan_tanggal, sum(pd.harga * pd.jumlah) as total")
                    ->where('p.pembeli', auth()->user()->username)
                    ->groupBy('u.nama')
                    ->groupBy('p.pembeli')
                    ->groupBy('p.penjualan_id')
                    ->groupBy('p.penjualan_kode')
                    ->groupBy('penjualan_tanggal')
                    ->orderBy('p.penjualan_id', 'desc')
                    ->get();
            } else {
                $transactions = (object) DB::table('t_penjualan as p')
                    ->join('t_penjualan_detail as pd', 'p.penjualan_id', '=', 'pd.penjualan_id')
                    ->join('m_user as u', 'p.user_id', '=', 'u.user_id')
                    ->selectRaw("p.penjualan_id,u.nama, p.pembeli, p.penjualan_kode, DATE_FORMAT(p.penjualan_tanggal, '%d-%m-%Y') as penjualan_tanggal, sum(pd.harga * pd.jumlah) as total")
                    ->groupBy('u.nama')
                    ->groupBy('p.pembeli')
                    ->groupBy('p.penjualan_id')
                    ->groupBy('p.penjualan_kode')
                    ->groupBy('penjualan_tanggal')
                    ->orderBy('p.penjualan_id', 'desc')
                    ->get();
            }
        }

        if (auth()->user()->level->level_nama == 'Member') {
            return DataTables::of($transactions)->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
                ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
                    $btn = '<a href="' . url('/penjualan/' . $penjualan->penjualan_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                    $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/printStruk') . '" class="btn btn-secondary btn-sm">Print Struk</a> ';
                    // $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/edit') . '" 
                    // class="btn btn-warning btn-sm">Edit</a> ';
                    //             $btn .= '<form class="d-inline-block" method="POST" action="' .
                    //                 url('/penjualan/' . $penjualan->penjualan_id) . '">'
                    //                 . csrf_field() . method_field('DELETE') .
                    //                 '<button type="submit" class="btn btn-danger btn-sm" 
                    // onclick="return confirm(\'Apakah Anda yakit menghapus data 
                    // ini?\');">Delete</button></form>';
                    return $btn;
                })
                ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
                ->make(true);
        } else {
            return DataTables::of($transactions)->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
                ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
                    $btn = '<a href="' . url('/penjualan/' . $penjualan->penjualan_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                    $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/printStruk') . '" class="btn btn-secondary btn-sm">Print Struk</a> ';
                    // $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/edit') . '" 
                    // class="btn btn-warning btn-sm">Edit</a> ';
                    $btn .= '<form class="d-inline-block" method="POST" action="' .
                        url('/penjualan/' . $penjualan->penjualan_id) . '">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" 
        onclick="return confirm(\'Apakah Anda yakit menghapus data 
        ini?\');">Delete</button></form>';
                    return $btn;
                })
                ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
                ->make(true);
        }
    }

    public function edit(string $id)
    {
        $penjualan = penjualanModel::with('user')->find($id);
        $penjualanDetail = PenjualanDetailModel::where('penjualan_id', $id)->get();

        // dd($penjualanDetail);

        $barang = StokModel::where('stok_jumlah', '>', 0)->with('barang')->get();
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
            'user' => userModel::all(),
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
            'user' => userModel::all(),
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

        $barang = StokModel::where('stok_jumlah', '>', 0)->with('barang')->get();
        $user = UserModel::with('level')->get();
        $kasir = $user->where('level.level_nama', '==', 'Staff/Kasir');
        $member = $user->where('level.level_nama', '==', 'Member');

        $activeMenu = 'penjualan';

        return view('penjualan.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kasir' => $kasir,
            'member' => $member,
            'barang' => $barang,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'data_checkout' => 'required|string',
            'user_id' => 'required|integer',
            'pembeli' => 'required|string',
            'penjualan_tanggal' => 'required|date',
        ]);

        $barang = BarangModel::all();
        $latestData = PenjualanModel::latest()->first();

        $penjualanKode = 'jual' . (($latestData->penjualan_id) + 1) . Carbon::createFromDate($request->penjualan_tanggal)->format('dmY');

        $penjualan = penjualanModel::create([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $penjualanKode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
        ]);


        $barangLaku = json_decode($request->data_checkout);

        foreach ($barangLaku as $key => $item) {

            PenjualanDetailModel::create([
                'penjualan_id' => $penjualan->penjualan_id,
                'barang_id' => $item->barang_id,
                'harga' => $barang->find($item->barang_id)->harga_jual,
                'jumlah' => $item->qty,
            ]);

            $stok = stokModel::where('barang_id', $item->barang_id)->with('barang')->first();
            if (!$stok) return back()->with('error', 'Stok ' . $stok->barang_nama . ' Tidak tersedia atau belum di inputkan');
            $stok->decrement('stok_jumlah', $item->qty);

            if ($stok->stok_jumlah < 0) return back()->with('error', 'Stok ' . $stok->barang_nama . ' Tidak Mencukupi');
        }

        DB::commit();

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil disimpan');
    }

    public function destroy(string $id)
    {
        $check = PenjualanModel::find($id);

        if (!$check) {
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
        }

        try {
            $penjualanDetail = PenjualanDetailModel::where('penjualan_id', $id)->get();

            foreach ($penjualanDetail as $key => $item) {
                $item->delete();
            }

            PenjualanModel::destroy($id);

            return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
        } catch (\Throwable $th) {
            // dd($th);
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
            'penjualan_tanggal' => 'nullable|date',
        ]);
        DB::beginTransaction();

        $penjualanKode = 'jual' . Carbon::createFromDate($request->penjualan_tanggal)->format('dmY');

        $penjualan = PenjualanModel::find($id);
        $penjualan->update([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $penjualanKode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
        ]);
        $barang = BarangModel::all();

        $barangLaku = $request->only('barang_id');

        if (count($barangLaku) > 0) {
            PenjualanDetailModel::where('penjualan_id', $id)->delete();

            foreach ($barangLaku['barang_id'] as $key => $item) {

                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'barang_id' => $item[0],
                    'harga' => $barang->find($item[0])->harga_jual,
                    'jumlah' => 1,
                ]);

                $stok = stokModel::where('barang_id', $item[0])->with('barang')->first();
                $stok->decrement('stok_jumlah', 1);

                if ($stok->stok_jumlah < 0) {
                    return back()->with('error', 'Stok ' . $stok->barang_nama . ' Tidak Mencukupi');
                }
            }
        }

        DB::commit();

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil diubah');
    }

    public function printStruk(string $id)
    {
        $transaction = PenjualanModel::with('penjualanDetail')->find($id);

        $pdf = Pdf::loadView('export_table.transaksiStruk', [
            'transaction' => $transaction,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'struk_Transaksi_#' . $transaction->penjualan_kode . '.pdf');
    }
}
