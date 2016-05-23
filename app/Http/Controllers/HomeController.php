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
//        dd(Auth::user()->group);
        $data = [
            'groups' => $this->group->all(),
        ];

        return view('welcome', $data);
    }

    public function test()
    {
        $training = \App\Training::find(1);

        $categories = $training->categoryExercises;
        $data = [
            'categories' => $categories,
        ];

        return view('test', $data);
    }
}
