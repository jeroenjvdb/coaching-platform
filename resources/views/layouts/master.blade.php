<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}">

    <title>@yield('title') | iCoach</title>

    <link rel="manifest" href="/manifest.json">
    <meta name="viewport" content="width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="400x400" href="/icon.png">


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    {{--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">--}}

    <link href="/resources/css/adminLTE.css" rel="stylesheet">
    <link href="/resources/css/skin.css" rel="stylesheet">
    <link href="/resources/css/main.css" rel="stylesheet">

    @yield('style')
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout" class="skin-red">
<div class="wrapper">
    <header class="main-header">
        {{--<div class="header-content">--}}
        <a class="logo" href="{{ url('/') }}">
            iCoach
        </a>
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <ul class="nav navbar-nav navbar-right pull-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a rel="external" href="{{ url('/login') }}">Login</a></li>
                    <li><a rel="external" href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a rel="external" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a rel="external" href="{{ url('/logout') }}"><i
                                            class="fa fa-btn fa-sign-out"></i>uitloggen</a></li>
                            <li><a href="{{ route('auth.password.update') }}">
                                    <i class="fa fa-key"></i> wachtwoord wijzigen
                                </a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
        {{--</div>--}}
    </header>
    <aside class="main-sidebar control-sidebar-dark">
        <section class="sidebar">
            @include('includes.nav')
        </section>
    </aside>
    <div class="control-sidebar-bg"></div>
    <div class="content-wrapper">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>

    @yield('right')

    @include('includes.footer')
</div>
</body>
</html>
