<?php

namespace App\Http\Controllers;

use App\Distance;
use App\Group;
use App\Stopwatch;
use App\Stroke;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use JavaScript;

class StopwatchController extends Controller
{
    /**
     * @var Stroke
     */
    private $stroke;
    /**
     * @var Distance
     */
    private $distance;
    /**
     * @var Stopwatch
     */
    private $stopwatch;

    public function __construct(Stroke $stroke, Distance $distance, Stopwatch $stopwatch)
    {
        $this->stroke = $stroke;
        $this->distance = $distance;
        $this->stopwatch = $stopwatch;
    }

    /**
     * get all stopwatches
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $group = Auth::user()->getGroup();

        $data = [
            'group'        => $group,
            'swimmers'     => $swimmers = $group->swimmers()->orderBy('first_name')->lists('first_name', 'id'),
            'strokes'      => $this->stroke->all(),
            'chronometers' => $group->stopwatches,
        ];

        return view('stopwatches.index', $data);
    }

    /**
     * create new stopwatch
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $group = Auth::user()->getGroup();

        $swimmers = $group->swimmers()->lists('first_name', 'id');
        $strokes = $this->stroke->with('distances')->get();

        $data = [
            'group'    => $group,
            'swimmers' => $swimmers,
            'strokes'  => $strokes,
        ];

        return view('stopwatches.create', $data);
    }

    /**
     * store stopwatch
     *
     * @param Request $request
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $group = Auth::user()->getGroup();

        $swimmer = $group->swimmers()->findOrFail($request->swimmer);
        $distance = $this->distance->find($request->distance);


        $stopwatchData = $this->stopwatch->fill(
            [
                'swimmer_id'  => $swimmer->id,
                'distance_id' => $distance->id,
                'is_running'  => false,
            ]
        );

        $stopwatch = Auth::user()->stopwatches()->save($stopwatchData);

        return redirect()->route(
            '{group}.stopwatch.show',
            [
                'group' => $group->slug,
                'id'    => $stopwatch->id,
            ]
        );
    }

    /**
     * store stopwatch for api
     *
     * @param Request $request
     * @param Group $group
     * @return string
     */
    public function storeApi(Request $request)
    {
        $group = Auth::user()->getGroup();

        $swimmer = $group->swimmers()->findOrFail($request->swimmer);
        $distance = $this->distance->find($request->distance);

        $stopwatchData = $this->stopwatch->fill(
            [
                'swimmer_id'  => $swimmer->id,
                'distance_id' => $distance->id,
                'is_running'  => false,
            ]
        );

        $stopwatch = Auth::user()->stopwatches()->save($stopwatchData);
        $storeTimeRoute = route(
            '{group}.stopwatch.storeTime',
            [
                'group' => $group->slug,
                'id'    => $stopwatch->id,
            ]
        );

        $data = [
            'form'  => 'timer',
            'route' => $storeTimeRoute,
            'records' => $stopwatch->getBestTime(),
            'swimmer'   => $stopwatch->swimmer,
            'distance'  => $stopwatch->distance,
            'stroke'    => $stopwatch->distance->stroke,
        ];

        return json_encode($data);
    }


    /**
     * show stopwatch
     *
     * @param Group $group
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $user = Auth::user();
        $group = $user->getGroup();

        $stopwatch = $user->stopwatches()
            ->where('stopwatches.id', $id)
            ->with(
                ['times' => function ($query) {
                    $query->orderedRev();
                }]
            )->first();


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


        $clock = 0;
        $is_paused = true;
        $lastTime = null;
        if ($stopwatch->times->count()) {
            $lastTime = $stopwatch->times->last();
            $clock = $lastTime->time;
            $is_paused = $lastTime->is_paused;

            $lastTime = $lastTime->created;
        }


        $storeUrl = route(
            '{group}.stopwatch.storeTime',
            [
                'group' => $group->slug,
                'id'    => $id,
            ]
        );

        JavaScript::put(
            [
                'user_id'         => $user->id,
                'stopwatch_id'    => $id,
                'stopwatch_store' => $storeUrl,
                'clock'           => $clock,
                'is_paused'       => $is_paused,
                'lastTime'        => $lastTime,
            ]
        );

        $stopwatch->recordsUrl = route('stopwatch.record.api', [
            'id' => $stopwatch->id,
        ]);
        $stopwatch->clock = $clock;
        $stopwatch->is_paused = $is_paused;
        $stopwatch->lastTime = $lastTime;
        $stopwatch->url = $storeUrl;
        $stopwatch->times = $stopwatch->times->sortByDesc('created_at');

        $data = [
            'group'     => $group,
            'stopwatch' => $stopwatch,
            'url'       => $storeUrl,
            'is_paused' => $is_paused,
            'clock'     => $clock,
            'lastTime'  => $lastTime,
            'records'   => $stopwatch->getBestTime(),
            'swimmer'   => $stopwatch->swimmer,
            'distance'  => $stopwatch->distance,
            'stroke'    => $stopwatch->stroke,

        ];

//        dd($data);

        return view('stopwatches.show', $data);
    }

    /**
     * Get the records
     *
     * @param $id
     * @return string
     */
    public function recordApi($id)
    {
        $stopwatch = $this->stopwatch->find($id);

        return json_encode([
           'besttimes' =>$stopwatch->getBestTime(),
            'swimmer' => $stopwatch->swimmer,
            'stroke' => $stopwatch->distance->stroke,
            'distance' => $stopwatch->distance,

        ]);
    }

    /**
     * make readable time
     *
     * @param $input
     * @return \Illuminate\Support\Collection
     */
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
