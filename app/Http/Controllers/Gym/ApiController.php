<?php

namespace App\Http\Controllers\Gym;

use App\Group;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Jenssegers\Date\Date;

class ApiController extends Controller
{
    /**
     * get fitness trainings
     *
     * @param Request $request
     * @param Group $group
     * @return string
     */
    public function get(Request $request, Group $group)
    {
        $trainings = $group->gyms()
            ->where('start_time', '>', $request->start)
            ->where('start_time', '<', $request->end);
        if(! Auth::user()->clearance_level > 0) {
            $trainings = $trainings->where('is_shared', 1);
        }
        $trainings = $trainings->get();


        $trainingsArr = [];

        foreach($trainings as $training) {
            $starttime = Date::parse($training->start_time);
            $start = $starttime->toDateTimeString();
            $endtime = $starttime->addHours(2)->toDateTimeString();
            $url = route('{group}.gym.show', [
                'group' => $group->slug,
                'training_id' => $training->id,
            ]);

            $data = [
                'start' => $start,
                'end' => $endtime,
                'url' => $url,
            ];

            array_push($trainingsArr, $data);
        }


        return json_encode($trainingsArr);
    }

    public function store()
    {

    }
}
