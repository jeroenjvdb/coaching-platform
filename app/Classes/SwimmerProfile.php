<?php

namespace App\Classes;

use App\Swimmer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SwimmerProfile
{
    /**
     * @var Swimmer
     */
    private $swimmer;

    /**
     * SwimmerProfile constructor.
     * @param Swimmer $swimmer
     */
    public function __construct(Swimmer $swimmer)
    {
        $this->swimmer = $swimmer;
    }

    /**
     * @return array
     */
    public function get()
    {
        $swimmer = $this->swimmer;

        $stopwatches = $swimmer->stopwatches()
            ->orderBy('created_at', 'desc')
            ->with('distance', 'distance.stroke')
            ->get();

        $personalBests = $this->getPersonalBest($swimmer->swimrankings_id);
        $personalBests = removeLinks($personalBests);
        $personalBests = $this->mobileHidden($personalBests);
        $personalBests = $this->removeWidth($personalBests);

//        $personalBests = "not found";

        $data = [
            'swimmer'       => $swimmer,
            'personalBests' => $personalBests,
            'stopwatches'   => $stopwatches,
            'meta'          => $this->getMeta($stopwatches),
            'contact'       => $this->contact(),
        ];

        return $data;
    }

    /**
     * add data to a swimmers profile
     *
     * @param $message
     * @param null $data
     * @return bool
     */
    public function addData($message,  $data = null)
    {
        $media = null;
        if($data['media']) {
            $media = $this->storeImage($data['media']);
        }

        $collecting = [
            'type'      => 'data',
            'message'   => $message,
            'media'     => $media,
            'date'      => date('Y-m-d H:i:s'),
            'response'  => false,
        ];

        $collection = collect($collecting);
        $this->swimmer->addMeta(date("Y-m-d H:i:s"), $collection);

        return true;
    }

    /**
     * add a reaction on your own profile
     *
     * @param $message
     * @return bool
     */
    public function reaction($message)
    {
        $collecting = [
            'type' => 'data',
            'message' => $message,
            'media' => null,
            'date' => date('Y-m-d H:i:s'),
            'response' => true,
        ];

        $collection = collect($collecting);

        $this->swimmer->addMeta(date("Y-m-d H:i:s"), $collection);

        return true;
    }

    /**
     * get personal bests from swimrankings
     *
     * @param $athleteId
     * @return mixed
     */
    private function getPersonalBest($athleteId)
    {
        $url = config('swimrankings.url') . config('swimrankings.swimmersPage') . $athleteId;
        $parameters = [];
        try {
            $res = getCall($url, $parameters);

            $pattern = '/<table class="athleteBest"[\s\S]*<\/table>/';
            preg_match($pattern, $res->getBody(), $table);

            $pattern = '/<script[\s\S]*?<\/script>/';
            $body = "not found";
            if(isset($table[0])) {
                $body = preg_replace($pattern, '', $table[0]);
            }

            return $body;
        } catch (\Exception $e) {
            Log::info('couldn\'t connect to url', [ $e ] );

            return "not found";
        }
    }

    private function removeWidth($records)
    {
        return preg_replace('/width="[\s\S]*?"/', '', $records);
    }

    private function mobileHidden($records)
    {
        $hidden = [
            'code',
            'date',
            'city',
            'name',
        ];

        foreach($hidden as $column)
        {
            $records = preg_replace('/class="' . $column . '"/', 'class="' . $column . ' hidden-xs"', $records);
        }

        return $records;
    }

    /**
     * get all the meta for this swimmer
     *
     * @param $stopwatches
     * @return \Illuminate\Support\Collection
     */
    private function getMeta($stopwatches)
    {
        $allMeta = $this->swimmer->getAllMeta();
        $meta = collect([]);

        $allMeta->each(function($item, $key) use ($meta){
            if(isset($item->type) && $item->type = 'data') {
                $item->date = Carbon::createFromFormat('Y-m-d H:i:s',$item->date);
                $meta->push($item);
            }
        });
        foreach($stopwatches as $stopwatch) {
            $newMeta = [
                'type' => 'chrono',
                'message' => $stopwatch,
                'media' => null,
                'date' => $stopwatch->created_at,
                'response' => false,
            ];

            $item = (object)$newMeta;

            /*collect([
            'type' => 'chrono',
            'message' => $stopwatch,
            'media' => null,
            'date' => $stopwatch->created_at,
        ]);*/

            $meta->push($item);
        }

        return $meta->sortByDesc('date');
    }

    /**
     * store image for data
     *
     * @param $img
     * @return string
     */
    private function storeImage($img)
    {
        $destinationPath    = "uploads/data/";
        $extension          = $img->getClientOriginalExtension();
        $filename           = random_string(50);
        $filename          .= "." . $extension;
        //fullpath = path to picture + filename + extension
        $fullPath           = $destinationPath . $filename;
        $img->move($destinationPath , $filename);

        return '/' . $fullPath;
    }

    /**
     * get contact info
     *
     * @return array
     */
    private function contact()
    {
        $swimmer = $this->swimmer;

        $address = $swimmer->getMeta('address');
        $addressText = null;
//        dd($address);
//        if($address) {
//            $addressText = $address->street . ' ' . $address->number . ',' .
//                $address->zipcode . ' ' . $address->city;
//        }

        return [
            'phone'     => $swimmer->getMeta('phone'),
            'email'     => $swimmer->getMeta('email', []),
            'birthday'  => $swimmer->getMeta('birthday'),
            'picture'   => $swimmer->getMeta('picture'),
            'address'   => $swimmer->getMeta('address'),

        ];
    }
}