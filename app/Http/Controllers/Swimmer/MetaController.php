<?php

namespace App\Http\Controllers\Swimmer;

use App\Group;
use App\Swimmer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MetaController extends Controller
{
    /**
     * @var Group
     */
    private $group;
    /**
     * @var Swimmer
     */
    private $swimmer;

    public function __construct(Group $group, Swimmer $swimmer)
    {
        $this->group = $group;
        $this->swimmer = $swimmer;
    }

    public function index(Swimmer $swimmer)
    {
        dd($swimmer->getAllMeta());
    }

    public function create()
    {

    }

    /**
     * store meta for swimmer
     *
     * @param Request $request
     * @param Group $group
     * @param Swimmer $swimmer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Group $group, Swimmer $swimmer)
    {
//        dd($request->all());
        $media_type = null;
        $media_url = null;
        if (isset($request->media)) {
            $media_type = 'img';

            if ($request->media->getMimeType() == 'video/mp4') {
                $media_type = 'vid';
            }
            $media_url = $this->storeImage($request->media);
        }

//        $collecting = [
//            'type'     => 'data',
//            'message'  => $request->message,
//            'media'    => $media,
//            'date'     => date('Y-m-d H:i:s'),
//            'response' => false,
//        ];

//        $collection = collect($collecting);

        $swimmer->data()->create(
            [
                'text'        => $request->message,
                'media_type'  => $media_type,
                'media_url'   => $media_url,
                'user_id'     => Auth::user()->id,
                'is_reaction' => false,
            ]
        );

//        $swimmer->addMeta(date("Y-m-d H:i:s"), $collection);

        return redirect()->route(
            '{group}.swimmer.show',
            [
                'group'   => $group->slug,
                'swimmer' => $swimmer->slug,
            ]
        );
    }

    public
    function show()
    {

    }

    public
    function edit()
    {

    }

    public
    function update(
        Request $request
    ) {

    }

    public
    function destroy(
        Request $request
    ) {

    }

    /**
     * store meta image
     *
     * @param $img
     * @return string
     */
    protected
    function storeImage(
        $img
    ) {
        $destinationPath = "uploads/data/";
        $extension = $img->getClientOriginalExtension();
        $filename = random_string(50);
        $filename .= "." . $extension;
        //fullpath = path to picture + filename + extension
        $fullPath = $destinationPath . $filename;
        $img->move($destinationPath, $filename);

        return '/' . $fullPath;
    }
}
