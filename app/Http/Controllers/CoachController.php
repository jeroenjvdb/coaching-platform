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
        $data = [
            'coach' => $this->coach->findOrFail($id),
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
    public function update($id)
    {
        $coach = $this->coach->findOrFail($id);

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
