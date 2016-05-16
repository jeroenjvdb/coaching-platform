<?php

use App\Group;
use Illuminate\Database\Seeder;

class SwimmersTableSeeder extends Seeder
{
    /**
     * @var Group
     */
    private $group;

    /**
     * SwimmersTableSeeder constructor.
     * @param Group $group
     */
    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group = $this->group->where('name', 's3')->first();
        $swimmers = $group->swimmers();

        $swimmers->create([
            'first_name' => 'Philippe',
            'last_name' => 'Dricot',
            'swimrankings_id' => '4680497'
        ]);

        $swimmers->create([
            'first_name' => 'Enya',
            'last_name' => 'Moerbeek',
            'swimrankings_id' => '4524127',
        ]);

        $swimmers->create([
            'first_name' => 'Frederik',
            'last_name' => 'Van den Abbeele',
            'swimrankings_id' => '4578968',
        ]);

        $swimmers->create([
            'first_name' => 'Stef',
            'last_name' => 'vaes',
            'swimrankings_id' => '4578964',
        ]);

        $swimmers->create([
            'first_name' => 'Jelle',
            'last_name' => 'Kruijtzer',
            'swimrankings_id' => '4470604',
        ]);

        $swimmers->create([
            'first_name' => 'Nathalie',
            'last_name' => 'Verzele',
            'swimrankings_id' => '4805411',
        ]);

        $swimmers->create([
            'first_name' => 'Magali',
            'last_name' => 'Buys',
            'swimrankings_id' => '4139684',
        ]);

        $swimmers->create([
            'first_name' => 'Lara',
            'last_name' => 'Stevens',
            'swimrankings_id' => '4682529',
        ]);
        $swimmers->create([
            'first_name' => 'Yara',
            'last_name' => 'Bouckaert',
            'swimrankings_id' => '4439390',
        ]);
        $swimmers->create([
            'first_name' => 'Caroline',
            'last_name' => 'Dricot',
            'swimrankings_id' => '4393257',
        ]);
        $swimmers->create([
            'first_name' => 'Karen',
            'last_name' => 'Cop',
            'swimrankings_id' => '4200198',
        ]);
        $swimmers->create([
            'first_name' => 'Andres',
            'last_name' => 'De jonge',
            'swimrankings_id' => '4816575',
        ]);
        $swimmers->create([
            'first_name' => 'Marie',
            'last_name' => 'Dionysoupoulou',
            'swimrankings_id' => '4921629',
        ]);
        $swimmers->create([
            'first_name' => 'Robbe',
            'last_name' => 'De Muynck',
            'swimrankings_id' => '4894194',
        ]);

        $swimmers->create([
            'first_name' => 'Vincent',
            'last_name' => 'Aluisio',
            'swimrankings_id' => '4524125',
        ]);
    }
}
