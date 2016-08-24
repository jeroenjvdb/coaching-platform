@extends('layouts.master')

@section('title', 'alle stopwatches')

@section('content')
    <div class="row">
        <h1>Stopwatches</h1>
    </div>
    <h2>Slagenteller</h2>
    <div class="row">
        <div class="col-xs-12">
            <div class="stopwatch" data-base3="true"></div>
        </div>
    </div>
    <h2>Stopwatch</h2>
    <div class="row">
        <div class="col-sm-6">
            <div class="box box-danger">
                <div class="box-body">
                    {!! Form::open(['route' => [
                            'stopwatch.store.api',
                            'group' => $group->slug
                        ],
                        'data-ajax' => "true"
                    ]) !!}

                    <fieldset class="form-group">

                        {!! Form::select('swimmer', $swimmers, null, [
                            'class' => 'select2 form-control'
                        ]) !!}
                    </fieldset>
                    <fieldset class="form-group">
                        <select name="distance" class="select2 form-control" id="">
                            @foreach($strokes as $stroke)
                                @foreach($stroke->distances as $distance)
                                    <option value="{{ $distance->id }}">{{ $stroke->name }}
                                        - {{ $distance->distance }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </fieldset>
                    {!! Form::submit('Stopwatch aanmaken', [
                        'class' => 'btn btn-primary btn-full',
                    ]) !!}

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
    <div id="newStopwatch"></div>
    <div class="row">
        <div class="stopwatch" data-base3="false" data-paused="true"></div>
    </div>
@stop

