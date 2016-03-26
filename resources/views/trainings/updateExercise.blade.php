@extends('layouts.master')

@section('content')

    <h1>update exercise</h1>
    {!! Form::model($exercise ,[
                        'route' => [
                            'exercises.update',
                            'training_id' => $training->id,
                            'id' => $exercise->id
                    ]]) !!}

    {!! Form::label('sets') !!}
    {!! Form::text('sets') !!} <br>
    {!! Form::label('meters') !!}
    {!! Form::text('meters') !!} <br>
    {!! Form::label('description') !!}
    {!! Form::text('description') !!} <br>
    {!! Form::label('postition') !!}
    {!! Form::text('position') !!}<br>
    {!! Form::submit() !!}

    {!! Form::close() !!}

@stop