@extends('layouts.master')

@section('title', 'show all groups')

@section('content')
    <h1>{{ $group->name }}</h1>
    <a href="{{ route('groups.edit', [$group->id]) }}">edit</a>
    <h2>zwemmers:</h2>
    @foreach($group->swimmers as $swimmer)

        <a href="{{ route('swimmers.show', [$swimmer->id]) }}">{{ $swimmer->name }}</a></br>

    @endforeach
@stop