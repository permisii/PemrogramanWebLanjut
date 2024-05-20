@extends('layout.app')

@section('subtitle', 'Kategori')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Create')

@section('content')
<div class="container-fluid">
  <div class="card card-primary">
    <div class="card-header">
      <h3 class="card-title">Edit Kategori</h3>
    </div>

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
  </div>
</div>
@endsection