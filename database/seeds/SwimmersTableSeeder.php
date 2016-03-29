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
            'name' => 'Philippe Dricot',
            'profile_id' => 'azer'
        ]);

        $swimmers->create([
            'name' => 'Enya Moerbeek',
            'profile_id' => 'azer'
        ]);

        $swimmers->create([
            'name' => 'Frederik Van den Abeele',
            'profile_id' => 'azer'
        ]);

        $swimmers->create([
            'name' => 'Stef vaes',
            'profile_id' => 'azer'
        ]);

        $swimmers->create([
            'name' => 'Jelle Kruytzer',
            'profile_id' => 'azer'
        ]);

        $swimmers->create([
            'name' => 'Nathalie Verzele',
            'profile_id' => 'azer'
        ]);

        $swimmers->create([
            'name' => 'Magali Buys',
            'profile_id' => 'azer'
        ]);

        $swimmers->create([
            'name' => 'Lara Stevens',
            'profile_id' => 'azer'
        ]);
        $swimmers->create([
            'name' => 'Yara Bouckaert',
            'profile_id' => 'azer'
        ]);
        $swimmers->create([
            'name' => 'Caroline Dricot',
            'profile_id' => 'azer'
        ]);
        $swimmers->create([
            'name' => 'Karen Cop',
            'profile_id' => 'azer'
        ]);
        $swimmers->create([
            'name' => 'Andres De jonge',
            'profile_id' => 'azer'
        ]);
        $swimmers->create([
            'name' => 'Marie Dionysoupoulou',
            'profile_id' => 'azer'
        ]);
    }
}
