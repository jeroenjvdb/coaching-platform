<?php

namespace App\Http\Controllers;

use App\Group;
use App\Stroke;
use Illuminate\Http\Request;

use App\Http\Requests;

class StopwatchController extends Controller
{
    /**
     * @var Stroke
     */
    private $stroke;

    public function __construct(Stroke $stroke)
    {
        $this->stroke = $stroke;
    }

    public function index(Group $group)
    {
        $data = [
            'swimmers' => $group->swimmers,
            'strokes' => $this->stroke->all(),
            'chronometers' => $group->stopwatches,
        ];

        return view('stopwatches.index', $data);
    }

    public function store(Request $request, Group $group)
    {
        dd($request->all());

        $stopwatch = $group->stopwatch->create([
            'user_id' => Auth::user()->id,
            'swimmer_id' => $swimmer->id,
            'distance_id' => $distance->id,
            'is_running' => false,
        ]);

        return redirect()->route('stopwatches.show', [
            'group' => $group>slug,
            'id' => $stopwatch->id,
        ]);
    }



    public function show(Group $group, $id) {
        $stopwatch = $group->stopwatches()
                            ->where('stopwatches.id', $id)
                            ->with(['times' => function($query){
                                $query->ordered();
                            }])->first();

        $data = [
            'group' => $group,
            'stopwatch' => $stopwatch,
        ];

        return view('stopwatches.show', $data);
    }
}
