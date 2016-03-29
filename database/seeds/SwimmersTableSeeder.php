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
            'profile_id' => 'azer'
        ]);

        $swimmers->create([
            'first_name' => 'Enya',
            'last_name' => 'Moerbeek',
            'profile_id' => 'azer'
        ]);

        $swimmers->create([
            'first_name' => 'Frederik',
            'last_name' => 'Van den Abeele',
            'profile_id' => 'azer'
        ]);

        $swimmers->create([
            'first_name' => 'Stef',
            'last_name' => 'vaes',
            'profile_id' => 'azer'
        ]);

        $swimmers->create([
            'first_name' => 'Jelle',
            'last_name' => 'Kruytzer',
            'profile_id' => 'azer'
        ]);

        $swimmers->create([
            'first_name' => 'Nathalie',
            'last_name' => 'Verzele',
            'profile_id' => 'azer'
        ]);

        $swimmers->create([
            'first_name' => 'Magali',
            'last_name' => 'Buys',
            'profile_id' => 'azer'
        ]);

        $swimmers->create([
            'first_name' => 'Lara',
            'last_name' => 'Stevens',
            'profile_id' => 'azer'
        ]);
        $swimmers->create([
            'first_name' => 'Yara',
            'last_name' => 'Bouckaert',
            'profile_id' => 'azer'
        ]);
        $swimmers->create([
            'first_name' => 'Caroline',
            'last_name' => 'Dricot',
            'profile_id' => 'azer'
        ]);
        $swimmers->create([
            'first_name' => 'Karen',
            'last_name' => 'Cop',
            'profile_id' => 'azer'
        ]);
        $swimmers->create([
            'first_name' => 'Andres',
            'last_name' => 'De jonge',
            'profile_id' => 'azer'
        ]);
        $swimmers->create([
            'first_name' => 'Marie',
            'last_name' => 'Dionysoupoulou',
            'profile_id' => 'azer'
        ]);
        $swimmers->create([
            'first_name' => 'Robbe',
            'last_name' => 'DeMuynck',
            'profile_id' => 'azer'
        ]);
    }
}
