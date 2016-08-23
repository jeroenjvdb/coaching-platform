@extends('layouts.landing')

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
            {!! Form::open(['url' => '/register']) !!}
            <div class="visual">
                <div class="face front"><img src="/resources/img/launcher-icon-4x.png">
                </div>
                <!--<div class="face back">
                    <a href="#"><i class="fa fa-times"></i></a>
                    <img src="http://placehold.it/200x200">
                </div>-->
            </div>

            <div class="col-sm-6 register-part">
                <h3>Registreren</h3>

                {{--<div class="field user">--}}
                {{--{!! Form::text('email', null, ['placeholder' => 'Email', 'autofocus', 'required']) !!}--}}
                {{--</div>--}}
                {{--<div class="field user">--}}
                {{--{!! Form::password('password', ['placeholder' => 'Wachtwoord', 'required']) !!}--}}
                {{--</div>--}}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Naam">

                    @if ($errors->has('name'))
                        <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
                </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                           placeholder="Email address">

                    @if ($errors->has('email'))
                        <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" name="password" placeholder="Wachtwoord">

                    @if ($errors->has('password'))
                        <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
                </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <input type="password" class="form-control" name="password_confirmation"
                           placeholder="Wachtwoord wijzigen">

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                    @endif
                </div>


                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-full">
                        <i class="fa fa-btn fa-user"></i>Registreren
                    </button>
                </div>


                {!! Form::close()  !!}

                <p>Al een account?</p>
                <div class="field user">
                    <div class="form-group">
                        <a href="/login" class="btn btn-danger">
                            <i class="fa fa-btn fa-sign-in"></i> Inloggen
                        </a>
                    </div>
                </div>

            </div>
            <div class="col-sm-6 advantages">
                <h3>Voordelen</h3>
                <div class="advantage row">
                    <div class="col-xs-2"> <i class="fa fa-plus"></i></div>
                    <div class="col-xs-10">Foto's en videos toevoegen aan zwemmers.</div>
                </div>
                <div class="advantage row">
                    <div class="col-xs-2"> <i class="fa fa-plus"></i></div>
                    <div class="col-xs-10">Automatisch updaten persoonlijke records</div>
                </div>
                <div class="advantage row">
                    <div class="col-xs-2"> <i class="fa fa-plus"></i></div>
                    <div class="col-xs-10">Trainingen schrijven, aanpassen en delen met zwemmers.</div>
                </div>
                <div class="advantage row">
                    <div class="col-xs-2"> <i class="fa fa-plus"></i></div>
                    <div class="col-xs-10">Tijden opnemen en opslaan per zwemmer.</div>
                </div>
            </div>
        </div>
    </div>


    {{--<div class="col-md-8 col-md-offset-2">--}}
        {{--<div class="panel panel-default">--}}
            {{--<div class="panel-heading">Reset Password</div>--}}

            {{--<div class="panel-body">--}}
                {{--<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">--}}
                    {{--{!! csrf_field() !!}--}}

                    {{--<input type="hidden" name="token" value="{{ $token }}">--}}

                    {{--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
                        {{--<label class="col-md-4 control-label">E-Mail Address</label>--}}

                        {{--<div class="col-md-6">--}}
                            {{--<input type="email" class="form-control" name="email" value="{{ $email or old('email') }}">--}}

                            {{--@if ($errors->has('email'))--}}
                                {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('email') }}</strong>--}}
                                    {{--</span>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">--}}
                        {{--<label class="col-md-4 control-label">Password</label>--}}

                        {{--<div class="col-md-6">--}}
                            {{--<input type="password" class="form-control" name="password">--}}

                            {{--@if ($errors->has('password'))--}}
                                {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                                    {{--</span>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">--}}
                        {{--<label class="col-md-4 control-label">Confirm Password</label>--}}
                        {{--<div class="col-md-6">--}}
                            {{--<input type="password" class="form-control" name="password_confirmation">--}}

                            {{--@if ($errors->has('password_confirmation'))--}}
                                {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('password_confirmation') }}</strong>--}}
                                    {{--</span>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="form-group">--}}
                        {{--<div class="col-md-6 col-md-offset-4">--}}
                            {{--<button type="submit" class="btn btn-primary">--}}
                                {{--<i class="fa fa-btn fa-refresh"></i>Reset Password--}}
                            {{--</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
@endsection