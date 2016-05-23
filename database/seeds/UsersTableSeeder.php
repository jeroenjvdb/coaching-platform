<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * @var User
     */
    private $user;

    /**
     * UsersTableSeeder constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->user->create([
            'name' => 'Jeroen Van den Broeck',
            'email' => 'jeroen_vdb1@hotmail.com',
            'password' => Hash::make('root'),
            'clearance_level' => 1,
        ]);
    }
}
