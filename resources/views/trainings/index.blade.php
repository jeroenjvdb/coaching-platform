@extends('layouts.master')

@section('title', 'alle trainingen')

@section('content')
    <div class="row">

            {{--    {!! Breadcrumbs::render('trainings.index', $group) !!}--}}
            <h1>Trainingen</h1>
            <div class="row">
                @if($editable)
                    <div class="col-md-4">
                        <div class="box box-danger">
                            <div class="box-body">
                                <h3>Training toevoegen</h3>
                                {!! Form::open(['route' => ['training.store', 'group' => $group->slug],
                    'data-ajax' => 'false',
                    'data-is_form' => 'true',
                    'data-form' => ''
                ]) !!}
                                <fieldset class="form-group">
                                    {!! Form::label('starttime', 'Begin tijdstip') !!}
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    {!! Form::input('text', 'starttime',null, [
                                        'class' => 'form-control datetimepicker datetime-box',
                                        'data-field' => "datetime",
                                        'read-only',
                                    ]) !!}
                                    </div>


                                </fieldset>
                                <fieldset class="form-group">
                                    {!! Form::submit('verzenden', [
                                        'class' => 'btn btn-primary btn-full',
                                    ]) !!}
                                </fieldset>
                                {!! Form::close() !!}

                            </div>
                        </div>
                    </div>
                    <div id="dtbox"></div>
                @endif
                <div class="col-md-8 {{(!$editable) ? 'col-md-offset-2' :''}}">
                    <div class="box box-danger">
                        <div class="box-body box-no-padding">
                            <div class="calendar" data-url="{{ route('{group}.training.get', [
        'group' => $group->slug
    ]) }}"></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>


@stop