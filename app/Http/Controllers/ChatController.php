<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\chatEvent;
use App\Message;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Support\Facades\Hash;

class ChatController extends Controller
{
    /**
     * @var Message
     */
    private $message;
    /**
     * @var chat
     */
    private $chat;
    /**
     * @var User
     */
    private $authUser;

    /**
     * ChatController constructor.
     * @param Message $message
     * @param chat $chat
     */
    public function __construct(Message $message, Chat $chat)
    {
        $this->message = $message;
        $this->chat = $chat;
        $this->authUser = Auth::user();
    }

    /**
     * get the chatbox
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'chats' => $this->chat->all(),
        ];

        return view('chat.index', $data);
    }

    /**
     * make chat post
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function fire(Request $request)
    {
        var_dump($request->all());
        $chat = $this->chat->where('name', $request->input('chatName'))->first();
        if(! Hash::check($this->authUser->id . $chat->name, $request->input('chatToken') )) {
            //dd();
            return false;
        }
        $message = $request->input('msg');
        var_dump($message);
        $message = $this->message->create([
            'message' => $message,
            'user_id' => $this->authUser->id,
            'chat_id' => $chat->id,
        ]);
        //dd($request->input('msg'));
        // this fires the event
        event(new chatEvent($message->message, $this->authUser->name));
        return redirect()->route('chat.show', [$chat->name]);
    }

    public function create(Request $request)
    {
        $chat = $this->chat->create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('chat.index');
    }

    public function show($name)
    {
        $chat = $this->chat->where('name', $name)->first();
        $data = [
            'chat' => $chat,
            'messages' => $chat->messages()->orderBy('created_at', 'ASC')->get(),
            'chatToken' => Hash::make(Auth::user()->id . $chat->name ),
        ];

        return view('chat.show', $data);
    }
}
