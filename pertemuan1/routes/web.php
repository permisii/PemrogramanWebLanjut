<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ('Welcome');
})
;

Route::get('/helo', function () {
    return 'Hello World';
})
;

Route::get('/', function () {
    return 'Selamat Datang';
})
;

Route::get('/about', function () {
    return '2141762082 - Arielia Zahwa';
})
;

Route::get('/user/{lia}', function ($name) {
    return 'Nama saya ' .$name;
})
;

Route::get('/mahasiswa', function () {
    $arrMahasiswa = ["gadhis", "alex", "diki", "dika", "ojan"];

    return view('polinema.mahasiswa', ['mahasiswa' => $arrMahasiswa]);
});

Route::get('/dosen', function(){
    $arrDosen = ["Pak Dimas", "Pak Yoppy", "Pak Imam"];

    return view('polinema.dosen', ['dosen' => $arrDosen]);
});