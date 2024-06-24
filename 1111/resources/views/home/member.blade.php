@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">{{ $page->title }}</h3>
    <div class="card-tools"></div>
  </div>
  <div class="card-body">
    @empty($member)
    <div class="alert alert-danger alert-dismissible">
      <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
      Data yang Anda cari tidak ditemukan.
    </div>
    @else
    <table class="table table-bordered table-striped table-hover table-sm">
      <tr>
        <th>ID</th>
        <td>{{ $member->user_id }}</td>
      </tr>
      <tr>
        <th>Nama</th>
        <td>{{ $member->nama }}</td>
      </tr>
      <tr>
      <tr>
        <th>Username</th>
        <td>{{ $member->username }}</td>
      </tr>
      <tr>
      <tr>
        <th>Level</th>
        <td>{{ $member->level->level_nama}}</td>
      </tr>
      <tr>
        <th>Status</th>
        <td>{{ auth()->user()->status == 1 ? 'Validate' : 'Unvalidate' }}</td>
      </tr>
      <tr>
      <tr>
        <th>Foto Profil</th>
        <td><img src="{{asset('storage/profile/'.$member->profile_img)}}" class=" "></td>
      </tr>

    </table>
    @endempty
    <a href="{{route('home.index')}}" class="btn btn-sm btn-default mt-2">Kembali</a>
  </div>
</div>
@endsection
@push('css')
@endpush
@push('js')
@endpush