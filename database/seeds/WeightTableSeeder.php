<?php

use App\Swimmer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WeightTableSeeder extends Seeder
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
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->swimmer->all() as $swimmer) {
            $date = Carbon::today();
            $date->month = 5;
            $date->day = 1;
            for($i = 0; $i < 40; $i++) {
                $swimmer->weights()->create([
                                                   'date' => $date,
                                                   'weight' => rand(65000, 67000) / 1000,
                                               ]);

                $date->addDay();
            }
        }

    }
}