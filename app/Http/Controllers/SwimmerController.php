<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Swimmer;

use GuzzleHttp\Client;

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
        $swimmer = $this->swimmer->fill([
            'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'profile_id' => $request->input('swimrankings'),
        ]);

        $group->swimmers()->save($swimmer);

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
        $personalBests = $this->getPersonalBest($swimmer->swimrankings_id);
        $personalBests = removeLinks($personalBests);

        $data = [
            'group' => $group,
            'swimmer' => $swimmer,
            'personalBests' => $personalBests,
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

    public function delete()
    {

    }

    /**
     * get personal bests from swimrankings
     *
     * @param $athleteId
     * @return mixed
     */
    private function getPersonalBest($athleteId)
    {
        $url = config('swimrankings.url') . config('swimrankings.swimmersPage') . $athleteId;
        $parameters = [];

        $res = getCall($url, $parameters);

        $pattern = '/<table class="athleteBest"[\s\S]*<\/table>/';
        preg_match($pattern, $res->getBody(), $table);

        $pattern = '/<script[\s\S]*?<\/script>/';
        $body = "not found";
        if(isset($table[0])) {
            $body = preg_replace($pattern, '', $table[0]);
        }

        return $body;
    }
}
	