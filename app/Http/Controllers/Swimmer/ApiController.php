<?php

namespace App\Http\Controllers\Swimmer;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function heartRate()
    {
        return json_encode([
            'type' => 'success',
        ]);
    }
}
