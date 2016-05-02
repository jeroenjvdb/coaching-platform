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

    public function store(Request $request, Group $group, $id)
    {
        echo $id;
        $gym = $this->gym->find($id);
        var_dump($gym);
        var_dump($request->all());
        echo '<br><br>';
        $exercise = $gym->exercises()->create([
            'sets' => $request->sets,
            'reps' => $request->reps,
            'g_exercise_id' => $request->exercise,
        ]);

        return redirect()->back();
    }
}
