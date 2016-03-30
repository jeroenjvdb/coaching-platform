<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * @var Group
     */
    private $group;

    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    /**
     * Get all the groups.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'groups' => $this->group->all(),
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
    public function store(Request $request)
    {
        $group = $this->group->create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('groups.index');
    }

    /**
     * show a specific group.
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Group $group)
    {
        $data = [
            'group' => $group,
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

        return redirect()->route('groups.index');
    }
}
