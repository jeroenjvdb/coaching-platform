@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="box box-danger col-md-4 col-sm-6 col-xs-12">
            <div class="box-header">
                <h2>coach toevoegen</h2>
            </div>
            <div class="box-body">
                {!! Form::open(['route' => [
                    '{group}.coach.store',

                    'group' => $group->slug,
                    ],
                    'data-ajax' => 'false',
                ]) !!}
                <div class="form-group">
                    {!! Form::label('email') !!}
                    {!! Form::email('email') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('first_name') !!}
                    {!! Form::text('first_name') !!}
                </div>
                <div class="form-group">
                    {!! Form::label('last_name') !!}
                    {!! Form::text('last_name') !!}
                </div>
                <div class="form-group">
                    {!! Form::submit() !!}
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>


@stop