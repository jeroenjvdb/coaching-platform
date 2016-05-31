@extends('layouts.master')

@section('title', 'show all groups')

@section('content')
    {!! Breadcrumbs::render('group', $group) !!}
    <h1>{{ $group->name }}</h1>
    <a href="{{ route('swimmers.download.pr', ['group' => $group->slug]) }}">download</a>
    <a href="{{ route('groups.edit', [$group->slug]) }}">edit</a>
    <h2>vandaag</h2>
    @foreach($trainings as $training)
        <div class="row">
            <div class="col-xs-6 col-md-3">
                <a href="{{ route('trainings.show', [
                    'group' => $group->slug,
                    'training_id' => $training->id,
                ]) }}">
                    <button class="btn btn-primary">
                        {{ sprintf("%02d", $training->starttime->hour) }}:{{ sprintf("%02d", $training->starttime->minute) }}
                    </button>
                </a>
            </div>
            <div class="col-xs-6 col-md-3">
                <canvas class="chart" data-url="{{ route('trainings.show.distances', [
                    'group' => $group->slug,
                    'training_id' => $training->id,
                ]) }}"></canvas>
            </div>
        </div>
    @endforeach

    <h2>zwemmers</h2>
    <div class="row swimmers">
        @foreach($swimmers as $key => $swimmer)
            @if($key > 0 && $key % 2 == 0)
                <div class="clearfix visible-xs"></div>
            @endif
            @if($key > 0 && $key % 3 == 0)
                <div class="clearfix visible-sm"></div>
            @endif
            @if($key > 0 && $key % 4 == 0)
                <div class="clearfix visible-md visible-lg"></div>
            @endif
            <div class="col-md-3 col-sm-4 col-xs-6 center">
                <a rel="external" href="{{ route('swimmers.show', ['group' => $group->slug, $swimmer->slug]) }}">
                    <span class="col-xs-12 col-sm-10 col-sm-offset-1">
                        <span class="thumbnail center swimmer-thumb" style="; ">
                        @if($swimmer->getMeta('picture'))
                                <img src="{{ $swimmer->getMeta('picture') }}" alt="">
                            @else
                                <img src="http://library.unn.edu.ng/wp-content/uploads/sites/42/2016/03/prifile-pic.png"
                                     alt="">
                            @endif
                    </span>
                    <span class="col-xs-12 center">
                     {{ $swimmer->first_name }} {{ $swimmer->last_name }}
                    </span>
                    </span>

                </a>
            </div>


        @endforeach
    </div>

@stop