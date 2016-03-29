<?php

use App\Stroke;
use Illuminate\Database\Seeder;

class StrokesTableSeeder extends Seeder
{
    /**
     * @var Stroke
     */
    private $stroke;

    public function __construct(Stroke $stroke)
    {
        $this->stroke = $stroke;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->stroke->create([
            'name' => 'crawl',
        ]);

        $this->stroke->create([
            'name' => 'vlinder',
        ]);

        $this->stroke->create([
            'name' => 'rug',
        ]);

        $this->stroke->create([
            'name' => 'schoolslag',
        ]);

        $this->stroke->create([
            'name' => 'wisselslag',
        ]);
    }
}
