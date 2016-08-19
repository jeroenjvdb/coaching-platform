<?php

namespace App\Http\Controllers\Training;

use App\Group;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{
    /**
     * store presences from a training
     *
     * @param Request $request
     * @param Group $group
     * @param $training_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Group $group, $training_id)
    {
        $group = Auth::user()->getGroup();
        $training = $group->trainings()->find($training_id);
        $swimmers = $training->swimmers;
        foreach($swimmers as $swimmer) {
            $swimmer->pivot->is_present = false;
            if($request->swimmers && in_array($swimmer->id, $request->swimmers)) {
                $swimmer->pivot->is_present = true;
            }
            $swimmer->pivot->save();
        }

        return redirect()->back();
    }

    /**
     * Store swimmers who have to go to the training.
     *
     * @param Request $request
     * @param Group $group
     * @param $training_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function swimmers(Request $request, Group $group, $training_id)
    {
        $group = Auth::user()->getGroup();
        $swimmerIds = $request->swimmers;
        $swimmers = $group->swimmers()->whereIn('id', $swimmerIds)->get();

        $training = $group->trainings()->find($training_id);
        $training->swimmers()->sync($swimmers);

        return redirect()->back();
    }
}
