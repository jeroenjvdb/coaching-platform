@extends('layouts.master')

@section('title', $swimmer->name . ' profile')

@section('content')
    <h1>{{ $swimmer->first_name }} {{ $swimmer->last_name }}</h1>

    @if(! $hasHeartRate)
        @include('swimmers.show.heartRate') <br>
    @endif

    <button class="btn btn-page" data-page="data">data</button>
    <button class="btn btn-page" data-page="about">about</button>
    <button class="btn btn-page" data-page="PR">PR's</button>
    <button class="btn btn-page" data-page="chrono">chrono</button>
    <button class="btn btn-page" data-page="contact">contact</button>
    <div class="pages">
        <div id="data" class="page" data-next="about">
            @include('swimmers.show.data')
        </div>
        <div id="about" class="page" data-next="PR" data-previous="data" hidden>
            @include('swimmers.show.about')
        </div>
        <div id="PR" class="page" data-next="chrono" data-previous="about" hidden>
            @include('swimmers.show.PR')
        </div>
        <div id="chrono" class="page" data-next="contact" data-previous="PR" hidden>
            @include('swimmers.show.chrono')
        </div>
        <div id="contact" class="page" data-previous="chrono" hidden>
            @include('swimmers.show.contact')
        </div>
    </div>



    {{--<div>--}}
    {{--</div>--}}

@stop