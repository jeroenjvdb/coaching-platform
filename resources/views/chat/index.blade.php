@extends('layouts.master')

@section('content')
    @foreach($chats as $chat)
        <a href="{{ route('chat.show', [$chat->name]) }}">{{ $chat->name }}</a></br>
    @endforeach
@stop

@section('scripts')
    
@stop