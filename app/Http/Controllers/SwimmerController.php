<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Swimmer;

use GuzzleHttp\Client;

class SwimmerController extends Controller
{

	public function index()
	{
		$data = [
			'swimmers' => Swimmer::all(),
		];

		return view('swimmers.index', $data);
	}

	public function create()
	{

		return view('swimmers.create');
	}

	public function store(Request $request)
	{
		
		return redirect()->route('swimmers.index');
	}

	public function show($id)
	{
		$swimmer = Swimmer::findOrFail($id);
		echo '<h1>' . $swimmer->name . '</h1>';
		$personalBests = $this->getPersonalBest($swimmer->swimrankings_id);
		echo $personalBests;

		$data = [
			'swimmer' => $swimmer,
			'personalBests' => $personalBests,
		];

		// return view('swimmers.show');

	}

    private function getPersonalBest($athleteId)
    {
    	$client = new Client();
    	$url = 'https://www.swimrankings.net/index.php?page=athleteDetail&athleteId=' . $athleteId;
    	$parameters = [];

    	$res = $client->request('GET', $url, $parameters);
		$pattern = '/<table class="athleteBest"[\s\S]*<\/table>/';
		preg_match($pattern, $res->getBody(), $table);

		return $table[0] ;
    }
}
	