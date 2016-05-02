@extends('layouts.master')

@section('content')
    <h1>trainingen</h1>
    <a href="{{ route('trainings.create', [
        'group' => $group->slug,
    ]) }}">create</a>
    <ul>
        @foreach($trainings as $training)
            <li><a href="{{ route('trainings.show', [
                                        'group' => $group->slug,
                                        'id' => $training->id
                                    ]) }}">{{ $training->starttime }}</a> - {{ $training->total }}m</li>
        @endforeach
    </ul>
@stop