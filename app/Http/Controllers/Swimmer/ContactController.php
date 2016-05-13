<?php

namespace App\Http\Controllers\Swimmer;

use App\Classes\SwimmerProfile;
use App\Group;
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

    /**
     * update contact.
     *
     * @param Request $request
     * @param Group $group
     * @param Swimmer $swimmer
     * @return string
     */
    public function update(Request $request, Group $group, Swimmer $swimmer)
    {
        $store = [
            'address' => [
                'street' => $request->street,
                'number' => $request->number,
                'city' => $request->city,
                'zipcode' => $request->zipcode,
            ],
            'phone' => $request->phone,
            'email' => [
                $request->emailMother,
                $request->emailFather,
            ]
        ];

        $swimmer->storeContact($store);

        $swimmer->email = $request->email;
        $swimmer->save();


        return json_encode([
            'type' => 'success',
            'form' => 'contact',
            'data' => [
                'swimmer' => $swimmer,
                'contact' => $swimmer->get()['contact'],
            ]
        ]);
    }
}
