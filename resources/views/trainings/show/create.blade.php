@if($editable)
{!! Form::open(['route' => [
        '{group}.training.exercise.store',
        'group' => $group->slug,
        'id' => $training->id
    ],
    'data-ajax' => "false",
    'class' => 'exercise-ui row add-exercise-' . $category->id ,
    'data-is_form' => 'true',
    'hidden'
]) !!}
<fieldset class="form-group col-xs-7">
    <div class="col-xs-5">
        {!! Form::label('sets', 'sets', [
            'class' => 'sr-only',
        ]) !!}
        {!! Form::input('number', 'sets', null, [
            'class' => 'form-control number',
            'autocomplete' => 'off',
            'placeholder' => 'sets'
        ]) !!}
    </div>
    <div class="col-xs-2 center">
        <i class="fa fa-times"></i>
    </div>
    <div class="col-xs-5">
        {!! Form::label('meters', 'meter', [
            'class' => 'sr-only'
        ]) !!}
        {!! Form::input('number', 'meters', null, [
            'class' => 'form-control number',
            'autocomplete' => 'off',
            'placeholder' => 'meter',
        ]) !!}
    </div>
</fieldset>
<div class="form-group col-xs-5">
    {!! Form::label('description', 'beschrijving', [
        'class' => 'sr-only',
    ]) !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'rows' => 2,
        'placeholder' => 'beschrijving',
    ]) !!}
</div>
{{ Form::hidden('cat_id', $category->id ) }}
<fieldset class="form-group col-md-12">
    {!! Form::submit('verzenden', [
    'class' => 'btn btn-primary'
]) !!}
</fieldset>
{!! Form::close() !!}
    @endif