<h2>contact</h2>
<div class="row swimmer">
    <div class="col-md-2 col-xs-4">
        <a href="#" data-toggle="picture">
    <img id="image-start"
        @if($contact['picture'])
            src="{{ $contact['picture'] }}"
        @else
            src="http://library.unn.edu.ng/wp-content/uploads/sites/42/2016/03/prifile-pic.png"
        @endif
            alt=""></a>
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
        {!! Form::file('picture', [
            'class' => 'upload-image',
            'data-img' => 'start',
        ]) !!}
        {!! Form::submit() !!}
        {!! Form::close() !!}
    </div>
    <div class="col-md-10 col-xs-12" data-is_form="false">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="row contact">
                    <div class="col-xs-2">
                        <strong><i class="fa fa-phone"></i><span class="sr-only">phone</span></strong>
                    </div>
                    <div class="col-xs-10">
                        <div class="row phone contact-form" data-is_form="false">
                            <div class="col-xs-10 contact-data" data-contact="swimmer.phone">
                                <a href="tel://{{ $contact['phone'] }}">{{ $contact['phone'] }}</a>
                            </div>
                            <div class="col-xs-1">
                                <a href="#" data-toggle="phone"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div>
                        <div class="row phone contact-form" data-is_form="true" data-form="phone" hidden>
                            {!! Form::open(['route' => ['{group}.swimmer.contact.update',
            'group' => $group->slug,
            'swimmer' => $swimmer->slug,
            ],
            'data-ajax' => 'true',

        ]) !!}
                            <div class="col-xs-10">
                                {!! Form::text('phone', $contact['phone']) !!}
                            </div>
                            <div class="col-xs-2">
                                <button type="submit"><i class="fa fa-angle-right"></i></button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
                <div class="row contact">
                    <div class="col-xs-2">
                        <strong>
                            <i class="fa fa-compass"></i>
                            <span class="sr-only">adres:</span>
                        </strong>
                    </div>
                    <div class="col-xs-10">
                        <div class="row address contact-form" data-is_form="false">
                            <div class="col-xs-10 contact-data" data-contact="address">
                                @if($contact['address'])
                                    {{ $contact['address']->street }} {{ $contact['address']->number }}, <br>
                                    {{ $contact['address']->zipcode }} {{ $contact['address']->city }}
                                @endif
                            </div>
                            <div class="col-xs-2">
                                <a href="#" data-toggle="address"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div>
                        <div class="row address contact-form" hidden data-is_form="true" data-form="address">
                            {!! Form::open(['route' => ['{group}.swimmer.contact.update',
                                        'group' => $group->slug,
                                        'swimmer' => $swimmer->slug,
                                        ],
                                        'data-ajax' => 'true',

                                    ]) !!}
                            <div class="col-xs-10">
                                {!! Form::text('street', $contact['address']->street) !!}
                                {!! Form::text('number', $contact['address']->number) !!} <br>
                                {!! Form::text('zipcode', $contact['address']->zipcode) !!}
                                {!! Form::text('city', $contact['address']->city) !!}
                            </div>
                            <div class="col-xs-2">
                                <button type="submit"><i class="fa fa-angle-right"></i></button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>
                <div class="row contact">
                    <div class="col-xs-2">
                        <strong><i class="fa fa-envelope"></i><span class="sr-only">email:</span></strong>
                    </div>
                    <div class="col-xs-10">
                        <div class="row swimmer-email contact-form" data-is_form="false">
                            <div class="col-xs-10 contact-data" data-contact="swimmer.email">
                                {{ $swimmer->email }}
                            </div>
                            <div class="col-xs-2">
                                <a href="#" data-toggle="swimmer-email"><i class="fa fa-pencil"></i></a>
                            </div>
                        </div>
                        <div class="row swimmer-email contact-form" data-is_form="true" hidden>
                            {!! Form::open(['route' => ['{group}.swimmer.contact.update',
                                        'group' => $group->slug,
                                        'swimmer' => $swimmer->slug,
                                        ],
                                        'data-ajax' => 'true',

                                    ]) !!}
                            <div class="col-xs-10">
                                {!! Form::email('email', $swimmer->email) !!}
                            </div>
                            <div class="col-xs-2">
                                <button type="submit"><i class="fa fa-angle-right"></i></button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-md-6 col-xs-12">
                <div class="row">
                    <div class="col-xs-2 contact-data" data-contact="email">
                        <strong>
                            <i class="fa fa-envelope"></i> <i class="fa fa-plus"></i>
                            <span class="sr-only">extra email adressen</span>
                        </strong>
                    </div>
                    <div class="col-xs-8">
                        {{--@foreach($contact['email'] as $email)--}}
                        {{--{{ $email }} <br>--}}
                        {{--@endforeach--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-10 col-xs-12 contact-form" data-is_form="true" data-form="contact" hidden>
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
                        <strong>phone:</strong>
                    </div>
                    <div class="col-xs-8">
                        {!! Form::text('phone', $contact['phone']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <strong>email:</strong>
                    </div>
                    <div class="col-xs-8">
                        {!! Form::email('email', $swimmer->email) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><strong>adres:</strong></div>
                    <div class="col-xs-8">
{{--                        {!! Form::text('street', $contact['address']->street) !!}--}}
{{--                        {!! Form::text('number', $contact['address']->number) !!} <br>--}}
{{--                        {!! Form::text('zipcode', $contact['address']->zipcode) !!}--}}
{{--                        {!! Form::text('city', $contact['address']->city) !!}--}}
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
        --}}
        {!! Form::close() !!}
    </div>
</div>