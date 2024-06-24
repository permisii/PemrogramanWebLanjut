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
    <form method="POST" action="{{ url('penjualan') }}" class="form-horizontal">
      @csrf
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Barang</label>
        <div class="col-11">
          <select class="select2bs4 form-control" name="barang_id[]" multiple="multiple" data-placeholder="Pilih Barang"
            style="width: 100">
            <option value="">- Pilih Barang -</option>
            @foreach($barang as $item)
            <option value="{{ $item->barang->barang_id }}" @if(old('barang_id')==$item->barang->barang_id) selected
              @endif>{{
              $item->barang->barang_nama.' : Rp.'.$item->barang->harga_jual
              }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">User</label>
        <div class="col-11">
          <select class="form-control" id="user_id" name="user_id" required>
            <option value="">- Pilih User -</option>
            @foreach($user as $item)
            <option value="{{ $item->user_id }}">{{ $item->nama
              }}</option>
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
          <input type="text" class="form-control" id="pembeli" name="pembeli" value="{{ old('pembeli') }}" required>
          @error('pembeli')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Kode Penjualan</label>
        <div class="col-11">
          <input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode"
            value="{{ old('penjualan_kode') }}" required>
          @error('penjualan_kode')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Tanggal Penjualan</label>
        <div class="col-11">
          <input type="date" class="form-control" id="penjualan_tanggal" name="penjualan_tanggal"
            value="{{ old('penjualan_tanggal') }}" required>
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