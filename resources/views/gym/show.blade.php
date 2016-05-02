@extends('layouts.master')

@section('content')
    <h1>fitness training</h1>
    <h2>add exercise</h2>
    {!! Form::open([
        'route' => [
            'gym.training.store',
            'group' => $group->slug,
            'id' => $gym->id
        ],
    ]) !!}

    {!! Form::label('sets') !!}
    {!! Form::text('sets') !!}
    {!! Form::label('reps') !!}
    {!! Form::text('reps') !!}
    {!! Form::label('exercise') !!}

    <select name="exercise" id="">
        @foreach($allExercises as $exercise)
            <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
        @endforeach
    </select>

    {!! Form::submit() !!}

    {!! Form::close() !!}

    <table>
        <thead>
            <th>sets</th>
            <th>reps</th>
            <th>name</th>
            <th>description</th>
            <th>start</th>
            <th>end</th>
        </thead>
        @foreach($exercises as $exercise)
            <tr>
                <td>{{ $exercise->sets }}</td>
                <td>{{ $exercise->reps }}</td>
                <td>{{ $exercise->exercise->name }}</td>
                <td>{{ $exercise->exercise->description }}</td>
                <td><img src="{{ $exercise->exercise->url_picture_start }}" alt="" style="max-width: 200px;"></td>
                <td><img src="{{ $exercise->exercise->url_picture_end }}" alt="" style="max-width: 200px;"></td>
            </tr>
        @endforeach

    </table>

@stop