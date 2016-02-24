@extends('layouts.master')

@section('content')
{{-- section content --}}
@foreach($swimmers as $swimmer)
	<a href="{{ route('swimmers.show', $swimmer->id) }}">{{ $swimmer->name }}</a>
@endforeach

@stop