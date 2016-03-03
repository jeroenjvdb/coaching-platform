@extends('layouts.master')

@section('title', 'show all groups')

@section('content')
    {!! Form::open(['route' => 'groups.store', 'method' => 'post']) !!}
        {!! Form::label('name') !!} {!! Form::text('name') !!}
    {!! Form::close() !!}
@stop