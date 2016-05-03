<?php

namespace App\Http\Controllers\Gym;

use App\GExercise;
use App\Group;
use App\GymCategory;
use App\Http\Requests\GExerciseRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ExerciseController extends Controller
{
    /**
     * @var Group
     */
    private $group;
    /**
     * @var GExercise
     */
    private $gExercise;
    /**
     * @var GymCategory
     */
    private $category;

    public function __construct(Group $group, GExercise $gExercise, GymCategory $category)
    {
        $this->group = $group;
        $this->gExercise = $gExercise;
        $this->category = $category;
    }

    public function index(Group $group)
    {
        $data = [
            'group' => $group,
            'gExercises' => $this->gExercise->all(),
        ];

        return view('gym.exercise.index', $data);
    }

    public function create(Group $group)
    {
        $data = [
            'group' => $group,
        ];

        return view('gym.exercise.create', $data);
    }

    public function store(Group $group, GExerciseRequest $request)
    {
        try {
            $gExercise = $this->gExercise->create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            $gExercise->url_picture_start = $this->storeImage($request->start, $gExercise->id, true);
            $gExercise->url_picture_end = $this->storeImage($request->end, $gExercise->id, false);

            $gExercise->save();
        } catch(\Exception $e) {
            Log::warning('couldn\'t store gym exercise', [ $e ]);
            if(isset($gExercise)) {
                return redirect()->route('gym.exercises.show', [
                    'group' => $group->slug,
                    'id' => $gExercise->id,
                ])->withErrors('problem with saving the exercise');
            }
        }

        return redirect()->route('gym.exercises.show', [
            'group' => $group->slug,
            'id' => $gExercise->id,
        ]);
    }

    public function show(Group $group, $id)
    {
        $gExercise = $this->gExercise->where('id', $id)->with('categories')->first();

        $data = [
            'group' => $group,
            'gExercise' => $gExercise,
            'categories' => $this->category->all(),
        ];

        return view('gym.exercise.show', $data);
    }

    protected function storeImage($img, $id , $isStart)
    {
        $destinationPath   = "uploads/gym/";
        $extension         = $img->getClientOriginalExtension();
        $filename = $id . "-";
        if($isStart) {
            $filename .= "start";
        } else {
            $filename .= "end";
        }
        $filename .= "." . $extension;
        //fullpath = path to picture + filename + extension
        $fullPath          = $destinationPath . $filename;
        $img->move($destinationPath , $filename);

        return '/' . $fullPath;
    }
}
