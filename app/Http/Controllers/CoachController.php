<?php

namespace App\Http\Controllers;

use App\Coach;
use App\Group;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CoachController extends Controller
{
    /**
     * @var Coach
     */
    private $coach;
    /**
     * @var User
     */
    private $user;

    public function __construct(Coach $coach, User $user)
    {
        $this->coach = $coach;
        $this->user = $user;
    }

    /**
     * Show all coaches.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        return view('coach.index');
    }

    /**
     * Create new coach.
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Group $group)
    {
        $data = [
            'group' => $group,
        ];

        return view('coach.create', $data);
    }

    /**
     * Save new coach.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Group $group)
    {
        echo 'store';

        $user = $this->user->where('email', $request->email)->first();
        if($user) {
            if($user->clearance_level < 1) {
                $user->clearance_level = 1;
                $user->save();
            }



        } else {
            $user = $this->user->create([
                'email' => $request->email,
                'clearance_level' => 1,
                'name' => $request->first_name,
                'password' => bcrypt('root'),
            ]);

            $token = hash_hmac('sha256', Str::random(40), env('APP_KEY'));
            DB::table('password_resets')->insert(['email' => $request->email, 'token' => $token, 'created_at' => new Carbon]);

//            Log::info($email);
            $this->sendLogin($token, $request->email);
        }

        $coach = $user->coach;
        if(! $coach) {
            $coach = $user->coach()->create(
                [
                    'first_name' => $request->first_name,
                    'last_name'  => $request->last_name,
                ]
            );
        }

        $group->coaches()->attach($coach);

        return redirect()->route('groups.show', [
            'group' => $group->slug
        ]);
    }

    /**
     * Show specific coach.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $coach = $this->coach->findOrFail($id);

        $data = [
            'coach' => $coach,
            'contact' => [
                'picture' => $coach->getMeta('picture'),
                'phone' => '0491436631',
                'address' => [
                    'street' => 'Bernard de Pooterstraat',
                    'number' => '9',
                    'city' => 'Wilrijk',
                    'zipcode' => '2610'
                ],
            ],
            'group' => Auth::user()->getGroup(),
        ];

        return view('coach.show', $data);
    }

    /**
     * Edit specific coach.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $data = [
            'coach' => $this->coach->findOrFail($id),
        ];

        return view('coach.edit');
    }

    /**
     * Update specific coach.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $group = Auth::user()->getGroup();
        $coach = $this->coach->findOrFail($id);

        if($request->picture && true) {
            $quality = 90;
            $src  = $request->picture;
            $img  = imagecreatefromjpeg($src);
            $dest = ImageCreateTrueColor($request->w,
                                         $request->h);

            imagecopyresampled($dest, $img, 0, 0, $request->x,
                               $request->y, $request->w, $request->h,
                               $request->w, $request->h);
            imagejpeg($dest, $src, $quality);

            $coach->updateMeta('picture', $this->storeImage($src, $group, $coach));
            return redirect()->back();
        } else if ($request->picture && ! $request->picture->isValid()) {
            return redirect()->back()->withErrors('Er is iets mis met deze afbeelding');
        }

        return redirect()->route('coach.show', [$id]);
    }

    /**
     * Delete specific coach.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $coach = $this->coach->findOrFail($id);

        $coach->delete();

        return redirect()->route('coach.index');
    }

    protected function storeImage($img, Group $group, Coach $coach)
    {
        $destinationPath   = "uploads/profilePics/" . $group-> slug . '/';
        $extension         = $img->getClientOriginalExtension();
        $filename = createSlug($coach->first_name . ' ' . $coach->last_name);
        $filename .= "." . $extension;
        //fullpath = path to picture + filename + extension
        $fullPath          = $destinationPath . $filename;
        $img->move($destinationPath , $filename);

        return '/' . $fullPath;
    }



    /**
     * Send the login link to the user.
     *
     * @param $token
     * @param $email
     * @return bool
     */
    private function sendLogin($token, $email)
    {
        $route = route(
            'password.reset.{token}',
            [
                'token' => $token,
            ]
        );

        Mail::send(
            'emails.reset2',
            ['route' => $route],
            function ($m) use ($email) {
                $m->from('jeroen.vandenbroeck@student.kdg.be', Auth::user()->name . ' - topswim');
                $m->to($email, 'topswim')->subject('account geregistreerd');
            }
        );

        return true;
    }
}
