@extends('layouts.master')

@section('content')
    {!! Breadcrumbs::render('trainings.show', $group, $training) !!}
    <h2>training {{ $training->starttime->formatLocalized('%A %d %B %P') }} <a rel="external" href="{{ route('training.download', [
        'group' => $group->slug,
        'training_id' => $training->id,
    ]) }}"><i class="fa fa-download"></i></a></h2>

    <a href="#" data-toggle="add-exercise"><i class="fa fa-plus"></i><span class="sr-only">Add new exercise</span></a>

    <div class="training">
        <div id="exercises" class="sortable" data-url="{{ route('exercises.update.cat.position', [
            'group' => $group->slug,
            'training_id' => $training->id,
        ]) }}">
            @foreach($categories as $category)
                <div id="category-{{ $category->id }}" class="test" data-id="{{ $category->id }}"
                     data-table="exercises" data-class="test" data-url="{{ route('exercises.update.position', [
            'group' => $group->slug,
            'training_id' => $training->id,
        ]) }}">
                    <div class="category exercise-ui row">
                        <div class="sort-bars col-xs-1"><i class="fa fa-bars"></i></div>
                        <div class="col-xs-4">
                            <div class="">{{ $category->category->name }}</div>
                        </div>
                        <div class="col-xs-6">
                            {{ $category->total }}m
                        </div>
                        <div class="col-xs-1 no-gutter  ">
                            <a href="#" data-toggle="add-exercise-{{ $category->id }}"><i class="fa fa-plus"></i><span class="sr-only">Add new exercise</span></a>
                        </div>
                    </div>
                    <div class="sortable">
                        @foreach($category->exercises as $exercise)
                            @include('trainings.show.exercise')
                        @endforeach
                            @include('trainings.show.create')
                    </div>
                </div>

            @endforeach
            <div class="exercise-ui total row">
                <div class="col-xs-8 col-xs-offset-1">
                    totaal: {{ $training->total }}m

                </div>
            </div>
            <div class="add-exercise " hidden data-is_form="true">
                <h2>add category</h2>
                {!! Form::open(['route' => [
                                    'category.exercise.store',
                                    'group' => $group->slug,
                                    'id' => $training->id
                                ],
                                'data-ajax' => "false",
                                ]) !!}
                <fieldset class="form-group col-md-12">
                    {!! Form::text('category') !!}
                </fieldset>
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
            @include('trainings.show.presences')
        </div>
    </div>


@stop