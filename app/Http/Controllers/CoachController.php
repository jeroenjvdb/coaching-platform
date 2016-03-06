<?php

namespace App\Http\Controllers;

use App\Coach;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CoachController extends Controller
{
    /**
     * @var Coach
     */
    private $coach;

    public function __construct(Coach $coach)
    {
        $this->coach = $coach;
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        return view('coach.create');
    }

    /**
     * Save new coach.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $coach = $this->coach->create([

        ]);

        return redirect()->route('coach.index');
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
}
