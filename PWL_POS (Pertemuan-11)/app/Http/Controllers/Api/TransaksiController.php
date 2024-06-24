<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\StokModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    public function index()
    {
        return PenjualanModel::with('penjualanDetail.barang')->orderby('penjualan_id', 'desc')->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang' => 'required',
            'pembeli' => 'required|string',
        ]);

        if($validator->fails()) return response()->json($validator->errors(), 422);

        $barangLaku = collect($validator->safe()->barang);

        $barang = BarangModel::whereIn('barang_id', $barangLaku->pluck('barang_id'))->get();

        DB::beginTransaction();

        $penjualan = penjualanModel::create([
            'user_id' => auth()->guard('api')->user()->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' =>Str::random(10),
            'penjualan_tanggal' => now(),
        ]);


        $barangLaku = $request->only('barang');

        $penjualan_detail = collect();

        foreach ($barangLaku['barang'] as $key => $item) {

            $itemLaku = $barang->find($item['barang_id']);

            if(!$itemLaku){
                return response()->json(['error' => 'Barang dengan id '.$item['barang_id'].' tidak ditemukan'], 401);
            }

            $detail = PenjualanDetailModel::create([
                'penjualan_id' => $penjualan->penjualan_id,
                'barang_id' => $item['barang_id'],
                'harga' => $itemLaku->harga_jual,
                'jumlah' => $item['qty'],
            ]);

            $stok = StokModel::where('barang_id', $item['barang_id'])->first();
            $stok->decrement('stok_jumlah', $item['qty']);

            if(!$stok){
                return response()->json(['error' => 'stok barang dengan id '.$item['barang_id'].' tidak ditemukan'], 401);
            }

            if($stok->stok_jumlah < 0 ){
                return response()->json(['error' => 'Stok barang '.$itemLaku->barang_nama.' tidak mencukup'], 401);
            }

            $penjualan_detail->prepend($detail);
        }

        DB::commit();

        return response()->json([
            'penjualan_id' => $penjualan->penjualan_id,
            'penjualan_kode' => $penjualan->penjualan_kode,
            'pembeli' => $penjualan->pembeli,
            'penjualan_tanggal' => $penjualan->penjualan_tanggal,
            'user_id' => $penjualan->user_id,
            'penjualanDetail' => $penjualan_detail
        ], 201);    
    }
}
