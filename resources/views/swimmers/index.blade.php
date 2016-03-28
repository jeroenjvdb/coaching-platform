@extends('layouts.master')

@section('content')
{{-- section content --}}
@foreach($swimmers as $swimmer)
	<a href="{{ route('swimmers.show', [
							'group' => $group->slug,
							'swimmer'  => $swimmer->slug
						]) }}">{{ $swimmer->name }}</a></br>
@endforeach

@stop