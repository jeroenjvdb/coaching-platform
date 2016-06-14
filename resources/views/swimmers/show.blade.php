@extends('layouts.master')

@section('title', $swimmer->full_name )

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
            <div class="row">

            @if(! $hasHeartRate)
                <div class="col-xs-6">
                @include('swimmers.show.heartRate')
                </div>
            @endif
            @if(! $swimmer->checkWeights())
                <div class="col-xs-6">
                @include('swimmers.show.weight')
                </div>
            @endif
            </div>
            <h1>{{ $swimmer->first_name }} {{ $swimmer->last_name }}</h1>



            <div class="pages">
                {{--<div id="data" data-role="page" class="page" data-next="about">--}}
                {{--<div role="main" class="ui-content">--}}
                {{--@include('swimmers.show.data')--}}
                {{--</div>--}}
                {{--</div>--}}
                <div id="" data-role="page" class="page about" data-next="PR" data-prev="data">
                    @include('swimmers.show.about')
                </div>
                <div id="" data-role="page" class="page PR" data-next="chrono" data-prev="about">
                    @include('swimmers.show.PR')
                </div>
                <div id="" data-role="page" class="page chrono" data-next="contact" data-prev="PR" hidden>
                    @include('swimmers.show.chrono')
                </div>
                <div id="contact" data-role="page" class="page" data-prev="chrono" hidden>
                    @include('swimmers.show.contact')
                </div>
            </div>


        </div>
    </div>

@stop