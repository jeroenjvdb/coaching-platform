@extends('layouts.master')

@section('title', 'show all groups')

@section('content')
{!! Form::model($group, ['method' => 'POST', 'route' => ['groups.update', $group->id]]) !!}
    {!! Form::label('name') !!} {!! Form::text('name', null) !!}</br>
    {!! Form::submit() !!}
{!! Form::close() !!}
@stop