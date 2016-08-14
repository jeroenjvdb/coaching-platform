@extends('layouts.master')

@section('title', 'Training ' . $starttime->format('l j F') )

@section('content')
    {!! Breadcrumbs::render('{group}.training.show', $group, $training) !!}
        <h1>Training {{ $starttime->format('l j F') }} <a href="#" data-toggle="modal" data-target="#edit">
                <i class="fa fa-pencil"></i></a></h1>
        @include('trainings.edit')

        {{--<a rel="external" href="{{ route('{group}.training.download', [
       'group' => $group->slug,
       'training_id' => $training->id,
   ]) }}"><i class="fa fa-download"></i></a>--}}</h2>
    @if($editable)
        {!! Form::open([
            'route' => [
                '{group}.training.shared',
                'group' => $group->slug,
                $training->id,
            ],
            'data-checked-submit' => 'true',
            'data-ajax' => 'true',
            'class' => 'training',
        ]) !!}
        <label class="switch">
            {!! Form::checkbox('is_shared','shared', $training->is_shared, ['id' => 'is_shared']) !!}
            {{--<input type="checkbox" id="is_shared" name="is_shared" value="shared">--}}
            <div class="slider"></div>
        </label>
        <label for="is_shared" class="shared"><i class="fa fa-share-alt"></i><span
                    class="sr-only">Share with swimmer </span></label>

        {!! Form::submit('verzenden', [
            'hidden',
        ]) !!}
        {!! Form::close() !!}

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
            @if($editable)
                <div class="test">
                    <div class="category exercise-ui row">
                        <div class=" col-xs-offset-1 col-xs-9">Categorie toevoegen</div>
                        <div class="col-xs-2  no-gutter">
                            <a href="#" data-toggle="add-exercise"><i class="fa fa-plus"></i><span
                                        class="sr-only">Nieuwe categorie toevoegen</span></a>
                        </div>
                    </div>
                    <div class="sortable">

                    <div class="exercise-ui row add-exercise " hidden data-is_form="true">
                            {!! Form::open(['route' => [
                                                                        '{group}.training.category.exercise.store',
                                                                        'id' => $training->id
                                                                    ],
                                                                    'data-ajax' => "false",
                                                                    ]) !!}
                            <fieldset class="form-group col-xs-offset col-xs-12 col-md-10">
                                {!! Form::text('category', null, [
                                    'placeholder' => 'naam',
                                    'class' => 'form-control'
                                ]) !!}
                            </fieldset>
                            <fieldset class=" col-xs-12 col-md-2">
                                {!! Form::submit('verzenden', [
                                'class' => 'btn btn-primary btn-full'
                            ]) !!}
                            </fieldset>
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            @endif
        </div>
        <div class="exercise-ui total row">
            <div class="col-xs-8 col-xs-offset-1">
                totaal: {{ $training->total }}m

            </div>
        </div>
        @if($editable)
            {{-- <div class="add-exercise " hidden data-is_form="true">
                 <h2>add category</h2>
                 {!! Form::open(['route' => [
                                     '{group}.training.category.exercise.store',
                                     'id' => $training->id
                                 ],
                                 'data-ajax' => "false",
                                 ]) !!}
                 <fieldset class="form-group col-md-12">
                     {!! Form::text('category', null, [
                         'placeholder' => 'naam',
                     ]) !!}
                 </fieldset>
                 <fieldset class="form-group col-md-12">
                     {!! Form::submit('verzenden', [
                     'class' => 'btn btn-primary'
                 ]) !!}
                 </fieldset>
                 {!! Form::close() !!}
             </div> --}}
        @endif
    </div>
    <h2>Stopwatch</h2>
    <div class="row">
        <div class="col-sm-6">
            <div class="box box-danger">
                <div class="box-body">
                    {!! Form::open(['route' => [
                            'stopwatch.store.api',
                            'group' => $group->slug
                        ],
                        'data-ajax' => "true"
                    ]) !!}

                    <fieldset class="form-group">


                        <select name="swimmer" id="swimmer" class="select2 form-control">
                            @foreach($swimmers as $swimmer)
                                <option value="{{$swimmer->id}}">{{ $swimmer->first_name }}</option>
                            @endforeach
                        </select>
                    </fieldset>
                    <fieldset class="form-group">
                        <select name="distance" class="select2 form-control" id="">
                            @foreach($strokes as $stroke)
                                @foreach($stroke->distances as $distance)
                                    <option value="{{ $distance->id }}">{{ $stroke->name }}
                                        - {{ $distance->distance }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </fieldset>
                    {!! Form::submit('Stopwatch aanmaken', [
                        'class' => 'btn btn-primary btn-full',
                    ]) !!}

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
    <div id="newStopwatch" class=""></div>
    <div class="row">
        @foreach($stopwatches as $stopwatch)
            @include('stopwatches.individual')
        @endforeach
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="stopwatch row" data-base3="true"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12" class="training">
            @include('trainings.show.presences')
        </div>
    </div>


@stop