@extends('layouts.master')

@section('title', $swimmer->name . ' profile')

@section('content')
    <div class="nav-tabs-custom">
        <ul class="btn-pages nav-tabs nav">
            {{--<li id="data" class="btn btn-page active" data-page="data">data</li><!----}}
            <li id="about" class="btn btn-page active" data-page="about">about</li><!--
            -->
            <li id="PR" class="btn btn-page" data-page="PR">besttijden</li><!--
            -->
            <li id="chrono" class="btn btn-page" data-page="chrono">stopwatch</li><!--
            -->
            <li id="contact" class="btn btn-page last" data-page="contact">contact</li>
        </ul>
    </div>

    {!! Breadcrumbs::render('swimmer', $group, $swimmer) !!}

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <h1>{{ $swimmer->first_name }} {{ $swimmer->last_name }}</h1>
            @if(! $hasHeartRate)
                @include('swimmers.show.heartRate') <br>
            @endif


            <div class="pages">
                {{--<div id="data" data-role="page" class="page" data-next="about">--}}
                {{--<div role="main" class="ui-content">--}}
                {{--@include('swimmers.show.data')--}}
                {{--</div>--}}
                {{--</div>--}}
                <div id="about" data-role="page" class="page" data-next="PR" data-prev="data">
                    @include('swimmers.show.about')
                </div>
                <div id="PR" data-role="page" class="page" data-next="chrono" data-prev="about">
                    @include('swimmers.show.PR')
                </div>
                <div id="chrono" data-role="page" class="page" data-next="contact" data-previous="PR" hidden>
                    @include('swimmers.show.chrono')
                </div>
                <div id="contact" data-role="page" class="page" data-prev="chrono" hidden>
                    @include('swimmers.show.contact')
                </div>
            </div>


        </div>
    </div>

@stop