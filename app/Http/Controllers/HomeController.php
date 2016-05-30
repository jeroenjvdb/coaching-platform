<?php

namespace App\Http\Controllers;

use App\Classes\SwimmerProfile;
use App\Group;
use App\Http\Requests;
use App\Swimmer;
use App\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * @var Group
     */
    private $group;
    /**
     * @var Swimmer
     */
    private $swimmer;

    /**
     * Create a new controller instance.
     * @param Group $group
     * @param Swimmer $swimmer
     */
    public function __construct(Group $group, Swimmer $swimmer)
    {
//        $this->middleware('auth');
        $this->group = $group;
        $this->swimmer = $swimmer;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd(Auth::user()->group);
        $user = Auth::user();
        $is_swimmer = false;
        $swimmer = null;
        if ($user->getMeta('swimmer_id')) {
            $is_swimmer = true;
            $swimmer = $this->swimmer->find($user->getMeta('swimmer_id'));
        }
//        $coach_id = $user->getMeta('coach_id');
//        $groups = null;
//        if($coach_id) {
        $coach = $user->coaches->first();
        $groups = $coach->groups;
//        }

//        dd($swimmer);

        $data = [
            'groups' => $groups,
            'is_swimmer' => $is_swimmer,
            'swimmer' => $swimmer,
        ];

        return view('welcome', $data);
    }

    public function test()
    {
        $training = Training::find(1);

        $categories = $training->categoryExercises;
        $data = [
            'categories' => $categories,
        ];

        return view('test', $data);
    }
}
