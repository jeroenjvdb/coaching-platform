<?php

namespace App\Console\Commands;

use App\Swimmer;
use Illuminate\Console\Command;

class getPersonalBests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'PB:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cache personal bests for all swimmers';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $swimmers = Swimmer::all();

        foreach($swimmers as $swimmer) {
            $swimmer->getPersonalBest();
            $this->info('swimmer added: ' . $swimmer->id);
        }
    }
}
