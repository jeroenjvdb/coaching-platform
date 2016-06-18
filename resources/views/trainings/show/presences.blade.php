@if($editable)
<h2>presences</h2>
{{ Form::open(['route' => ['{group}.training.presences.store',
                                'group' => $group->slug,
                                'training_id' => $training->id,
                            ],
            'data-ajax' => "false",
            'class' => 'presences',
            ]) }}
<div class="row">
    @foreach($swimmers as $key => $swimmer)
        @if($key > 0 && $key % 4 == 0)
            <div class="clearfix visible-sm"></div>
        @endif
        @if($key > 0 && $key % 3 == 0)
            <div class="clearfix visible-xs"></div>
        @endif
        @if($key > 0 && $key % 6 == 0)
            <div class="clearfix visible-md"></div>
        @endif

        <div class="col-xs-4 col-sm-3 col-md-2">{{ Form::checkbox('swimmers[]', $swimmer->id, $swimmer->present, ['id' => $swimmer->id,
                        'class' => 'input_change_checkbox',
                        'data-image' => $swimmer->getMeta('picture') ? $swimmer->getMeta('picture') : config('profile.picture'),
                    ]) }}
            {{ Form::label($swimmer->id, $swimmer->first_name . ' ' . $swimmer->last_name) }}
        </div>

    @endforeach
</div>
{{ Form::submit('verzenden', [
    'class' => 'btn btn-primary',
]) }}
{{ Form::close() }}
    @endif