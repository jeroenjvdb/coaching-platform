@extends('layouts.master')

@section('content')
    @foreach($chats as $chat)
        <a href="{{ route('chat.show', [
            $chat->name,
            'group' => $group->slug,
        ]) }}"
        rel="external">{{ $chat->name }}</a></br>
    @endforeach
@stop

@section('scripts')
    
@stop