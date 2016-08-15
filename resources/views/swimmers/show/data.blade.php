<h2>Aandachtspunten</h2>
@if($myProfile || Auth::user()->clearance_level > 0)

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
@endif
@if(isset($meta['meta']))
    <ul class="timeline">

        @foreach($meta['meta'] as $dateGroup)
            <li class="time-label">
        <span class="bg-red">
            {{ $dateGroup['date']->format('j F') }}
        </span>
            </li>

            @foreach($dateGroup['item'] as $data)
                <li>
                    <!-- timeline icon -->
                    <!-- <div class="">
                    <div class="pull-right">
                            </div>-->

                    @if($data->type == 'data' )
                        <i class="fa fa-envelope bg-blue"></i>

                        <div class="timeline-item">

                            <span class="time"><i class="fa fa-clock-o"></i> {{ $data->date->hour }}:{{ $data->date->minute }}</span>
                            <h3 class="timeline-header">{{ $data->user->name }}</h3>
                            <div class="timeline-body">
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
                            </div>

                            @elseif($data->type == 'chrono')
                                <i class="fa fa-clock-o bg-blue"></i>

                                <div class="timeline-item">

                                    <span class="time"><i class="fa fa-clock-o"></i> {{ $data->date->hour }}:{{ $data->date->minute }}</span>
                                    <h3 class="timeline-header"><a href="{{ route('stopwatch.show', [
                        'id' => $data->message->id,
                        ]) }}">
                                            {{ $data->message->distance->distance }}
                                            {{ $data->message->distance->stroke->name }}
                                        </a></h3>

                                    <div class="timeline-body">

                                        <div class="row stopwatch-ui">
                                            <?php $i = 0; ?>
                                            @foreach($data->message->times as $key => $time)
                                                <div class="col-lg-3 col-md-6 col-xs-12">
                                                    @foreach($time->full_time->arr as $char)
                                                        <div class="cell">{{ $char }}</div>@endforeach
                                                </div>
                                                <div class="col-lg-3 col-md-6 col-xs-12 small">
                                                    @foreach($time->split->arr as $char)
                                                        <div class="cell">{{ $char }}</div>@endforeach
                                                </div>
                                                <div class="clearfix visible-md"></div>
                                                @if($i != 0 && $i % 2 != 0)
                                                    <div class="clearfix visible-lg"></div>
                                                @endif
                                                <?php $i++; ?>
                                            @endforeach
                                        </div>
                                    </div>

                                    @elseif($data->type == 'heartRate')
                                        <i class="fa fa-heart bg-red"></i>

                                        <div class="timeline-item">

                                            <span class="time"><i class="fa fa-clock-o"></i> {{ $data->date->hour }}:{{ $data->date->minute }}</span>
                                            <h3 class="timeline-header">Ochtendpols</h3>
                                            <div class="timeline-body">
                                                {{ $data->message }}
                                            </div>
                                            @endif
                                                    <!-- <div class="timeline-footer">
                <a class="btn btn-primary btn-xs">...</a>
            </div> -->
                                        </div>
                </li>
            @endforeach
        @endforeach
            <li id="read-more" class="time-label">
        <span  class="bg-red">
            <a href="#" data-load-page="2" data-url="{{ route('swimmer.data.get', [
                'swimmer' => $swimmer->slug
            ]) }}">Meer laden</a>
        </span>
            </li>

    </ul>
@endif
