<?php

namespace App\Http\Controllers\Training;

use App\CategoryExercise;
use App\Group;
use App\Training;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * @var CategoryExercise
     */
    private $categoryExercise;
    /**
     * @var Training
     */
    private $training;

    /**
     * ApiController constructor.
     * @param CategoryExercise $categoryExercise
     * @param Training $training
     */
    public function __construct(CategoryExercise $categoryExercise, Training $training)
    {
        $this->categoryExercise = $categoryExercise;
        $this->training = $training;
    }

    public function individualDistance(Group $group, $training_id) {
        $training = $this->training->find($training_id);
        $categories = $training->categoryExercises;

        return json_encode([
            'type' => 'success',
            'datatype' => 'distance',
            'categories' => $categories,
        ]);
    }
}
