@extends('layouts.master')

@section('title', 'groep wijzigen')

@section('content')

{!! Form::model($group, ['method' => 'POST', 'route' => ['groups.update', $group->slug]]) !!}
    <div class="form-group">
        {!! Form::label('name', 'naam') !!} {!! Form::text('name', null, [
            'class' => 'form-control'
        ]) !!}
    </div>
    {!! Form::submit('updaten', [
        'class' => 'btn btn-primary'
    ]) !!}
{!! Form::close() !!}

@stop