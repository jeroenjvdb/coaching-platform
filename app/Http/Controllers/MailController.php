<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function __construct()
    {
    }

    /**
     * show mail view
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Group $group)
    {
        $data = [
            'group' => $group,
        ];

        return view('mail.show', $data);
    }

    /**
     * send mail
     *
     * @param Request $request
     * @param Group $group
     * @return mixed
     */
    public function send(Request $request, Group $group)
    {
        $data = [
            'msg'        => $request->message,
            'subject'    => $request->subject,
            'attachment' => $request->attachment,
        ];

        $email = $this->getMails($request->to, $group);

        $data['to'] = $email;//'jeroen_vdb1@hotmail.com' ;// ;

        Mail::send(
            'mail.mail',
            $data,
            function ($m) use ($data) {
                $m->from('jeroen.vandenbroeck@student.kdg.be', Auth::user()->name . ' - topswim');
                $m->to($data['to'], 'topswim')->subject($data['subject']);
                if ($data['attachment']) {
                    $m->attach($data['attachment'],
                               ['as'     => $data['attachment']->getClientOriginalName(
                               ), 'mime' => $data['attachment']->getMimeType()]
                    );
                }
            }
        );

        return redirect()->back()->withSuccess('mail sent');

    }

    /**
     * get necessary mails
     *
     * @param $data
     * @param $group
     * @return array
     */
    private function getMails($data, $group)
    {
        $email = [];

        if (in_array('coaches', $data)) {
            $coaches = $group->coaches;
            foreach ($coaches as $coach) {
                array_push($email, $coach->user->email);
            }
        }
        if (in_array('swimmers', $data)) {
            $swimmers = $group->swimmers;
            foreach ($swimmers as $swimmer) {
                if ($swimmer->email) {
                    array_push($email, $swimmer->email);
                }
            }
        }
        if (in_array('parents', $data)) {
            $swimmers = $group->swimmers;
            foreach ($swimmers as $swimmer) {
                $pEmails = $swimmer->getMeta('email');
                if ($pEmails) {
                    foreach ($pEmails as $pEmail) {
                        if ($pEmail) {
                            array_push($email, $pEmail);
                        }
                    }
                }
            }
        }

        return $email;
    }
}
