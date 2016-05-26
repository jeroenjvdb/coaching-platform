<nav class="">
    {{--<div class="container">--}}
        {{--<div class="navbar-header">--}}

            <!-- Collapsed Hamburger -->
            {{--<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">--}}
                {{--<span class="sr-only">Toggle Navigation</span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
                {{--<span class="icon-bar"></span>--}}
            {{--</button>--}}

            <!-- Branding Image -->
            {{--<a class="navbar-brand" href="{{ url('/') }}">--}}
                {{--iCoach--}}
            {{--</a>--}}
        {{--</div>--}}

        {{--<div class="collapse navbar-collapse" id="app-navbar-collapse">--}}
            <!-- Left Side Of Navbar -->
            <ul class="nav sidebar-menu">
                <li><a rel="external" href="/">Home</a></li>
                <li><a rel="external" href="{{ route('groups.show', [
                        'group' => $group->slug,
                    ]) }}">{{ $group->name }}</a></li>
                <li><a rel="external" href="{{ route('trainings.index', [
                            'group' => $group->slug,
                     ]) }}">training</a></li>
                {{--<li><a rel="external" href="{{ route('swimmers.index', [--}}
                        {{--'group' => $group->slug,--}}
                    {{--]) }}"></a></li>--}}
                <li><a rel="external" href="{{ route('chat.index',[
                        'group' => $group->slug,
                    ]) }}">chat</a></li>
                <li><a rel="external" href="{{ route('stopwatches.index',[
                        'group' => $group->slug,
                    ]) }}">stopwatch</a></li>
                <li><a rel="external" href="{{ route('gyms.index', [
                        'group' => $group->slug,
                    ]) }}">gym</a></li>
            </ul>

            <!-- Right Side Of Navbar -->

        {{--</div>--}}
    {{--</div>--}}
</nav>

