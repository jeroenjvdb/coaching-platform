@extends('layouts.master')

@section('title', $swimmer->name . ' profile')

@section('content')
    <h1>{{ $swimmer->first_name }} {{ $swimmer->last_name }}</h1>

    <button class="btn page" data-page="data">data</button>
    <button class="btn page" data-page="about">about</button>
    <button class="btn page" data-page="PR">PR's</button>
    <button class="btn page" data-page="chrono">chrono</button>
    <button class="btn page" data-page="contact">contact</button>
    <div class="pages">
        <div id="data">
            @include('swimmers.data')
        </div>
        <div id="about" hidden>
            @include('swimmers.about')
        </div>
        <div id="PR" hidden>
            @include('swimmers.PR')
        </div>
        <div id="chrono" hidden>
            @include('swimmers.chrono')
        </div>
        <div id="contact" hidden>
            @include('swimmers.contact')
        </div>
    </div>

    {{--<div>--}}
    {{--</div>--}}

@stop