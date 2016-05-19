@extends('layouts.master')

@section('title')
@stop

@section('content')
    <h1>stopwatches</h1>
    <a rel="external" href="{{ route('stopwatches.create', [
        'group' => $group->slug,
    ]) }}">create</a>
    <h2>base 3</h2>
    <div class="stopwatch" data-base3="true"></div>
@stop

