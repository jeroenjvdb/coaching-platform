@extends('layouts.master')

@section('title', 'zwemmer toevoegen')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            <h1>Create swimmer</h1>
            <div class="box box-danger">
                <div class="box-body">

                    {!! Form::open([
                        'method' => 'POST',
                        'route' => [
                            '{group}.swimmer.store',
                            'group' => $group->slug
                        ],
                        'data-ajax' => 'false',
                    ]) !!}
                    <div class="form-group">
                        {!! Form::label('first_name', 'voornaam') !!}
                        {!! Form::text('first_name', null, [
                            'id' => 'firstName',
                            'class' => 'form-control'
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('last_name', 'achternaam') !!}
                        {!! Form::text('last_name', null, [
                    'id' => 'lastName',
                    'class' => 'form-control'
                    ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('email') !!}
                        {!! Form::email('email', null, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('swimrankings') !!}
                        {!! Form::text('swimrankings', null, [
                            'class' => 'form-control'
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('toevoegen', [
                            'class' => 'btn btn-primary btn-full',
                        ]) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            // $('input').on('keyup', getSwimmers);

            function getSwimmers(e) {
                var fName = $('input#firstName').val();
                var lName = $('input#lastName').val();
                var url = 'https://www.swimrankings.net/index.php?&internalRequest=athleteFind&athlete_clubId=-1&athlete_gender=-1&athlete_lastname=' + lName + '&athlete_firstname=' + fName;
                console.log(url);
                $.get(url, null, showSwimmers, 'html');
            }

            function showSwimmers(data) {
                console.log(data);
            }

        });

    </script>
@stop