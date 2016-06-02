<nav class="">
    <ul class="nav sidebar-menu">
        <li {{ Request::is('/') ? ' class=active' : null }}><a rel="external" href="/">Home</a></li>
        <li {{ Request::is($group->slug ) ? ' class=active' : null }}><a rel="external" href="{{ route('groups.show', [
                        'group' => $group->slug,
                    ]) }}">{{ $group->name }}</a></li>
        <li {{ Request::is($group->slug . '/training*') ? ' class=active' : null }}><a rel="external" href="{{ route('{group}.training.index', [
                            'group' => $group->slug,
                     ]) }}">training</a></li>
        {{--<li><a rel="external" href="{{ route('swimmers.index', [--}}
        {{--'group' => $group->slug,--}}
        {{--]) }}"></a></li>--}}
        <li {{ Request::is($group->slug . '/chat*') ? ' class=active' : null }}><a rel="external" href="{{ route('chat.index',[
                        'group' => $group->slug,
                    ]) }}">chat</a></li>
        <li {{ Request::is($group->slug . '/stopwatch*') ? ' class=active' : null }}>
            <a rel="external" href="{{ route('{group}.stopwatch.index',[
                        'group' => $group->slug,
                    ]) }}">stopwatch</a></li>
        <li {{ Request::is($group->slug . '/gym*') ? ' class=active' : null }}><a rel="external" href="{{ route('gyms.index', [
                        'group' => $group->slug,
                    ]) }}">gym</a></li>
    </ul>
</nav>

