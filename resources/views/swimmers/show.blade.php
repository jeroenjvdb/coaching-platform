@extends('layouts.master')

@section('title', $swimmer->name . ' profile')

@section('content')

	<h1>{{ $swimmer->name }}</h1>
	{!! $personalBests !!}

@stop