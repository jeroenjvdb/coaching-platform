<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

use App\Http\Requests;

class StopwatchTimeController extends Controller
{
    public function __construct()
    {
    }


    /**
     * @param Request $request
     * @param Group $group
     */
    public function store(Request $request, Group $group)
    {
//        dd($request->all());
        $time = $group->stopwatches()->find($request->stopwatch_id)->times()->create([
            'time' => $request->clock,
        ]);

        return json_encode($time->time->toString);

//        return $data;
    }

    public function endTimer()
    {

    }
}
