<nav class="">
    <ul class="nav sidebar-menu">
        <li {{ Request::is('/') ? ' class=active' : null }}><a rel="external" href="/">{{ $group->name }}</a></li>
{{--        <li {{ Request::is($group->slug ) ? ' class=active' : null }}><a rel="external" href="{{ route('groups.show', [--}}
{{--                        'group' => $group->slug,--}}
{{--                    ]) }}">{{ $group->name }}</a></li>--}}
        <li {{ Request::is($group->slug . '/training*') ? ' class=active' : null }}><a rel="external" href="{{ route('training.index', [
                     ]) }}">Training</a></li>
        {{--<li><a rel="external" href="{{ route('swimmers.index', [--}}
        {{--'group' => $group->slug,--}}
        {{--]) }}"></a></li>--}}
        @if(Auth::user()->clearance_level > 0)
        {{--<li {{ Request::is($group->slug . '/mail*') ? ' class=active' : null }}><a rel="external" href="{{ route('{group}.mail',[
                        'group' => $group->slug,
                    ]) }}">Email</a></li>--}}
        <li {{ Request::is($group->slug . '/stopwatch*') ? ' class=active' : null }}>
            <a rel="external" href="{{ route('stopwatch.index',[
                        'group' => $group->slug,
                    ]) }}">Stopwatch</a></li>
        @endif
        {{--<li {{ Request::is($group->slug . '/gym*') ? ' class=active' : null }}><a rel="external" href="{{ route('{group}.gym.index', [
                        'group' => $group->slug,
                    ]) }}">Gym</a></li>--}}
    </ul>
</nav>

