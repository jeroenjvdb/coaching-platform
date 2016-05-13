<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
heartRate
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    {!! Form::open(['route' => ['me.heartRate']]) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">ochtendpols</h4>
            </div>
            <div class="modal-body">
                {!! Form::label('heartRate') !!}
                {!! Form::text('heartRate') !!} <br>
                {{--<input type="checkbox" name></input>--}}
                {!! Form::checkbox('forgot', 'true',false, ['id' => 'forgot']) !!}
                {!! Form::label('forgot') !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {!! Form::submit() !!}
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>