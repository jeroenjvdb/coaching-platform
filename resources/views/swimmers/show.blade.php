@extends('layouts.master')

@section('title', $swimmer->name . ' profile')

@section('content')
    <div class="btn-pages">
    <button id="data" class="btn btn-page active" data-page="data">data</button><!--
    --><button id="about" class="btn btn-page" data-page="about">about</button><!--
    --><button id="PR" class="btn btn-page" data-page="PR">PR's</button><!--
    {{----><button id="chrono" class="btn btn-page" data-page="chrono">chrono</button><!----}}
    --><button id="contact" class="btn btn-page last" data-page="contact">contact</button>
    </div>

    {!! Breadcrumbs::render('swimmer', $group, $swimmer) !!}

    <h1>{{ $swimmer->first_name }} {{ $swimmer->last_name }}</h1>

    @if(! $hasHeartRate)
        @include('swimmers.show.heartRate') <br>
    @endif


    <div class="pages">
        <div id="data" data-role="page" class="page" data-next="about">
            <div role="main" class="ui-content">
            @include('swimmers.show.data')
            </div>
        </div>
        <div id="about" data-role="page" class="page" data-next="PR" data-prev="data" >
            @include('swimmers.show.about')
        </div>
        <div id="PR" data-role="page" class="page" data-next="contact" data-prev="about" >
            @include('swimmers.show.PR')
        </div>
        {{--<div id="chrono" class="page" data-next="contact" data-previous="PR" hidden>--}}
            {{--@include('swimmers.show.chrono')--}}
        {{--</div>--}}
        <div id="contact" data-role="page" class="page" data-prev="PR" hidden>
            @include('swimmers.show.contact')
        </div>
    </div>



    {{--<div>--}}
    {{--</div>--}}

@stop