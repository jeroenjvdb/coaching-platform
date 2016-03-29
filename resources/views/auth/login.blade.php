@extends('layouts.landing')

@section('content')
    <div class="login-box ">
        <div class="in clearfix">
            {!! Form::open(['url' => '/login']) !!}
            <div class="visual">
                <!--<div class="face front"><img src="https://musketonmazda.com/resources/admin/images/login-user.gif">
                </div>
                <div class="face back">
                    <a href="#"><i class="fa fa-times"></i></a>
                    <img src="http://placehold.it/200x200">
                </div>-->
            </div>
            <div class="field fixed-user">
                Firstname Lastname
            </div>
            <div class="field user">
                {!! Form::text('email', null, ['placeholder' => 'email', 'autofocus', 'required']) !!}
            </div>
            <div class="field user">
                {!! Form::password('password', ['placeholder' => 'password', 'required']) !!}
            </div>

            <div class="field">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> Remember Me
                    </label>
                </div>
            </div>

            <div class="field user">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-sign-in"></i> inloggen
                    </button>

                </div>
            </div>

            <div class="field user">
                <a class="btn btn-danger" href="{{ url('/password/reset') }}" role="button">Forgot Your Password?</a>
            </div>



            {!! Form::close()  !!}


        </div>
    </div>
@stop
