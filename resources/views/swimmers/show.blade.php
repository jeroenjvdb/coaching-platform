@extends('layouts.master')

@section('title', $swimmer->name . ' profile')

@section('content')

	<h1>{{ $swimmer->first_name }}</h1>
	{{--	{!! $personalBests !!}--}}
	<h2>presence</h2>
	{{ $swimmer->presence * 100 }}%
@stop