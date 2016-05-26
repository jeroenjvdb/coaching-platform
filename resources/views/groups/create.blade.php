@extends('layouts.landing')

@section('title', 'show all groups')

@section('content')
    <div class="container">
        <h1>Create group</h1>
        {!! Form::open(['method' => 'POST', 'route' => 'groups.store']) !!}
        <fieldset class="form-group">
        {!! Form::label('name') !!} {!! Form::text('name') !!}
        </fieldset>
        <fieldset class="form-group">
        {!! Form::submit('toevoegen', [
            'class' => 'btn btn-lg btn-primary',
        ]) !!}
        </fieldset>
        {!! Form::close() !!}
    </div>
@stop