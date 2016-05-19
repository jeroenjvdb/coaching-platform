@extends('layouts.master')

@section('title', 'show all groups')

@section('content')
    <h1>{{ $group->name }}</h1>
    <a href="{{ route('groups.edit', [$group->slug]) }}">edit</a>
    <h2>zwemmers:</h2>
    @foreach($swimmers as $swimmer)

        <a rel="external" href="{{ route('swimmers.show', ['group' => $group->slug, $swimmer->slug]) }}">{{ $swimmer->first_name }} {{ $swimmer->last_name }}</a></br>

    @endforeach
@stop