@extends('layouts.master')

@section('title', 'stopwatch aanmaken')

@section('content')

    {!! Form::open(['route' => [
                '{group}.stopwatch.store',
                'group' => $group->slug
            ],
            'data-ajax' => "false"
        ]) !!}

        {!! Form::select('swimmer', $swimmers) !!}
        <select name="distance" id="">
            @foreach($strokes as $stroke)
                @foreach($stroke->distances as $distance)
                    <option value="{{ $distance->id }}">{{ $stroke->name }} - {{ $distance->distance }}</option>
                @endforeach
            @endforeach
        </select>
        {!! Form::submit() !!}

    {!! Form::close() !!}

@stop
