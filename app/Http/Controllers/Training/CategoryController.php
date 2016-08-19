<?php

namespace App\Http\Controllers\Training;

use App\Category;
use App\CategoryExercise;
use App\Group;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * @var Category
     */
    private $category;
    /**
     * @var CategoryExercise
     */
    private $categoryExercise;

    public function __construct(Category $category, CategoryExercise $categoryExercise)
    {

        $this->category = $category;
        $this->categoryExercise = $categoryExercise;
    }
    /**
     * add category to training
     *
     * @param Request $request
     * @param Group $group
     * @param $training_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $training_id)
    {
        $group = Auth::user()->getGroup();

        $training = $group
            ->trainings()
            ->find($training_id);

        $cat = $this
            ->category
            ->where('name', $request->category)
            ->firstOrCreate([
                'name' => $request->category,
            ]);

        $catEx = $training
            ->categoryExercises()
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

    /**
     * update category position
     *
     * @param Request $request
     * @param Group $group
     * @param $training_id
     * @return string
     */
    public function updateCatPosition(Request $request, Group $group, $training_id)
    {
        $group = Auth::user()->getGroup();
        Log::info('request: ', [$request->all()]);

        $training = $group
            ->trainings()
            ->find($training_id);
        $category = $training
            ->categoryExercises()
            ->find($request->exercise_id);

        $category->changePosition($training, $request->position);

        return json_encode([
            'type' => 'success',
        ]);
    }

    /**
     * delete category from training
     *
     * @param Request $request
     * @param Group $group
     * @param $training_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Group $group, $training_id)
    {
        $group = Auth::user()->getGroup();

        $training = $group
            ->trainings()
            ->find($training_id);
        $category = $training
            ->categoryExercises()
            ->find($request->category_id);

        $category->delete();

        $counter = 0;
        $categories = $training
            ->categoryExercises()
            ->orderBy('position', 'asc');

        foreach($categories as $cat) {
            $cat->position = $counter;
            $cat->save();
            $counter++;
        }

        return redirect()->back();
    }
}
