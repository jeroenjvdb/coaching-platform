@extends('layouts.master')

@section('content')
    <ul>
        @foreach($trainings as $training)
            <li><a href="{{ route('trainings.show', $training->id) }}">{{ $training->starttime }}</a></li>
        @endforeach
    </ul>
@stop