<?php

namespace App\Http\Controllers\Swimmer;

use App\Group;
use App\Swimmer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function getHeartRate(Group $group, Swimmer $swimmer)
    {
        $data = $swimmer->get();
        $hr = $data['meta']['heartRate'];

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
