<?php

namespace App\Http\Controllers\Training;

use App\CategoryExercise;
use App\Group;
use App\Training;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

    function get(Request $request, Group $group)
    {
        $trainings = $group->trainings()
            ->where('start_time', '>', $request->start)
            ->where('start_time', '<', $request->end);
        if(! Auth::user()->clearance_level > 0) {
            $trainings = $trainings->where('is_shared', 1);
        }
        $trainings = $trainings->get();
        $trainingsArr = [];

        foreach($trainings as $training) {
            $starttime = Carbon::parse($training->starttime);
            $start = $starttime->toDateTimeString();
            $endtime = $starttime->addHours(2)->toDateTimeString();
            $url = route('{group}.training.show', [
                'group' => $group->slug,
                'training_id' => $training->id,
            ]);

            $data = [
                'start' => $start,
                'end' => $endtime,
                'url' => $url,
            ];

            array_push($trainingsArr, $data);
        }

        return json_encode($trainingsArr);
    }

    public function individualDistance(Group $group, $training_id)
    {
        $training = $this->training->find($training_id);
        $categories = $training->categoryExercises;

        return json_encode([
            'type' => 'success',
            'datatype' => 'distance',
            'training' => $training,
            'categories' => $categories,
        ]);
    }

    public function shared(Request $request, Group $group, $training_id)
    {
        $training = $group->trainings()->find($training_id);

        $training-> is_shared = abs($training->is_shared - 1);
        $training->save();

//        dd($training);

        return redirect()->back();
    }
}
