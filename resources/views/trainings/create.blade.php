@extends('layouts.master')

@section('title', 'training toevoegen')

@section('content')

    {!! Form::open(['route' => ['trainings.store', 'group' => $group->slug], 'data-ajax' => 'false']) !!}
    <fieldset class="form-group">
        {!! Form::label('starttime') !!}
        {!! Form::input('datetime-local', 'starttime', null, [
            'class' => 'form-control',
        ]) !!}
    </fieldset>
    <fieldset class="form-group">
        {!! Form::submit('verzenden', [
            'class' => 'btn btn-primary',
        ]) !!}
    </fieldset>
    {!! Form::close() !!}

@stop