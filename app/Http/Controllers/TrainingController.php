<?php

namespace App\Http\Controllers;

use App\Training;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TrainingController extends Controller
{

    /**
     * @var Training
     */
    private $training;

    /**
     * TrainingController constructor.
     * @param Training $training
     */
    public function __construct(Training $training)
    {
        $this->training = $training;
    }

    /**
     * Get all the trainings
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'trainings' => $this->training->all(),
        ];

        return view('trainings.index', $data);
    }

    /**
     * get the create page for a new training
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('trainings.create');
    }

    /**
     * save the new training
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $training = $this->training->create([
            'starttime' => $request->starttime,
        ]);

        return redirect()->route('trainings.show', $training->id);

    }

    /**
     * show detail page of training
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $training = $this->training->find($id);

        $training->exercises = $training->exercises()
                                    ->orderBy('position', 'asc')
                                    ->get();
        $training->total = 0;

        foreach($training->exercises as $exercise) {
            $exercise->distance = $exercise->meters * $exercise->sets;
            $training->total += $exercise->distance;
        }

        $data = [
            'training' => $training,
        ];

        return view('trainings.show', $data);
    }

    /**
     * @param $id
     */
    public function edit($id)
    {

    }

    /**
     * @param $id
     */
    public function update($id)
    {

    }

    /**
     * soft delete the selected training
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $training = $this->training->find($id);
        $training->delete();

        return redirect()->route('trainings.index');
    }
}
