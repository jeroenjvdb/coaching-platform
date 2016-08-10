@extends('layouts.master')

@section('title', 'Stopwatch aanmaken')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Stopwatch aanmaken</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-danger">
                        <div class="box-body">
                            {!! Form::open(['route' => [
                                    'stopwatch.store',
                                    'group' => $group->slug
                                ],
                                'data-ajax' => "false"
                            ]) !!}

                            <fieldset class="form-group">

                                {!! Form::select('swimmer', $swimmers) !!}
                            </fieldset>
                            <fieldset class="form-group">
                                <select name="distance" id="">
                                    @foreach($strokes as $stroke)
                                        @foreach($stroke->distances as $distance)
                                            <option value="{{ $distance->id }}">{{ $stroke->name }}
                                                - {{ $distance->distance }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </fieldset>
                            {!! Form::submit() !!}

                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






@stop
