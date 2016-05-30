@extends('layouts.master')

@section('content')
    {!! Breadcrumbs::render('trainings.index', $group) !!}
    <h1>trainingen</h1>
    <a rel="external" href="{{ route('trainings.create', [
        'group' => $group->slug,
    ]) }}">create</a>

    {!! Form::open(['route' => ['trainings.store', 'group' => $group->slug],
        'data-ajax' => 'false',
        'hidden',
        'data-is_form' => 'true',
        'data-form' => ''
    ]) !!}
    <fieldset class="form-group">
        {!! Form::label('starttime') !!}
        {!! Form::input('datetime-local', 'starttime', null, [
            'class' => 'form-control',
        ]) !!}
    </fieldset>
    <fieldset class="form-group">
        {!! Form::submit('verzenden', [
            'class' => 'btn btn-primary',
        ]) !!}
    </fieldset>
    {!! Form::close() !!}
    <ul>
        @foreach($trainings as $training)
            <li><a rel="external" href="{{ route('trainings.show', [
                                        'group' => $group->slug,
                                        'id' => $training->id
                                    ]) }}">{{ $training->starttime->formatLocalized('%A %d %B %P') }}</a> - {{ $training->total }}m</li>
        @endforeach
    </ul>

    <div class="calendar" data-url="{{ route('trainings.get', [
        'group' => $group->slug
    ]) }}"></div>


@stop

@section('scripts')
   {{-- <script src="/resources/js/jquery.min.js"></script>
    <script src="/resources/js/jquery-ui.custom.min.js"></script>
    <script src="/resources/js/moment.min.js"></script>
    <script>
        $(document).ready(function(){
            console.log('ready');
        });
    </script>--}}
@stop