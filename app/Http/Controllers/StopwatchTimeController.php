<?php

namespace App\Http\Controllers;

use App\Group;
use App\StopwatchTime;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StopwatchTimeController extends Controller
{
    /**
     * @var StopwatchTime
     */
    private $time;

    public function __construct(StopwatchTime $time)
    {
        $this->time = $time;
    }


    /**
     * @param Request $request
     * @param Group $group
     * @return string
     */
    public function store(Request $request, Group $group)
    {
        $is_paused = false;
        if( json_decode($request->is_paused) ) {
            //return json_encode('stop');
            $is_paused = true;
        }
        //return json_encode($request->dt);
        $time = $this->time->fill([
            'time' => $request->clock,
            'created' => $request->dt,
            'is_paused' => $is_paused,
        ]);

        $time = Auth::user()->stopwatches()->find($request->stopwatch_id)->times()->save( $time );

        Log::info('stored time: ', [$time]);

        return json_encode($time);
    }
}
