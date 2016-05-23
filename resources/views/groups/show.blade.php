@extends('layouts.master')

@section('title', 'show all groups')

@section('content')
    {!! Breadcrumbs::render('group', $group) !!}
    <h1>{{ $group->name }}</h1>
    <a href="{{ route('swimmers.download.pr', ['group' => $group->slug]) }}">download</a>
    <a href="{{ route('groups.edit', [$group->slug]) }}">edit</a>
    <h2>zwemmers:</h2>
    <div class="row">
        @foreach($swimmers as $swimmer)
            <div class="col-md-4 col-sm-6 col-xs-12">
                <a rel="external" href="{{ route('swimmers.show', ['group' => $group->slug, $swimmer->slug]) }}">
                    <span class="thumbnail col-xs-4">
{{--                        @if(isset($swimmer->getMeta('picture')))--}}
                            <img src="http://archive.eyebeam.org/sites/default/files/imagecache/node_size/people/images/blank_image_17.png" alt="">
                        {{--@endif--}}
                    </span>
                     {{ $swimmer->first_name }} {{ $swimmer->last_name }}
                </a>
            </div>

        @endforeach
    </div>

@stop