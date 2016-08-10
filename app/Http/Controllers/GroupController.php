<?php

namespace App\Http\Controllers;

use App\Group;
use App\Swimmer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * @var Group
     */
    private $group;
    /**
     * @var Swimmer
     */
    private $swimmer;

    public function __construct(Group $group, Swimmer $swimmer)
    {
        $this->group = $group;
        $this->swimmer = $swimmer;
    }

    /**
     * Get all the groups.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'groups' => $this->group->with(
                ['swimmers' => function ($query) {
                    $query->ordered()->get();
                }]
            ),
        ];

        return view('groups.index', $data);
    }

    /**
     * Get the create page for a new group.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a new group.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(GroupRequest $request)
    {
        $group = $this->group->create(
            [
                'name' => $request->input('name'),
            ]
        );

        $user = Auth::user();
        $coach = $user->coach;
        $group->coaches()->attach($coach->id);

        return redirect()->route(
            'groups.show',
            [
                'group' => $group->slug,
            ]
        );
    }

    /**
     * show a specific group.
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Group $group)
    {
        $swimmers = $group
            ->swimmers()
            ->ordered()
            ->get();
        $today = Carbon::today();
        $tomorrow = Carbon::today()
            ->addDay();

        $trainings = $group->trainings()
            ->where('starttime', '>', $today)
            ->where('starttime', '<', $tomorrow)
            ->get();

        $user = Auth::user();
        $mySwimmer = null;
        if ($user->getMeta('swimmer_id')) {
            $is_swimmer = true;
            $mySwimmer = $this->swimmer->find($user->getMeta('swimmer_id'));
        }

        $data = [
            'group'     => $group,
            'trainings' => $trainings,
            'swimmers'  => $swimmers,
            'coaches'   => $group->coaches,
            'mySwimmer' => $mySwimmer,
        ];

        return view('groups.show', $data);
    }

    /**
     * Get the edit page of a specific group.
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Group $group)
    {
        $data = [
            'group' => $group,
        ];

        return view('groups.edit', $data);
    }

    /**
     * Update a specific group.
     *
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Group $group)
    {
        //TODO: updaten

        $data = [
            'group' => $group,
        ];

        return redirect()->route('groups.show', [$group->slug]);
    }

    /**
     * Delete a specific group.
     *
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Group $group)
    {
        //TODO: soft delete toevoegen

        $group->delete();

        return redirect('/');
    }

    /**
     * Select other group.
     *
     * @param $group_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function select($group_id)
    {
        $group = $this->group->where('id', $group_id)->first();
        if($group) {
            Auth::user()->updateMeta('group', $group->id);
        }

        return redirect()->back();
    }
}
