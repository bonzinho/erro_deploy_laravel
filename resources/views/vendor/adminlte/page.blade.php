@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        @if(\Illuminate\Support\Facades\Auth::user()->role == \App\Entities\Client::ROLE)
                            <a href="{{ url(config('adminlte.dashboard_url_client', 'home')) }}" class="navbar-brand">
                                {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                            </a>
                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == \App\Entities\Collaborator::ROLE)
                            <a href="{{ url(config('adminlte.dashboard_url_collaborator', 'home')) }}" class="navbar-brand">
                                {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                            </a>
                            @elseif(\Illuminate\Support\Facades\Auth::user()->role == \App\Entities\Admin::ROLE)
                            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                                {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                            </a>
                        @endif
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
                @if(\Illuminate\Support\Facades\Auth::user()->role == \App\Entities\Client::ROLE)
                    <a href="{{ url(config('adminlte.dashboard_url_client', 'home')) }}" class="logo">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
                    </a>
                @elseif(\Illuminate\Support\Facades\Auth::user()->role == \App\Entities\Collaborator::ROLE)
                    <a href="{{ url(config('adminlte.dashboard_url_collaborator', 'home')) }}" class="logo">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
                    </a>
                @elseif(\Illuminate\Support\Facades\Auth::user()->role == \App\Entities\Admin::ROLE)
                    <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
                    </a>
                @endif
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">

                    <ul class="nav navbar-nav">
                        <li>
                            @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                teste
                                <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                            @else
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    @if(auth()->guard(\App\Entities\Admin::ROLE)->check() )
                                        <img src="{{asset('images/profile_pic_default.png')}}" class="user-image" alt="Admin">
                                    @elseif(auth()->guard(\App\Entities\Client::ROLE)->check())
                                        <img src="{{asset('images/profile_client_default.png')}}" class="user-image" alt="Client">
                                    @else
                                        <img src="{{asset('storage/'.auth()->user()->photo)}}" class="user-image" alt="Collaborator">
                                    @endif
                                    <span class="hidden-xs">{{auth()->user()->name}}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        @if(auth()->guard(\App\Entities\Admin::ROLE)->check() )
                                            <img src="{{asset('images/profile_pic_default.png')}}" class="img-circle" alt="Admin">
                                            @elseif(auth()->guard(\App\Entities\Client::ROLE)->check())
                                            <img src="{{asset('images/profile_client_default.png')}}" class="img-circle" alt="Client">
                                            @else
                                            <img src="{{asset('storage/'.auth()->user()->photo)}}" class="img-circle" alt="Collaborator">
                                        @endif
                                        <p>
                                            {{auth()->user()->name}}
                                            <!--<small>Member since Nov. 2012</small> -->
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="#" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >
                                                <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                                @if(\Illuminate\Support\Facades\Auth::user()->role == \App\Entities\Client::ROLE)
                                    <form id="logout-form" action="{{ url(config('adminlte.logout_url_client')) }}" method="POST" style="display: none;">
                                        @elseif(\Illuminate\Support\Facades\Auth::user()->role == \App\Entities\Collaborator::ROLE)
                                            <form id="logout-form" action="{{ url(config('adminlte.logout_url_collaborator')) }}" method="POST" style="display: none;">
                                                @else
                                                    <form id="logout-form" action="{{ url(config('adminlte.logout_url')) }}" method="POST" style="display: none;">
                                                        @endif

                                        @if(config('adminlte.logout_method'))
                                            {{ method_field(config('adminlte.logout_method')) }}
                                        @endif
                                        {{ csrf_field() }}
                                    </form>

                            @endif
                        </li>
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
