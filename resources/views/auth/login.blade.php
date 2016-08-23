@extends('layouts.landing')

@section('title', 'Inloggen')

@section('content')
    <div class="login-box register box box-danger">
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
            <div class="visual">
                <div class="face front"><img src="/resources/img/launcher-icon-4x.png">
                </div>
                <!--<div class="face back">
                    <a href="#"><i class="fa fa-times"></i></a>
                    <img src="http://placehold.it/200x200">
                </div>-->
            </div>
            <div class="col-sm-6 register-part">
                {!! Form::open(['url' => '/login']) !!}

                <h3>Inloggen</h3>
                <div class="field user">
                    {!! Form::text('email', null, ['placeholder' => 'Email', 'autofocus', 'required']) !!}
                </div>
                <div class="field user">
                    {!! Form::password('password', ['placeholder' => 'Wachtwoord', 'required']) !!}
                </div>

                <div class="field">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Onthoud me
                        </label>
                    </div>
                </div>

                <div class="field user">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-sign-in"></i> Inloggen
                        </button>

                    </div>
                </div>

                <div class="field user">
                    <a class="btn btn-danger" href="{{ url('/password/reset') }}" role="button">Wachtwoord
                        vergeten?</a>
                </div>
                <div class="field user">
                    <p>Nog geen account?</p>
                    <a href="/register" class="btn btn-primary">
                        Registreren
                    </a>
                </div>



                {!! Form::close()  !!}

            </div>
            <div class="col-sm-6 advantages">
                <h3>Voordelen</h3>
                <div class="field">
                    <div class="advantage row">
                        <div class="col-xs-2"><i class="fa fa-plus"></i></div>
                        <div class="col-xs-10">Foto's en videos toevoegen aan zwemmers.</div>
                    </div>
                    <div class="advantage row">
                        <div class="col-xs-2"><i class="fa fa-plus"></i></div>
                        <div class="col-xs-10">Automatisch updaten persoonlijke records</div>
                    </div>
                    <div class="advantage row">
                        <div class="col-xs-2"><i class="fa fa-plus"></i></div>
                        <div class="col-xs-10">Trainingen schrijven, aanpassen en delen met zwemmers.</div>
                    </div>
                    <div class="advantage row">
                        <div class="col-xs-2"><i class="fa fa-plus"></i></div>
                        <div class="col-xs-10">Tijden opnemen en opslaan per zwemmer.</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@stop                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       