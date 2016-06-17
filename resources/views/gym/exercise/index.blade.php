@extends('layouts.master')

@section('title', 'gym oefeningen')

@section('content')
    <h1>Gym oefeningen</h1>
    <a href="{{ route('{group}.gym.exercise.create', [
        'group' => $group->slug,
    ]) }}">Aanmaken</a>
    @foreach($gExercises as $exercise)
        <li>
            <a href="{{ route('{group}.gym.exercise.show', [
                'group' => $group->slug,
                'id' => $exercise->id,
            ]) }}">{{ $exercise->name }}</a>
        </li>
    @endforeach
@stop