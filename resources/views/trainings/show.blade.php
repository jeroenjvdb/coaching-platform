@extends('layouts.master')

@section('content')
    {!! Breadcrumbs::render('trainings.show', $group, $training) !!}
    <h2>training {{ $training->starttime }} <a rel="external" href="{{ route('training.download', [
        'group' => $group->slug,
        'training_id' => $training->id,
    ]) }}"><i class="fa fa-download"></i></a></h2>

    <a href="#" data-toggle="add-exercise"><i class="fa fa-plus"></i><span class="sr-only">Add new exercise</span></a>

    <div class="training">
        <div id="exercises" class="sortable" data-url="{{ route('exercises.update.position', [
            'group' => $group->slug,
            'training_id' => $training->id,
        ]) }}">
            @foreach($training->exercises as $exercise)
                <div data-id="{{ $exercise->id }}" class="exercise exercise-row-{{ $exercise->id }} row"
                     data-class="exercise" data-table="exercises">
                    <div class="sort-bars col-xs-1"><i class="fa fa-bars"></i></div>
                    {{--<td class="sort-bars"><i class="fa fa-bars"></i></td>--}}
                    <div class="col-xs-4">
                        <div class="row">
                            <div class="col-xs-3">{{ $exercise->sets }}</div>
                            <div class="col-xs-1"><i class="fa fa-times"></i></div>
                            <div class="col-xs-6">{{ $exercise->meters }}</div>
                        </div>
                    </div>
                    <div class="col-xs-5">
                        {{ $exercise->description }}
                    </div>
                    <div class="col-xs-2">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="#" data-toggle="exercise-row-{{ $exercise->id }}">
                                    <i class="fa fa-pencil"></i>
                                    <span class="sr-only">update</span>
                                </a>
                            </div>
                            <div class="col-xs-6">
                                <a rel="external" href="{{ route('exercises.delete', [
                                                    'group' => $group->slug,
                                                    'training_id' => $training->id,
                                                    'id' => $exercise->id
                                                ]) }}"><i class="fa fa-times"></i><span
                                            class="sr-only">delete</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="exercise-ui exercise-row-{{ $exercise->id }} row" data-is_form="true" hidden>
                    {!! Form::open(['route' => [
                        'exercises.update',
                        'group' => $group->slug,
                        'training_id' => $training->id,
                        'id' => $exercise->id,
                        ],
                        'data-ajax' => "false",

                        ]) !!}
                    <div class="col-xs-6 col-md-4">
                        <div class="row">
                            <div class="col-xs-5">
                                {!! Form::number('sets', $exercise->sets, [
                                    'class' => 'form-control number'
                                ]) !!}
                            </div><!--
                            --><div class="col-xs-1 no-gutter"><i class="fa fa-times"></i>
                            </div><!--
                            --><div class="col-xs-6">
                                {!! Form::number('meters', $exercise->meters, [
                                    'class' => 'form-control number',
                                ] ) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        {!! Form::textarea('description', $exercise->description, [
                            'class' => 'form-control',
                            'rows' => 1
                        ]) !!}
                    </div>
                    <div class="col-xs-2">
                        {!! Form::submit() !!}
                    </div>
                    {{--<td>{{ $exercise->total }}</td>--}}
                    {{--<td>{!! Form::submit() !!}</td>--}}
                    {!! Form::close() !!}
                </div>
            @endforeach
            <div class="add-exercise " hidden data-is_form="true">
                <h2>add exercise</h2>
                {!! Form::open(['route' => [
                                    'exercises.store',
                                    'group' => $group->slug,
                                    'id' => $training->id
                                ],
                                'data-ajax' => "false",
                                ]) !!}
                <fieldset class="form-group col-xs-7">
                    <div class="col-xs-5">
                        {!! Form::label('sets', 'sets', [
                            'class' => 'sr-only',
                        ]) !!}
                        {!! Form::input('number', 'sets', null, [
                            'class' => 'form-control number',
                            'autocomplete' => 'off',
                            'placeholder' => 'sets'
                        ]) !!}
                    </div>
                    <div class="col-xs-2 center">
                        <i class="fa fa-times"></i>
                    </div>
                    <div class="col-xs-5">
                        {!! Form::label('meters', 'meter', [
                            'class' => 'sr-only'
                        ]) !!}
                        {!! Form::input('number', 'meters', null, [
                            'class' => 'form-control number',
                            'autocomplete' => 'off',
                            'placeholder' => 'meter',
                        ]) !!}
                    </div>
                </fieldset>
                <div class="form-group col-xs-5">
                    {!! Form::label('description', 'beschrijving', [
                        'class' => 'sr-only',
                    ]) !!}
                    {!! Form::textarea('description', null, [
                        'class' => 'form-control',
                        'rows' => 2,
                        'placeholder' => 'beschrijving',
                    ]) !!}
                </div>
                <fieldset class="form-group col-md-12">
                    {!! Form::submit('verzenden', [
                    'class' => 'btn btn-primary'
                ]) !!}
                </fieldset>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
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
        </div>
    </div>


@stop