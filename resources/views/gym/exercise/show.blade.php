@extends('layouts.master')

@section('content')
    <h1>{{ $gExercise->name }}</h1>
    <p>{{ $gExercise->description }}</p>
    <div class="row">
        <div class="col-xs-6">
            <img src="{{ $gExercise->url_picture_start }}" alt="" style="max-width: 100%">
        </div>
        <div class="col-xs-6">
            <img src="{{ $gExercise->url_picture_end }}" alt="" style="max-width: 100%">
        </div>
    </div>
    <h2>categories</h2>
    {!! Form::open(['route' => [
        '{group}.gym.categories.store',
        'group' => $group->slug,
    ], 'data-ajax' => true]) !!}
    {!! Form::label('name') !!}
    {!! Form::text('name') !!}<br>
    {!! Form::submit() !!}
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

    <select name="options[]" id="" multiple>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>

    {!! Form::submit() !!}
    {!! Form::close() !!}
@stop