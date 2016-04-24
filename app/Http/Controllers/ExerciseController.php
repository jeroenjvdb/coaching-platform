<?php

namespace App\Http\Controllers;

use App\Exercise;
use App\Group;
use App\Http\Requests\ExerciseRequest;
use App\Training;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ExerciseController extends Controller
{
    /**
     * @var Training
     */
    private $training;
    /**
     * @var Exercise
     */
    private $exercise;

    /**
     * ExerciseController constructor.
     * @param Training $training
     * @param Exercise $exercise
     */
    public function __construct(Training $training, Exercise $exercise)
    {
        $this->training = $training;
        $this->exercise = $exercise;
    }

    /**
     * save the new exercise
     *
     * @param Request $request
     * @param Group $group
     * @param $training_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ExerciseRequest $request, Group $group, $training_id)
    {
        $training = $group
            ->trainings()
            ->find($training_id);
        $lastExercise = $training
            ->exercises()
            ->lastExercise();

        $position = 1;
        if ($lastExercise->exists()) {
            $position = $lastExercise->position + 1;
        }

        $exercise = $this->exercise->fill([
            'sets' => $request->sets,
            'meters' => $request->meters,
            'description' => $request->description,
            'position' => $position,
        ]);

        $training->exercises()->save($exercise);

        return redirect()->back();
    }

    /**
     * get edit page for exercise
     *
     * @param Group $group
     * @param $training_id
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Group $group, $training_id, $id)
    {
        $training = $group->trainings()
            ->where('id', $training_id)
            ->with(['exercises' => function($query) {
                $query->positioned();
            }])->first();
        //dd($training->exercises);
        $exercise = $training->exercises()->find($id);
        // dd($exercise->first());
        $data = [
            'group' => $group,
            'training' => $training,
            'exercise' => $exercise,
        ];

        return view('trainings.updateExercise', $data);
    }

    /**
     * update the exercise
     *
     * @param ExerciseRequest $request
     * @param Group $group
     * @param $training_id
     * @param $exercise_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ExerciseRequest $request, Group $group, $training_id, $exercise_id)
    {
        $training = $group->trainings()->find($training_id);
        $exercise = $training->exercises()->find($exercise_id);
        $newPos = $request->position;
        $oldPos = $exercise->position;

        $exercise->update($request->all());

        if ($newPos != $oldPos) {
            $exercise->changePositions($training, $newPos, $oldPos);
        }



        return redirect()->route('trainings.show',[
            'group' => $group->slug,
            'id' => $training_id
        ]);
    }

    /**
     * soft delete the exercise
     *
     * @param Group $group
     * @param $training_id
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Group $group, $training_id, $id)
    {
        $training = $group
            ->trainings()
            ->find($training_id);
        $exercise = $training
            ->exercises()
            ->find($id);
        $exercise->delete();

        return redirect()->back();
    }
}
