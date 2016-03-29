<?php

use App\Group;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * @var Group
     */
    private $group;

    /**
     * GroupsTableSeeder constructor.
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
        $this->group->create([
            'name' => 's3',
            'slug' => 's3',
        ]);
    }
}
