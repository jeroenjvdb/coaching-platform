@extends('layouts.landing')

@section('content')
    <div class="col-md-4 col-md-offset-4">

        <div class="box box-danger login-box">
            <div class="box-header">
                <h3 class="text-center title-center">
                    wachtwoord wijzigen
                </h3>
                <a href="/">
                    <div class="return">
                        <h3>&lt</h3>
                    </div>
                </a>
            </div>
            <div class="box-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {!! Form::open([route('auth.password.update')]) !!}
                <fieldset class="form_group">
                    {!! Form::label('old_password') !!}
                    {!! Form::password('old_password') !!}
                </fieldset>
                <fieldset class="form_group">
                    {!! Form::label('new_password') !!}
                    {!! Form::password('new_password') !!}
                </fieldset>
                <fieldset class="form_group">
                    {!! Form::label('new_password_confirmation') !!}
                    {!! Form::password('new_password_confirmation') !!}
                </fieldset>
                <fieldset class="form_group">
                    {!! Form::submit('wachtwoord wijzigen', [
                        'class' => 'btn btn-primary form-control',
                    ]) !!}
                </fieldset>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop