@extends('layouts.landing')

@section('title', 'groep toevoegen')

@section('content')
    <div class="box box-danger login-box">
        <div class="in clearfix">
            <h1>Groep toevoegen</h1>
            {!! Form::open(['method' => 'POST', 'route' => 'groups.store']) !!}
            <fieldset class="form-group">
                {!! Form::label('name', 'naam') !!}
                {!! Form::text('name', null, [
                    'class' => 'form-control',
                    'autofocus' => 'autofocus',
                ]) !!}
            </fieldset>
            <fieldset class="form-group">
                {!! Form::submit('toevoegen', [
                    'class' => 'btn btn-primary btn-full',
                ]) !!}
            </fieldset>
            {!! Form::close() !!}
        </div>
    </div>
@stop