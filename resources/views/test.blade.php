@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @foreach($strokes as $stroke)
                <div class="col-md-2">
                    <h2>{{ $stroke->name }}</h2>
                    <ul>
                        @foreach($stroke->distances as $distance)
                            <li>{{$distance->distance}}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

@stop