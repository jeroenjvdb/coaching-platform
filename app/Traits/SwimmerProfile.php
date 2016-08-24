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
     *
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
        $stopwatches = $this->getStopwatches(Carbon::now(), Carbon::now()->subYear());

        $data = [
            'swimmer'       => $this,
            'personalBests' => Cache::get('PB.' . $this->id),
            'stopwatches'   => $stopwatches,
//            'meta'          => $this->getSwimmerMeta($stopwatches),
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
    public function addData($message, $data = null)
    {
        $media = null;
        if ($data['media']) {
            $mediaCollect = [
                'url'  => $this->storeImage($data['media']),
                'type' => 'image',
            ];
            $media = collect($mediaCollect);
        }

        $collecting = [
            'type'     => 'data',
            'message'  => $message,
            'media'    => $media,
            'date'     => date('Y-m-d H:i:s'),
            'response' => false,
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
            'type'     => 'data',
            'message'  => $message,
            'media'    => null,
            'date'     => date('Y-m-d H:i:s'),
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
        if ($data['address']['street']) {
            $this->updateMeta('address', $address);
        }
        if ($data['phone']) {
            $this->updateMeta('phone', $data['phone']);
        }
        foreach ($data['email'] as $email) {
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
        return $this->heartRates()->where('date', '>=', Carbon::today())->exists();
    }

    /**
     * store new heartRate
     *
     * @param $rate
     * @return bool
     */
    public function storeHeartRate($rate)
    {
        $this->heartRates()->create(
            [
                'heart_rate' => $rate,
                'date'       => Carbon::today(),
            ]
        );

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

        if ($start) {
            $hr = $hr->where('date', '>', $start);
        }
        if ($end) {
            $hr = $hr->where('date', '<', $end);
        }

        return $hr->orderBy('date', 'asc')->get();
    }

    /**
     * get all the stopwatches
     *
     * @return mixed
     */
    private function getStopwatches($start, $end)
    {
        $stopwatches = $this->stopwatches()
//            ->where('stopwatches.id', $id)$sta
            ->where('created_at', '>', $start )
            ->where('created_at', '<', $end)
            ->with(
                ['times' => function ($query) {
                    $query->orderedRev();
                },
                    'distance',
                    'distance.stroke',
                ]
            )->get();

        $lastRecord = null;
        foreach ($stopwatches as $stopwatch) {
            $lastTime = 0;
            foreach ($stopwatch->times as $key => $time) {
                if ($lastRecord == $time->time || $time->time == 0) {
                    $stopwatch->times->pull($key);
                } else {
                    $split = $time->time - $lastTime;
                    $time->split = $this->makeFullTime($split);
                    $lastTime = $time->time;
                    $lastRecord = $time->time;
                }
            }
        }

        return $stopwatches;
    }

    private function makeFullTime($input)
    {
        $data = collect([]);

        $data->milliseconds = $input % 1000;
        $data->hundredth = $input % 100;
        $input = floor($input / 1000);

        $data->seconds = $input % 60;
        $input = floor($input / 60);

        $data->minutes = $input % 60;
        $input = floor($input / 60);

        $data->hours = $input % 24;
        $input = floor($input / 24);

        $data->toText = //sprintf('%02d', $data->hours) . ':' .
            sprintf('%02d', $data->minutes) . ':' .
            sprintf('%02d', $data->seconds) . '.' .
            sprintf('%02d', $data->milliseconds / 10);

        $data->arr = str_split($data->toText);

        return $data;
    }

    /**
     * get personal bests from swimrankings
     *
     * @return mixed
     */
    public function getPersonalBest()
    {
        $athleteId = $this->swimrankings_id;

        $url = config('swimrankings.url') . config('swimrankings.swimmersPage') . $athleteId;
        $parameters = [];
        try {
            $res = getCall($url, $parameters);

            $body = $this->extractTable($res);
            $body = removeLinks($body);
            $body = $this->mobileHidden($body);
            $body = $this->removeWidth($body);

            Cache::forever('PB.' . $this->id, $body);

            return $body;
        } catch (\Exception $e) {
            Log::info('couldn\'t connect to url', [$e]);

            return "not found";
        }
    }

    /**
     * extract table from string
     *
     * @param $res
     * @return mixed|string
     */
    private function extractTable($res)
    {
        $pattern = '/<table class="athleteBest"[\s\S]*<\/table>/';
        preg_match($pattern, $res->getBody(), $table);

        $pattern = '/<script[\s\S]*?<\/script>/';
        $body = "not found";
        if(isset($table[0])) {
            $body = preg_replace($pattern, '', $table[0]);
        }

        return $body;
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
            Log::info('couldn\'t connect to url', [$e]);

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

        foreach ($hidden as $column) {
            $records = preg_replace('/class="' . $column . '"/', 'class="' . $column . ' hidden-xs"', $records);
        }

        return $records;
    }

    public function getTheMeta($page)
    {
        $stopwatches = $this->stopwatches();

        return $this->getSwimmerMeta($stopwatches, $page);
    }

    /**
     * get all the meta for this swimmer
     *
     * @param $stopwatches
     * @return \Illuminate\Support\Collection
     */
    private function getSwimmerMeta($stopwatches, $page)
    {
//        $allMeta = $this->getAllMeta();
        $meta = collect([]);

        $heartRate = [];
        $dateArr = [];
        $rateArr = [];

        $startDate = Carbon::now()->subWeeks($page);
        $endDate = Carbon::now()->subWeeks($page - 1);
//        dd($endDate);

//        $allMeta = $allMeta->sortByDesc('date');


        /* $allMeta->each(function($item, $key) use ($meta, $dateArr, $rateArr){
             if(isset($item->type) && $item->type == 'data') {
                 $item->date = Date::createFromFormat('Y-m-d H:i:s',$item->date);
                 $meta->push($item);
             } else if(isset($item->type) && $item->type == 'heartRate') {
                 $item->date = Carbon::createFromFormat('Y-m-d H:i:s',$item->date);
                 $meta->push($item);
             }
         });*/

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
//        dd($this->stopwatches);//()->where('created_at', '>', $startDate)->where('created_at', '<', $endDate)->get());7
//        dd($endDate);
//        dd($this->data()->where('created_at', '>', $startDate)->where('created_at', '<', $endDate)->get());
        foreach ($this->data()->where('created_at', '>', $startDate)->where('created_at', '<=', $endDate)->get() as $data) {
            $media = null;
            if ($data->media_url && $data->media_type) {
                $collecting = [
                    'type' => $data->media_type,
                    'url'  => $data->media_url,
                ];
                $media = collect($collecting);
            }
            $newMeta = [
                'type'     => 'data',
                'message'  => $data->text,
                'user'     => $data->user,
                'media'    => $media,
                'date'     => $data->created_at,
                'response' => $data->is_reaction,
            ];

            $item = (object)$newMeta;
            $meta->push($item);
        }


//        dd($this->heartRates()->where('date', '>', $startDate)->where('date', '<', $endDate)->get());
        foreach ($this->heartRates()->where('date', '>', $startDate)->where('date', '<', $endDate)->get() as $heartRate) {
            $newMeta = [
                'type'     => 'heartRate',
                'message'  => $heartRate->heart_rate,
                'media'    => null,
                'date'     => Carbon::parse($heartRate->date),
                'response' => true,
            ];

            $item = (object)$newMeta;
            $meta->push($item);
        }

//        dd($this->stopwatches()->where('created_at', '>', $startDate)->where('created_at', '<', $endDate)->get());
        foreach ($this->getStopwatches($startDate, $endDate) as $stopwatch) {
            $newMeta = [
                'type'     => 'chrono',
                'message'  => $stopwatch,
                'media'    => null,
                'date'     => Carbon::parse($stopwatch->created_at),
                'response' => false,
            ];

            $item = (object)$newMeta;
            $meta->push($item);
        }

        $meta = $meta->sortByDesc('date');
        $metaGrouped = [];
        $item = null;
        $allItems = null;

        $date = null;
        foreach ($meta as $data) {
            $day = Date::parse($data->date)->startOfDay();
            if($day != $date) {
                $date = $day;
//                $date['asString'] = $day->format('F l');
                if($item) {
                    $item->put('item', $allItems);
                    array_push($metaGrouped, $item);
                }
                $item = collect([]);
                $item->put('date', $date);
                $allItems = [];
            }
            array_push($allItems, $data);
        }
        if($item) {
            $item->put('item', $allItems);
            array_push($metaGrouped, $item);
        }


        return [
            'meta' => $metaGrouped,
            'heartRate' => $heartRate,
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
        $destinationPath = "uploads/data/";
        $extension = $img->getClientOriginalExtension();
        $filename = random_string(50);
        $filename .= "." . $extension;
        //fullpath = path to picture + filename + extension
        $fullPath = $destinationPath . $filename;
        $img->move($destinationPath, $filename);

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

        if ($address) {
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
            'phone'    => $swimmer->getMeta('phone'),
            'email'    => $swimmer->getMeta('email', []),
            'birthday' => $swimmer->getMeta('birthday'),
            'picture'  => $swimmer->getMeta('picture'),
            'address'  => $address,

        ];
    }

    /**
     * @return bool
     */
    public function checkWeights()
    {
        return $this->weights()->where('date', '>=', Carbon::today())->exists();
    }

    /**
     * Get weights between dates
     *
     * @param null $start
     * @param null $end
     * @return mixed
     */
    public function getWeights($start = null, $end = null)
    {
        $weights = $this->weights();
        if ($start) {
            $weights = $weights->where('date', '>=', $start);
        }
        if ($end) {
            $weights = $weights->where('date', '<=', $end);
        }
        $weights = $weights->ordered()->get();


        return $weights;
    }


}