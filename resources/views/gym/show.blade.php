@extends('layouts.master')

@section('title', 'toon training')

@section('content')
    <h1>fitness training</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-danger">
                <div class="box-header">
                    <h2>oefening toevoegen</h2>
                </div>
                <div class="box-body">
                    {!! Form::open([
               'route' => [
                   '{group}.gym.{gym}.add',
                   'group' => $group->slug,
                   'gym' => $gym->id
               ],
           ]) !!}
                    <div class="row">
                        <div class="col-md-6 form-group">
                            {!! Form::label('sets') !!}
                            {!! Form::text('sets', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="col-md-6 form-group">
                            {!! Form::label('reps') !!}
                            {!! Form::text('reps', null, [
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('exercise') !!}
                        <select name="exercise" class="form-control" id="">
                            @foreach($allExercises as $exercise)
                                <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {!! Form::submit('oefening toevoegen', [
                        'class' => 'btn btn-primary btn-full'
                    ]) !!}

                    {!! Form::close() !!}


                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-danger">
                <div class="box-header">
                    <h2>oefening aanmaken</h2>
                </div>
                <div class="box-body">
                    {!! Form::open(['route' => ['{group}.gym.exercise.store', 'group' => $group->slug], 'files' => true]) !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name') !!}
                                {!! Form::text('name', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('description') !!}
                                {!! Form::textarea('description', null, [
                                    'rows' => '1',
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    {!! Form::label('start', 'beginpositie', [
                                        'class' => 'sr-only',
                                    ]) !!}
                                    <span class="btn btn-primary btn-file btn-full">
        <i class="fa fa-image"></i> <i class="fa fa-upload"></i> beginpositie {!! Form::file('start', [
                                        'class' => 'upload-image',
                                        'data-img' => 'start',
                                    ]) !!}
    </span>
                                    <img id="image-start" src="#" alt="your image"/>
                                </div>
                                <div class="form-group col-md-6">
                                    {!! Form::label('end', 'eindpositie', [
                                        'class' => 'sr-only',
                                    ]) !!}
                                    <span class="btn btn-primary btn-file btn-full">
        <i class="fa fa-image"></i> <i class="fa fa-upload"></i> eindpositie
                                    {!! Form::file('end', [
                                        'class' => 'upload-image',
                                        'data-img' => 'end',
                                    ]) !!}
                                        </span>
                                    <img id="image-end" src="#" alt="your image"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{--<div class="row">--}}
                    {{--<div class="col-md-6">--}}
                    {{--{!! Form::label('start') !!}--}}
                    {{--{!! Form::file('start', [--}}
                    {{--'class' => 'upload-image',--}}
                    {{--'data-img' => 'start',--}}
                    {{--]) !!}--}}
                    {{--<img id="image-start" src="#" alt="your image"/>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-6">--}}
                    {{--{!! Form::label('end') !!}--}}
                    {{--{!! Form::file('end', [--}}
                    {{--'class' => 'upload-image',--}}
                    {{--'data-img' => 'end',--}}
                    {{--]) !!}--}}
                    {{--<img id="image-end" src="#" alt="your image"/>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    {!! Form::submit('oefening aanmaken', [
                        'class' => 'btn btn-primary btn-full',
                    ]) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


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