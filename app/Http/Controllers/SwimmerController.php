<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Swimmer;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SwimmerController extends Controller
{
    /**
     * @var Swimmer
     */
    private $swimmer;
    /**
     * @var Group
     */
    private $group;

    /**
     * SwimmerController constructor.
     * @param Swimmer $swimmer
     */
    public function __construct(Swimmer $swimmer, Group $group)
    {
        $this->swimmer = $swimmer;
        $this->group = $group;
    }

    /**
     * show all swimmers
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Group $group)
    {
        $data = [
            'group' => $group,
            'swimmers' => $group->swimmers,
        ];

        return view('swimmers.index', $data);
    }

    /**
     * get create view for swimmers
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Group $group)
    {
        $data = [
            'group' => $group
        ];

        return view('swimmers.create', $data);
    }

    /**
     * store the swimmers in the database
     *
     * @param Request $request
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Group $group)
    {
        $group = Auth::user()->getGroup();

        dd($group);

        $swimmer = $this->swimmer->fill([
            'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'profile_id' => $request->input('swimrankings'),
            'group_id' => $group->id,
        ]);

        dd($swimmer);

//        $group->swimmers()->save($swimmer);

        return redirect()->route('swimmers.index', ['group' => $group->slug]);
    }

    /**
     * show the profile of a swimmer
     *
     * @param Group $group
     * @param Swimmer $swimmer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Group $group, Swimmer $swimmer)
    {
        if( $group->id != $swimmer->group_id ) {
            abort(404, 'page not found');
        }



        $stopwatches = $swimmer->stopwatches()->orderBy('created_at', 'desc')->with('distance', 'distance.stroke')->get();

        $personalBests = $this->getPersonalBest($swimmer->swimrankings_id);
        $personalBests = removeLinks($personalBests);

        $data = [
            'group' => $group,
            'swimmer' => $swimmer,
            'personalBests' => $personalBests,
            'stopwatches' => $stopwatches,
        ];

        return view('swimmers.show', $data);

    }

    /**
     * open the edit page of this swimmer
     *
     * @param Group $group
     * @param Swimmer $swimmer
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Group $group, Swimmer $swimmer)
    {
        if( $group->id != $swimmer->group_id ) {
            abort(404, 'page not found');
        }

        $data = [
            'group' => $group,
            'swimmer' => $group->swimmers()->findOrFail($swimmer->id),
        ];

        return view('swimmers.edit', $data);
    }

    public function update($id)
    {

    }

    public function destroy(Group $group, Swimmer $swimmer)
    {
        if(! $group->swimmers()->find($swimmer->id)) {
            return redirect()->back()->withErrors('De zwemmer is niet gevonden.');
        }

        $swimmer->delete();

        return redirect('groups.show', [
            'group' => $group,
        ]);
    }


}
	