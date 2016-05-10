<?php

namespace App\Http\Controllers;

use App\Classes\SwimmerProfile;
use App\Swimmer;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class MyController extends Controller
{
    /**
     * @var Swimmer
     */
    private $swimmer;

    public function __construct(Swimmer $swimmer)
    {
        $this->swimmer = $swimmer;
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $swimmer = $this->swimmer->find($user->getMeta('swimmer_id'));
//        dd($swimmer);

        $profile = new SwimmerProfile($swimmer);
        $profile->reaction($request->message);

        return redirect()->back();

    }
}
