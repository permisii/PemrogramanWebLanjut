<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    {{-- <li class="nav-item d-none d-sm-inline-block">
      <a href="{{asset('adminLte/index3.html')}}" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
    </li> --}}
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    @if (auth()->user()->level->level_nama == 'Administrator' || auth()->user()->level->level_nama == 'Admin')
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        @if ($user->where('status', false)->count() > 0)
        <span class="badge badge-warning navbar-badge">{{$user->where('status', false)->count() > 0}}</span>
        @endif
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">User Validation Notifications</span>
        <div class="dropdown-divider"></div>
        <div class="dropdown-divider"></div>
        <a href="{{route('home.index')}}" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> {{$user->where('status', false)->count()}} User Unvalidate
        </a>
        <a href="{{route('user.index')}}" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> {{$user->where('status', true)->count()}} User Validated
        </a>
      </div>
    </li>
    @endif
  </ul>
</nav>