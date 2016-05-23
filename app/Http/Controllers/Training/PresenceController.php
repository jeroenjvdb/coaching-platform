<?php

namespace App\Http\Controllers\Training;

use App\Group;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PresenceController extends Controller
{
    public function store(Request $request, Group $group, $training_id)
    {
        $swimmerIds = $request->swimmers;
        $swimmers = $group->swimmers()->whereIn('id', $swimmerIds)->get();

        $training = $group->trainings()->find($training_id);
        $training->swimmers()->sync($swimmers);

        return redirect()->back();
    }
}
