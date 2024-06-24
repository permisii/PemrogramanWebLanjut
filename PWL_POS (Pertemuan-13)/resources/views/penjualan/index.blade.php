@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">{{ $page->title }}</h3>
    <div class="card-tools">
      @if (auth()->user()->level->level_nama != 'Member')
      <a class="btn btn-sm btn-primary mt-1" href="{{ url('penjualan/create') 
}}">Tambah</a>
      @endif
    </div>
  </div>
  <div class="card-body">
    @if (session('success'))
    <div class="alert alert-success">{{session('success')}}</div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
    @endif
    @if (auth()->user()->level->level_nama == 'Administrator' || auth()->user()->level->level_nama == 'Manager')
    <div class="chart-wrapper container-fluid">
      {!! $chart->container() !!}
    </div>
    <div class="chart-wrapper container-fluid mt-3">
      {!! $forecastingChart->container() !!}
    </div>
    @endif
    @if (auth()->user()->level->level_nama != 'Member')
    <div class="row">
      <div class="col-md-12">
        <div class="form-group row">
          <label class="col-1 control-label col-form-label">Filter User :</label>
          <div class="col-3">
            <select name="user_id" required id="user_id" class="form-control">
              <option value="">- Semua -</option>
              @foreach ($user as $item)
              <option value="{{$item->user_id}}">{{$item->nama}}</option>
              @endforeach
            </select>
            <small class="form-text text-muted">User</small>
          </div>
        </div>
      </div>
    </div>
    @endif

    <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
      <thead>
        <tr>
          <th>ID</th>
          <th>Kode Penjualan</th>
          <th>Nama User</th>
          <th>Nama Pembeli</th>
          <th>Tanggal Penjualan</th>
          <th>Total Penjualan (Rp)</th>
          <th>Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection
@push('css')
@endpush
@push('js')
<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}
<script src="{{ $forecastingChart->cdn() }}"></script>
{{ $forecastingChart->script() }}
<script>
  $(document).ready(function() {
    var dataPenjualan = $('#table_penjualan').DataTable({
    serverSide: true, // serverSide: true, jika ingin menggunakan server side processing
    ajax: {
    "url": "{{ url('penjualan/list') }}",
    "dataType": "json",
    "type": "GET",
    "data": function(d) {
      d.user_id = $('#user_id').val();
    }
    },
    columns: [
    {
    data: "penjualan_id", // nomor urut dari laravel datatable addIndexColumn()
    className: "text-center",
    orderable: false,
    searchable: false
    },{
    data: "penjualan_kode", 
    className: "",
    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
    },{
    data: "nama", 
    className: "",
    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
    searchable: true // searchable: true, jika ingin kolom ini bisa dicari
    },{
    data: "pembeli", 
    className: "",
    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
    searchable: true // searchable: true, jika ingin kolom ini bisa dicari
    },{
    data: "penjualan_tanggal", 
    className: "",
    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
    },
    {
  data: "total", 
    className: "",
    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
    },
    {
    data: "aksi", 
    className: "",
    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
    },
    ],
    });


    $('#user_id').on('change', function() {
      dataPenjualan.ajax.reload();
    });
});
</script>
@endpush