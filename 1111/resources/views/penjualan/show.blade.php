@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">{{ $page->title }}</h3>
    <div class="card-tools"></div>
  </div>
  <div class="card-body">
    @empty($penjualan)
    <div class="alert alert-danger alert-dismissible">
      <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
      Data yang Anda cari tidak ditemukan.
    </div>
    @else
    <table class="table table-bordered table-striped table-hover table-sm">
      <tr>
        <th>ID</th>
        <td>{{ $penjualan->penjualan_id }}</td>
      </tr>
      <tr>
        <th>Nama User</th>
        <td>{{ $penjualan->user->nama }}</td>
      </tr>
      <tr>
      <tr>
        <th>Nama Pembeli</th>
        <td>{{ $penjualan->pembeli}}</td>
      </tr>
      <tr>
      <tr>
        <th>penjualan_kode</th>
        <td>{{ $penjualan->penjualan_kode }}</td>
      </tr>
      <tr>
        <th>penjualan_tanggal</th>
        <td>{{ date('d-m-Y', strtotime($penjualan->penjualan_tanggal)) }}</td>
      </tr>
      <tr>
        <th>Barang yang dibeli</th>
        <td>
          <ul>
            @foreach ($penjualanDetail as $item)
            <li>{{$item->barang->barang_nama}}</li>
            @endforeach
          </ul>
        </td>
      </tr>

    </table>
    @endempty
    <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
  </div>
</div>
@endsection
@push('css')
@endpush
@push('js')
@endpush