<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Reaction;
use App\Models\User;
use App\Notifications\SendNotifReaction;

class sendReactionNot implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;
    public $r;

    /**
     * Create a new job instance.
     */
    public function __construct($r)
    {
        $this->r = $r;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $re = Reaction::findOrFail($this->r);
        $u = $re->claim;
        $user = User::findOrFail($u->user_id);
        $user->notify(new SendNotifReaction($re));
        \Log::info($user);
    }
}
