<!doctype html>
<html @auth style="height: auto;" lang="{{ str_replace('_', '-', app()->getLocale()) }}" @endauth>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'DiDrive') }}</title>

    @auth

        {{-- <!-- CSRF Token --> --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <!-- Google Font: Source Sans Pro --> --}}
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        {{-- <!-- Font Awesome --> --}}
        <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
        {{-- <!-- Ionicons --> --}}
        {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
        {{-- <!-- Tempusdominus Bootstrap 4 --> --}}
        <link rel="stylesheet"
            href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
        {{-- <!-- iCheck --> --}}
        {{-- <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"> --}}
        {{-- <!-- JQVMap --> --}}
        {{-- <link rel="stylesheet" href="{{ asset('lte/plugins/jqvmap/jqvmap.min.css') }}"> --}}
        {{-- <!-- Theme style --> --}}
        <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
        {{-- <!-- overlayScrollbars --> --}}
        {{-- <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}"> --}}
        {{-- <!-- Daterange picker --> --}}
        {{-- <link rel="stylesheet" href="{{ asset('lte/plugins/daterangepicker/daterangepicker.css') }}"> --}}
        {{-- <!-- summernote --> --}}
        {{-- <link rel="stylesheet" href="{{ asset('lte/plugins/summernote/summernote-bs4.min.css') }}"> --}}

    @endauth


    @if (1 == 2)

        {{-- <!-- Scripts --> --}}
        {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
        {{-- <!-- Fonts --> --}}
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        {{-- <!-- Styles --> --}}
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="https://kit.fontawesome.com/39007b605f.js" crossorigin="anonymous"></script>

    @endif

    @section('css')
    @show

</head>

<body @auth class="control-sidebar-slide-open layout-fixed layout-navbar-fixed" style="height: auto;" @endauth>

    <div id="app">
        <div class="wrapper">

            {{-- <!-- Preloader --> --}}
            @if (1 == 2)
                <div class="preloader flex-column justify-content-center align-items-center" style="height: 0px;">
                    {{-- <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" style="display: none;" width="60" height="60"> --}}
                    DiDrive
                </div>
            @endif

            @guest
                @yield('content')
            @endguest

            @auth

                {{-- <!-- /.navbar --> --}}
                @include('didrive.app.tops')

                @if (2 == 3)
                    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                        <!-- Left navbar links -->
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                        class="fas fa-bars"></i></a>
                            </li>
                            <li class="nav-item d-none d-sm-inline-block">
                                <a href="index3.html" class="nav-link">Home</a>
                            </li>
                            <li class="nav-item d-none d-sm-inline-block">
                                <a href="#" class="nav-link">Contact</a>
                            </li>
                        </ul>

                        <!-- Right navbar links -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Navbar Search -->
                            <li class="nav-item">
                                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                                    <i class="fas fa-search"></i>
                                </a>
                                <div class="navbar-search-block">
                                    <form class="form-inline">
                                        <div class="input-group input-group-sm">
                                            <input class="form-control form-control-navbar" type="search"
                                                placeholder="Search" aria-label="Search">
                                            <div class="input-group-append">
                                                <button class="btn btn-navbar" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>

                            <!-- Messages Dropdown Menu -->
                            <li class="nav-item dropdown">
                                <a class="nav-link" data-toggle="dropdown" href="#">
                                    <i class="far fa-comments"></i>
                                    <span class="badge badge-danger navbar-badge">3</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                    <a href="#" class="dropdown-item">
                                        <!-- Message Start -->
                                        <div class="media">
                                            <img src="dist/img/user1-128x128.jpg" alt="User Avatar"
                                                class="img-size-50 mr-3 img-circle">
                                            <div class="media-body">
                                                <h3 class="dropdown-item-title">
                                                    Brad Diesel
                                                    <span class="float-right text-sm text-danger"><i
                                                            class="fas fa-star"></i></span>
                                                </h3>
                                                <p class="text-sm">Call me whenever you can...</p>
                                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours
                                                    Ago</p>
                                            </div>
                                        </div>
                                        <!-- Message End -->
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item">
                                        <!-- Message Start -->
                                        <div class="media">
                                            <img src="dist/img/user8-128x128.jpg" alt="User Avatar"
                                                class="img-size-50 img-circle mr-3">
                                            <div class="media-body">
                                                <h3 class="dropdown-item-title">
                                                    John Pierce
                                                    <span class="float-right text-sm text-muted"><i
                                                            class="fas fa-star"></i></span>
                                                </h3>
                                                <p class="text-sm">I got your message bro</p>
                                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours
                                                    Ago</p>
                                            </div>
                                        </div>
                                        <!-- Message End -->
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item">
                                        <!-- Message Start -->
                                        <div class="media">
                                            <img src="dist/img/user3-128x128.jpg" alt="User Avatar"
                                                class="img-size-50 img-circle mr-3">
                                            <div class="media-body">
                                                <h3 class="dropdown-item-title">
                                                    Nora Silvester
                                                    <span class="float-right text-sm text-warning"><i
                                                            class="fas fa-star"></i></span>
                                                </h3>
                                                <p class="text-sm">The subject goes here</p>
                                                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours
                                                    Ago</p>
                                            </div>
                                        </div>
                                        <!-- Message End -->
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                                </div>
                            </li>
                            <!-- Notifications Dropdown Menu -->
                            <li class="nav-item dropdown">
                                <a class="nav-link" data-toggle="dropdown" href="#">
                                    <i class="far fa-bell"></i>
                                    <span class="badge badge-warning navbar-badge">15</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item">
                                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                                        <span class="float-right text-muted text-sm">3 mins</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item">
                                        <i class="fas fa-users mr-2"></i> 8 friend requests
                                        <span class="float-right text-muted text-sm">12 hours</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item">
                                        <i class="fas fa-file mr-2"></i> 3 new reports
                                        <span class="float-right text-muted text-sm">2 days</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                                    <i class="fas fa-expand-arrows-alt"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"
                                    role="button">
                                    <i class="fas fa-th-large"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                @endif

                @include('didrive.app.sidebar')

                {{-- <!-- Content Wrapper. Contains page content --> --}}

                <div class="content-wrapper"
                    style="background-image: url('/img/bg-body.jpg'); background-size: cover; background-position: center center; min-height: 70vh; background-color: rgba(255,255,255,0.3);">
                    {{-- <!-- Content Header (Page header) --> --}}

                    <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    {{-- <h1 class="m-0">Dashboard</h1> --}}
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        {{-- <li class="breadcrumb-item"><a href="#">Home</a></li> --}}
                                        {{-- <li class="breadcrumb-item active">Dashboard v1</li> --}}
                                    </ol>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </div>
                    {{-- <!-- /.content-header --> --}}

                    {{-- <!-- Main content --> --}}

 @section('content')
 @show
 
                </div>
            @endauth

        </div>

    </div>

</body>






@auth
    <script src="{{ asset('js/vue.js?' . date('U')) }}"></script>
@endauth

    {{-- <!-- jQuery --> --}}
    {{-- @guest --}}
<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
    {{-- @endguest --}}


    {{-- <!-- jQuery UI 1.11.4 --> --}}
<script src="{{ asset('lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    {{-- <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip --> --}}
{{-- <script>
    $.widget.bridge('uibutton', $.ui.button)
</script> --}}


@auth

    {{-- <!-- Bootstrap 4 --> --}}
    {{-- <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    {{-- <!-- ChartJS --> --}}
    {{-- <script src="{{ asset('lte/plugins/chart.js/Chart.min.js') }}"></script> --}}
    {{-- <!-- Sparkline --> --}}
    {{-- <script src="{{ asset('lte/plugins/sparklines/sparkline.js') }}"></script> --}}
    {{-- <!-- JQVMap --> --}}
    {{-- <script src="{{ asset('lte/plugins/jqvmap/jquery.vmap.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('lte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script> --}}
    {{-- <!-- jQuery Knob Chart --> --}}
    {{-- <script src="{{ asset('lte/plugins/jquery-knob/jquery.knob.min.js') }}"></script> --}}
    {{-- <!-- daterangepicker --> --}}
    {{-- <script src="{{ asset('lte/plugins/moment/moment.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('lte/plugins/daterangepicker/daterangepicker.js') }}"></script> --}}
    {{-- <!-- Tempusdominus Bootstrap 4 --> --}}
    {{-- <script src="{{ asset('lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script> --}}
    {{-- <!-- Summernote --> --}}
    {{-- <script src="{{ asset('lte/plugins/summernote/summernote-bs4.min.js') }}"></script> --}}
    {{-- <!-- overlayScrollbars --> --}}
    {{-- <script src="{{ asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script> --}}
    {{-- <!-- AdminLTE App --> --}}
    <script src="{{ asset('lte/dist/js/adminlte.js') }}"></script>
    {{-- <!-- AdminLTE for demo purposes --> --}}
    {{-- <script src="{{ asset('lte/dist/js/demo.js') }}"></script> --}}
    {{-- <!-- AdminLTE dashboard demo (This is only for demo purposes) --> --}}
    {{-- <script src="{{ asset('lte/dist/js/pages/dashboard.js') }}"></script> --}}

{{-- <script src="../node_modules/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script> --}}
{{-- <script src="../node_modules/@ckeditor/ckeditor5-vue/dist/ckeditor.js"></script> --}}

{{-- <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script> --}}

{{-- <!-- include summernote css/js--> --}}
{{-- <link href="summernote.css" rel="stylesheet"> --}}
{{-- <script src="summernote.js"></script> --}}

{{-- <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script> --}}
{{-- <script> CKEDITOR.replace( 'editor1' ); </script> --}}
{{-- <script src="https://cdn.ckeditor.com/4.4.5/standard/ckeditor.js"></script> --}}
@endauth


@section('js')
@show

</html>
