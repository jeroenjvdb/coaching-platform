@extends('layouts.master')

@section('content')
    <h1>create exercises
        <small>for in the gym</small>
    </h1>
    {!! Form::open(['route' => ['{group}.gym.exercise.store', 'group' => $group->slug], 'files' => true]) !!}
    {!! Form::label('name') !!}<br>
    {!! Form::text('name') !!}<br>

    {!! Form::label('description') !!}<br>
    {!! Form::textarea('description') !!}<br>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('start') !!}
            {!! Form::file('start', [
                'class' => 'upload-image',
                'data-img' => 'start',
            ]) !!}
            <img id="image-start" src="#" alt="your image" />
        </div>
        <div class="col-md-6">
            {!! Form::label('end') !!}
            {!! Form::file('end', [
                'class' => 'upload-image',
                'data-img' => 'end',
            ]) !!}
            <img id="image-end" src="#" alt="your image" />
        </div>
    </div>

    <br>
    {!! Form::submit() !!}

    {!! Form::close() !!}
@stop