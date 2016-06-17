@extends('layouts.landing')

@section('title', 'Groep toevoegen')

@section('content')
    <div class="box box-danger login-box">
        <div class="box-header">
            <h3 class="text-center title-center">
                Groep toevoegen
            </h3>
            <a href="/">
                <div class="return">
                    <h3>&lt</h3>
                </div>
            </a>
        </div>
        <div class="in clearfix">

            {!! Form::open(['method' => 'POST', 'route' => 'groups.store']) !!}
            <fieldset class="form-group">
                {!! Form::label('name', 'Naam') !!}
                {!! Form::text('name', null, [
                    'class' => 'form-control',
                    'autofocus' => 'autofocus',
                ]) !!}
            </fieldset>
            <fieldset class="form-group">
                {!! Form::submit('Toevoegen', [
                    'class' => 'btn btn-primary btn-full',
                ]) !!}
            </fieldset>
            {!! Form::close() !!}
        </div>
    </div>
@stop