@extends('layouts.master')

@section('content')
    <h1>all gym exercises</h1>
    <a href="{{ route('gym.exercises.create', [
        'group' => $group->slug,
    ]) }}">create</a>
    @foreach($gExercises as $exercise)
        <li>
            <a href="{{ route('gym.exercises.show', [
                'group' => $group->slug,
                'id' => $exercise->id,
            ]) }}">{{ $exercise->name }}</a>
        </li>
    @endforeach
@stop