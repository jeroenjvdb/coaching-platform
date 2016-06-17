<!DOCTYPE html>
<html lang="en">
@include('includes.head')
<body id="app-layout" class="skin-red">
<div class="wrapper">
    <header class="main-header">
        {{--<div class="header-content">--}}
        <a class="logo" href="{{ url('/') }}">
            <img src="/resources/img/launcher-icon-4x.png" alt="">
            {{ config('app.name') }}
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
                                            class="fa fa-btn fa-sign-out"></i> Uitloggen</a></li>
                            <li><a href="{{ route('auth.password.update') }}">
                                    <i class="fa fa-key"></i> Wachtwoord wijzigen
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
