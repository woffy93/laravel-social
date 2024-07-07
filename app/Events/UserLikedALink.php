<?php

namespace App\Events;

use App\Models\Link;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLikedALink
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $link;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Link $link)
    {
        $this->user = $user;
        $this->link = $link;
    }
}
