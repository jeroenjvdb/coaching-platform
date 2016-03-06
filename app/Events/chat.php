<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class chat extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $data;

    /**
     * chat constructor.
     * @param $msg
     * @param $user
     */
    public function __construct($msg, $user)
    {
        $this->data = [
            'username' => $user,
            'msg' => $msg,
        ];
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['test-channel'];
    }
}
