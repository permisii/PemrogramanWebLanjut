@extends('layout.app')

@section('subtitle', 'User')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Create User')

@section('content')
<div class="container-fluid">
  <div class="row mt-5 mb-5">
    <div class="col-lg-12 margin-tb">
      <div class="float-left">
        <h2>Membuat Daftar User</h2>
      </div>
      <div class="float-right">
        <a class="btn btn-secondary" href="{{ route('m_user.index') }}">
          Kembali</a>
      </div>
    </div>
  </div>
  @if ($errors->any())
  <div class="alert alert-danger">
    <strong>Ops</strong> Input gagal<br><br>
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <form action="{{ route('m_user.store') }}" method="POST">
    @csrf
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
        <strong>Level Id:</strong>
        <select class="form-control select2bs4 @error('level_id') is-invalid @enderror" name="level_id"
          style="width: 100%;">
          @foreach ($level_id as $id)
          <option value="{{$id->level_id}}">{{$id->level_nama}}</option>
          @endforeach
        </select>
        @error('level_id')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group">
        <strong>Username:</strong>
        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
          placeholder="Masukkan username"></input>
      </div>
      @error('username')
      <div class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
        <strong>nama:</strong>
        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
          placeholder="Masukkan nama"></input>
      </div>
      @error('nama')
      <div class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
        <strong>Password:</strong>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
          placeholder="Masukkan password"></input>
      </div>
      @error('password')
      <div class="alert alert-danger">{{ $message }}</div>
      @enderror
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</form>
</div>
@endsection