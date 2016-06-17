<h2>Stopwatch</h2>
<div class="row">
    <div class="col-md-4">
        <div class="box box-danger">
            <div class="box-header">
                <h3>Nieuwe stopwatch aanmaken</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['route' => ['{group}.stopwatch.store.api',
            'group' => $group->slug,
        ],
        'data-ajax' => 'true',
        'class' => 'stopwatch-create',
        'data-is_form' => 'true',
    ]) !!}

                {!! Form::hidden('swimmer', $swimmer->id) !!}
                <div class="form-group">
                    {!! Form::label('distance') !!}<br>
                    <select name="distance" class="select2 form-control" id="">
                        @foreach($strokes as $stroke)
                            @foreach($stroke->distances as $distance)
                                <option value="{{ $distance->id }}">{{ $stroke->name }} - {{ $distance->distance }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                {!! Form::submit('stopwatch aanmaken', [
                    'class' => 'btn btn-primary btn-full',
                ]) !!}
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div id="newStopwatch"></div>
    </div>
</div>
{{--<div class="stopwatch" data-base3="false" data-user_id="{{ 'test' }}" ></div>--}}


{{--@foreach($stopwatches as $stopwatch)--}}
{{--<a href="{{ route('{group}.stopwatch.show', [--}}
{{--'group' => $group->slug,--}}
{{--'id' => $stopwatch->id,--}}
{{--]) }}">--}}
{{--{{ $stopwatch->distance->distance }}--}}
{{--{{ $stopwatch->distance->stroke->name }}--}}
{{--</a></br>--}}
{{--@endforeach--}}