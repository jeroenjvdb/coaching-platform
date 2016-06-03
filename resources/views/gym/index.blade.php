@extends('layouts.master')

@section('content')
    <h1>gym</h1>
    <a href="{{ route('{group}.gym.exercise.index', ['group' => $group->slug]) }}">exercises</a><br>
    <a href="{{ route('{group}.gym.create', [
        'group' => $group->slug,
    ]) }}">create</a>
    <div class="col-md-4">
        <div class="box box-danger">
            <div class="box-header">
                <h2>gym training toevoegen</h2>
            </div>
            <div class="box-body">
                {!! Form::open(['route' => [
        '{group}.gym.store',
        'group' => $group->slug,
    ]]) !!}

                {!! Form::label('start_time') !!}
                {!! Form::text('start_time') !!}
                {!! Form::submit() !!}

                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="box box-danger">
            <div class="box-body box-no-padding">
                <div class="calendar" data-url="{{ route('{group}.gym.get', [
        'group' => $group->slug
    ]) }}"></div>
            </div>
        </div>
    </div>
    <h2>komende trainingen</h2>

    <ul>
        @foreach($gyms as $gym)

            <li><a href="{{ route('{group}.gym.show', [
            'group' => $group->slug,
            'id' => $gym->id
        ]) }}">{{ $gym->start_time }}</a></li>
        @endforeach
    </ul>
@stop