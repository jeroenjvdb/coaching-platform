<h2>contact <small><a href="#" data-toggle="contact-form"><i class="fa fa-pencil"></i></a></small></h2>
<div class="row swimmer">
    <div class="col-md-2 col-xs-3">
        <img src="{{ $contact['picture'] }}" alt="">
    </div>
    @include('swimmers.show.pictureModal')
    <div class="col-md-10 col-xs-12 contact-form" data-is_form="false">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="row">
                    <div class="col-xs-4">
                        <strong>phone:</strong>
                    </div>
                    <div class="col-xs-8">
                        {{ $contact['phone'] }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <strong>email:</strong>
                    </div>
                    <div class="col-xs-8">
                        {{ $swimmer->email }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><strong>adres:</strong></div>
                    <div class="col-xs-8">
                        {{ $contact['address']->street }} {{ $contact['address']->number }}, <br>
                        {{ $contact['address']->zipcode }} {{ $contact['address']->city }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="row">
                    <div class="col-xs-4">
                        <strong>email ouders:</strong>
                    </div>
                    <div class="col-xs-8">
                        @foreach($contact['email'] as $email)
                            {{ $email }} <br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-10 col-xs-8 contact-form" data-is_form="true" data-form="contact" hidden>
        {!! Form::open(['route' => ['swimmers.contact.update',
            'group' => $group->slug,
            'swimmer' => $swimmer->slug,
        ]]) !!}
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="row">
                    <div class="col-xs-4">
                        <strong>phone:</strong>
                    </div>
                    <div class="col-xs-8">
                        {!! Form::text('phone') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <strong>email:</strong>
                    </div>
                    <div class="col-xs-8">
                        {!! Form::email('email') !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><strong>adres:</strong></div>
                    <div class="col-xs-8">
                        {!! Form::text('street') !!} {!! Form::text('number') !!} <br>
                        {!! Form::text('zipcode') !!} {!! Form::text('city') !!}
                        {{--{{ $contact['address']->street }} {{ $contact['address']->number }}, <br>--}}
                        {{--{{ $contact['address']->zipcode }} {{ $contact['address']->city }}--}}
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="row">
                    <div class="col-xs-4">
                        <strong>email ouders:</strong>
                    </div>
                    <div class="col-xs-8">
                        {!! Form::email('emailMother') !!}
                        {!! Form::email('emailFather') !!}
                        {{--@foreach($contact['email'] as $email)--}}
                            {{--{{ $email }} <br>--}}
                        {{--@endforeach--}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::submit() !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>