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
            <div class="col-xs-6">
                <a href="#" data-toggle="exercise-row-{{ $exercise->id }}">
                    <i class="fa fa-pencil"></i>
                    <span class="sr-only">update</span>
                </a>
            </div>
            <div class="col-xs-6">
                <a rel="external" href="{{ route('exercises.delete', [
                                                    'group' => $group->slug,
                                                    'training_id' => $training->id,
                                                    'id' => $exercise->id
                                                ]) }}"><i class="fa fa-times"></i><span
                            class="sr-only">delete</span></a>
            </div>
        </div>
    </div>
</div>
<div class="exercise-ui exercise-row-{{ $exercise->id }} row" data-is_form="true" hidden>
    {!! Form::open(['route' => [
        'exercises.update',
        'group' => $group->slug,
        'training_id' => $training->id,
        'id' => $exercise->id,
        ],
        'data-ajax' => "false",

        ]) !!}
    <div class="col-xs-6 col-md-4">
        <div class="row">
            <div class="col-xs-5">
                {!! Form::number('sets', $exercise->sets, [
                    'class' => 'form-control number'
                ]) !!}
            </div><!--
                            -->
            <div class="col-xs-1 no-gutter"><i class="fa fa-times"></i>
            </div><!--
                            -->
            <div class="col-xs-6">
                {!! Form::number('meters', $exercise->meters, [
                    'class' => 'form-control number',
                ] ) !!}
            </div>
        </div>
    </div>
    <div class="col-xs-6">
        {!! Form::textarea('description', $exercise->description, [
            'class' => 'form-control',
            'rows' => 1
        ]) !!}
    </div>
    <div class="col-xs-2">
        {!! Form::submit() !!}
    </div>
    {{--<td>{{ $exercise->total }}</td>--}}
    {{--<td>{!! Form::submit() !!}</td>--}}
    {!! Form::close() !!}
</div>