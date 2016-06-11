<?php

use App\Group;
use App\User;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * @var Group
     */
    private $group;
    /**
     * @var User
     */
    private $user;

    /**
     * GroupsTableSeeder constructor.
     *
     * @param Group $group
     * @param User $user
     */
    public function __construct(Group $group, User $user)
    {
        $this->group = $group;
        $this->user = $user;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group = $this->group->create([
            'name' => 's3',
            'slug' => 's3',
        ]);

        $coach = $this->user->first()->coach()->create([
            'first_name' => 'jeroen',
            'last_name' => 'van den broeck'
        ]);

        $group->coaches()->attach($coach->id);
    }
}
