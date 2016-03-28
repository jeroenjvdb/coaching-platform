<?php

namespace App\Http\Controllers;

use App\Exercise;
use App\Group;
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
    public function store(Request $request, Group $group, $training_id)
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
        $training = $group->trainings()->find($training_id);
        $exercise = $training->exercises()->find($id);
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
     * @param Request $request
     * @param Group $group
     * @param $training_id
     * @param $exercise_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Group $group, $training_id, $exercise_id)
    {
        $training = $group->trainings()->find($training_id);
        $exercise = $training->exercises()->find($exercise_id);
        $newPos = $request->position;
        $oldPos = $exercise->position;

        if ($newPos != $oldPos) {
            $this->changePositions($exercise, $training, $newPos, $oldPos);
        }

        return redirect()->route('trainings.show',[
            'group' => $group->slug,
            'id' => $training_id
        ]);
    }

    /**
     * change positions of the exercises
     * TODO: set in ?Exercise? model
     *
     * @param Exercise $exercise
     * @param Training $training
     * @param $newPos
     * @param $oldPos
     */
    private function changePositions(Exercise $exercise, Training $training, $newPos, $oldPos)
    {
        $lastPos = $newPos;
        $directionWhere = '<=';
        $directionOrderBy = 'asc';
        $directionPos = -1;

        if ($newPos < $oldPos) {
            $directionWhere = '>=';
            $directionOrderBy = 'desc';
            $directionPos = 1;
        }

        $allExercises = $training->exercises()
            ->where('position', $directionWhere, $newPos)
            ->orderBy('position', $directionOrderBy)
            ->get();

        foreach ($allExercises as $allExercise) {
            $lastPos = $allExercise->position;
            $allExercise->position += $directionPos;
            $allExercise->save();
        }

        $exercise->position = $lastPos;
        $exercise->save();
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
