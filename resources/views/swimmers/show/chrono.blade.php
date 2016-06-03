<h2>stopwatch <a href="#" data-toggle="stopwatch-create">
        <i class="fa fa-plus"></i>
    </a></h2>

{!! Form::open(['route' => ['{group}.stopwatch.store.api',
        'group' => $group->slug,
    ],
    'data-ajax' => 'true',
    'hidden',
    'class' => 'stopwatch-create',
    'data-is_form' => 'true',
]) !!}

{!! Form::hidden('swimmer', $swimmer->id) !!}
{!! Form::label('distance') !!}
<select name="distance" id="">
    @foreach($strokes as $stroke)
        @foreach($stroke->distances as $distance)
            <option value="{{ $distance->id }}">{{ $stroke->name }} - {{ $distance->distance }}</option>
        @endforeach
    @endforeach
</select>
{!! Form::submit() !!}

{!! Form::close() !!}

{{--<div class="stopwatch" data-base3="false" data-user_id="{{ 'test' }}" ></div>--}}
<div id="newStopwatch"></div>


{{--@foreach($stopwatches as $stopwatch)--}}
    {{--<a href="{{ route('{group}.stopwatch.show', [--}}
                        {{--'group' => $group->slug,--}}
                        {{--'id' => $stopwatch->id,--}}
                        {{--]) }}">--}}
        {{--{{ $stopwatch->distance->distance }}--}}
        {{--{{ $stopwatch->distance->stroke->name }}--}}
    {{--</a></br>--}}
{{--@endforeach--}}