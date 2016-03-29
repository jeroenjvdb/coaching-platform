<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests;
use Illuminate\Http\Request;

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
        $this->middleware('auth');
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
}
