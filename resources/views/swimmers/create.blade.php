@extends('layouts.master')

@section('title', 'create swimmer')

@section('content')
	<h1>Create swimmer</h1>
	{!! Form::open(['method' => 'POST', 'route' => ['swimmers.store', 'group' => $group->slug]]) !!}
		{!! Form::label('last_name', 'last name') !!}
		{!! Form::text('last_name', null, ['id' => 'lastName']) !!}</br>
		{!! Form::label('first_name', 'first name') !!}
		{!! Form::text('first_name', null, ['id' => 'firstName']) !!}</br>
		{!! Form::label('swimrankings') !!}
		{!! Form::text('swimrankings') !!}</br>
		{!! Form::submit() !!}
	{!! Form::close() !!}
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function()
		{
			
			// $('input').on('keyup', getSwimmers);

			function getSwimmers(e)
			{
				var fName = $('input#firstName').val();
				var lName = $('input#lastName').val();
				var url = 'https://www.swimrankings.net/index.php?&internalRequest=athleteFind&athlete_clubId=-1&athlete_gender=-1&athlete_lastname=' + lName + '&athlete_firstname=' + fName;
				console.log(url);
				$.get(url, null, showSwimmers, 'html');
			}

			function showSwimmers(data)
			{
				console.log(data);
			}

		});

	</script>
@stop