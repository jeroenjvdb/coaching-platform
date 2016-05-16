@extends('layouts.master')

@section('content')

    <h2>training {{ $training->starttime }} <a href="{{ route('training.download', [
        'group' => $group->slug,
        'training_id' => $training->id,
    ]) }}"><i class="fa fa-download"></i></a></h2>


    <div >
        <h2>add exercise</h2>
        {!! Form::open(['route' => [
                            'exercises.store',
                            'group' => $group->slug,
                            'id' => $training->id]
                        ]) !!}
        <fieldset class="form-group col-md-6">
            {!! Form::label('sets') !!}
            {!! Form::input('number', 'sets', null, [
                'class' => 'form-control',
                'autocomplete' => 'off',
            ]) !!}
        </fieldset>
        <fieldset class="form-group col-md-6">
            {!! Form::label('meters') !!}
            {!! Form::input('number', 'meters', null, [
                'class' => 'form-control',
                'autocomplete' => 'off',
            ]) !!}
        </fieldset>
        <fieldset class="form-group col-md-12">
            {!! Form::label('description') !!}
            {!! Form::textarea('description', null, [
                'class' => 'form-control',
            ]) !!}
        </fieldset>
        <fieldset class="form-group col-md-12">
            {!! Form::submit('verzenden', [
            'class' => 'btn btn-primary'
        ]) !!}
        </fieldset>
        {!! Form::close() !!}
    </div>


    <table>
        <thead>
        <th>sets</th>
        <th></th>
        <th>meters</th>
        <th>description</th>
        <th>distance</th>
        <th></th>
        </thead>
        <tbody class="sortable" id="exercises" data-url="{{ route('exercises.update.position', [
            'group' => $group->slug,
            'training_id' => $training->id,
        ]) }}">
        @foreach($training->exercises as $exercise)
            <tr data-id="{{ $exercise->id }}" class="exercise" data-class="exercise" data-table="exercises">
                <td>{{ $exercise->sets }}</td>
                <td>*</td>
                <td>{{ $exercise->meters }}</td>
                <td>{{ $exercise->description }}</td>
                <td>{{ $exercise->total }}</td>
                <td><a href="{{ route('exercises.edit', [
                                                    'group' => $group->slug,
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

    <h2>presences</h2>
    {{ Form::open(['route' => ['presences.store',
                                    'group' => $group->slug,
                                    'training_id' => $training->id,
                                ]]) }}
    <ul>
        @foreach($swimmers as $swimmer)
            <li>{{ Form::checkbox('swimmers[]', $swimmer->id, $swimmer->present, ['id' => $swimmer->id]) }}
                {{ Form::label($swimmer->id, $swimmer->first_name . ' ' . $swimmer->last_name) }}

            </li>
        @endforeach

    </ul>
    {{ Form::submit() }}
    {{ Form::close() }}

@stop