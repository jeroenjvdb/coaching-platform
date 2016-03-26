<?php

namespace App\Http\Controllers;

use App\Exercise;
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
     * TODO: part to model
     *
     * @param Request $request
     * @param $training_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $training_id)
    {
        $last_exercise = $this->exercise
            ->where('training_id', $training_id)
            ->orderBy('position', 'desc')
            ->first();
        $position = $last_exercise->position + 1;

        $this->exercise->create([
            'training_id' => $training_id,
            'sets' => $request->sets,
            'meters' => $request->meters,
            'description' => $request->description,
            'position' => $position,
        ]);

        return redirect()->back();
    }

    /**
     * get edit page for exercise
     *
     * @param $training_id
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($training_id, $id)
    {
        $training = $this->training->find($training_id);
        $exercise = $training->exercises()->where('id', $id)->first();
        $data = [
            'training' => $training,
            'exercise' => $exercise,
        ];

        return view('trainings.updateExercise', $data);
    }

    /**
     * update the exercise
     *
     * @param Request $request
     * @param $training_id
     * @param $exercise_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $training_id, $exercise_id)
    {
        $training = $this->training->find($training_id);
        $exercise = $training->exercises()->find($exercise_id);
        $newPos   = $request->position;
        $oldPos   = $exercise->position;

        if($newPos != $oldPos) {
            $this->changePositions($exercise, $training, $newPos, $oldPos);
        }

        return redirect()->route('trainings.show', $training_id);
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

        if($newPos < $oldPos) {
            $directionWhere = '>=';
            $directionOrderBy = 'desc';
            $directionPos = 1;
        }

        $allExercises = $training->exercises()
            ->where('position', $directionWhere, $newPos)
            ->orderBy('position', $directionOrderBy)
            ->get();

        foreach($allExercises as $allExercise) {
            $lastPos = $allExercise->position;
            $allExercise->position+= $directionPos;
            $allExercise->save();
        }

        $exercise->position = $lastPos;
        $exercise->save();
    }

    /**
     * soft delete the exercise
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $exercise = $this->exercise->find($id);

        $exercise->delete();

        return redirect()->back();
    }
}
