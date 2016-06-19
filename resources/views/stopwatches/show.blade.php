@extends('layouts.master')

@section('title', 'stopwatch')

@section('content')
    {!! Breadcrumbs::render('stopwatch.show', $group, $stopwatch) !!}
    <h1>Stopwatch</h1>
    <h2>slagenteller</h2>
    <div class="stopwatch" data-base3="true"></div>
    <h2>normal</h2>
    <div class="stopwatch" data-base3="false" data-user-id="{{ Auth::user()->user_id }}"
         data-stopwatch-id="{{ $stopwatch->id }}"
         data-url="{{ $url }}" data-clock="{{ $clock }}" data-last="{{ $lastTime }}" data-paused="{{ $is_paused }}"
    ></div>
    <span id="splits" class="list-unstyled">
        @foreach($stopwatch->times as $time)
            <li data-time="{{ $time->time }}">
                {{--{{ $time->full_time->toText }}--}}
                @foreach($time->full_time->arr as $char)<div class="cell">{{ $char }}</div>@endforeach
                <span class="small">
                @foreach($time->split->arr as $char)<div class="cell">{{ $char }}</div>@endforeach
                </span>
            </li>
        @endforeach
    </span>



@stop

@section('scripts')


@stop