<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function fileUpload()
    {
        return view('file-upload');
    }

    public function prosesFileUpload(Request $request)
    {
        $request->validate([
            'nama_gambar' => 'required',
            'berkas' => 'required|file|image|max:5000'
        ]);

        $extFile = $request->berkas->extension();
        $namaFile = $request->nama_gambar.".".$extFile;

        $path = $request->berkas->move('gambar',$namaFile);
        // $path = str_replace("\\", "//", $path);
        
        $pathBaru = asset('gambar/'.$namaFile);

        echo "Gambar berhasil di upload ke <a href='$pathBaru'>$namaFile</a>";
        echo "<br>";
        echo "<br>";
        echo "<img src='$pathBaru' alt='gambar'>";


        // if($request->hasFile('berkas'))
        // {
        //     echo "path() : ".$request->berkas->path();
        //     echo "<br>";
        //     echo "extension() : ".$request->berkas->extension();
        //     echo "<br>";
        //     echo "getClientOriginalExtension() : ".$request->berkas->getClientOriginalExtension();
        //     echo "<br>";
        //     echo "getMimeType() : ".$request->berkas->getMimeType();
        //     echo "<br>";
        //     echo "getSize() : ".$request->berkas->getSize();
        // }else{
        //     echo "Tidak ada berkas yang diupload";
        // }
    }
}
