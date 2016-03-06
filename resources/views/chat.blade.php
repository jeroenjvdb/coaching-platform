<!doctype html>
<html>
<head>
    <title>Socket.IO chat</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font: 13px Helvetica, Arial; }
        form { background: #000; padding: 3px; position: fixed; bottom: 0; width: 100%; }
        form input { border: 0; padding: 10px; width: 90%; margin-right: .5%; }
        form button { width: 9%; background: rgb(130, 224, 255); border: none; padding: 10px; }
        #messages { list-style-type: none; margin: 0; padding: 0; }
        #messages li { padding: 5px 10px; }
        #messages li:nth-child(odd) { background: #eee; }
    </style>
</head>
<body>
<ul id="messages"></ul>
<form action="/fire" method="post">
    <input id="m" autocomplete="off" name="msg"/><button>Send</button>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.5/socket.io.min.js"></script>
<script src="http://code.jquery.com/jquery-1.11.1.js"></script>
<script>
    var socket = io('http://192.168.56.101:3000');
    $('form').submit(function(e){
        e.preventDefault();
        $.post('/fire', $(this).serialize());
        console.log('fire!')

        //socket.emit('chat message', $('#m').val());
        $('#m').val('');
        //return false;
    });
    socket.on('test-channel:App\\Events\\chat', function(msg){
        console.log(msg);
        $('#messages').append($('<li>').text(msg.data.username + ': ' + msg.data.msg));
    });
</script>
</body>
</html>
