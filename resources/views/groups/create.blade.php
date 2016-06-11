@extends('layouts.landing')

@section('title', 'groep toevoegen')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Groep toevoegen</h1>
            {!! Form::open(['method' => 'POST', 'route' => 'groups.store']) !!}
            <fieldset class="form-group">
                {!! Form::label('name', 'naam') !!}
                {!! Form::text('name', null, [
                    'class' => 'form-control',
                ]) !!}
            </fieldset>
            <fieldset class="form-group">
                {!! Form::submit('toevoegen', [
                    'class' => 'btn btn-lg btn-primary',
                ]) !!}
            </fieldset>
            {!! Form::close() !!}
        </div>
    </div>
@stop