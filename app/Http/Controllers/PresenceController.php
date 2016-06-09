<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

use App\Http\Requests;

class PresenceController extends Controller
{
    /**
     * store presences for training
     *
     * @param Request $request
     * @param Group $group
     * @param $training_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Group $group, $training_id)
    {
        $swimmerIds = $request->swimmers;
        $swimmers = $group->swimmers()->whereIn('id', $swimmerIds)->get();

        $training = $group->trainings()->find($training_id);
        $training->swimmers()->sync($swimmers);

        return redirect()->back();
    }
}
