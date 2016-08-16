<h2>Contact</h2>
<div class="row swimmer">
    <div class="col-xs-12  col-md-6">
        <div class="box box-danger">
            <div class="box-body box-profile">
                <div class="row">
                    <div class="col-xs-12">
                        <a href="#" class="profile-img-edit" data-toggle="picture">
                            <img class="profile-user-img img-responsive img-circle " id="image-start"
                                 @if($contact['picture'])
                                 src="{{ $contact['picture'] }}"
                                 @else
                                 src="http://library.unn.edu.ng/wp-content/uploads/sites/42/2016/03/prifile-pic.png"
                                 @endif
                                 alt=""></a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::open([
                            'route' => ['{group}.swimmer.contact.update',
                            'group' => $group->slug,
                            'swimmer' => $swimmer->slug,
                            ],
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
                        {!! Form::submit('opslaan', [
                            'class' => 'btn btn-primary btn-full',
                        ]) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="col-xs-12">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b><i class="fa fa-phone"></i></b>
                            <a class="pull-right" href="tel://{{ $contact['phone'] }}">{{ $contact['phone'] }}</a>
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
                                {{ $contact['address']->street }} {{ $contact['address']->number }}, <br>
                                {{ $contact['address']->zipcode }} {{ $contact['address']->city }}
                            @endif
                        </span>
                        </li>
                        <li class="list-group-item">
                            <b><i class="fa fa-envelope"></i></b>
                        <span class="pull-right">
                            <a href="mailto:{{$swimmer->email}}">{{ $swimmer->email }}</a>
                        </span>
                        </li>
                    </ul>
                </div>
                {{--<div class="col-md-6">--}}
                    {{--<ul class="list-group list-group-unbordered">--}}
                        {{--<li class="list-group-item"></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}

            </div>
            @include('swimmers.show.pictureModal')


        </div>


        {{--<div class="row">--}}
        {{--<div class="col-md-2 col-xs-4">--}}
        {{--<a href="#" data-toggle="picture">--}}
        {{--<img class="profile-user-img img-responsive img-circle" id="image-start"--}}
        {{--@if($contact['picture'])--}}
        {{--src="{{ $contact['picture'] }}"--}}
        {{--@else--}}
        {{--src="http://library.unn.edu.ng/wp-content/uploads/sites/42/2016/03/prifile-pic.png"--}}
        {{--@endif--}}
        {{--alt=""></a>--}}
        {{--{!! Form::open([--}}
        {{--'route' => ['{group}.swimmer.contact.update',--}}
        {{--'group' => $group->slug,--}}
        {{--'swimmer' => $swimmer->slug,--}}
        {{--],--}}
        {{--'class' => 'picture',--}}
        {{--'data-is_form' => 'true',--}}
        {{--'data-form' => 'picture',--}}
        {{--'data-ajax' => 'false',--}}
        {{--'files' => 'true',--}}
        {{--'hidden'--}}
        {{--]) !!}--}}
        {{--<div class="form-group">--}}
        {{--<span class="btn btn-primary btn-full btn-file">--}}
        {{--<i class="fa fa-upload"></i> foto toevoegen {!! Form::file('picture', [--}}
        {{--'class' => 'upload-image',--}}
        {{--'data-img' => 'crop',--}}
        {{--]) !!}--}}
        {{--</span>--}}
        {{--</div>--}}
        {{--{!! Form::submit('opslaan', [--}}
        {{--'class' => 'btn btn-primary btn-full',--}}
        {{--]) !!}--}}
        {{--{!! Form::close() !!}--}}
        {{--</div>--}}
        {{--            @include('swimmers.show.pictureModal')--}}
        {{--<div class="col-md-10 col-xs-12" data-is_form="false">--}}
        {{--<div class="row">--}}
        {{--<div class="col-md-6 col-xs-12">--}}
        {{--<div class="row contact">--}}
        {{--<div class="col-xs-2">--}}
        {{--<strong><i class="fa fa-phone"></i><span class="sr-only">GSM</span></strong>--}}
        {{--</div>--}}
        {{--<div class="col-xs-10">--}}
        {{--<div class="phone contact-form" data-is_form="false">--}}
        {{--<div class="col-xs-10 contact-data" data-contact="swimmer.phone">--}}
        {{--<a href="tel://{{ $contact['phone'] }}">{{ $contact['phone'] }}</a>--}}
        {{--</div>--}}
        {{--<div class="col-xs-1">--}}
        {{--<a href="#" data-toggle="phone"><i class="fa fa-pencil"></i></a>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="row phone contact-form" data-is_form="true" data-form="phone" hidden>--}}
        {{--{!! Form::open(['route' => ['{group}.swimmer.contact.update',--}}
        {{--'group' => $group->slug,--}}
        {{--'swimmer' => $swimmer->slug,--}}
        {{--],--}}
        {{--'data-ajax' => 'true',--}}

        {{--]) !!}--}}
        {{--<div class="col-xs-10">--}}
        {{--{!! Form::text('phone', $contact['phone']) !!}--}}
        {{--</div>--}}
        {{--<div class="col-xs-2">--}}
        {{--<button type="submit" class="btn btn-primary btn-full"><i--}}
        {{--class="fa fa-angle-right"></i>--}}
        {{--</button>--}}
        {{--</div>--}}
        {{--{!! Form::close() !!}--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--</div>--}}
        {{--<div class="row contact">--}}
        {{--<div class="col-xs-2">--}}
        {{--<strong>--}}
        {{--<i class="fa fa-home"></i>--}}
        {{--<span class="sr-only">Adres:</span>--}}
        {{--</strong>--}}
        {{--</div>--}}
        {{--<div class="col-xs-10">--}}
        {{--<div class="row address contact-form" data-is_form="false">--}}
        {{--<div class="col-xs-10 contact-data" data-contact="address">--}}
        {{--@if($contact['address'])--}}
        {{--{{ $contact['address']->street }} {{ $contact['address']->number }}, <br>--}}
        {{--{{ $contact['address']->zipcode }} {{ $contact['address']->city }}--}}
        {{--@endif--}}
        {{--</div>--}}
        {{--<div class="col-xs-2">--}}
        {{--<a href="#" data-toggle="address"><i class="fa fa-pencil"></i></a>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="row address contact-form" hidden data-is_form="true" data-form="address">--}}
        {{--{!! Form::open(['route' => ['{group}.swimmer.contact.update',--}}
        {{--'group' => $group->slug,--}}
        {{--'swimmer' => $swimmer->slug,--}}
        {{--],--}}
        {{--'data-ajax' => 'true',--}}

        {{--]) !!}--}}
        {{--<div class="col-xs-10">--}}
        {{--{!! Form::text('street', $contact['address']->street) !!}--}}
        {{--{!! Form::text('number', $contact['address']->number) !!} <br>--}}
        {{--{!! Form::text('zipcode', $contact['address']->zipcode) !!}--}}
        {{--{!! Form::text('city', $contact['address']->city) !!}--}}
        {{--</div>--}}
        {{--<div class="col-xs-2">--}}
        {{--<button type="submit" class="btn btn-primary btn-full"><i--}}
        {{--class="fa fa-angle-right"></i>--}}
        {{--</button>--}}
        {{--</div>--}}
        {{--{!! Form::close() !!}--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--</div>--}}
        {{--<div class="row contact">--}}
        {{--<div class="col-xs-2">--}}
        {{--<strong><i class="fa fa-envelope"></i><span class="sr-only">Email:</span></strong>--}}
        {{--</div>--}}
        {{--<div class="col-xs-10">--}}
        {{--<div class="row swimmer-email contact-form" data-is_form="false">--}}
        {{--<div class="col-xs-10 contact-data" data-contact="swimmer.email">--}}
        {{--{{ $swimmer->email }}--}}
        {{--</div>--}}
        {{--<div class="col-xs-2">--}}
        {{--<a href="#" data-toggle="swimmer-email"><i class="fa fa-pencil"></i></a>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="row swimmer-email contact-form" data-is_form="true" hidden>--}}
        {{--{!! Form::open(['route' => ['{group}.swimmer.contact.update',--}}
        {{--'group' => $group->slug,--}}
        {{--'swimmer' => $swimmer->slug,--}}
        {{--],--}}
        {{--'data-ajax' => 'true',--}}

        {{--]) !!}--}}
        {{--<div class="col-xs-10">--}}
        {{--{!! Form::email('email', $swimmer->email) !!}--}}
        {{--</div>--}}
        {{--<div class="col-xs-2">--}}
        {{--<button type="submit" class="btn btn-primary btn-full"><i--}}
        {{--class="fa fa-angle-right"></i>--}}
        {{--</button>--}}
        {{--</div>--}}
        {{--{!! Form::close() !!}--}}
        {{--</div>--}}
        {{--</div>--}}

        {{--</div>--}}

        {{--</div>--}}
        {{--<div class="col-md-6 col-xs-12">--}}
        {{--<div class="row contact-data parents-email" data-is_form="false">--}}
        {{--<div class="col-xs-2">--}}
        {{--<strong>--}}
        {{--<i class="fa fa-envelope"></i> <i class="fa fa-plus"></i>--}}
        {{--<span class="sr-only">Extra email adressen</span>--}}
        {{--</strong>--}}
        {{--</div>--}}
        {{--<div class="col-xs-8 contact-data" data-contact="email">--}}
        {{--@foreach($contact['email'] as $email)--}}
        {{--{{ $email }} <br>--}}
        {{--@endforeach--}}
        {{--</div>--}}
        {{--<div class="col-xs-2">--}}
        {{--<a href="#" data-toggle="parents-email"><i class="fa fa-pencil"></i></a>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="row parents-email contact-form" data-is_form="true" hidden>--}}
        {{--{!! Form::open([--}}
        {{--'route' => [--}}
        {{--'{group}.swimmer.contact.update',--}}
        {{--'group' => $group->slug,--}}
        {{--'swimmer' => $swimmer->slug,--}}
        {{--],--}}
        {{--'data-ajax' => 'true',--}}
        {{--]) !!}--}}
        {{--<div class="col-xs-2">--}}
        {{--<strong>--}}
        {{--<i class="fa fa-envelope"></i> <i class="fa fa-plus"></i>--}}
        {{--<span class="sr-only">Extra Email adressen</span>--}}
        {{--</strong>--}}
        {{--</div>--}}
        {{--<div class="col-xs-8 contact-data" data-contact="email">--}}
        {{--{!! Form::email('emailMother', null) !!}--}}
        {{--{!! Form::email('emailFather', null) !!}--}}
        {{--</div>--}}
        {{--<div class="col-xs-2">--}}
        {{--<button type="submit" class="btn btn-primary btn-full"><i class="fa fa-angle-right"></i>--}}
        {{--</button>--}}
        {{--</div>--}}
        {{--{!! Form::close() !!}--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        @if(Auth::user()->clearance_level > 0)

            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 col-xs-12">
                    <button type="button" class="btn btn-danger btn-lg btn-full" data-toggle="modal"
                            data-target="#delete">
                        verwijderen
                    </button>
                </div>
            </div>
        @endif
    </div>


    {{-- <div class="col-md-10 col-xs-12 contact-form" data-is_form="true" data-form="contact" hidden>
        {!! Form::open(['route' => ['{group}.swimmer.contact.update',
            'group' => $group->slug,
            'swimmer' => $swimmer->slug,
            ],
            'data-ajax' => 'true',

        ]) !!}
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="row">
                    <div class="col-xs-4">
                        <strong>GSM:</strong>
                    </div>
                    <div class="col-xs-8">
                        {!! Form::text('phone', $contact['phone']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-xs-8">
                        {!! Form::email('email', $swimmer->email) !!}
                    </div>
                </div> --}}
    {{--<div class="row">--}}
    {{--<div class="col-xs-4"><strong>Adres:</strong></div>--}}
    {{--<div class="col-xs-8">--}}
    {{--                        {!! Form::text('street', $contact['address']->street) !!}--}}
    {{--                        {!! Form::text('number', $contact['address']->number) !!} <br>--}}
    {{--                        {!! Form::text('zipcode', $contact['address']->zipcode) !!}--}}
    {{--                        {!! Form::text('city', $contact['address']->city) !!}--}}
    {{--{{ $contact['address']->street }} {{ $contact['address']->number }}, <br>--}}
    {{--{{ $contact['address']->zipcode }} {{ $contact['address']->city }}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-md-6 col-xs-12">--}}
    {{--<div class="row">--}}
    {{--<div class="col-xs-4">--}}
    {{--<strong>Email ouders:</strong>--}}
    {{--</div>--}}
    {{--<div class="col-xs-8">--}}
    {{--{!! Form::email('emailMother') !!}--}}
    {{--{!! Form::email('emailFather') !!}--}}
    {{--@foreach($contact['email'] as $email)--}}
    {{--{{ $email }} <br>--}}
    {{--@endforeach--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="row">--}}
    {{--<div class="col-xs-12">--}}
    {{--{!! Form::submit() !!}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--{!! Form::close() !!}--}}
    {{--</div>--}}
    @if(Auth::user()->clearance_level > 0)


        <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Zwemmer verwijderen</h4>
                    </div>
                    <div class="modal-body">
                        <p>Bent u zeker dat u {{ $swimmer->full_name }} wil verwijderen?</p>
                    </div>
                    {!! Form::open(['route' => [
                        '{group}.swimmer.destroy',
                        'group' => $group->slug,
                        'swimmer' => $swimmer->slug,
                    ], 'method' => 'delete']) !!}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                        {!! Form::submit('verwijderen', [
                            'class' => 'btn btn-danger',
                        ]) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    @endif
</div>
{{--</div>--}}