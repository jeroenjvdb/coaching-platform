<?php

namespace App\Http\Controllers;

use App\Events\chat;
use App\Message;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class ChatController extends Controller
{
    /**
     * @var Message
     */
    private $message;

    /**
     * ChatController constructor.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * doesn't do a thing
     *
     * @return string
     */
    public function index()
    {
        dd(Auth::user());
        // this doesn't do anything other than to
        // tell you to go to /fire
        return "login and go to /fire";
    }

    /**
     * open chatbox
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function chat()
    {
        // this checks for the event
        return view('chat');
    }

    /**
     * make chat post
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function fire(Request $request)
    {
        $message = $request->input('msg');
        $user = Auth::user();

        $message = $this->message->create([
            'message' => $message,
            'user_id' => $user->id,
        ]);
        //dd($request->input('msg'));
        // this fires the event
        event(new chat($message->message, $user->name));
        return redirect()->route('chat');
    }
}
