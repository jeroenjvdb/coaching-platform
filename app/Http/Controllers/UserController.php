<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @var User;
     */
    private $authUser;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->authUser = Auth::user();
    }

    public function getUpdatePassword()
    {
        return view('auth.passwords.update');
    }

    public function postUpdatePassword(PasswordRequest $request)
    {
        if(!Hash::check($request->old_password, $this->authUser->password)) {
            return redirect()->back()->withInput()->withErrors([
                'wachtwoord incorrect',
            ]);
        }

        $this->authUser->password = $request->new_password;
        $this->authUser->save();

        return redirect('/')->withSuccess('password changed');
    }
}
