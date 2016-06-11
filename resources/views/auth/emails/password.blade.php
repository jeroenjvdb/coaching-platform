@extends('layouts.landing')

@section('content')
    <div class="box box-danger">
        <div class="box-body">
        Click here to reset your password: <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
        </div>
    </div>
@stop