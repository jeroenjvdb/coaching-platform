@extends('layouts.master')

@section('title', 'alle stopwatches')

@section('content')
    {!! Breadcrumbs::render('{group}.stopwatch.index', $group) !!}
    <h1>Stopwatches</h1>
    <a rel="external" href="{{ route('{group}.stopwatch.create', [
        'group' => $group->slug,
    ]) }}">Aanmaken</a>

    <h2>Slagenteller</h2>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="stopwatch" data-base3="true"></div>
        </div>
    </div>
    <h2>Stopwatch</h2>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="stopwatch" data-base3="false" data-paused="true"></div>
        </div>
    </div>
@stop

