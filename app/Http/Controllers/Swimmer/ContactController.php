<?php

namespace App\Http\Controllers\Swimmer;

use App\Swimmer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    /**
     * @var Swimmer
     */
    private $swimmer;

    public function __construct(Swimmer $swimmer)
    {
        $this->swimmer = $swimmer;
    }

    public function update(Request $request, Swimmer $swimmer)
    {
        dd($swimmer);
    }
}
