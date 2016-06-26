<?php

namespace App\Http\Controllers\Training;

use App\Group;
use App\Training;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jenssegers\Date\Date;
use Maatwebsite\Excel\Facades\Excel;

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
        Group $group
    )
    {
        $this->middleware('coach', ['except' => [
            'index',
            'show',
            'get',
            'download',
        ]]);

        $this->training = $training;
        $this->group = $group;
        setLocale(LC_TIME, 'nl_NL.utf8');
    }

    /**
     * Get all the trainings
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Group $group)
    {
        $trainings = $group->trainings()->with('group', 'exercises')->get();
        foreach($trainings as $training) {
            $startTime = new Carbon($training->starttime);
            $training->starttime = $startTime;
        }

        $editable = false;
        if(Auth::user()->clearance_level > 0) {
            $editable = true;
        }

        $data = [
            'trainings' => $trainings,
            'group' => $group,
            'editable' => $editable,
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

        return redirect()->route('{group}.training.show', [
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
        $training = $group->trainings()->find($id);
//            ->with(['exercises' => function ($query) {
//                $query->positioned();
//            }])
        if(!Auth::user()->clearance_level > 0 && !$training->is_shared) {

            return redirect()->back()->withErrors([
                'you aren\'t permitted to view this training',
            ]);
        }
        $starttime = Date::parse($training->starttime);
//        dd($starttime);

        $training->starttime = $starttime;

        $categories = $training->categoryExercises()->positioned()
            ->with(['exercises' => function($query) {
                $query->positioned();
            }])->get();


        $swimmers = $group->swimmers()->presences($training->id)->get();
        $editable = false;
        if(Auth::user()->clearance_level > 0) {
            $editable = true;
        }


        $data = [
            'training' => $training,
            'categories' => $categories,
            'group' => $group,
            'swimmers' => $swimmers,
            'editable' => $editable,
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

    public function download(Group $group, $training_id)
    {
        $training = $group->trainings()
            ->with(['exercises' => function ($query) {
                $query->positioned();
            }])
            ->find($training_id);

        $categories = $training->categoryExercises()->positioned()
            ->with(['exercises' => function($query) {
                $query->positioned();
            }])->get();

        $training->starttime = Carbon::createFromTimestamp(strtotime($training->starttime));

        $data = [
            'training' => $training,
            'categories' => $categories,
        ];

//        dd($training->starttime);
//        return view('excel.training', $data);

        Excel::create('training', function($excel) use ($data) {

            $excel->sheet('New sheet', function($sheet) use ($data) {

                $sheet->loadView('excel.training', $data);

            })->download('pdf');

        });
        //TODO make choice between pdf/xls
    }


}
