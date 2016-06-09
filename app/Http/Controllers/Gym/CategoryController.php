<?php

namespace App\Http\Controllers\Gym;

use App\GExercise;
use App\Group;
use App\GymCategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * @var GymCategory
     */
    private $category;
    /**
     * @var GExercise
     */
    private $gExercise;

    public function __construct(GymCategory $category, GExercise $gExercise)
    {
        $this->category = $category;
        $this->gExercise = $gExercise;
    }

    /**
     * store category
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        $this->category->create([
            'name' => $request->name,
        ]);

        return json_encode([
            'category' => $request->all(),
            'type' => 'success',
        ]);
    }

    /**
     * synchronize categories
     *
     * @param Request $request
     * @param Group $group
     * @param $id
     * @return string
     */
    public function add(Request $request, Group $group, $id)
    {
        $exercise = $this->gExercise->find($id);
        if(! isset($request->options)) {
            $request->options = [];
        }
        $exercise->categories()->sync($request->options);

        return json_encode([
            'categories' => $exercise->categories,
            'data' => $request->all(),
            'type' => 'success',
        ]);
    }
}
