@extends('layouts.master')

@section('title', $gExercise->name)

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 gym">
            <h1>{{ $gExercise->name }}</h1>
            <p>{{ $gExercise->description }}</p>
            <div class="row">
                <div class="col-xs-6 img">
                    <img src="{{ $gExercise->url_picture_start }}" alt="" style="max-width: 100%">
                </div>
                <div class="col-xs-6 img">
                    <img src="{{ $gExercise->url_picture_end }}" alt="" style="max-width: 100%">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="box box-danger">
                        <div class="box-header">
                            <h2>categories</h2>
                        </div>
                        <div class="box-body">
                            {!! Form::open(['route' => [
                        '{group}.gym.categories.store',
                        'group' => $group->slug,
                    ], 'data-ajax' => true]) !!}
                            <div class="form-group">
                                {!! Form::label('name') !!}
                                {!! Form::text('name', null, [
                                    'class' => 'form-control',
                                ]) !!}<br>
                            </div>
                            <div class="form-group">
                                {!! Form::submit('opslaan', [
                                    'class' => 'btn btn-primary btn-full',
                                ]) !!}
                            </div>
                            {!! Form::close() !!}
                            <ul>
                                @foreach( $gExercise->categories as $category )
                                    <li>{{ $category->name }}</li>
                                @endforeach
                            </ul>
                            {!! Form::open(['route' => ['{group}.gym.exercises.category',
                                                    'group' => $group->slug,
                                                    'id' => $gExercise->id,
                            ], 'data-ajax' => true]) !!}
                            <div class="form-group">
                                {!! Form::label('options[]', 'categorieën') !!}
                                <select name="options[]" class="select2 form-control" id="" multiple>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                {!! Form::submit('opslaan', [
                                    'class' => 'btn btn-primary btn-full',
                                ]) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@stop