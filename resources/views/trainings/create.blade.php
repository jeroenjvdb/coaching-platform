@extends('layouts.master')

@section('content')

    {!! Form::open(['route' => ['trainings.store', 'group' => $group->slug]]) !!}
        {!! Form::label('starttime') !!}
        {!! Form::input('datetime', 'starttime') !!}
        {!! Form::submit() !!}
    {!! Form::close() !!}

@stop