@extends('layouts.master')

@section('title', $swimmer->full_name )

@section('content')
    <div class="pagebar">
    <div id="navigation-sticky" class="nav-tabs-custom">
        <ul class="btn-pages nav-tabs nav"><!--
            -->
            <li id="about" class="btn btn-page active col-xs-3 " data-page="about"><i class="fa fa-line-chart"></i> Over</li><!--
            -->
            <li id="PR" class="btn btn-page col-xs-3" data-page="PR"><img src="/resources/img/podium.svg" alt="" height="20px"> PR</li><!--
            -->
            <li id="chrono" class="btn btn-page col-xs-3" data-page="chrono"><i class="fa fa-clock-o"></i> SW</li><!--
            -->
            <li id="contact" class="btn btn-page col-xs-3" data-page="contact"><i class="fa fa-exclamation-circle"></i> AP</li><!--
        --></ul>
    </div>
    </div>

    {!! Breadcrumbs::render('swimmer', $group, $swimmer) !!}

    <div class="row">
        <div class="col-sm-12 col-sm-offset-0">
            @if(Auth::user()->clearance_level > 0 || $myProfile)
                <div class="row">


                    @if(! $hasHeartRate)
                        <div class="col-sm-6">
                            @include('swimmers.show.heartRate')
                        </div>
                    @endif
                    @if(! $swimmer->checkWeights())
                        <div class="col-sm-6">
                            @include('swimmers.show.weight')
                        </div>
                    @endif
                </div>
            @endif
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
                <div id="" data-role="page" class="page chrono" data-next="contact" data-prev="PR">
                    @include('swimmers.show.chrono')
                </div>
                <div id="" data-role="page" class="page contact" data-prev="chrono">
                    @include('swimmers.show.data')
                </div>
            </div>


        </div>
    </div>

@stop