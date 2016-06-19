@extends('layouts.master')

@section('title', 'toon training')

@section('content')
    <h1>Fitness training</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-danger">
                <div class="box-header">
                    <h2>Oefening toevoegen</h2>
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
                            {!! Form::label('sets', 'Sets') !!}
                            {!! Form::text('sets', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="col-md-6 form-group">
                            {!! Form::label('reps', 'Reps') !!}
                            {!! Form::text('reps', null, [
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('exercise', 'Oefening') !!}
                        <select name="exercise" class="form-control" id="">
                            @foreach($allExercises as $exercise)
                                <option value="{{ $exercise->id }}">{{ $exercise->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {!! Form::submit('Oefening toevoegen', [
                        'class' => 'btn btn-primary btn-full'
                    ]) !!}

                    {!! Form::close() !!}


                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-danger">
                <div class="box-header">
                    <h2>Oefening aanmaken</h2>
                </div>
                <div class="box-body">
                    {!! Form::open(['route' => ['{group}.gym.exercise.store', 'group' => $group->slug], 'files' => true]) !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Naam') !!}
                                {!! Form::text('name', null, [
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('description', 'Beschrijving') !!}
                                {!! Form::textarea('description', null, [
                                    'rows' => '1',
                                    'class' => 'form-control',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('start', 'beginpositie', [
                                        'class' => 'sr-only',
                                    ]) !!}
                                    <span class="btn btn-primary btn-file btn-full">
        <i class="fa fa-image"></i> <i class="fa fa-upload"></i> Beginpositie {!! Form::file('start', [
                                        'class' => 'upload-image',
                                        'data-img' => 'start',
                                    ]) !!}
    </span>
                                </div>
                                <img id="image-start" src="/resources/img/gym/start.png" alt="your image"/>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('end', 'Eindpositie', [
                                        'class' => 'sr-only',
                                    ]) !!}
                                    <span class="btn btn-primary btn-file btn-full">
        <i class="fa fa-image"></i> <i class="fa fa-upload"></i> Eindpositie
                                        {!! Form::file('end', [
                                            'class' => 'upload-image',
                                            'data-img' => 'end',
                                        ]) !!}
                                        </span>
                                </div>
                                <img id="image-end" src="/resources/img/gym/stop.png" alt="your image"/>
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

                    {!! Form::submit('Oefening aanmaken', [
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