<h2>Aandachtspunten</h2>
@if(!$myProfile)
    {!! Form::open(['route' => ['{group}.swimmer.meta.store',
        'group' => $group->slug,
        'swimmer' => $swimmer->slug
    ],'files' => true,
    'data-ajax' => "false"]) !!}
@else
    {!! Form::open(['route' => ['me.reaction.store', 'group' => $swimmer->group->slug], 'files' => true]) !!}
@endif
<fieldset class="form-group">
    {!! Form::label('message') !!}
    {!! Form::textarea('message', null, [
        'class' => 'form-control'
    ]) !!}
</fieldset>
<fieldset class="form-group">
    <span class="btn btn-default btn-file">
        <i class="fa fa-upload"></i> Upload media {!! Form::file('media') !!}
    </span>

</fieldset>

{!! Form::submit('verzenden', [
    'class' => 'btn btn-primary',
]) !!}

{!! Form::close() !!}

        @if(isset($meta['meta']))
            @foreach($meta['meta'] as $data)
                <div class="data {{ $data->type }} {{ ($data->response) ? 'response' : '' }}">
                    <div class="pull-right">
                        {{ $data->date->format('2 F, g:ia') }}
                    </div>
                    @if($data->type == 'data' )
                        {{ $data->message }}
                        @if($data->media && isset($data->media['type']))
                            test
                            <hr>
                            @if( $data->media['type'] == 'img')
                                <img src="{{ $data->media['url'] }}" alt="">
                            @elseif( $data->media['type'] == 'vid' )
                                <video src="{{ $data->media['url'] }}" controls></video>
                            @endif
                        @endif
                    @elseif($data->type == 'chrono')
                        <a href="{{ route('{group}.stopwatch.show', [
                        'group' => $group->slug,
                        'id' => $data->message->id,
                        ]) }}">
                            {{ $data->message->distance->distance }}
                            {{ $data->message->distance->stroke->name }}
                        </a>
                        <div class="row stopwatch-ui">
                            @foreach($data->message->times as $time)
                                <div class="col-md-3 col-xs-6">
                                    @foreach($time->full_time->arr as $char)
                                        <div class="cell">{{ $char }}</div>@endforeach
                                </div>
                                <div class="col-md-3 col-xs-6 split">
                                   @foreach($time->split->arr as $char)
                                        <div class="cell">{{ $char }}</div>@endforeach
                                </div>
                            @endforeach
                        </div>
                    @elseif($data->type == 'heartRate')
                        {{ $data->message }}
                    @endif
                </div>
            @endforeach
        @endif
