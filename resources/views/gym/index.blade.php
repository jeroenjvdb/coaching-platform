@extends('layouts.master')

@section('title', 'Gym')

@section('content')
    <h1>Gym</h1>
    <!--<a href="{{ route('{group}.gym.exercise.index', ['group' => $group->slug]) }}">exercises</a><br>
    <a href="{{ route('{group}.gym.create', [
        'group' => $group->slug,
    ]) }}">create</a>-->
    <div class="col-md-4">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-danger">
                    <div class="box-header">
                        <h2>Gym training toevoegen</h2>
                    </div>
                    <div class="box-body">
                        {!! Form::open(['route' => [
                '{group}.gym.store',
                'group' => $group->slug,
            ]]) !!}
                        <div class="form-group">
                            {!! Form::label('start_time', 'Begintijdstip') !!}
                            {!! Form::text('start_time', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        {!! Form::submit('Aanmaken', [
                            'class' => 'btn btn-primary btn-full',
                        ]) !!}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h1>Oefening toevoegen
                        </h1>
                    </div>
                    <div class="box-body">
                        {!! Form::open(['route' => ['{group}.gym.exercise.store', 'group' => $group->slug], 'files' => true]) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Naam') !!}
                            {!! Form::text('name', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'Beschrijving') !!}
                            {!! Form::textarea('description', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('start', 'Beginpositie') !!}


                                <div class="form-group">
                                <span class="btn btn-primary btn-full btn-file">
                                    <i class="fa fa-upload"></i> Foto toevoegen {!! Form::file('start', [
                                                                'class' => 'upload-image',
                                                                'data-img' => 'start',
                                                            ]) !!}
                                </span>
                                </div>
                                <img id="image-start" src="/resources/img/gym/start.png" alt="your image"/>
                            </div>
                            <div class="col-md-6">
                                {!! Form::label('end', 'Eindpositie') !!}


                                <div class="form-group">
                                <span class="btn btn-primary btn-full btn-file">
                                    <i class="fa fa-upload"></i> Foto toevoegen {!! Form::file('picture', [
                                        'class' => 'upload-image',
                                        'data-img' => 'end',
                                    ]) !!}
                                </span>
                                </div>

                                <img id="image-end" src="/resources/img/gym/stop.png" alt="your image"/>
                            </div>
                        </div>

                        <br>
                        {!! Form::submit('aanmaken', [
                        'class' => 'btn btn-primary btn-full']) !!}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="box box-danger">
            <div class="box-body box-no-padding">
                <div class="calendar" data-url="{{ route('{group}.gym.get', [
        'group' => $group->slug
    ]) }}"></div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    {{--<h2>komende trainingen</h2>--}}

    {{--<ul>--}}
        {{--@foreach($gyms as $gym)--}}

            {{--<li><a href="{{ route('{group}.gym.show', [--}}
            {{--'group' => $group->slug,--}}
            {{--'id' => $gym->id--}}
        {{--]) }}">{{ $gym->start_time }}</a></li>--}}
        {{--@endforeach--}}
    {{--</ul>--}}
@stop