<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Training aanpassen</h4>
            </div>
            <div class="modal-body">
                <h2>Tijdstip</h2>
                <p>Het begintijdstip aanpassen</p>
                {!! Form::open(['route' => ['training.update',  'id' => $training->id],
                                'data-ajax' => 'false',
                                'data-is_form' => 'true',
                                'data-form' => '',
                                'method' => 'put',
                            ]) !!}
                <fieldset class="form-group">
                    {!! Form::label('starttime', 'begin tijdstip') !!}
                    <div class="input-group">

                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    {!! Form::input('text', 'starttime', $training->starttime->format('Y-m-d H:i'), [
                        'class' => 'form-control datetimepicker',
                        'data-field' => 'datetime',
                        'readonly'
                    ]) !!}
                    </div>

                </fieldset>
                <fieldset class="form-group">
                    {!! Form::submit('verzenden', [
                        'class' => 'btn btn-primary btn-full',
                    ]) !!}
                </fieldset>
                {!! Form::close() !!}
                <div class="row">
                    <div class="col-xs-12">
                        <h2>Zwemmers</h2>
                <p>
                    Zwemmers toevoegen die deel moeten nemen aan deze training.
                </p>
                    </div>
                </div>

                {{ Form::open(['route' => ['{group}.training.swimmer',
                                                'group' => $group->slug,
                                                'training_id' => $training->id,
                                            ],
                            'data-ajax' => "false",
                            'class' => 'presences',
                            ]) }}
                <div class="row swimmers">
                    <div class="col-xs-12">

                    <ul class="users-list">
                        @foreach( $group->swimmers as $key => $swimmer )
                        <li>
                            <label>
                                {{ Form::checkbox('swimmers[]', $swimmer->id, $swimmers->contains('id', $swimmer->id) ? 'true' : false, ['id' => $swimmer->id,
                               'class' => 'input_change_checkbox',
                               'data-image' => $swimmer->getMeta('picture') ? $swimmer->getMeta('picture') : config('profile.picture'),
                           ]) }}
                                @if($swimmer->getMeta('picture'))
                                    <img src="{{ $swimmer->getMeta('picture') }}" alt="">
                                @else
                                    <img src="{{ config('profile.picture') }}"
                                         alt="">
                                @endif
                                <span class="users-list-name">
                                    {{ $swimmer->first_name }} {{ $swimmer->last_name }}
                                </span>
                            </label>

                        </li>
                            @endforeach
                    </ul>
                    </div>

                    {{--<div class="form-group">--}}

                        {{--@foreach($group->swimmers as $key => $swimmer)--}}
                            {{--@if($key > 0 && $key % 3 == 0)--}}
                                {{--<div class="clearfix visible-sm"></div>--}}
                            {{--@endif--}}
                            {{--@if($key > 0 && $key % 3 == 0)--}}
                                {{--<div class="clearfix visible-xs"></div>--}}
                            {{--@endif--}}
                            {{--@if($key > 0 && $key % 6 == 0)--}}
                                {{--<div class="clearfix visible-md"></div>--}}
                            {{--@endif--}}

                            {{--<div class="col-xs-4 col-md-2 no-gutter center">--}}
                                {{--<div class="swimmer swimmer-thumb center">--}}
                                    {{--{{ Form::checkbox('swimmers[]', $swimmer->id, $swimmers->contains('id', $swimmer->id) ? 'true' : false, ['id' => $swimmer->id,--}}
                                {{--'class' => 'input_change_checkbox',--}}
                                {{--'data-image' => $swimmer->getMeta('picture') ? $swimmer->getMeta('picture') : config('profile.picture'),--}}
                            {{--]) }}--}}
                                    {{--<label for="{{ $swimmer->id }}">--}}
                                        {{--<img src="{{ $swimmer->getMeta('picture') ? $swimmer->getMeta('picture') : config('profile.picture') }}" alt="">--}}
                                        {{--<span class="name">--}}
                                            {{--{{ $swimmer->full_name }}--}}
                                        {{--</span>--}}
                                    {{--</label>--}}
                                    {{--{{ Form::label($swimmer->id, $swimmer->first_name . ' ' . $swimmer->last_name, [--}}
                                        {{--'class' => 'sr-only'--}}
                                    {{--]) }}--}}

                                {{--</div>--}}
                            {{--</div>--}}

                        {{--@endforeach--}}
                    {{--</div>--}}

                </div>
                <div class="row">
                    <div class="col-xs-12">
                        {{ Form::submit('verzenden', [
                    'class' => 'btn btn-primary btn-full',
                ]) }}
                    </div>
                </div>
                {{ Form::close() }}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">sluiten</button>
            </div>
        </div>
    </div>
</div>
<div id="dtbox"></div>