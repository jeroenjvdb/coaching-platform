@extends('layouts.master')

@section('title', $swimmer->name . ' profile')

@section('content')
    <h1>{{ $swimmer->first_name }} {{ $swimmer->last_name }}</h1>

    @if(! $hasHeartRate)
        @include('swimmers.show.heartRate') <br>
    @endif

    <button class="btn page" data-page="data">data</button>
    <button class="btn page" data-page="about">about</button>
    <button class="btn page" data-page="PR">PR's</button>
    <button class="btn page" data-page="chrono">chrono</button>
    <button class="btn page" data-page="contact">contact</button>
    <div class="pages">
        <div id="data">
            @include('swimmers.show.data')
        </div>
        <div id="about" hidden>
            @include('swimmers.show.about')
        </div>
        <div id="PR" hidden>
            @include('swimmers.show.PR')
        </div>
        <div id="chrono" hidden>
            @include('swimmers.show.chrono')
        </div>
        <div id="contact" hidden>
            @include('swimmers.show.contact')
        </div>
    </div>



    {{--<div>--}}
    {{--</div>--}}

@stop