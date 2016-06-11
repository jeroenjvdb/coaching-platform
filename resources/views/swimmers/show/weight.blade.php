<button type="button" class="btn btn-primary btn-lg btn-full" data-toggle="modal" data-target="#weight">
    gewicht
</button>

<!-- Modal -->
<div class="modal fade" id="weight" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {!! Form::open(['route' => ['{group}.swimmer.weight',
        'group' => $group->slug,
        'swimmer' => $swimmer->slug,
    ], 'data-ajax' => 'false']) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-heartrate" id="myModalLabel">gewicht</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('weight', 'gewicht') !!}
                    {!! Form::number('weight', null, [
                        'class' => 'form-control',
                        'autocomplete' => 'off',
                        'step' => 0.1,
                    ]) !!} <br>
                </div>
                {{--<input type="checkbox" name></input>--}}
                {{--                {!! Form::checkbox('forgot', 'true',false, ['id' => 'forgot']) !!}--}}
                {{--                {!! Form::label('forgot') !!}--}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">sluiten</button>
                {!! Form::submit('verzenden', [
                    'class' => 'btn btn-primary',
                ]) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>