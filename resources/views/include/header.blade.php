<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> MACHINE TEST </title>

    <link rel="stylesheet" href="{{ url('public/assets/css/app.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ url('public/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/bundles/izitoast/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ url('public/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/css/components.css')}}">
    <link rel="stylesheet" href="{{ url('public/assets/bundles/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/bundles/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('public/assets/bundles/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <nav class="navbar navbar-expand-lg main-navbar sticky">
            <div class="navbar-bg"></div>
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
                        <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i data-feather="maximize"></i>
                            </a></li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="{{ url('public/img/user.jpg') }}" class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
                        <div class="dropdown-menu dropdown-menu-right pullDown">
                            <div class="dropdown-title">{{ Auth::user()->name }}</div>
                            <a href="{{ url('profile') }}" class="dropdown-item has-icon"> <i class="far fa-user"></i> Profile </a>
                            <a href="{{url('/logout')}}" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>Logout </a>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{ route('dashboard') }}"> <img alt="image" src="{{ url('public/img/logo.svg') }}" class="header-logo mt-3 ml-n5" /> <span class="logo-name"></span>
                        </a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="{{ request()->routeIs('dashboard') ? 'active bg-primary' : '' }}"><a href="{{ route('dashboard') }}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a></li>
                    </ul>
                </aside>
            </div>