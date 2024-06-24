@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">{{ $page->title }}</h3>
    <div class="card-tools"></div>
  </div>
  <div class="card-body">
    @empty($userEdit)
    <div class="alert alert-danger alert-dismissible">
      <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
      Data yang Anda cari tidak ditemukan.
    </div>
    <a href="{{ url('user') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    @else
    <form method="POST" action="{{ url('/user/'.$userEdit->user_id) }}" class="form-horizontal"
      enctype="multipart/form-data">
      @csrf
      {!! method_field('PUT') !!}
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Level</label>
        <div class="col-11">
          <select class="form-control" id="level_id" name="level_id" required>
            <option value="">- Pilih Level -</option>
            @foreach($level as $item)
            <option value="{{ $item->level_id }}" @if($item->level_id ==
              $userEdit->level_id) selected @endif>{{ $item->level_nama }}</option>
            @endforeach
          </select>
          @error('level_id')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Nama</label>
        <div class="col-11">
          <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $userEdit->nama) }}"
            required>
          @error('nama')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Alamat</label>
        <div class="col-11">
          <input type="text" class="form-control" id="alamat" name="alamat"
            value="{{ old('alamat', $userEdit->alamat) }}" required>
          @error('alamat')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">No KTP</label>
        <div class="col-11">
          <input type="text" class="form-control" id="no_ktp" name="no_ktp"
            value="{{ old('no_ktp', $userEdit->no_ktp) }}" required>
          @error('no_ktp')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">No Telp</label>
        <div class="col-11">
          <input type="text" class="form-control" id="no_telp" name="no_telp"
            value="{{ old('no_telp', $userEdit->no_telp) }}" required>
          @error('no_telp')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Username</label>
        <div class="col-11">
          <input type="text" class="form-control" id="username" name="username"
            value="{{ old('username', $userEdit->username) }}" required>
          @error('username')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Password</label>
        <div class="col-11">
          <input type="password" class="form-control" id="password" name="password">
          @error('password')
          <small class="form-text text-danger">{{ $message }}</small>
          @else
          <small class="form-text text-muted">Abaikan (jangan diisi) jika
            tidak ingin mengganti password user.</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Gambar Profile</label>
        <div class="col-11">
          <input type="file" class="form-control" id="nama" name="profile_img" value="{{ old('profile_img') }}">
          @error('profile_img')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label"></label>
        <div class="col-11">
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
          <a class="btn btn-sm btn-default ml-1" href="{{ url('user') 
}}">Kembali</a>
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