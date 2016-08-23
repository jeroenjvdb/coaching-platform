@extends('layouts.landing')

@section('title', 'Groep toevoegen')

@section('content')
    <div class="box box-danger login-box">
        <div class="panel-heading">
            <h3>
                Groep toevoegen
            </h3>
            <a href="/">
                <div class="return">
                    <h3>&lt</h3>
                </div>
            </a>
        </div>
        <div class="in clearfix">
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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