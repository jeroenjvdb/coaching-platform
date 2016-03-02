<?php

function getCall($url, $parameters)
{
    	$client = new GuzzleHttp\Client();

    	$res = $client->request('GET', $url, $parameters);

    	if($res->getStatusCode() == '200')
    	{
    		return $res;
    	}
}















?>