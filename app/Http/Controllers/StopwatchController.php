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

    public function index(Group $group)
    {
        $data = [
            'group' => $group,
            'swimmers' => $group->swimmers,
            'strokes' => $this->stroke->all(),
            'chronometers' => $group->stopwatches,
        ];

        return view('stopwatches.index', $data);
    }

    public function create(Group $group)
    {
        $swimmers = $group->swimmers()->lists('first_name', 'id');
        $strokes = $this->stroke->with('distances')->get();

        $data = [
            'group' => $group,
            'swimmers' => $swimmers,
            'strokes' => $strokes,
        ];

        return view('stopwatches.create', $data);
    }

    public function store(Request $request, Group $group)
    {
        $swimmer = $group->swimmers()->findOrFail($request->swimmer);
        $distance = $this->distance->find($request->distance);

        $stopwatchData = $this->stopwatch->fill([
            'swimmer_id' => $swimmer->id,
            'distance_id' => $distance->id,
            'is_running' => false,
        ]);

        $stopwatch = Auth::user()->stopwatches()->save( $stopwatchData );

        return redirect()->route('{group}.stopwatch.show', [
            'group' => $group->slug,
            'id' => $stopwatch->id,
        ]);
    }

    public function storeApi(Request $request, Group $group)
    {
        $swimmer = $group->swimmers()->findOrFail($request->swimmer);
        $distance = $this->distance->find($request->distance);

        $stopwatchData = $this->stopwatch->fill([
            'swimmer_id' => $swimmer->id,
            'distance_id' => $distance->id,
            'is_running' => false,
        ]);

        $stopwatch = Auth::user()->stopwatches()->save( $stopwatchData );
        $storeTimeRoute = route('{group}.stopwatch.storeTime', [
            'group' => $group->slug,
            'id' => $stopwatch->id,
        ]);

        $data = [
            'form' => 'timer',
            'route' => $storeTimeRoute,

        ];

        return json_encode($data);
    }



    public function show(Group $group, $id) {
        $user = Auth::user();
        $stopwatch = $user->stopwatches()
                            ->where('stopwatches.id', $id)
                            ->with(['times' => function($query){
                                $query->ordered();
                            }])->first();

        $lastRecord = null;
        foreach($stopwatch->times as $key => $time)
        {
            if ($lastRecord == $time->time) {
                $stopwatch->times->pull($key);
            } else {
                $lastRecord = $time->time;

            }
        }


        $clock = 0;
        $is_paused = true;
        $lastTime = null;
        if ( $stopwatch->times->count() ) {
            $lastTime = $stopwatch->times->first();
            $clock = $lastTime->time;
            $is_paused = $lastTime->is_paused;

            $lastTime = $lastTime->created;
        }

        $storeUrl = route('{group}.stopwatch.storeTime', [
            'group' => $group->slug,
            'id' => $id,
        ]);

       // dd($stopwatch->times->last()->time);
        JavaScript::put([
            'user_id' => $user->id,
            'stopwatch_id' => $id,
            'stopwatch_store' =>$storeUrl,
            'clock' =>  $clock,
            'is_paused' => $is_paused,
            'lastTime' => $lastTime,
        ]);

        $data = [
            'group' => $group,
            'stopwatch' => $stopwatch,
            'url' => $storeUrl,
            'is_paused' => $is_paused,
            'clock' => $clock,
            'lastTime' => $lastTime,
        ];

        return view('stopwatches.show', $data);
    }
}
