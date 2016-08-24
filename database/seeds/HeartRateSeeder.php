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
            $date->month = 7;
            $date->day = 1;
            for($i = 0; $i < 40; $i++) {
                $swimmer->heartRates()->create([
                    'date' => $date,
                    'heart_rate' => rand(55, 60),
                                            ]);

                $date->addDay();
            }
        }
    }
}
