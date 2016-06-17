@extends('layouts.master')

@section('title', 'groep wijzigen')

@section('content')

{!! Form::model($group, ['method' => 'POST', 'route' => ['groups.update', $group->slug]]) !!}
    <div class="form-group">
        {!! Form::label('name', 'Naam') !!} {!! Form::text('name', null, [
            'class' => 'form-control'
        ]) !!}
    </div>
    {!! Form::submit('Updaten', [
        'class' => 'btn btn-primary'
    ]) !!}
{!! Form::close() !!}

@stop