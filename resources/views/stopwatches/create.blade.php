@extends('layouts.master')

@section('content')

    {!! Form::open(['route' => ['stopwatches.store', 'group' => $group->slug]]) !!}

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
