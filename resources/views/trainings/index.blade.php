@extends('layouts.master')

@section('title', 'alle trainingen')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            {{--    {!! Breadcrumbs::render('trainings.index', $group) !!}--}}
            <h1>Trainingen</h1>
            <div class="row">
                @if($editable)
                    <div class="col-md-4">
                        <div class="box box-danger">
                            <div class="box-body">
                                <h3>training toevoegen</h3>
                                {!! Form::open(['route' => ['{group}.training.store', 'group' => $group->slug],
                    'data-ajax' => 'false',
                    'data-is_form' => 'true',
                    'data-form' => ''
                ]) !!}
                                <fieldset class="form-group">
                                    {!! Form::label('starttime') !!}
                                    {!! Form::input('datetime-local', 'starttime', date('Y-m-d\Th:i'), [
                                        'class' => 'form-control datetimepicker',
                                    ]) !!}

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
    </div>


@stop