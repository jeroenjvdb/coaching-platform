@extends('layouts.master')

@section('content')

    {!! Form::open(['route' => ['trainings.store', 'group' => $group->slug]]) !!}
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