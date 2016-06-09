@extends('layouts.master')

@section('title', 'alle stopwatches')

@section('content')
    {!! Breadcrumbs::render('{group}.stopwatch.index', $group) !!}
    <h1>stopwatches</h1>
    <a rel="external" href="{{ route('{group}.stopwatch.create', [
        'group' => $group->slug,
    ]) }}">create</a>
    <h2>base 3</h2>
    <div class="stopwatch" data-base3="true"></div>
@stop

