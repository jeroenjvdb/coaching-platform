@extends('layouts.master')

@section('title', 'gym training toevoegen')

@section('content')
    {!! Form::open(['route' => [
        '{group}.gym.store',
        'group' => $group->slug,
    ]]) !!}

    {!! Form::label('start_time') !!}
    {!! Form::text('start_time') !!}
    {!! Form::submit() !!}

    {!! Form::close() !!}
@stop