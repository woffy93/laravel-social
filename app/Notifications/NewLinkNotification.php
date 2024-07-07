<?php

namespace App\Notifications;

use App\Models\Link;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLinkNotification extends Notification
{
    use Queueable;

    protected $link;
    protected $authorName;

    public function __construct(Link $link, $authorName)
    {
        $this->link = $link;
        $this->authorName = $authorName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->line('Hello ' . $notifiable->name . ',')
        ->line('A new link has been created by ' . $this->authorName . '.')
        ->action('View Link', url('/links/' . $this->link->id))
        ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
