<?php

namespace App\Notifications;

use App\Event;
use App\Http\Resources\Event as EventResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventFunded extends Notification
{
    use Queueable;

    /**
     * @var Event
     */
    private Event $event;

    /**
     * Create a new notification instance.
     *
     * @param Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        return $notifiable->notification_preference;

    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
                    ->line('Event "' . $this->event->name . '" is funded!')
                    ->action('Go to Event', url('/events/' . $this->event->id ))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'text' => "Event " . $this->event->name . " just got funded!",
            'redirect_url' => '/events/' . $this->event->id
        ];
    }
}
