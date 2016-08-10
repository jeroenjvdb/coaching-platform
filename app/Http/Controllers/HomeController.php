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
use Carbon\Carbon;

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

        if ( ! $user) {
            return view('auth.login');
        }

        $group = null;

        if ($user->getMeta('swimmer_id')) {
            $is_swimmer = true;
            $mySwimmer = $this->swimmer->find($user->getMeta('swimmer_id'));
            $groups = $this->group->where('id', $user->getMeta('swimmer_id'))->get();
            $group = $groups->first();
        }

        if ($user->coach) {
            $groups = $user->coach->groups;
            $group = $user->getGroup();
        }

        $is_swimmer = false;
        $swimmer = null;

//        $groups = $this->group->where('id', $user->getMeta('swimmer_id'))->get();

        $swimmers = $group
            ->swimmers()
            ->ordered()
            ->get();
        $today = Carbon::today();
        $tomorrow = Carbon::today()
            ->addDay();

        $trainings = $group->trainings()
            ->where('starttime', '>', $today)
            ->where('starttime', '<', $tomorrow)
            ->get();

        $user = Auth::user();
        $mySwimmer = null;


        $data = [
            'group'     => $group,
            'trainings' => $trainings,
            'swimmers'  => $swimmers,
            'coaches'   => $group->coaches,
            'mySwimmer' => $mySwimmer,
        ];


        return view('groups.show', $data);

//        $coach = $user->coaches->first();
//
//        $data = [
//            'groups'     => $groups,
//            'is_swimmer' => $is_swimmer,
//            'swimmer'    => $swimmer,
//
//        ];
//
//        return view('welcome', $data);
    }

    /**
     * get testpage
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function test()
    {
        $stroke = 'freestyle';
        $distance = '100';

        $swimmer = $this->swimmer->first();

        $pb = $swimmer->getPersonalBest();

        preg_match_all("/<tr.*?<\/tr>/", $pb, $pbArr);
        $times = [];

        $courses = preg_grep("/" . config('swimrankings.courses')[$stroke][$distance] . "<\/td>/", $pbArr[0]);
        foreach ($courses as $course) {
            preg_match('/<td class="time">.*?<\/td>/', $course, $time);
            array_push($times, $time[0]);
        }
        dd($times);

        dd($pbArr);
    }
}