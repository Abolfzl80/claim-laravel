<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class SendNotifReaction extends Notification 
{
    protected $r;

    public function __construct($r)
    {
        $this->r = $r;
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'you have new Reactionnn!',
            'from user_id' => $this->r->user_id,
        ];
    }
}
