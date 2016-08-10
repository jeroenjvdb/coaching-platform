@if($editable)
{!! Form::open(['route' => [
        'training.exercise.store',
        'id' => $training->id
    ],
    'data-ajax' => "false",
    'class' => 'exercise-ui row add-exercise-' . $category->id ,
    'data-is_form' => 'true',
    'hidden'
]) !!}
<div class="col-xs-6 col-md-4">
    <div class="row form-group">
        <div class="col-xs-5">
            {!! Form::number('sets', null, [
                'class' => 'form-control number',
                'placeholder' => 'sets',

            ]) !!}
        </div><!--
                            -->
        <div class="col-xs-1 no-gutter"><i class="fa fa-times"></i>
        </div><!--
                            -->
        <div class="col-xs-6">
            {!! Form::number('meters', null, [
                'class' => 'form-control number',
                'placeholder' => 'meters',
                'required',
            ] ) !!}
        </div>
    </div>
</div>
<div class="col-xs-6">
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'rows' => 1,
        'placeholder' => 'beschrijving',
        'required',
    ]) !!}
</div>

{{ Form::hidden('cat_id', $category->id ) }}
<div class="col-xs-12 col-md-2">
    <div class="form-group">
    {!! Form::submit('opslaan', [
        'class' => 'btn btn-primary btn-full',
    ]) !!}
    </div>
</div>
</fieldset>
{!! Form::close() !!}
    @endif