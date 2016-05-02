@extends('layouts.master')

@section('content')
    {!! Form::open(['route' => [
        'gyms.store',
        'group' => $group->slug,
    ]]) !!}

    {!! Form::label('start_time') !!}
    {!! Form::text('start_time') !!}
    {!! Form::submit() !!}

    {!! Form::close() !!}
@stop