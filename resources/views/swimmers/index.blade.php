@extends('layouts.master')

@section('content')
{{-- section content --}}
@foreach($swimmers as $swimmer)
	<a rel="external" href="{{ route('swimmers.show', [
							'group' => $group->slug,
							'swimmer'  => $swimmer->slug
						]) }}">{{ $swimmer->first_name }} {{ $swimmer->last_name }}</a></br>
@endforeach

@stop