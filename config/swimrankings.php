<?php

return [
    'url' => 'http://www.swimrankings.net/',

    'swimmersPage' => 'index.php?&points=rudolph_2016&page=athleteDetail&language=nl&athleteId=',
    'pdf'          => 'services/AthletePBestPdf/pbest.pdf?Language=nl&AthleteId=',

    'courses' => [
        'crawl'    => [
            '50'   => '50m vrije slag',
            '100'  => '100m vrije slag',
            '200'  => '200m vrije slag',
            '400'  => '400m vrije slag',
            '800'  => '800m vrije slag',
            '1500' => '1500m vrije slag',
        ],
        'rug'   => [
            '50'  => '50m rugslag',
            '100' => '100m rugslag',
            '200' => '200m rugslag',
        ],
        'schoolslag' => [
            '50'  => '50m schoolslag',
            '100' => '100m schoolslag',
            '200' => '200m schoolslag',
        ],
        'vlinder'    => [
            '50'  => '50m vlinderslag',
            '100' => '100m vlinderslag',
            '200' => '200m vlinderslag',
        ],
        'wissel'       => [
            '100' => '100m wisselslag',
            '200' => '200m wisselslag',
            '400' => '400m wisselslag',
        ],
    ],

];