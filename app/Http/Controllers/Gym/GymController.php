<?php

namespace App\Http\Controllers\Gym;

use App\GExercise;
use App\Group;
use App\Gym;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GymController extends Controller
{
    /**
     * @var Gym
     */
    private $gym;
    /**
     * @var GExercise
     */
    private $gExercise;

    public function __construct(Gym $gym, GExercise $gExercise)
    {
        $this->gym = $gym;
        $this->gExercise = $gExercise;
    }

    /**
     * get trainings
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Group $group)
    {
        $gyms = $this->gym->all();

        $data = [
            'group' => $group,
            'gyms' => $gyms,
        ];

        return view('gym.index', $data);
    }

    /**
     * create new training
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Group $group)
    {
        $data = [
            'group' => $group
        ];

        return view('gym.create', $data);
    }

    /**
     * store new training
     *
     * @param Group $group
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Group $group, Request $request)
    {
        $gym = $this->gym->create([
            'start_time' => $request->start_time,
        ]);

        $data = [
            'group' => $group,
        ];

        return redirect()->route('{group}.gym.show', [
            'group' => $group->slug,
            'id' => $gym->id
        ]);
    }

    /**
     * show individual training
     *
     * @param Group $group
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Group $group, $id)
    {
        $gym = $this->gym->find($id);
        $exercises = $gym->exercises()->with('exercise')->get();

        $data = [
            'group' => $group,
            'gym' => $gym,
            'exercises' => $exercises,
            'allExercises' => $this->gExercise->all(),
        ];

        return view('gym.show', $data);
    }
}
