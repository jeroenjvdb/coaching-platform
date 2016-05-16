@if(!$myProfile)
    {!! Form::open(['route' => ['swimmers.meta.store',
        'group' => $group->slug,
        'swimmer' => $swimmer->slug
    ],'files' => true]) !!}
@else
    {!! Form::open(['route' => ['me.reaction.store'], 'files' => true]) !!}
@endif
<fieldset class="form-group">
    {!! Form::label('message') !!}
    {!! Form::textarea('message', null, [
        'class' => 'form-control'
    ]) !!}
</fieldset>
<fieldset class="form-group">
    <span class="btn btn-default btn-file">
        <i class="fa fa-upload"></i> upload media {!! Form::file('media') !!}
    </span>

</fieldset>

{!! Form::submit('verzenden', [
    'class' => 'btn btn-primary',
]) !!}

{!! Form::close() !!}

@if(isset($meta['meta']))
    @foreach($meta['meta'] as $data)
        <div class="data {{ $data->type }} {{ ($data->response) ? 'response' : '' }}">
            @if($data->type == 'data' )
                {{ $data->message }}
                @if($data->media)
                    <hr>
                    <img src="{{ $data->media }}" alt="">
                @endif
            @elseif($data->type == 'chrono')
                <a href="{{ route('stopwatches.show', [
                        'group' => $group->slug,
                        'id' => $data->message->id,
                        ]) }}">
                    {{ $data->message->distance->distance }}
                    {{ $data->message->distance->stroke->name }}
                </a>
            @elseif($data->type == 'heartRate')
                {{ $data->message }}
            @endif
        </div>
    @endforeach
@endif
