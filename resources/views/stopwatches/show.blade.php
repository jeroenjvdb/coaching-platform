@extends('layouts.master')

@section('title', 'stopwatch')

@section('content')
    <div class="row">
        <h1>Stopwatch</h1>
        <h2>slagenteller</h2>
    </div>
    <div class="row">
        <div class="stopwatch" data-base3="true"></div>
    </div>
    <h2>normal</h2>
    <div class="row">
        @include('stopwatches.individual')
    </div>



@stop

@section('scripts')


@stop