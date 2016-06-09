<?php

namespace App\Http\Controllers\Swimmer;

use App\Classes\SwimmerProfile;
use App\Group;
use App\Stroke;
use App\Swimmer;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

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
     * @var User
     */
    private $user;
    /**
     * @var Stroke
     */
    private $stroke;

    /**
     * SwimmerController constructor.
     *
     * @param Swimmer $swimmer
     * @param Group $group
     * @param User $user
     * @param Stroke $stroke
     */
    public function __construct(Swimmer $swimmer, Group $group, User $user, Stroke $stroke)
    {
        $this->swimmer = $swimmer;
        $this->group = $group;
        $this->user = $user;
        $this->stroke = $stroke;
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
            'group'    => $group,
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
            'group' => $group,
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
        $swimmer = $this->swimmer->fill(
            [
                'first_name'      => $request->first_name,
                'last_name'       => $request->input('last_name'),
                'swimrankings_id' => $request->input('swimrankings'),
//                'email'           => $request->email,
            ]
        );

        $swimmer = $group->swimmers()->save($swimmer);

        $this->createLogin($swimmer, $request->email);
        $swimmer->getPersonalBest();
        $swimmer->seedPDF();

        return redirect()->route(
            'groups.show',
            [
                'group' => $group->slug,
            ]
        );
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
        if ($group->id != $swimmer->group_id) {
            abort(404, 'page not found');
        }

        $data = $swimmer->get();
//        dd($data);

        $data['group'] = $group;
        $data['myProfile'] = false;
        $data['strokes'] = $this->stroke->with('distances')->get();

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
        if ($group->id != $swimmer->group_id) {
            abort(404, 'page not found');
        }

        $data = [
            'group'   => $group,
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
     * create login for new swimmer.
     *
     * @param $swimmer
     * @param $email
     * @return bool
     */
    private function createLogin($swimmer, $email)
    {
        if ( ! $this->user->where('email', $email)->exists()) {
            $user = $this->user->create(
                [
                    'clearance_level' => config('clearance.swimmer'),
                    'email'           => $email,
                    'name'            => $swimmer->first_name . ' ' . $swimmer->last_name,
                    'password'        => bcrypt(random_string(10)),
                ]
            );

            $user->addMeta('swimmer_id', $swimmer->id);
            $token = strtolower(str_random(64));

            DB::table('password_resets')->insert(
                [
                    'email' => $email,
                    'token' => $token,
                ]
            );
            $this->sendLogin($token, $swimmer, $email);
        }

        return true;
    }

    /**
     * send login link over mail
     *
     * @param $token
     * @param $swimmer
     * @param $email
     * @return bool
     */
    private function sendLogin($token, $swimmer, $email)
    {
        $route = route(
            'password.reset.{token}',
            [
                'token' => $token,
            ]
        );

        Mail::send(
            'emails.reset',
            ['route' => $route, 'swimmer' => $swimmer],
            function ($m) use ($email) {
                $m->from('jeroen.vandenbroeck@student.kdg.be', Auth::user()->name . ' - topswim');
                $m->to($email, 'topswim')->subject('account geregistreerd');
            }
        );

        return true;
    }

    /**
     * download pr's
     *
     * @param Group $group
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Group $group)
    {
        $groupPath = $group->slug;
        $path = '../storage/app/' . $groupPath;
        if ( ! file_exists($path)) {
            mkdir($path, 0777, true);
            mkdir($path . '/bestTimes', 0777, true);
        }
        $path = $path . '/';
        $zipname = $path . 'bestTimes.zip';
        if (file_exists($zipname)) {
            unlink($zipname);
        }

        $zip = new ZipArchive();
        $zip->open($zipname, ZipArchive::CREATE);

        foreach (Storage::allFiles(
            $groupPath . '/bestTimes'
        ) as $file) { /* Add appropriate path to read content of zip */
            $toZip = '../storage/app/' . $file;
            $zip->addFile($toZip, $file);
        }

        $zip->close();

        $headers = [
            'Content-Disposition: attachment',
            'filename: ' . $zipname,
        ];

        return response()->download($zipname, 'BestTimes.zip', $headers);
    }
}
