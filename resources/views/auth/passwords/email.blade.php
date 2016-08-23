@extends('layouts.landing')

@section('title', 'Reset Wachtwoord')
        <!-- Main Content -->
@section('content')
    <div class="box box-danger login-box">
        <div class="panel-heading">
            <h3>Reset Wachtwoord</h3>
            <a href="/">
                <div class="return">
                    <h3>&lt</h3>
                </div>
            </a>
        </div>
        <div class="box-body">

            <div class="visual" style="margin-bottom: 30px;">
                <div class="face front"><img src="/resources/img/launcher-icon-4x.png">
                </div>
                <!--<div class="face back">
                    <a href="#"><i class="fa fa-times"></i></a>
                    <img src="http://placehold.it/200x200">
                </div>-->
            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif



            {!! Form::open(['url' => '/password/email']) !!}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="control-label">E-Mail Address</label>

                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                </div>

                <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-full">
                            <i class="fa fa-btn fa-envelope"></i> Verstuur wachtwoord reset link
                        </button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
