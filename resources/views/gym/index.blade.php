@extends('layouts.master')

@section('content')
    <h1>gym</h1>
    <a href="{{ route('gym.exercises.index', ['group' => $group->slug]) }}">exercises</a><br>
    <a href="{{ route('gyms.create', [
        'group' => $group->slug,
    ]) }}">create</a>
    <h2>komende trainingen</h2>
    <ul>
    @foreach($gyms as $gym)

        <li><a href="{{ route('gyms.show', [
            'group' => $group->slug,
            'id' => $gym->id
        ]) }}">{{ $gym->start_time }}</a></li>
    @endforeach
    </ul>
@stop