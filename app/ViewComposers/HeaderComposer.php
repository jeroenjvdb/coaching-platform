<?php namespace App\Http\ViewComposers;

use App\Swimmer;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Users\Repository as UserRepository;

class HeaderComposer {

    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $users;
    /**
     * @var Swimmer
     */
    private $swimmer;

    /**
     * Create a new profile composer.
     *
     * @param Swimmer $swimmer
     * @internal param UserRepository $users
     */
    public function __construct(Swimmer $swimmer)
    {
        // Dependencies automatically resolved by service container...
        $this->user = Auth::user();
        $this->swimmer = $swimmer;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if($this->user->coach) {
            $view->with('authUser', $this->user)->with('groups', $this->user->coach->groups);
        } else {
            $swimmer_id = $this->user->getMeta('swimmer_id');
            $swimmer = $this->swimmer->find($swimmer_id);
//            dd($swimmer->group);
            $view->with('authUser', $this->user)->with('groups', collect([$swimmer->group]));
        }
    }

}