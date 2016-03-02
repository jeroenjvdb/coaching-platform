<?php

namespace App\Http\Controllers;

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
     * SwimmerController constructor.
     * @param Swimmer $swimmer
     */
    public function __construct(Swimmer $swimmer)
    {
        $this->swimmer = $swimmer;
    }

    /**
     * show all swimmers
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'swimmers' => $this->swimmer->all(),
        ];

        return view('swimmers.index', $data);
    }

    /**
     * get create view for swimmers
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        return view('swimmers.create');
    }

    /**
     * store the swimmers in the database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $swimmer = $this->swimmer->create([
            'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'profile_id' => $request->input('swimrankings'),
        ]);

        return redirect()->route('swimmers.index');
    }

    /**
     * show the profile of a swimmer
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $swimmer = $this->swimmer->findOrFail($id);
        $personalBests = $this->getPersonalBest($swimmer->swimrankings_id);

        $data = [
            'swimmer' => $swimmer,
            'personalBests' => $personalBests,
        ];

        return view('swimmers.show', $data);

    }

    /**
     * open the edit page of this swimmer
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $data = [
            'swimmer' => $this->swimmer->findOrFail($id),
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

        return $table[0];
    }
}
	