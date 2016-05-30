@extends('layouts.master')

@section('title', 'chatbox for: ' . $chat->name)

@section('style')
    {{--<style>--}}
    {{--* { margin: 0; padding: 0; box-sizing: border-box; }--}}
    {{--body { font: 13px Helvetica, Arial; }--}}
    {{--form { background: #000; padding: 3px; position: fixed; bottom: 0; width: 100%; }--}}
    {{--form input { border: 0; padding: 10px; width: 70%; margin-right: .5%; }--}}
    {{--form button { width: 9%; background: rgb(130, 224, 255); border: none; padding: 10px; }--}}
    {{--#messages { list-style-type: none; margin: 0; padding: 0; }--}}
    {{--#messages li { padding: 5px 10px; }--}}
    {{--#messages li:nth-child(odd) { background: #eee; }--}}
    {{--</style>--}}
@stop

@section('content')
    <div class="chat col-md-12">
        <h1>{{ $chat->name }}</h1>

        {!! Form::open([
        'route' => [
            'chat.fire',
            'group' => $group->slug,
            'chat' => $chat->name,
        ],
        'data-ajax' => 'true',
    ]) !!}
        <input id="m" autocomplete="off" name="msg" autofocus/>
        <button>Send</button>

        {!! Form::close() !!}

        <ul id="messages">
            @foreach($messages as $message)
                <li>{{ $message->user->name }}: {{ $message->message }}</li>
            @endforeach
        </ul>
    </div>


    {{--<form action="/chat/fire" method="post">--}}
    {{--<input id="m" autocomplete="off" name="msg" autofocus/><button>Send</button>--}}
    {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
    {{--<input type="hidden" name="chatName" value="{{ $chat->name }}">--}}
    {{--<input type="hidden" name="chatToken" value="{{ $chatToken }}">--}}
    {{--</form>--}}
@stop

@section('right')
    <aside class="control-sidebar control-sidebar-dark">
        test
    </aside>
@stop

@section('scripts')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.js"></script>--}}
    {{--<script>--}}
    {{--$(document).ready(function(){--}}
    {{--scrollDown();--}}
    {{--var socket = io('http://192.168.56.101:3000');--}}
    {{--$('form').submit(function(e){--}}
    {{--e.preventDefault();--}}
    {{--$.ajax({--}}
    {{--type: "POST",--}}
    {{--url: '/chat/fire',--}}
    {{--dataType: "json",--}}
    {{--data: $(this).serialize(),--}}
    {{--success: function(data){--}}
    {{--console.log(data);--}}
    {{--}--}}
    {{--});--}}
    {{--//$.post('/chat/fire', $(this).serialize(), 'json')--}}
    {{--//        .done(function(data) {--}}
    {{--//            console.log(data);--}}
    {{--//        });--}}
    {{--//console.log('fire!');--}}

    {{--//socket.emit('chat message', $('#m').val());--}}
    {{--$('#m').val('').focus();--}}
    {{--scrollDown();--}}
    {{--return false;--}}
    {{--});--}}
    {{--socket.on('chat-channel:App\\Events\\chatEvent', function(msg){--}}
    {{--var bottom = false;--}}
    {{--if($(window).scrollTop() + $(window).height() == $(document).height()) {--}}
    {{--bottom = true--}}
    {{--}--}}
    {{--console.log(msg);--}}
    {{--$('#messages').append($('<li>').text(msg.data.username + ': ' + msg.data.msg));--}}
    {{--if(bottom){--}}
    {{--scrollDown();--}}
    {{--}--}}

    {{--});--}}

    {{--function scrollDown()--}}
    {{--{--}}
    {{--window.scrollTo(0, document.body.scrollHeight);--}}
    {{--}--}}
    {{--});--}}
    {{--</script>--}}
@stop