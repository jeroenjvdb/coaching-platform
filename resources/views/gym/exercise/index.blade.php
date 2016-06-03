@extends('layouts.master')

@section('content')
    <h1>all gym exercises</h1>
    <a href="{{ route('{group}.gym.exercise.create', [
        'group' => $group->slug,
    ]) }}">create</a>
    @foreach($gExercises as $exercise)
        <li>
            <a href="{{ route('{group}.gym.exercise.show', [
                'group' => $group->slug,
                'id' => $exercise->id,
            ]) }}">{{ $exercise->name }}</a>
        </li>
    @endforeach
@stop