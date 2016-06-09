<?php

namespace App\Http\Controllers\Swimmer;

use App\Group;
use App\Swimmer;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
            'label' => 'ochtendpols',
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
    public function heartRate(Request $request, Group $group, Swimmer $swimmer)
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
            'label' => 'gewicht',
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
    public function postWeight(Request $request, Group $group, Swimmer $swimmer)
    {
        $swimmer->weights()->create([
            'weight' => $request->weight,
            'date' => Carbon::today(),
        ]);

        return redirect()->back();
    }
}
