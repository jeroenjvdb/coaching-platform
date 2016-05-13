<?php

namespace App\Http\Controllers;

use App\Classes\SwimmerProfile;
use App\Swimmer;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use JavaScript;

class MyController extends Controller
{
    /**
     * @var Swimmer
     */
    private $swimmer;

    public function __construct(Swimmer $swimmer)
    {
        $this->swimmer = $swimmer;
    }

    /**
     * store reactions meta
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $swimmer = $this->swimmer->find($user->getMeta('swimmer_id'));

        $swimmer->reaction($request->message);

        return redirect()->back();

    }

    /**
     * get own profile
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function me()
    {
        $id = Auth::user()->getMeta('swimmer_id');
        if(! $id) {
            abort('404', 'page not found');
        }
        $swimmer = Swimmer::find($id);

        $data = $swimmer->get();
        $data['hasHeartRate'] = $swimmer->checkHeartRate();
        $data['group'] = $swimmer->group;
        $data['myProfile'] = true;


        JavaScript::put([
            'HR' => $data['meta']['heartRate'],
        ]);

        return view('swimmers.show', $data);
    }

    public function heartRate(Request $request)
    {
        $id = Auth::user()->getMeta('swimmer_id');
        if(! $id) {
            abort('404', 'page not found');
        }
        $swimmer = Swimmer::find($id);
        $profile = $swimmer;

        $profile->storeHeartRate($request->heartRate, $request->forgot);

        return redirect()->back();
    }

    public function getHeartRate()
    {
        $swimmer = Swimmer::find(Auth::user()->getMeta('swimmer_id'));

        $data = $swimmer->get();
        $hr = $data['meta']['heartRate'];

        return json_encode(['hr' => $hr]);
    }


}
