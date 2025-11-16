<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class NotificationChallenge extends Notification 
{
    protected $c;

    public function __construct($c)
    {
        $this->c = $c;
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'you have new message!',
            'claim_id' => $this->c->id,
            'user_one_id' => $this->c->user_one_id,
        ];
    }
}
