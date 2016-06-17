@extends('layouts.master')

@section('title', 'mail')

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-push-1">
            <h1>Mail</h1>

                    {{--<div class="col-md-4">--}}
                    {{--<div class="box box-danger">--}}
                    {{--<div class="box-header">--}}
                    {{--<h2>recipiënten</h2>--}}
                    {{--</div>--}}
                    {{--<div class="box-body">--}}

                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                            <!-- /.col -->
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h2 class="">Nieuw Bericht Schrijven</h2>
                            </div>
                            <!-- /.box-header -->
                            {!! Form::open(['route' => [
                                    '{group}.mail.send',
                                    'group' => $group->slug,
                                ],
                                'files' => 'true',
                            ]) !!}
                            <div class="box-body">
                                <div class="form-group">
                                    {{--{!! Form::text('to', null, [--}}
                                    {{--'placeholder' => 'Naar:',--}}
                                    {{--'class' => 'form-control',--}}
                                    {{--]) !!}--}}
                                    <div class="form-group">
                                        {!! Form::checkbox('to-all', 'all', false, [
                                            'data-all' => 'true',
                                            'data-checkbox' => 'to',
                                            'class' => 'line',
                                        ]) !!}
                                        <label>
                                            Iedereen
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::checkbox('to[]', 'swimmers', false, [
                                            'data-name' => 'to',
                                            'class' => 'line',
                                        ]) !!}
                                        <label>
                                            Zwemmers
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::checkbox('to[]', 'coaches', false, [
                                            'data-name' => 'to',
                                            'class' => 'line',
                                        ]) !!}
                                        <label>
                                            Coaches
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::checkbox('to[]', 'parents', false,[
                                            'data-name' => 'to',
                                            'class' => 'line',
                                        ] ) !!}
                                        <label>
                                            Ouders

                                        </label>
                                    </div>
                                    {{--<input class="form-control" name="to" placeholder="To:">--}}
                                </div>
                                <div class="form-group">
                                    {!! Form::text('subject', null, [
                                        'placeholder' => 'Onderwerp:',
                                        'class' => 'form-control',
                                    ]) !!}
                                    {{--<input class="form-control" name="subject" placeholder="Subject:">--}}
                                </div>
                                <div class="form-group">
                                    {!! Form::textarea('message', null, [
                                        'id' => 'compose-textarea',
                                        'placeholder' => 'Bericht',
                                        'class' => 'form-control',
                                        'rows' => '10',
                                    ]) !!}
                                    {{--<textarea id="compose-textarea" class="form-control" name="message" style="height: 300px">--}}

                                    {{--</textarea>--}}
                                </div>
                                <div class="form-group">
                                    <div class="btn btn-default btn-file">
                                        <i class="fa fa-paperclip"></i> Attachment
                                        {{--<input type="file" name="attachment">--}}
                                        {!! Form::file('attachment') !!}
                                    </div>
                                    <p class="help-block">Max. 32MB</p>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="pull-right">
                                    {{--<button type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Draft--}}
                                    {{--</button>--}}
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Verzenden
                                    </button>
                                </div>
                                {{--<button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard--}}
                                {{--</button>--}}
                            </div>
                            <!-- /.box-footer -->
                            {!! Form::close() !!}
                        </div>
                        <!-- /. box -->

        </div>
    </div>
@stop