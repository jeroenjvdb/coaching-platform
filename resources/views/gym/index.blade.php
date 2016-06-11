@extends('layouts.master')

@section('title', 'gym')

@section('content')
    <h1>gym</h1>
    <!--<a href="{{ route('{group}.gym.exercise.index', ['group' => $group->slug]) }}">exercises</a><br>
    <a href="{{ route('{group}.gym.create', [
        'group' => $group->slug,
    ]) }}">create</a>-->
    <div class="col-md-4">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-danger">
                    <div class="box-header">
                        <h2>gym training toevoegen</h2>
                    </div>
                    <div class="box-body">
                        {!! Form::open(['route' => [
                '{group}.gym.store',
                'group' => $group->slug,
            ]]) !!}
                        <div class="form-group">
                            {!! Form::label('start_time', 'begintijdstip') !!}
                            {!! Form::text('start_time', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        {!! Form::submit('aanmaken', [
                            'class' => 'btn btn-primary btn-full',
                        ]) !!}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h1>oefening toevoegen
                            <small>for in the gym</small>
                        </h1>
                    </div>
                    <div class="box-body">
                        {!! Form::open(['route' => ['{group}.gym.exercise.store', 'group' => $group->slug], 'files' => true]) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'naam') !!}
                            {!! Form::text('name', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', 'beschrijving') !!}
                            {!! Form::textarea('description', null, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('start', 'beginpositie') !!}


                                <div class="form-group">
                                <span class="btn btn-primary btn-full btn-file">
                                    <i class="fa fa-upload"></i> foto toevoegen {!! Form::file('start', [
                                                                'class' => 'upload-image',
                                                                'data-img' => 'start',
                                                            ]) !!}
                                </span>
                                </div>
                                <img id="image-start" src="#" alt="your image"/>
                            </div>
                            <div class="col-md-6">
                                {!! Form::label('end', 'eindpositie') !!}


                                <div class="form-group">
                                <span class="btn btn-primary btn-full btn-file">
                                    <i class="fa fa-upload"></i> foto toevoegen {!! Form::file('picture', [
                                        'class' => 'upload-image',
                                        'data-img' => 'end',
                                    ]) !!}
                                </span>
                                </div>

                                <img id="image-end" src="#" alt="your image"/>
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