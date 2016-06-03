<?php

namespace App\Http\Controllers\Swimmer;

use App\Group;
use App\Swimmer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function getHeartRate(Request $request, Group $group, Swimmer $swimmer)
    {
        $hr = $swimmer->getHeartRates($request->start, $request->end);

        return json_encode([
            'type' => 'success',
            'datatype' => 'heartRate',
            'hr' => $hr
        ]);
    }

    public function heartRate(Request $request, Group $group, Swimmer $swimmer)
    {
        $swimmer->storeHeartRate($request->heartRate, $request->forgot);

        return redirect()->back();
    }
}
