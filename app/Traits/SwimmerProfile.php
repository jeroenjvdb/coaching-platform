<?php

namespace App\Traits;

use App\Swimmer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Date\Date;

trait SwimmerProfile
{
    /**
     * @var Swimmer
     */
    private $swimmer;

    /**
     * SwimmerProfile constructor.
     * @param Swimmer $swimmer
     */
//    public function __construct(Swimmer $swimmer)
//    {
//        $this->swimmer = $swimmer;
//    }

    /**
     * @return array
     */
    public function get()
    {
        $stopwatches = $this->getStopwatches();

        $data = [
            'swimmer'       => $this,
            'personalBests' => Cache::get('PB.' . $this->id),
            'stopwatches'   => $stopwatches,
            'meta'          => $this->getSwimmerMeta($stopwatches),
            'contact'       => $this->contact(),
            'hasHeartRate'  => $this->checkHeartRate(),
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
            $mediaCollect = [
                'url' => $this->storeImage($data['media']),
                'type' => 'image'
            ];
            $media = collect($mediaCollect);
        }

        $collecting = [
            'type'      => 'data',
            'message'   => $message,
            'media'     => $media,
            'date'      => date('Y-m-d H:i:s'),
            'response'  => false,
        ];

        $collection = collect($collecting);
        $this->addMeta(date("Y-m-d H:i:s"), $collection);

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

        $this->addMeta(date("Y-m-d H:i:s"), $collection);

        return true;
    }

    /**
     * save contact data
     *
     * @param $data
     * @return bool
     */
    public function storeContact($data)
    {
        $address = collect($data['address']);
        if($data['address']['street']) {
            $this->updateMeta('address', $address);
        }
        if($data['phone']) {
            $this->updateMeta('phone', $data['phone']);
        }
        foreach($data['email'] as $email) {
            $this->appendMeta('email', $email);
        }

        return true;
    }

    /**
     * check if a heartrate is filled in
     *
     * @return bool
     */
    public function checkHeartRate()
    {
        return $this->heartRates()->where('created_at', '>', Carbon::today())->exists();;
    }

    /**
     * store new heartRate
     *
     * @param $rate
     * @return bool
     */
    public function storeHeartRate($rate)
    {
        $this->heartRates()->create([
            'heart_rate' => $rate,
        ]);

        return true;

    }

    /**
     * get the heartRates
     *
     * @param null $start
     * @param null $end
     * @return mixed
     */
    public function getHeartRates($start = null, $end = null)
    {
        $hr = $this->heartRates();

        if($start) {
            $hr = $hr->where('created_at', '>', $start);
        }
        if( $end ){
            $hr = $hr->where('created_at', '<', $end);
        }

        return $hr->orderBy('created_at', 'asc')->get();
    }

    /**
     * get all the stopwatches
     *
     * @return mixed
     */
    private function getStopwatches()
    {
        $stopwatches = $this->stopwatches()
//            ->where('stopwatches.id', $id)
            ->with(['times' => function($query){
                    $query->orderedRev();
                },
                'distance',
                'distance.stroke',
            ])->get();

        $lastRecord = null;
        foreach($stopwatches as $stopwatch) {
            foreach ($stopwatch->times as $key => $time) {
                if ($lastRecord == $time->time) {
                    $stopwatch->times->pull($key);
                } else {
                    $lastRecord = $time->time;

                }
            }
        }

        return $stopwatches;
    }

