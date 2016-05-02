@extends('layouts.master')

@section('content')
    <a href="{{ route('gym.exercises.index', ['group' => $group->slug]) }}">exercises</a><br>
    <a href="{{ route('gyms.create', [
        'group' => $group->slug,
    ]) }}">create</a>
@stop