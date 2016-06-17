@extends('layouts.master')

@section('title', 'Coach toevoegen')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Coach toevoegen</h1>
            <div class="box box-danger col-md-4 col-sm-6 col-xs-12">
                <div class="box-body">
                    {!! Form::open(['route' => [
                        '{group}.coach.store',

                        'group' => $group->slug,
                        ],
                        'data-ajax' => 'false',
                    ]) !!}
                    <div class="form-group">
                        {!! Form::label('email', 'E-mail address') !!}
                        {!! Form::email('email', null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('first_name', 'Voornaam') !!}
                        {!! Form::text('first_name', null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('last_name', 'Achternaam') !!}
                        {!! Form::text('last_name', null, [
                            'class' => 'form-control'
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Toevoegen', [
                            'class' => 'btn btn-primary btn-full'
                        ]) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


@stop