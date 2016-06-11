@extends('layouts.master')

@section('title', 'coach toevoegen')

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
                        {!! Form::label('email') !!}
                        {!! Form::email('email', null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('first_name') !!}
                        {!! Form::text('first_name', null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('last_name') !!}
                        {!! Form::text('last_name', null, [
                            'class' => 'form-control'
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('toevoegen', [
                            'class' => 'btn btn-primary btn-full'
                        ]) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


@stop