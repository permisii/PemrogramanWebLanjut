@extends('layouts.template')

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Home</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
        @endif
        @if (auth()->user()->level->level_nama != 'Member')
        <div class="chart-wrapper container-fluid">
            {!! $chart->container() !!}
        </div>
        <div class="table-wrapper container-fluid">
            <div class="title">
                <strong>List Member</strong>
            </div>
            <div class="btn-wrapper d-flex justify-content-end mb-3">
                <a href="{{route('member.export.pdf')}}" class="btn btn-danger mr-2">Export PDF <i
                        class="ml-1 far fa-file-pdf"></i></a>
                <a href="{{route('member.export.excel')}}" class="btn btn-success">Export Excel <i
                        class="ml-1 far fa-file-excel"></i></a>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Level</th>
                        <th>Status Validasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        @else
        <table class="table table-bordered table-striped table-hover table-sm">
            <tr>
                <th>ID</th>
                <td>{{ auth()->user()->user_id }}</td>
            </tr>
            <tr>
                <th>Username</th>
                <td>{{ auth()->user()->username }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ auth()->user()->nama }}</td>
            </tr>
            <tr>
                <th>Level</th>
                <td>{{ auth()->user()->level->level_nama }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ auth()->user()->status == 1 ? 'Validate' : 'Unvalidate' }}</td>
            </tr>
            <tr>
                <th>Foto Profil</th>
                <td><img src="{{asset('storage/profile/'.auth()->user()->profile_img)}}" class=" "></td>
            </tr>

        </table>
        @endif
    </div>
</div>

@endsection
@push('css')
@endpush
@push('js')
<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}
<script>
    $(document).ready(function() {
    var dataUser = $('#table_user').DataTable({
    serverSide: true, // serverSide: true, jika ingin menggunakan server side processing
    ajax: {
    "url": "{{ url('member/list') }}",
    "dataType": "json",
    "type": "POST",
    "data": function(d) {
      d.level_id = $('#level_id').val();
    },
    },

    columns: [
    {
    data: "DT_RowIndex", // nomor urut dari laravel datatable addIndexColumn()
    className: "text-center",
    orderable: false,
    searchable: false
    },{
    data: "username", 
    className: "",
    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
    searchable: true // searchable: true, jika ingin kolom ini bisa dicari
    },{
    data: "nama", 
    className: "",
    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
    searchable: true // searchable: true, jika ingin kolom ini bisa dicari
    },{
    data: "level.level_nama", 
    className: "",
    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
    },{
        data: "status", 
    className: "",
    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
    },{
    data: "aksi", 
    className: "",
    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
    }
    ]
    });

    $('#level_id').on('change', function() {
      dataUser.ajax.reload()
    });
});
</script>
@endpush