@php
  $shop_name = 'APP';
  $setting = \App\Setting::first();
  if ($setting && $setting->shop_name) {
    $shop_name = $setting->shop_name;
  }
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="generator" content="Jekyll v4.1.1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $shop_name }} | @yield('title')</title>

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('public/assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('public/assets/dashboard/dashboard.css') }}" rel="stylesheet">

  <!-- Fontawesome CSS -->
  <link href="{{ asset('public/assets/fontawesome/css/all.min.css') }}" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  <!-- Custom styles for this template -->
  <link href="dashboard.css" rel="stylesheet">

  @yield('css')
</head>
<body>
  <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="{{ url('/') }}">{{ $shop_name }}</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a class="nav-link text-white" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          {{ __('Logout') }}
        </a>
      </li>
    </ul>
  </nav>

  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
      @csrf
  </form>

  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="sidebar-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link {{Request::segment(1)=='home'?'active':''}}" href="{{ route('home') }}">
                <i class="fas fa-tv mr-1"></i> Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{Request::segment(1)=='category'?'active':''}}" href="{{ route('category.index') }}">
                <i class="fas fa-boxes mr-1"></i> Categories
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{Request::segment(1)=='product'?'active':''}}" href="{{ route('product.index') }}">
                <i class="fas fa-shopping-cart mr-1"></i> Products
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{Request::segment(1)=='setting'?'active':''}}" href="{{ route('setting.index') }}">
                <i class="fas fa-cog mr-1"></i> Settings
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out-alt mr-1"></i> Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </li>
          </ul>

          <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Saved reports</span>
          </h6>

          <ul class="nav flex-column mb-2">
            <li class="nav-item">
              <a class="nav-link {{Request::segment(1)=='order'&&Request::segment(2)=='show'?'active':''}}" href="{{ route('order.show') }}">
                <i class="fas fa-list mr-1"></i> Reports List
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{Request::segment(1)=='order'&&Request::segment(2)=='create'?'active':''}}" href="{{ route('order.create') }}">
                <i class="fas fa-file-medical mr-1"></i> Create Report
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{Request::segment(1)=='order'&&Request::segment(2)=='search'?'active':''}}" href="{{ route('order.search.report') }}">
                <i class="fas fa-search mr-1"></i> Search Report
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{Request::segment(1)=='order'&&Request::segment(2)=='month'?'active':''}}" href="{{ route('order.month.report') }}">
                <i class="fas fa-file-alt mr-1"></i> Monthly Report
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{Request::segment(1)=='order'&&Request::segment(2)=='year'?'active':''}}" href="{{ route('order.year.report') }}">
                <i class="fas fa-file-alt mr-1"></i> Yearly Report
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        @yield('content')
      </main>
    </div>
  </div>
  <script src="{{ asset('public/assets/bootstrap/js/jquery.min.js') }}"></script>
  <script src="{{ asset('public/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  @yield('js')
</body>
</html>
