@extends('layouts.master')

@section('content')

    {!! Form::open(['route' => 'trainings.store']) !!}
        {!! Form::label('starttime') !!}
        {!! Form::text('starttime') !!}
        {!! Form::submit() !!}
    {!! Form::close() !!}

@stop