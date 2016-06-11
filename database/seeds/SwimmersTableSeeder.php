<?php

use App\Group;
use App\User;
use Illuminate\Database\Seeder;

class SwimmersTableSeeder extends Seeder
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
     * SwimmersTableSeeder constructor.
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
        $group = $this->group->where('name', 's3')->first();
        $swimmers = $group->swimmers();

        $swimmer = $swimmers->create(
            [
                'first_name'      => 'Philippe',
                'last_name'       => 'Dricot',
                'swimrankings_id' => '4680497',
            ]
        );
        $this->createLogin($swimmer, 'ph.dricot@gmail.com' );


        $swimmer = $swimmers->create(
            [
                'first_name'      => 'Enya',
                'last_name'       => 'Moerbeek',
                'swimrankings_id' => '4524127',
            ]
        );
        $this->createLogin($swimmer, 'enya.moerbeeck@gmail.com' );

        $swimmer = $swimmers->create(
            [
                'first_name'      => 'Frederik',
                'last_name'       => 'Van den Abbeele',
                'swimrankings_id' => '4578968',
            ]
        );
        $this->createLogin($swimmer, 'familie.vandenabbeele@gmail.com' );

        $swimmer = $swimmers->create(
            [
                'first_name'      => 'Stef',
                'last_name'       => 'vaes',
                'swimrankings_id' => '4578964',
            ]
        );
        $this->createLogin($swimmer, 'marcvaes@outlook.com' );

        $swimmer = $swimmers->create(
            [
                'first_name'      => 'Jelle',
                'last_name'       => 'Kruijtzer',
                'swimrankings_id' => '4470604',
            ]
        );
        $this->createLogin($swimmer, 'jellekruijtzer@gmail.com' );

        $swimmer = $swimmers->create(
            [
                'first_name'      => 'Nathalie',
                'last_name'       => 'Verzele',
                'swimrankings_id' => '4805411',
            ]
        );
        $this->createLogin($swimmer, 'nathalie_verzele@hotmail.com' );

        $swimmer = $swimmers->create(
            [
                'first_name'      => 'Magali',
                'last_name'       => 'Buys',
                'swimrankings_id' => '4139684',
            ]
        );
        $this->createLogin($swimmer, 'magali.buys@hotmail.com' );

        /*$swimmer = $swimmers->create(
            [
                'first_name'      => 'Lara',
                'last_name'       => 'Stevens',
                'swimrankings_id' => '4682529',
            ]
        );
        $this->createLogin($swimmer, )*/
        $swimmer = $swimmers->create(
            [
                'first_name'      => 'Yara',
                'last_name'       => 'Bouckaert',
                'swimrankings_id' => '4439390',
            ]
        );
        $this->createLogin($swimmer, 'yara.bouckaert@skynet.be' );
        $swimmer = $swimmers->create(
            [
                'first_name'      => 'Caroline',
                'last_name'       => 'Dricot',
                'swimrankings_id' => '4393257',
            ]
        );
        $this->createLogin($swimmer, 'caroline.dricot@gmail.com' );
        $swimmer = $swimmers->create(
            [
                'first_name'      => 'Karen',
                'last_name'       => 'Cop',
                'swimrankings_id' => '4200198',
            ]
        );
        $this->createLogin($swimmer, 'karencop4a04@hotmail.com' );
        $swimmer = $swimmers->create(
            [
                'first_name'      => 'Andres',
                'last_name'       => 'De jonge',
                'swimrankings_id' => '4816575',
            ]
        );
        $this->createLogin($swimmer, 'andresdejonge@rocketmail.com' );
       /* $swimmer = $swimmers->create(
            [
                'first_name'      => 'Marie',
                'last_name'       => 'Dionysoupoulou',
                'swimrankings_id' => '4921629',
            ]
        );
        $this->createLogin($swimmer, )
        $swimmer = $swimmers->create(
            [
                'first_name'      => 'Robbe',
                'last_name'       => 'De Muynck',
                'swimrankings_id' => '4894194',
            ]
        );
        $this->createLogin($swimmer, )*/

        $swimmer = $swimmers->create(
            [
                'first_name'      => 'Vincent',
                'last_name'       => 'Aluisio',
                'swimrankings_id' => '4524125',
            ]
        );
        $this->createLogin($swimmer, 'aluisiovincent@gmail.com');
    }


    /**
     * create login for new swimmers.
     *
     * @param $swimmer
     * @param $email
     * @return bool
     */
    private function createLogin($swimmer, $email)
    {
        if ( ! $this->user->where('email', $email)->exists()) {
            $user = $this->user->create(
                [
                    'clearance_level' => config('clearance.swimmer'),
                    'email'           => $email,
                    'name'            => $swimmer->first_name . ' ' . $swimmer->last_name,
                    'password'        => 'root',
                ]
            );

            $swimmer->user_id = $user->id;
            $swimmer->save();

            $user->addMeta('swimmer_id', $swimmer->id);
            $token = strtolower(str_random(64));

            DB::table('password_resets')->insert(
                [
                    'email' => $email,
                    'token' => $token,
                ]
            );
//            $this->sendLogin($token, $swimmer, $email);
        }

        return true;
    }

    /**
     * send login link over mail
     *
     * @param $token
     * @param $swimmer
     * @param $email
     * @return bool
     */
    private function sendLogin($token, $swimmer, $email)
    {
        $route = route(
            'password.reset.{token}',
            [
                'token' => $token,
            ]
        );

        Mail::send(
            'emails.reset',
            ['route' => $route, 'swimmer' => $swimmer],
            function ($m) use ($email) {
                $m->from('jeroen.vandenbroeck@student.kdg.be', Auth::user()->name . ' - topswim');
                $m->to($email, 'topswim')->subject('account geregistreerd');
            }
        );

        return true;
    }
}
