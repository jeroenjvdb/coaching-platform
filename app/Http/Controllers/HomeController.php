<?php

namespace App\Http\Controllers;

use App\Classes\SwimmerProfile;
use App\Group;
use App\Http\Requests;
use App\Swimmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * @var Group
     */
    private $group;

    /**
     * Create a new controller instance.
     * @param Group $group
     */
    public function __construct(Group $group)
    {
//        $this->middleware('auth');
        $this->group = $group;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'groups' => $this->group->all(),
        ];

        return view('welcome', $data);
    }

    public function me()
    {
//        dd(Auth::user()->getAllMeta());
        if(! Auth::user()->getMeta('swimmer_id')) {
            abort('404', 'page not found');
        }
        $swimmer = Swimmer::find(Auth::user()->getMeta('swimmer_id'));
        $profile = new SwimmerProfile($swimmer);
        $data = $profile->get();

        $data['group'] = $swimmer->group;
        $data['myProfile'] = true;

        return view('swimmers.show', $data);
    }
}
