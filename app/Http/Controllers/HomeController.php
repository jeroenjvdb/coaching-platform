<?php
namespace App\Http\Controllers;
use App\Classes\SwimmerProfile;
use App\Group;
use App\Http\Requests;
use App\Stroke;
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
     * @var Stroke
     */
    private $stroke;

    /**
     * Create a new controller instance.
     *
     * @param Group $group
     * @param Swimmer $swimmer
     * @param Stroke $stroke
     */
    public function __construct(Group $group, Swimmer $swimmer, Stroke $stroke)
    {
//        $this->middleware('auth');
        $this->group = $group;
        $this->swimmer = $swimmer;
        $this->stroke = $stroke;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        if(!$user) {
            return view('welcome');
        }

        $is_swimmer = false;
        $swimmer = null;
        if ($user->getMeta('swimmer_id')) {
            $is_swimmer = true;
            $swimmer = $this->swimmer->find($user->getMeta('swimmer_id'));
            $groups = $this->group->where('id', $user->getMeta('swimmer_id'))->get();

        }
        $coach = $user->coaches->first();
        if($coach) {
            $groups = $coach->groups;
        }

        $data = [
            'groups' => $groups,
            'is_swimmer' => $is_swimmer,
            'swimmer' => $swimmer,

        ];

        return view('welcome', $data);
    }

    /**
     * get testpage
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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