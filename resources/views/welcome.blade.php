@extends('layouts.landing')

@section('content')
    <div class="container">
        <div class="row groups">
            <h1>mijn groepen</h1>
            @foreach($groups as $group)
                <div class="col-xs-4">
                    <a rel="external" href="{{ route('groups.show', ['group' => $group->slug]) }}"
                       class="btn btn-lg btn-primary" role="button">
                        {{ $group->name }}
                    </a>
                </div>
            @endforeach
            @if(Auth::user() && Auth::user()->clearance_level > 0)
            <div class="col-xs-4">
                <a href="{{ route('groups.create') }}"
                    class="btn btn-lg btn-primary" role="button" rel="external">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            @endif
            @if($is_swimmer)
                  <div class="col-cs-4">
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
        </div>
    </div>
@endsection
