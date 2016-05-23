<?php

namespace App\Http\Controllers\Training;

use App\Category;
use App\CategoryExercise;
use App\Exercise;
use App\Group;
use App\Http\Requests\ExerciseRequest;
use App\Training;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

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
     * @var CategoryExercise
     */
    private $categoryExercise;

    /**
     * ExerciseController constructor.
     *
     * @param Training $training
     * @param Exercise $exercise
     */
    public function __construct(Training $training, Exercise $exercise, CategoryExercise $categoryExercise)
    {
        $this->training = $training;
        $this->exercise = $exercise;
        $this->categoryExercise = $categoryExercise;
    }

    /**
     * save the new exercise
     *
     * @param ExerciseRequest $request
     * @param Group $group
     * @param $training_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ExerciseRequest $request, Group $group, $training_id)
    {
        $training = $group
            ->trainings()
            ->find($training_id);
        $category = $training
            ->categoryExercises()
            ->find($request->cat_id);
        $lastExercise = $category
            ->exercises()
            ->lastExercise();

        $position = 0;
        if ($lastExercise->exists()) {
            $position = $lastExercise->position + 1;
        }

        $exercise = $this->exercise->fill([
            'sets' => $request->sets,
            'meters' => $request->meters,
            'description' => $request->description,
            'position' => $position,
            'category_exercise_id' => $category->id
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
            ->with(['exercises' => function ($query) {
                $query->positioned();
            }])->first();

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

        $exercise->sets = $request->sets;
        $exercise->meters = $request->meters;
        $exercise->description = $request->description;

        $exercise->save();

        return redirect()->route('trainings.show', [
            'group' => $group->slug,
            'id' => $training_id
        ]);
    }

    /**
     * update position of exercise
     *
     * @param Request $request
     * @param Group $group
     * @param $training_id
     * @return string
     */
    public function updatePosition(Request $request, Group $group, $training_id)
    {
        $training = $group->trainings()->find($training_id);

        $exercise = $training->exercises()->find($request->exercise_id);
        $newPos = $request->position;

        $exercise->changePositions($training, $newPos);

        return json_encode([
            'type' => 'success',
        ]);
    }

    /**
     * update category position
     *
     * @param Request $request
     * @param Group $group
     * @param $training_id
     */
    public function updateCatPosition(Request $request, Group $group, $training_id)
    {
        Log::info('request: ', [$request->all()]);

//        return json_encode([
//            'type' => 'success',
//        ]);

        $training = $group->trainings()->find($training_id);

        $category = $training->categoryExercises()->find($request->exercise_id);
        Log::info('category: ', [$category]);
        $category->changePosition($training, $request->position);
        $newPos = $request->position;
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

    /**
     * add category to training
     *
     * @param Request $request
     * @param Group $group
     * @param $training_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCategory(Request $request, Group $group, $training_id)
    {
        $training = $group
            ->trainings()
            ->find($training_id);

        $cat = Category::where('name', $request->category)
            ->first();


        $catEx = $training->categoryExercises()
            ->orderBy('position', 'desc')
            ->first();
        
        $position = 0;
        if($catEx) {
            $position = $catEx->position + 1;
        }


        $this->categoryExercise->create([
            'training_id' => $training->id,
            'category_id' => $cat->id,
            'position' => $position,
        ]);

        return redirect()->back();
    }
}
