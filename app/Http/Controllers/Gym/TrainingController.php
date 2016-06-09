<?php

namespace App\Http\Controllers\Gym;

use App\Group;
use App\Gym;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TrainingController extends Controller
{
    /**
     * @var Gym
     */
    private $gym;

    public function __construct(Gym $gym)
    {
        $this->gym = $gym;
    }

    /**
     * store exercise to training
     *
     * @param Request $request
     * @param Group $group
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Group $group, $id)
    {
        $gym = $this->gym->find($id);
        $exercise = $gym->exercises()->create([
            'sets' => $request->sets,
            'reps' => $request->reps,
            'g_exercise_id' => $request->exercise,
        ]);

        return redirect()->back();
    }
}
