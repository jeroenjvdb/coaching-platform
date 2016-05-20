@extends('layouts.master')

@section('content')
    {!! Breadcrumbs::render('trainings.index', $group) !!}
    <h1>trainingen</h1>
    <a rel="external" href="{{ route('trainings.create', [
        'group' => $group->slug,
    ]) }}">create</a>
    <ul>
        @foreach($trainings as $training)
            <li><a rel="external" href="{{ route('trainings.show', [
                                        'group' => $group->slug,
                                        'id' => $training->id
                                    ]) }}">{{ $training->starttime }}</a> - {{ $training->total }}m</li>
        @endforeach
    </ul>
@stop