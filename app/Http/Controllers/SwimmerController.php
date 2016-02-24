<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use GuzzleHttp\Client;

class SwimmerController extends Controller
{
    public function jeroen()
    {
    	echo '<h1>Jeroen</h1>';
    	echo $this->getPersonalBest('4295910');

    }

    public function philippe()
    {
    	echo '<h1>Philippe</h1>';
    	echo $this->getPersonalBest('4680497');
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
	