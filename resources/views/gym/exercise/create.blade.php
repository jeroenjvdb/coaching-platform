@extends('layouts.master')

@section('title', 'Gym oefening toevoegen')

@section('content')
    <h1>Gym oefening toevoegen
    </h1>
    {!! Form::open(['route' => ['{group}.gym.exercise.store', 'group' => $group->slug], 'files' => true]) !!}
    {!! Form::label('name', 'Naam') !!}<br>
    {!! Form::text('name') !!}<br>

    {!! Form::label('description', 'Beschrijving') !!}<br>
    {!! Form::textarea('description') !!}<br>
    <div class="row">
        <div class="col-md-6">
            {!! Form::label('start', 'Start') !!}
            {!! Form::file('start', [
                'class' => 'upload-image',
                'data-img' => 'start',
            ]) !!}
            <img id="image-start" src="#" alt="your image" />
        </div>
        <div class="col-md-6">
            {!! Form::label('end', 'Einde') !!}
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