    /**
     * get personal bests from swimrankings
     *
     * @return mixed
     */
    public function getPersonalBest()
    {
        Log::warning('cache');
        $athleteId = $this->swimrankings_id;

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

            $body = removeLinks($body);
            $body = $this->mobileHidden($body);
            $body = $this->removeWidth($body);

            $expiresAt = Carbon::now()->addDays(31);

            Cache::forever('PB.' . $this->id, $body, $expiresAt);

            return $body;
        } catch (\Exception $e) {
            Log::info('couldn\'t connect to url', [ $e ] );

            return "not found";
        }
    }

    public function seedPDF()
    {
        $athleteId = $this->swimrankings_id;
        $group = $this->group->slug;

        $filename = $group . '/bestTimes/' . $this->slug . '.pdf';

        $url = config('swimrankings.url') . config('swimrankings.pdf') . $athleteId;
        $parameters = [];
        try {
//            $res = getCall($url, $parameters);

            $file = file_get_contents($url);
            Storage::put($filename, $file);

            return true;
//            return $body;
        } catch (\Exception $e) {
            Log::info('couldn\'t connect to url', [ $e ] );

            return "not found";
        }
    }

    /**
     * remove width of table
     *
     * @param $records
     * @return mixed
     */
    private function removeWidth($records)
    {
        return preg_replace('/width="[\s\S]*?"/', '', $records);
    }

    /**
     * hide columns on mobile view
     *
     * @param $records
     * @return mixed
     */
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
    private function getSwimmerMeta($stopwatches)
    {
        $allMeta = $this->getAllMeta();
        $meta = collect([]);

        $heartRate = [];
        $dateArr = [];
        $rateArr = [];

        $allMeta = $allMeta->sortByDesc('date');

        $allMeta->each(function($item, $key) use ($meta, $dateArr, $rateArr){
            if(isset($item->type) && $item->type == 'data') {
                $item->date = Date::createFromFormat('Y-m-d H:i:s',$item->date);
                $meta->push($item);
            } else if(isset($item->type) && $item->type == 'heartRate') {
                $item->date = Carbon::createFromFormat('Y-m-d H:i:s',$item->date);
                $meta->push($item);
            }
        });

//        foreach($allMeta as $key => $item) {
//            if(isset($item->type) && $item->type == 'heartRate') {
//                array_push($dateArr, $item->date);
//                array_push($rateArr, $item->message);
//                $hr = collect([
//                    'x' => $item->date,
//                    'y' => $item->message,
//                ]);
//                array_push($heartRate, $hr);
//            }
//        }

        foreach($this->heartRates as $heartRate) {
            $newMeta = [
                'type' => 'heartRate',
                'message' => $heartRate->heart_rate,
                'media' => null,
                'date' => Date::parse($heartRate->created_at),
                'response' => true,
            ];

            $item = (object)$newMeta;
            $meta->push($item);
        }

        foreach($stopwatches as $stopwatch) {
            $newMeta = [
                'type' => 'chrono',
                'message' => $stopwatch,
                'media' => null,
                'date' => Date::parse($stopwatch->created_at),
                'response' => false,
            ];

            $item = (object)$newMeta;
            $meta->push($item);
        }

        return [
            'meta' =>$meta->sortByDesc('date'),
            'heartRate' => $heartRate
        ];
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
        $swimmer = $this;

        $address = $swimmer->getMeta('address');
        $addressText = null;

        if($address) {
            $address->street = htmlentities($address->street);
            $address->number = htmlentities($address->number);
            $address->city = htmlentities($address->city);
            $address->zipcode = htmlentities($address->zipcode);

            $toString = $address->street . ' ' . $address->number . ',<br>' .
                $address->zipcode . ' ' . $address->city;
            $address->toString = $toString;
        } else {
            /*$address = collect([
                'street' => "",
                'number' => "",
                'city' => "",
                'zipcode' => "",
                'toString' => "",
            ]);*/
            $address = collect([]);
            $address->street = null;//htmlentities($address->street);
            $address->number = null;//htmlentities($address->number);
            $address->city = null;//htmlentities($address->city);
            $address->zipcode = null;//htmlentities($address->zipcode);

//            $toString = $address->street . ' ' . $address->number . ',<br>' .
//                $address->zipcode . ' ' . $address->city;
            $address->toString = null;//$toString;
        }

        return [
            'phone'     => $swimmer->getMeta('phone'),
            'email'     => $swimmer->getMeta('email', []),
            'birthday'  => $swimmer->getMeta('birthday'),
            'picture'   => $swimmer->getMeta('picture'),
            'address'   => $address,

        ];
    }
}