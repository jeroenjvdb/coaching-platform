@extends('layouts.master')

@section('content')
    <h1>{{ $gExercise->name }}</h1>
    <p>{{ $gExercise->description }}</p>
    <div class="col-xs-6">
        <img src="{{ $gExercise->url_picture_start }}" alt="" style="max-width: 100%">
    </div>
    <div class="col-xs-6">
        <img src="{{ $gExercise->url_picture_end }}" alt="" style="max-width: 100%">
    </div>
@stop