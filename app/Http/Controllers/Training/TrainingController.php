<?php

namespace App\Http\Controllers\Training;

use App\Group;
use App\Stroke;
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
     * @var Stroke
     */
    private $stroke;

    /**
     * TrainingController constructor.
     *
     * @param Training $training
     * @param Group $group
     * @param Stroke $stroke
     */
    public function __construct(
        Training $training,
        Group $group,
        Stroke $stroke
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
//        setLocale(LC_TIME, 'nl_NL.utf8');
        $this->stroke = $stroke;
        Date::setLocale('nl');
    }

    /**
     * Get all the trainings
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Group $group)
    {
        $group = Auth::user()->getGroup();

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
    public function store(Request $request)
    {
        $group = Auth::user()->getGroup();

        $training = $this->training->fill([
            'starttime' => $request->starttime,

        ]);
        $training = $group->trainings()->save($training);

        return redirect()->route('training.show', [
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
    public function show($id)
    {
        $group = Auth::user()->getGroup();
        $training = $group->trainings()->find($id);
//            ->with(['exercises' => function ($query) {
//                $query->positioned();
//            }])
        if((!Auth::user()->clearance_level > 0 && !$training->is_shared) || !$training) {

            return redirect()->route('training.index')->withErrors([
                trans('trainings.permission')
            ]);
        }
//        Date::setLocale('nl');
        $starttime = Date::parse($training->starttime);
//        dd($starttime->format('l j F'));
//        dd($starttime);

        $training->starttime = $starttime;

        $categories = $training->categoryExercises()->positioned()
            ->with(['exercises' => function($query) {
                $query->positioned();
            }])->get();


        $swimmers = $training->swimmers;
        $stopwatches = [];
        foreach($swimmers as $swimmer) {
            if($swimmer->stopwatches()->where('created_at', '>', $training->starttime)->exists()) {
                $swimmerSw = $swimmer->stopwatches()
                    ->where('created_at', '>', $training->starttime)
                    ->where('created_at', '<', $training->starttime->addHours(3))
                    ->with(
                    ['times' => function ($query) {
                        $query->orderedRev();
                    }]
                )->get();
                foreach($swimmerSw as $stopwatch) {
                    $lastRecord = null;
                    $lastTime = 0;
                    foreach ($stopwatch->times as $key => $time) {
                        if ($lastRecord == $time->time || $time->time == 0) {
                            $stopwatch->times->pull($key);
                        } else {
                            $split = $time->time - $lastTime;
                            $time->split = $this->makeFullTime($split);
                            $lastTime = $time->time;
                            $lastRecord = $time->time;
                        }
                    }

                    $stopwatch->url = route(
                        '{group}.stopwatch.storeTime',
                        [
                            'group' => $group->slug,
                            'id'    => $stopwatch->id,
                        ]
                    );

                    $clock = 0;
                    $is_paused = true;
                    $lastTime = null;
                    if ($stopwatch->times->count()) {
                        $lastTime = $stopwatch->times->last();
                        $clock = $lastTime->time;
                        $is_paused = $lastTime->is_paused;

                        $lastTime = $lastTime->created;
                    }


                    $stopwatch->times = $stopwatch->times->sortByDesc('created_at');
//                    dd($stopwatch->times);

                    $stopwatch->clock = $clock;
                    $stopwatch->is_paused = $is_paused;
                    $stopwatch->lastTime = $lastTime;
                    $stopwatch->records = $stopwatch->getBestTime();
                    $stopwatch->recordsUrl = route('stopwatch.record.api', [
                        'id' => $stopwatch->id,
                    ]);

                    array_push($stopwatches, $stopwatch);
                }
            }
        }
//        dd($stopwatches);
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
            'stopwatches' => $stopwatches,
            'strokes'      => $this->stroke->all(),
            'starttime' => $starttime,
        ];

        return view('trainings.show', $data);
    }

    /**
     * @param $id
     */
    public function edit($id)
    {
        $group = Auth::user()->getGroup();
        $training = $group->trainings()->find($id);
//            ->with(['exercises' => function ($query) {
//                $query->positioned();
//            }])
        if(!Auth::user()->clearance_level > 0 && !$training->is_shared) {

            return redirect()->back()->withErrors([
                'you aren\'t permitted to view this training',
            ]);
        }
        $training->starttime = Date::parse($training->starttime);
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
            'group' => $group,
            'swimmers' => $swimmers,
        ];

        return view('trainings.edit', $data);

    }

    /**
     * @param $id
     */
    public function update(Request $request, Group $group, $id)
    {
        $group = Auth::user()->getGroup();

        $training = $group->trainings()->find($id);
        $training->starttime = $request->starttime;
        $training->save();

        return redirect()->route('training.show',[
            'id' => $training->id,
        ]);
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

    private function makeFullTime($input)
    {
        $data = collect([]);

        $data->milliseconds = $input % 1000;
        $data->hundredth = $input % 100;
        $input = floor($input / 1000);

        $data->seconds = $input % 60;
        $input = floor($input / 60);

        $data->minutes = $input % 60;
        $input = floor($input / 60);

        $data->hours = $input % 24;
        $input = floor($input / 24);

        $data->toText = //sprintf('%02d', $data->hours) . ':' .
            sprintf('%02d', $data->minutes) . ':' .
            sprintf('%02d', $data->seconds) . '.' .
            sprintf('%02d', $data->milliseconds / 10);

        $data->arr = str_split($data->toText);

        return $data;
    }


}
