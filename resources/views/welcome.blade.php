@extends('layouts.landing')

@section('title', 'home')

@section('content')
@if(Auth::user())
    <div class="container">
        <div class="row groups">
            <h1 class="text-center">Mijn groepen</h1>
            @foreach($groups as $group)
                <div class="col-lg-3 col-md-4 col-sm-6 field">
                    <a rel="external" href="{{ route('groups.show', ['group' => $group->slug]) }}"
                       class="btn btn-lg btn-primary" role="button">
                        {{ $group->name }}
                    </a>
                </div>
            @endforeach
            @if(Auth::user() && Auth::user()->clearance_level > 0)
                <div class="col-lg-3 col-md-4 col-sm-6 field">
                    <a href="{{ route('groups.create') }}"
                       class="btn btn-lg btn-primary" role="button" rel="external">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            @endif
            @if($is_swimmer)
                <div class="col-lg-3 col-md-4 col-sm-6 field">
                    <a href="{{ route('me.profile', [
                        'group' => $swimmer->group->slug
                      ]) }}" class="btn btn-lg btn-primary"
                       role="button" rel="external"
                    >me</a>
                </div>
                @endif
                        <!--<div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Welcome</div>
                    <div class="panel-body">
                        Your Application's Landing Page.
                    </div>
                </div>
            </div>-->
                <div class="col-lg-3 col-md-4 col-sm-6 field">
                    <a href="/logout" class="btn btn-lg btn-primary"
                       role="button" rel="external">
                        <i class="fa fa-sign-out"></i> Uitloggen
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 field">
                    <a href="/password" class="btn btn-lg btn-primary"
                       role="button" rel="external">
                        <i class="fa fa-key"></i> Wachtwoord
                    </a>
                </div>
        </div>
    </div>
@else
    <div class="login-box box box-danger">
        <div class="in clearfix">
            {!! Form::open(['url' => '/login']) !!}
            <div class="visual">
                <div class="face front"><img src="/resources/img/launcher-icon-4x.png">
                </div>
                <!--<div class="face back">
                    <a href="#"><i class="fa fa-times"></i></a>
                    <img src="http://placehold.it/200x200">
                </div>-->
            </div>

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
                <a class="btn btn-danger" href="{{ url('/password/reset') }}" role="button">Wachtwoord vergeven?</a>
            </div>



            {!! Form::close()  !!}


        </div>
    </div>
@endif
@endsection