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

    public function index(Group $group)
    {
        $gyms = $this->gym->all();

        $data = [
            'group' => $group,
            'gyms' => $gyms,
        ];

        return view('gym.index', $data);
    }

    public function create(Group $group)
    {
        $data = [
            'group' => $group
        ];

        return view('gym.create', $data);
    }

    public function store(Group $group, Request $request)
    {
        $gym = $this->gym->create([
            'start_time' => $request->start_time,
        ]);

        $data = [
            'group' => $group,
        ];

        return redirect()->route('gyms.show', [
            'group' => $group->slug,
            'id' => $gym->id
        ]);
    }

    public function show(Group $group, $id)
    {
        $gym = $this->gym->find($id);
        $exercises = $gym->exercises()->with('exercise')->get();
//        dd($exercises);

        $data = [
            'group' => $group,
            'gym' => $gym,
            'exercises' => $exercises,
            'allExercises' => $this->gExercise->all(),
        ];

        return view('gym.show', $data);
    }
}
