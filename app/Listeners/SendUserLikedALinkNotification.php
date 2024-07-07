<?php

namespace App\Listeners;

use App\Events\UserLikedALink;
use App\Mail\UserLikedALinkMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUserLikedALinkNotification
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param UserLikedALink $event
     * @return void
     */
    public function handle(UserLikedALink $event)
    {
        Mail::to($event->link->user)->send(new UserLikedALinkMail($event->link->user, $event->user, $event->link));
    }
}
