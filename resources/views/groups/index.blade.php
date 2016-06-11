@extends('layouts.master')

@section('title', 'alle groepen')

@section('content')
    @foreach($groups as $group)
        <a rel="external" href="{{ route('groups.show', ['group' => $group->slug]) }}">{{ $group->name }}</a></br>
    @endforeach
@stop