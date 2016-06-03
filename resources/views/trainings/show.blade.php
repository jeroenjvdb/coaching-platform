@extends('layouts.master')

@section('content')
    {!! Breadcrumbs::render('{group}.training.show', $group, $training) !!}
    <h2>training {{ $training->starttime->formatLocalized('%A %d %B %P') }} <a rel="external" href="{{ route('{group}.training.download', [
        'group' => $group->slug,
        'training_id' => $training->id,
    ]) }}"><i class="fa fa-download"></i></a></h2>
    @if($editable)
        {!! Form::open([
            'route' => [
                '{group}.training.shared',
                'group' => $group->slug,
                $training->id,
            ],
            'data-checked-submit' => 'true',
            'data-ajax' => 'true',
        ]) !!}
        <label class="switch">
            {!! Form::checkbox('is_shared','shared', $training->is_shared, ['id' => 'is_shared']) !!}
            {{--<input type="checkbox" id="is_shared" name="is_shared" value="shared">--}}
            <div class="slider"></div>
        </label>
        <label for="is_shared">share with swimmers</label>

        {!! Form::submit('verzenden', [
            'hidden',
        ]) !!}
        {!! Form::close() !!}
        <div class="row">
            <div class="col-xs-2 col-xs-offset-10 text-center">
                <a href="#" data-toggle="add-exercise"><i class="fa fa-plus"></i><span
                            class="sr-only">Add new exercise</span></a>
            </div>
        </div>
    @endif
    <div class="training">
        <div id="exercises" class="sortable" data-url="{{ route('{group}.training.exercise.update.cat.position', [
            'group' => $group->slug,
            'training_id' => $training->id,
        ]) }}">
            @foreach($categories as $category)
                <div id="category-{{ $category->id }}" class="test" data-id="{{ $category->id }}"
                     data-table="exercises" data-class="test" data-url="{{ route('{group}.training.exercise.update.position', [
            'group' => $group->slug,
            'training_id' => $training->id,
        ]) }}">
                    @include('trainings.show.category')
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
                @if($editable)
            <div class="add-exercise " hidden data-is_form="true">
                <h2>add category</h2>
                {!! Form::open(['route' => [
                                    '{group}.training.category.exercise.store',
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
                @endif
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            @include('trainings.show.presences')
        </div>
    </div>


@stop