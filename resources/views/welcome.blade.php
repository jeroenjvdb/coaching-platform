@extends('layouts.landing')

@section('content')
<div class="container">
    <div class="row groups">
        <h1>mijn groepen</h1>
        @foreach($groups as $group)
            <div class="col-md-4">
                <a rel="external" href="{{ route('groups.show', ['group' => $group->slug]) }}" class="btn btn-lg btn-primary" role="button" width="100%">
                    {{ $group->name }}
                </a>
            </div>
        @endforeach
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
