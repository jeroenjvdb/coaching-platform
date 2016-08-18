@extends('layouts.master')

@section('title', $group->name)

@section('content')
    {!! Breadcrumbs::render('group', $group) !!}
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <h1>{{ $group->name }}</h1>
            {{--<a href="{{ route('{group}.swimmer.download.pr', ['group' => $group->slug]) }}" class="btn btn-primary"><i
                        class="fa fa-download"></i> Persoonlijke Records</a>
            {{--    <a href="{{ route('groups.edit', [$group->slug]) }}">edit</a>--}}
            <h2>Vandaag</h2>

            <div class="row">
                <div class="col-xs-12">
                    <p>
                        Alle trainingen die vandaag vallen.
                    </p>
                </div>
                @foreach($trainings as $key => $training)
                    @if(Auth::user()->clearance_level > 0 || $training->is_shared)
                        <div class="col-xs-12 col-md-6 col-lg-4">
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <a href="{{ route('training.show', [
                    'training_id' => $training->id,
                ]) }}">
                                        <button class="btn btn-primary">
                                            {{ sprintf("%02d", $training->starttime->hour) }}
                                            :{{ sprintf("%02d", $training->starttime->minute) }}
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <canvas class="chart" data-url="{{ route('{group}.training.show.distances', [
                    'group' => $group->slug,
                    'training_id' => $training->id,
                ]) }}"></canvas>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            @if($mySwimmer)
                <h2>Mijn profiel</h2>

                <div class="row swimmers">
                    <div class="swimmer col-xs-6 col-sm-4 col-md-3 col-lg-2">
                        <a rel="external" href="{{ route('me.profile', [
                    'group' => $group->slug,
                ]) }}">
                        <span class="col-xs-12 col-sm-10 col-sm-offset-1">
                        <div class="thumbnail center swimmer-thumb" style="; ">
                            @if($mySwimmer->getMeta('picture'))
                                <img src="{{ $mySwimmer->getMeta('picture') }}" alt="">
                            @else
                                <img src="{{ config('profile.picture') }}"
                                     alt="">
                            @endif
                            <span class="center">
                             {{ $mySwimmer->first_name }} {{ $mySwimmer->last_name }}
                            </span>
                        </div>
                        </span>

                        </a>
                    </div>
                </div>
            @endif
            <h2>Zwemmers
                @if(Auth::user()->clearance_level > 0)
                    <a href="{{ route('{group}.swimmer.create', [
        'group' => $group->slug,
    ]) }}" class="small"><i class="fa fa-plus"></i></a>
                @endif
            </h2>
            <div class="row swimmers">
                <div class="col-xs-12">
                    <p>Alle zwemmers van {{ $group->name }}</p>

                </div>
                <ul class="users-list">

                    @foreach($swimmers as $key => $swimmer)
                        {{--@if($key > 0 && $key % 2 == 0)--}}
                        {{--<div class="clearfix visible-xs"></div>--}}
                        {{--@endif--}}
                        {{--@if($key > 0 && $key % 4 == 0)--}}
                        {{--<div class="clearfix visible-sm"></div>--}}
                        {{--@endif--}}
                        {{--@if($key > 0 && $key % 6 == 0)--}}
                        {{--<div class="clearfix visible-md"></div>--}}
                        {{--@endif--}}
                        {{--@if($key > 0 && $key % 12 == 0)--}}
                        {{--<div class="clearfix visible-lg"></div>--}}
                        {{--@endif--}}
                        {{--<div class="center no-gutter cube">--}}
                        {{--<a rel="external" href="{{ route('{group}.swimmer.show', [--}}
                        {{--$swimmer->slug--}}
                        {{--]) }}">--}}
                        {{--<div class=" swimmer">--}}
                        {{--<div class="thumbnail center swimmer-thumb" style="; ">--}}
                        {{--<span class="center name">--}}

                        {{--</span>--}}


                        {{--</div>--}}
                        {{--</div>--}}

                        {{--</a>--}}
                        {{--</div>--}}
                        <li>
                            <a href="{{ route('{group}.swimmer.show', $swimmer->slug) }}">
                                @if($swimmer->getMeta('picture'))
                                    <img src="{{ $swimmer->getMeta('picture') }}" alt="">
                                @else
                                    <img src="{{ config('profile.picture') }}"
                                         alt="">
                                @endif
                                <span class="users-list-name">
                            {{ $swimmer->first_name }} {{ $swimmer->last_name }}
                        </span>
                            </a>
                        </li>




                    @endforeach
                </ul>

            </div>

            <h2>Coaches
                @if(Auth::user()->clearance_level > 0)
                    <a href="{{ route('coach.create', [
        'group' => $group->slug,
    ]) }}" class="small"><i class="fa fa-plus"></i></a>
                @endif
            </h2>
            <div class="row">
                <div class="col-xs-12">
                    <p>Alle coaches van {{ $group->name }}</p>
                </div>
                @foreach($coaches as $coach)
                    <div class="col-xs-12">
                        {{ $coach->first_name }} {{-- }}{{ $coach->last_name }}--}}
                    </div>
                @endforeach
            </div>
            @if(Auth::user()->clearance_level > 0)

                <h2>groep verwijderen</h2>
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <button type="button" class="btn btn-danger btn-lg btn-full" data-toggle="modal"
                                data-target="#delete">
                            verwijderen
                        </button>
                    </div>
                </div>
                <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">groep verwijderen</h4>
                            </div>
                            <div class="modal-body">
                                <p>Bent u zeker dat u {{ $group->name }} wil verwijderen?</p>
                            </div>
                            {!! Form::open(['route' => [
                                'groups.destroy',
                                'group' => $group->slug,
                            ], 'method' => 'delete']) !!}
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                                {!! Form::submit('verwijderen', [
                                    'class' => 'btn btn-danger',
                                ]) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

@stop