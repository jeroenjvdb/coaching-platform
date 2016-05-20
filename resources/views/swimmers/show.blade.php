@extends('layouts.master')

@section('title', $swimmer->name . ' profile')

@section('content')
    {!! Breadcrumbs::render('swimmer', $group, $swimmer) !!}
    <button id="data" class="btn btn-page" data-page="data">data</button>
    <button id="about" class="btn btn-page" data-page="about">about</button>
    <button id="PR" class="btn btn-page" data-page="PR">PR's</button>
    <button id="chrono" class="btn btn-page" data-page="chrono">chrono</button>
    <button id="contact" class="btn btn-page" data-page="contact">contact</button>

    <h1>{{ $swimmer->first_name }} {{ $swimmer->last_name }}</h1>

    @if(! $hasHeartRate)
        @include('swimmers.show.heartRate') <br>
    @endif


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