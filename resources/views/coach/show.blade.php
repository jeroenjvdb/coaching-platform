@extends('layouts.master')

@section('content')
    <div class="row">
    <h2>Contact</h2>
    <div class="row swimmer">
        <div class="col-xs-12  col-md-6">
            <div class="box box-danger">
                <div class="box-body box-profile">
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="#" class="profile-img-edit text-center" data-toggle="picture">
                                <img class="profile-user-img img-responsive img-circle " id="image-start"
                                     @if($contact['picture'])
                                     src="{{ $contact['picture'] }}"
                                     @else
                                     src="http://library.unn.edu.ng/wp-content/uploads/sites/42/2016/03/prifile-pic.png"
                                     @endif
                                     alt="">
                                <i class="fa fa-pencil edit-profile"></i>
                                <span class="users-list-name">
                                    {{ $coach->first_name }} {{ $coach->last_name }}
                                </span>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            {!! Form::open([
                                'route' => ['coach.update',
                                'id' => $coach->id,
                                ],
                                'method' => 'PUT',
                                'class' => 'picture',
                                'data-is_form' => 'true',
                                'data-form' => 'picture',
                                'data-ajax' => 'false',
                                'files' => 'true',
                                'hidden'
                            ]) !!}
                            <div class="form-group">
                                <span class="btn btn-primary btn-full btn-file">
                                <i class="fa fa-upload"></i> foto toevoegen {!! Form::file('picture', [
                                    'class' => 'upload-image',
                                    'data-img' => 'crop',
                                ]) !!}
                            </span>
                            </div>
                            {{--{!! Form::submit('opslaan', [--}}
                            {{--'class' => 'btn btn-primary btn-full',--}}
                            {{--]) !!}--}}
                                                        {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="contact">

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b><i class="fa fa-phone"></i></b>
                                    <a class="pull-right"
                                       href="tel://{{ $contact['phone'] }}">{{ $contact['phone'] }}</a>
                                    {{--<div class="phone contact-form" data-is_form="false">--}}
                                    {{--<div class="col-xs-10 contact-data" data-contact="swimmer.phone">--}}
                                    {{--<a href="tel://{{ $contact['phone'] }}">{{ $contact['phone'] }}</a>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-xs-1">--}}
                                    {{--<a href="#" data-toggle="phone"><i class="fa fa-pencil"></i></a>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                </li>
                                <li class="list-group-item clearfix">
                                    <b><i class="fa fa-home"></i></b>
                        <span class="pull-right">
                             @if($contact['address'])
                                <a href="http://maps.google.com/maps?q={{ $contact['address']['street'] . " " . $contact['address']['number'] . ", "
                                . $contact['address']['zipcode'] . " " .  $contact['address']['city'] }}"
                                   target="_blank">
                                    {{ $contact['address']['street'] }} {{ $contact['address']['number'] }}, <br>
                                    {{ $contact['address']['zipcode'] }} {{ $contact['address']['city'] }}
                                </a>
                            @endif
                        </span>
                                </li>
                                <li class="list-group-item">
                                    <b><i class="fa fa-envelope"></i></b>
                        <span class="pull-right">
                            <a href="mailto:{{$coach->user->email}}">{{ $coach->user->email }}</a>
                        </span>
                                </li>
                            </ul>

                            <a href="#" class="btn btn-primary btn-full" data-toggle="contact">
                                <i class="fa fa-pencil"></i> Wijzigen
                            </a>
                        </div>
                        <div class="contact" data-is_form="true" hidden>
                            {{--                        {!! Form::open() !!}--}}
                            {{--{!! Form::open([--}}
                            {{--'route' => ['{group}.swimmer.contact.update',--}}
                            {{--'group' => $group->slug,--}}
                            {{--'swimmer' => $swimmer->slug,--}}
                            {{--],--}}
                            {{--]) !!}--}}
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item form-group">
                                    {{--<b><i class="fa fa-phone"></i></b>--}}
                                    <label class="input-group">
                                        <div class="input-group-addon"><b><i class="fa fa-phone"></i></b></div>
                                        {!! Form::text('phone', $contact['phone'], [
                                            'class' => 'pull-right form-control',
                                            'placeholder' => 'telefoonnummer'

                                        ]) !!}
                                    </label>
                                    {{--<a class="pull-right" href="tel://{{ $contact['phone'] }}">{{ $contact['phone'] }}</a>--}}
                                    {{--<div class="phone contact-form" data-is_form="false">--}}
                                    {{--<div class="col-xs-10 contact-data" data-contact="swimmer.phone">--}}
                                    {{--<a href="tel://{{ $contact['phone'] }}">{{ $contact['phone'] }}</a>--}}
                                    {{--</div>--}}
                                    {{--<div class="col-xs-1">--}}
                                    {{--<a href="#" data-toggle="phone"><i class="fa fa-pencil"></i></a>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                </li>
                                <li class="list-group-item clearfix">
                                    <label class="input-group">
                                        <div class="input-group-addon"><b><i class="fa fa-home"></i></b></div>
                                        {!! Form::text('street', $contact['address']['street'], [
                                            'class' => 'form-control',
                                            'placeholder' => 'straatnaam'
                                        ]) !!}
                                        {!! Form::text('number', $contact['address']['number'], [
                                            'class' => 'form-control',
                                            'placeholder' => 'huisnummer'
                                        ]) !!} <br>
                                        {!! Form::text('zipcode', $contact['address']['zipcode'], [
                                            'class' => 'form-control',
                                            'placeholder' => 'postcode',
                                        ]) !!}
                                        {!! Form::text('city', $contact['address']['city'], [
                                            'class' => 'form-control',
                                            'placeholder' => 'stad'
                                        ]) !!}

                                    </label>
                                </li>
                                <li class="list-group-item">
                                    <label class="input-group">
                                        <div class="input-group-addon"><b><i class="fa fa-envelope"></i></b></div>
                                        {!! Form::email('email', $coach->user->email, [
                                            'class' => 'pull-right form-control',
                                            'placeholder' => 'email',
                                            'readonly',
                                        ]) !!}
                                    </label>
                                </li>
                            </ul>

                            {!! Form::submit('Opslaan', [
                                'class' => 'btn btn-primary btn-full',
                            ]) !!}
                            {!! Form::close() !!}
                        </div>


                    </div>
                    {{--<div class="col-md-6">--}}
                    {{--<ul class="list-group list-group-unbordered">--}}
                    {{--<li class="list-group-item"></li>--}}
                    {{--</ul>--}}
                    {{--</div>--}}

                </div>
                @include('coach.pictureModal')


            </div>
        </div>
        @if(Auth::user()->clearance_level > 0)

            {{--<div class="row">--}}
                {{--<div class="col-xs-12">--}}
                    {{--<h2>Verwijderen</h2>--}}
                {{--</div>--}}
                {{--<div class="col-md-6">--}}
                    {{--<button type="button" class="btn btn-danger btn-lg btn-full" data-toggle="modal"--}}
                            {{--data-target="#delete">--}}
                        {{--Verwijderen--}}
                    {{--</button>--}}
                {{--</div>--}}
            {{--</div>--}}
        @endif
    </div>



    @if(Auth::user()->clearance_level > 0)


        <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Coach verwijderen</h4>
                    </div>
                    <div class="modal-body">
                        <p>Bent u zeker dat u {{ $coach->name }} wil verwijderen?</p>
                    </div>
                    {{--{!! Form::open(['route' => [--}}
                    {{--'{group}.swimmer.destroy',--}}
                    {{--'group' => $group->slug,--}}
                    {{--'swimmer' => $swimmer->slug,--}}
                    {{--], 'method' => 'delete']) !!}--}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                        {!! Form::submit('verwijderen', [
                            'class' => 'btn btn-danger',
                        ]) !!}
                    </div>
                    {{--                    {!! Form::close() !!}--}}
                </div>
            </div>
        </div>
    @endif
    </div>
@stop