<?php

use App\Stroke;
use Illuminate\Database\Seeder;

class DistancesTableSeeder extends Seeder
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
        $strokes = [
            'crawl',
            'schoolslag',
            'rug',
            'vlinder',
            'wisselslag',
        ];

        foreach ($strokes as $stroke) {
            if ($stroke != 'wisselslag') {
                $this->stroke
                    ->where('name', $stroke)
                    ->first()
                    ->distances()->create([
                    'distance' => 50,
                ]);
            }

            $this->stroke
                ->where('name', $stroke)
                ->first()->distances()->create([
                'distance' => 100,
            ]);

            $this->stroke
                ->where('name', $stroke)
                ->first()->distances()->create([
                'distance' => 200,
            ]);

            if ($stroke == 'crawl' || $stroke == 'wisselslag') {
                $this->stroke
                    ->where('name', $stroke)
                    ->first()->distances()->create([
                        'distance' => 400,
                    ]);
            }
            if( $stroke == 'crawl' ) {
                $this->stroke
                    ->where('name', $stroke)
                    ->first()->distances()->create([
                    'distance' => 800,
                ]);

                $this->stroke
                    ->where('name', $stroke)
                    ->first()->distances()->create([
                    'distance' => 1500,
                ]);
            }

        }
    }
}
