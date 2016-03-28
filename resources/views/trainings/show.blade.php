@extends('layouts.master')

@section('content')

    <h2>add exercise</h2>
    {!! Form::open(['route' => [
                        'exercises.store',
                        'group' => $training->group->slug,
                        'id' => $training->id]
                    ]) !!}
        {!! Form::label('sets') !!}
        {!! Form::text('sets') !!} <br>
        {!! Form::label('meters') !!}
        {!! Form::text('meters') !!} <br>
        {!! Form::label('description') !!}
        {!! Form::text('description') !!} <br>
        {!! Form::submit() !!}

    {!! Form::close() !!}
    <h2>training {{ $training->starttime }}</h2>

    <table>
        <thead>
            <th>sets</th>
            <th></th>
            <th>meters</th>
            <th>description</th>
            <th>distance</th>
            <th></th>
        </thead>
        <tbody>
            @foreach($training->exercises as $exercise)
                <tr>
                    <td>{{ $exercise->sets }}</td>
                    <td>* </td>
                    <td>{{ $exercise->meters }}</td>
                    <td>{{ $exercise->description }}</td>
                    <td>{{ $exercise->total }}</td>
                    <td><a href="{{ route('exercises.edit', [
                                                    'group' => $training->group->slug,
                                                    'training_id' => $training->id,
                                                    'id' => $exercise->id
                                                ]) }}">update</a></td>
                </tr>
            @endforeach
        <tr>
            <td colspan="3">total:</td>
            <td>{{ $training->total ? $training->total : 0 }}</td>
        </tr>
        </tbody>
    </table>

@stop