<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use App\Models\StokModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    public function index()
    {
        return BarangModel::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required',
            'barang_kode' => 'required',
            'barang_nama' => 'required',
            'stok_jumlah' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048'
        ]);

        if($validator->fails()) return response()->json($validator->errors(), 422);


        $newUser = (object) $validator->safe()->all();

        // Store image
        $image = $request->file('image');
        $imageName = $image->hashName();
        $image->storeAs('public/posts', $imageName);


        DB::beginTransaction();

        if($validator->fails()) return response()->json($validator->errors(), 422);
        
        $barang = BarangModel::create([
            'kategori_id' => $newUser->kategori_id,
            'barang_kode' => $newUser->barang_kode,
            'barang_nama' => $newUser->barang_nama,
            'harga_beli' => $newUser->harga_beli,
            'harga_jual' => $newUser->harga_jual,
            'image' =>  $imageName,
        ]);

        $stok = $barang->stok()->create([
            'barang_id' => $barang->barang_id,
            'user_id' => auth()->guard('api')->user()->user_id,
            'stok_tanggal' => now(),
            'stok_jumlah' => $newUser->stok_jumlah
        ]);


        DB::commit();

        return response()->json([
            'kategori_id' => $barang->kategori_id,
            'barang_kode' => $barang->barang_kode,
            'barang_nama' => $barang->barang_nama,
            'harga_beli' => $barang->harga_beli,
            'harga_jual' => $barang->harga_jual,
            'image' =>  $barang->image,
            'stok_jumlah' =>  $stok->stok_jumlah,
            'user_id' =>  $stok->stok_jumlah,
        ], 201);
    }

    public function show(BarangModel $barang)
    {
        return $barang;
    }

    public function update(Request $request, BarangModel $barang)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'nullable',
            'barang_kode' => 'nullable',
            'barang_nama' => 'nullable',
            'harga_beli' => 'nullable',
            'harga_jual' => 'nullable',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048'
        ]);

        if($validator->fails()) return response()->json($validator->errors(), 422);

        $updateUser = $validator->safe()->all();

        if($request->image){
            // Store image
            $image = $request->file('image');
            $imageName = $image->hashName();
            $image->storeAs('public/posts', $imageName);
            
            $updateUser['image'] = $imageName;
        }

        $barang->update($updateUser);
        return $barang;
    }

    public function destroy(BarangModel $barang)
    {
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data terhapus'
        ]);
    }}
