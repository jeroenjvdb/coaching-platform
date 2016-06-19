<?php

namespace App\Http\Controllers\Swimmer;

use App\Classes\SwimmerProfile;
use App\Group;
use App\Http\Requests\ContactRequest;
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
     * @param ContactRequest $request
     * @param Group $group
     * @param Swimmer $swimmer
     * @return string
     */
    public function update(ContactRequest $request, Group $group, Swimmer $swimmer)
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
            ],
            'sEmail' => $request->sEmail,
        ];

        if($request->picture && $request->picture->isValid()) {
            $swimmer->updateMeta('picture', $this->storeImage($request->picture, $group, $swimmer));
            return redirect()->back();
        }

        $swimmer->storeContact($store);
        if($request->email) {
            $swimmer->email = $request->email;
        }

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

    public function updatePicture(Request $request, Group $group, Swimmer $swimmer)
    {
        $image = $request->profilePicture;
        $swimmer->updateMeta('picture', $this->storeImage($image, $group, $swimmer));

        return redirect()->back();
    }

    /**
     * store meta image
     *
     * @param $img
     * @param Group $group
     * @param Swimmer $swimmer
     * @return string
     */
    protected function storeImage($img, Group $group, Swimmer $swimmer)
    {
        $destinationPath   = "uploads/profilePics/" . $group-> slug . '/';
        $extension         = $img->getClientOriginalExtension();
        $filename = $swimmer->slug;
        $filename .= "." . $extension;
        //fullpath = path to picture + filename + extension
        $fullPath          = $destinationPath . $filename;
        $img->move($destinationPath , $filename);

        return '/' . $fullPath;
    }
}
