@if($editable)
<h2>Aanwezigheden</h2>
{{ Form::open(['route' => ['{group}.training.presences.store',
                                'group' => $group->slug,
                                'training_id' => $training->id,
                            ],
            'data-ajax' => "false",
            'class' => 'presences',
            ]) }}
<div class="row swimmers">
    @foreach($swimmers as $key => $swimmer)
        @if($key > 0 && $key % 2 == 0)
            <div class="clearfix visible-xs"></div>
        @endif
        @if($key > 0 && $key % 3 == 0)
            <div class="clearfix visible-sm"></div>
        @endif
        @if($key > 0 && $key % 4 == 0)
            <div class="clearfix visible-md"></div>
        @endif
        @if($key > 0 && $key % 6 == 0)
            <div class="clearfix visible-lg"></div>
        @endif
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 no-gutter center">
            <div class="swimmer swimmer-thumb center">
                {{ Form::checkbox('swimmers[]', $swimmer->id, $swimmer->pivot->is_present, [
                        'id' => 'presences-' . $swimmer->id,
                        'class' => ' input_change_checkbox ' . $swimmer->pivot->is_present,
                        'data-image' => $swimmer->getMeta('picture') ? $swimmer->getMeta('picture') : config('profile.picture'),
                    ]) }}
                {{--<input type='checkbox' name='thing' value='valuable' id="thing"/>--}}
                <label for="{{ 'presences-' . $swimmer->id }}">
                    <img src="{{ $swimmer->getMeta('picture') ? $swimmer->getMeta('picture') : config('profile.picture') }}" alt="">
                    <span class="name">{{ $swimmer->full_name }}</span>
                </label>
                {{--<div class="thumbnail center swimmer-thumb {{ $swimmer->pivot->is_present ? 'checked' : '' }}">--}}
                    {{--<img src="{{ $swimmer->getMeta('picture') ? $swimmer->getMeta('picture') : config('profile.picture') }}" alt="">--}}
                {{--</div>--}}
{{--                {{ Form::label($swimmer->id, $swimmer->first_name . ' ' . $swimmer->last_name) }}--}}
            </div>

        </div>

    @endforeach
</div>
    <div class="form-group">
        {{ Form::submit('verzenden', [
            'class' => 'btn btn-primary btn-full',
        ]) }}
    </div>
{{ Form::close() }}
    @endif