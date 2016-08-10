@extends('layouts.master')

@section('title', 'stopwatch')

@section('content')
    {!! Breadcrumbs::render('stopwatch.show', $group, $stopwatch) !!}
    <h1>Stopwatch</h1>
    <h2>slagenteller</h2>
    <div class="stopwatch" data-base3="true"></div>
    <h2>normal</h2>
    <div class="row">
    <div class="col-md-6 col-md-push-6">
        <p class="stopwatch-title">{{ $stopwatch->distance->distance . ' ' . $stopwatch->distance->stroke->name }}
            - {{ $swimmer->first_name . ' ' . $swimmer->last_name }}</p>
        <table class="stopwatch-table">
            <thead>
            <th>zwembad</th>
            <th>persoonlijke records</th>
            </thead>
            <tbody>
            @foreach($records as $record)
                <tr>{!! $record !!}</tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-pull-6 col-md-6">
        <div class="stopwatch center    " data-base3="false" data-user-id="{{ Auth::user()->user_id }}"
             data-stopwatch-id="{{ $stopwatch->id }}"
             data-url="{{ $url }}" data-clock="{{ $clock }}" data-last="{{ $lastTime }}" data-paused="{{ $is_paused }}"
        ></div>
    </div>
    </div>

    <div class="row">
    <div class="col-md-6">
        <span id="splits" class="list-unstyled">
        @foreach($stopwatch->times as $time)
            <li data-time="{{ $time->time }}">
                {{--{{ $time->full_time->toText }}--}}
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



@stop

@section('scripts')


@stop