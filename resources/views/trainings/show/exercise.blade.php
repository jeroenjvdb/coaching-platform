@if($editable)
    <div data-id="{{ $exercise->id }}" class="exercise exercise-row-{{ $exercise->id }} row"
         data-class="exercise" data-table="category-{{ $category->id }}">
        <div class="sort-bars col-xs-1"><i class="fa fa-bars"></i></div>
        {{--<td class="sort-bars"><i class="fa fa-bars"></i></td>--}}
        <div class="col-xs-4">
            <div class="row">
                <div class="col-xs-3">{{ $exercise->sets }}</div>
                <div class="col-xs-1"><i class="fa fa-times"></i></div>
                <div class="col-xs-6">{{ $exercise->meters }}</div>
            </div>
        </div>
        <div class="col-xs-5">
            {!! $exercise->description !!}
        </div>
        <div class="col-xs-2">
            <div class="row">
                <div class="col-xs-6 no-gutter">
                    <a href="#" data-toggle="exercise-row-{{ $exercise->id }}">
                        <i class="fa fa-pencil"></i>
                        <span class="sr-only">update</span>
                    </a>
                </div>
                <div class="col-xs-6 no-gutter">
                    {{--<a rel="external" ">--}}
                    {!! Form::open(['route' => [
                            'training.exercise.destroy',
                            'training_id' => $training->id,
                            'id' => $exercise->id
                        ], 'method' => 'delete',
                        'data-ajax' => 'false',
                    ]) !!}
                    <button type="submit" class="btn btn-default btn-no-border btn-lg">
                        <i class="fa fa-times"></i><span
                                class="sr-only">delete</span></a>
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="exercise-ui exercise-row-{{ $exercise->id }} row" data-is_form="true" hidden>
        {!! Form::open(['route' => [
            'training.exercise.update',
            'training_id' => $training->id,
            'id' => $exercise->id,
            ],
            'method' => 'PUT',
            'data-ajax' => "false",

            ]) !!}
        <div class="col-xs-6 col-md-4">
            <div class="row form-group">
                <div class="col-xs-5">
                    {!! Form::number('sets', $exercise->sets, [
                        'class' => 'form-control number',
                        'placeholder' => 'sets',

                    ]) !!}
                </div><!--
                            -->
                <div class="col-xs-1 no-gutter"><i class="fa fa-times"></i>
                </div><!--
                            -->
                <div class="col-xs-6">
                    {!! Form::number('meters', $exercise->meters, [
                        'class' => 'form-control number',
                        'placeholder' => 'meters',
                        'required',
                    ] ) !!}
                </div>
            </div>
        </div>
        <div class="col-xs-6 form-group">
            {!! Form::textarea('description', $exercise->textarea, [
                'class' => 'form-control',
                'rows' => 1,
                'placeholder' => 'beschrijving',
                'required'
            ]) !!}
        </div>

        <div class="col-xs-12 col-md-2 form-group">
            {!! Form::submit('opslaan', [
                'class' => 'btn btn-primary btn-full',
            ]) !!}
        </div>
    {{--<td>{{ $exercise->total }}</td>--}}
    {{--<td>{!! Form::submit() !!}</td>--}}
    {!! Form::close() !!}
    </div>
@else
    <div data-id="{{ $exercise->id }}" class="exercise exercise-row-{{ $exercise->id }} row"
         data-class="exercise" data-table="category-{{ $category->id }}">
        {{--<td class="sort-bars"><i class="fa fa-bars"></i></td>--}}
        <div class="col-xs-offset-1 col-xs-4">
            <div class="row">
                <div class="col-xs-3">{{ $exercise->sets }}</div>
                <div class="col-xs-1"><i class="fa fa-times"></i></div>
                <div class="col-xs-6">{{ $exercise->meters }}</div>
            </div>
        </div>
        <div class="col-xs-6">
            {!! $exercise->description !!}
        </div>
    </div>
@endif