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

    /**
     * show exercises
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Group $group)
    {
        $data = [
            'group' => $group,
            'gExercises' => $this->gExercise->all(),
        ];

        return view('gym.exercise.index', $data);
    }

    /**
     * create new exercise
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Group $group)
    {
        $data = [
            'group' => $group,
        ];

        return view('gym.exercise.create', $data);
    }

    /**
     * store exercise
     *
     * @param Group $group
     * @param GExerciseRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Group $group, GExerciseRequest $request)
    {
            $gExercise = $this->gExercise->create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            $gExercise->url_picture_start = $this->storeImage($request->start, $gExercise->id, true);
            $gExercise->url_picture_end = $this->storeImage($request->end, $gExercise->id, false);

            $gExercise->save();

        return redirect()->route('{group}.gym.exercise.show', [
            'group' => $group->slug,
            'id' => $gExercise->id,
        ]);
    }

    /**
     * show exercise
     *
     * @param Group $group
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * upload exercise to gym
     *
     * @param $img
     * @param $id
     * @param $isStart
     * @return string
     */
    protected function storeImage($img, $id , $isStart)
    {
//        dd(exif_read_data($img)['Orientation']);
        if($img->getMimeType() == 'image/jpeg' && isset(exif_read_data($img)['Orientation'])) {
            $img = orientate($img, exif_read_data($img)['Orientation']);
        }

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
