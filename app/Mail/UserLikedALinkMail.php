<?php

namespace App\Mail;

use App\Models\Link;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserLikedALinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $author;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $author, User $userThatLiked, Link $link)
    {
        $this->author = $author;
        $this->userThatLiked = $userThatLiked;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.user_liked_a_link')
            ->with([
                'authorName' => $this->author->name,
                'linkTitle' => $this->link->title,
            ]);
    }
}
