@extends('layouts.master')

@section('content')
{{--    {!! Breadcrumbs::render('trainings.index', $group) !!}--}}
    <h1>trainingen</h1>
    {{--<a rel="external" href="{{ route('trainings.create', [--}}
        {{--'group' => $group->slug,--}}
    {{--]) }}">create</a>--}}

    {{--<ul>--}}
        {{--@foreach($trainings as $training)--}}
            {{--<li><a rel="external" href="{{ route('trainings.show', [--}}
                                        {{--'group' => $group->slug,--}}
                                        {{--'id' => $training->id--}}
                                    {{--]) }}">{{ $training->starttime->formatLocalized('%A %d %B %P') }}</a>--}}
                {{--- {{ $training->total }}m--}}
            {{--</li>--}}
        {{--@endforeach--}}
    {{--</ul>--}}
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
                            'class' => 'btn btn-primary',
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