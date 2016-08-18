<?php

namespace App\Http\Controllers\Swimmer;

use App\Group;
use App\Swimmer;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests\HeartrateRequest;
use App\Http\Requests\WeightRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    /**
     * get heartrates of swimmer
     *
     * @param Request $request
     * @param Group $group
     * @param Swimmer $swimmer
     * @return string
     */
    public function getHeartRate(Request $request, Group $group, Swimmer $swimmer)
    {
        $hr = $swimmer->getHeartRates($request->start, $request->end);

        return json_encode([
            'type' => 'success',
            'datatype' => 'heartRate',
            'label' => 'Slagen / Minuut',
            'data' => $hr,
        ]);
    }

    /**
     * store heartrate
     *
     * @param Request $request
     * @param Group $group
     * @param Swimmer $swimmer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function heartRate(HeartrateRequest $request, Group $group, Swimmer $swimmer)
    {
        $swimmer->storeHeartRate($request->heartRate, $request->forgot);

        return redirect()->back();
    }

    /**
     * get weights
     *
     * @param Request $request
     * @param Group $group
     * @param Swimmer $swimmer
     * @return string
     */
    public function weights(Request $request, Group $group, Swimmer $swimmer)
    {
        $weights = $swimmer->getWeights($request->start, $request->end);

        return json_encode([
            'type' => 'success',
            'datatype' => 'weight',
            'label' => 'Kilogram',
            'data' => $weights,
        ]);
    }

    /**
     * store weightss
     *
     * @param Request $request
     * @param Group $group
     * @param Swimmer $swimmer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postWeight(WeightRequest $request, Group $group, Swimmer $swimmer)
    {
        $swimmer->weights()->create([
            'weight' => $request->weight,
            'date' => Carbon::today(),
        ]);

        return redirect()->back();
    }

    /**
     * get data.
     *
     * @param Request $request
     * @param Swimmer $swimmer
     * @return \Illuminate\Support\Collection
     */
    public function data(Request $request, Swimmer $swimmer)
    {
        Log::info('page',[ $request->page ]);

        return $swimmer->getTheMeta($request->page);
    }

    /**
     * get presence percentage between two dates.
     *
     * @param Request $request
     * @param Swimmer $swimmer
     * @return string
     */
    public function presences(Request $request, Swimmer $swimmer)
    {
        $start = $request->start;
        $end = $request->end;

        $percentage = $swimmer->presences($start, $end);

        return json_encode([
            'type' => 'success',
            'presences' => $percentage,
                           ]);
    }
}
