<?php

use App\Swimmer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class HeartRateSeeder extends Seeder
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
            $date->month = 8;
            $date->day = 15;
            for($i = 0; $i < 7; $i++) {
                $swimmer->heartRates()->create([
                    'date' => $date,
                    'heart_rate' => rand(55, 60),
                                            ]);

                $date->addDay();
            }
        }
    }
}
