<aside class="main-sidebar elevation-4 sidebar-light-warning">
    {{-- <!-- Brand Logo --> --}}
    <a href="/" class="brand-link text-center">
        {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                        style="opacity: .8"> --}}
        {{-- <span class="brand-text font-weight-light">AdminLTE 3</span> --}}
        <span class="brand-text font-weight-light">DiDrive</span>
    </a>

    <!-- Sidebar -->
    <div
        class="sidebar os-host os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition os-theme-dark os-host-scrollbar-vertical-hidden">
        <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
        </div>
        <div class="os-size-auto-observer observed" style="height: calc(100%); float: left;">
            <div class="os-resize-observer"></div>
        </div>
        {{-- <div class="os-content-glue" style="margin: 0px -8px; height: 1359px; width: 249px;"></div> --}}
        <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="">
                <div class="os-content" style="padding: 0px 8px; height: auto; width: 100%;">

                    {{-- <!-- Sidebar user panel (optional) --> --}}
                    @if (1 == 2)
                        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                            <div class="image">
                                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                            </div>
                            <div class="info">
                                <a href="#" class="d-block">Alexander Pierce</a>
                            </div>
                        </div>
                    @endif

                    {{-- <!-- SidebarSearch Form --> --}}
                    @if (1 == 2)
                        <div class="form-inline">
                            <div class="input-group" data-widget="sidebar-search">
                                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-sidebar">
                                        <i class="fas fa-search fa-fw"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="sidebar-search-results">
                                <div class="list-group"><a href="#" class="list-group-item">
                                        <div class="search-title"><strong class="text-light"></strong>N<strong
                                                class="text-light"></strong>o<strong
                                                class="text-light"></strong> <strong
                                                class="text-light"></strong>e<strong
                                                class="text-light"></strong>l<strong
                                                class="text-light"></strong>e<strong
                                                class="text-light"></strong>m<strong
                                                class="text-light"></strong>e<strong
                                                class="text-light"></strong>n<strong
                                                class="text-light"></strong>t<strong
                                                class="text-light"></strong> <strong
                                                class="text-light"></strong>f<strong
                                                class="text-light"></strong>o<strong
                                                class="text-light"></strong>u<strong
                                                class="text-light"></strong>n<strong
                                                class="text-light"></strong>d<strong
                                                class="text-light"></strong>!<strong
                                                class="text-light"></strong></div>
                                        <div class="search-path"></div>
                                    </a></div>
                            </div>
                        </div>
                    @endif

                    {{-- <!-- Sidebar Menu --> --}}
                    @if (1 == 1)

                        @if (1 == 2)
                            <li class="nav-item">
                                <a href="pages/widgets.html" class="nav-link">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Widgets
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        @endif

                        {{-- <app-menu></app-menu> --}}
                        <router-view name="leftMenu"></router-view>

                        @if (1 == 2)
                            <li class="nav-item">
                                <a href="pages/widgets.html" class="nav-link">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Widgets
                                        <span class="right badge badge-danger">New</span>
                                    </p>
                                </a>
                            </li>
                        @endif

                    @endif
                    {{-- <!-- /.sidebar-menu --> --}}

                </div>
            </div>
        </div>

        <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px);"></div>
            </div>
        </div>

        <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="height: 100%; transform: translate(0px);"></div>
            </div>
        </div>

        <div class="os-scrollbar-corner"></div>

    </div>
    {{-- <!-- /.sidebar --> --}}
</aside>



{{-- <a href="{{ route('modules.index') }}" class="item">Модули</a>

<a href="{{ route('sites') }}" class="item">Сайты</a>

<div style="padding-left: 20px;">

    <div class="bg-info">
        Модули
    </div>

    @section('menu_modules')
    @show

</div> --}}
