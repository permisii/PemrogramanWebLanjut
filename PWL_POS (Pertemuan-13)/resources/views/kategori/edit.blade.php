@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">{{ $page->title }}</h3>
    <div class="card-tools"></div>
  </div>
  <div class="card-body">
    @empty($kategori)
    <div class="alert alert-danger alert-dismissible">
      <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
      Data yang Anda cari tidak ditemukan.
    </div>
    <a href="{{ url('level') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    @else
    <form action="{{ url('/kategori/'.$kategori->kategori_id) }}" method="post">
      @csrf
      @method('PUT')
      <div class="card-body">
        {{-- Error Alert --}}
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
          </ul>
        </div>
        @endif
        <div class="form-group">
          <label for="kodeKategori">Kode Kategori</label>
          <input type="text" name="kategori_kode" value="{{$kategori->kategori_kode}}" id="kodeKategori"
            placeholder="Untuk makanan, contoh: MKN" class="form-control">
        </div>
        <div class="form-group">
          <label for="kodeKategori">Nama Kategori</label>
          <input type="text" name="kategori_nama" id="namaKategori" value="{{$kategori->kategori_nama}}"
            placeholder="Nama" class="form-control">
        </div>

        <div class=" card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
    @endempty
  </div>
</div>
@endsection
@push('css')
@endpush
@push('js')
@endpush