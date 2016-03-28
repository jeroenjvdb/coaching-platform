<?php

namespace App\Http\Controllers;

use App\Group;
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
     * @var Group
     */
    private $group;

    /**
     * TrainingController constructor.
     * @param Training $training
     * @param Group $group
     */
    public function __construct(
        Training $training,
        Group $group)
    {
        $this->training = $training;
        $this->group = $group;
    }

    /**
     * Get all the trainings
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Group $group)
    {
        $data = [
            'trainings' => $group->trainings,
        ];

        return view('trainings.index', $data);
    }

    /**
     * get the create page for a new training
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Group $group)
    {
        $data = [
            'group' => $group
        ];

        return view('trainings.create', $data);
    }

    /**
     * save the new training
     *
     * @param Request $request
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Group $group)
    {
        $training = $this->training->fill([
            'starttime' => $request->starttime,

        ]);
        $training = $group->trainings()->save($training);

        return redirect()->route('trainings.show', [
            'group' => $group->slug,
            'training' => $training->id,
        ]);

    }

    /**
     * show detail page of training
     *
     * @param Group $group
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Group $group, $id)
    {
        $training = $group->trainings()
            ->with(['exercises' => function ($query) {
                $query->orderBy('position', 'asc');
            }])
            ->find($id);

        $data = [
            'training' => $training,
            'group' => $group,
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
