<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{config('app.name'), 'PWL Laravel Starter Code'}}</title>

  <meta name="csrf-token" content="{{csrf_token()}}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('adminLte/plugins/fontawesome-free/css/all.min.css')}}">

  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('adminLte/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('adminLte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

  {{-- DataTables --}}
  <link rel="stylesheet" href="{{asset('adminLte/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
  <link rel="stylesheet" href="{{asset('adminLte/plugins/datatables-responsive/css/responsive.bootstrap4.css')}}">
  <link rel="stylesheet" href="{{asset('adminLte/plugins/datatables-buttons/css/buttons.bootstrap4.css')}}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminLte/dist/css/adminlte.min.css')}}">

  @stack('css')
</head>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    @include('layouts.header')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{url('/')}}" class="brand-link">
        <img src="{{asset('adminLte/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
          class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">PWL - Starter Code</span>
      </a>

      <!-- Sidebar -->
      @include('layouts.sidebar')
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      @include('layouts.breadcrumb')

      <!-- Main content -->
      @yield('content')
      <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->

    @include('layouts.footer')
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{asset('adminLte/plugins/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('adminLte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  {{-- Datatables & Plugins --}}
  <script src="{{asset('adminLte/plugins/datatables/jquery.dataTables.js')}}"></script>
  <script src="{{asset('adminLte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('adminLte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('adminLte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
  <script src="{{asset('adminLte/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('adminLte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{asset('adminLte/plugins/jszip/jszip.js')}}"></script>
  <script src="{{asset('adminLte/plugins/pdfmake/pdfmake.js')}}"></script>
  <script src="{{asset('adminLte/plugins/pdfmake/vfs_fonts.js')}}"></script>
  <script src="{{asset('adminLte/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{asset('adminLte/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{asset('adminLte/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
  {{-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script> --}}
  <!-- AdminLTE App -->
  <script src="{{asset('adminLte/dist/js/adminlte.min.js')}}"></script>
  <!-- Select2 -->
  <script src="{{asset('adminLte/plugins/select2/js/select2.full.min.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="{{asset('adminLte/dist/js/demo.js')}}"></script>
  <script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
  </script>
  @stack('js')
</body>

</html>