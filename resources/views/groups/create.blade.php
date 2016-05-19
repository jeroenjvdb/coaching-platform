@extends('layouts.master')

@section('title', 'show all groups')

@section('content')
{!! Form::open(['method' => 'POST', 'route' => 'groups.store']) !!}
        {!! Form::label('name') !!} {!! Form::text('name') !!}<br>
        {!! Form::submit() !!}
    {!! Form::close() !!}
@stop