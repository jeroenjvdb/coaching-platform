@extends('layouts.landing')

@section('title', 'home')

@section('content')
    <div class="container">
        <div class="row groups">
            <h1>mijn groepen</h1>
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
                        <i class="fa fa-sign-out"></i> uitloggen
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 field">
                    <a href="/password" class="btn btn-lg btn-primary"
                       role="button" rel="external">
                        <i class="fa fa-key"></i> wachtwoord
                    </a>
                </div>
        </div>
    </div>
@endsection