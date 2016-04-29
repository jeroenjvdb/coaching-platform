@extends('layouts.master')

@section('title', $swimmer->name . ' profile')

@section('content')
    <h1>{{ $swimmer->first_name }} {{ $swimmer->last_name }}</h1>

    <button class="btn page" data-page="about">about</button>
    <button class="btn page" data-page="PR">PR's</button>
    <button class="btn page" data-page="chrono">chrono</button>
    <button class="btn page" data-page="contact">contact</button>
    <div class="pages">
        <div id="about">
            @include('swimmers.about')
        </div>
        <div id="PR">
            @include('swimmers.PR')
        </div>
        <div id="chrono">
            @include('swimmers.chrono')
        </div>
        <div id="contact">
            @include('swimmers.contact')
        </div>
    </div>

    {{--<div>--}}
    {{--</div>--}}

@stop