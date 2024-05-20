@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">{{ $page->title }}</h3>
    <div class="card-tools"></div>
  </div>
  <div class="card-body">
    @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Ops!</strong> Error <br><br>
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    @empty($penjualan)
    <div class="alert alert-danger alert-dismissible">
      <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
      Data yang Anda cari tidak ditemukan.
    </div>
    <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    @else
    <form method="POST" action="{{ url('/penjualan/'.$penjualan->penjualan_id) }}" class="form-horizontal">
      @csrf
      @method('PUT')
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Barang</label>
        <div class="col-11">
          <select class="form-control select2bs4" id="barang_id" name="barang_id[]" multiple="multiple"
            style="width: 100" required>
            <option value="">- Pilih Barang -</option>
            @foreach($barang as $item)
            @foreach ($penjualanDetail as $detail)
            <option value="{{ $item->barang->barang_id }}" @selected(($detail->barang_id) ==
              ($item->barang->barang_id))>{{ $item->barang->barang_nama
              }}</option>
            @endforeach
            @endforeach
          </select>
          <small>Pilih barang baru</small>
          @error('barang_id')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">User</label>
        <div class="col-11">
          <select class="form-control" id="user_id" name="user_id" required>
            <option value="">- Pilih User -</option>
            @foreach($user as $item)
            <option value="{{ $item->user_id }}" @if($item->user_id ==
              $penjualan->user_id) selected @endif>{{ $item->nama }}</option>
            @endforeach
          </select>
          @error('user_id')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Nama Pembeli</label>
        <div class="col-11">
          <input type="text" class="form-control" id="pembeli" name="pembeli"
            value="{{ old('pembeli', $penjualan->pembeli) }}" required>
          @error('pembeli')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Kode Penjualan</label>
        <div class="col-11">
          <input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode"
            value="{{ old('penjualan_kode', $penjualan->penjualan_kode) }}" required>
          @error('penjualan_kode')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Tanggal Penjualan</label>
        <div class="col-11">
          <input type="date" class="form-control" id="penjualan_tanggal" name="penjualan_tanggal"
            value="{{ old('penjualan_tanggal', date('Y-m-d', strtotime($penjualan->penjualan_tanggal))) }}">
          @error('penjualan_tanggal')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>

      <div class="form-group row">
        <label class="col-1 control-label col-form-label"></label>
        <div class="col-11">
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
          <a class="btn btn-sm btn-default ml-1" href="{{ url('penjualan') 
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
<script>
  $(document).ready(function() {
    $('.select2bs4').select2();
});
</script>
@endpush