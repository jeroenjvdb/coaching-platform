{{--<div class="col-md-pull-6 col-md-6">--}}
<div class="row">
    <div class="stopwatch center    " data-base3="false" data-user-id="{{ Auth::user()->user_id }}"
         data-stopwatch-id="{{ $stopwatch->id }}"
         data-url="{{ $stopwatch->url }}" data-clock="{{ $stopwatch->clock }}" data-last="{{ $stopwatch->lastTime }}" data-paused="{{ $stopwatch->is_paused }}"
         data-records="{{ $stopwatch->recordsUrl }}"
    ></div>
</div>
{{--</div>--}}

<div class="row">
    <div class="col-sm-6">
        <span id="splits" class="list-unstyled">
        @foreach($stopwatch->times as $time)
            <li data-time="{{ $time->time }}">
                @foreach($time->full_time->arr as $char)<div class="cell">{{ $char }}</div>@endforeach
                <br>
                <span class="small">
                @foreach($time->split->arr as $char)<div class="cell">{{ $char }}</div>@endforeach
                </span>
            </li>
            @endforeach
            </span>
    </div>
</div>