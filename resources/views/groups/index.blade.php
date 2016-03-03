@extends('layouts.master')

@section('title', 'show all groups')

@section('content')
    @foreach($groups as $group)
        <a href="{{ route('groups.show' [$group->id]) }}">{{ $group->name }}</a></br>
    @endforeach
@stop